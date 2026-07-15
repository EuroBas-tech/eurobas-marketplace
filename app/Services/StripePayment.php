<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use Stripe\Stripe;
use App\Model\Setting;
use App\Model\AdminWallet;
use App\Model\AdminWalletAction;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StripePayment
{     
    public function __construct()     
    {
        $stripe_credentials = $this->getStripeCredentials(); 
        Stripe::setApiKey($stripe_credentials['api_key']);
    }

    protected function getStripeCredentials()
    {
        $stripe = Setting::where('key_name', 'stripe')->first();

        if (!$stripe) {
            throw new \Exception("Stripe configuration not found.");
        }

        $values = $stripe->{$stripe->mode . '_values'};

        return $values;
    }

    /**
     * Create Stripe Checkout Session with all European payment methods
     */
    public function pay($model, $returnUrl = null, $cancelUrl = null)
    {
        try {
            // Default to the web session-based callbacks; callers (e.g. the mobile
            // API) may pass self-contained URLs that do not depend on a web session.
            // Stripe needs the {CHECKOUT_SESSION_ID} placeholder on the success URL.
            if ($returnUrl) {
                $successUrl = $returnUrl . (parse_url($returnUrl, PHP_URL_QUERY) ? '&' : '?') . 'session_id={CHECKOUT_SESSION_ID}';
            } else {
                $successUrl = route('payment.success', ['method' => 'stripe', 'sponsor_id' => $model->id]) . '?session_id={CHECKOUT_SESSION_ID}';
            }
            $cancelUrl = $cancelUrl ?: route('payment.cancel', ['method' => 'stripe', 'sponsor_id' => $model->id]);

            $session = Session::create([
                'payment_method_types' => [
                    'card',           // Credit & Debit Cards (Visa, Mastercard, Amex, etc.) + Apple Pay + Google Pay
                    'ideal',          // iDEAL (Netherlands)
                    'giropay',        // Giropay (Germany)
                ],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'EUR',
                        'product_data' => [
                            'name' => "Sponsored Ad #{$model->id}",
                        ],
                        'unit_amount' => intval($model->price * 100), // Stripe uses cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                
                // Enable Apple Pay and Google Pay (they appear automatically for supported devices)
                'payment_method_options' => [
                    'card' => [
                        'request_three_d_secure' => 'automatic',
                    ]
                ],
                
                // Allow promotion codes/coupons (optional)
                'allow_promotion_codes' => false,
                
                // Set locale for better UX (optional - Stripe auto-detects)
                // 'locale' => 'auto',
            ]);

            Log::info('Stripe session created successfully', [
                'sponsor_id' => $model->id,
                'session_id' => $session->id,
                'amount' => $model->price,
                'currency' => 'EUR'
            ]);

            return $session->url;
        } catch (Exception $e) {
            Log::error('Stripe Create Payment Error: ' . $e->getMessage(), [
                'exception_class' => get_class($e),
                'trace' => $e->getTraceAsString(),
            ]);
            throw new Exception('Unable to process Stripe payment. Please try again later.');
        }
    }      

    /**
     * Verify Stripe Session and complete payment
     */
    public function executePayment($sessionId, $model)
    {
        try {
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $model->update([
                    'is_paid' => 1,
                    'payment_transaction_id' => $session->payment_intent,
                ]);

                // Record in accounting
                $this->recordToAccounting($model, $session->payment_intent, 'stripe');

                Log::info('Stripe payment completed successfully', [
                    'sponsor_id' => $model->id,
                    'transaction_id' => $session->payment_intent,
                ]);

                return true;
            } else {
                Log::error('Stripe payment not approved', [
                    'status' => $session->payment_status,
                    'sponsor_id' => $model->id
                ]);
                return false;
            }
        } catch (Exception $ex) {
            Log::error('Stripe Execute Payment Error: ' . $ex->getMessage(), [
                'exception_class' => get_class($ex),
                'trace' => $ex->getTraceAsString(),
                'sponsor_id' => $model->id,
                'session_id' => $sessionId
            ]);
            return false;
        }
    }

    protected function recordToAccounting($model, $transactionId, $gateway)
    {
        try {
            $grossAmount = (float) $model->price;
            if ($grossAmount <= 0) return;

            // Stripe fee: EU 1.5% + €0.25
            $gatewayFee = round(($grossAmount * 0.015) + 0.25, 2);
            $netAmount  = round($grossAmount - $gatewayFee, 2);

            $euVatRates = [
                'AT'=>20,'BE'=>21,'BG'=>20,'CY'=>19,'CZ'=>21,
                'DE'=>19,'DK'=>25,'EE'=>22,'ES'=>21,'FI'=>24,
                'FR'=>20,'GR'=>24,'HR'=>25,'HU'=>27,'IE'=>23,
                'IT'=>22,'LT'=>21,'LU'=>17,'LV'=>21,'MT'=>18,
                'NL'=>21,'PL'=>23,'PT'=>23,'RO'=>19,'SE'=>25,
                'SI'=>22,'SK'=>20,
            ];

            $userCountry = '';
            if (isset($model->ad) && $model->ad && isset($model->ad->user) && $model->ad->user) {
                $userCountry = strtoupper($model->ad->user->country ?? '');
            }

            $isEu      = array_key_exists($userCountry, $euVatRates);
            $vatRate   = $isEu ? $euVatRates[$userCountry] : 0;
            $vatAmount = $isEu ? round($grossAmount * ($vatRate / 100), 2) : 0;
            $packageType = $model->type ?? class_basename($model);

            $adminWallet = \App\Model\AdminWallet::where('admin_id', 1)->first();
            if (!$adminWallet) {
                $walletId = \Illuminate\Support\Facades\DB::table('admin_wallets')->insertGetId([
                    'admin_id'=>1,'withdrawn'=>0,'commission_earned'=>0,
                    'delivery_charge_earned'=>0,'pending_amount'=>0,
                    'total_earning'=>0,'collected_cash'=>0,
                    'total_tax_collected'=>0,
                    'created_at'=>now(),'updated_at'=>now(),
                ]);
            } else {
                $walletId = $adminWallet->id;
            }

            \Illuminate\Support\Facades\DB::table('admin_wallets')->where('admin_id',1)->update([
                'commission_earned'   => \Illuminate\Support\Facades\DB::raw("commission_earned + {$netAmount}"),
                'collected_cash'      => \Illuminate\Support\Facades\DB::raw("collected_cash + {$grossAmount}"),
                'total_tax_collected' => \Illuminate\Support\Facades\DB::raw("total_tax_collected + {$vatAmount}"),
                'updated_at'          => now(),
            ]);

            \Illuminate\Support\Facades\DB::table('admin_wallet_actions')->insert([
                'admin_wallet_id'     => $walletId,
                'order_id'            => $model->id,
                'gateway'             => $gateway,
                'transaction_id'      => $transactionId,
                'package_type'        => $packageType,
                'gross_amount'        => $grossAmount,
                'gateway_fee'         => $gatewayFee,
                'vat_amount'          => $vatAmount,
                'net_amount'          => $netAmount,
                'user_country'        => $userCountry,
                'is_eu'               => $isEu ? 1 : 0,
                'vat_rate'            => $vatRate,
                'commission_earned'   => $netAmount,
                'collected_cash'      => $grossAmount,
                'total_tax_collected' => $vatAmount,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);

            \Illuminate\Support\Facades\Log::info('Accounting recorded ('.$gateway.')', [
                'sponsor_id'=>$model->id,'gross'=>$grossAmount,
                'fee'=>$gatewayFee,'vat'=>$vatAmount,'net'=>$netAmount,
                'country'=>$userCountry,'is_eu'=>$isEu,
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Accounting record failed ('.$gateway.')', [
                'sponsor_id'=>$model->id,'error'=>$e->getMessage(),
            ]);
        }
    }

}

<?php

namespace App\Services;

use Exception;
use Stripe\Stripe;
use App\Model\Setting;
use App\Model\AdminWallet;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MultipleStripePayment
{
    // EU VAT rates (OSS system)
    const EU_VAT_RATES = [
        'AT'=>20,'BE'=>21,'BG'=>20,'CY'=>19,'CZ'=>21,
        'DE'=>19,'DK'=>25,'EE'=>22,'ES'=>21,'FI'=>24,
        'FR'=>20,'GR'=>24,'HR'=>25,'HU'=>27,'IE'=>23,
        'IT'=>22,'LT'=>21,'LU'=>17,'LV'=>21,'MT'=>18,
        'NL'=>21,'PL'=>23,'PT'=>23,'RO'=>19,'SE'=>25,
        'SI'=>22,'SK'=>20,
    ];

    public function __construct()
    {
        $stripe_credentials = $this->getStripeCredentials();
        Stripe::setApiKey($stripe_credentials['api_key']);
    }

    protected function getStripeCredentials()
    {
        $stripe = Setting::where('key_name', 'stripe')->first();
        if (!$stripe) throw new \Exception("Stripe configuration not found.");
        return $stripe->{$stripe->mode . '_values'};
    }

    /**
     * Create Stripe Checkout Session
     */
    public function pay($models)
    {
        try {
            $ids = $models->pluck('id')->implode(',');

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'EUR',
                        'product_data' => ['name' => "Sponsored Ad"],
                        'unit_amount' => (int) round($models->sum('price') * 100),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('multiple.payment.success', [
                    'method' => 'stripe', 'sponsor_ids' => $ids
                ]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('multiple.payment.cancel', [
                    'method' => 'stripe', 'sponsor_ids' => $ids
                ]),
            ]);

            Log::info('Stripe session created', [
                'sponsor_ids' => $ids,
                'session_id'  => $session->id,
                'amount'      => $models->sum('price'),
            ]);

            return $session->url;

        } catch (Exception $e) {
            Log::error('Stripe Create Payment Error: ' . $e->getMessage());
            throw new Exception('Unable to process Stripe payment. Please try again later.');
        }
    }

    /**
     * Verify Stripe Session and complete payment
     */
    public function executePayment($sessionId, $models)
    {
        try {
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {

                foreach ($models as $model) {

                    // Only record paid packages (price > 0)
                    // Free packages never reach this point (redirected before payment)
                    if ($model->price > 0) {
                        $model->update([
                            'is_paid'                => 1,
                            'payment_transaction_id' => $session->payment_intent,
                        ]);

                        // Record each package separately in accounting
                        $this->recordToAccounting($model, $session->payment_intent, 'stripe');
                    }

                    Log::info('Stripe payment completed', [
                        'sponsor_id'     => $model->id,
                        'transaction_id' => $session->payment_intent,
                        'package_type'   => $model->type ?? 'N/A',
                        'price'          => $model->price,
                    ]);
                }

                $models[0]->ad->status = 1;
                $models[0]->ad->save();

                return true;

            } else {
                foreach ($models as $model) {
                    Log::error('Stripe payment not approved', [
                        'status'     => $session->payment_status,
                        'sponsor_id' => $model->id,
                    ]);
                }
                return false;
            }

        } catch (Exception $ex) {
            Log::error('Stripe Execute Payment Error: ' . $ex->getMessage(), [
                'session_id' => $sessionId,
            ]);
            return false;
        }
    }

    /**
     * Record successful payment to accounting
     * Called ONLY after confirmed paid — never for free packages
     */
    protected function recordToAccounting($model, $transactionId, $gateway)
    {
        try {
            $grossAmount = (float) $model->price;
            if ($grossAmount <= 0) return; // extra safety: skip free packages

            // Stripe fee: EU cards 1.5% + €0.25
            $gatewayFee = round(($grossAmount * 0.015) + 0.25, 2);
            $netAmount  = round($grossAmount - $gatewayFee, 2);

            // Get user country via Ad → User
            $userCountry = '';
            if ($model->ad && $model->ad->user) {
                $userCountry = strtoupper($model->ad->user->country ?? '');
            }

            // VAT calculation
            $isEu      = array_key_exists($userCountry, self::EU_VAT_RATES);
            $vatRate   = $isEu ? self::EU_VAT_RATES[$userCountry] : 0;
            $vatAmount = $isEu ? round($grossAmount * ($vatRate / 100), 2) : 0;

            // Package type — use sponsored ad type name if available
            $packageType = $model->type ?? 'SponsoredAd';

            // Get or create AdminWallet
            $adminWallet = AdminWallet::where('admin_id', 1)->first();
            if (!$adminWallet) {
                $walletId = DB::table('admin_wallets')->insertGetId([
                    'admin_id'               => 1,
                    'withdrawn'              => 0,
                    'commission_earned'      => 0,
                    'delivery_charge_earned' => 0,
                    'pending_amount'         => 0,
                    'total_earning'          => 0,
                    'collected_cash'         => 0,
                    'total_tax_collected'    => 0,
                    'created_at'             => now(),
                    'updated_at'             => now(),
                ]);
            } else {
                $walletId = $adminWallet->id;
            }

            // Update wallet totals
            DB::table('admin_wallets')->where('admin_id', 1)->update([
                'commission_earned'   => DB::raw("commission_earned + {$netAmount}"),
                'collected_cash'      => DB::raw("collected_cash + {$grossAmount}"),
                'total_tax_collected' => DB::raw("total_tax_collected + {$vatAmount}"),
                'updated_at'          => now(),
            ]);

            // Insert transaction record
            DB::table('admin_wallet_actions')->insert([
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

            Log::info('Accounting recorded (Stripe)', [
                'sponsor_id'     => $model->id,
                'transaction_id' => $transactionId,
                'package_type'   => $packageType,
                'gross'          => $grossAmount,
                'gateway_fee'    => $gatewayFee,
                'vat'            => $vatAmount,
                'net'            => $netAmount,
                'country'        => $userCountry,
                'is_eu'          => $isEu,
            ]);

        } catch (\Exception $e) {
            // NEVER block the payment flow — only log
            Log::error('Accounting record failed (Stripe)', [
                'sponsor_id' => $model->id,
                'error'      => $e->getMessage(),
            ]);
        }
    }
}

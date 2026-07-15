<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\CPU\Helpers;
use PayPal\Api\Payer;
use App\Model\Setting;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use App\Model\SponsoredAd;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use PayPal\Auth\OAuthTokenCredential;
use Illuminate\Database\Eloquent\Model;

class PaypalPayment
{
    protected $apiContext;

    public function __construct()
    {

        $paypal_credentials = $this->getPaypalCredentials();

        $paypalConfig = [
            'client_id' => $paypal_credentials['client_id'],
            'secret' => $paypal_credentials['client_secret'],
            'settings' => [
                'mode' => $paypal_credentials['mode'],
                'http.ConnectionTimeOut' => 60,
                'http.Retry' => 3,
                'log.LogEnabled' => true,
                'log.FileName' => storage_path('logs/paypal.log'),
                'log.LogLevel' => 'ERROR',
            ],
        ];

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConfig['client_id'],
                $paypalConfig['secret']
            )
        );

        $this->apiContext->setConfig($paypalConfig['settings']);
    }

    protected function getPaypalCredentials()
    {
        $paypal = Setting::where('key_name', 'paypal')->first();

        if (!$paypal) {
            throw new \Exception("PayPal configuration not found.");
        }

        $values = $paypal->{$paypal->mode . '_values'};

        $values['mode'] = $paypal->mode === 'test' ? 'sandbox' : 'live';

        return $values;
        
    }

    /**
     * Create a PayPal payment
     */
    public function pay($model, $returnUrl = null, $cancelUrl = null)
    {
        try {

            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $amount = new Amount();
            $amount->setCurrency('EUR')
            ->setTotal(number_format($model->price, 2, '.', ''));

            $transaction = new Transaction();
            $transaction->setAmount($amount)
            ->setDescription("Payment for Sponsored Ad #{$model->id}");

            // Default to the web session-based callbacks; callers (e.g. the mobile
            // API) may pass self-contained URLs that do not depend on a web session.
            $returnUrl = $returnUrl ?: URL::route('payment.success', ['method' => 'paypal', 'sponsor_id' => $model->id]);
            $cancelUrl = $cancelUrl ?: URL::route('payment.cancel', ['method' => 'paypal', 'sponsor_id' => $model->id]);

            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl($returnUrl)
            ->setCancelUrl($cancelUrl);

            $payment = new Payment();
            $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

            $payment->create($this->apiContext);

            $approvalUrl = $payment->getApprovalLink();
            
            // Log the payment creation details
            Log::info('PayPal payment created successfully', [
                'sponsor_id' => $model->id,
                'payment_id' => $payment->getId(),
                'approval_url' => $approvalUrl,
                'amount' => $model->price,
                'currency' => 'EUR'
            ]);

            return $approvalUrl;
        } catch (Exception $e) {
            // Detailed logging for debugging
            Log::error('PayPal Create Payment Error: ' . $e->getMessage(), [
                'exception_class' => get_class($e),
                'trace' => $e->getTraceAsString(),
            ]);

            // Check if it's a PayPal Connection Exception with extra data
            if (method_exists($e, 'getData')) {
                Log::error('PayPal API Response: ' . $e->getData());
            }

            throw new Exception('Unable to process PayPal payment. Please try again later.');
        }
    }

    public function executePayment($paymentId, $payerId, $model)
    {
        try {
            Log::info('Executing PayPal payment', [
                'paymentId' => $paymentId,
                'payerId' => $payerId,
                'sponsor_id' => $model->id
            ]);

            // Get the payment
            $payment = Payment::get($paymentId, $this->apiContext);
            
            Log::info('Payment state before execution', [
                'state' => $payment->getState(),
                'payment_id' => $payment->getId()
            ]);

            // Execute the payment
            $execution = new PaymentExecution();
            $execution->setPayerId($payerId);

            $result = $payment->execute($execution, $this->apiContext);
            
            Log::info('Payment execution result', [
                'state' => $result->getState(),
                'payment_id' => $result->getId()
            ]);

            if ($result->getState() === 'approved') {
                // Get transaction details
                $transactions = $result->getTransactions();
                $transaction = $transactions[0];
                $relatedResources = $transaction->getRelatedResources();
                $sale = $relatedResources[0]->getSale();
                                
                // Update sponsor with payment details
                $model->update([
                    'is_paid' => 1,
                    'payment_transaction_id' => $sale->getId(),
                ]);

                // Record in accounting after confirmed approved
                $this->recordToAccounting($model, $sale->getId(), 'paypal');

                Log::info('Payment completed successfully', [
                    'sponsor_id' => $model->id,
                    'transaction_id' => $sale->getId(),
                ]);

                return true;
            } else {
                Log::error('Payment not approved', [
                    'state' => $result->getState(),
                    'sponsor_id' => $model->id
                ]);
                return false;
            }

        } catch (Exception $ex) {
            Log::error('PayPal Execute Payment Error: ' . $ex->getMessage(), [
                'exception_class' => get_class($ex),
                'trace' => $ex->getTraceAsString(),
                'sponsor_id' => $model->id,
                'payment_id' => $paymentId,
                'payer_id' => $payerId
            ]);
            
            // Check if it's a PayPal Connection Exception with extra data
            if (method_exists($ex, 'getData')) {
                Log::error('PayPal Execute API Response: ' . $ex->getData());
            }
            
            return false;
        }
    }

    protected function recordToAccounting($model, $transactionId, $gateway)
    {
        try {
            $grossAmount = (float) $model->price;
            if ($grossAmount <= 0) return;

            // PayPal fee: 3.49% + €0.49
            $gatewayFee = round(($grossAmount * 0.0349) + 0.49, 2);
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

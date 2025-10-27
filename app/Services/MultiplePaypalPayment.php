<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
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

class MultiplePaypalPayment
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

        // Initialize PayPal API Context
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
    public function pay($models)
    {
        try {
            
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $amount = new Amount();
            $amount->setCurrency('EUR')
            ->setTotal(number_format($models->sum('price'), 2, '.', ''));

            $transaction = new Transaction();
            $transaction->setAmount($amount)
            ->setDescription("Payment for Sponsored Ad");

            $ids = $models->pluck('id')->implode(',');

            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl(URL::route('multiple.payment.success', ['method' => 'paypal', 'sponsor_ids' => $ids]))
            ->setCancelUrl(URL::route('multiple.payment.cancel', ['method' => 'paypal', 'sponsor_ids' => $ids]));

            $payment = new Payment();
            $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

            $payment->create($this->apiContext);

            $approvalUrl = $payment->getApprovalLink();
            
            // Log the payment creation details
            Log::info('PayPal payment created successfully', [
                'sponsor_id' => $ids,
                'payment_id' => $payment->getId(),
                'approval_url' => $approvalUrl,
                'amount' => $models->sum('price'),
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

    
    public function executePayment($paymentId, $payerId, $models)
    {
        try {
            Log::info('Executing PayPal payment', [
                'paymentId' => $paymentId,
                'payerId' => $payerId,
                'sponsor_ids' => $models->pluck('id')->implode(',')
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
                
                // Update all models with payment details
                foreach ($models as $model) {
                    $expirationDate = Carbon::now()->addDays($model->duration_in_days);

                    $model->update([
                        'is_paid' => 1,
                        'expiration_date' => $expirationDate,
                        'payment_transaction_id' => $sale->getId(),
                    ]);

                    Log::info('Payment completed successfully', [
                        'sponsor_id' => $model->id,
                        'transaction_id' => $sale->getId(),
                        'expiration_date' => $expirationDate
                    ]);
                }

                $models[0]->ad->status = 1;
                $models[0]->ad->save();

                return true;
            } else {
                foreach ($models as $model) {
                    Log::error('Payment not approved', [
                        'state' => $result->getState(),
                        'sponsor_id' => $model->id
                    ]);
                }
                return false;
            }

        } catch (Exception $ex) {
            Log::error('PayPal Execute Payment Error: ' . $ex->getMessage(), [
                'exception_class' => get_class($ex),
                'trace' => $ex->getTraceAsString(),
                'payment_id' => $paymentId,
                'payer_id' => $payerId
            ]);
            
            if (method_exists($ex, 'getData')) {
                Log::error('PayPal Execute API Response: ' . $ex->getData());
            }
            
            return false;
        }
    }



}
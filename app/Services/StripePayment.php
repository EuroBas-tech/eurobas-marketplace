<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use Stripe\Stripe;
use App\Model\Setting;
use Stripe\Checkout\Session;
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
    public function pay($model)
    {
        try {
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
                'success_url' => route('payment.success', ['method' => 'stripe', 'sponsor_id' => $model->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel', ['method' => 'stripe', 'sponsor_id' => $model->id]),
                
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
} 
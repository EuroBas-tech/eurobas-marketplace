<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use Stripe\Stripe;
use App\Model\Setting;
use App\Model\SponsoredAd;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class MultipleStripePayment
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
                        'product_data' => [
                            'name' => "Sponsored Ad",
                        ],
                        'unit_amount' => (int) round($models->sum('price') * 100) // stripe uses cents,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('multiple.payment.success', ['method' => 'stripe', 'sponsor_ids' => $ids]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('multiple.payment.cancel', ['method' => 'stripe', 'sponsor_ids' => $ids]),
            ]);

            Log::info('Stripe session created successfully', [
                'sponsor_ids' => $ids,
                'session_id' => $session->id,
                'amount' => $models->sum('price'),
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
    public function executePayment($sessionId, $models)
    {
        try {
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                foreach ($models as $model) {
                    $expirationDate = Carbon::now()->addDays($model->duration_in_days);

                    $model->update([
                        'is_paid' => 1,
                        'payment_transaction_id' => $session->payment_intent,
                        'expiration_date' => $expirationDate,
                    ]);

                    Log::info('Stripe payment completed successfully', [
                        'sponsor_id' => $model->id,
                        'transaction_id' => $session->payment_intent,
                        'expiration_date' => $expirationDate
                    ]);
                }

                $models[0]->ad->status = 1;
                $models[0]->ad->save();

                return true;
            } else {
                foreach ($models as $model) {
                    Log::error('Stripe payment not approved', [
                        'status' => $session->payment_status,
                        'sponsor_id' => $model->id
                    ]);
                }
                return false;
            }
        } catch (Exception $ex) {
            Log::error('Stripe Execute Payment Error: ' . $ex->getMessage(), [
                'exception_class' => get_class($ex),
                'trace' => $ex->getTraceAsString(),
                'session_id' => $sessionId
            ]);
            return false;
        }
    }

}
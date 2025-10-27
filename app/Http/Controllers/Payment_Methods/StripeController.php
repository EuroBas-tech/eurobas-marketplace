<?php

namespace App\Http\Controllers\Payment_Methods;

use App\Model\SponsoredAd;
use Illuminate\Http\Request;
use App\Services\StripePayment;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    protected $stripeService;

    public function __construct(StripePayment $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function pay(SponsoredAd $sponsor)
    {
        try {
            $checkoutUrl = $this->stripeService->pay($sponsor);
            return redirect($checkoutUrl);
        } catch (\Exception $e) {
            Log::error('Stripe payment creation failed', [
                'sponsor_id' => $sponsor->id,
                'error' => $e->getMessage()
            ]);

            Toastr::error('Unable to create Stripe payment. Please try again.');
            return redirect()->route('home');
        }
    }

    public function success(Request $request, $sponsor_id)
    {
        $sessionId = $request->get('session_id');

        Log::info('Stripe success callback received', [
            'sessionId' => $sessionId,
            'sponsor_id'=> $sponsor_id,
            'all_params' => $request->all()
        ]);

        if (!$sessionId) {
            Log::error('Missing Stripe session_id', [
                'sponsor_id' => $sponsor_id
            ]);

            Toastr::error('Invalid payment session.');
            return redirect()->route('home');
        }

        try {
            $sponsor = SponsoredAd::findOrFail($sponsor_id);

            if ($this->stripeService->executePayment($sessionId, $sponsor)) {
                Toastr::success('Payment completed successfully.');
                return redirect()->route('home');
            } else {
                Log::error('Stripe payment execution failed', [
                    'sponsor_id' => $sponsor_id,
                    'session_id' => $sessionId
                ]);

                if ($sponsor->fresh() && !$sponsor->fresh()->is_paid) {
                    $sponsor->delete();
                    Log::info('Unpaid sponsor removed', ['sponsor_id' => $sponsor_id]);
                }

                Toastr::error('Payment failed. Please try again.');
                return redirect()->route('home');
            }
        } catch (\Exception $e) {
            Log::error('Stripe success handler error', [
                'error' => $e->getMessage(),
                'sponsor_id' => $sponsor_id,
                'session_id' => $sessionId
            ]);

            Toastr::error('An error occurred processing your payment.');
            return redirect()->route('home');
        }
    }

    public function cancel($sponsor_id)
    {
        try {
            $sponsor = SponsoredAd::find($sponsor_id);
            if ($sponsor) {
                $sponsor->delete();
                Log::info('Sponsor deleted due to Stripe cancellation', [
                    'sponsor_id' => $sponsor_id
                ]);
            }

            Toastr::error('Payment cancelled.');
            return redirect()->route('home');
        } catch (\Exception $e) {
            Log::error('Error handling Stripe cancellation', [
                'error' => $e->getMessage(),
                'sponsor_id' => $sponsor_id
            ]);

            Toastr::error('Payment cancelled.');
            return redirect()->route('home');
        }
    }
}

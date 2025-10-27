<?php

namespace App\Http\Controllers\Payment_Methods;

use App\Model\SponsoredAd;
use Illuminate\Http\Request;
use App\Services\PaypalPayment;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    protected $paypalService;

    public function __construct(PaypalPayment $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    public function pay(SponsoredAd $sponsor)
    {
        try {
            $approvalUrl = $this->paypalService->pay($sponsor);
            return redirect($approvalUrl);
        } catch (\Exception $e) {
            Log::error('PayPal payment creation failed', [
                'sponsor_id' => $sponsor->id,
                'error' => $e->getMessage()
            ]);
            
            Toastr::error('Unable to create payment. Please try again.');
            return redirect()->route('home');
        }
    }

    public function success(Request $request, $sponsor_id)
    {
        $paymentId = $request->get('paymentId');
        $payerId   = $request->get('PayerID');

        Log::info('PayPal success callback received', [
            'paymentId' => $paymentId,
            'payerId'   => $payerId,
            'sponsor_id'=> $sponsor_id,
            'all_params' => $request->all()
        ]);

        // Validate required parameters
        if (!$paymentId || !$payerId) {
            Log::error('Missing required PayPal parameters', [
                'paymentId' => $paymentId,
                'payerId' => $payerId,
                'sponsor_id' => $sponsor_id
            ]);
            
            Toastr::error('Invalid payment parameters.');
            return redirect()->route('home');
        }

        try {
            $sponsor = SponsoredAd::findOrFail($sponsor_id);
            
            if ($this->paypalService->executePayment($paymentId, $payerId, $sponsor)) {
                Toastr::success('Payment completed successfully.');
                return redirect()->route('home');
            } else {
                Log::error('Payment execution failed', [
                    'sponsor_id' => $sponsor_id,
                    'paymentId' => $paymentId
                ]);
                
                // Only delete if sponsor still exists and wasn't paid
                if ($sponsor->fresh() && !$sponsor->fresh()->is_paid) {
                    $sponsor->delete();
                    Log::info('Unpaid sponsor removed', ['sponsor_id' => $sponsor_id]);
                }
                
                Toastr::error('Payment failed. Please try again.');
                return redirect()->route('home');
            }
        } catch (\Exception $e) {
            Log::error('PayPal success handler error', [
                'error' => $e->getMessage(),
                'sponsor_id' => $sponsor_id,
                'paymentId' => $paymentId
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
                Log::info('Sponsor deleted due to payment cancellation', [
                    'sponsor_id' => $sponsor_id
                ]);
            }
            
            Toastr::error('Payment cancelled.');
            return redirect()->route('home');
        } catch (\Exception $e) {
            Log::error('Error handling payment cancellation', [
                'error' => $e->getMessage(),
                'sponsor_id' => $sponsor_id
            ]);
            
            Toastr::error('Payment cancelled.');
            return redirect()->route('home');
        }
    }
}
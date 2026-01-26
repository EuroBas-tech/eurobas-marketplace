<?php

namespace App\Http\Controllers\Payment_Methods;

use App\Model\Ad;
use App\Model\Setting;
use App\Model\PaidBanner;
use App\Model\SponsoredAd;
use Illuminate\Http\Request;
use App\Services\PaypalPayment;
use App\Services\StripePayment;
use App\Model\SubscriptionPackage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Services\MultiplePaypalPayment;
use App\Services\MultipleStripePayment;
use Illuminate\Database\Eloquent\Model;

class MultiplePaymentController extends Controller
{
    protected $paypalService;
    protected $stripeService;

    public function __construct(MultiplePaypalPayment $paypalService, MultipleStripePayment $stripeService)
    {
        $this->paypalService = $paypalService;
        $this->stripeService = $stripeService;
    }

    public function multiplePaymentMethod(Request $request) {

        $data = $request->all();

        $packages = SubscriptionPackage::with('type')->whereIn('id', $data['packages_ids'])->get();

        session([
            'ad_id' => $data['ad_id'],
            'packages_ids' => $packages->pluck('id')->toArray(),
        ]);

        $payment_methods = Setting::whereIn('key_name',['paypal', 'stripe'])->get();

        $payment_methods_images = $payment_methods->pluck('additional_data.gateway_image', 'key_name')->toArray();

        return view('theme-views.payment-methods.multiple-select-payment-method',
        compact('data', 'packages', 'payment_methods_images'));

    }

    public function multipleRedirectToPayment(Request $request) {

        $ad_id = session('ad_id');
        $packages_ids = session('packages_ids');

        $payment_method = $request->get('payment_method');
        
        $packages = SubscriptionPackage::with('type')->whereIn('id', $packages_ids)->get();
        
        $ad = Ad::find($ad_id);

        $model_ids = [];

        foreach($packages as $package) {

            $data = [];

            $data['ad_id'] = $ad->id;
            $data['type'] = $package->type->name;
            $data['price'] = $package->price;
            $data['package_id'] = $package->id;
            $data['duration_in_days'] = $package->duration_in_days;
            $data['expiration_date'] = now()->addHours($package->duration_in_days * 24);

            if($package->type->name == 'promotional_video') {
                $data['video_id'] = session('video_id');
            }

            $model = $ad->sponsor()->create($data);
            $model_ids[] = $model->id;
            
            if($package->type->name == 'promotional_video') {
                session()->forget('video_id');
            }

        }

        return redirect()->route(
            'multiple.payment.pay',
            [
                'method' => $payment_method,
                'model_ids' => implode(',', $model_ids),
                'model_name' => 'App\Model\SponsoredAd',
            ]
        );

    }

    public function pay(string $method, $model_ids)
    {
        $method = strtolower($method);

        $models = SponsoredAd::whereIn('id', explode(',', $model_ids))->get();

        try {
            switch ($method) {
                case 'paypal':
                    $approvalUrl = $this->paypalService->pay($models);
                    return redirect($approvalUrl);

                case 'stripe':
                    $checkoutUrl = $this->stripeService->pay($models);
                    return redirect($checkoutUrl);

                default:
                    Log::error('Invalid payment method', [
                        'method' => $method,
                        'sponsor_ids' => $model_ids,
                        'model_name' => 'SponsoredAd'
                    ]);
                    
                    Toastr::error('Invalid payment method selected.');
                    return redirect()->route('home');
            }
        } catch (\Exception $e) {
            Log::error('Payment creation failed', [
                'method' => $method,
                'sponsor_ids' => $model_ids,
                'error' => $e->getMessage()
            ]);
            
            $methodName = ucfirst($method);
            Toastr::error("Unable to create {$methodName} payment. Please try again.");
            return redirect()->route('home');
        }
    }

    public function success(Request $request, string $method, $sponsor_ids)
    {
        $method = strtolower($method);

        
        Log::info('Payment success callback received', [
            'method' => $method,
            'sponsor_ids' => $sponsor_ids,
            'model_name' => 'SponsoredAd',
            'all_params' => $request->all()
        ]);

        try {
            $models = SponsoredAd::whereIn('id', explode(',', $sponsor_ids))->get();

            switch ($method) {
                case 'paypal':
                    return $this->handlePaypalSuccess($request, $models);

                case 'stripe':
                    return $this->handleStripeSuccess($request, $models);

                default:
                    Log::error('Invalid payment method in success callback', [
                        'method' => $method,
                        'model_id' => $sponsor_ids,
                        'model_name' => 'SponsoredAd'
                    ]);
                    
                    Toastr::error('Invalid payment method.');
                    return redirect()->route('home');
            }
        } catch (\Exception $e) {
            Log::error('Payment success handler error', [
                'method' => $method,
                'error' => $e->getMessage(),
                'model_id' => $sponsor_ids,
                'model_name' => 'SponsoredAd'
            ]);
            
            Toastr::error('An error occurred processing your payment.');
            return redirect()->route('home');
        }
    }

    public function cancel(string $method, $sponsor_ids)
    {
        $method = strtolower($method);

        $modelName = session('model_name');

        try {

            $sponsors = SponsoredAd::whereIn('id', explode(',', $sponsor_ids))->get();
            $ad = $sponsors[0]->ad;

            $ad->delete();
            $sponsors->delete();

            Log::info('Sponsor deleted due to payment cancellation', [
                'method' => $method,
                'model_id' => $sponsor_ids,
                'model_name' => 'SponsoredAd'
            ]);
                        
            Toastr::error('Payment cancelled.');
            return redirect()->route('home');
        } catch (\Exception $e) {
            Log::error('Error handling payment cancellation', [
                'method' => $method,
                'error' => $e->getMessage(),
                'model_id' => $sponsor_ids,
                'model_name' => 'SponsoredAd'
            ]);
            
            Toastr::error('Payment cancelled.');
            return redirect()->route('home');
        }
    }

    private function handlePaypalSuccess(Request $request, $models)
    {
        $paymentId = $request->get('paymentId');
        $payerId = $request->get('PayerID');

        $modelName = session('model_name');

        // Validate PayPal parameters
        if (!$paymentId || !$payerId) {
            Log::error('Missing required PayPal parameters', [
                'paymentId' => $paymentId,
                'payerId' => $payerId,
                'sponsor_ids' => $models->pluck('id')->implode(','),
                'model_name' => 'SponsoredAd',
            ]);
            
            Toastr::error('Invalid PayPal payment parameters.');
            return redirect()->route('home');
        }

        if ($this->paypalService->executePayment($paymentId, $payerId, $models)) {
            Toastr::success('PayPal payment completed successfully.');
            return redirect()->route('ads-show', $models[0]->ad->slug);
        } else {
            Log::error('PayPal payment execution failed', [
                'sponsor_ids' => $models->pluck('id')->implode(','),
                'model_name' => $modelName,
                'paymentId' => $paymentId
            ]);
            
            $models[0]->ad->delete();

            foreach ($models as $model) {
                if ($model->fresh() && !$model->fresh()->is_paid) {
                    $model->delete();
                    Log::info('Unpaid model removed', [
                        'sponsor_id' => $model->id,
                        'model_name' => 'SponsoredAd'
                    ]);
                }
            }
            
            Toastr::error('PayPal payment failed. Please try again.');
            return redirect()->route('home');
        }
    }

    private function handleStripeSuccess(Request $request, $models)
    {
        $sessionId = $request->get('session_id');

        // Validate Stripe parameters
        if (!$sessionId) {
            Log::error('Missing Stripe session_id', [
                'sponsor_ids' => $models->pluck('id')->implode(','),
                'model_name' => 'SponsoredAd',
            ]);
            
            Toastr::error('Invalid Stripe payment session.');
            return redirect()->route('home');
        }

        if ($this->stripeService->executePayment($sessionId, $models)) {
            Toastr::success('Stripe payment completed successfully.');
            return redirect()->route('ads-show', $models[0]->ad->slug);
        } else {
            Log::error('Stripe payment execution failed', [
                'sponsor_ids' => $models->pluck('id')->implode(','),
                'session_id' => $sessionId
            ]);

            $models[0]->ad->delete();

            foreach ($models as $model) {
                if ($model->fresh() && !$model->fresh()->is_paid) {
                    $model->delete();
                    Log::info('Unpaid model removed', [
                        'sponsor_id' => $model->id,
                        'model_name' => 'SponsoredAd'
                    ]);
                }
            }
            
            Toastr::error('Stripe payment failed. Please try again.');
            return redirect()->route('home');
        }
    }

}
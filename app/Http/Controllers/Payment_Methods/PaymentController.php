<?php

namespace App\Http\Controllers\Payment_Methods;

use App\Model\Ad;
use App\Model\Setting;
use App\CPU\ImageManager;
use App\Model\PaidBanner;
use App\Model\SponsoredAd;
use Illuminate\Http\Request;
use App\Services\PaypalPayment;
use App\Services\StripePayment;
use Illuminate\Http\UploadedFile;
use App\Model\SubscriptionPackage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    protected $paypalService;
    protected $stripeService;

    public function __construct(PaypalPayment $paypalService, StripePayment $stripeService)
    {
        $this->paypalService = $paypalService;
        $this->stripeService = $stripeService;
    }

    public function paymentMethod(Request $request) {

        $data = $request->all();

        $package = SubscriptionPackage::with('type')->find($request->package_id);

        $session_data = [
            'ad_id' => $data['ad_id'] ?? null,
            'package_id' => $package->id,
        ];

        if($request->filled('banner_id')) {
            $session_data['banner_id'] = $request->banner_id;
        }

        session($session_data);

        $payment_methods = Setting::whereIn('key_name',['paypal', 'stripe'])->get();

        $payment_methods_images = $payment_methods->pluck('additional_data.gateway_image', 'key_name')->toArray();

        return view('theme-views.payment-methods.select-payment-method',
        compact('data', 'package', 'payment_methods_images'));

    }

    public function redirectToPayment(Request $request) {

        $ad_id = session('ad_id');
        $package_id = session('package_id');
        $data = [];

        $payment_method = $request->get('payment_method');

        if(!$payment_method) {
            return abort(404);
        }
        
        $package = SubscriptionPackage::with('type')->find($package_id);
        
        $ad = Ad::find($ad_id);
        
        if ($package->type->name == 'promotional_banner') {

            $data['type'] = $package->type->name;
            $data['price'] = $package->price;
            $data['package_id'] = $package->id;
            $data['duration_in_days'] = $package->duration_in_days;

            
            $uploadedFile = null;
            $path = session('banner_image_path'); // (1) get stored path

            if (!session('banner_id')) {

                if (!$path || !Storage::exists($path)) {
                    throw new \RuntimeException('Temporary banner image not found.'); // (2) fail fast if missing
                }

                $fullPath = storage_path('app/' . $path); // (3) absolute file path

                $uploadedFile = new \Symfony\Component\HttpFoundation\File\UploadedFile(
                    $fullPath,
                    session('banner_image_name') ?? basename($fullPath),
                    session('banner_image_mime') ?? mime_content_type($fullPath),
                    null,
                    true
                ); // (4) rebuild UploadedFile from real temp file
            } else {
                if ($path && Storage::exists($path)) {   // ✅ fixed: should be AND, not OR
                    $fullPath = storage_path('app/' . $path); // (3) absolute file path

                    $uploadedFile = new \Symfony\Component\HttpFoundation\File\UploadedFile(
                        $fullPath,
                        session('banner_image_name') ?? basename($fullPath),
                        session('banner_image_mime') ?? mime_content_type($fullPath),
                        null,
                        true
                    ); // (4) rebuild UploadedFile from real temp file
                }
            }

            $model = session('banner_id') ? PaidBanner::find(session('banner_id')) : new PaidBanner;

            $model->banner_url = isset($ad->slug) ? route('ads-show', $ad->slug) : null;
            if($uploadedFile) {
                $model->banner_image = ImageManager::upload('paid-banners/', 'webp', $uploadedFile, null);
            }
            $model->price = $package->price;
            $model->duration_in_days = $package->duration_in_days;
            $model->user_id = auth('customer')->id();
            $model->package_id = $package->id;

            $model->save();

            // cleanup: remove temp file and clear session keys
            Storage::delete($path); // (5) delete temporary file
            session()->forget(['banner_image_path', 'banner_image_name', 'banner_image_mime']); // (6) clear session
        }else {
            $data['ad_id'] = $ad->id;
            $data['type'] = $package->type->name;
            $data['price'] = $package->price;
            $data['package_id'] = $package->id;
            $data['duration_in_days'] = $package->duration_in_days;

            if($package->type->name == 'promotional_video') {
                $data['video_id'] = session('video_id');
            }

            $model = $ad->sponsor()->create($data);

            if($package->type->name == 'promotional_video') {
                session()->forget('video_id');
            }
        }

        return redirect()->route(
            'payment.pay',
            [
                'method' => $payment_method,
                'model_id' => $model->id,
                'model_name' => get_class($model),
            ]
        );

    }

    public function pay(string $method, $model_id, $model_name)
    {

        $model = $model_name::find($model_id);

        session(['model_name' => $model_name]);

        try {
            switch ($method) {
                case 'paypal':
                    $approvalUrl = $this->paypalService->pay($model);
                    return redirect($approvalUrl);

                case 'stripe':
                    $checkoutUrl = $this->stripeService->pay($model);
                    return redirect($checkoutUrl);

                default:
                    Log::error('Invalid payment method', [
                        'method' => $method,
                        'model_id' => $model->id,
                        'model_name' => $model_name
                    ]);
                    
                    Toastr::error('Invalid payment method selected.');
                    return redirect()->route('home');
            }
        } catch (\Exception $e) {
            Log::error('Payment creation failed', [
                'method' => $method,
                'model_id' => $model->id,
                'error' => $e->getMessage()
            ]);
            
            $methodName = ucfirst($method);
            Toastr::error("Unable to create {$methodName} payment. Please try again.");
            return redirect()->route('home');
        }
    }

    public function success(Request $request, string $method, $model_id)
    {
        $method = strtolower($method);

        $modelName = session('model_name');
        
        Log::info('Payment success callback received', [
            'method' => $method,
            'model_id' => $model_id,
            'model_name' => $modelName,
            'all_params' => $request->all()
        ]);

        try {
            $model = $modelName::findOrFail($model_id);

            switch ($method) {
                case 'paypal':
                    return $this->handlePaypalSuccess($request, $model);

                case 'stripe':
                    return $this->handleStripeSuccess($request, $model);

                default:
                    Log::error('Invalid payment method in success callback', [
                        'method' => $method,
                        'model_id' => $model_id,
                        'model_name' => $modelName
                    ]);
                    
                    Toastr::error('Invalid payment method.');
                    return redirect()->route('home');
            }
        } catch (\Exception $e) {
            Log::error('Payment success handler error', [
                'method' => $method,
                'error' => $e->getMessage(),
                'model_id' => $model_id,
                'model_name' => session('model_name')
            ]);
            
            Toastr::error('An error occurred processing your payment.');
            return redirect()->route('home');
        }
    }

    public function cancel(string $method, $model_id)
    {
        $method = strtolower($method);

        $modelName = session('model_name');

        try {
            $model = SponsoredAd::find($model_id);

            if ($model) {
                $model->delete();
                Log::info('Sponsor deleted due to payment cancellation', [
                    'method' => $method,
                    'model_id' => $model_id,
                    'model_name' => $modelName
                ]);
            }
            
            Toastr::error('Payment cancelled.');
            return redirect()->route('home');
        } catch (\Exception $e) {
            Log::error('Error handling payment cancellation', [
                'method' => $method,
                'error' => $e->getMessage(),
                'model_id' => $model_id,
                'model_name' => $modelName
            ]);
            
            Toastr::error('Payment cancelled.');
            return redirect()->route('home');
        }
    }

    private function handlePaypalSuccess(Request $request, $model)
    {
        $paymentId = $request->get('paymentId');
        $payerId = $request->get('PayerID');

        $modelName = session('model_name');

        // Validate PayPal parameters
        if (!$paymentId || !$payerId) {
            Log::error('Missing required PayPal parameters', [
                'paymentId' => $paymentId,
                'payerId' => $payerId,
                'model_id' => $model->id,
                'model_name' => $modelName,
            ]);
            
            Toastr::error('Invalid PayPal payment parameters.');
            return redirect()->route('home');
        }

        if ($this->paypalService->executePayment($paymentId, $payerId, $model)) {
            Toastr::success('PayPal payment completed successfully.');
            return redirect()->route('home');
        } else {
            Log::error('PayPal payment execution failed', [
                'model_id' => $model->id,
                'model_name' => $modelName,
                'paymentId' => $paymentId
            ]);
            
            // Only delete if model still exists and wasn't paid
            if ($model->fresh() && !$model->fresh()->is_paid) {
                $model->delete();
                Log::info('Unpaid model removed', ['model_id' => $model->id, 'model_name' => $modelName]);
            }
            
            Toastr::error('PayPal payment failed. Please try again.');
            return redirect()->route('home');
        }
    }

    private function handleStripeSuccess(Request $request, $model)
    {
        $sessionId = $request->get('session_id');

        $modelName = session('model_name');

        // Validate Stripe parameters
        if (!$sessionId) {
            Log::error('Missing Stripe session_id', [
                'model_id' => $model->id,
                'model_name' => $modelName,
            ]);
            
            Toastr::error('Invalid Stripe payment session.');
            return redirect()->route('home');
        }

        if ($this->stripeService->executePayment($sessionId, $model)) {
            Toastr::success('Stripe payment completed successfully.');
            return redirect()->route('home');
        } else {
            Log::error('Stripe payment execution failed', [
                'model_id' => $model->id,
                'session_id' => $sessionId
            ]);
            
            // Only delete if model still exists and wasn't paid
            if ($model->fresh() && !$model->fresh()->is_paid) {
                $model->delete();
                Log::info('Unpaid model removed', ['model_id' => $model->id]);
            }
            
            Toastr::error('Stripe payment failed. Please try again.');
            return redirect()->route('home');
        }
    }

}
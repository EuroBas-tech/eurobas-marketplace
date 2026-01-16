<?php

namespace App\Http\Controllers\Web;

use App\Model\Ad;
use App\CPU\Helpers;
use App\Model\Brand;
use App\Models\User;
use App\Model\AdView;
use App\Model\Review;
use GuzzleHttp\Client;
use App\Model\AdReport;
use App\Model\Category;
use App\Model\Wishlist;
use App\Model\AdAuction;
use App\Model\ListValue;
use App\CPU\ImageManager;
use App\Model\SponsoredAd;
use App\CPU\ProductManager;
use App\Model\VehicleModel;
use Illuminate\Support\Str;
use App\Model\AdAskingPrice;
use Illuminate\Http\Request;
use App\Model\BusinessSetting;
use App\Model\SponsoredAdType;
use App\Model\SubscriptionPackage;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\PaymentGatewayFactory;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Payment_Methods\PayPalController;
use App\Http\Controllers\Payment_Methods\StripeController;

class SponsorController extends Controller
{

    public function add(Request $request) {

        $is_profile_uncompleted = Helpers::prevent_if_profile_incomplete();

        if($is_profile_uncompleted) {
            Toastr::success(translate('you_must_complete_your_profile_first_to_be_able_to_post_an_ad'));
            return back();
        }
        
        SponsoredAdType::where('name', str_replace('-', '_', $request->type))->firstOrFail();

        $sponsor_type = $request->type;

        $user_ads = Ad::active()->where('user_id', auth('customer')->id())
        ->whereDoesntHave('sponsor', function ($q) use ($sponsor_type) {
            $q->where('type', str_replace('-', '_', $sponsor_type))
            ->where('expiration_date', '>', now());
        })->get();

        $packages = SubscriptionPackage::with('features')->where('status', 1)
        ->whereHas('type', function ($q) use ($request, $sponsor_type) {
            $q->where('name', str_replace('-', '_', $sponsor_type));
        })->get();

        $maximum_video_duration = BusinessSetting::where('type', 'maximum_promotional_video_duration')->value('value');
        $maximum_video_size = BusinessSetting::where('type', 'maximum_promotional_video_size')->value('value');
        
        return view('theme-views.sponsor.create' , compact('user_ads', 'packages', 'sponsor_type', 
        'maximum_video_duration', 'maximum_video_size'));
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'ad_id' => 'required|integer',
            'type' => 'required|string|in:urgent-sale-sticker,appearance-in-first-results,promotional-video',
        ]);

        $ad = Ad::find($request->ad_id);
        $sponsor_type = str_replace('-', '_', $request->type);

        // Dynamically call the method based on type
        if (method_exists($this, $sponsor_type)) {
            return $this->{$sponsor_type}($request, $ad);
        }

        abort(404, 'Invalid sponsor type');
    }

    private function urgent_sale_sticker(Request $request, $ad)
    {
        
        $package = SubscriptionPackage::with('type')->where('id', $request->package_id)
        ->where('status', 1)
        ->whereHas('type', function ($query) {
            $query->where('name', 'urgent_sale_sticker');
        })->first();

        if ($package->price > 0) {
            $data = $request->all();
            $data['ad_id'] = $ad->id;

            return response()->view('theme-views.sponsor.partials.redirect-payment-post', [
                'route' => route('payment.method'),
                'data'  => $data,
            ]);
        }
        
        $ad->sponsor()->create([
            'ad_id' => $ad->id,
            'type' => $package->type->name,
            'price' => $package->price,
            'package_id' => $package->id,
            'duration_in_days' => $package->duration_in_days,
            'is_paid' => 1,
            'expiration_date' => now()->addDays($package->duration_in_days),
            'payment_transaction_id' => null,
        ]);

        Toastr::success(translate('urgent_sale_sticker_added_successfully'));
        return redirect()->route('home');

    }

    private function appearance_in_first_results(Request $request, $ad)
    {
        $package = SubscriptionPackage::with('type')->where('id', $request->package_id)
        ->where('status', 1)
        ->whereHas('type', function ($query) {
            $query->where('name', 'appearance_in_first_results');
        })->first();

        if ($package->price > 0) {
            $data = $request->all();
            $data['ad_id'] = $ad->id;

            return response()->view('theme-views.sponsor.partials.redirect-payment-post', [
                'route' => route('payment.method'),
                'data'  => $data,
            ]);
        }
        
        $ad->sponsor()->create([
            'ad_id' => $ad->id,
            'type' => $package->type->name,
            'price' => $package->price,
            'package_id' => $package->id,
            'duration_in_days' => $package->duration_in_days,
            'is_paid' => 1,
            'expiration_date' => now()->addDays($package->duration_in_days),
            'payment_transaction_id' => null,
        ]);

        Toastr::success(translate('appearance_in_first_results_sponsor_added_successfully'));
        return redirect()->route('home');

    }

    private function promotional_video(Request $request, $ad)
    {

        $package = SubscriptionPackage::with('type')->where('id', $request->package_id)
        ->where('status', 1)
        ->whereHas('type', function ($query) {
            $query->where('name', 'promotional_video');
        })->first();

        if ($package->price > 0) {
            $data = $request->all();
            $data['ad_id'] = $ad->id;

            return response()->view('theme-views.sponsor.partials.redirect-payment-post', [
                'route' => route('payment.method'),
                'data'  => $data,
            ]);
        }
        
        $ad->sponsor()->create([
            'ad_id' => $ad->id,
            'type' => $package->type->name,
            'price' => $package->price,
            'package_id' => $package->id,
            'duration_in_days' => $package->duration_in_days,
            'is_paid' => 1,
            'expiration_date' => now()->addDays($package->duration_in_days),
            'payment_transaction_id' => null,
            'video_id' => session('video_id'),
        ]);

        Toastr::success(translate('promotional_video_added_successfully'));
        return redirect()->route('home');

    }

    public function data() {

        $user_ads_sponsor = Ad::with('sponsor')->whereHas('sponsor')
        ->where('user_id', auth('customer')->id())->get();

        return view('theme-views.sponsor.data', compact('user_ads_sponsor'));
    }

    public function createUploadUrl(Request $request)     
    {         
        $muxTokenId = BusinessSetting::where('type', 'mux_api_token')->value('value');
        $muxTokenSecret = BusinessSetting::where('type', 'mux_secret_key')->value('value');
        
        if (!$muxTokenId || !$muxTokenSecret) {            
            return response()->json([                 
                'success' => false,                 
                'error' => 'Mux credentials not configured'             
            ], 500);         
        }          
        
        try {             
            // Create direct upload in Mux with proper CORS settings
            $response = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                ->withHeaders([                 
                    'Content-Type' => 'application/json'             
                ])->post("https://api.mux.com/video/v1/uploads", [               
                    'new_asset_settings' => [
                        'playback_policy' => ['public']
                    ],
                    'cors_origin' => request()->getSchemeAndHttpHost(), // Use actual domain
                    'timeout' => 3600
                ]);    
            
            if ($response->successful()) {                 
                $uploadData = $response->json();                 
                $uploadId = $uploadData['data']['id'];
                $uploadUrl = $uploadData['data']['url'];
                
                // Return the response with upload URL                 
                return response()->json([                     
                    'success' => true,                     
                    'data' => [                         
                        'url' => $uploadUrl,                         
                        'id' => $uploadId,                         
                        'upload_id' => $uploadId,                         
                        'access_key' => ''  // Mux doesn't need access key                   
                    ]                 
                ]);             
            } else {                 
                return response()->json([                     
                    'success' => false,                     
                    'error' => 'Failed to create upload: ' . $response->body()           
                ], 500);             
            }                              
        } catch (\Exception $e) {             
            return response()->json([                 
                'success' => false,                 
                'error' => $e->getMessage()             
            ], 500);         
        }     
    }

    public function getVideoUrl(Request $request)
    {
        $uploadId = $request->input('upload_id');
        
        if (!$uploadId) {
            return response()->json([
                'success' => false,
                'error' => 'Upload ID is required'
            ], 400);
        }

        $muxTokenId = BusinessSetting::where('type', 'mux_api_token')->value('value');
        $muxTokenSecret = BusinessSetting::where('type', 'mux_secret_key')->value('value');

        try {
            // Get upload details from Mux
            $response = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                ->get("https://api.mux.com/video/v1/uploads/{$uploadId}");

            if ($response->successful()) {
                $uploadData = $response->json();
                
                // Check if upload is completed and asset is created
                if ($uploadData['data']['status'] !== 'asset_created') {
                    return response()->json([
                        'success' => false,
                        'error' => 'Video is still processing, please try again in a moment',
                        'status' => $uploadData['data']['status']
                    ], 202);
                }
                
                $assetId = $uploadData['data']['asset_id'];
                
                // Get asset details to check if it's ready
                $assetResponse = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                    ->get("https://api.mux.com/video/v1/assets/{$assetId}");
                
                if ($assetResponse->successful()) {
                    $assetData = $assetResponse->json();
                    
                    // Check if asset is ready for playback
                    if ($assetData['data']['status'] !== 'ready') {
                        return response()->json([
                            'success' => false,
                            'error' => 'Video is still processing, please try again in a moment',
                            'status' => $assetData['data']['status']
                        ], 202);
                    }
                    
                    $playbackId = $assetData['data']['playback_ids'][0]['id'];
                    
                    // Store video info in session
                    session(['playback_id' => $playbackId]);
                    session(['video_player_url' => "https://stream.mux.com/{$playbackId}"]);
                    session(['asset_id' => $assetId]);
                    
                    return response()->json([
                        'success' => true,
                        'video_url' => "https://stream.mux.com/{$playbackId}.m3u8"
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'error' => 'Failed to get asset details: ' . $assetResponse->body()
                    ], 500);
                }
                
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to get upload details: ' . $response->body()
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteVideo(Request $request)
    {
        $uploadId = $request->input('upload_id');
        
        if (!$uploadId) {
            return response()->json([
                'success' => false,
                'error' => 'Upload ID is required'
            ], 400);
        }

        $muxTokenId = BusinessSetting::where('type', 'mux_api_token')->value('value');
        $muxTokenSecret = BusinessSetting::where('type', 'mux_secret_key')->value('value');

        try {
            // Get upload to find associated asset
            $uploadResponse = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                ->get("https://api.mux.com/video/v1/uploads/{$uploadId}");
            
            if ($uploadResponse->successful()) {
                $uploadData = $uploadResponse->json();
                $assetId = $uploadData['data']['asset_id'] ?? null;
                
                // Delete the asset if it exists
                if ($assetId) {
                    $deleteResponse = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                        ->delete("https://api.mux.com/video/v1/assets/{$assetId}");
                    
                    if (!$deleteResponse->successful()) {
                        return response()->json([
                            'success' => false,
                            'error' => 'Failed to delete video: ' . $deleteResponse->body()
                        ], 500);
                    }
                }
            }
            
            // Clear session data
            session()->forget(['playback_id', 'video_player_url', 'asset_id']);
            
            return response()->json([
                'success' => true,
                'message' => 'Video deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function clearVideoSession(Request $request)
    {
        session()->forget(['playback_id', 'video_player_url', 'asset_id']);
        
        return response()->json([
            'success' => true,
            'message' => 'Session cleared'
        ]);
    }

    

}
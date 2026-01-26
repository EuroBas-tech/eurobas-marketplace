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
    

}
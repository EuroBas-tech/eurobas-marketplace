<?php

namespace App\Http\Controllers\Web;

use App\Model\Ad;
use App\Models\User;
use App\Model\Category;
use App\CPU\ImageManager;
use App\Model\PaidBanner;
use Illuminate\Http\Request;
use App\Model\ShippingAddress;
use App\Model\SubscriptionPackage;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Cache;

class PaidBannerController extends Controller
{
    
    public function index() {

        $user_banners = PaidBanner::where('user_id', auth('customer')->user()->id)
        ->orderBy('created_at', 'desc')
        ->paginate(15);

        return view('theme-views.paid-banners.index', compact('user_banners'));
    }

    public function create() {

        $packages = SubscriptionPackage::with('features')->where('status', 1)->whereHas('type', function ($query) {
            $query->where('name', 'promotional_banner');
        })->get();

        $user_ads = Ad::where('user_id', auth('customer')->id())->get();

        $categories = Category::get();

        return view("theme-views.paid-banners.create", compact('packages', 'user_ads', 'categories'));
    }

    public function store(Request $request) {
        
        $request->validate([
            'banner_image' => 'required|image',
            'package_id' => 'required|numeric|exists:subscription_packages,id',
        ]);

        if($request->redirect_to_ads && $request->redirect_to_ads == 'on') {
            if(is_numeric($request->ad_id)) {
                $ad = Ad::where('id', $request->ad_id)->where('user_id', auth('customer')->id())->first();

                if(!$ad) {
                    Toastr::error(translate('ad_not_found'));
                    return back();
                }
            }
        }

        $package = SubscriptionPackage::with('type')->where('id', $request->package_id)
        ->where('status', 1)
        ->whereHas('type', function ($query) {
            $query->where('name', 'promotional_banner');
        })->first();
        
        if($package->price > 0) {
            $data = $request->all();
            $data['ad_id'] = $ad->id ?? null;

            if ($request->hasFile('banner_image')) {
                $image = $request->file('banner_image');

                // Store temporarily in storage/app/tmp/
                $path = $image->store('tmp');

                // Save meta info in session
                session([
                    'banner_image_path' => $path,
                    'banner_image_name' => $image->getClientOriginalName(),
                    'banner_image_mime' => $image->getMimeType(),
                ]);
            }

            return response()->view('theme-views.sponsor.partials.redirect-payment-post', [
                'route' => route('payment.method'),
                'data'  => $data,
            ]);
        }
        
        if($package) {
            $paidBanner = new PaidBanner();
            $paidBanner->banner_url = isset($ad->slug) ? route('ads-show',$ad->slug) : null;
            $paidBanner->banner_image = ImageManager::upload('paid-banners/', 'webp', $request->file('banner_image'), null);
            $paidBanner->price = $package->price;
            $paidBanner->duration_in_days = $package->duration_in_days;
            $paidBanner->expiration_date = now()->addHours($package->duration_in_days * 24);
            $paidBanner->is_paid = 1;
            $paidBanner->user_id = auth('customer')->user()->id;
            $paidBanner->category_id = $request->category_id;
            $paidBanner->package_id = $request->package_id;
            $paidBanner->save();
        } else {
            Toastr::error(translate('something_went_wrong_in_the_selected_package_please_again_with_right_data'));
            return back();
        }

        Cache::forget('main_banners');
        
        Toastr::success(translate('banner_added_successfully'));
        return redirect()->route('home');

    }

    public function edit($id) {

        $packages = SubscriptionPackage::where('status', 1)->whereHas('type', function ($query) {
            $query->where('name', 'promotional_banner');
        })->get();

        $paid_banner = PaidBanner::where('user_id', auth('customer')->id())->findOrFail($id);
        $user_ads = Ad::where('user_id', auth('customer')->id())->get();
        
        $package_expiration_date = $paid_banner->expiration_date;

        $categories = Category::get();

        return view("theme-views.paid-banners.edit",
        compact('packages', 'paid_banner', 'package_expiration_date', 'user_ads', 'categories'));
    }

    public function update(Request $request) {

        $request->validate([
            'banner_image' => 'image',
            'banner_id' => 'required|exists:paid_banners,id',
            'package_id' => 'exists:subscription_packages,id',
        ]);

        if($request->redirect_to_ads && $request->redirect_to_ads == 'on') {
            if(is_numeric($request->ad_id)) {
                $ad = Ad::where('id', $request->ad_id)->where('user_id', auth('customer')->id())->first();

                if(!$ad) {
                    Toastr::error(translate('ad_not_found'));
                    return back();
                }
            }
        }
        
        $paidBanner = PaidBanner::with('package')->findOrFail($request->banner_id);

        $package = null;

        if ($request->filled('package_id')) {
            $package = SubscriptionPackage::with('type')
            ->where('id', $request->package_id)
            ->where('status', 1)
            ->whereHas('type', fn($query) => $query->where('name', 'promotional_banner'))
            ->first();
        }

        if (optional($paidBanner->expiration_date)->lt(now())) {
            if (empty($package)) {
                Toastr::error(translate('banner_expired_and_there_is_no_package_selected'));
                return back();
            }
        }
            
        if ($paidBanner->expiration_date && $paidBanner->expiration_date < now() && $package && $package->price > 0) {
            $data = $request->all();
            $data['ad_id'] = $ad->id ?? null;
            $data['banner_id'] = $paidBanner->id;

            if ($request->hasFile('banner_image')) {
                $image = $request->file('banner_image');

                session([
                    'banner_image_base64' => base64_encode(file_get_contents($image)),
                    'banner_image_name'   => $image->getClientOriginalName(),
                    'banner_image_mime'   => $image->getMimeType(),
                ]);
            }

            return response()->view('theme-views.sponsor.partials.redirect-payment-post', [
                'route' => route('payment.method'),
                'data'  => $data,
            ]);
        }

        $paidBanner->banner_url = isset($ad) && $ad->slug ? route('ads-show',$ad->slug) : $paidBanner->banner_url;
        $paidBanner->category_id = $request->category_id;

        if ($request->hasFile('banner_image')) {
            $paidBanner->banner_image = ImageManager::upload(
                'paid-banners/',
                'webp',
                $request->file('banner_image'),
                null
            );
        }

        if ($package) {
            $paidBanner->fill([
                'package_id'        => $request->package_id,
                'price'             => $package->price,
                'duration_in_days'  => $package->duration_in_days,
                'expiration_date'   => now()->addHours($package->duration_in_days * 24),
            ]);
        }

        $paidBanner->save();

        Cache::forget('main_banners');

        Toastr::success(translate('banner_updated_successfully'));

        return redirect()->route('home');

    }

    public function delete($id) {
        
        $banner = PaidBanner::where('user_id', auth('customer')->id())->findOrFail($id);

        $banner->delete();

        Cache::forget('main_banners');

        Toastr::success(translate('banner_deleted_successfully'));
        return back();


    }

}

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
        ->where('is_paid', 1)
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
            'banner_image' => 'required|image|max:4096',
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
                $banner_image_name = ImageManager::upload('paid-banners/', 'webp', $request->file('banner_image'), null);
                session(['banner_image_name' => $banner_image_name]);
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
        session(['home_slider_offset' => 0]); // Reset so user sees their new banner immediately
        
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
            'banner_image' => 'nullable|image|max:4096',
            'banner_id' => 'required|exists:paid_banners,id',
            'package_id' => 'nullable|exists:subscription_packages,id',
        ]);

        $paidBanner = PaidBanner::with('package')->findOrFail($request->banner_id);

        if ($paidBanner->user_id != auth('customer')->id()) {
            Toastr::error(translate('unauthorized_access'));
            return back();
        }

        $ad = null;
        if ($request->redirect_to_ads && $request->redirect_to_ads == 'on') {
            if (is_numeric($request->ad_id)) {
                $ad = Ad::where('id', $request->ad_id)->where('user_id', auth('customer')->id())->first();
                if (!$ad) {
                    Toastr::error(translate('ad_not_found'));
                    return back();
                }
            }
        }

        $package = null;
        if ($request->filled('package_id')) {
            $package = SubscriptionPackage::with('type')
                ->where('id', $request->package_id)
                ->where('status', 1)
                ->whereHas('type', fn($query) => $query->where('name', 'promotional_banner'))
                ->first();
        }

        // إذا كانت الباقة منتهية ولم يحدد باقة جديدة
        if (optional($paidBanner->expiration_date)->lt(now()) && empty($package)) {
            Toastr::error(translate('banner_expired_and_there_is_no_package_selected'));
            return back();
        }

        // التوجيه للدفع فقط إذا كانت الباقة منتهية واختار باقة مدفوعة جديدة
        if ($paidBanner->expiration_date < now() && $package && $package->price > 0) {
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

          // 1. تحديث رابط البنر بشكل صحيح (مع دعم إطفاء الزر)
         if ($request->redirect_to_ads == 'on' && isset($ad->slug)) {
         $paidBanner->banner_url = route('ads-show', $ad->slug);
         } elseif ($request->filled('banner_url')) {
         $paidBanner->banner_url = $request->banner_url;
          } else {
         // إزالة الرابط القديم عند إطفاء الزر
         $paidBanner->banner_url = null;
         }

        // 2. تحديث القسم فقط إذا أُرسل قسم جديد
        if ($request->filled('category_id')) {
            $paidBanner->category_id = $request->category_id;
        }

        // 3. تحديث الصورة فقط إذا تم رفع صورة جديدة
        if ($request->hasFile('banner_image')) {
            $paidBanner->banner_image = ImageManager::upload(
                'paid-banners/',
                'webp',
                $request->file('banner_image'),
                null
            );
        }

        // 4. تحديث الباقة وتمديد الوقت فقط إذا تم تحديد باقة جديدة وكانت الباقة القديمة منتهية
        if ($package && $paidBanner->expiration_date < now()) {
            $paidBanner->package_id = $package->id;
            $paidBanner->price      = $package->price;
            $paidBanner->duration_in_days = $package->duration_in_days;
            $paidBanner->expiration_date  = now()->addHours($package->duration_in_days * 24);
        }

        // حفظ التعديلات مع الحفاظ التام على package_id القديمة
        $paidBanner->save();
        Cache::forget('main_banners');
        session(['home_slider_offset' => 0]);
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

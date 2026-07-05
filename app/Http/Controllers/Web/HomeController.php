<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use App\Model\Cart;
use App\CPU\Helpers;
use App\Model\Brand;
use App\Model\Order;
use App\Model\Banner;
use App\Model\Coupon;
use App\Model\Review;
use App\Model\Seller;
use App\Model\Product;
use App\Model\Category;
use App\CPU\CartManager;
use App\Model\FlashDeal;
use App\CPU\OrderManager;
use App\Model\PaidBanner;
use App\Model\OrderDetail;
use App\CPU\ProductManager;
use App\Model\DealOfTheDay;
use App\Model\MostDemanded;
use App\Model\VehicleModel;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Model\PaymentRequest;
use App\Model\BusinessSetting;
use Illuminate\Support\Facades\DB;
use App\Model\UserCategoryInterest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HomeController extends Controller
{
    public function __construct(){}

    public function index()
    {
        
  $locale = app()->getLocale(); 

$home_categories = Cache::rememberForever('categories_' . $locale, function () use ($locale) {
    return Category::with(['translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }])
            ->where('home_status', true)
            ->priority()
            ->latest()
            ->take(16)
            ->get();
});
         

        $locale = app()->getLocale();

        $banners = Cache::rememberForever('main_banners', function () {
            return Banner::where('banner_type', 'Main Banner')
            ->where('published', 1)
            ->get();
        });

        // Case-insensitive match: supports both old ('En') and new ('en') lang codes
        $banner = $banners->first(function ($b) use ($locale) {
                return strtolower($b->lang) === strtolower($locale);
            })
            ?? $banners->firstWhere('lang', 'Both');

        // Pre-calculate text overlay values in Controller (avoids @php in blade)
        $bannerText = null;
        if ($banner && isset($banner->show_text) && $banner->show_text && ($banner->title || $banner->sub_title)) {
            $rtlLocales = ['ar','he','fa','ur','yi','ps','sd','ku'];
            $isRtl      = in_array($locale, $rtlLocales);
            $pos        = $banner->text_position ?? 'center';
            $size       = $banner->text_size     ?? 'large';
            $color      = $banner->text_color    ?? 'white';
            $colorMap   = ['white'=>'#ffffff','orange'=>'#FF6B35','blue'=>'#60B8FF','gold'=>'#FFD700'];
            $titleSizes = ['small'=>'clamp(20px,3.5vw,36px)','medium'=>'clamp(26px,4.5vw,48px)','large'=>'clamp(32px,5.5vw,64px)'];
            $subSizes   = ['small'=>'clamp(14px,2vw,20px)','medium'=>'clamp(16px,2.5vw,26px)','large'=>'clamp(18px,3vw,32px)'];
            $vAligns    = ['top'=>'flex-start','center'=>'center','bottom'=>'flex-end'];
            $bannerText = [
                'title'      => $banner->title,
                'sub_title'  => $banner->sub_title,
                'hexColor'   => $colorMap[$color]   ?? '#ffffff',
                'titleSize'  => $titleSizes[$size]  ?? 'clamp(18px,3vw,32px)',
                'subSize'    => $subSizes[$size]    ?? 'clamp(13px,2vw,20px)',
                'vAlign'     => $vAligns[$pos]      ?? 'center',
                'hPos'       => $isRtl ? 'right:0;left:auto;' : 'left:0;right:auto;',
                'tAlign'     => $isRtl ? 'right' : 'left',
                'dir'        => $isRtl ? 'rtl' : 'ltr',
            ];
        }

         $customerId = auth('customer')->id();
         $guestId    = $customerId ? null : Helpers::deviceId();
         $cacheKey   = 'user_interests_' . ($customerId ?? $guestId);
         $cacheTTL   = $customerId ? now()->addHours(2) : now()->addMinutes(10);

        $interestData = Cache::remember($cacheKey, $cacheTTL, function () use ($customerId, $guestId) {

         $query = \App\Model\UserCategoryInterest::query()
            ->when(
            $customerId,
            fn($q) => $q->where('user_id', $customerId),
            fn($q) => $q->where('guest_id', $guestId)
          );

          $interests = $query
          ->orderByDesc('score')
          ->get();

        return [
           'userInterests' => $interests,
           'favCategoryId' => optional($interests->first())->category_id
       ];
   });

       $userInterests = $interestData['userInterests'];
       $favCategoryId = $interestData['favCategoryId'];

        // Get total matching banners count
        $totalBanners = PaidBanner::with('package.features', 'category')
            ->whereHas('package.features', fn ($q) =>
                $q->where('name', 'show_on_home_page')
            )
            ->where('status', 1)
            ->where('is_paid', 1)
            ->where('expiration_date', '>', now())
            ->count();

        // If no banners or less than 10, just show what exists
        if ($totalBanners <= 10) {
            $paid_banners = PaidBanner::with('package.features', 'category')
                ->whereHas('package.features', fn ($q) =>
                    $q->where('name', 'show_on_home_page')
                )
                ->where('status', 1)
                ->where('is_paid', 1)
                ->where('expiration_date', '>', now())
                ->orderByRaw(
                    $favCategoryId
                        ? "category_id = {$favCategoryId} DESC"
                        : '1'
                )
                ->get();
        } else {
            // Get current offset from session (default 0) - separate session key
            $offset = session('home_slider_offset', 0);

            $orderRaw = $favCategoryId ? "category_id = {$favCategoryId} DESC" : '1';

            // How many banners remain from offset to end
            $remaining = $totalBanners - $offset;

            if ($remaining >= 10) {
                // Enough banners after offset, fetch normally
                $paid_banners = PaidBanner::with('package.features', 'category')
                    ->whereHas('package.features', fn ($q) =>
                        $q->where('name', 'show_on_home_page')
                    )
                    ->where('status', 1)
                    ->where('is_paid', 1)
                    ->where('expiration_date', '>', now())
                    ->orderByRaw($orderRaw)
                    ->offset($offset)
                    ->limit(10)
                    ->get();
            } else {
                // Not enough banners remaining — fetch the tail, then wrap around for the rest
                $tail = PaidBanner::with('package.features', 'category')
                    ->whereHas('package.features', fn ($q) =>
                        $q->where('name', 'show_on_home_page')
                    )
                    ->where('status', 1)
                    ->where('is_paid', 1)
                    ->where('expiration_date', '>', now())
                    ->orderByRaw($orderRaw)
                    ->offset($offset)
                    ->limit($remaining)
                    ->get();

                $needed = 10 - $remaining;

                $wrap = PaidBanner::with('package.features', 'category')
                    ->whereHas('package.features', fn ($q) =>
                        $q->where('name', 'show_on_home_page')
                    )
                    ->where('status', 1)
                    ->where('is_paid', 1)
                    ->where('expiration_date', '>', now())
                    ->orderByRaw($orderRaw)
                    ->offset(0)
                    ->limit($needed)
                    ->get();

                $paid_banners = $tail->concat($wrap);
            }

            // Calculate next offset (rotate when reaching end)
            $nextOffset = ($offset + 10) % $totalBanners;

            // Store for next page load
            session(['home_slider_offset' => $nextOffset]);
        }

        $decimal_point_settings = Helpers::get_business_settings('decimal_point_settings') ?? 0;
        $user = Helpers::get_customer();

        $now = now();

        /** ✅ تحميل الإعلانات بدون limit */
        $categories = Category::homeEnabled()
        ->with(['ads' => function ($q) use ($now) {
            $q->active()
            ->when(session('show_by_country'),
                fn ($qq) => $qq->country(session('show_by_country')['name'])
            )
            ->with(['brand', 'sponsor', 'wish_list'])
            ->latest();
        }])
        ->get();

        /** ✅ هنا نتحكم بالعدد والترتيب بدون كسر eager loading */
        $categories->each(function ($category) use ($now) {

            $ads = $category->ads->map(function ($ad) use ($now) {

                $ad->has_first_results = $ad->sponsor
                    ->where('type', 'appearance_in_first_results')
                    ->where('is_paid', 1)
                    ->where('expiration_date', '>', $now)
                    ->isNotEmpty() ? 1 : 0;
                    
                $ad->has_urgent_sale_sticker = $ad->sponsor
                    ->where('type', 'urgent_sale_sticker')
                    ->where('is_paid', 1)
                    ->where('expiration_date', '>', $now)
                    ->isNotEmpty() ? 1 : 0;

                return $ad;
            });

            $category->setRelation(
                'ads',
                $ads->sortByDesc('has_first_results')->take( 20)->values()
            );
        });

        $brands = Cache::rememberForever('brands', function () {
            return Brand::with('categories:id')
                ->orderBy('name')
                ->get()
                ->map(fn ($brand) => [
                    'id' => $brand->id,
                    'name' => $brand->name,
                    'image' => $brand->image,
                    'categories' => $brand->categories->pluck('id')->toArray(),
                ]);
        });

        $models = Cache::rememberForever('models', function () {
            return VehicleModel::with('categories:id')
                ->get()
                ->map(fn ($model) => [
                    'id' => $model->id,
                    'name' => $model->name,
                    'brand_id' => $model->brand_id,
                    'category_id' => $model->category_id,
                    'status' => $model->status,
                    'categories' => $model->categories->pluck('id')->toArray(),
                ]);
        });

        return view(
            VIEW_FILE_NAMES['home'],
            compact(
                'home_categories',
                'decimal_point_settings',
                'banner',
                'bannerText',
                'brands',
                'categories',
                'models',
                'paid_banners'
            )
        );

    }

}

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
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HomeController extends Controller
{
    public function __construct(){}

    public function index()
    {
        return self::theme_aster();
    }

    public function theme_aster()
{
    $home_categories = Cache::rememberForever('categories', function () {
        return Category::where('home_status', true)
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

    $banner = $banners->firstWhere('lang', $locale)
        ?? $banners->firstWhere('lang', 'Both');

        $paid_banners = PaidBanner::with('package.features')
            ->whereHas('package.features', fn ($q) =>
                $q->where('name', 'show_on_home_page')
            )
            ->where('status', 1)
            ->where('expiration_date', '>', now())
            ->where('is_paid', 1)
            ->limit(5);

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
                'brands',
                'categories',
                'models',
                'paid_banners'
            )
        );
    }


    public function loadBrands()
    {
        // Check if request is AJAX
        if (!request()->ajax()) {
            abort(404);
        }

        try {
            // Cache all brands already mapped
            $brands = Cache::rememberForever('brands', function () {
                return Brand::with('categories:id')->orderBy('name')->get()->map(function ($brand) {
                    return [
                        'id' => $brand->id,
                        'name' => $brand->name,
                        'image' => $brand->image,
                        'categories' => $brand->categories->pluck('id')->toArray(),
                    ];
                });
            });

            // Return the brands section as HTML
            return view('theme-views.partials._brands', compact('brands'))->render();
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load brands'], 500);
        }
    }




}

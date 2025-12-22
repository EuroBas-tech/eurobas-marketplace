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
    public function __construct(
        private Product      $product,
        private Order        $order,
        private OrderDetail  $order_details,
        private Category     $category,
        private Seller       $seller,
        private Review       $review,
        private DealOfTheDay $deal_of_the_day,
        private Banner       $banner,
        private MostDemanded $most_demanded,
    ){}

    public function index()
    {
        $theme_name = theme_root_path();

        return match ($theme_name) {
            'theme_aster' => self::theme_aster(),
        };
    }

     public function theme_aster()
{
    $now = now();
    $locale = session('local') ?? 'en';

    /**
     * ------------------------------------------------
     * Home Categories (Top section)
     * ------------------------------------------------
     */
    $home_categories = Cache::rememberForever('home_categories', function () {
        return Category::where('home_status', true)
            ->priority()
            ->latest()
            ->take(16)
            ->get();
    });

    /**
     * ------------------------------------------------
     * Banner
     * ------------------------------------------------
     */
    $banner = Cache::rememberForever("main_banner_{$locale}", function () use ($locale) {
        return Banner::where('banner_type', 'Main Banner')
            ->where('published', 1)
            ->whereIn('lang', [$locale, 'Both'])
            ->orderByRaw("lang = '{$locale}' DESC")
            ->first();
    });

    /**
     * ------------------------------------------------
     * Paid Banners
     * ------------------------------------------------
     */
    $paid_banners = Cache::remember('paid_banners', 300, function () {
        return PaidBanner::with('package.features')
            ->whereHas('package.features', function ($q) {
                $q->where('name', 'show_on_home_page');
            })
            ->where('status', 1)
            ->where('expiration_date', '>', now())
            ->get();
    });

    /**
     * ------------------------------------------------
     * Categories + Ads (OPTIMIZED 🔥)
     * ------------------------------------------------
     */
    $categories = Cache::remember('home_categories_ads', 300, function () use ($now) {

        return Category::homeEnabled()
            ->with(['ads' => function ($q) use ($now) {

                $q->active()
                  ->when(session('show_by_country'), function ($qq) {
                      $qq->country(session('show_by_country')['name']);
                  })
                  ->with([
                      'brand:id,name',
                      'wish_list',
                      'sponsor' => function ($sq) use ($now) {
                          $sq->where('expiration_date', '>', $now);
                      }
                  ])
                  ->withExists([
                      'sponsor as has_first_results' => function ($sq) use ($now) {
                          $sq->where('type', 'appearance_in_first_results')
                             ->where('expiration_date', '>', $now);
                      },
                      'sponsor as has_urgent_sale_sticker' => function ($sq) use ($now) {
                          $sq->where('type', 'urgent_sale_sticker')
                             ->where('expiration_date', '>', $now);
                      },
                  ])
                  ->orderByDesc('has_first_results')
                  ->latest()
                  ->limit(16);

            }])
            ->get();
    });

    /**
     * ------------------------------------------------
     * Brands
     * ------------------------------------------------
     */
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

    /**
     * ------------------------------------------------
     * Vehicle Models
     * ------------------------------------------------
     */
    $models = Cache::rememberForever('vehicle_models', function () {
        return VehicleModel::with('categories:id')
            ->where('status', 1)
            ->get()
            ->map(fn ($model) => [
                'id' => $model->id,
                'name' => $model->name,
                'brand_id' => $model->brand_id,
                'category_id' => $model->category_id,
                'categories' => $model->categories->pluck('id')->toArray(),
            ]);
    });

    /**
     * ------------------------------------------------
     * Settings
     * ------------------------------------------------
     */
    $decimal_point_settings = Helpers::get_business_settings('decimal_point_settings') ?? 0;

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

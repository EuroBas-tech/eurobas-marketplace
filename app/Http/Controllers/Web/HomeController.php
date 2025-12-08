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

        $theme_name = theme_root_path();
        $current_date = date('Y-m-d H:i:s');

        $home_categories = Cache::rememberForever('categories', function () {
            return Category::where('home_status', true)->priority()->latest()->take(16)->get();
        });

        $locale = LaravelLocalization::getCurrentLocale();

        $isBannerLocaleExist = $this->banner->where('lang', $locale)->exists();

        // Cache all banners
        $banners = Cache::rememberForever('main_banners', function () {
            return Banner::where('banner_type', 'Main Banner')
            ->where('published', 1)
            ->get();
        });

        // Get banner for current locale
        $banner = $banners->firstWhere('lang', $isBannerLocaleExist ? $locale : 'Both');

        $paid_banners = PaidBanner::with('package.features')->whereHas('package', function ($q) {
            $q->whereHas('features', function ($q2) {
                $q2->where('name', 'show_on_home_page');
            });
        })->where('status', 1)->where('expiration_date', '>', Carbon::now())->get();

        $decimal_point = Helpers::get_business_settings('decimal_point_settings');
        $decimal_point_settings = !empty($decimal_point) ? $decimal_point : 0;
        $user = Helpers::get_customer();

        $categories = Category::homeEnabled()->with([
            'ads' => function($q) {
                $q->with(['brand', 'sponsor', 'wish_list']);
            }
        ])->get();
        
        $now = Carbon::now();

        $categories->each(function ($category) use ($now) {

            // Get filtered ads with active scope and country filter
            $filteredAds = $category->ads()
                ->active()
                ->when(session('show_by_country'),
                    fn($query) => $query->country(session('show_by_country')['name'])
                )
                ->latest()
                ->get();    

            // Compute flags for each ad
            $filteredAds->each(function ($ad) use ($now) {

                $ad->has_urgent_sale_sticker = collect($ad->sponsor)
                    ->firstWhere('type', 'urgent_sale_sticker')
                    ?->expiration_date > $now ? 1 : 0;

                $ad->has_first_results = collect($ad->sponsor)
                    ->firstWhere('type', 'appearance_in_first_results')
                    ?->expiration_date > $now ? 1 : 0;
            });

            // Sort ads: first by has_first_results DESC, then keep other order
            // Take only 15 ads
            $sortedAds = $filteredAds->sortByDesc('has_first_results')->take(16)->values();
            
            // Set the relation with sorted ads
            $category->setRelation('ads', $sortedAds);
        });
        
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

        // Cache all vehicle models already mapped
        $models = Cache::rememberForever('models', function () {
            return VehicleModel::with('categories:id')->get()->map(function ($model) {
                return [
                    'id' => $model->id,
                    'name' => $model->name,
                    'brand_id' => $model->brand_id,
                    'category_id' => $model->category_id,
                    'status' => $model->status,
                    'categories' => $model->categories->pluck('id')->toArray(),
                ];
            });
        });

        return view(VIEW_FILE_NAMES['home'],compact('home_categories', 'decimal_point_settings','banner', 
        'brands','categories', 'models', 'paid_banners'));

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

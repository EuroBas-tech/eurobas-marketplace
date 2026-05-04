<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Model\Ad;
use App\Model\AdAuction;
use App\Model\AdView;
use App\Model\Category;
use App\Model\Wishlist;
use App\Model\UserCategoryInterest;
use App\Model\PaidBanner;
use App\CPU\Helpers;

class AdController extends Controller
{

    public function show($id)
    {
        $ad = Ad::active()
            ->with(['category', 'brand', 'model', 'sponsor'])
            ->findOrFail($id);

        // Track view
        $ip = request()->ip();
        $user_agent = request()->header('User-Agent');

        $is_already_viewed = AdView::where('ad_id', $ad->id)
            ->where('ip_address', $ip)
            ->where('user_agent', $user_agent)
            ->exists();

        if (!$is_already_viewed) {
            AdView::create([
                'ad_id'      => $ad->id,
                'ip_address' => $ip,
                'user_agent' => $user_agent,
            ]);
        }

        Helpers::trackUserCategoryInterest($ad->category_id);

        // Wishlist
        $countWishlist   = Wishlist::where('ad_id', $ad->id)->count();
        $wishlist_status = Wishlist::where([
            'ad_id'       => $ad->id,
            'customer_id' => auth('api')->id(),
        ])->exists();

        // Related ads
        $relatedAds = Ad::active()
            ->with(['category', 'brand', 'model'])
            ->where('model_id', $ad->model_id)
            ->whereKeyNot($ad->id)
            ->limit(12)
            ->get();

        // Promotional video
        $current_date = now();

        $ad_promotional_video = $ad->sponsor()
            ->where('type', 'promotional_video')
            ->where('expiration_date', '>=', $current_date)
            ->where('is_paid', 1)
            ->whereHas('video', fn($q) =>
                $q->where('is_video_suspended', 0)
                ->where('is_video_deleted', 0)
            )
            ->with('video')
            ->first();

        // Gallery
        $images = json_decode($ad->images);
        $gallery_images_number = is_array($images) ? count($images) + 1 : 1;
        if ($ad_promotional_video) { $gallery_images_number++; }

        // More ads from same user
        $more_ads_from_user = Ad::active()
            ->with(['category', 'brand', 'model'])
            ->withCount('reviews')
            ->where('id', '!=', $ad->id)
            ->where('user_id', $ad->user_id)
            ->latest()
            ->take(5)
            ->get();

        $ad_views_number = $ad->adViews()->count();

        // Paid banners
        $favCategoryId = $this->getUserFavoriteCategoryId();

        $bannerQuery = PaidBanner::with('package.features', 'category')
            ->whereHas('package', fn($q) =>
                $q->whereHas('features', fn($q2) =>
                    $q2->where('name', 'show_on_filter_and_ad_page')
                )
            )
            ->where('status', 1)
            ->where('is_paid', 1)
            ->where('expiration_date', '>', now());

        $totalBanners = (clone $bannerQuery)->count();

        if ($totalBanners <= 5) {
            $paid_banners = (clone $bannerQuery)
                ->when($favCategoryId, fn($q) => $q->orderByRaw('category_id = ? DESC', [$favCategoryId]))
                ->get();
        } else {
            $offset       = session('banner_offset', 0);
            $paid_banners = (clone $bannerQuery)
                ->when($favCategoryId, fn($q) => $q->orderByRaw('category_id = ? DESC', [$favCategoryId]))
                ->offset($offset)
                ->limit(5)
                ->get();

            session(['banner_offset' => ($offset + 5) % $totalBanners]);
        }

        // Empty-state flags
        $is_dimensions_and_sizes_empty = !$ad->height && !$ad->width && !$ad->length
            && !$ad->bag_capacity && !$ad->weight;

        $is_environmental_information_empty = !$ad->gas_emission_tax
            && !$ad->energy_source && !$ad->energy_consumption;

        $is_battery_information_empty = !$ad->battery_charging_time
            && !$ad->fast_battery_charging_time && !$ad->battery_life;

        $is_additional_information_empty = !$ad->previous_scan_date && !$ad->acceleration_0_100;

        return response()->json([
            'ad'                                 => $ad,
            'wishlist_status'                    => $wishlist_status,
            'count_wishlist'                     => $countWishlist,
            'related_ads'                        => $relatedAds,
            'ad_promotional_video'               => $ad_promotional_video,
            'gallery_images_number'              => $gallery_images_number,
            'more_ads_from_user'                 => $more_ads_from_user,
            'paid_banners'                       => $paid_banners,
            'ad_views_number'                    => $ad_views_number,
            'is_dimensions_and_sizes_empty'      => $is_dimensions_and_sizes_empty,
            'is_environmental_information_empty' => $is_environmental_information_empty,
            'is_battery_information_empty'       => $is_battery_information_empty,
            'is_additional_information_empty'    => $is_additional_information_empty,
        ], 200);
    }

    public function get_ads_by_category($id) {
        $category = Category::with('ads')->find($id);
        return response()->json($category, 200);
    }

    public function ads_filter(Request $request) {

        $query = Ad::active()->with(['sponsor', 'category', 'brand', 'model', 'user']);

        if ($request->color != 'all' && $request->color) {
            $query->where('color', $request->color);
        }

        $query = $this->ad_query_filter($query, $request);

        if ($request->city != '' && $request->city) {
            $coordinates = null;
            if ($request->filled('location_lat') && $request->filled('location_lng')) {
                $coordinates = ['latitude' => (float) $request->location_lat, 'longitude' => (float) $request->location_lng];
            } else {
                $coordinates = $this->getLocationCoordinates($request->city);
            }

            if ($coordinates) {
                $radius = ($request->radius != '') ? $request->radius : 25;
                $query = $this->getAdsInRadius($query, $radius, $coordinates['latitude'], $coordinates['longitude']);
            }
        }

        if ($request->status) {
            $query->whereIn('ad_status', $request->status);
        }

        if ($request->doors_number) {
            $query->whereIn('doors_number', $request->doors_number);
        }

        if ($request->seats_number) {
            $query->whereIn('seats_number', $request->seats_number);
        }

        if ($request->body_type) {
            $query->whereIn('body_type', $request->body_type);
        }

        if ($request->fuel_type) {
            $query->whereIn('fuel_type', $request->fuel_type);
        }

        if ($request->transmission_type) {
            $query->whereIn('transmission_type', $request->transmission_type);
        }

        if ($request['multiple_bicycle_type'] != 'all' && $request['multiple_bicycle_type']) {
            $query->whereIn('bicycle_type', $request['multiple_bicycle_type']);
        }

        if ($request['multiple_bicycle_size'] != 'all' && $request['multiple_bicycle_size']) {
            $query->whereIn('bicycle_size', $request['multiple_bicycle_size']);
        }

        if ($request['multiple_furniture_material'] != 'all' && $request['multiple_furniture_material']) {
            $query->whereIn('material', $request['multiple_furniture_material']);
        }

        if ($request['multiple_furniture_type'] != 'all' && $request['multiple_furniture_type']) {
            $query->whereIn('furniture_type', $request['multiple_furniture_type']);
        }

        if ($request['multiple_home_garden_material'] != 'all' && $request['multiple_home_garden_material']) {
            $query->whereIn('material', $request['multiple_home_garden_material']);
        }

        if ($request['multiple_shipbuilding_type'] != 'all' && $request['multiple_shipbuilding_type']) {
            $query->whereIn('shipbuilding_type', $request['multiple_shipbuilding_type']);
        }

        if ($request['multiple_engines_number'] != 'all' && $request['multiple_engines_number']) {
            $query->whereIn('engines_number', $request['multiple_engines_number']);
        }

        if ($request['multiple_cabins_number'] != 'all' && $request['multiple_cabins_number']) {
            $query->whereIn('cabins_number', $request['multiple_cabins_number']);
        }

        if ($request['multiple_usage'] != 'all' && $request['multiple_usage']) {
            $query->whereIn('usage_type', $request['multiple_usage']);
        }

        if ($request['multiple_machine_type'] != 'all' && $request['multiple_machine_type']) {
            $query->whereIn('machine_type', $request['multiple_machine_type']);
        }

        if ($request['multiple_power_source'] != 'all' && $request['multiple_power_source']) {
            $query->whereIn('power_source', $request['multiple_power_source']);
        }

        if ($request['multiple_home_appliance_type'] != 'all' && $request['multiple_home_appliance_type']) {
            $query->whereIn('home_appliance_type', $request['multiple_home_appliance_type']);
        }

        if ($request['multiple_listing_type'] != 'all' && $request['multiple_listing_type']) {
            $query->whereIn('listing_type', $request['multiple_listing_type']);
        }

        if ($request['multiple_property_type'] != 'all' && $request['multiple_property_type']) {
            $query->whereIn('property_type', $request['multiple_property_type']);
        }

        if ($request['multiple_floor'] != 'all' && $request['multiple_floor']) {
            $query->whereIn('floor', $request['multiple_floor']);
        }

        if ($request['multiple_electronic_type'] != 'all' && $request['multiple_electronic_type']) {
            $query->whereIn('electronic_type', $request['multiple_electronic_type']);
        }

        if ($request->length) {
            $query->where('length', $request->length);
        }

        if ($request->width) {
            $query->where('width', $request->width);
        }

        if ($request->height) {
            $query->where('height', $request->height);
        }

        if ($request->max_weight) {
            $query->where('max_weight', $request->max_weight);
        }

        if ($request->bag_capacity) {
            $query->where('bag_capacity', $request->bag_capacity);
        }

        if ($request->battery_charging_time) {
            $query->where('battery_charging_time', $request->battery_charging_time);
        }

        if ($request->fast_battery_charging_time) {
            $query->where('fast_battery_charging_time', $request->fast_battery_charging_time);
        }

        if ($request->battery_life) {
            $query->where('battery_life', $request->battery_life);
        }

        if ($request->acceleration_0_100) {
            $query->where('acceleration_0_100', $request->acceleration_0_100);
        }

        if ($request->min_mileage && $request->max_mileage) {
            $query->whereBetween('mileage', [$request['min_mileage'], $request['max_mileage']]);
        } elseif ($request->min_mileage) {
            $query->where('mileage', '>=', $request['min_mileage']);
        } elseif ($request->max_mileage) {
            $query->where('mileage', '<=', $request['max_mileage']);
        }

        $ads = $query->paginate(10);

        return response()->json($ads, 200);
    }

    public function ad_query_filter($query, $request) {
        if ($request['category_id'] != 'all' && $request['category_id']) {
            $query->where('category_id', $request['category_id']);
        }

        if ($request['brand_id'] != 'all' && $request['brand_id']) {
            $query->where('brand_id', $request['brand_id']);
        }

        if ($request['model_id'] != 'all' && $request['model_id']) {
            $query->where('model_id', $request['model_id']);
        }

        if ($request['bicycle_type'] != 'all' && $request['bicycle_type']) {
            $query->where('bicycle_type', $request['bicycle_type']);
        }

        if ($request['bicycle_size'] != 'all' && $request['bicycle_size']) {
            $query->where('bicycle_size', $request['bicycle_size']);
        }

        if ($request['country'] != 'All Europe' && $request['country']) {
            $query->where('country', $request['country']);
        }

        if ($request['furniture_material'] != 'all' && $request['furniture_material']) {
            $query->where('material', $request['furniture_material']);
        }

        if ($request['furniture_type'] != 'all' && $request['furniture_type']) {
            $query->where('furniture_type', $request['furniture_type']);
        }

        if ($request['home_garden_material'] != 'all' && $request['home_garden_material']) {
            $query->where('material', $request['home_garden_material']);
        }

        if ($request['shipbuilding_type'] != 'all' && $request['shipbuilding_type']) {
            $query->where('shipbuilding_type', $request['shipbuilding_type']);
        }

        if ($request['engines_number'] != 'all' && $request['engines_number']) {
            $query->where('engines_number', $request['engines_number']);
        }

        if ($request['cabins_number'] != 'all' && $request['cabins_number']) {
            $query->where('cabins_number', $request['cabins_number']);
        }

        if ($request['usage'] != 'all' && $request['usage']) {
            $query->where('usage_type', $request['usage']);
        }

        if ($request['machine_type'] != 'all' && $request['machine_type']) {
            $query->where('machine_type', $request['machine_type']);
        }

        if ($request['power_source'] != 'all' && $request['power_source']) {
            $query->where('power_source', $request['power_source']);
        }

        if ($request['home_appliance_type'] != 'all' && $request['home_appliance_type']) {
            $query->where('home_appliance_type', $request['home_appliance_type']);
        }

        if ($request['listing_type'] != 'all' && $request['listing_type']) {
            $query->where('listing_type', $request['listing_type']);
        }

        if ($request['property_type'] != 'all' && $request['property_type']) {
            $query->where('property_type', $request['property_type']);
        }

        if ($request['floor'] != 'all' && $request['floor']) {
            $query->where('floor', $request['floor']);
        }

        if ($request['electronic_type'] != 'all' && $request['electronic_type']) {
            $query->where('electronic_type', $request['electronic_type']);
        }

        // Parameterized price filtering (fixes SQL injection)
        $minPrice = $request->min_price;
        $maxPrice = $request->max_price;

        if ($minPrice || $maxPrice) {
            $query->where(function ($q) use ($minPrice, $maxPrice) {
                $q->where(function ($sub) use ($minPrice, $maxPrice) {
                    $sub->whereIn('price_type', ['fixed_price', 'asking_price']);
                    if ($minPrice && $maxPrice) {
                        $sub->whereBetween('price', [$minPrice, $maxPrice]);
                    } elseif ($minPrice) {
                        $sub->where('price', '>=', $minPrice);
                    } elseif ($maxPrice) {
                        $sub->where('price', '<=', $maxPrice);
                    }
                })->orWhere(function ($sub) use ($minPrice, $maxPrice) {
                    $sub->where('price_type', 'auction');
                    if ($minPrice && $maxPrice) {
                        $sub->whereBetween('starting_price', [$minPrice, $maxPrice]);
                    } elseif ($minPrice) {
                        $sub->where('starting_price', '>=', $minPrice);
                    } elseif ($maxPrice) {
                        $sub->where('starting_price', '<=', $maxPrice);
                    }
                });
            });
        }

        // Filter by construction year
        if ($request->min_construction_year && $request->max_construction_year) {
            $query->whereBetween('year', [$request['min_construction_year'], $request['max_construction_year']]);
        } elseif ($request->min_construction_year) {
            $query->where('year', '>=', $request['min_construction_year']);
        } elseif ($request->max_construction_year) {
            $query->where('year', '<=', $request['max_construction_year']);
        }

        return $query;
    }

    public function getLocationCoordinates($city) {

        $apiKey = Helpers::get_business_settings('map_api_key_server');

        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $city,
            'key' => $apiKey
        ]);

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();

        if ($data['status'] !== 'OK' || empty($data['results'])) {
            return null;
        }

        $location = $data['results'][0]['geometry']['location'];

        return [
            'latitude' => $location['lat'],
            'longitude' => $location['lng'],
        ];

    }

    public function getAdsInRadius($query, $radius, $latitude, $longitude)
    {
        $query->withinRadius($latitude, $longitude, $radius);
        return $query;
    }

    public function store_auction(Request $request)
    {
        if (Helpers::prevent_if_profile_incomplete()) {
            return response()->json([
                'message' => translate('you_must_complete_your_profile_first_to_be_able_to_make_an_offer')
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'id'    => 'required',
            'price' => 'required|numeric|min:0|max:10000000000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }

        $ad = Ad::active()->with('auctions')->find($request->id);

        if (!$ad) {
            return response()->json([
                'message' => translate('ad_not_found')
            ], 404);
        }

        if ($ad->auctions->contains('user_id', auth('api')->id())) {
            return response()->json([
                'message' => translate('you_already_send_an_offer_to_this_ad')
            ], 409);
        }

        $last_auction_price = $ad->auctions->count() > 0
            ? $ad->auctions->sortByDesc('created_at')->first()->price
            : ($ad->starting_price ?? 0);

        if ($request->price <= $last_auction_price) {
            return response()->json([
                'message' => translate('the_offer_price_must_be_greater_than_the_starting_price_or_the_last_offer_price')
            ], 422);
        }

        $auction = AdAuction::create([
            'ad_id'   => $ad->id,
            'user_id' => auth('api')->id(),
            'price'   => $request->price,
        ]);

        return response()->json([
            'message' => translate('offer_sended_successfully'),
            'data'    => $auction,
        ], 201);
    }

    private function getUserFavoriteCategoryId(): ?int
    {
        $column = auth('api')->check() ? 'user_id' : 'guest_id';
        $value = auth('api')->check() ? auth('api')->id() : Helpers::deviceId();

        return UserCategoryInterest::where($column, $value)
            ->orderByDesc('score')
            ->value('category_id');
    }

}

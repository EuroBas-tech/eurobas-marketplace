<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\Ad;
use App\Model\AdAuction;
use App\Model\AdAskingPrice;
use App\Model\AdReport;
use App\Model\AdView;
use App\Model\Brand;
use App\Model\VehicleModel;
use App\Model\ListValue;
use App\Model\Category;
use App\Model\Chatting;
use App\Model\Wishlist;
use App\Model\BusinessSetting;
use App\Model\SponsoredAd;
use App\Model\SubscriptionPackage;
use App\Model\UserCategoryInterest;
use App\Model\PaidBanner;
use App\User;
use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\CPU\BackEndHelper;
use function App\CPU\specificTranslate;

class AdController extends Controller
{

    public function show($id)
    {
        $ad = Ad::active()
            ->with([
                'category', 'brand', 'model', 'sponsor', 'user',
                'auctions.user'    => fn($q) => $q->select('id', 'name', 'image'),
                'askingPrice.user' => fn($q) => $q->select('id', 'name', 'image'),
            ])
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

        // Offer panels (parity with the website's auction / asking-price lists)
        $auctions = $ad->auctions->sortByDesc('created_at')->map(fn($a) => [
            'id'         => $a->id,
            'user_id'    => $a->user_id,
            'name'       => $a->user->name ?? null,
            'image'      => $a->user->image ?? null,
            'price'      => $a->price,
            'created_at' => $a->created_at,
        ])->values();

        $asking_price = $ad->askingPrice->sortByDesc('created_at')->map(fn($a) => [
            'id'         => $a->id,
            'user_id'    => $a->user_id,
            'name'       => $a->user->name ?? null,
            'image'      => $a->user->image ?? null,
            'price'      => $a->price,
            'created_at' => $a->created_at,
        ])->values();

        // Build the redacted public seller, then drop the raw user relation so the
        // seller's email/phone/location/tokens are not leaked via `ad.user`.
        $seller = Helpers::publicSellerProfile($ad->user);
        $ad->unsetRelation('user');

        return response()->json([
            'ad'                                 => $ad,
            'seller'                             => $seller,
            'auctions'                           => $auctions,
            'asking_price'                       => $asking_price,
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

    public function get_ads_by_category(Request $request, $id) {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => translate('category_not_found')], 404);
        }

        Helpers::trackUserCategoryInterest($category->id);

        $now = now();

        $ads = Ad::active()
            ->with(['category', 'brand', 'model', 'sponsor', 'user' => fn($q) => $q->select('id', 'name', 'image')])
            ->where('category_id', $category->id)
            // sponsored "appearance in first results" ads first, then newest
            ->orderByDesc(
                SponsoredAd::selectRaw('1')
                    ->whereColumn('sponsored_ads.ad_id', 'ads.id')
                    ->where('type', 'appearance_in_first_results')
                    ->where('is_paid', 1)
                    ->where('expiration_date', '>', $now)
                    ->limit(1)
            )
            ->latest()
            ->paginate($request->input('limit', 10));

        return response()->json([
            'category'  => $category,
            'ads'       => $ads,
        ], 200);
    }

    public function ads_filter(Request $request) {
        // Stable, deterministic order so paginated pages never overlap or skip
        // rows (an unordered query returns rows in an undefined order that can
        // shift between page fetches — causing duplicate keys on the client).
        return response()->json(
            $this->buildAdsFilterQuery($request)->orderByDesc('id')->paginate($request->input('limit', 10)),
            200
        );
    }

    public function filter_count(Request $request) {
        return response()->json(['count' => $this->buildAdsFilterQuery($request)->count()], 200);
    }

    private function buildAdsFilterQuery(Request $request) {

        $query = Ad::active()->with(['sponsor', 'category', 'brand', 'model', 'user' => fn($q) => $q->select('id', 'name', 'image')]);

        // Public seller profile: let the filter scope to a single seller's ads (§6.2)
        if ($request->filled('profile_id') || $request->filled('user_id')) {
            $query->where('user_id', $request->input('profile_id', $request->input('user_id')));
        }

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

        return $query;
    }

    public function ad_query_filter($query, $request) {
        // Free-text search from the mobile app's search box. Matches the listing
        // title, or the brand / model name. Accepts `search` (mobile) or `title`
        // (web parity); no-op when empty, so existing callers are unaffected.
        $keyword = trim((string) ($request->input('search') ?? $request->input('title') ?? ''));
        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$keyword}%"))
                  ->orWhereHas('model', fn($m) => $m->where('name', 'like', "%{$keyword}%"));
            });
        }

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

        // new + save (the model is fully guarded — no mass assignment).
        $auction = new AdAuction();
        $auction->ad_id   = $ad->id;
        $auction->user_id = auth('api')->id();
        $auction->price   = $request->price;
        $auction->save();

        // Parity with the website: the bid also lands in the seller's inbox as a chat message.
        $this->createOfferChatMessage($ad, $request->price);

        return response()->json([
            'message' => translate('offer_sended_successfully'),
            'data'    => $auction,
        ], 201);
    }

    /**
     * Write the offer (auction bid / asking-price) into the seller's chat inbox,
     * mirroring Web\ChattingController@messages_store so the seller sees the offer.
     */
    private function createOfferChatMessage(Ad $ad, $offer_price): void
    {
        $buyer  = auth('api')->user();
        $seller = $ad->relationLoaded('user') && $ad->user ? $ad->user : User::find($ad->user_id);

        if (!$seller || !$buyer || $seller->id == $buyer->id) {
            return;
        }

        $message_language = ($seller->native_language && $buyer->native_language
            && $seller->native_language == $buyer->native_language)
            ? $buyer->native_language : 'en';

        $message =
            specificTranslate('dear', $message_language) . ' ' . $seller->f_name . ",<br>" .
            specificTranslate('i_would_like_to_offer', $message_language) . ' ' .
            BackEndHelper::set_currency($ad->currency) . $offer_price . ' ' .
            specificTranslate('for_your_listing', $message_language) . ' "' . $ad->title . "\".<br>" .
            specificTranslate('i_look_forward_to_hearing_from_you', $message_language) . ",<br>" .
            specificTranslate('kind_regards', $message_language) . ",<br>" .
            $buyer->f_name . ' ' . $buyer->l_name;

        Chatting::create([
            'sender_id'   => $buyer->id,
            'receiver_id' => $seller->id,
            'message'     => $message,
            'attachment'  => json_encode([]),
            'ad_id'       => $ad->id,
            'seen'        => 0,
            'created_at'  => now(),
        ]);
    }

    private function getUserFavoriteCategoryId(): ?int
    {
        $column = auth('api')->check() ? 'user_id' : 'guest_id';
        $value = auth('api')->check() ? auth('api')->id() : Helpers::deviceId();

        return UserCategoryInterest::where($column, $value)
            ->orderByDesc('score')
            ->value('category_id');
    }

    // ─── LISTING LIFECYCLE (§3) ──────────────────────────────────────────

    /**
     * Form bootstrap for the post/edit-ad flow. Mirrors Web\AdController@add.
     * GET v1/ads/create-options?category_id=
     */
    public function create_options(Request $request)
    {
        $selected_category = $request->filled('category_id') ? Category::find($request->category_id) : null;

        $categories = Category::where('position', 1)
            ->when($selected_category, fn($q) => $q->where('category_type', $selected_category->category_type))
            ->get();

        $brands = Brand::orderBy('name', 'ASC')->get()->map(fn($brand) => [
            'id'         => $brand->id,
            'name'       => $brand->name,
            'image'      => $brand->image,
            'categories' => $brand->categories->pluck('id')->toArray(),
        ]);

        $models = VehicleModel::with('categories:id')
            ->select('id', 'name', 'brand_id', 'category_id', 'status')
            ->get()
            ->map(fn($model) => [
                'id'         => $model->id,
                'name'       => $model->name,
                'brand_id'   => $model->brand_id,
                'category_id'=> $model->category_id,
                'status'     => $model->status,
                'categories' => $model->categories->pluck('id')->toArray(),
            ]);

        $packages = SubscriptionPackage::with('type')
            ->where('status', 1)
            ->whereHas('type', fn($q) => $q->whereIn('name', [
                'appearance_in_first_results', 'urgent_sale_sticker', 'promotional_video',
            ]))
            ->get();

        return response()->json([
            'categories'                  => $categories,
            'brands'                      => $brands,
            'models'                      => $models,
            'fields'                      => $this->categoryFieldDefinitions(),
            'sponsor_packages' => [
                'appearance_in_first_results' => $packages->where('type.name', 'appearance_in_first_results')->values(),
                'urgent_sale_sticker'         => $packages->where('type.name', 'urgent_sale_sticker')->values(),
                'promotional_video'           => $packages->where('type.name', 'promotional_video')->values(),
            ],
            'limits' => [
                'ad_images_size'                       => BusinessSetting::where('type', 'ad_images_size')->value('value'),
                'maximum_ad_images_number'             => BusinessSetting::where('type', 'maximum_ad_images_number')->value('value'),
                'maximum_promotional_video_duration'   => BusinessSetting::where('type', 'maximum_promotional_video_duration')->value('value'),
                'maximum_promotional_video_size'       => BusinessSetting::where('type', 'maximum_promotional_video_size')->value('value'),
            ],
        ], 200);
    }

    /**
     * Per-category attribute field definitions + allowed values, built from
     * the ListAttribute / ListValue records (so values are backend-driven and
     * the app no longer hard-codes them). GET v1/categories/{id}/fields
     */
    public function category_fields($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => translate('category_not_found')], 404);
        }

        return response()->json([
            'category'      => ['id' => $category->id, 'name' => $category->name],
            'category_type' => $category->category_type,
            'fields'        => $this->categoryFieldDefinitions(),
        ], 200);
    }

    /**
     * Attribute => allowed values, grouped from the lists_values dictionary.
     */
    private function categoryFieldDefinitions(): array
    {
        return Cache::remember('api_list_values_grouped', now()->addHours(6), function () {
            return ListValue::with(['list:id,name'])
                ->select('id', 'value', 'list_attribute_id', 'priority')
                ->orderBy('priority')
                ->get()
                ->groupBy(fn($item) => $item->list->name ?? 'unknown')
                ->map(fn($values) => $values->map(fn($v) => [
                    'id'       => $v->id,
                    'value'    => $v->value,
                    'priority' => $v->priority,
                ])->values())
                ->toArray();
        });
    }

    /**
     * POST v1/ads — create a listing. Mirrors Web\AdController@store.
     */
    public function store(Request $request)
    {
        if (Helpers::prevent_if_profile_incomplete()) {
            return response()->json([
                'success' => false,
                'message' => translate('you_must_complete_your_profile_first_to_be_able_to_post_an_ad'),
            ], 403);
        }

        $ad_images_size = BusinessSetting::where('type', 'ad_images_size')->value('value') ?? 4;

        $validator = Validator::make($request->all(), [
            'title'                => 'required',
            'description'          => 'required',
            'category_id'          => 'required',
            'price_type'           => 'required',
            'image'                => 'required|image|max:' . ((int) $ad_images_size * 1024) . '|dimensions:max_width=4500,max_height=4500',
            'images.*'             => 'nullable|image|max:' . ((int) $ad_images_size * 1024) . '|dimensions:max_width=4500,max_height=4500',
            'price'                => $request->price_type == 'fixed_price' || $request->price_type == 'asking_price' ? 'required|numeric|min:0|max:10000000000' : '',
            'contact_phone_number' => $request->show_phone_number && $request->show_phone_number == 'on' ? 'required|numeric' : '',
            'currency'             => 'required',
            'country'              => 'required',
            'city'                 => 'required',
        ], [
            'image.max' => translate('Maximum file size is') . ' ' . $ad_images_size . ' ' . translate('mb'),
            'image.dimensions' => translate('Image dimensions are too large. Please use a smaller image'),
            'images.*.max' => translate('Maximum file size is') . ' ' . $ad_images_size . ' ' . translate('mb'),
            'images.*.dimensions' => translate('Image dimensions are too large. Please use a smaller image'),
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        $selected_category = Category::find($request->category_id);
        if ($selected_category && $selected_category->is_vehicle == 1 && !$request->year) {
            return response()->json(['success' => false, 'errors' => [translate('Vehicle year is required')]], 422);
        }

        $ad = new Ad();
        $ad->user_id = auth('api')->id();
        $ad->title   = $request->title;
        $ad->slug    = Str::slug($ad->title, '-') . '-' . Str::random(6);

        $ad_images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image && $image->isValid()) {
                    $ad_images[] = ImageManager::upload('ad/', 'webp', $image, 'def.jpg');
                }
            }
        }
        $ad->images = json_encode($ad_images);

        if ($request->hasFile('image')) {
            $ad->thumbnail = ImageManager::upload('ad/thumbnail/', 'webp', $request->file('image'), 'def.jpg');
        }

        $this->fillAdFromRequest($ad, $request);

        $ad->status = 0;
        $ad->save();

        // Attach sponsor packages. Free packages activate immediately; paid ones
        // are created unpaid and returned in `payment` for the app to checkout (§4).
        $payment = $this->attachSponsorPackages($ad, $request);

        // Website parity (Web\AdController@store): publish the listing immediately
        // only when nothing needs paying. If a paid promotion is attached, the
        // listing stays unpublished (status 0) until payment succeeds — at which
        // point PaymentController publishes it (mirrors Multiple*Payment@executePayment).
        $with_payment = count($payment) > 0;
        $ad->status = $with_payment ? 0 : 1;
        $ad->save();

        return response()->json([
            'success'      => true,
            'with_payment' => $with_payment,
            'message'      => $with_payment
                ? translate('the_ad_has_been_created_complete_the_payment_to_publish_it')
                : translate('the_ad_has_been_published_successfully'),
            'ad'           => $ad->load(['category', 'brand', 'model', 'sponsor']),
            'payment'      => $payment,
        ], 201);
    }

    /**
     * PUT/POST v1/ads/{id} — update own listing. Mirrors Web\AdController@update.
     */
    public function update(Request $request, $id)
    {
        if (Helpers::prevent_if_profile_incomplete()) {
            return response()->json([
                'success' => false,
                'message' => translate('you_must_complete_your_profile_first_to_be_able_to_post_an_ad'),
            ], 403);
        }

        $ad = Ad::where('user_id', auth('api')->id())->find($id);
        if (!$ad) {
            return response()->json(['success' => false, 'message' => translate('ad_not_found')], 404);
        }

        $ad_images_size = BusinessSetting::where('type', 'ad_images_size')->value('value') ?? 4;

        $validator = Validator::make($request->all(), [
            'title'                => 'required',
            'description'          => 'required',
            'category_id'          => 'required',
            'price_type'           => 'required',
            'image'                => 'nullable|image|max:' . ((int) $ad_images_size * 1024) . '|dimensions:max_width=4500,max_height=4500',
            'images.*'             => 'nullable|image|max:' . ((int) $ad_images_size * 1024) . '|dimensions:max_width=4500,max_height=4500',
            'price'                => $request->price_type == 'fixed_price' || $request->price_type == 'asking_price' ? 'required|numeric|min:0|max:10000000000' : '',
            'contact_phone_number' => $request->show_phone_number && $request->show_phone_number == 'on' ? 'required|numeric' : '',
            'currency'             => 'required',
            'country'              => 'required',
            'city'                 => 'required',
        ], [
            'image.max' => translate('Maximum file size is') . ' ' . $ad_images_size . ' ' . translate('mb'),
            'image.dimensions' => translate('Image dimensions are too large. Please use a smaller image'),
            'images.*.max' => translate('Maximum file size is') . ' ' . $ad_images_size . ' ' . translate('mb'),
            'images.*.dimensions' => translate('Image dimensions are too large. Please use a smaller image'),
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        $selected_category = Category::find($request->category_id);
        if ($selected_category && $selected_category->is_vehicle == 1 && !$request->year) {
            return response()->json(['success' => false, 'errors' => [translate('Vehicle year is required')]], 422);
        }

        $ad->title = $request->title;

        // Retain kept gallery images, then append newly uploaded ones.
        $ad_images = is_array($request->old_images) ? array_values($request->old_images) : [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image && $image->isValid()) {
                    $ad_images[] = ImageManager::upload('ad/', 'webp', $image, 'def.jpg');
                }
            }
        }
        $ad->images = json_encode($ad_images);

        if ($request->hasFile('image')) {
            $ad->thumbnail = ImageManager::upload('ad/thumbnail/', 'webp', $request->file('image'), 'def.jpg');
        }

        $this->fillAdFromRequest($ad, $request);
        $ad->save();

        return response()->json([
            'success' => true,
            'message' => translate('ad_updated_successfully'),
            'ad'      => $ad->load(['category', 'brand', 'model', 'sponsor']),
        ], 200);
    }

    /**
     * DELETE v1/ads/{id} — delete own listing.
     */
    public function destroy($id)
    {
        $ad = Ad::where('user_id', auth('api')->id())->find($id);
        if (!$ad) {
            return response()->json(['success' => false, 'message' => translate('ad_not_found')], 404);
        }

        // Best-effort image cleanup (skip shared default placeholder).
        if ($ad->thumbnail && $ad->thumbnail !== 'def.jpg') {
            ImageManager::delete('ad/thumbnail/' . $ad->thumbnail);
        }
        foreach ((array) json_decode($ad->images, true) as $img) {
            if ($img && $img !== 'def.jpg') {
                ImageManager::delete('ad/' . $img);
            }
        }

        $ad->delete();

        return response()->json(['success' => true, 'message' => translate('ad_deleted_successfully')], 200);
    }

    /**
     * Maps the (~60) request fields onto the Ad model. Shared by store/update,
     * mirroring the column assignments in Web\AdController.
     */
    private function fillAdFromRequest(Ad $ad, Request $request): void
    {
        $coords = $request->filled('city') ? $this->getLocationCoordinates($request->city) : null;

        $ad->title                     = $request->title;
        $ad->category_id               = $request->category_id;
        $ad->brand_id                  = $request->brand_id;
        $ad->description               = $request->description;
        $ad->model_id                  = $request->model_id;
        $ad->color                     = $request->color;
        $ad->ad_status                 = $request->status;
        $ad->fuel_type                 = $request->fuel_type;
        $ad->engine_size               = $request->engine_size;
        $ad->engine_cylinders          = $request->engine_cylinders;
        $ad->engine_power              = $request->engine_power;
        $ad->mileage                   = $request->mileage;
        $ad->year                      = $request->year;
        $ad->transmission_type         = $request->transmission_type;
        $ad->currency                  = $request->currency;
        $ad->price_type                = $request->price_type;

        $offers_on = $request->price_type == 'asking_price' && $request->allow_offers && $request->allow_offers == 'on';
        $ad->allow_offers              = $offers_on ? 1 : 0;
        $ad->first_price               = $offers_on ? $request->first_price : null;

        $ad->price                     = $request->price;
        $ad->starting_price            = $request->starting_price;
        $ad->body_type                 = $request->body_type;
        $ad->length                    = $request->length;
        $ad->width                     = $request->width;
        $ad->height                    = $request->height;
        $ad->show_phone_number         = $request->show_phone_number && $request->show_phone_number == 'on' ? 1 : 0;
        $ad->show_email_address        = $request->show_email_address && $request->show_email_address == 'on' ? 1 : 0;
        $ad->whatsapp_availability     = $request->whatsapp_availability && $request->whatsapp_availability == 'on' ? 1 : 0;
        $ad->phone_code                = $request->phone_code;
        $ad->contact_phone_number      = $request->contact_phone_number;
        $ad->city                      = $request->city;
        $ad->country                   = $request->country;
        $ad->latitude                  = $coords['latitude'] ?? $ad->latitude;
        $ad->longitude                 = $coords['longitude'] ?? $ad->longitude;
        $ad->postal_code               = $request->postal_code;
        $ad->max_weight                = $request->max_weight;
        $ad->bag_capacity              = $request->bag_capacity;
        $ad->doors_number              = $request->doors_number;
        $ad->seats_number              = $request->seats_number;
        $ad->co2_emissions             = $request->co2_emissions;
        $ad->energy_consumption        = $request->energy_consumption;
        $ad->gas_emission_tax          = $request->gas_emission_tax;
        $ad->previous_scan_date        = $request->previous_scan_date;
        $ad->battery_charging_time     = $request->battery_charging_time;
        $ad->fast_battery_charging_time= $request->fast_battery_charging_time;
        $ad->battery_life              = $request->battery_life;
        $ad->acceleration_0_100        = $request->acceleration_0_100;
        $ad->options                   = json_encode($request->options);
        $ad->furniture_type            = $request->furniture_type;
        $ad->material                  = $request->material;
        $ad->listing_type              = $request->listing_type;
        $ad->property_type             = $request->property_type;
        $ad->property_size             = $request->property_size;
        $ad->floor                     = $request->floor;
        $ad->rooms_number              = $request->rooms_number;
        $ad->machine_type              = $request->machine_type;
        $ad->manufacturer              = $request->manufacturer;
        $ad->power_capacity            = $request->power_capacity;
        $ad->power_source              = $request->power_source;
        $ad->custom_brand              = $request->custom_brand;
        $ad->electronic_type           = $request->electronic_type;
        $ad->bicycle_type              = $request->bicycle_type;
        $ad->bicycle_size              = $request->bicycle_size;
        $ad->home_appliance_type       = $request->home_appliance_type;
        $ad->usage_type                = $request->usage;
        $ad->maximum_speed             = $request->maximum_speed;
        $ad->engines_number            = $request->engines_number;
        $ad->cabins_number             = $request->cabins_number;
        $ad->beds_number               = $request->beds_number;
        $ad->shipbuilding_type         = $request->shipbuilding_type;
    }

    /**
     * Resolves attached sponsor packages, mirroring Web\AdController@store.
     * Returns the payment descriptors for any paid packages (price > 0).
     */
    private function attachSponsorPackages(Ad $ad, Request $request): array
    {
        $map = [
            'urgent_sale_sticker_sponsor'      => 'urgent_sale_sticker',
            'appear_on_first_results_sponsor'  => 'appearance_in_first_results',
            'promotional_video_sponsor'        => 'promotional_video',
        ];

        $payment = [];

        foreach ($map as $field => $type_name) {
            if (!$request->$field || !is_numeric($request->$field)) {
                continue;
            }

            $package = SubscriptionPackage::with('type')
                ->where('id', $request->$field)
                ->where('status', 1)
                ->whereHas('type', fn($q) => $q->where('name', $type_name))
                ->first();

            if (!$package) {
                continue;
            }

            $data = [
                'ad_id'                  => $ad->id,
                'type'                   => $package->type->name,
                'price'                  => $package->price,
                'package_id'             => $package->id,
                'duration_in_days'       => $package->duration_in_days,
                'expiration_date'        => now()->addHours($package->duration_in_days * 24),
            ];

            if ($type_name === 'promotional_video' && $request->filled('video_id')) {
                $data['video_id'] = $request->video_id;
            }

            if ($package->price > 0) {
                $data['is_paid'] = 0;
                $sponsor = $ad->sponsor()->create($data);
                $payment[] = [
                    'model_type' => 'sponsor',
                    'model_id'   => $sponsor->id,
                    'type'       => $package->type->name,
                    'price'      => $package->price,
                ];
            } else {
                $data['is_paid'] = 1;
                $data['payment_transaction_id'] = null;
                $ad->sponsor()->create($data);
            }
        }

        return $payment;
    }

    // ─── OFFERS & REPORT (§5) ────────────────────────────────────────────

    /**
     * POST v1/ads/asking-price — place an asking-price offer (row + chat message).
     */
    public function store_asking_price(Request $request)
    {
        if (Helpers::prevent_if_profile_incomplete()) {
            return response()->json(['message' => translate('you_must_complete_your_profile_first_to_be_able_to_make_an_offer')], 403);
        }

        $validator = Validator::make($request->all(), [
            'ad_id' => 'required',
            'price' => 'required|numeric|min:0|max:10000000000',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $ad = Ad::active()->with(['askingPrice', 'user'])->find($request->ad_id);
        if (!$ad) {
            return response()->json(['message' => translate('ad_not_found')], 404);
        }

        if ($ad->askingPrice->count() && $ad->askingPrice->contains('user_id', auth('api')->id())) {
            return response()->json(['message' => translate('you_already_send_an_negotiate_price_to_this_ad')], 409);
        }

        $last_asking_price = $ad->askingPrice->count() > 0
            ? $ad->askingPrice()->latest()->value('price')
            : ($ad->starting_price ?: 0);

        if ($request->price < $last_asking_price) {
            return response()->json(['message' => translate('the_offer_price_must_be_greater_than_the_starting_price_or_the_last_offer_price')], 422);
        }

        // new + save (the model is fully guarded — no mass assignment).
        $asking_price = new AdAskingPrice();
        $asking_price->ad_id   = $ad->id;
        $asking_price->user_id = auth('api')->id();
        $asking_price->price   = $request->price;
        $asking_price->save();

        $this->createOfferChatMessage($ad, $request->price);

        return response()->json([
            'message' => translate('offer_sended_successfully'),
            'data'    => $asking_price,
        ], 201);
    }

    /**
     * DELETE v1/ads/auction/{id} — delete own auction bid.
     */
    public function delete_auction($id)
    {
        $auction = AdAuction::where('user_id', auth('api')->id())->find($id);
        if (!$auction) {
            return response()->json(['message' => translate('No such data found!')], 404);
        }
        $auction->delete();
        return response()->json(['message' => translate('offer_deleted_successfully')], 200);
    }

    /**
     * DELETE v1/ads/asking-price/{id} — delete own asking-price offer.
     */
    public function delete_asking_price($id)
    {
        $asking_price = AdAskingPrice::where('user_id', auth('api')->id())->find($id);
        if (!$asking_price) {
            return response()->json(['message' => translate('No such data found!')], 404);
        }
        $asking_price->delete();
        return response()->json(['message' => translate('offer_deleted_successfully')], 200);
    }

    /**
     * POST v1/ads/report — report an ad. Mirrors Web\AdController@report_ad.
     */
    public function report(Request $request)
    {
        if (Helpers::prevent_if_profile_incomplete()) {
            return response()->json(['message' => translate('you_must_complete_your_profile_first_to_be_able_to_report_ads')], 403);
        }

        $validator = Validator::make($request->all(), [
            'id'      => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $ad = Ad::active()->find($request->id);
        if (!$ad) {
            return response()->json(['message' => translate('ad_not_found')], 404);
        }

        if ($ad->user_id == auth('api')->id()) {
            return response()->json(['message' => translate('you_cant_report_your_own_ad')], 403);
        }

        if (AdReport::where('ad_id', $request->id)->where('user_id', auth('api')->id())->exists()) {
            return response()->json(['message' => translate('you_already_reported_this_ad')], 409);
        }

        $report = new AdReport;
        $report->ad_id   = $request->id;
        $report->user_id = auth('api')->id();
        $report->message = $request->message;
        $report->save();

        return response()->json(['message' => translate('ad_reported_successfully')], 201);
    }

    // ─── BROWSE / DISCOVERY (§6.3) ───────────────────────────────────────

    /**
     * GET v1/ads/show-by-slug/{slug} — deep-link lookup by slug.
     */
    public function show_by_slug($slug)
    {
        $id = Ad::active()->where('slug', $slug)->value('id');
        if (!$id) {
            return response()->json(['message' => translate('ad_not_found')], 404);
        }
        return $this->show($id);
    }

    /**
     * GET v1/home — home feed: per-category ad rows (sponsored-first), ordered
     * by the viewer's category interest, plus home banners. Mirrors
     * Web\HomeController@index.
     */
    public function home(Request $request)
    {
        $now = now();

        $categories = Category::homeEnabled()->priority()
            ->with(['ads' => fn($q) => $q->active()->with(['brand', 'sponsor', 'wish_list'])->latest()])
            ->get();

        $categories->each(function ($category) use ($now) {
            $ads = $category->ads->map(function ($ad) use ($now) {
                $ad->has_first_results = $ad->sponsor
                    ->where('type', 'appearance_in_first_results')
                    ->where('is_paid', 1)
                    ->where('expiration_date', '>', $now)->isNotEmpty() ? 1 : 0;
                $ad->has_urgent_sale_sticker = $ad->sponsor
                    ->where('type', 'urgent_sale_sticker')
                    ->where('is_paid', 1)
                    ->where('expiration_date', '>', $now)->isNotEmpty() ? 1 : 0;
                return $ad;
            });
            $category->setRelation('ads', $ads->sortByDesc('has_first_results')->take(20)->values());
        });

        // Order categories by the viewer's interest (trending) signal.
        $column = auth('api')->check() ? 'user_id' : 'guest_id';
        $value  = auth('api')->check() ? auth('api')->id() : Helpers::deviceId();
        $scores = UserCategoryInterest::where($column, $value)->pluck('score', 'category_id');

        $categories = $categories
            ->sortByDesc(fn($category) => $scores[$category->id] ?? 0)
            ->values();

        $banners = PaidBanner::with('package.features', 'category')
            ->whereHas('package.features', fn($q) => $q->where('name', 'show_on_home_page'))
            ->where('status', 1)->where('is_paid', 1)->where('expiration_date', '>', $now)
            ->get();

        return response()->json([
            'categories' => $categories,
            'banners'    => $banners,
        ], 200);
    }

    /**
     * GET v1/ads/load-home-ads — per-category "load more" for the home feed.
     * Mirrors Web\AdController@load_home_ads.
     */
    public function load_home_ads(Request $request)
    {
        $validator = Validator::make($request->all(), ['category_id' => 'required']);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $limit  = (int) $request->input('limit', 15);
        $offset = (int) $request->input('offset', 0);

        $ads = Ad::active()
            ->with(['brand', 'sponsor', 'category', 'model'])
            ->where('category_id', $request->category_id)
            ->latest()
            ->offset($offset)->limit($limit)->get();

        return response()->json([
            'ads'          => $ads,
            'ads_count'    => $ads->count(),
            'show_ad_ids'  => $ads->pluck('id')->toArray(),
        ], 200);
    }

}

<?php

namespace App\Http\Controllers\Web;

use App\Model\Ad;
use Carbon\Carbon;
use App\CPU\Helpers;
use App\Model\Brand;
use App\Models\User;
use App\Model\AdView;
use App\Model\Review;
use App\Model\AdReport;
use App\Model\Category;
use App\Model\Wishlist;
use App\Model\AdAuction;
use App\Model\ListValue;
use App\CPU\ImageManager;
use App\Model\PaidBanner;
use App\CPU\ProductManager;
use App\Model\VehicleModel;
use Illuminate\Support\Str;
use App\Model\AdAskingPrice;
use Illuminate\Http\Request;
use App\Model\BusinessSetting;
use App\Model\SubscriptionPackage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AdController extends Controller
{

    public function adding_type() {

        $is_profile_uncompleted = Helpers::prevent_if_profile_incomplete();

        if($is_profile_uncompleted) {
            Toastr::success(translate('you_must_complete_your_profile_first_to_be_able_to_post_an_ad'));
            return back();
        }

        $categories = Category::where('position' , 1)->get();

        $brands = Brand::with('categories:id')->orderBY('name', 'ASC')->get();
        $models = VehicleModel::with('categories:id')->select('id', 'name', 'brand_id', 'status')->get();

        $brands = $brands->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name,
                'categories' => $brand->categories->pluck('id')->toArray(),
            ];
        });

        $models = $models->map(function ($model) {
            return [
                'id' => $model->id,
                'name' => $model->name,
                'brand_id' => $model->brand_id,
                'category_id' => $model->category_id,
                'status' => $model->status,
                'categories' => $model->categories->pluck('id')->toArray(),
            ];
        });

        return view(VIEW_FILE_NAMES['adding_type'], compact('categories', 'brands', 'models'));
    }

    public function add(Request $request) {

        $is_profile_uncompleted = Helpers::prevent_if_profile_incomplete();

        if($is_profile_uncompleted) {
            Toastr::success(translate('you_must_complete_your_profile_first_to_be_able_to_post_an_ad'));
            return back();
        }

        if(!$request->title && !$request->category_id && !session('selected_data')) {
            return redirect()->route('ads-adding-type');
        }

        if($request->title && $request->category_id) {

            $selected_category = Category::find($request->category_id);

            $selected_data = [];

            $selected_data['title'] = $request->title;
            $selected_data['category_id'] = $request->category_id;
            $selected_data['category_name'] = $selected_category->name;
            $selected_data['brand_id'] = $request->brand_id;
            $selected_data['model_id'] = $request->model_id;

            session(['selected_data' => $selected_data]);
        } else {
            $selected_category = Category::find(session('selected_data')['category_id']);
        }

        $data = session('selected_data');

        $selected_type = $selected_category->category_type;

        $categories = Category::where('position', 1)->where('category_type', $selected_type)->get();

        $brands = Cache::rememberForever('adding_brands', function () {
            return Brand::orderBy('name', 'ASC')->get();
        });

        $models = Cache::rememberForever('adding_models', function () {
            return VehicleModel::with('categories:id')->select('id', 'name', 'brand_id', 'status')->get();
        });

        $list_values = Cache::rememberForever('list_values', function () {
            return ListValue::with(['list' => function ($query) {
                    $query->select('id', 'name');
                }])
                ->select('id', 'value', 'list_attribute_id', 'priority')
                ->get()
                ->map(function ($item) {
                    $item->list_name = $item->list->name ?? null;
                    unset($item->list); // optional: remove the nested relation if not needed
                    return $item;
                });
        });
        
        // return Cache::get('business_settings');

        $urgent_sale_sticker_price = BusinessSetting::where('type', 'urgent_sale_sticker_price')->value('value');
        $urgent_sale_sticker_duration = BusinessSetting::where('type', 'urgent_sale_sticker_duration_in_days')->value('value');

        $maximum_video_duration = BusinessSetting::where('type', 'maximum_promotional_video_duration')->value('value');
        $maximum_video_size = BusinessSetting::where('type', 'maximum_promotional_video_size')->value('value');
        
        $ad_images_size = BusinessSetting::where('type', 'ad_images_size')->value('value');
        $maximum_ad_images_number = BusinessSetting::where('type', 'maximum_ad_images_number')->value('value');        

        $all_packages = SubscriptionPackage::with('type')
        ->whereHas('type', function ($query) {
            $query->whereIn('name', [
                'appearance_in_first_results',
                'urgent_sale_sticker',
                'promotional_video'
            ]);
        })
        ->get();

        $appear_on_top_packages = $all_packages->filter(function ($item) {
            return $item->status == 1 && $item->type->name === 'appearance_in_first_results';
        });

        $urgent_sale_sticker_packages = $all_packages->filter(function ($item) {
            return $item->status == 1 && $item->type->name === 'urgent_sale_sticker';
        });

        $promotional_video_packages = $all_packages->filter(function ($item) {
            return $item->status == 1 && $item->type->name === 'promotional_video';
        });

        return view('theme-views.ad.add-pages.add-'.strtolower(str_replace(' ', '-', $selected_type)),
        compact('categories', 'brands', 'models', 'data', 'selected_category', 'selected_type', 'list_values',
        'appear_on_top_packages', 'urgent_sale_sticker_packages', 'promotional_video_packages',
        'maximum_video_duration', 'maximum_video_size', 'ad_images_size', 'maximum_ad_images_number'));
    }

    public function edit($id) {

        $ad = Ad::active()->with('category')->find($id);
            
        $categories = Category::where('position', 1)->where('category_type', $ad->category->category_type)->get();
        $brands = Brand::orderBY('name', 'ASC')->get();
        $models = VehicleModel::select('id', 'name', 'brand_id', 'status')
        ->get();

        $list_values = ListValue::with(['list' => function ($query) {
            $query->select('id', 'name');
        }])
        ->select('id', 'value', 'list_attribute_id', 'priority')
        ->get()
        ->map(function ($item) {
            $item->list_name = $item->list->name ?? null;
            unset($item->list); // optional: remove the nested relation if not needed
            return $item;
        });

        return view('theme-views.ad.edit-pages.edit-'.strtolower(str_replace(' ', '-', $ad->category->category_type)),
        compact('ad', 'categories', 'brands', 'models','list_values'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'price_type' => 'required',
            'image' => 'required',
            'price' => $request->price_type == 'fixed_price' || $request->price_type == 'asking_price' ? 'required|numeric|min:0|max:10000000000' : '',
            'contact_phone_number' => $request->show_phone_number && $request->show_phone_number == 'on' ? 'required|numeric' : '',
            'currency' => 'required',
            'country' => 'required',
            'city' => 'required',
        ], [
            'title.required' => translate("Ad title is required"),
            'description.required' => translate("Ad description is required"),
            'category_id.required' => translate("Category name is required") ,
            'status.required' => translate("Status is required") ,
            'contact_phone_number.required' => translate("Phone number is required") ,
            'currency.required' => translate("Currency is required") ,
            'country.required' => translate("Country is required") ,
            'city.required' => translate("City is required"),
            'price.required' => translate("The price field is required"),
            'price_type.required' => translate("Price Type Status name is required"),
            'image.required' => translate("Image is required"),
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => translate("Validation failed"),
                'errors' => $validator->errors()->all()
            ], 422);
        }
        
        $selected_category = Category::find($request->category_id);
        
        if ($selected_category && $selected_category->is_vehicle == 1) {
            if (!$request->year) {
                return response()->json([
                    'success' => false,
                    'message' => translate("Vehicle year is required"),
                    'errors' => [translate("Vehicle year is required")]
                ], 422);
            }
        }

        $ad = new Ad();
        $ad->user_id = auth('customer')->user()->id;
        $ad->title = $request->title;
        $ad->slug = Str::slug($ad->title, '-') . '-' . Str::random(6);

        $ad_images = [];
        
        if($request->hasFile('images')) {
            foreach ($request->images as $image) {
                if ($image && $image->isValid()) {
                    $image_name = ImageManager::upload('ad/', 'webp', $image, 'def.jpg');
                    $ad_images[] = $image_name;
                }
            }
        }

        $ad_location_coordinates = $this->getLocationCoordinates($request->city);

        $ad->category_id            = $request->category_id;
        $ad->brand_id               = $request->brand_id;
        $ad->description            = $request->description;
        $ad->model_id               = $request->model_id;
        $ad->color                  = $request->color;
        $ad->ad_status              = $request->status;
        $ad->fuel_type              = $request->fuel_type;
        $ad->engine_size            = $request->engine_size;
        $ad->engine_cylinders       = $request->engine_cylinders;
        $ad->engine_power           = $request->engine_power;
        $ad->mileage                = $request->mileage;
        $ad->year                   = $request->year;
        $ad->transmission_type      = $request->transmission_type;
        $ad->currency               = $request->currency;
        $ad->price_type             = $request->price_type;

        $ad->allow_offers           = $request->price_type == 'asking_price' && 
        $request->allow_offers && $request->allow_offers == 'on' ? 1 : 0;

        $ad->first_price            = $request->price_type == 'asking_price' &&
        $request->allow_offers && $request->allow_offers == 'on' ? $request->first_price : null;

        $ad->price                  = $request->price;
        $ad->starting_price         = $request->starting_price;
        $ad->body_type              = $request->body_type;
        $ad->length                 = $request->length;
        $ad->show_phone_number      = $request->show_phone_number && $request->show_phone_number == 'on' ? 1 : 0;
        $ad->show_email_address     = $request->show_email_address && $request->show_email_address == 'on' ? 1 : 0;
        $ad->whatsapp_availability  = $request->whatsapp_availability && $request->whatsapp_availability == 'on' ? 1 : 0;
        $ad->phone_code             = $request->phone_code;
        $ad->contact_phone_number   = $request->contact_phone_number;
        $ad->city                   = $request->city;
        $ad->country                = $request->country;
        $ad->latitude               = $ad_location_coordinates['latitude'] ?? null;
        $ad->longitude              = $ad_location_coordinates['longitude'] ?? null;
        $ad->postal_code            = $request->postal_code;
        $ad->width                  = $request->width;
        $ad->height                 = $request->height;
        $ad->max_weight             = $request->max_weight;
        $ad->bag_capacity           = $request->bag_capacity;
        $ad->doors_number           = $request->doors_number;
        $ad->seats_number           = $request->seats_number;
        $ad->co2_emissions          = $request->co2_emissions;
        $ad->energy_consumption     = $request->energy_consumption;
        $ad->gas_emission_tax       = $request->gas_emission_tax;
        $ad->previous_scan_date     = $request->previous_scan_date;
        $ad->battery_charging_time  = $request->battery_charging_time;
        $ad->fast_battery_charging_time= $request->fast_battery_charging_time;
        $ad->options = json_encode($request->options);

        $ad->furniture_type = $request->furniture_type;
        $ad->material = $request->material;

        $ad->listing_type = $request->listing_type;
        $ad->property_type = $request->property_type;
        $ad->property_size = $request->property_size;
        $ad->floor = $request->floor;
        $ad->rooms_number = $request->rooms_number;

        $ad->machine_type = $request->machine_type;
        $ad->manufacturer = $request->manufacturer;
        $ad->power_capacity = $request->power_capacity;
        $ad->power_source = $request->power_source;

        $ad->custom_brand = $request->custom_brand;
        $ad->electronic_type = $request->electronic_type;

        $ad->bicycle_type = $request->bicycle_type;
        $ad->bicycle_size = $request->bicycle_size;

        $ad->home_appliance_type = $request->home_appliance_type;
        
        $ad->usage_type = $request->usage;

        $ad->maximum_speed = $request->maximum_speed;
        $ad->engines_number = $request->engines_number;
        $ad->cabins_number = $request->cabins_number;
        
        $ad->beds_number = $request->beds_number;
    
        $ad->shipbuilding_type = $request->shipbuilding_type;

        $ad->battery_life           = $request->battery_life;
        $ad->acceleration_0_100     = $request->acceleration_0_100;
        $ad->images = json_encode($ad_images);

        if($request->hasFile('image')) {
            $ad->thumbnail = ImageManager::upload('ad/thumbnail/', 'webp', $request->file('image'), 'def.jpg');
        }

        $ad->status = 0;

        $ad->save();

        $packages_ids = [];

        if($request->urgent_sale_sticker_sponsor && is_numeric($request->urgent_sale_sticker_sponsor)) {
            $urgent_sale_sticker_package = SubscriptionPackage::with('type')->where('id', $request->urgent_sale_sticker_sponsor)
            ->where('status', 1)
            ->whereHas('type', function ($query) {
                $query->where('name', 'urgent_sale_sticker');
            })->first();
            
            if($urgent_sale_sticker_package) { $packages_ids[] = $urgent_sale_sticker_package->id; }
        }
        
        if($request->appear_on_first_results_sponsor && is_numeric($request->appear_on_first_results_sponsor)) {
            $appear_on_first_results_package = SubscriptionPackage::with('type')->where('id', $request->appear_on_first_results_sponsor)
            ->where('status', 1)
            ->whereHas('type', function ($query) {
                $query->where('name', 'appearance_in_first_results');
            })->first();
            
            if($appear_on_first_results_package) { $packages_ids[] = $appear_on_first_results_package->id; }
        }
        
        if($request->promotional_video_sponsor && is_numeric($request->promotional_video_sponsor)) {
            $promotional_video_package = SubscriptionPackage::with('type')->where('id', $request->promotional_video_sponsor)
            ->where('status', 1)
            ->whereHas('type', function ($query) {
                $query->where('name', 'promotional_video');
            })->first();

            if($promotional_video_package) { $packages_ids[] = $promotional_video_package->id; }
        }
        
        $is_total_price_zero = !empty($packages_ids) && SubscriptionPackage::whereIn('id', $packages_ids)->sum('price') == 0 ? true : false;

        if(!empty($packages_ids) && !$is_total_price_zero) {
            
            $data['ad_id'] = $ad->id;
            $data['packages_ids'] = $packages_ids;

            session(['sponsor_data' => $data]);

            return response()->json([
                'success' => true,
                'with_payment' => true,
                'message' => translate('the_ad_has_been_published_you_will_be_redirected_to_complete_the_payment_checkout'),
                'checkout_redirect_url' => route('redirect.to.payment'),
            ]);
        }

        if(isset($urgent_sale_sticker_package) && $urgent_sale_sticker_package->price == 0) {
            $ad->sponsor()->create([
                'ad_id' => $ad->id,
                'type' => $urgent_sale_sticker_package->type->name,
                'price' => $urgent_sale_sticker_package->price,
                'package_id' => $urgent_sale_sticker_package->id,
                'duration_in_days' => $urgent_sale_sticker_package->duration_in_days,
                'is_paid' => 1,
                'expiration_date' => now()->addHours($urgent_sale_sticker_package->duration_in_days * 24),
                'payment_transaction_id' => null,
            ]);
        }

        if(isset($appear_on_first_results_package) && $appear_on_first_results_package->price == 0) {
            $ad->sponsor()->create([
                'ad_id' => $ad->id,
                'type' => $appear_on_first_results_package->type->name,
                'price' => $appear_on_first_results_package->price,
                'package_id' => $appear_on_first_results_package->id,
                'duration_in_days' => $appear_on_first_results_package->duration_in_days,
                'is_paid' => 1,
                'expiration_date' => now()->addHours($appear_on_first_results_package->duration_in_days * 24),
                'payment_transaction_id' => null,
            ]);
        }

        if(isset($promotional_video_package) && $promotional_video_package->price == 0) {
            $ad->sponsor()->create([
                'ad_id' => $ad->id,
                'type' => $promotional_video_package->type->name,
                'price' => $promotional_video_package->price,
                'package_id' => $promotional_video_package->id,
                'playback_id' => session('playback_id'),
                'video_url' => session('video_player_url'),
                'duration_in_days' => $promotional_video_package->duration_in_days,
                'is_paid' => 1,
                'expiration_date' => now()->addHours($promotional_video_package->duration_in_days * 24),
                'payment_transaction_id' => null,
            ]);

            session()->forget('video_player_url');
            session()->forget('playback_id');

        }

        $ad->status = 1;    

        $ad->save();

        return response()->json([
            'success' => true,
            'with_payment' => false,
            'message' => translate('the_ad_has_been_published_successfully'),
            'redirect_url' => route('ads-show', $ad->slug)
        ]);

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
                'error' => translate("Upload ID is required")
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
                        'error' => translate("Video is still processing please try again in a moment"),
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
                            'error' => translate("Video is still processing please try again in a moment"),
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
                        'error' => translate("Failed to get asset details") . ':' . $assetResponse->body()
                    ], 500);
                }
                
            } else {
                return response()->json([
                    'success' => false,
                    'error' => translate("Failed to get upload details") . ':' . $response->body()
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
                'error' => translate("Upload ID is required")
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
                            'error' => translate("Failed to delete video") . ':' . $deleteResponse->body()
                        ], 500);
                    }
                }
            }
            
            // Clear session data
            session()->forget(['playback_id', 'video_player_url', 'asset_id']);
            
            return response()->json([
                'success' => true,
                'message' => translate("Video deleted successfully")
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
            'message' => translate("Session cleared")
        ]);
    }

    public function validateCityInCountry($city, $country)
    {
        $apiKey = Helpers::get_business_settings('map_api_key');
        
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => "$city, $country",
            'key' => $apiKey
        ]);
        
        if (!$response->successful()) {
            return false;
        }
        
        $data = $response->json();
        
        // Check if we got any results
        if ($data['status'] !== 'OK' || empty($data['results'])) {
            return false;
        }
        
        // Check address components for country match
        foreach ($data['results'][0]['address_components'] as $component) {
            if (in_array('country', $component['types'])) {
                // Compare with expected country (case insensitive)
                return strtolower($component['long_name']) === strtolower($country) 
                    || strtolower($component['short_name']) === strtolower($country);
            }
        }
        
        return false;
    }

    public function getLocationCoordinates($city) {

        $apiKey = Helpers::get_business_settings('map_api_key');

        $address = $city;

        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $address,
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

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'price_type' => 'required',
            'price' => $request->price_type == 'fixed_price' || $request->price_type == 'asking_price' ? 'required|numeric|min:0|max:10000000000' : '',
            'contact_phone_number' => $request->show_phone_number && $request->show_phone_number == 'on' ? 'required|numeric' : '',
            'currency' => 'required',
            'country' => 'required',
            'city' => 'required',
        ], [
            'title.required' => translate("Ad title is required"),
            'description.required' => translate("Ad description is required"),
            'category_id.required' => translate("Category name is required"),
            'status.required' => translate("Status is required"),
            'contact_phone_number.required' => translate("Phone number is required"),
            'currency.required' => translate("Currency is required") ,
            'country.required' => translate("Country is required"),
            'city.required' => translate("City is required"),
            'price_type.required' => translate("Price Type Status name is required"),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => translate("Validation failed"),
                'errors' => $validator->errors()->all()
            ], 422);
        }
        
        $selected_category = Category::find($request->category_id);
        
        if ($selected_category && $selected_category->is_vehicle == 1) {
            if (!$request->year) {
                return response()->json([
                    'success' => false,
                    'message' => translate("Vehicle year is required"),
                    'errors' => [translate("Vehicle year is required")]
                ], 422);
            }
        }

        $ad = Ad::active()->find($request->id);

        $ad->title = $request->title;
        // $ad->slug = Str::slug($ad->title, '-') . '-' . Str::random(6);
        
        $ad_images = $request->old_images && 
            count($request->old_images) > 0 ? 
        $request->old_images : [];
        
        if($request->hasFile('images')) {
            foreach ($request->images as $image) {
                if ($image && $image->isValid()) {
                    $image_name = ImageManager::upload('ad/', 'webp', $image, 'def.jpg');
                    $ad_images[] = $image_name;
                }
            }
        }
        
        $ad->images = json_encode($ad_images);

        $ad->category_id            = $request->category_id;
        $ad->brand_id               = $request->brand_id;
        $ad->description            = $request->description;
        $ad->model_id               = $request->model_id;
        $ad->color                  = $request->color;
        $ad->ad_status              = $request->status;
        $ad->fuel_type              = $request->fuel_type;
        $ad->engine_size            = $request->engine_size;
        $ad->engine_cylinders       = $request->engine_cylinders;
        $ad->engine_power           = $request->engine_power;
        $ad->currency               = $request->currency;
        $ad->price_type             = $request->price_type;
        $ad->mileage                = $request->mileage;
        $ad->year                   = $request->year;

        $ad->allow_offers           = $request->price_type == 'asking_price' && 
        $request->allow_offers && $request->allow_offers == 'on' ? 1 : 0;

        $ad->first_price            = $request->price_type == 'asking_price' &&
        $request->allow_offers && $request->allow_offers == 'on' ? $request->first_price : null;

        $ad->price                  = $request->price;
        $ad->show_phone_number      = $request->show_phone_number && $request->show_phone_number == 'on' ? 1 : 0;
        $ad->show_email_address     = $request->show_email_address && $request->show_email_address == 'on' ? 1 : 0;
        $ad->whatsapp_availability  = $request->whatsapp_availability && $request->whatsapp_availability == 'on' ? 1 : 0;
        $ad->phone_code             = $request->phone_code;
        $ad->contact_phone_number   = $request->contact_phone_number;
        $ad->country                = $request->country;
        $ad->city                   = $request->city;
        $ad->postal_code            = $request->postal_code;

        $ad->transmission_type      = $request->transmission_type;
        $ad->starting_price         = $request->starting_price;
        $ad->price                  = $request->price;
        $ad->body_type              = $request->body_type;
        $ad->doors_number           = $request->doors_number;
        $ad->seats_number           = $request->seats_number;
        $ad->length                 = $request->length;
        $ad->width                  = $request->width;
        $ad->height                 = $request->height;
        $ad->max_weight             = $request->max_weight;
        $ad->bag_capacity           = $request->bag_capacity;
        $ad->co2_emissions          = $request->co2_emissions;
        $ad->energy_consumption     = $request->energy_consumption;
        $ad->gas_emission_tax       = $request->gas_emission_tax;
        $ad->previous_scan_date     = $request->previous_scan_date;
        $ad->battery_charging_time  = $request->battery_charging_time;
        $ad->fast_battery_charging_time= $request->fast_battery_charging_time;
        $ad->options = json_encode($request->options);
        $ad->battery_life           = $request->battery_life;
        $ad->acceleration_0_100     = $request->acceleration_0_100;

        $ad->furniture_type = $request->furniture_type;
        $ad->material = $request->material;

        $ad->listing_type = $request->listing_type;
        $ad->property_type = $request->property_type;
        $ad->property_size = $request->property_size;
        $ad->floor = $request->floor;
        $ad->rooms_number = $request->rooms_number;

        $ad->machine_type = $request->machine_type;
        $ad->manufacturer = $request->manufacturer;
        $ad->power_capacity = $request->power_capacity;
        $ad->power_source = $request->power_source;

        $ad->custom_brand = $request->custom_brand;
        $ad->electronic_type = $request->electronic_type;

        $ad->bicycle_type = $request->bicycle_type;
        $ad->bicycle_size = $request->bicycle_size;

        $ad->home_appliance_type = $request->home_appliance_type;

        $ad->usage_type = $request->usage;
        
        $ad->maximum_speed = $request->maximum_speed;
        $ad->engines_number = $request->engines_number;
        $ad->cabins_number = $request->cabins_number;
        
        $ad->beds_number = $request->beds_number;

        $ad->shipbuilding_type = $request->shipbuilding_type;

        $ad->images = json_encode($ad_images);
        if($request->hasFile('image')) {
            $ad->thumbnail = ImageManager::upload('ad/thumbnail/', 'webp', $request->file('image'), 'def.jpg');
        }

        $ad->save();

        return response()->json([
            'success' => true,
            'message' => translate('ad_updated_successfully'),
            'redirect_url' => route('user-ads')
        ]);

    }

    public function show_by_country($code){
        
        if($code == 'EU') {
            session()->forget('show_by_country');
            return back();
        }

        $country = array_values(array_filter(SYSTEM_COUNTRIES, fn($item) => isset($item['code']) && $item['code'] === $code))[0];

        session(['show_by_country' => [
            'code' => $code,
            'name' => $country['name'],
            'emoji' => $country['emoji']
        ]]);

        return back();
    }

    public function show_by_category($cat_id) {
        $category = Category::with('ads')->find($cat_id);

        $category_name = $category->name;

        $ads = $category->ads('sponsor')
        ->when(session('show_by_country'), fn($q, $country) => $q->country($country['name']))
        ->get();

        $now = Carbon::now();

        $ads->each(function ($ad) use ($now) {
            $sponsor = collect($ad->sponsor)->firstWhere('type', 'urgent_sale_sticker');
            $ad->has_urgent_sale_sticker = $sponsor && $sponsor->expiration_date > $now ? 1 : 0;

            $ad->has_first_results = collect($ad->sponsor)
            ->firstWhere('type', 'appearance_in_first_results')
            ?->expiration_date > $now ? 1 : 0;
        });

        // reorder ads so those with has_first_results = 1 come first
        $ads = $ads->sortByDesc('has_first_results')->values();

        $ads_count = $ads->count();

        return view('theme-views.ad.show-by-category' , compact('category_name', 'ads', 'ads_count'));

    }

    public function show($slug){

        $ad = Ad::active()
            ->with(['category','brand','model','sponsor'])
            ->where('slug', $slug)
            ->firstOrFail();
        
        $ip = request()->ip();
        $user_agent = request()->header('User-Agent');

        $is_already_viewed = AdView::where('ad_id', $ad->id)
        ->where('ip_address', $ip)
        ->where('user_agent', $user_agent)
        ->exists();

        if (!$is_already_viewed) {
            $view = new AdView;
            $view->ad_id = $ad->id;
            $view->ip_address = $ip;
            $view->user_agent = $user_agent;
            $view->save();
        }

        if ($ad != null) {
            $current_date = date('Y-m-d H:i:s');

            $countWishlist = Wishlist::where('ad_id', $ad->id)->count();
            $wishlist_status = Wishlist::where(['ad_id'=>$ad->id, 'customer_id'=>auth('customer')->id()])->count();

            $relatedAds = Ad::active()->with(['category', 'brand', 'model'])
            ->active()
            ->when(session('show_by_country'), fn($q, $country) => $q->country($country['name']))
            ->where('model_id', $ad->model_id)
            ->whereKeyNot($ad->id)
            ->limit(12)
            ->get();

            $ad_promotional_video = $ad->sponsor->where('type', 'promotional_video')
            ->where('expiration_date', '>=', $current_date)
            ->where('is_video_suspended', 0)
            ->where('is_video_deleted', 0)
            ->first();

            $gallery_images_number = count(json_decode($ad->images)) + 1;

            if($ad_promotional_video) { $gallery_images_number++; }

            $customer_detail = User::where('id', auth('customer')->id())->first();

            $more_ads_from_user = Ad::active()->withCount('reviews')
            ->when(session('show_by_country'), fn($q, $country) => $q->country($country['name']))
            ->where('id', '!=', $ad->id)->where('user_id', $ad->user_id)
            ->latest()->take(5)->get();
            
            $ad_views_number = $ad->adViews->count();

            $ad_ids = Ad::active()->where('user_id', $ad->user_id)->pluck('id');

            $paid_banners = PaidBanner::with('package.features')
            ->whereHas('package', function ($q) {
                $q->whereHas('features', function ($q2) {
                    $q2->where('name', 'show_on_filter_and_ad_page');
                });
            })
            ->where('status', 1)
            ->where('expiration_date', '>', Carbon::now()) // not expired
            ->get();

            $libraryId = BusinessSetting::where('type', 'bunny_library_id')->value('value');
            $pullZone = BusinessSetting::where('type', 'bunny_pull_zone')->value('value');

            $is_dimensions_and_sizes_empty = !$ad->height && 
                !$ad->width && 
                !$ad->length && 
                !$ad->bag_capacity &&
                !$ad->weight;

            $is_environmental_information_empty = 
                !$ad->gas_emission_tax  &&
                !$ad->energy_source &&
                !$ad->energy_consumption;

            $is_battery_information_empty = 
                !$ad->battery_charging_time &&
                !$ad->fast_battery_charging_time &&
                !$ad->battery_life;            
            
            $is_additional_information_empty =
                !$ad->previous_scan_date &&
                !$ad->acceleration_0_100;
            
            return view(VIEW_FILE_NAMES['ad_details'], compact(
                'ad',
                'wishlist_status',
                'countWishlist',
                'relatedAds', 
                'current_date',
                'ad_promotional_video',
                'gallery_images_number',
                'more_ads_from_user',
                'paid_banners',
                'libraryId',
                'pullZone',
                'customer_detail',
                'ad_views_number',
                'is_dimensions_and_sizes_empty',
                'is_environmental_information_empty',
                'is_battery_information_empty',
                'is_additional_information_empty',
                ));
        }

        Toastr::error(translate('ad_not_found'));
        return back();

    }

    public function report_ad(Request $request) {
        
        $is_profile_completed = Helpers::prevent_if_profile_incomplete();

        if($is_profile_completed) {
            Toastr::error(translate('you_must_complete_your_profile_first_to_be_able_to_report_ads'));
            return back();
        }

        $validator = Validator::make($request->all(), [
            'id'                         => 'required',
            'message'                    => 'required',
        ], [
            'id.required'                => translate('id_is_required'),
            'message.required'           => translate('message_is_required'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        
        // cant report own ad
        if (Ad::active()->find($request->id)->user_id == auth('customer')->id()) {
            Toastr::error(translate('you_cant_report_your_own_ad'));
            return back();
        }

        $is_user_already_reported = AdReport::where('ad_id', $request->id)->where('user_id', auth('customer')->id())->exists();

        if ($is_user_already_reported) {
            Toastr::error(translate('you_already_reported_this_ad'));
            return back();
        }


        $report = new AdReport;
        $report->ad_id = $request->id;
        $report->user_id = auth('customer')->id();
        $report->message = $request->message;
        $report->save();

        Toastr::success(translate('ad_reported_successfully'));
        return back();

    }

    public function store_auction(Request $request) {

        $is_profile_completed = Helpers::prevent_if_profile_incomplete();

        if($is_profile_completed) {
            Toastr::error(translate('you_must_complete_your_profile_first_to_be_able_to_make_an_offer'));
            return back();
        }

        $validator = Validator::make($request->all(), [
            'id'                         => 'required',
            'price'                      => 'required|numeric|min:0|max:10000000000',
        ], [
            'id.required'                => 'id is required!',
            'price'                      => 'required|numeric|min:0|max:10000000000',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Toastr::error(translate($error));
            }
            return back()->withInput();
        }

        $ad = Ad::active()->with('auctions')->find($request->id);

        $last_auction_price = $ad->auctions->count() > 0 
            ? $ad->auctions()->latest()->value('price') 
        : ($ad->starting_price ? $ad->starting_price : 0);

        if($ad->auctions->count() && $ad->auctions->contains('user_id', auth('customer')->id())) {
            Toastr::error(translate('you_already_send_an_offer_to_this_ad'));
            return back();
        }

        if($request->price <= $last_auction_price) {
            Toastr::error(translate('the_offer_price_must_be_greater_than_the_starting_price_or_the_last_offer_price'));
            return back();
        }

        $auction = new AdAuction();

        $auction->ad_id = $ad->id;
        $auction->user_id = auth('customer')->id();
        $auction->price = $request->price;

        $auction->save();

        Toastr::success(translate('offer_sended_successfully'));
        return back();

    }

    public function delete_auction(Request $request) {
        

        $auction = AdAuction::find($request->id);

        $auction->delete();

        Toastr::success(translate('offer_deleted_successfully'));
        return back();

    }
    
    public function store_asking_price(Request $request) {

        $is_profile_completed = Helpers::prevent_if_profile_incomplete();

        if($is_profile_completed) {
            Toastr::error(translate('you_must_complete_your_profile_first_to_be_able_to_make_an_offer'));
            return back();
        }
        
        $validator = Validator::make($request->all(), [
            'id'                         => 'required',
            'price'                      => 'required|numeric|min:0|max:10000000000',
        ], [
            'id.required'                => translate("id is required"),
            'price.required'             => translate("price is required"),
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Toastr::error(translate($error));
            }
            return back()->withInput();
        }

        $ad = Ad::active()->with('askingPrice')->find($request->id);

        if($ad->askingPrice->count() && $ad->askingPrice->contains('user_id', auth('customer')->id())) {
            Toastr::error(translate('you_already_send_an_negotiate_price_to_this_ad'));
            return back();
        }

        $last_asking_price = $ad->askingPrice->count() > 0 
        ? $ad->askingPrice()->latest()->value('price') 
        : ($ad->starting_price ? $ad->starting_price : 0);

        if($request->price < $last_asking_price) {
            Toastr::error(translate('the_offer_price_must_be_greater_than_the_starting_price_or_the_last_offer_price'));
            return back();
        } 

        $asking_price = new AdAskingPrice();

        $asking_price->ad_id = $ad->id;
        $asking_price->user_id = auth('customer')->id();
        $asking_price->price = $request->price;

        $asking_price->save();

        Toastr::success(translate('offer_sended_successfully'));
        return back();

    }

    public function delete_asking_price(Request $request) {
        $asking_price = AdAskingPrice::find($request->id);

        $asking_price->delete();

        Toastr::success(translate('offer_deleted_successfully'));
        return back();
    }

    public function delete($id) {

        $ad = Ad::active()->where('user_id', auth('customer')->id())->findOrFail($id);

        if ($video = $ad->sponsor()
        ->where('type', 'promotional_video')
        ->where('expiration_date', '>', now())
        ->where('is_video_deleted', 0)
        ->whereNotNull('playback_id')
        ->first()) 
        {
            $muxTokenId     = BusinessSetting::where('type', 'mux_api_token')->value('value');
            $muxTokenSecret = BusinessSetting::where('type', 'mux_secret_key')->value('value');

            if ($muxTokenId && $muxTokenSecret) {

                $response = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                    ->get("https://api.mux.com/video/v1/playback-ids/{$video->playback_id}");

                if ($response->successful()) {

                    $responseData = $response->json();

                    $assetId = $responseData['data']['asset_id']
                        ?? $responseData['data']['object']['id']
                        ?? null;

                    if ($assetId) {
                        $deleteResponse = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                        ->delete("https://api.mux.com/video/v1/assets/{$assetId}");

                        if ($deleteResponse->successful()) {
                            $video->update([
                                'is_video_deleted' => 1,
                            ]);
                        }

                    }
                }
            }

        }

        $ad->delete();

        Toastr::success(translate('ad_deleted_successfully'));
        return back();

    }

    public function filter(Request $request) {

        $filter_data = $request->all() ?? [];

        $is_selected_category_vehicle = $request->category_id == 0 || Category::find($request->category_id)->category_type == 'vehicles';
        
        $ad_data = Ad::active()->with('sponsor','wish_list');

        $max_price = $request->price_range;
        $min_construction_year = $request->construction_year;

        $request['max_price'] = $request->price_range != 'all' ? $request->price_range : null;
        $request['min_construction_year'] = $request->construction_year != 'all' ? $request->construction_year : null;

        $request['bicycle_type'] = $request->bicycle_type != 'all' ? $request->bicycle_type : null;
        $request['bicycle_size'] = $request->bicycle_size != 'all' ? $request->bicycle_size : null;
        
        $request['furniture_material'] = $request->furniture_material != 'all' ? $request->furniture_material : null;
        $request['furniture_type'] = $request->furniture_type != 'all' ? $request->furniture_type : null;
        $request['home_garden_material'] = $request->home_garden_material != 'all' ? $request->home_garden_material : null;
        $request['shipbuilding_type'] = $request->shipbuilding_type != 'all' ? $request->shipbuilding_type : null;
        $request['engines_number'] = $request->engines_number != 'all' ? $request->engines_number : null;
        $request['cabins_number'] = $request->cabins_number != 'all' ? $request->cabins_number : null;
        $request['usage'] = $request->usage != 'all' ? $request->usage : null;
        $request['machine_type'] = $request->machine_type != 'all' ? $request->machine_type : null;
        $request['power_source'] = $request->power_source != 'all' ? $request->power_source : null;
        $request['home_appliance_type'] = $request->home_appliance_type != 'all' ? $request->home_appliance_type : null;
        $request['electronic_type'] = $request->electronic_type != 'all' ? $request->electronic_type : null;
        $request['listing_type'] = $request->listing_type != 'all' ? $request->listing_type : null;
        $request['property_type'] = $request->property_type != 'all' ? $request->property_type : null;
        $request['floor'] = $request->floor != 'all' ? $request->floor : null;

        $ad_data = $this->ad_query_filter($ad_data, $request);
        $initial_filter_count = $ad_data->count();
        $ads = $ad_data->limit(5)
        ->orderBy('created_at', 'DESC')
        ->get();

        $categories = Category::where('position', 1)->get();

        $brands = Brand::with('categories:id')->orderBY('name', 'ASC')->get();

        $models = VehicleModel::with('categories:id')->select('id', 'name', 'brand_id', 'status')->get();

        $models = $models->map(function ($model) {
            return [
                'id' => $model->id,
                'name' => $model->name,
                'brand_id' => $model->brand_id,
                'category_id' => $model->category_id,
                'status' => $model->status,
                'categories' => $model->categories->pluck('id')->toArray(),
            ];
        });

        $brands = $brands->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name,
                'categories' => $brand->categories->pluck('id')->toArray(),
            ];
        });

        $paid_banners = PaidBanner::with('package.features')
            ->whereHas('package', function ($q) {
                $q->whereHas('features', function ($q2) {
                    $q2->where('name', 'show_on_filter_and_ad_page');
                });
            })
            ->where('status', 1)
            ->where('expiration_date', '>', Carbon::now()) // not expired
            ->get();

        return view(VIEW_FILE_NAMES['products_view_page'], compact('filter_data', 'ads', 'categories', 'paid_banners' ,
        'is_selected_category_vehicle', 'brands', 'models', 'max_price', 'min_construction_year', 'initial_filter_count'));

    }

    public function ads_filter(Request $request) {

        $query = Ad::active()->with('sponsor');
        
        if ($request->color != 'all' && $request->color) {
            $query->where('color', $request->color);
        }
        
        $query = $this->ad_query_filter($query, $request);
                
        if ($request->city != '' && $request->city) {
            $coordinates = $this->getLocationCoordinates($request->city);
            
            if($request->radius != '') {
                $query = $this->getAdsInRadius($query, $request->radius, $coordinates['latitude'], $coordinates['longitude']);
            } else {
                $query->where('latitude', $coordinates['latitude'])
                ->where('longitude', $coordinates['longitude']);
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

        if($request->has('offset') && $request->has('limit')) {
            $limit = $request->input('limit', 5);
            $offset = $request->input('offset', 5);
        
            $ads = $query->offset($offset)->limit($limit)->get();
            
            return response()->json([
                'html' => $ads->count() > 0 ? view('theme-views.partials._ajax-products-view', compact('ads'))->render() : null,
                'ads_count' => $ads->count(),
                'show_ad_ids' => $ads->pluck('id')->toArray()
            ]);
        }

        $count = $query->count();
        $ads = $query->limit(5)->get();

        return response()->json([
            'html' => view('theme-views.partials._ajax-products-view', compact('ads'))->render(),
            'show_ad_ids' => $ads->pluck('id')->toArray(),
            'count' => $count,
        ]);
    }

    public function profile_ads_filter(Request $request) {        

        $query = Ad::active()->where('user_id', $request->user_id);
        
        if ($request->color != 'all' && $request->color) {
            $query->where('color', $request->color);
        }
        
        $query = $this->ad_query_filter($query, $request);
                
        if ($request->city != '' && $request->city) {
            $coordinates = $this->getLocationCoordinates($request->city);
            
            if($request->radius != '') {
                $query = $this->getAdsInRadius($query, $request->radius, $coordinates['latitude'], $coordinates['longitude']);
            } else {
                $query->where('latitude', $coordinates['latitude'])
                ->where('longitude', $coordinates['longitude']);
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

        if($request->has('offset') && $request->has('limit')) {
            $limit = $request->input('limit', 5);
            $offset = $request->input('offset', 5);
        
            $ads = $query->offset($offset)->limit($limit)->get();
            
            return response()->json([
                'html' => $ads->count() > 0 ? view('theme-views.partials._ajax-products-view', compact('ads'))->render() : null,
                'ads_count' => $ads->count(),
                'show_ad_ids' => $ads->pluck('id')->toArray()
            ]);
        }

        $count = $query->count();
        $ads = $query->limit(5)->get();

        return response()->json([
            'html' => view('theme-views.partials._ajax-products-view', compact('ads'))->render(),
            'show_ad_ids' => $ads->pluck('id')->toArray(),
            'count' => $count,
        ]);
    }

    public function getAdsInRadius($query, $radius, $latitude, $longitude)
    {
        // Step 2: Filter ads within radius
        $query->withinRadius($latitude, $longitude ,$radius);
        return $query;
    }

    public function ads_filter_count(Request $request)
    {
        $query = Ad::active();

        $request['max_price'] = $request->price_range != 'all' ? $request->price_range : null;
        $request['min_construction_year'] = $request->construction_year != 'all' ? $request->construction_year : null;

        $request['bicycle_type'] = $request->bicycle_type != 'all' ? $request->bicycle_type : null;
        $request['bicycle_size'] = $request->bicycle_size != 'all' ? $request->bicycle_size : null;
        
        $request['furniture_material'] = $request->furniture_material != 'all' ? $request->furniture_material : null;
        $request['furniture_type'] = $request->furniture_type != 'all' ? $request->furniture_type : null;
        $request['home_garden_material'] = $request->home_garden_material != 'all' ? $request->home_garden_material : null;
        $request['shipbuilding_type'] = $request->shipbuilding_type != 'all' ? $request->shipbuilding_type : null;
        $request['engines_number'] = $request->engines_number != 'all' ? $request->engines_number : null;
        $request['cabins_number'] = $request->cabins_number != 'all' ? $request->cabins_number : null;
        $request['usage'] = $request->usage != 'all' ? $request->usage : null;
        $request['machine_type'] = $request->machine_type != 'all' ? $request->machine_type : null;
        $request['power_source'] = $request->power_source != 'all' ? $request->power_source : null;
        $request['home_appliance_type'] = $request->home_appliance_type != 'all' ? $request->home_appliance_type : null;
        $request['electronic_type'] = $request->electronic_type != 'all' ? $request->electronic_type : null;
        $request['listing_type'] = $request->listing_type != 'all' ? $request->listing_type : null;
        $request['property_type'] = $request->property_type != 'all' ? $request->property_type : null;
        $request['floor'] = $request->floor != 'all' ? $request->floor : null;

        $query = $this->ad_query_filter($query, $request);

        return response()->json([
            'count' => $query->count()
        ]);
    }

    public function ad_query_filter($query, $request) {
        // Filter by category if specified
        if ($request['category_id'] != 'all' && $request['category_id']) {
            $query->where('category_id', $request['category_id']);
        }

        // Filter by brand if specified
        if ($request['brand_id'] != 'all' && $request['brand_id']) {
            $query->where('brand_id', $request['brand_id']);
        }
        
        // Filter by model if specified
        if ($request['model_id'] != 'all' && $request['model_id']) {
            $query->where('model_id', $request['model_id']);
        }

        if ($request['bicycle_type'] != 'all' && $request['bicycle_type']) {
            $query->where('bicycle_type', $request['bicycle_type']);
        }

        if ($request['bicycle_size'] != 'all' && $request['bicycle_size']) {
            $query->where('bicycle_size', $request['bicycle_size']);
        }
        
        // Filter by country if specified
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

        // Optimized price filtering
        $query->where(function ($q) use ($request) {
            // Variables to avoid repeated function calls
            $minPrice = $request->min_price;
            $maxPrice = $request->max_price;
            
            // Only process if we have at least one price constraint
            if ($minPrice || $maxPrice) {
                // Create conditions for each price type
                $fixedPriceCondition = [];
                $auctionCondition = [];
                
                // Build price conditions based on available filters
                if ($minPrice && $maxPrice) {
                    $fixedPriceCondition[] = "price BETWEEN {$minPrice} AND {$maxPrice}";
                    $auctionCondition[] = "starting_price BETWEEN {$minPrice} AND {$maxPrice}";
                } elseif ($minPrice) {
                    $fixedPriceCondition[] = "price >= {$minPrice}";
                    $auctionCondition[] = "starting_price >= {$minPrice}";
                } elseif ($maxPrice) {
                    $fixedPriceCondition[] = "price <= {$maxPrice}";
                    $auctionCondition[] = "starting_price <= {$maxPrice}";
                }
                
                // Instead of using raw queries, use Laravel's query builder
                if (!empty($fixedPriceCondition) && !empty($auctionCondition)) {
                    $q->where(function($query) use ($fixedPriceCondition, $auctionCondition) {
                        // Fixed price or asking price condition
                        $query->where(function($subquery) use ($fixedPriceCondition) {
                            $subquery->whereIn('price_type', ['fixed_price', 'asking_price']);

                            if (!empty($fixedPriceCondition)) {
                                foreach ($fixedPriceCondition as $condition) {
                                    $subquery->whereRaw($condition);
                                }
                            }
                        });
                        
                        // Auction price condition
                        $query->orWhere(function($subquery) use ($auctionCondition) {
                            $subquery->where('price_type', 'auction');
                            
                            if (!empty($auctionCondition)) {
                                foreach ($auctionCondition as $condition) {
                                    $subquery->whereRaw($condition);
                                }
                            }
                        });
                    });
                }
            }
        });
        
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

    public function load_related_ads(Request $request) {
        
        $query = Ad::active();

        // Exclude shown ads
        if ($request->has('shown_ad_ids') && is_array($request->shown_ad_ids)) {
            $query->whereNotIn('id', $request->shown_ad_ids);
        }

        // Apply brand or category filter
        if ($request->brand_id !== 'all') {
            $query->where('brand_id', $request->brand_id);
        } elseif ($request->category_id !== 'all') {
            $query->where('category_id', $request->category_id);
        }

        // Get ads
        $ads = $query->limit(20)->get();

        return response()->json([
            'html' => view('theme-views.partials._ajax-products-view', compact('ads'))->render(),
            'related_ads_count' => $ads->count()
        ]);

    }

    public function load_home_ads(Request $request) {
        
        $limit = $request->input('limit', 15);
        $offset = $request->input('offset', 15);
    
        $query = Ad::active();

        $query->where('category_id', $request->category_id);
        $query->when(session('show_by_country'), fn($q, $country) => $q->country($country['name']));


        $ads = $query->offset($offset)->limit($limit)->get();

        return response()->json([
            'html' => $ads->count() > 0 ? view('theme-views.partials._ajax-home-ads-load', compact('ads'))->render() : null,
            'ads_count' => $ads->count(),
            'show_ad_ids' => $ads->pluck('id')->toArray()
        ]);
        
    }

}















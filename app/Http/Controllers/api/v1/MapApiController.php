<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\CPU\Helpers;

class MapApiController extends Controller
{
    public function place_api_autocomplete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search_text' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }
        $api_key = Helpers::get_business_settings('map_api_key_server');
        $response = Http::get('https://maps.googleapis.com/maps/api/place/autocomplete/json', [
            'input' => $request['search_text'],
            'key' => $api_key,
        ]);
        return $response->json();
    }

    public function distance_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'origin_lat' => 'required|numeric',
            'origin_lng' => 'required|numeric',
            'destination_lat' => 'required|numeric',
            'destination_lng' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }
        $api_key = Helpers::get_business_settings('map_api_key_server');
        $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
            'origins' => $request['origin_lat'] . ',' . $request['origin_lng'],
            'destinations' => $request['destination_lat'] . ',' . $request['destination_lng'],
            'key' => $api_key,
        ]);
        return $response->json();
    }

    public function place_api_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'placeid' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }
        $api_key = Helpers::get_business_settings('map_api_key_server');
        $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
            'placeid' => $request['placeid'],
            'key' => $api_key,
        ]);
        return $response->json();
    }

    public function geocode_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }
        $api_key = Helpers::get_business_settings('map_api_key_server');
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng' => $request->lat . ',' . $request->lng,
            'key' => $api_key,
        ]);
        return $response->json();
    }
}

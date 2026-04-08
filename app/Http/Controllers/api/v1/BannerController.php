<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function get_banners(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'banner_type' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $query = Banner::where('published', 1);

        if ($request['banner_type'] == 'main_banner') {
            $query->where('banner_type', 'Main Banner');
        } elseif ($request['banner_type'] == 'main_section_banner') {
            $query->where('banner_type', 'Main Section Banner');
        } elseif ($request['banner_type'] == 'top_side_banner') {
            $query->where('banner_type', 'Top Side Banner');
        } elseif ($request['banner_type'] == 'footer_banner') {
            $query->where('banner_type', 'Footer Banner');
        }

        $banners = $query->get();

        return response()->json($banners, 200);
    }
}

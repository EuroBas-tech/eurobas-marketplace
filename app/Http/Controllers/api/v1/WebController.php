<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\CPU\ProductManager;
use Illuminate\Http\Request;

class WebController extends Controller
{

    public function searched_ads(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $result = ProductManager::search_ads_web($request['title']);
        $ads = $result['ads'];

        return response()->json($ads, 200);
    }

}

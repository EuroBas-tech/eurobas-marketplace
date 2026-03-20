<?php

namespace App\Http\Controllers\api\v4;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Model\PaidBanner;
use Illuminate\Http\Request;

class PaidBannerController extends Controller
{

    public function get_paid_banners()
    {
        try {
            $banners = Cache::rememberForever('api_paid_banners', function () {
                return PaidBanner::with('package.features', 'category')
                    ->whereHas('package.features', fn($q) =>
                        $q->where('name', 'show_on_home_page')
                    )
                    ->where('status', 1)
                    ->where('is_paid', 1)
                    ->where('expiration_date', '>', now())
                    ->get();
            });

            return response()->json($banners, 200);

        } catch (\Exception $e) {
            Log::error('Failed to fetch paid banners: ' . $e->getMessage());
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

}

<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\CategoryManager;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function get_categories()
    {
        try {
            // Bounded TTL so admin category changes self-heal (admin cache-clear
            // targets the website's own keys, not this one).
            $categories = Cache::remember('api_home_categories', now()->addHours(6), function () {
                return Category::homeEnabled()->priority()->get();
            });
            return response()->json($categories, 200);

        } catch (\Exception $e) {
            Log::error('Failed to fetch home categories: ' . $e->getMessage());
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

    public function get_products(Request $request, $id)
    {
        return response()->json(Helpers::product_data_formatting(CategoryManager::products($id, $request), true), 200);
    }

    public function popular_categories(){
        // Count only active (publicly visible) ads, so the ordering and counts
        // match what the app/website actually show.
        $categories = Category::withCount(['ads' => fn($q) => $q->where('status', 1)])
            ->orderByDesc('ads_count')
            ->take(9)
            ->get();

        return response()->json($categories, 200);
    }
}

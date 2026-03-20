<?php

namespace App\Http\Controllers\api\v4;

use App\CPU\CategoryManager;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function get_categories()
    {
        try {
            $categories = Cache::rememberForever('api_home_categories', function () {
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
        $categories = Category::withCount(['product' => function($query){
                $query->whereHas('order_details', function($query){
                    $query->where('delivery_status', 'delivered');
                })->active();
            }])
            ->orderBy('product_count', 'DESC')
            ->take(9)->get();

        return response()->json($categories, 200);
    }
}

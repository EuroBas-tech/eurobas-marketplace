<?php

namespace App\CPU;

use App\Model\Category;
use App\Model\Product;
use App\CPU\Helpers;

class CategoryManager
{
    public static function parents()
    {
        return Category::with(['childes.childes'])
            ->where('position', 1)
            ->priority()
            ->get();
    }

    public static function child($parent_id)
    {
        return Category::where(['parent_id' => $parent_id])->get();
    }

    public static function products($category_id, $request = null)
    {
        $user = Helpers::get_customer($request);
        $id = '"' . $category_id . '"';
        return Product::with(['rating', 'tags', 'seller.shop'])
            ->withCount(['wish_list' => function ($query) use ($user) {
                $query->where('customer_id', $user != 'offline' ? $user->id : '0');
            }])
            ->active()
            ->where('category_ids', 'like', "%{$id}%")->get();
    }

    public static function get_category_name($id)
    {
        $category = Category::find($id);
        if ($category) {
            return $category->name;
        }
        return '';
    }

    public static function get_categories_with_counting()
    {
        return Category::withCount(['product' => function ($query) {
                $query->where(['status' => '1']);
            }])
            ->with(['childes' => function ($query) {
                $query->withCount(['sub_category_product'])->where('position', 2);
                $query->with(['childes' => function ($q) {
                    $q->withCount(['sub_sub_category_product'])->where('position', 3);
                }]);
            }])
            ->where('position', 1)
            ->get();
    }
}

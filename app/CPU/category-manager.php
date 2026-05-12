<?php

namespace App\CPU;

use App\Model\Category;
use App\Model\Product;

class CategoryManager
{
    public static function parents()
    {
        // تم تغيير 0 إلى 1 لأن قاعدة بياناتك تبدأ من 1
        $x = Category::with(['childes.childes'])->where('position', 1)->priority()->get();
        return $x;
    }

    public static function child($parent_id)
    {
        $x = Category::where(['parent_id' => $parent_id])->get();
        return $x;
    }

    public static function products($category_id, $request=null)
    {
        $user = Helpers::get_customer($request);
        $id = '"'.$category_id.'"';
        return Product::with(['rating','tags','seller.shop'])
            ->withCount(['wish_list' => function($query) use($user){
                $query->where('customer_id', $user != 'offline' ? $user->id : '0');
            }])
            ->active()
            ->where('category_ids', 'like', "%{$id}%")->get();
    }

    public static function get_category_name($id){
        $category = Category::find($id);

        if($category){
            return $category->name;
        }
        return '';
    }

    public static function get_categories_with_counting()
    {
        // تم تعديل المستويات (1 و 2 و 3) لتناسب هيكلة قاعدة بياناتك الحالية
        $categories = Category::withCount(['product'=>function($query){
                        $query->where(['status'=>'1']);
                    }])->with(['childes' => function ($query) {
                        $query->with(['childes' => function ($query) {
                            $query->withCount(['sub_sub_category_product'])->where('position', 3);
                        }])->withCount(['sub_category_product'])->where('position', 2);
                    }, 'childes.childes'])
                    ->where('position', 1)
                    ->get();

        return $categories;
    }
}

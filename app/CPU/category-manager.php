<?php

namespace App\CPU;

use App\Model\Category;
use App\Model\Product;
use Illuminate\Support\Facades\Cache;

class CategoryManager
{
    public static function parents()
    {
        $locale = app()->getLocale();
        
        return Cache::remember('categories_parents_' . $locale, now()->addDays(7), function () use ($locale) {
            return Category::with(['childes.childes', 'translations' => function($query) use ($locale) {
                $query->where('locale', $locale);
            }])
            ->where('position', 1)    
            ->priority()
            ->get();
        });
    }

    public static function child($parent_id)
    {
        $locale = app()->getLocale();
        return Cache::remember('categories_child_' . $parent_id . '_' . $locale, now()->addDays(7), function () use ($parent_id, $locale) {
            return Category::with(['translations' => function($query) use ($locale) {
                $query->where('locale', $locale);
            }])
            ->where(['parent_id' => $parent_id])
            ->get();
        });
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
        $locale = app()->getLocale();
        return Cache::remember('category_name_' . $id . '_' . $locale, now()->addDays(7), function () use ($id, $locale) {
            $category = Category::with(['translations' => function($query) use ($locale) {
                $query->where('locale', $locale);
            }])->find($id);

            if($category){
                return $category->name;
            }
            return '';
        });
    }

    public static function get_categories_with_counting()
    {
        $locale = app()->getLocale();
        return Cache::remember('categories_counting_' . $locale, now()->addDays(7), function () use ($locale) {
            return Category::withCount(['product'=>function($query){
                            $query->where(['status'=>'1']);
                        }])->with(['translations' => function($query) use ($locale) {
                            $query->where('locale', $locale);
                        }, 'childes' => function ($query) use ($locale) {
                            $query->with(['translations' => function($q) use ($locale) {
                                $q->where('locale', $locale);
                            }, 'childes' => function ($query) use ($locale) {
                                $query->with(['translations' => function($q) use ($locale) {
                                    $q->where('locale', $locale);
                                }])->withCount(['sub_sub_category_product'])->where('position', 3);    
                            }])->withCount(['sub_category_product'])->where('position', 2);   
                        }])
                        ->where('position', 1)    
                        ->get();
        });
    }
}

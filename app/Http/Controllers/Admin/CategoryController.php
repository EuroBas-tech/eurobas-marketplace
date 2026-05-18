<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Model\Category;
use App\CPU\ImageManager;
use App\Model\Translation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index( Request $request )
    {
        $query_param = [];
        $search = $request['search'];
        if($request->has('search'))
        {
            $key = explode(' ', $request['search']);
            $categories = Category::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }else{
            $categories=Category::query();
        }
        $categories = $categories->orderby('id')->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.category.category-view',compact('categories','search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'priority'=>'required',
            'category_type'=>'required'
        ], [
            'name.required' => 'Category name is required!',
            'priority.required' => 'Category priority is required!',
            'category_type.required' => 'Main Category is required!',
        ]);
        $category = new Category;
        $category->name = $request->name[array_search('en', $request->lang)];
        $category->slug = Str::slug($request->name[array_search('en', $request->lang)]);
        if ($request->image){
            $category->icon = ImageManager::upload('category/', 'webp', $request->file('image'), 'def.jpg');
        }
        $category->category_type = $request->category_type;
        $category->priority = $request->priority;
        $category->parent_id = (int) ($request->parent_id ?? 0);
        $category->position = (int) ($request->position ?? 0);
        $category->home_status = 1;
        $category->save();

        foreach($request->lang as $index=>$key)
        {
            if($request->name[$index] && $key != 'en')
            {
                Translation::updateOrInsert(
                    ['translationable_type'  => 'App\Model\Category',
                        'translationable_id'    => $category->id,
                        'locale'                => $key,
                        'key'                   => 'name'],
                    ['value'                 => $request->name[$index]]
                );
            }
        }

        $this->flushCategoryCachesSafe();

        Toastr::success(translate('category_updated_successfully'));
        return back();
    }

    public function edit($id)
    {
        $category = Category::with('translations')->withoutGlobalScopes()->find($id);
        return view('admin-views.category.category-edit', compact('category'));
    }

    public function update(Request $request)
    {
        $category = Category::find($request->id);

        $category->name = $request->name[array_search('en', $request->lang)];
        $category->slug = Str::slug($request->name[array_search('en', $request->lang)]);
        $category->category_type = $request->category_type;
        if ($request->image) {
            $category->icon = ImageManager::update('category/', $category->icon, 'webp', $request->file('image'));
        }
        $category->priority = $request->priority;
        $category->save();

        foreach ($request->lang as $index => $key) {
            if ($request->name[$index] && $key != 'en') {
                Translation::updateOrInsert(
                    ['translationable_type' => 'App\Model\Category',
                        'translationable_id' => $category->id,
                        'locale' => $key,
                        'key' => 'name'],
                    ['value' => $request->name[$index]]
                );
            }
        }

        $this->flushCategoryCachesSafe();

        Toastr::success(translate('Category_updated_successfully'));
        return back();
    }

    public function delete(Request $request)
    {
        $categories = Category::where('category_type', $request->id)->get();
        if (!empty($categories)) {

            foreach ($categories as $category) {
                $translation = Translation::where('translationable_type','App\Model\Category')
                                    ->where('translationable_id',$category->id);
                $translation->delete();
                Category::destroy($category->id);
            }
        }
        $translation = Translation::where('translationable_type','App\Model\Category')
                                    ->where('translationable_id',$request->id);
        $translation->delete();
        Category::destroy($request->id);

        $this->flushCategoryCachesSafe();

        return response()->json();
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::orderBy('id', 'desc')->get();
            return response()->json($data);
        }
    }

    public function home_status(Request $request)
    {
        $category = Category::find($request->id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }

        $category->home_status = $category->home_status == 1 ? 0 : 1;
        $category->save();

        $this->flushCategoryCachesSafe();

        return response()->json([
            'success' => true,
            'home_status' => $category->home_status,
        ]);
    }

    private function flushCategoryCachesSafe(): void
    {
        $keys = ['home_categories', 'categories', 'active_brands', 'brands', 'models', 'language'];

        foreach ($keys as $key) {
            try {
                Cache::forget($key);
            } catch (\Throwable $e) {
                // ignore
            }
        }

        try {
            $locales = array_keys((array) config('laravellocalization.supportedLocales'));
            foreach ($locales as $locale) {
                Cache::forget('categories_' . $locale);
                Cache::forget('home_categories_' . $locale);
            }
        } catch (\Throwable $e) {
            // ignore
        }

        foreach (['redis', 'file'] as $store) {
            try {
                Cache::store($store)->flush();
            } catch (\Throwable $e) {
                // store unavailable; skip silently
            }
        }
    }
}

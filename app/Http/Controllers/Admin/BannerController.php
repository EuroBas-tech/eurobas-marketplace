<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Banner;
use App\Model\Translation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BannerController extends Controller
{
    function list(Request $request)
    {
        $banner_types = [
            "Main Banner", 
            "Popup Banner", 
            "Footer Banner",
            "Main Section Banner",
            "Header Banner",
            "Sidebar Banner", 
            "Top Side Banner"
        ];

        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $banners = Banner::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->Where('banner_type', 'like', "%{$value}%");
                }
            })->orderBy('priority', 'desc');
            $query_param = ['search' => $request['search']];
        } else {
            $banners = Banner::orderBy('priority', 'desc');
        }

        if (!is_null($request['lang'])) {
            $banners->where('lang', $request['lang']);
            $query_param['lang'] = $request['lang'];
        }

        if (!is_null($request['for_mobile'])) {
            $banners->where('for_mobile', $request['for_mobile']);
            $query_param['for_mobile'] = $request['for_mobile'];
        }

        $banners = $banners
            ->where('theme', 'theme_aster')
            ->whereIn('banner_type', $banner_types)
            ->orderBy('priority', 'asc')
            ->paginate(Helpers::pagination_limit(), ['*'], 'page')
            ->appends($query_param);

        return view('admin-views.banner.view', compact('banners', 'search', 'request'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'nullable',
            'image' => 'required'
        ]);

        $banner = new Banner;
        $banner->banner_type = $request->banner_type;
        $banner->resource_type = null;
        $banner->resource_id = null;
        
        // حفظ النص باللغة الافتراضية للموقع داخل جدول البنرات
        $banner->title = $request->title[array_search('en', $request->lang)] ?? $request->title[0];
        $banner->sub_title = $request->sub_title[array_search('en', $request->lang)] ?? $request->sub_title[0];
        
        $banner->theme = 'theme_aster';
        $banner->button_text = $request->button_text;
        $banner->background_color = $request->background_color;
        $banner->url = $request->url;
        $banner->lang = $request->lang_input ?? 'Both';
        $banner->for_mobile = $request->for_mobile;
        $banner->priority = $request->priority;
        $banner->photo = ImageManager::upload('banner/', 'webp', $request->file('image'), 'def.jpg');

        if (\Illuminate\Support\Facades\Schema::hasColumn('banners', 'show_text')) {
            $banner->show_text     = $request->has('show_text') ? 1 : 0;
            $banner->text_position = $request->text_position ?? 'center';
            $banner->text_size     = $request->text_size ?? 'large';
            $banner->text_color    = $request->text_color ?? 'white';
        }

        $banner->save();

        // حفظ الترجمات المتعددة في جدول اللغات للموقع
        foreach ($request->lang as $index => $key) {
            if (isset($request->title[$index]) && $request->title[$index] != '') {
                Translation::updateOrInsert(
                    [
                        'translationable_type' => 'App\Model\Banner',
                        'translationable_id'   => $banner->id,
                        'locale'               => $key,
                        'key'                  => 'title'
                    ],
                    ['value' => $request->title[$index]]
                );
            }
            if (isset($request->sub_title[$index]) && $request->sub_title[$index] != '') {
                Translation::updateOrInsert(
                    [
                        'translationable_type' => 'App\Model\Banner',
                        'translationable_id'   => $banner->id,
                        'locale'               => $key,
                        'key'                  => 'sub_title'
                    ],
                    ['value' => $request->sub_title[$index]]
                );
            }
        }

        Cache::forget('main_banners');
        Toastr::success(translate('banner_added_successfully'));
        return back();
    }

    public function edit($id)
    {
        $banner = Banner::where('id', $id)->first();
        return view('admin-views.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'url' => 'nullable',
        ]);

        $banner = Banner::find($id);
        $banner->banner_type = $request->banner_type;
        
        // تحديث النص باللغة الافتراضية
        $banner->title = $request->title[array_search('en', $request->lang)] ?? $request->title[0];
        $banner->sub_title = $request->sub_title[array_search('en', $request->lang)] ?? $request->sub_title[0];
        
        $banner->button_text = $request->button_text;
        $banner->background_color = $request->background_color;
        $banner->lang = $request->lang_input ?? 'Both';
        $banner->for_mobile = $request->for_mobile;
        $banner->url = $request->url;
        $banner->priority = $request->priority;
        
        if ($request->file('image')) {
            $banner->photo = ImageManager::update('banner/', $banner['photo'], 'webp', $request->file('image'));
        }

        if (\Illuminate\Support\Facades\Schema::hasColumn('banners', 'show_text')) {
            $banner->show_text     = $request->has('show_text') ? 1 : 0;
            $banner->text_position = $request->text_position ?? 'center';
            $banner->text_size     = $request->text_size ?? 'large';
            $banner->text_color    = $request->text_color ?? 'white';
        }

        $banner->save();

        // تحديث الترجمات المتعددة في جدول اللغات للموقع
        foreach ($request->lang as $index => $key) {
            if (isset($request->title[$index]) && $request->title[$index] != '') {
                Translation::updateOrInsert(
                    [
                        'translationable_type' => 'App\Model\Banner',
                        'translationable_id'   => $banner->id,
                        'locale'               => $key,
                        'key'                  => 'title'
                    ],
                    ['value' => $request->title[$index]]
                );
            }
            if (isset($request->sub_title[$index]) && $request->sub_title[$index] != '') {
                Translation::updateOrInsert(
                    [
                        'translationable_type' => 'App\Model\Banner',
                        'translationable_id'   => $banner->id,
                        'locale'               => $key,
                        'key'                  => 'sub_title'
                    ],
                    ['value' => $request->sub_title[$index]]
                );
            }
        }

        Cache::forget('main_banners');
        Toastr::success(translate('banner_updated_successfully'));
        return back();
    }

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $banner = Banner::find($request->id);
            $banner->published = $request->status ?? 0;
            $banner->save();
            Cache::forget('main_banners');
            return response()->json($request->status ?? 0);
        }
    }

    public function delete(Request $request)
    {
        $br = Banner::find($request->id);
        ImageManager::delete('/banner/' . $br['photo']);
        Banner::where('id', $request->id)->delete();
        Cache::forget('main_banners');
        return response()->json();
    }
}

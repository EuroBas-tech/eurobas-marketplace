<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Banner;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BannerController extends Controller
{

    function list(Request $request)
    {

        $banner_types = [];
        $lang = $request['lang'] ?? null;
        $for_mobile = $request['for_mobile'] ?? null;
        
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

        if (!is_null($lang)) {
            $banners->where('lang', $lang);
            $query_param['lang'] = $lang;
        }

        if (!is_null($for_mobile)) {
            $banners->where('for_mobile', $for_mobile);
            $query_param['for_mobile'] = $for_mobile;
        }

        $banners = $banners
        ->where('theme', 'theme_aster')
        ->whereIn('banner_type', $banner_types)
        ->orderBy('priority', 'asc')
        ->paginate(Helpers::pagination_limit(), ['*'], 'page')
        ->appends($query_param);

        return view('admin-views.banner.view', compact('banners', 'search','lang','for_mobile'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'url' => 'nullable',
        ], [
            'url.required' => 'url is required!',
            'image.required' => 'Image is required!',

        ]);

        $photo = ImageManager::upload('banner/', 'webp', $request->file('image'), 'def.jpg');

        Banner::insert([
            'banner_type'      => $request->banner_type,
            'resource_type'    => null,
            'resource_id'      => null,
            'title'            => $request->title,
            'theme'            => 'theme_aster',
            'sub_title'        => $request->sub_title,
            'button_text'      => $request->button_text,
            'background_color' => $request->background_color,
            'url'              => $request->url,
            'lang'             => $request->lang,
            'for_mobile'       => $request->for_mobile,
            'priority'         => $request->priority,
            'photo'            => $photo,
            'show_text'        => $request->has('show_text') ? 1 : 0,
            'text_position'    => $request->text_position ?? 'center',
            'text_size'        => $request->text_size ?? 'large',
            'text_color'       => $request->text_color ?? 'white',
            'published'        => 1,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        Cache::forget('main_banners');

        Toastr::success(translate('banner_added_successfully'));
        return back();
    }

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $banner = Banner::find($request->id);
            $banner->published = $request->status ?? 0;
            $banner->save();

            Cache::forget('main_banners');

            $data = $request->status ?? 0;
            return response()->json($data);
        }
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
        ], [
            'url.required' => 'url is required!',
        ]);

        $banner = Banner::find($id);

        $updateData = [
            'banner_type'      => $request->banner_type,
            'resource_type'    => $request->resource_type,
            'resource_id'      => $request[$request->resource_type . '_id'],
            'title'            => $request->title,
            'sub_title'        => $request->sub_title,
            'button_text'      => $request->button_text,
            'background_color' => $request->background_color,
            'lang'             => $request->lang,
            'for_mobile'       => $request->for_mobile,
            'url'              => $request->url,
            'priority'         => $request->priority,
            'show_text'        => $request->has('show_text') ? 1 : 0,
            'text_position'    => $request->text_position ?? 'center',
            'text_size'        => $request->text_size ?? 'large',
            'text_color'       => $request->text_color ?? 'white',
        ];

        if ($request->file('image')) {
            $updateData['photo'] = ImageManager::update('banner/', $banner['photo'], 'webp', $request->file('image'));
        }

        Banner::where('id', $id)->update($updateData);

        Cache::forget('main_banners');

        Toastr::success(translate('banner_updated_successfully'));
        return back();
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

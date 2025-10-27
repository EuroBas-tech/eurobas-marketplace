<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Banner;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

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
        ->where('theme', theme_root_path())
        ->whereIn('banner_type', $banner_types)
        ->orderBy('priority', 'asc')
        ->paginate(Helpers::pagination_limit(), ['*'], 'page')
        ->appends($query_param);

        return view('admin-views.banner.view', compact('banners', 'search','lang','for_mobile'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'url' => 'required',
            'image' => 'required',
        ], [
            'url.required' => 'url is required!',
            'image.required' => 'Image is required!',

        ]);

        $banner = new Banner;
        $banner->banner_type = $request->banner_type;
        $banner->resource_type = null;
        $banner->resource_id = null;
        $banner->title = $request->title;
        $banner->theme = 'theme_aster';
        $banner->sub_title = $request->sub_title;
        $banner->button_text = $request->button_text;
        $banner->background_color = $request->background_color;
        $banner->url = $request->url;
        $banner->lang = $request->lang;
        $banner->for_mobile = $request->for_mobile;
        $banner->priority = $request->priority;
        $banner->photo = ImageManager::upload('banner/', 'webp', $request->file('image'), 'def.jpg');
        $banner->save();

        Toastr::success(translate('banner_added_successfully'));
        return back();
    }

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $banner = Banner::find($request->id);
            $banner->published = $request->status ?? 0;
            $banner->save();
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
            'url' => 'required',
        ], [
            'url.required' => 'url is required!',
        ]);

        $banner = Banner::find($id);
        $banner->banner_type = $request->banner_type;
        $banner->resource_type = $request->resource_type;
        $banner->resource_id = $request[$request->resource_type . '_id'];
        $banner->title = $request->title;
        $banner->sub_title = $request->sub_title;
        $banner->button_text = $request->button_text;
        $banner->background_color = $request->background_color;
        $banner->lang = $request->lang;
        $banner->for_mobile = $request->for_mobile;
        $banner->url = $request->url;
        $banner->priority = $request->priority;
        if ($request->file('image')) {
            $banner->photo = ImageManager::update('banner/', $banner['photo'], 'webp', $request->file('image'));
        }
        $banner->save();

        Toastr::success(translate('banner_updated_successfully'));
        return back();
    }

    public function delete(Request $request)
    {
        $br = Banner::find($request->id);
        ImageManager::delete('/banner/' . $br['photo']);
        Banner::where('id', $request->id)->delete();
        return response()->json();
    }
}

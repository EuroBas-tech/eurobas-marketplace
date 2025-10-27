<?php

namespace App\Http\Controllers\Admin;

use App\Model\Ad;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;

class AdController extends Controller
{
    
    public function list(Request $request) {
        $query_param = [];
        $search = $request['search'];

        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $ads = Ad::with(['user'])
            ->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('title', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $ads = Ad::with(['user']);
        }
                
        $ads = $ads->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.ads.list', compact('ads', 'search'));
    }

    public function status_update(Request $request)
    {
        Ad::where(['id' => $request['id']])->update([
            'status' => $request['status'] ?? 0
        ]);

        Toastr::success(translate('ad_status_updated_successfully'));
        return back();
    }

    public function delete(Request $request) {
        $ad = Ad::find($request['id']);
        $ad->delete();

        Toastr::success(translate('ad_deleted_successfully'));
        return back();
    }


}

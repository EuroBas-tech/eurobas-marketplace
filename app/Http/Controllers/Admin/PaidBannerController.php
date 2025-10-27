<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Model\PaidBanner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Cache;

class PaidBannerController extends Controller
{
    
    public function list(Request $request) {
        $query_param = [];
        $search = $request['search'];

        if ($request->has('search')) {
            $key = explode(' ', $request['search']);

            $paid_banners = PaidBanner::with(['user'])
            ->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('duration_in_days', 'like', "%{$value}%")
                    ->orWhere('price', 'like', "%{$value}%")
                    ->orWhereHas('user', function ($userQuery) use ($value) {
                        $userQuery->where('name', 'like', "%{$value}%");
                    });
                }
            });
            
            $query_param = ['search' => $request['search']];
        } else {
            $paid_banners = PaidBanner::with(['user']);
        }
                
        $paid_banners = $paid_banners->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.paid-banners.list', compact('paid_banners', 'search'));
    }

    public function status_update(Request $request)
    {
        PaidBanner::where(['id' => $request['id']])->update([
            'status' => $request['status'] ?? 0
        ]);

        Cache::forget('main_banners');

        Toastr::success(translate('banner_status_updated_successfully'));
        return back();
    }

    public function delete(Request $request, $id) {
        $paid_banners = PaidBanner::find($id);
        $paid_banners->delete();

        Cache::forget('main_banners');

        Toastr::success(translate('banner_deleted_successfully'));
        return back();
    }


}

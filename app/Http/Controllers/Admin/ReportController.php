<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\CPU\Helpers;
use App\Model\Order;
use App\Model\Seller;
use App\Model\Product;
use App\Model\AdReport;
use Carbon\CarbonPeriod;
use App\CPU\BackEndHelper;
use App\Model\SellerWallet;
use App\Model\RefundRequest;
use Illuminate\Http\Request;
use App\Model\BusinessSetting;
use App\Model\OrderTransaction;
use App\Model\RefundTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Brian2694\Toastr\Facades\Toastr;
use Rap2hpoutre\FastExcel\FastExcel;

class ReportController extends Controller
{
    
    public function list(Request $request) {

        $search      = $request['search'];
        $query_param = $search ? ['search' => $request['search']] : '';

        $reports = AdReport::withCount('ad')
            ->with('user')
            ->when($request['search'], function ($q) use($request){
                $key = explode(' ', $request['search']);
                foreach ($key as $value) {
                    $q->Where('message', 'like', "%{$value}%")
                      ->orWhere('id', $value);
                }
            })
            ->latest()->paginate(Helpers::pagination_limit())->appends($query_param);

        return view('admin-views.report.list', compact('reports','search'));
        
    }
    
    public function view($id) {

        $report = AdReport::with('ad')->findOrFail($id);

        return view('admin-views.report.view', compact('report'));
    }

    public function confirm($id) {
        $report = AdReport::findOrFail($id);

        $report->status = 1;

        $report->save();

        Toastr::success(translate('Ad Report status changed to confirmed successfully'));
        return redirect()->route('admin.report.list');

    }

    public function delete(Request $request) {

        $report = AdReport::findOrFail($request->id);

        $report->delete();

        Toastr::success(translate('Ad Report deleted successfully'));
        return redirect()->route('admin.report.list');

    }


}

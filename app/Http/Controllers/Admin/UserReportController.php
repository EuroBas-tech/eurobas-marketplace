<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Model\UserReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

/**
 * Milestone 2 — Admin review of user reports raised from chat / seller profile.
 */
class UserReportController extends Controller
{
    public function list(Request $request)
    {
        $search      = $request['search'];
        $query_param = $search ? ['search' => $search] : '';

        $reports = UserReport::with(['reporter', 'reported'])
            ->when($search, function ($q) use ($search) {
                $key = explode(' ', $search);
                foreach ($key as $value) {
                    $q->where('message', 'like', "%{$value}%")
                        ->orWhere('reason', 'like', "%{$value}%")
                        ->orWhere('id', $value);
                }
            })
            ->latest()
            ->paginate(Helpers::pagination_limit())
            ->appends($query_param);

        return view('admin-views.user-report.list', compact('reports', 'search'));
    }

    public function view($id)
    {
        $report = UserReport::with(['reporter', 'reported', 'chatting'])->findOrFail($id);
        return view('admin-views.user-report.view', compact('report'));
    }

    public function status(Request $request)
    {
        $report = UserReport::findOrFail($request->id);
        $report->status = $request->status; // pending | reviewed | dismissed
        $report->save();

        Toastr::success(translate('report_status_updated_successfully'));
        return back();
    }

    public function delete(Request $request)
    {
        $report = UserReport::findOrFail($request->id);
        $report->delete();

        Toastr::success(translate('report_deleted_successfully'));
        return back();
    }
}

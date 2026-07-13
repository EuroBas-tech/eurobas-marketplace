<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Model\Cost;
use App\CPU\Helpers;
use App\CPU\Convert;
use App\CPU\BackEndHelper;
use App\Model\AdminWallet;
use App\Model\BusinessSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Brian2694\Toastr\Toastr; // تم ضبطها لتتوافق مع نظامك الحالي
use App\Http\Controllers\Controller;
use Carbon\CarbonPeriod;

class AccountingController extends Controller
{
    // EU VAT rates
    const EU_VAT_RATES = [
        'AT'=>20,'BE'=>21,'BG'=>20,'CY'=>19,'CZ'=>21,
        'DE'=>19,'DK'=>25,'EE'=>22,'ES'=>21,'FI'=>24,
        'FR'=>20,'GR'=>24,'HR'=>25,'HU'=>27,'IE'=>23,
        'IT'=>22,'LT'=>21,'LU'=>17,'LV'=>21,'MT'=>18,
        'NL'=>21,'PL'=>23,'PT'=>23,'RO'=>19,'SE'=>25,
        'SI'=>22,'SK'=>20,
    ];

    // ── MAIN DASHBOARD ─────────────────────────────
    public function index(Request $request)
    {
        $date_type = $request->input('date_type', 'this_year');
        $from      = $request->input('from');
        $to        = $request->input('to');

        // جلب فلتر التاريخ الأساسي لتوافق ملف الـ Blade والمخططات
        $filter_data = $this->earning_common_filter($request);

        if($date_type == 'this_year' || $date_type == 'custom_date' && (Carbon::parse($from)->diffInDays(Carbon::parse($to)) > 365) || $date_type == 'different_year') {
            return $this->earning_different_year($request, $filter_data);
        }

        $txAll = $this->txQuery($date_type, $from, $to)->get();

        // Revenue
        $grossRevenue  = $txAll->sum('gross_amount');
        $gatewayFees   = $txAll->sum('gateway_fee');
        $vatCollected  = $txAll->sum('vat_amount');
        $netRevenue    = $txAll->sum('net_amount');

        // Gateway breakdown
        $stripeTotal = $txAll->where('gateway','stripe')->sum('gross_amount');
        $paypalTotal = $txAll->where('gateway','paypal')->sum('gross_amount');
        $stripeFees  = $txAll->where('gateway','stripe')->sum('gateway_fee');
        $paypalFees  = $txAll->where('gateway','paypal')->sum('gateway_fee');

        // Package breakdown
        $packageBreakdown = $txAll->groupBy('package_type')
            ->map(fn($g) => [
                'type'  => $g->first()->package_type ?? 'Unknown',
                'count' => $g->count(),
                'gross' => $g->sum('gross_amount'),
                'net'   => $g->sum('net_amount'),
            ])->values();

        // EU vs Non-EU
        $euRevenue    = $txAll->where('is_eu',1)->sum('gross_amount');
        $nonEuRevenue = $txAll->where('is_eu',0)->sum('gross_amount');

        // VAT per EU country (for OSS)
        $vatByCountry = $txAll->where('is_eu',1)
            ->groupBy('user_country')
            ->map(fn($g) => [
                'country'    => $g->first()->user_country,
                'vat_rate'   => $g->first()->vat_rate,
                'gross'      => $g->sum('gross_amount'),
                'vat_amount' => $g->sum('vat_amount'),
                'count'      => $g->count(),
            ])->values();

        // Costs & Expenses
        $costsAndExpenses = $this->costQuery($date_type, $from, $to)->sum('amount');

        // Net Profit
        $netProfit = $netRevenue - $costsAndExpenses;
        $txCount   = $txAll->count();

        // Recent 10 transactions
        $recentTx = $this->txQuery($date_type, $from, $to)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // تجهيز المخطط البياني (Chart) بناءً على المعاملات الجديدة المفلترة
        $chart_data = [];
        $period = CarbonPeriod::create($filter_data['start_date'], $filter_data['end_date']);
        foreach ($period as $date) {
            $day = $date->format('d');
            $month = $date->format('m');
            $year = $date->format('Y');

            $day_gross = $txAll->filter(function($tx) use ($day, $month, $year) {
                $txDate = Carbon::parse($tx->created_at);
                return $txDate->format('d') == $day && $txDate->format('m') == $month && $txDate->format('Y') == $year;
            })->sum('gross_amount');

            if($date_type == 'this_month' || $date_type == 'custom_date' && (Carbon::parse($from)->diffInDays(Carbon::parse($to)) <= 365)) {
                $chart_data['earnings'][$date->format('d-M')] = $day_gross;
            } else if($date_type == 'this_week') {
                $chart_data['earnings'][$date->format('D')] = $day_gross;
            } else {
                $chart_data['earnings'][$date->format('d-M')] = $day_gross;
            }
        }

        // إرسال البيانات المحدثة إلى القالب الجديد index.blade.php
        return view('admin-views.accounting.index', compact(
            'grossRevenue','gatewayFees','vatCollected','netRevenue',
            'stripeTotal','paypalTotal','stripeFees','paypalFees',
            'packageBreakdown','euRevenue','nonEuRevenue',
            'vatByCountry','costsAndExpenses','netProfit',
            'txCount','recentTx','date_type','from','to', 'chart_data'
        ));
    }

    // ── COSTS & EXPENSES ───────────────────────────
    public function get_costs(Request $request)
    {
        $date_type = $request->input('date_type', 'this_year');
        $from      = $request->input('from');
        $to        = $request->input('to');
        $search    = $request->input('search');

        $costs = $this->dateFilter(
            Cost::when($search, fn($q) =>
                $q->where('title','like',"%{$search}%")
                  ->orWhere('description','like',"%{$search}%")
            ),
            $date_type, $from, $to
        )->orderByDesc('id')->paginate(Helpers::pagination_limit());

        return view('admin-views.accounting.get-costs-and-expenses',
            compact('costs','date_type','from','to','search'));
    }

    public function store_costs(Request $request)
    {
        $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'amount'      => 'required|numeric|min:0',
        ]);

        Cost::create([
            'title'       => $request->title,
            'description' => $request->description,
            'amount'      => Convert::usd($request->amount),
        ]);

        Toastr::success(Helpers::translate('cost_added_successfully'));
        return back();
    }

    public function update_costs(Request $request)
    {
        $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'amount'      => 'required|numeric|min:0',
        ]);

        Cost::where('id', $request->id)->update([
            'title'       => $request->title,
            'description' => $request->description,
            'amount'      => Convert::usd($request->amount),
        ]);

        Toastr::success(Helpers::translate('cost_updated_successfully'));
        return back();
    }

    public function delete_costs(Request $request)
    {
        Cost::where('id', $request->id)->delete();
        Toastr::success(Helpers::translate('cost_deleted_successfully'));
        return back();
    }

    // ── PDF EXPORTS ────────────────────────────────

    public function platform_finance_pdf(Request $request)
    {
        $date_type = $request->input('date_type', 'this_year');
        $from      = $request->input('from');
        $to        = $request->input('to');

        $txAll = $this->txQuery($date_type, $from, $to)->get();

        $data = [
            'grossRevenue'     => $txAll->sum('gross_amount'),
            'gatewayFees'      => $txAll->sum('gateway_fee'),
            'vatCollected'     => $txAll->sum('vat_amount'),
            'netRevenue'       => $txAll->sum('net_amount'),
            'costsAndExpenses' => $this->costQuery($date_type,$from,$to)->sum('amount'),
            'vatByCountry'     => $txAll->where('is_eu',1)->groupBy('user_country')
                ->map(fn($g) => [
                    'country'    => $g->first()->user_country,
                    'vat_rate'   => $g->first()->vat_rate,
                    'gross'      => $g->sum('gross_amount'),
                    'vat_amount' => $g->sum('vat_amount'),
                ])->values(),
            'date_type' => $date_type, 'from' => $from, 'to' => $to,
        ];
        $data['netProfit'] = $data['netRevenue'] - $data['costsAndExpenses'];

        $mpdf_view = View::make('admin-views.accounting.pdf.admin-earning-pdf',
            $data + $this->companyInfo());

        Helpers::gen_mpdf($mpdf_view, 'platform_finance_', rand(1000,9999).time());
    }

    public function tax_report_pdf(Request $request)
    {
        $date_type = $request->input('date_type', 'this_year');
        $from      = $request->input('from');
        $to        = $request->input('to');

        $txAll         = $this->txQuery($date_type, $from, $to)->get();
        $euTx          = $txAll->where('is_eu',1);

        $vatByCountry  = $euTx->groupBy('user_country')
            ->map(fn($g) => [
                'country'    => $g->first()->user_country,
                'vat_rate'   => $g->first()->vat_rate,
                'gross'      => $g->sum('gross_amount'),
                'vat_amount' => $g->sum('vat_amount'),
                'count'      => $g->count(),
            ])->values();

        $data = [
            'vatByCountry'  => $vatByCountry,
            'totalEuGross'  => $euTx->sum('gross_amount'),
            'totalVat'      => $euTx->sum('vat_amount'),
            'nonEuRevenue'  => $txAll->where('is_eu',0)->sum('gross_amount'),
            'date_type'     => $date_type, 'from' => $from, 'to' => $to,
        ];

        $mpdf_view = View::make('admin-views.accounting.pdf.admin-earning-pdf',
            $data + $this->companyInfo());

        Helpers::gen_mpdf($mpdf_view, 'vat_tax_report_', rand(1000,9999).time());
    }

    public function pdf_costs_and_expenses(Request $request)
    {
        $cost      = Cost::find($request->id);
        $mpdf_view = View::make('admin-views.accounting.pdf.cost-wise-pdf',
            compact('cost') + $this->companyInfo());
        Helpers::gen_mpdf($mpdf_view, 'cost_', rand(1000,9999).time());
    }

    public function cost_summary_pdf(Request $request)
    {
        $date_type  = $request->input('date_type', 'this_year');
        $from       = $request->input('from');
        $to         = $request->input('to');
        $search     = $request->input('search');

        $costs = $this->dateFilter(
            Cost::when($search, fn($q) =>
                $q->where('title','like',"%{$search}%")
                  ->orWhere('description','like',"%{$search}%")
            ),
            $date_type, $from, $to
        )->orderByDesc('id')->get();

        $amount_sum = $costs->sum('amount');
        $mpdf_view  = View::make('admin-views.accounting.pdf.cost-summary',
            compact('costs','amount_sum','date_type','from','to') + $this->companyInfo());

        Helpers::gen_mpdf($mpdf_view, 'cost_summary_', rand(1000,9999).time());
    }

    // ── HELPERS & FILTERS REQUIRED BY SYSTEM ────────────────────────────────────

    private function txQuery(string $dateType, $from, $to)
    {
        return $this->dateFilter(
            DB::table('admin_wallet_actions')
                ->whereNotNull('gateway')
                ->whereNotNull('transaction_id')
                ->where('gross_amount', '>', 0),
            $dateType, $from, $to
        );
    }

    private function costQuery(string $dateType, $from, $to)
    {
        return $this->dateFilter(Cost::query(), $dateType, $from, $to);
    }

    public function dateFilter($query, string $dateType, $from, $to)
    {
        return $query
            ->when($dateType === 'this_year',
                fn($q) => $q->whereYear('created_at', date('Y')))
            ->when($dateType === 'this_month',
                fn($q) => $q->whereYear('created_at', date('Y'))
                             ->whereMonth('created_at', date('m')))
            ->when($dateType === 'this_week',
                fn($q) => $q->whereBetween('created_at',
                    [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]))
            ->when($dateType === 'custom_date' && $from && $to,
                fn($q) => $q->whereDate('created_at', '>=', $from)
                             ->whereDate('created_at', '<=', $to));
    }

    // دالة الفلترة المضافة لضمان عمل القوالب الجديدة والتقويم الزمني بدون انهيار
    public function earning_common_filter($request){
        $from = $request['from'];
        $to = $request['to'];
        $date_type = $request['date_type'] ?? 'this_year';

        if ($date_type == 'this_year') {
            $start_date = date('Y-01-01');
            $end_date = date('Y-12-31');
        } else if ($date_type == 'this_month') {
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-t');
        } else if ($date_type == 'this_week') {
            $start_date = Carbon::now()->startOfWeek()->format('Y-m-d');
            $end_date = Carbon::now()->endOfWeek()->format('Y-m-d');
        } else if ($date_type == 'custom_date') {
            $start_date = $from;
            $end_date = $to;
        }

        return [
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }

    // دالة الفلترة السنوية للمخططات البيانية مضافة ليتوافق نظام العرض الجديد والقديم
    public function earning_different_year($request, $data){
        $from = $request['from'];
        $to = $request['to'];
        $date_type = $request['date_type'] ?? 'this_year';

        if ($date_type == 'this_year') {
            $start_date = date('Y-01-01');
            $end_date = date('Y-12-31');
        } else if ($date_type == 'custom_date') {
            $start_date = $from;
            $end_date = $to;
        }

        $from_year = date('Y', strtotime($start_date));
        $to_year = date('Y', strtotime($end_date));

        $txAll = $this->txQuery($date_type, $from, $to)->get();
        $gross_revenue_array = [];

        for ($inc = $from_year; $inc <= $to_year; $inc++) {
            $gross_revenue_array[$inc] = $txAll->filter(function($tx) use ($inc) {
                return Carbon::parse($tx->created_at)->format('Y') == $inc;
            })->sum('gross_amount');
        }

        // إرسال المصفوفة المتوافقة مع المخطط السنوي للـ View
        return view('admin-views.accounting.index', [
            'grossRevenue' => $txAll->sum('gross_amount'),
            'gatewayFees'  => $txAll->sum('gateway_fee'),
            'vatCollected' => $txAll->sum('vat_amount'),
            'netRevenue'   => $txAll->sum('net_amount'),
            'costsAndExpenses' => $this->costQuery($date_type,$from,$to)->sum('amount'),
            'stripeTotal'  => $txAll->where('gateway','stripe')->sum('gross_amount'),
            'paypalTotal'  => $txAll->where('gateway','paypal')->sum('gross_amount'),
            'stripeFees'   => $txAll->where('gateway','stripe')->sum('gateway_fee'),
            'paypalFees'   => $txAll->where('gateway','paypal')->sum('gateway_fee'),
            'packageBreakdown' => collect([]),
            'euRevenue'    => $txAll->where('is_eu',1)->sum('gross_amount'),
            'nonEuRevenue' => $txAll->where('is_eu',0)->sum('gross_amount'),
            'vatByCountry' => collect([]),
            'netProfit'    => $txAll->sum('net_amount') - $this->costQuery($date_type,$from,$to)->sum('amount'),
            'txCount'      => $txAll->count(),
            'recentTx'     => $txAll->take(10),
            'date_type'    => $date_type, 'from' => $from, 'to' => $to,
            'chart_data'   => ['earnings' => $gross_revenue_array]
        ]);
    }

    private function companyInfo(): array
    {
        return [
            'company_name'     => BusinessSetting::where('type','company_name')->value('value')     ?? 'EuroBas',
            'company_email'    => BusinessSetting::where('type','company_email')->value('value')    ?? '',
            'company_phone'    => BusinessSetting::where('type','company_phone')->value('value')    ?? '',
            'company_web_logo' => BusinessSetting::where('type','company_web_logo')->value('value') ?? '',
        ];
    }
}

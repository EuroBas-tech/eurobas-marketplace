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
use Brian2694\Toastr\Toastr;
use App\Http\Controllers\Controller;
use Carbon\CarbonPeriod;

class AccountingController extends Controller
{
    
    const EU_VAT_RATES = [
        'AT'=>20,'BE'=>21,'BG'=>20,'CY'=>19,'CZ'=>21,
        'DE'=>19,'DK'=>25,'EE'=>22,'ES'=>21,'FI'=>24,
        'FR'=>20,'GR'=>24,'HR'=>25,'HU'=>27,'IE'=>23,
        'IT'=>22,'LT'=>21,'LU'=>17,'LV'=>21,'MT'=>18,
        'NL'=>21,'PL'=>23,'PT'=>23,'RO'=>19,'SE'=>25,
        'SI'=>22,'SK'=>20,
    ];

     
    public function index(Request $request)
    {
        $date_type = $request->input('date_type', 'this_year');
        $from      = $request->input('from');
        $to        = $request->input('to');

     
        $txAll = $this->txQuery($date_type, $from, $to)->get();

    
        $grossRevenue  = $txAll->sum('gross_amount');
        $gatewayFees   = $txAll->sum('gateway_fee');
        $vatCollected  = $txAll->sum('vat_amount');
        $netRevenue    = $txAll->sum('net_amount');

        // تفصيل الأرباح والرسوم حسب بوابات الدفع المستخدمة (Stripe & PayPal)
        $stripeTotal = $txAll->where('gateway','stripe')->sum('gross_amount');
        $paypalTotal = $txAll->where('gateway','paypal')->sum('gross_amount');
        $stripeFees  = $txAll->where('gateway','stripe')->sum('gateway_fee');
        $paypalFees  = $txAll->where('gateway','paypal')->sum('gateway_fee');

        // حساب مبيعات الحزم والاشتراكات وتقسيماتها المطلوبة في الـ Blade
        $packageBreakdown = $txAll->groupBy('package_type')
            ->map(fn($g) => [
                'type'  => $g->first()->package_type ?? 'Unknown',
                'count' => $g->count(),
                'gross' => $g->sum('gross_amount'),
                'net'   => $g->sum('net_amount'),
            ])->values();

        // توزيع الأرباح جغرافياً (داخل الاتحاد الأوروبي وخارجه)
        $euRevenue    = $txAll->where('is_eu', 1)->sum('gross_amount');
        $nonEuRevenue = $txAll->where('is_eu', 0)->sum('gross_amount');

        // تقرير نظام نافذة OSS الضريبية للدول الأوروبية (تم تعديلها لتظل كمجموعة Collection من أجل دالة count)
        $vatByCountry = $txAll->where('is_eu', 1)
            ->groupBy('user_country')
            ->map(fn($g) => [
                'country'    => $g->first()->user_country,
                'vat_rate'   => $g->first()->vat_rate ?? 0,
                'gross'      => $g->sum('gross_amount'),
                'vat_amount' => $g->sum('vat_amount'),
                'count'      => $g->count(),
            ]);

        // جلب إجمالي المصاريف الإدارية المضافة
        $costsAndExpenses = $this->costQuery($date_type, $from, $to)->sum('amount');

        // صافي الأرباح النهائي والمستهدف
        $netProfit = $netRevenue - $costsAndExpenses;
        
        // إجمالي الحركات وأحدث 10 حركات لعرضها في الجدول
        $txCount  = $txAll->count();
        $recentTx = $txAll->take(10);

        return view('admin-views.accounting.index', compact(
            'grossRevenue', 'gatewayFees', 'vatCollected', 'netRevenue',
            'stripeTotal', 'paypalTotal', 'stripeFees', 'paypalFees',
            'packageBreakdown', 'euRevenue', 'nonEuRevenue',
            'vatByCountry', 'costsAndExpenses', 'netProfit',
            'txCount', 'recentTx', 'date_type', 'from', 'to'
        ));
    }

    // ── قسم إدارة المصاريف والتكاليف ──
    public function get_costs(Request $request)
    {
        $date_type = $request->input('date_type', 'this_year');
        $from      = $request->input('from');
        $to        = $request->input('to');
        $search    = $request->input('search');

        $costs = $this->dateFilter(
            Cost::when($search, fn($q) =>
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
            ),
            $date_type, $from, $to
        )->orderByDesc('id')->paginate(Helpers::pagination_limit());

        return view('admin-views.accounting.get-costs-and-expenses', compact('costs', 'date_type', 'from', 'to', 'search'));
    }

    // لتفادي أي خطأ في ملفات الراوت (admin.php) التي تستدعي الاسم القصير
    public function costs(Request $request) {
        return $this->get_costs($request);
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

    // ── تصدير التقارير بصيغة PDF ──
    public function platform_finance_pdf(Request $request)
    {
        $date_type = $request->input('date_type', 'this_year');
        $from      = $request->input('from');
        $to        = $request->input('to');

        $txAll = $this->txQuery($date_type, $from, $to)->get();
        $costsAndExpenses = $this->costQuery($date_type, $from, $to)->sum('amount');
        $netRevenue = $txAll->sum('net_amount');

        $data = [
            'grossRevenue'     => $txAll->sum('gross_amount'),
            'gatewayFees'      => $txAll->sum('gateway_fee'),
            'vatCollected'     => $txAll->sum('vat_amount'),
            'netRevenue'       => $netRevenue,
            'costsAndExpenses' => $costsAndExpenses,
            'vatByCountry'     => $txAll->where('is_eu', 1)->groupBy('user_country')
                ->map(fn($g) => [
                    'country'    => $g->first()->user_country,
                    'vat_rate'   => $g->first()->vat_rate ?? 0,
                    'gross'      => $g->sum('gross_amount'),
                    'vat_amount' => $g->sum('vat_amount'),
                ])->values(),
            'date_type' => $date_type, 'from' => $from, 'to' => $to,
            'netProfit' => $netRevenue - $costsAndExpenses
        ];

        $mpdf_view = View::make('admin-views.accounting.pdf.admin-earning-pdf', $data + $this->companyInfo());
        Helpers::gen_mpdf($mpdf_view, 'platform_finance_', rand(1000, 9999) . time());
    }

    public function tax_report_pdf(Request $request)
    {
        $date_type = $request->input('date_type', 'this_year');
        $from      = $request->input('from');
        $to        = $request->input('to');

        $txAll = $this->txQuery($date_type, $from, $to)->get();
        $euTx  = $txAll->where('is_eu', 1);

        $vatByCountry = $euTx->groupBy('user_country')
            ->map(fn($g) => [
                'country'    => $g->first()->user_country,
                'vat_rate'   => $g->first()->vat_rate ?? 0,
                'gross'      => $g->sum('gross_amount'),
                'vat_amount' => $g->sum('vat_amount'),
                'count'      => $g->count(),
            ])->values();

        $data = [
            'vatByCountry'  => $vatByCountry,
            'totalEuGross'  => $euTx->sum('gross_amount'),
            'totalVat'      => $euTx->sum('vat_amount'),
            'nonEuRevenue'  => $txAll->where('is_eu', 0)->sum('gross_amount'),
            'date_type'     => $date_type, 'from' => $from, 'to' => $to,
        ];

        $mpdf_view = View::make('admin-views.accounting.pdf.admin-earning-pdf', $data + $this->companyInfo());
        Helpers::gen_mpdf($mpdf_view, 'vat_tax_report_', rand(1000, 9999) . time());
    }

    // ── الاستعلامات المساعدة وفلاتر التاريخ ──
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
            ->when($dateType === 'this_year', fn($q) => $q->whereYear('created_at', date('Y')))
            ->when($dateType === 'this_month', fn($q) => $q->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m')))
            ->when($dateType === 'this_week', fn($q) => $q->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]))
            ->when($dateType === 'custom_date' && $from && $to, fn($q) => $q->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to));
    }

    private function companyInfo(): array
    {
        return [
            'company_name'     => BusinessSetting::where('type', 'company_name')->value('value') ?? 'EuroBas',
            'company_email'    => BusinessSetting::where('type', 'company_email')->value('value') ?? '',
            'company_phone'    => BusinessSetting::where('type', 'company_phone')->value('value') ?? '',
            'company_web_logo' => BusinessSetting::where('type', 'company_web_logo')->value('value') ?? '',
        ];
    }
}

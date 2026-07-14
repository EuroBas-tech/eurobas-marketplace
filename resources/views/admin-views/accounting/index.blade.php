@extends('layouts.back-end.app')

@section('title', translate('accounting'))

@push('css_or_js')
<style>
    /* High-Contrast Modern White UI Styling */
    .dashboard-card {
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        background: #ffffff !important;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .dashboard-card:hover {
        border-color: #cbd5e1 !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }
    .stat-card .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 800;
    }
    .stat-value {
        font-size: 18px; 
        font-weight: 800;
        letter-spacing: -0.02em;
        margin-top: 8px;
        color: #0f172a !important;  
    }
    
    
    .text-black-bold {
        color: #0f172a !important;
        font-weight: 700 !important;
    }
    .text-black-medium {
        color: #1e293b !important;
        font-weight: 600 !important;
    }
    .text-black-regular {
        color: #334155 !important;
        font-weight: 500 !important;
    }

    .gateway-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        padding: 6px 14px;
        border-radius: 6px;
        font-weight: 700;
        border: 1px solid transparent;
    }
    .badge-stripe { background: #f0f7ff; color: #0052cc; border-color: #cbdfff; }
    .badge-paypal { background: #fffdf0; color: #8a6d00; border-color: #f7eec1; }
    .badge-eu { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    .badge-noeu { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
    
    .country-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .country-row:last-child { border-bottom: none; }
    
    .tx-table {
        border-collapse: separate;
        border-spacing: 0;
    }
    .tx-table th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #0f172a !important; /* رأس جدول أسود واضح */
        font-weight: 800;
        background-color: #f8fafc !important;
        border-bottom: 2px solid #e2e8f0;
        padding: 16px;
    }
    .tx-table tbody tr {
        transition: background-color 0.1s ease;
    }
    .tx-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .tx-table td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #e2e8f0;
        color: #1e293b !important; /* نصوص جدول سوداء واضحة */
    }
    .custom-form-control {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 10px 14px;
        color: #0f172a !important;
        font-weight: 600;
        background-color: #ffffff;
    }
    .custom-form-control:focus {
        border-color: #0052cc;
        box-shadow: 0 0 0 3px rgba(0, 82, 204, 0.1);
    }
    .btn-outline-primary {
        color: #0052cc !important;
        border-color: #cbdfff !important;
        background: #ffffff;
    }
    .btn-outline-primary:hover {
        background: #f0f7ff !important;
        border-color: #0052cc !important;
    }
    /* الزر الأزرق للفلتر */
    .btn-custom-blue {
        background-color: #0052cc !important;
        color: #ffffff !important;
        border: none;
        padding: 11px;
        border-radius: 8px;
        font-weight: 700;
        transition: background-color 0.2s ease;
    }
    .btn-custom-blue:hover {
        background-color: #0043a4 !important;
    }
</style>
@endpush

@section('content')
<div class="content container-fluid" style="background: #ffffff; min-height: 100vh; padding-top: 24px;">

    {{-- Page Title --}}
    <div class="mb-4 d-flex align-items-center gap-3">
        <div style="background: #ffffff; padding: 10px; border-radius: 12px; border: 1px solid #e2e8f0;">
            <img width="24" src="{{ asset('assets/back-end/img/accounting.png') }}" alt="">
        </div>
        <h2 class="h2 mb-0 text-capitalize text-black-bold" style="font-size: 28px;">{{ translate('accounting') }}</h2>
    </div>

    {{-- Tabs --}}
    <div class="mb-4">
        @include('admin-views.accounting.partials.product-report-inline-menu')
    </div>

    {{-- Filter --}}
    <div class="card dashboard-card mb-4">
        <div class="card-body py-4">
            <form method="GET" id="filter-form">
                <div class="row gy-3 gx-3 align-items-end">
                    <div class="col-sm-6 col-md-3">
                        <label class="form-label small text-black-bold mb-2">{{ translate('period') }}</label>
                        <select class="form-control custom-form-control" name="date_type" id="date_type">
                            <option value="this_year"  {{ $date_type=='this_year'  ? 'selected':'' }}>{{ translate('this_Year') }}</option>
                            <option value="this_month" {{ $date_type=='this_month' ? 'selected':'' }}>{{ translate('this_Month') }}</option>
                            <option value="this_week"  {{ $date_type=='this_week'  ? 'selected':'' }}>{{ translate('this_Week') }}</option>
                            <option value="custom_date"{{ $date_type=='custom_date'? 'selected':'' }}>{{ translate('custom_Date') }}</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3" id="from_div">
                        <label class="form-label small text-black-bold mb-2">{{ translate('start_date') }}</label>
                        <input type="date" name="from" value="{{ $from }}" id="from_date" class="form-control custom-form-control">
                    </div>
                    <div class="col-sm-6 col-md-3" id="to_div">
                        <label class="form-label small text-black-bold mb-2">{{ translate('end_date') }}</label>
                        <input type="date" name="to" value="{{ $to }}" id="to_date" class="form-control custom-form-control">
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button type="submit" class="btn btn-custom-blue w-100">
                            <i class="tio-filter-list me-1"></i>{{ translate('filter') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Stats Row 1 --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card dashboard-card stat-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-black-bold small text-uppercase" style="letter-spacing: 0.05em;">{{ translate('total_Revenue') }}</span>
                        <div class="stat-icon" style="background:#f0fdf4; color:#166534; border: 1px solid #bbf7d0;">€</div>
                    </div>
                    <div class="stat-value">€{{ number_format($grossRevenue,2) }}</div>
                    <div class="text-black-regular mt-2" style="font-size:13px;"><i class="tio-trending-up text-success"></i> {{ translate('gross_all_payments') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card stat-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-black-bold small text-uppercase" style="letter-spacing: 0.05em;">{{ translate('gateway_fees') }}</span>
                        <div class="stat-icon" style="background:#fff1f2; color:#991b1b; border: 1px solid #fecaca;"><i class="tio-credit-card"></i></div>
                    </div>
                    <div class="stat-value text-danger" style="color: #dc2626 !important;">−€{{ number_format($gatewayFees,2) }}</div>
                    <div class="text-black-regular mt-2" style="font-size:13px;">Stripe + PayPal</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card stat-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-black-bold small text-uppercase" style="letter-spacing: 0.05em;">{{ translate('costs_and_expenses') }}</span>
                        <div class="stat-icon" style="background:#fff1f2; color:#991b1b; border: 1px solid #fecaca;"><i class="tio-institution"></i></div>
                    </div>
                    <div class="stat-value text-danger" style="color: #dc2626 !important;">−€{{ number_format($costsAndExpenses,2) }}</div>
                    <div class="text-black-regular mt-2" style="font-size:13px;">{{ translate('office_salaries_etc') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card stat-card h-100" style="border: 2px solid #22c55e !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-success small text-uppercase" style="letter-spacing: 0.05em; font-weight: 800;">{{ translate('net_Profit') }}</span>
                        <div class="stat-icon" style="background:#22c55e; color:#ffffff;"><i class="tio-checkmark-circle"></i></div>
                    </div>
                    <div class="stat-value" style="color:#15803d !important;">€{{ number_format($netProfit,2) }}</div>
                    <div class="text-black-regular mt-2" style="font-size:13px;">{{ translate('after_all_deductions') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Row 2 --}}
    <div class="row g-3 mb-4">
        {{-- Gateway breakdown --}}
        <div class="col-md-4">
            <div class="card dashboard-card h-100">
                <div class="card-header border-0 bg-transparent pt-4 pb-0">
                    <h5 class="mb-0 text-black-bold" style="font-size: 16px;">{{ translate('gateway_breakdown') }}</h5>
                </div>
                <div class="card-body pt-2">
                    <div class="country-row">
                        <span><span class="gateway-badge badge-stripe">Stripe</span></span>
                        <div class="text-end">
                            <div class="text-black-bold">€{{ number_format($stripeTotal,2) }}</div>
                            <div class="text-danger fw-700" style="font-size:12px;">Fee: €{{ number_format($stripeFees,2) }}</div>
                        </div>
                    </div>
                    <div class="country-row">
                        <span><span class="gateway-badge badge-paypal">PayPal</span></span>
                        <div class="text-end">
                            <div class="text-black-bold">€{{ number_format($paypalTotal,2) }}</div>
                            <div class="text-danger fw-700" style="font-size:12px;">Fee: €{{ number_format($paypalFees,2) }}</div>
                        </div>
                    </div>
                    <div class="country-row mt-2" style="font-size: 16px;">
                        <span class="text-black-bold">{{ translate('total') }}</span>
                        <span class="text-black-bold" style="color: #0f172a !important;">€{{ number_format($grossRevenue,2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Package breakdown --}}
        <div class="col-md-4">
            <div class="card dashboard-card h-100">
                <div class="card-header border-0 bg-transparent pt-4 pb-0">
                    <h5 class="mb-0 text-black-bold" style="font-size: 16px;">{{ translate('package_breakdown') }}</h5>
                </div>
                <div class="card-body pt-2">
                    @forelse($packageBreakdown as $pkg)
                    <div class="country-row">
                        <span class="text-black-medium" style="font-size:13px;">{{ ucwords(str_replace('_',' ',$pkg['type'])) }}</span>
                        <div class="text-end">
                            <div class="text-black-bold">€{{ number_format($pkg['gross'],2) }}</div>
                            <div class="text-black-regular" style="font-size:12px;">{{ $pkg['count'] }} {{ translate('transactions') }}</div>
                        </div>
                    </div>
                    @empty
                    <p class="text-black-regular text-center py-4 mb-0">{{ translate('no_data') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- EU vs Non-EU --}}
        <div class="col-md-4">
            <div class="card dashboard-card h-100">
                <div class="card-header border-0 bg-transparent pt-4 pb-0">
                    <h5 class="mb-0 text-black-bold" style="font-size: 16px;">{{ translate('revenue_by_region') }}</h5>
                </div>
                <div class="card-body pt-2">
                    <div class="country-row">
                        <span><span class="gateway-badge badge-eu">🇪🇺 {{ translate('europe_eu') }}</span></span>
                        <span class="text-black-bold">€{{ number_format($euRevenue,2) }}</span>
                    </div>
                    <div class="country-row">
                        <span><span class="gateway-badge badge-noeu">🌍 {{ translate('outside_eu') }}</span></span>
                        <span class="text-black-bold">€{{ number_format($nonEuRevenue,2) }}</span>
                    </div>
                    <div class="country-row mt-2" style="font-size: 16px;">
                        <span class="text-black-bold">{{ translate('total') }}</span>
                        <span class="text-black-bold" style="color: #0f172a !important;">€{{ number_format($grossRevenue,2) }}</span>
                    </div>
                    <div class="mt-3 pt-2 border-top" style="border-top-color: #e2e8f0 !important;">
                        <div class="d-flex justify-content-between align-items-center" style="font-size:14px;">
                            <span class="text-black-medium">{{ translate('vat_collected') }}</span>
                            <span class="text-danger fw-800" style="font-size:15px; color: #dc2626 !important;">€{{ number_format($vatCollected,2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- VAT by Country (OSS) --}}
    <div class="card dashboard-card mb-4" style="overflow: hidden;">
        <div class="card-header border-0 bg-transparent p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 text-black-bold" style="font-size: 18px;">
                    🏛 {{ translate('vat_report_oss') }}
                    <span class="badge bg-dark text-white ms-2" style="font-size:12px; font-weight: 700; padding: 6px 12px; border-radius: 6px;">{{ $vatByCountry->count() }} {{ translate('countries') }}</span>
                </h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.accounting.tax-report-pdf', ['date_type'=>$date_type,'from'=>$from,'to'=>$to]) }}"
                       class="btn btn-outline-primary btn-sm" style="border-radius: 6px; font-weight: 700; font-size: 13px;">
                        <i class="tio-file-text"></i> {{ translate('tax_report_pdf') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-borderless table-hover mb-0 tx-table">
                <thead>
                    <tr>
                        <th>{{ translate('country') }}</th>
                        <th>{{ translate('vat_rate') }}</th>
                        <th>{{ translate('gross_revenue') }}</th>
                        <th>{{ translate('vat_to_pay') }}</th>
                        <th>{{ translate('transactions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vatByCountry as $row)
                    <tr>
                        <td><strong class="text-black-bold" style="font-size:14px;">{{ $row['country'] }}</strong></td>
                        <td><span class="badge bg-dark text-white fw-700" style="font-size:12px; padding: 6px 10px; border-radius: 4px;">{{ $row['vat_rate'] }}%</span></td>
                        <td class="text-black-medium">€{{ number_format($row['gross'],2) }}</td>
                        <td class="text-danger fw-800" style="color: #dc2626 !important;">€{{ number_format($row['vat_amount'],2) }}</td>
                        <td class="text-black-regular">{{ $row['count'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="text-center py-5">
                                <img class="mb-3 w-120" src="{{ asset('assets/back-end/svg/illustrations/sorry.svg') }}" alt="">
                                <p class="mb-0 text-black-medium">{{ translate('no_eu_transactions') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    @if($vatByCountry->count() > 0)
                    <tr style="background-color: #f8fafc; font-size: 15px;">
                        <td colspan="2" class="text-black-bold"><strong>{{ translate('total') }}</strong></td>
                        <td class="text-black-bold"><strong>€{{ number_format($euRevenue,2) }}</strong></td>
                        <td class="text-danger fw-800" style="color: #dc2626 !important;"><strong>€{{ number_format($vatCollected,2) }}</strong></td>
                        <td class="text-black-bold"><strong>{{ $vatByCountry->sum('count') }}</strong></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="card dashboard-card mb-4" style="overflow: hidden;">
        <div class="card-header border-0 bg-transparent p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 text-black-bold" style="font-size: 18px;">
                    {{ translate('recent_transactions') }}
                    <span class="badge bg-dark text-white ms-2" style="font-size:12px; font-weight: 700; padding: 6px 12px; border-radius: 6px;">{{ $txCount }}</span>
                </h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.accounting.platform-finance-pdf', ['date_type'=>$date_type,'from'=>$from,'to'=>$to]) }}"
                       class="btn btn-outline-primary btn-sm" style="border-radius: 6px; font-weight: 700; font-size: 13px;">
                        <i class="tio-file-text"></i> PDF
                    </a>
                    <a href="{{ route('admin.accounting.platform-finance-excel', ['date_type'=>$date_type,'from'=>$from,'to'=>$to]) }}"
                       class="btn btn-outline-success btn-sm" style="border-radius: 6px; font-weight: 700; font-size: 13px; color: #15803d !important; border-color: #bbf7d0 !important;">
                        <img width="13" src="{{ asset('assets/back-end/img/excel.png') }}" alt="" class="me-1"> Excel
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-borderless table-hover mb-0 tx-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('date') }}</th>
                        <th>{{ translate('package') }}</th>
                        <th>{{ translate('country') }}</th>
                        <th>{{ translate('gateway') }}</th>
                        <th>{{ translate('gross') }}</th>
                        <th>{{ translate('gateway_fee') }}</th>
                        <th>{{ translate('vat') }}</th>
                        <th>{{ translate('net') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTx as $i => $tx)
                    <tr>
                        <td class="text-black-regular">{{ $i+1 }}</td>
                        <td class="text-black-bold">{{ \Carbon\Carbon::parse($tx->created_at)->format('d M Y') }}</td>
                        <td class="text-black-bold">{{ ucwords(str_replace('_',' ',$tx->package_type ?? '-')) }}</td>
                        <td>
                            @if($tx->user_country)
                                @if($tx->is_eu)
                                    <span class="gateway-badge badge-eu">{{ $tx->user_country }}</span>
                                @else
                                    <span class="gateway-badge badge-noeu">{{ $tx->user_country }}</span>
                                @endif
                            @else
                                <span class="text-black-regular">—</span>
                            @endif
                        </td>
                        <td>
                            @if($tx->gateway === 'stripe')
                                <span class="gateway-badge badge-stripe">Stripe</span>
                            @elseif($tx->gateway === 'paypal')
                                <span class="gateway-badge badge-paypal">PayPal</span>
                            @else
                                <span class="badge bg-dark text-white fw-700" style="padding: 5px 10px; border-radius: 4px; font-size: 11px;">{{ $tx->gateway }}</span>
                            @endif
                        </td>
                        <td class="text-black-bold">€{{ number_format($tx->gross_amount,2) }}</td>
                        <td class="text-danger fw-700" style="color: #dc2626 !important;">−€{{ number_format($tx->gateway_fee,2) }}</td>
                        <td class="text-danger fw-700" style="color: #dc2626 !important;">{{ $tx->vat_amount > 0 ? '−€'.number_format($tx->vat_amount,2) : '—' }}</td>
                        <td style="color:#166534; font-weight:800; font-size: 15px;">€{{ number_format($tx->net_amount,2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="text-center py-5">
                                <img class="mb-3 w-120" src="{{ asset('assets/back-end/svg/illustrations/sorry.svg') }}" alt="">
                                <p class="mb-0 text-black-medium">{{ translate('no_transactions_yet') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('script_2')
<script>
$("#date_type").change(function() {
    let val = $(this).val();
    $('#from_div, #to_div').toggle(val === 'custom_date');
    if(val !== 'custom_date'){
        $('#from_date,#to_date').val('').removeAttr('required');
    } else {
        $('#from_date,#to_date').attr('required','required');
    }
}).change();

$('#from_date,#to_date').change(function(){
    let fr = $('#from_date').val(), to = $('#to_date').val();
    if(fr && to && fr > to){
        $('#from_date,#to_date').val('');
        toastr.error('Invalid date range!');
    }
});
</script>
@endpush

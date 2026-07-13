@extends('layouts.back-end.app')

@section('title', translate('accounting'))

@push('css_or_js')
<style>
    /* Modern Premium UI Styling */
    .dashboard-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        background: #ffffff;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .dashboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.07);
    }
    .stat-card .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        font-weight: bold;
    }
    .stat-value {
        font-size: 24px;
        font-weight: 700;
        letter-spacing: -0.02em;
        margin-top: 8px;
    }
    .gateway-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        padding: 4px 12px;
        border-radius: 30px;
        font-weight: 600;
    }
    .badge-stripe { background: rgba(26, 115, 232, 0.08); color: #1a73e8; }
    .badge-paypal { background: rgba(255, 193, 7, 0.12); color: #b58105; }
    .badge-eu { background: rgba(25, 135, 84, 0.09); color: #198754; }
    .badge-noeu { background: rgba(220, 53, 69, 0.08); color: #dc3545; }
    
    .country-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f5f6f7;
        font-size: 14px;
    }
    .country-row:last-child { border-bottom: none; }
    
    .tx-table {
        border-collapse: separate;
        border-spacing: 0;
    }
    .tx-table th {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #718096;
        font-weight: 700;
        background-color: #f8fafc !important;
        border-bottom: 1px solid #edf2f7;
        padding: 14px 16px;
    }
    .tx-table tbody tr {
        transition: background-color 0.15s ease;
    }
    .tx-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .tx-table td {
        padding: 14px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #edf2f7;
    }
    .custom-form-control {
        border-radius: 8px;
        border: 1px solid #d1d5db;
        padding: 10px 14px;
        transition: all 0.2s;
    }
    .custom-form-control:focus {
        border-color: #1a73e8;
        box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.15);
    }
</style>
@endpush

@section('content')
<div class="content container-fluid" style="background: #fafbfe; min-height: 100vh; padding-top: 24px;">

    {{-- Page Title --}}
    <div class="mb-4 d-flex align-items-center gap-3">
        <div style="background: #ffffff; padding: 10px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            <img width="24" src="{{ asset('assets/back-end/img/accounting.png') }}" alt="">
        </div>
        <h2 class="h2 mb-0 text-capitalize" style="font-weight: 700; color: #1e293b;">{{ translate('accounting') }}</h2>
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
                        <label class="form-label small fw-600 text-secondary mb-2">{{ translate('period') }}</label>
                        <select class="form-control custom-form-control" name="date_type" id="date_type">
                            <option value="this_year"  {{ $date_type=='this_year'  ? 'selected':'' }}>{{ translate('this_Year') }}</option>
                            <option value="this_month" {{ $date_type=='this_month' ? 'selected':'' }}>{{ translate('this_Month') }}</option>
                            <option value="this_week"  {{ $date_type=='this_week'  ? 'selected':'' }}>{{ translate('this_Week') }}</option>
                            <option value="custom_date"{{ $date_type=='custom_date'? 'selected':'' }}>{{ translate('custom_Date') }}</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3" id="from_div">
                        <label class="form-label small fw-600 text-secondary mb-2">{{ translate('start_date') }}</label>
                        <input type="date" name="from" value="{{ $from }}" id="from_date" class="form-control custom-form-control">
                    </div>
                    <div class="col-sm-6 col-md-3" id="to_div">
                        <label class="form-label small fw-600 text-secondary mb-2">{{ translate('end_date') }}</label>
                        <input type="date" name="to" value="{{ $to }}" id="to_date" class="form-control custom-form-control">
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button type="submit" class="btn btn--primary w-100" style="padding: 10px; border-radius: 8px; font-weight: 600;">
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
                        <span class="text-muted small fw-600 text-uppercase" style="letter-spacing: 0.05em;">{{ translate('total_Revenue') }}</span>
                        <div class="stat-icon" style="background:rgba(26, 115, 232, 0.1); color:#1a73e8;">€</div>
                    </div>
                    <div class="stat-value text-dark">€{{ number_format($grossRevenue,2) }}</div>
                    <div class="text-muted mt-2" style="font-size:12px;"><i class="tio-trending-up text-success"></i> {{ translate('gross_all_payments') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card stat-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-muted small fw-600 text-uppercase" style="letter-spacing: 0.05em;">{{ translate('gateway_fees') }}</span>
                        <div class="stat-icon" style="background:rgba(255, 193, 7, 0.15); color:#b58105;"><i class="tio-credit-card"></i></div>
                    </div>
                    <div class="stat-value text-danger">−€{{ number_format($gatewayFees,2) }}</div>
                    <div class="text-muted mt-2" style="font-size:12px;">Stripe + PayPal</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card stat-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-muted small fw-600 text-uppercase" style="letter-spacing: 0.05em;">{{ translate('costs_and_expenses') }}</span>
                        <div class="stat-icon" style="background:rgba(220, 53, 69, 0.1); color:#dc3545;"><i class="tio-institution"></i></div>
                    </div>
                    <div class="stat-value text-danger">−€{{ number_format($costsAndExpenses,2) }}</div>
                    <div class="text-muted mt-2" style="font-size:12px;">{{ translate('office_salaries_etc') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card stat-card h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%); border: 1px solid rgba(25, 135, 84, 0.15);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-success small fw-700 text-uppercase" style="letter-spacing: 0.05em;">{{ translate('net_Profit') }}</span>
                        <div class="stat-icon" style="background:#198754; color:#ffffff;"><i class="tio-checkmark-circle"></i></div>
                    </div>
                    <div class="stat-value" style="color:#198754;">€{{ number_format($netProfit,2) }}</div>
                    <div class="text-muted mt-2" style="font-size:12px;">{{ translate('after_all_deductions') }}</div>
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
                    <h5 class="mb-0 style" style="font-weight: 700; color: #334155;">{{ translate('gateway_breakdown') }}</h5>
                </div>
                <div class="card-body pt-2">
                    <div class="country-row">
                        <span><span class="gateway-badge badge-stripe">Stripe</span></span>
                        <div class="text-end">
                            <div class="fw-600 text-dark">€{{ number_format($stripeTotal,2) }}</div>
                            <div class="text-danger fw-500" style="font-size:11px;">Fee: €{{ number_format($stripeFees,2) }}</div>
                        </div>
                    </div>
                    <div class="country-row">
                        <span><span class="gateway-badge badge-paypal">PayPal</span></span>
                        <div class="text-end">
                            <div class="fw-600 text-dark">€{{ number_format($paypalTotal,2) }}</div>
                            <div class="text-danger fw-500" style="font-size:11px;">Fee: €{{ number_format($paypalFees,2) }}</div>
                        </div>
                    </div>
                    <div class="country-row mt-2" style="font-weight:700; font-size: 15px;">
                        <span class="text-secondary">{{ translate('total') }}</span>
                        <span class="text-primary">€{{ number_format($grossRevenue,2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Package breakdown --}}
        <div class="col-md-4">
            <div class="card dashboard-card h-100">
                <div class="card-header border-0 bg-transparent pt-4 pb-0">
                    <h5 class="mb-0" style="font-weight: 700; color: #334155;">{{ translate('package_breakdown') }}</h5>
                </div>
                <div class="card-body pt-2">
                    @forelse($packageBreakdown as $pkg)
                    <div class="country-row">
                        <span class="fw-500 text-dark" style="font-size:13px;">{{ ucwords(str_replace('_',' ',$pkg['type'])) }}</span>
                        <div class="text-end">
                            <div class="fw-600 text-dark">€{{ number_format($pkg['gross'],2) }}</div>
                            <div class="text-muted" style="font-size:11px;">{{ $pkg['count'] }} {{ translate('transactions') }}</div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center py-4 mb-0">{{ translate('no_data') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- EU vs Non-EU --}}
        <div class="col-md-4">
            <div class="card dashboard-card h-100">
                <div class="card-header border-0 bg-transparent pt-4 pb-0">
                    <h5 class="mb-0" style="font-weight: 700; color: #334155;">{{ translate('revenue_by_region') }}</h5>
                </div>
                <div class="card-body pt-2">
                    <div class="country-row">
                        <span><span class="gateway-badge badge-eu">🇪🇺 {{ translate('europe_eu') }}</span></span>
                        <span class="fw-600 text-dark">€{{ number_format($euRevenue,2) }}</span>
                    </div>
                    <div class="country-row">
                        <span><span class="gateway-badge badge-noeu">🌍 {{ translate('outside_eu') }}</span></span>
                        <span class="fw-600 text-dark">€{{ number_format($nonEuRevenue,2) }}</span>
                    </div>
                    <div class="country-row mt-2" style="font-weight:700; font-size: 15px;">
                        <span class="text-secondary">{{ translate('total') }}</span>
                        <span class="text-primary">€{{ number_format($grossRevenue,2) }}</span>
                    </div>
                    <div class="mt-3 pt-2 border-top">
                        <div class="d-flex justify-content-between align-items-center" style="font-size:14px;">
                            <span class="text-muted fw-500">{{ translate('vat_collected') }}</span>
                            <span class="text-danger fw-600">€{{ number_format($vatCollected,2) }}</span>
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
                <h5 class="mb-0" style="font-weight: 700; color: #334155;">
                    🏛 {{ translate('vat_report_oss') }}
                    <span class="badge rounded-pill bg-soft-dark ms-2 text-dark" style="font-size:12px; font-weight: 600; padding: 4px 10px;">{{ $vatByCountry->count() }} {{ translate('countries') }}</span>
                </h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.accounting.tax-report-pdf', ['date_type'=>$date_type,'from'=>$from,'to'=>$to]) }}"
                       class="btn btn-outline-primary btn-sm" style="border-radius: 6px; font-weight: 600;">
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
                        <td><strong class="text-dark">{{ $row['country'] }}</strong></td>
                        <td><span class="badge bg-light text-dark fw-600" style="font-size:13px; padding: 4px 8px;">{{ $row['vat_rate'] }}%</span></td>
                        <td class="fw-500">€{{ number_format($row['gross'],2) }}</td>
                        <td class="text-danger fw-600">€{{ number_format($row['vat_amount'],2) }}</td>
                        <td class="text-secondary fw-500">{{ $row['count'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="text-center py-5">
                                <img class="mb-3 w-120" src="{{ asset('assets/back-end/svg/illustrations/sorry.svg') }}" alt="">
                                <p class="mb-0 text-muted fw-500">{{ translate('no_eu_transactions') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    @if($vatByCountry->count() > 0)
                    <tr style="background-color: #f8fafc; font-weight:700; font-size: 14px;">
                        <td colspan="2" class="text-dark"><strong>{{ translate('total') }}</strong></td>
                        <td class="text-dark"><strong>€{{ number_format($euRevenue,2) }}</strong></td>
                        <td class="text-danger"><strong>€{{ number_format($vatCollected,2) }}</strong></td>
                        <td class="text-primary"><strong>{{ $vatByCountry->sum('count') }}</strong></td>
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
                <h5 class="mb-0" style="font-weight: 700; color: #334155;">
                    {{ translate('recent_transactions') }}
                    <span class="badge rounded-pill bg-soft-dark ms-2 text-dark" style="font-size:12px; font-weight: 600; padding: 4px 10px;">{{ $txCount }}</span>
                </h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.accounting.platform-finance-pdf', ['date_type'=>$date_type,'from'=>$from,'to'=>$to]) }}"
                       class="btn btn-outline-primary btn-sm" style="border-radius: 6px; font-weight: 600;">
                        <i class="tio-file-text"></i> PDF
                    </a>
                    <a href="{{ route('admin.accounting.platform-finance-excel', ['date_type'=>$date_type,'from'=>$from,'to'=>$to]) }}"
                       class="btn btn-outline-success btn-sm" style="border-radius: 6px; font-weight: 600;">
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
                        <td class="text-secondary fw-500">{{ $i+1 }}</td>
                        <td class="text-dark fw-500">{{ \Carbon\Carbon::parse($tx->created_at)->format('d M Y') }}</td>
                        <td class="fw-600 text-dark">{{ ucwords(str_replace('_',' ',$tx->package_type ?? '-')) }}</td>
                        <td>
                            @if($tx->user_country)
                                @if($tx->is_eu)
                                    <span class="gateway-badge badge-eu">{{ $tx->user_country }}</span>
                                @else
                                    <span class="gateway-badge badge-noeu">{{ $tx->user_country }}</span>
                                @endif
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($tx->gateway === 'stripe')
                                <span class="gateway-badge badge-stripe">Stripe</span>
                            @elseif($tx->gateway === 'paypal')
                                <span class="gateway-badge badge-paypal">PayPal</span>
                            @else
                                <span class="badge bg-light text-dark fw-500">{{ $tx->gateway }}</span>
                            @endif
                        </td>
                        <td class="fw-600 text-dark">€{{ number_format($tx->gross_amount,2) }}</td>
                        <td class="text-danger fw-500">−€{{ number_format($tx->gateway_fee,2) }}</td>
                        <td class="text-danger fw-500">{{ $tx->vat_amount > 0 ? '−€'.number_format($tx->vat_amount,2) : '—' }}</td>
                        <td style="color:#15803d; font-weight:700; font-size: 14px;">€{{ number_format($tx->net_amount,2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="text-center py-5">
                                <img class="mb-3 w-120" src="{{ asset('assets/back-end/svg/illustrations/sorry.svg') }}" alt="">
                                <p class="mb-0 text-muted fw-500">{{ translate('no_transactions_yet') }}</p>
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

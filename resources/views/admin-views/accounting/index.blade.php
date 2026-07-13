@extends('layouts.back-end.app')

@section('title', translate('accounting'))

@push('css_or_js')
<style>
.stat-card { border-radius: 10px; border: 1px solid #e8eaed; }
.stat-card .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
.stat-value { font-size: 22px; font-weight: 600; }
.gateway-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; padding: 2px 8px; border-radius: 10px; font-weight: 500; }
.badge-stripe { background: #e8f0fe; color: #1a73e8; }
.badge-paypal { background: #fff3cd; color: #856404; }
.badge-eu { background: #d1e7dd; color: #0a6640; }
.badge-noeu { background: #f8d7da; color: #842029; }
.country-row { display: flex; justify-content: space-between; align-items: center; padding: 7px 0; border-bottom: 1px solid #f0f0f0; font-size: 13px; }
.country-row:last-child { border-bottom: none; }
.tx-table th { font-size: 11px; text-transform: uppercase; letter-spacing: .04em; color: #888; }
</style>
@endpush

@section('content')
<div class="content container-fluid">

    {{-- Page Title --}}
    <div class="mb-3 d-flex align-items-center gap-2">
        <img width="22" src="{{ asset('assets/back-end/img/accounting.png') }}" alt="">
        <h2 class="h1 mb-0 text-capitalize">{{ translate('accounting') }}</h2>
    </div>

    {{-- Tabs --}}
    @include('admin-views.accounting.partials.product-report-inline-menu')

    {{-- Filter --}}
    <div class="card mb-3">
        <div class="card-body py-3">
            <form method="GET" id="filter-form">
                <div class="row gy-2 gx-2 align-items-end">
                    <div class="col-sm-6 col-md-3">
                        <label class="form-label small">{{ translate('period') }}</label>
                        <select class="form-control" name="date_type" id="date_type">
                            <option value="this_year"  {{ $date_type=='this_year'  ? 'selected':'' }}>{{ translate('this_Year') }}</option>
                            <option value="this_month" {{ $date_type=='this_month' ? 'selected':'' }}>{{ translate('this_Month') }}</option>
                            <option value="this_week"  {{ $date_type=='this_week'  ? 'selected':'' }}>{{ translate('this_Week') }}</option>
                            <option value="custom_date"{{ $date_type=='custom_date'? 'selected':'' }}>{{ translate('custom_Date') }}</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3" id="from_div">
                        <label class="form-label small">{{ translate('start_date') }}</label>
                        <input type="date" name="from" value="{{ $from }}" id="from_date" class="form-control">
                    </div>
                    <div class="col-sm-6 col-md-3" id="to_div">
                        <label class="form-label small">{{ translate('end_date') }}</label>
                        <input type="date" name="to" value="{{ $to }}" id="to_date" class="form-control">
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button type="submit" class="btn btn--primary w-100">
                            <i class="tio-filter-list me-1"></i>{{ translate('filter') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Stats Row 1 --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="stat-icon" style="background:#e8f0fe;color:#1a73e8;">€</div>
                        <span class="text-muted small">{{ translate('total_Revenue') }}</span>
                    </div>
                    <div class="stat-value">€{{ number_format($grossRevenue,2) }}</div>
                    <div class="text-muted" style="font-size:12px;">{{ translate('gross_all_payments') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="stat-icon" style="background:#fff3cd;color:#856404;"><i class="tio-credit-card"></i></div>
                        <span class="text-muted small">{{ translate('gateway_fees') }}</span>
                    </div>
                    <div class="stat-value text-danger">−€{{ number_format($gatewayFees,2) }}</div>
                    <div class="text-muted" style="font-size:12px;">Stripe + PayPal</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="stat-icon" style="background:#f8d7da;color:#842029;"><i class="tio-institution"></i></div>
                        <span class="text-muted small">{{ translate('costs_and_expenses') }}</span>
                    </div>
                    <div class="stat-value text-danger">−€{{ number_format($costsAndExpenses,2) }}</div>
                    <div class="text-muted" style="font-size:12px;">{{ translate('office_salaries_etc') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card h-100" style="border-color:#1D9E75;">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="stat-icon" style="background:#d1e7dd;color:#0a6640;"><i class="tio-checkmark-circle"></i></div>
                        <span class="text-muted small">{{ translate('net_Profit') }}</span>
                    </div>
                    <div class="stat-value" style="color:#1D9E75;">€{{ number_format($netProfit,2) }}</div>
                    <div class="text-muted" style="font-size:12px;">{{ translate('after_all_deductions') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Row 2 --}}
    <div class="row g-3 mb-3">
        {{-- Gateway breakdown --}}
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header border-0 pb-0">
                    <h6 class="mb-0">{{ translate('gateway_breakdown') }}</h6>
                </div>
                <div class="card-body pt-2">
                    <div class="country-row">
                        <span><span class="gateway-badge badge-stripe">Stripe</span></span>
                        <div class="text-end">
                            <div class="fw-500">€{{ number_format($stripeTotal,2) }}</div>
                            <div class="text-danger" style="font-size:11px;">Fee: €{{ number_format($stripeFees,2) }}</div>
                        </div>
                    </div>
                    <div class="country-row">
                        <span><span class="gateway-badge badge-paypal">PayPal</span></span>
                        <div class="text-end">
                            <div class="fw-500">€{{ number_format($paypalTotal,2) }}</div>
                            <div class="text-danger" style="font-size:11px;">Fee: €{{ number_format($paypalFees,2) }}</div>
                        </div>
                    </div>
                    <div class="country-row" style="font-weight:600;">
                        <span>{{ translate('total') }}</span>
                        <span>€{{ number_format($grossRevenue,2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Package breakdown --}}
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header border-0 pb-0">
                    <h6 class="mb-0">{{ translate('package_breakdown') }}</h6>
                </div>
                <div class="card-body pt-2">
                    @forelse($packageBreakdown as $pkg)
                    <div class="country-row">
                        <span style="font-size:13px;">{{ ucwords(str_replace('_',' ',$pkg['type'])) }}</span>
                        <div class="text-end">
                            <div class="fw-500">€{{ number_format($pkg['gross'],2) }}</div>
                            <div class="text-muted" style="font-size:11px;">{{ $pkg['count'] }} {{ translate('transactions') }}</div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center py-3">{{ translate('no_data') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- EU vs Non-EU --}}
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header border-0 pb-0">
                    <h6 class="mb-0">{{ translate('revenue_by_region') }}</h6>
                </div>
                <div class="card-body pt-2">
                    <div class="country-row">
                        <span><span class="gateway-badge badge-eu">🇪🇺 {{ translate('europe_eu') }}</span></span>
                        <span class="fw-500">€{{ number_format($euRevenue,2) }}</span>
                    </div>
                    <div class="country-row">
                        <span><span class="gateway-badge badge-noeu">🌍 {{ translate('outside_eu') }}</span></span>
                        <span class="fw-500">€{{ number_format($nonEuRevenue,2) }}</span>
                    </div>
                    <div class="country-row" style="font-weight:600;">
                        <span>{{ translate('total') }}</span>
                        <span>€{{ number_format($grossRevenue,2) }}</span>
                    </div>
                    <div class="mt-2 pt-2 border-top">
                        <div class="d-flex justify-content-between" style="font-size:13px;">
                            <span class="text-muted">{{ translate('vat_collected') }}</span>
                            <span class="text-danger fw-500">€{{ number_format($vatCollected,2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- VAT by Country (OSS) --}}
    <div class="card mb-3">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h6 class="mb-0">
                    🏛 {{ translate('vat_report_oss') }}
                    <span class="badge badge-soft-dark ms-1" style="font-size:11px;">{{ $vatByCountry->count() }} {{ translate('countries') }}</span>
                </h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.accounting.tax-report-pdf', ['date_type'=>$date_type,'from'=>$from,'to'=>$to]) }}"
                       class="btn btn-outline--primary btn-sm">
                        <i class="tio-file-text"></i> {{ translate('tax_report_pdf') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-borderless table-hover mb-0 tx-table">
                <thead class="thead-light">
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
                        <td><strong>{{ $row['country'] }}</strong></td>
                        <td>{{ $row['vat_rate'] }}%</td>
                        <td>€{{ number_format($row['gross'],2) }}</td>
                        <td class="text-danger fw-500">€{{ number_format($row['vat_amount'],2) }}</td>
                        <td>{{ $row['count'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="text-center py-4">
                                <img class="mb-2 w-120" src="{{ asset('assets/back-end/svg/illustrations/sorry.svg') }}" alt="">
                                <p class="mb-0 text-muted">{{ translate('no_eu_transactions') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    @if($vatByCountry->count() > 0)
                    <tr class="thead-light fw-600">
                        <td colspan="2"><strong>{{ translate('total') }}</strong></td>
                        <td><strong>€{{ number_format($euRevenue,2) }}</strong></td>
                        <td class="text-danger"><strong>€{{ number_format($vatCollected,2) }}</strong></td>
                        <td><strong>{{ $vatByCountry->sum('count') }}</strong></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="card">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h6 class="mb-0">
                    {{ translate('recent_transactions') }}
                    <span class="badge badge-soft-dark ms-1" style="font-size:11px;">{{ $txCount }}</span>
                </h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.accounting.platform-finance-pdf', ['date_type'=>$date_type,'from'=>$from,'to'=>$to]) }}"
                       class="btn btn-outline--primary btn-sm">
                        <i class="tio-file-text"></i> PDF
                    </a>
                    <a href="{{ route('admin.accounting.platform-finance-excel', ['date_type'=>$date_type,'from'=>$from,'to'=>$to]) }}"
                       class="btn btn-outline--primary btn-sm">
                        <img width="13" src="{{ asset('assets/back-end/img/excel.png') }}" alt=""> Excel
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-borderless table-hover mb-0 tx-table">
                <thead class="thead-light">
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
                        <td>{{ $i+1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($tx->created_at)->format('d M Y') }}</td>
                        <td>{{ ucwords(str_replace('_',' ',$tx->package_type ?? '-')) }}</td>
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
                                {{ $tx->gateway }}
                            @endif
                        </td>
                        <td>€{{ number_format($tx->gross_amount,2) }}</td>
                        <td class="text-danger">−€{{ number_format($tx->gateway_fee,2) }}</td>
                        <td class="text-danger">{{ $tx->vat_amount > 0 ? '−€'.number_format($tx->vat_amount,2) : '—' }}</td>
                        <td style="color:#1D9E75;font-weight:500;">€{{ number_format($tx->net_amount,2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="text-center py-4">
                                <img class="mb-2 w-120" src="{{ asset('assets/back-end/svg/illustrations/sorry.svg') }}" alt="">
                                <p class="mb-0 text-muted">{{ translate('no_transactions_yet') }}</p>
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

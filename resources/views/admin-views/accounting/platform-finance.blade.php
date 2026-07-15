@extends('layouts.back-end.app')
@section('title', translate('platform_finance'))

@push('css_or_js')
<style>
.stat-card { border-radius: 10px; border: 1px solid #e8eaed; }
.stat-icon { width: 44px; height: 44px; border-radius: 10px; display:flex; align-items:center; justify-content:center; font-size:18px; }
.stat-value { font-size: 22px; font-weight: 600; }
.g-badge { display:inline-flex; align-items:center; gap:4px; font-size:11px; padding:2px 8px; border-radius:10px; font-weight:500; }
.b-stripe { background:#e8f0fe; color:#1a73e8; }
.b-paypal { background:#fff3cd; color:#856404; }
.b-eu  { background:#d1e7dd; color:#0a6640; }
.b-noeu{ background:#f8d7da; color:#842029; }
.c-row { display:flex; justify-content:space-between; align-items:center; padding:7px 0; border-bottom:1px solid #f0f0f0; font-size:13px; }
.c-row:last-child { border-bottom:none; }
</style>
@endpush

@section('content')
<div class="content container-fluid">

    <div class="mb-3 d-flex align-items-center gap-2">
        <img width="22" src="{{ asset('assets/back-end/img/accounting.png') }}" alt="">
        <h2 class="h1 mb-0">{{ translate('accounting') }}</h2>
    </div>

    @include('admin-views.accounting.partials.product-report-inline-menu')

    {{-- Filter --}}
    <div class="card mb-3">
        <div class="card-body py-3">
            <form method="GET">
                <div class="row gy-2 gx-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small">{{ translate('period') }}</label>
                        <select class="form-control" name="date_type" id="date_type">
                            <option value="this_year"  {{ $date_type=='this_year'  ?'selected':'' }}>{{ translate('this_Year') }}</option>
                            <option value="this_month" {{ $date_type=='this_month' ?'selected':'' }}>{{ translate('this_Month') }}</option>
                            <option value="this_week"  {{ $date_type=='this_week'  ?'selected':'' }}>{{ translate('this_Week') }}</option>
                            <option value="custom_date"{{ $date_type=='custom_date'?'selected':'' }}>{{ translate('custom_Date') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3" id="from_div">
                        <label class="form-label small">{{ translate('start_date') }}</label>
                        <input type="date" name="from" value="{{ $from }}" class="form-control">
                    </div>
                    <div class="col-md-3" id="to_div">
                        <label class="form-label small">{{ translate('end_date') }}</label>
                        <input type="date" name="to" value="{{ $to }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn--primary w-100">
                            <i class="tio-filter-list me-1"></i>{{ translate('filter') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="stat-icon" style="background:#e8f0fe;color:#1a73e8;"><i class="tio-money"></i></div>
                        <span class="text-muted small text-capitalize">{{ translate('total_Revenue') }}</span>
                    </div>
                    <div class="stat-value" style="color:#1a73e8;">€{{ number_format($grossRevenue,2) }}</div>
                    <div class="text-muted" style="font-size:12px;">{{ $txCount }} {{ translate('transactions') }}</div>
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
                        <div class="stat-icon" style="background:#f8d7da;color:#842029;"><i class="tio-subtract-circle"></i></div>
                        <span class="text-muted small text-capitalize">{{ translate('costs_and_expenses') }}</span>
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
                        <span class="text-muted small text-capitalize">{{ translate('net_Profit') }}</span>
                    </div>
                    <div class="stat-value" style="color:#1D9E75;">€{{ number_format($netProfit,2) }}</div>
                    <div class="text-muted" style="font-size:12px;">{{ translate('after_all_deductions') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Breakdown Row --}}
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header border-0 pb-1"><h6 class="mb-0">{{ translate('gateway_breakdown') }}</h6></div>
                <div class="card-body pt-2">
                    <div class="c-row">
                        <span><span class="g-badge b-stripe">Stripe</span></span>
                        <div class="text-end">
                            <div class="fw-500">€{{ number_format($stripeTotal,2) }}</div>
                            <div class="text-danger" style="font-size:11px;">Fee −€{{ number_format($stripeFees,2) }}</div>
                        </div>
                    </div>
                    <div class="c-row">
                        <span><span class="g-badge b-paypal">PayPal</span></span>
                        <div class="text-end">
                            <div class="fw-500">€{{ number_format($paypalTotal,2) }}</div>
                            <div class="text-danger" style="font-size:11px;">Fee −€{{ number_format($paypalFees,2) }}</div>
                        </div>
                    </div>
                    <div class="c-row fw-600">
                        <span>{{ translate('total') }}</span>
                        <span>€{{ number_format($grossRevenue,2) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header border-0 pb-1"><h6 class="mb-0">{{ translate('package_breakdown') }}</h6></div>
                <div class="card-body pt-2">
                    @forelse($packageBreakdown as $pkg)
                    <div class="c-row">
                        <span>{{ ucwords(str_replace('_',' ',$pkg['type'])) }}</span>
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
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header border-0 pb-1"><h6 class="mb-0">{{ translate('revenue_by_region') }}</h6></div>
                <div class="card-body pt-2">
                    <div class="c-row">
                        <span><span class="g-badge b-eu">🇪🇺 EU</span></span>
                        <span class="fw-500">€{{ number_format($euRevenue,2) }}</span>
                    </div>
                    <div class="c-row">
                        <span><span class="g-badge b-noeu">🌍 {{ translate('outside_eu') }}</span></span>
                        <span class="fw-500">€{{ number_format($nonEuRevenue,2) }}</span>
                    </div>
                    <div class="c-row fw-600">
                        <span>{{ translate('total') }}</span>
                        <span>€{{ number_format($grossRevenue,2) }}</span>
                    </div>
                    <div class="mt-2 pt-2 border-top d-flex justify-content-between" style="font-size:13px;">
                        <span class="text-muted">{{ translate('vat_collected') }}</span>
                        <span class="text-danger fw-500">€{{ number_format($vatCollected,2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- VAT by Country --}}
    <div class="card mb-3">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h6 class="mb-0">🏛 {{ translate('vat_report_oss') }}</h6>
                <a href="{{ route('admin.accounting.tax-report-pdf', ['date_type'=>$date_type,'from'=>$from,'to'=>$to]) }}"
                   class="btn btn-outline--primary btn-sm">
                    <i class="tio-file-text"></i> {{ translate('tax_report_pdf') }}
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-borderless table-hover mb-0">
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
                    <tr><td colspan="5" class="text-center py-4 text-muted">{{ translate('no_eu_transactions') }}</td></tr>
                    @endforelse
                    @if($vatByCountry->count() > 0)
                    <tr class="thead-light fw-600">
                        <td colspan="2"><strong>Total</strong></td>
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
                <h6 class="mb-0">{{ translate('recent_transactions') }} <span class="badge badge-soft-dark ms-1">{{ $txCount }}</span></h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.accounting.platform-finance-pdf', ['date_type'=>$date_type,'from'=>$from,'to'=>$to]) }}"
                       class="btn btn-outline--primary btn-sm"><i class="tio-file-text"></i> PDF</a>
                    <a href="{{ route('admin.accounting.platform-finance-excel', ['date_type'=>$date_type,'from'=>$from,'to'=>$to]) }}"
                       class="btn btn-outline--primary btn-sm">
                       <img width="13" src="{{ asset('assets/back-end/img/excel.png') }}" alt=""> Excel</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-borderless table-hover mb-0">
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
                                <span class="g-badge {{ $tx->is_eu ? 'b-eu' : 'b-noeu' }}">{{ $tx->user_country }}</span>
                            @else —
                            @endif
                        </td>
                        <td>
                            @if($tx->gateway==='stripe')
                                <span class="g-badge b-stripe">Stripe</span>
                            @elseif($tx->gateway==='paypal')
                                <span class="g-badge b-paypal">PayPal</span>
                            @else {{ $tx->gateway }}
                            @endif
                        </td>
                        <td>€{{ number_format($tx->gross_amount,2) }}</td>
                        <td class="text-danger">−€{{ number_format($tx->gateway_fee,2) }}</td>
                        <td class="text-danger">{{ $tx->vat_amount>0 ? '−€'.number_format($tx->vat_amount,2) : '—' }}</td>
                        <td style="color:#1D9E75;font-weight:500;">€{{ number_format($tx->net_amount,2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center py-4 text-muted">{{ translate('no_transactions_yet') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('script_2')
<script>
$("#date_type").change(function(){
    let v = $(this).val();
    $('#from_div,#to_div').toggle(v==='custom_date');
}).change();
</script>
@endpush

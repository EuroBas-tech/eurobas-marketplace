<html>
<head>
    <meta charset="UTF-8">
    <title>EuroBas — Platform Finance Report</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size:11px; color:#111; padding:20px; }
        .header { display:flex; justify-content:space-between; align-items:flex-start; border-bottom:2px solid #0f4c81; padding-bottom:12px; margin-bottom:16px; }
        .logo-area h1 { font-size:20px; color:#0f4c81; font-weight:700; }
        .logo-area p  { font-size:10px; color:#666; }
        .report-info  { text-align:right; font-size:10px; color:#555; }
        .section-title { font-size:12px; font-weight:700; color:#0f4c81; border-bottom:1px solid #cde; padding-bottom:4px; margin:16px 0 8px; text-transform:uppercase; letter-spacing:.04em; }
        .stat-grid { display:table; width:100%; border-collapse:collapse; margin-bottom:4px; }
        .stat-cell { display:table-cell; width:25%; border:1px solid #e0e4ea; padding:8px 10px; vertical-align:top; }
        .stat-label { font-size:9px; color:#888; text-transform:uppercase; letter-spacing:.04em; }
        .stat-value { font-size:15px; font-weight:700; margin-top:3px; }
        .green { color:#1D9E75; }
        .red   { color:#c53030; }
        .blue  { color:#2b6cb0; }
        table  { width:100%; border-collapse:collapse; font-size:10px; }
        th { background:#f0f4f8; padding:6px 8px; text-align:left; font-size:9px; text-transform:uppercase; letter-spacing:.04em; color:#555; border-bottom:1px solid #ddd; }
        td { padding:6px 8px; border-bottom:1px solid #eee; }
        tr:nth-child(even) td { background:#fafafa; }
        .total-row td { font-weight:700; background:#f0f4f8 !important; border-top:1px solid #ccc; }
        .footer { margin-top:24px; padding-top:10px; border-top:1px solid #ddd; font-size:9px; color:#aaa; text-align:center; }
        .badge { display:inline-block; padding:1px 6px; border-radius:8px; font-size:9px; font-weight:600; }
        .badge-eu  { background:#d1e7dd; color:#0a6640; }
        .badge-row { background:#fff3cd; color:#856404; }
    </style>
</head>
<body>

{{-- Header --}}
<div class="header">
    <div class="logo-area">
        <h1>EuroBas.com</h1>
        <p>Europe's Premium Marketplace</p>
        @if(!empty($company_email))<p>{{ $company_email }}</p>@endif
    </div>
    <div class="report-info">
        <strong>Platform Finance Report</strong><br>
        Generated: {{ now()->format('d M Y, H:i') }}<br>
        Period: {{ ucwords(str_replace('_',' ', $date_type ?? 'this_year')) }}
        @if(!empty($from) && !empty($to))
            <br>{{ $from }} → {{ $to }}
        @endif
    </div>
</div>

{{-- Summary Stats --}}
<div class="section-title">Financial Summary</div>
<div class="stat-grid">
    <div class="stat-cell">
        <div class="stat-label">Total Revenue</div>
        <div class="stat-value blue">€{{ number_format($grossRevenue ?? 0, 2) }}</div>
    </div>
    <div class="stat-cell">
        <div class="stat-label">Gateway Fees</div>
        <div class="stat-value red">−€{{ number_format($gatewayFees ?? 0, 2) }}</div>
    </div>
    <div class="stat-cell">
        <div class="stat-label">Costs & Expenses</div>
        <div class="stat-value red">−€{{ number_format($costsAndExpenses ?? 0, 2) }}</div>
    </div>
    <div class="stat-cell">
        <div class="stat-label">Net Profit</div>
        <div class="stat-value green">€{{ number_format($netProfit ?? 0, 2) }}</div>
    </div>
</div>

{{-- VAT Section --}}
@if(!empty($vatByCountry) && $vatByCountry->count() > 0)
<div class="section-title">VAT Report — EU (OSS)</div>
<table>
    <thead>
        <tr>
            <th>Country</th>
            <th>VAT Rate</th>
            <th>Gross Revenue</th>
            <th>VAT to Pay</th>
            <th>Transactions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vatByCountry as $row)
        <tr>
            <td><strong>{{ $row['country'] }}</strong></td>
            <td>{{ $row['vat_rate'] }}%</td>
            <td>€{{ number_format($row['gross'], 2) }}</td>
            <td style="color:#c53030;font-weight:600;">€{{ number_format($row['vat_amount'], 2) }}</td>
            <td>{{ $row['count'] }}</td>
        </tr>
        @endforeach
        <tr class="total-row">
            <td colspan="2">TOTAL EU VAT</td>
            <td>€{{ number_format($vatByCountry->sum('gross'), 2) }}</td>
            <td style="color:#c53030;">€{{ number_format($vatByCountry->sum('vat_amount'), 2) }}</td>
            <td>{{ $vatByCountry->sum('count') }}</td>
        </tr>
        @if(!empty($nonEuRevenue))
        <tr>
            <td colspan="2">Outside EU (0%)</td>
            <td>€{{ number_format($nonEuRevenue, 2) }}</td>
            <td>€0.00</td>
            <td>—</td>
        </tr>
        @endif
    </tbody>
</table>
@endif

<div class="footer">
    EuroBas.com · This report is generated automatically · {{ now()->format('Y') }}
</div>

</body>
</html>

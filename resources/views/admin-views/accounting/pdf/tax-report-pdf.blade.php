<html>
<head>
    <meta charset="UTF-8">
    <title>EuroBas — VAT Tax Report</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'DejaVu Sans',Arial,sans-serif; font-size:11px; color:#111; padding:20px; }
        .header { border-bottom:2px solid #0f4c81; padding-bottom:12px; margin-bottom:16px; display:table; width:100%; }
        .header-left  { display:table-cell; vertical-align:top; }
        .header-right { display:table-cell; text-align:right; vertical-align:top; font-size:10px; color:#555; }
        h1 { font-size:20px; color:#0f4c81; font-weight:700; }
        .section-title { font-size:11px; font-weight:700; color:#0f4c81; border-bottom:1px solid #cde; padding-bottom:4px; margin:14px 0 8px; text-transform:uppercase; letter-spacing:.04em; }
        .info-box { background:#f0f4f8; border:1px solid #cde; border-radius:4px; padding:10px 14px; margin-bottom:14px; font-size:10px; color:#555; }
        table { width:100%; border-collapse:collapse; font-size:10px; }
        th { background:#f0f4f8; padding:7px 8px; text-align:left; font-size:9px; text-transform:uppercase; color:#555; border-bottom:1px solid #ddd; }
        td { padding:7px 8px; border-bottom:1px solid #eee; }
        tr:nth-child(even) td { background:#fafafa; }
        .total-row td { font-weight:700; background:#0f4c81 !important; color:#fff !important; border-top:2px solid #0a3870; }
        .summary-table { width:100%; border-collapse:collapse; margin-bottom:14px; }
        .summary-table td { border:1px solid #e0e4ea; padding:8px 12px; width:33%; vertical-align:top; }
        .s-label { font-size:9px; color:#888; text-transform:uppercase; letter-spacing:.04em; }
        .s-value { font-size:16px; font-weight:700; margin-top:3px; }
        .green { color:#1D9E75; } .red { color:#c53030; } .blue { color:#2b6cb0; }
        .footer { margin-top:24px; padding-top:10px; border-top:1px solid #ddd; font-size:9px; color:#aaa; text-align:center; }
        .oss-note { background:#fff3cd; border:1px solid #ffc107; border-radius:4px; padding:8px 12px; font-size:10px; color:#856404; margin-bottom:14px; }
    </style>
</head>
<body>

<div class="header">
    <div class="header-left">
        <h1>EuroBas.com</h1>
        <p style="font-size:10px;color:#666;">Europe's Premium Marketplace</p>
        @if(!empty($company_email))<p style="font-size:10px;color:#666;">{{ $company_email }}</p>@endif
    </div>
    <div class="header-right">
        <strong>VAT Tax Report — OSS</strong><br>
        Generated: {{ now()->format('d M Y, H:i') }}<br>
        Period: {{ ucwords(str_replace('_',' ', $date_type ?? 'this_year')) }}
        @if(!empty($from) && !empty($to))<br>{{ $from }} → {{ $to }}@endif
    </div>
</div>

<div class="oss-note">
    <strong>OSS (One Stop Shop):</strong> This report covers all EU VAT obligations. You can submit this report via your local tax authority to cover VAT in all EU countries at once.
</div>

<div class="section-title">Summary</div>
<table class="summary-table">
    <tr>
        <td><div class="s-label">Total EU Revenue</div><div class="s-value blue">€{{ number_format($totalEuGross??0,2) }}</div></td>
        <td><div class="s-label">Total VAT to Pay</div><div class="s-value red">€{{ number_format($totalVat??0,2) }}</div></td>
        <td><div class="s-label">Non-EU Revenue (0%)</div><div class="s-value green">€{{ number_format($nonEuRevenue??0,2) }}</div></td>
    </tr>
</table>

<div class="section-title">VAT Breakdown by EU Country</div>
<table>
    <thead>
        <tr>
            <th>Country</th>
            <th>VAT Rate</th>
            <th>Gross Revenue</th>
            <th>Net (excl. VAT)</th>
            <th>VAT Amount</th>
            <th>Transactions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($vatByCountry as $row)
        <tr>
            <td><strong>{{ $row['country'] }}</strong></td>
            <td>{{ $row['vat_rate'] }}%</td>
            <td>€{{ number_format($row['gross'],2) }}</td>
            <td>€{{ number_format($row['gross'] - $row['vat_amount'],2) }}</td>
            <td style="color:#c53030;font-weight:600;">€{{ number_format($row['vat_amount'],2) }}</td>
            <td>{{ $row['count'] }}</td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:12px;color:#888;">No EU transactions in this period</td></tr>
        @endforelse
        @if(isset($vatByCountry) && $vatByCountry->count() > 0)
        <tr class="total-row">
            <td colspan="2"><strong>TOTAL</strong></td>
            <td><strong>€{{ number_format($totalEuGross??0,2) }}</strong></td>
            <td><strong>€{{ number_format(($totalEuGross??0)-($totalVat??0),2) }}</strong></td>
            <td><strong>€{{ number_format($totalVat??0,2) }}</strong></td>
            <td><strong>{{ $vatByCountry->sum('count') }}</strong></td>
        </tr>
        @endif
    </tbody>
</table>

@if(($nonEuRevenue??0) > 0)
<div class="section-title" style="margin-top:16px;">Non-EU Revenue (VAT = 0%)</div>
<table>
    <thead>
        <tr><th>Region</th><th>Revenue</th><th>VAT Rate</th><th>VAT Amount</th></tr>
    </thead>
    <tbody>
        <tr>
            <td>Outside European Union</td>
            <td>€{{ number_format($nonEuRevenue,2) }}</td>
            <td>0%</td>
            <td>€0.00</td>
        </tr>
    </tbody>
</table>
@endif

<div class="footer">
    EuroBas.com · VAT Tax Report · Generated {{ now()->format('d M Y') }} ·
    This document is for informational purposes. Please consult your tax advisor for official submissions.
</div>

</body>
</html>

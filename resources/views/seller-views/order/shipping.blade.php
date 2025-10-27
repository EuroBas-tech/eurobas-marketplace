<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ucwords('invoice')}}</title>
    <meta http-equiv="Content-Type" content="text/html;"/>
    <meta charset="UTF-8">
    <style media="all">
        * {
            margin: 0;
            padding: 0;
            line-height: 1.3;
            font-family: sans-serif;
            color: #333542;
        }

        /* IE 6 */
        * html .footer {
            position: absolute;
            top: expression((0-(footer.offsetHeight)+(document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight)+(ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop))+'px');
        }

        body {
            font-size: .75rem;
        }

        img {
            max-width: 100%;
        }

        .customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        table {
            width: 100%;
        }

        table thead th {
            padding: 8px;
            font-size: 11px;
            text-align: left;
        }

        table tbody th,
        table tbody td {
            padding: 8px;
            /*font-size: 11px;*/
        }

        table.fz-12 thead th {
            font-size: 12px;
        }

        table.fz-12 tbody th,
        table.fz-12 tbody td {
            font-size: 12px;
        }

        table.customers thead th {
            background-color: #0177CD;
            color: #fff;
        }

        table.customers tbody th,
        table.customers tbody td {
            background-color: #FAFCFF;
        }

        table.calc-table th {
            text-align: left;
        }

        table.calc-table td {
            text-align: right;
        }
        table.calc-table td.text-left {
            text-align: left;
        }

        .table-total {
            font-family: Arial, Helvetica, sans-serif;
        }


        .text-left {
            text-align: left !important;
        }

        .pb-2 {
            padding-bottom: 8px !important;
        }

        .pb-3 {
            padding-bottom: 16px !important;
        }

        .text-right {
            text-align: right !important;
        }

        table th.text-right {
            text-align: right !important;
        }

        @media print {
            table th.text-right {
                text-align: right !important;
            }
        }

        .content-position {
            padding: 15px 40px;
        }

        .content-position-y {
            padding: 0px 40px;
        }

        .text-white {
            color: white !important;
        }

        .bs-0 {
            border-spacing: 0;
        }
        .text-center {
            text-align: center;
        }
        .mb-1 {
            margin-bottom: 4px !important;
        }
        .mb-2 {
            margin-bottom: 8px !important;
        }
        .mb-4 {
            margin-bottom: 24px !important;
        }
        .mb-30 {
            margin-bottom: 30px !important;
        }
        .px-10 {
            padding-left: 10px;
            padding-right: 10px;
        }
        .fz-14 {
            font-size: 14px;
        }
        .fz-12 {
            font-size: 12px;
        }
        .fz-10 {
            font-size: 10px;
        }
        .font-normal {
            font-weight: 400;
        }
        .font-weight-normal {
            font-weight: normal;
        }
        .border-dashed-top {
            border-top: 1px dashed #ddd;
        }
        .font-weight-bold {
            font-weight: 700;
        }
        .bg-light {
            background-color: #F7F7F7;
        }
        .py-30 {
            padding-top: 30px;
            padding-bottom: 30px;
        }
        .py-4 {
            padding-top: 24px;
            padding-bottom: 24px;
        }
        .d-flex {
            display: flex;
        }
        .gap-2 {
            gap: 8px;
        }
        .flex-wrap {
            flex-wrap: wrap;
        }
        .align-items-center {
            align-items: center;
        }
        .justify-content-center {
            justify-content: center;
        }
        a {
            color: rgba(0, 128, 245, 1);
        }
        .p-1 {
            padding: 4px !important;
        }
        .h2 {
            font-size: 1.5em;
            margin-block-start: 0.83em;
            margin-block-end: 0.83em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            font-weight: bold;
        }

        .h4 {
            margin-block-start: 1.33em;
            margin-block-end: 1.33em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            font-weight: bold;
        }

    </style>
</head>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>
@php
    use App\Model\BusinessSetting;
    $company_phone =BusinessSetting::where('type', 'company_phone')->first()->value;
    $company_email =BusinessSetting::where('type', 'company_email')->first()->value;
    $company_name =BusinessSetting::where('type', 'company_name')->first()->value;
    $company_web_logo =BusinessSetting::where('type', 'company_web_logo')->first()->value;
    $company_mobile_logo =BusinessSetting::where('type', 'company_mobile_logo')->first()->value;
@endphp


@if ($order->order_type == 'default_type')
    <div class="">
        <section>
            <table class="content-position-y fz-12">
                <tr>
                    <td class="font-weight-bold p-1">

                                    @if($order->shipping_address_data)
                                        @php
                                            $shipping_address = json_decode($order->shipping_address_data)
                                        @endphp
                                        <span class="h2" style="margin: 0px;">{{ucwords('shipping to')}} </span>
                                        <div class="h4 montserrat-normal-600">
                                            <p style=" margin-top: 6px; margin-bottom:0px;">name : {{$shipping_address->contact_person_name}}</p>
                                            <p style=" margin-top: 6px; margin-bottom:0px;"> phone : {{$shipping_address->phone}}</p>
                                            <p style=" margin-top: 6px; margin-bottom:0px;">address :{{$shipping_address->address}}</p>
                                            <p style=" margin-top: 6px; margin-bottom:0px;">city : {{ $shipping_address->city }} , zip :{{ $shipping_address->zip }} </p>
                                        </div>
                                    @else
                                        <span class="h2" style="margin: 0px;">{{ ucwords('customer info')}} </span>
                                        <div class="h4 montserrat-normal-600">
                                            @if($order->is_guest)
                                                <p style=" margin-top: 6px; margin-bottom:0px;">Guest User</p>
                                            @else
                                                <p style=" margin-top: 6px; margin-bottom:0px;">{{ $order->customer !=null? $order->customer['f_name'].' '.$order->customer['l_name']:'Name not found' }}</p>
                                            @endif

                                            @if (isset($order->customer) && $order->customer['id']!=0)
                                                <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->customer !=null? $order->customer['email']: ucwords('email not found')}}</p>
                                                <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->customer !=null? $order->customer['phone']: ucwords('phone not found')}}</p>
                                            @endif
                                        </div>
                                        @endif
                                        </p>

                    </td>
                </tr>
            </table>
        </section>
    </div>
@else
    <div class="row">
        <section>
            <table class="content-position-y" style="width: 100%">
                <tr>
                    <td class="text-center" valign="top">
                        <span class="h2" style="margin: 0px;">{{ ucwords('POS order')}} </span>

                    </td>

                </tr>
            </table>
        </section>
    </div>
@endif

<br>

</body>
</html>

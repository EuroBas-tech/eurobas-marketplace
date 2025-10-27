@extends('layouts.back-end.app-seller')

@section('title', translate('dashboard'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Heading -->
        <div class="page-header pb-0 border-0 mb-3">
            <div class="flex-between row align-items-center mx-1">
                <div>
                    <h1 class="page-header-title">{{translate('dashboard')}}</h1>
                    <div>{{ translate('welcome_message')}}.</div>
                </div>

                <div class="d-flex align-items-center gap-3" >
                    <a class="btn btn--primary" href="{{route('seller.orders.list',['all'])}}">
                        <i class="tio-shopping-cart mr-1"></i> {{translate('all_orders')}}
                    </a>
                    <a class="btn btn--primary" href="{{route('seller.product.list')}}">
                        <i class="tio-premium-outlined mr-1"></i> {{translate('products')}}
                    </a>
                    <a class="btn btn--primary" onclick="choose_delivery_type()" href="#">
                        <svg class="mr-2" style="fill: white;" width="17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path d="M112 0C85.5 0 64 21.5 64 48l0 48L16 96c-8.8 0-16 7.2-16 16s7.2 16 16 16l48 0 208 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L64 160l-16 0c-8.8 0-16 7.2-16 16s7.2 16 16 16l16 0 176 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L64 224l-48 0c-8.8 0-16 7.2-16 16s7.2 16 16 16l48 0 144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L64 288l0 128c0 53 43 96 96 96s96-43 96-96l128 0c0 53 43 96 96 96s96-43 96-96l32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-64 0-32 0-18.7c0-17-6.7-33.3-18.7-45.3L512 114.7c-12-12-28.3-18.7-45.3-18.7L416 96l0-48c0-26.5-21.5-48-48-48L112 0zM544 237.3l0 18.7-128 0 0-96 50.7 0L544 237.3zM160 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96zm272 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0z"></path>
                        </svg>
                        {{translate('free_delivery_over_amount')}}
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Statistics -->
        <div class="card mb-3 remove-card-shadow">
            <div class="card-body">
                <div class="row justify-content-between align-items-center g-2 mb-3">
                    <div class="col-sm-6">
                        <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                            <img src="{{asset('public/assets/back-end/img/business_analytics.png')}}" alt="">
                            {{translate('business_analytics')}}
                        </h4>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-sm-end">
                        <select class="custom-select w-auto" name="statistics_type"
                                onchange="order_stats_update(this.value)">
                            <option
                                value="overall" {{session()->has('statistics_type') && session('statistics_type') == 'overall'?'selected':''}}>
                                {{translate('overall_Statistics')}}
                            </option>
                            <option
                                value="today" {{session()->has('statistics_type') && session('statistics_type') == 'today'?'selected':''}}>
                                {{translate('todays_Statistics')}}
                            </option>
                            <option
                                value="this_month" {{session()->has('statistics_type') && session('statistics_type') == 'this_month'?'selected':''}}>
                                {{translate('this_Months_Statistics')}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row g-2" id="order_stats">
                    @include('seller-views.partials._dashboard-order-stats',['data'=>$data])
                </div>
            </div>
        </div>

        <div class="modal" id="third_party_delivery_service_modal" role="dialog" tabindex="-1" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{translate('free_delivery_over_amount')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                            <form action="{{route('seller.shop.order-settings')}}" method="post" enctype="multipart/form-data"
                                id="add_fund">
                                @csrf
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="text-capitalize mb-0">
                                            <i class="tio-dollar-outlined"></i>
                                            {{translate('free_delivery_over_amount')}}
                                        </h5>
                                    </div>
                                    <div class="card-body"
                                        style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                        <div class="row align-items-end">
                                            <div class="col-xl-6 col-md-6">
                                                <div
                                                    class="d-flex justify-content-between align-items-center gap-10 form-control form-group">
                                                    <span class="title-color d-flex align-items-center gap-1">
                                                        {{translate('free_Delivery')}}
                                                        <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                                            data-placement="top"
                                                            title="{{translate('if_enabled_free_delivery_will_be_available_when_customers_order_over_a_certain_amount')}}">
                                                            <img width="16"
                                                                src="{{asset('public/assets/back-end/img/info-circle.svg')}}" alt="">
                                                        </span>
                                                    </span>

                                                    <label class="switcher" for="free_delivery_status">
                                                        <input type="checkbox" class="switcher_input" name="free_delivery_status"
                                                            id="free_delivery_status" {{$seller->free_delivery_status == 1?'checked':''}}
                                                            onclick="toogleModal(event,'free_delivery_status','free-delivery-on.png','free-delivery-off.png','{{translate('want_to_Turn_ON_Free_Delivery')}}','{{translate('want_to_Turn_OFF_Free_Delivery')}}',`<p>{{translate('if_enabled_the_free_delivery_feature_will_be_shown_from_the_system')}}</p>`,`<p>{{translate('if_disabled_the_free_delivery_feature_will_be_hidden_from_the_system')}}</p>`)">
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="title-color d-flex align-items-center gap-2"
                                                        for="free_delivery_over_amount">
                                                        {{translate('free_Delivery_Over')}} ({{\App\CPU\BackEndHelper::currency_symbol()}})
                                                        <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                                            data-placement="top" title="{{ translate('customers_will_get_free_delivery_if_the_order_amount_exceeds_the_given_amount') }} {{ translate('and_the_given_amount_will_be_added_as_seller_expenses') }}">
                                                            <img width="16"
                                                                src="{{asset('public/assets/back-end/img/info-circle.svg')}}" alt="">
                                                        </span>
                                                    </label>
                                                    <input type="number" class="form-control" name="free_delivery_over_amount"
                                                        id="free_delivery_over_amount" min="0"
                                                        placeholder="{{translate('ex')}} : {{translate('10')}}"
                                                        value="{{ \App\CPU\Convert::default($seller->free_delivery_over_amount) ?? 0 }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" id="submit"
                                                class="btn btn--primary px-4">{{translate('submit')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Stats -->

        <div class="modal fade" id="balance-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content"
                     style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{translate('withdraw_Request')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('seller.withdraw.request')}}" method="post">
                        <div class="modal-body">
                            @csrf
                            <div class="">
                                <select class="form-control" id="withdraw_method" name="withdraw_method" required>
                                    @foreach($withdrawal_methods as $item)
                                        <option value="{{$item['id']}}" {{ $item['is_default'] ? 'selected':'' }}>{{$item['method_name']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="" id="method-filed__div">

                            </div>

                            <div class="mt-1">
                                <label for="recipient-name" class="col-form-label fz-16">{{translate('amount')}}
                                    :</label>
                                <input type="number" name="amount" step=".01"
                                       value="{{\App\CPU\BackEndHelper::usd_to_currency($data['total_earning'])}}"
                                       class="form-control" id="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{translate('close')}}</button>
                                <button type="submit"
                                        class="btn btn--primary">{{translate('request')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row g-2">
            <div class="col-lg-12">
                <!-- Card -->
                <div class="card h-100 remove-card-shadow">
                    <!-- Body -->
                    <div class="card-body">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-6">
                                <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                                    <img src="{{asset('public/assets/back-end/img/earning_statictics.png')}}" alt="">
                                    {{translate('earning_statistics')}}
                                </h4>
                            </div>
                            <div class="col-md-6 d-flex justify-content-md-end">
                                <ul class="option-select-btn">
                                    <li>
                                        <label class="basic-box-shadow">
                                            <input type="radio" name="statistics2" hidden="" checked="">
                                            <span data-earn-type="yearEarn"
                                                  onclick="earningStatisticsUpdate(this)">{{translate('this_Year')}}</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="basic-box-shadow">
                                            <input type="radio" name="statistics2" hidden="">
                                            <span data-earn-type="MonthEarn"
                                                  onclick="earningStatisticsUpdate(this)">{{translate('this_Month')}}</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="basic-box-shadow">
                                            <input type="radio" name="statistics2" hidden="">
                                            <span data-earn-type="WeekEarn"
                                                  onclick="earningStatisticsUpdate(this)">{{translate('this_Week')}}</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Bar Chart -->
                        <div class="chartjs-custom mt-2" id="set-new-graph">
                            <canvas id="updatingData" class="earningShow"
                                    data-hs-chartjs-options='{
                            "type": "bar",
                            "data": {
                              "labels": ["Jan","Feb","Mar","April","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                              "datasets": [{
                                "label": "{{ translate('seller')}}",
                                "data": [
                                    @php($i = 0)
                                    @php($array_count = count($seller_data))
                                    @foreach($seller_data as $value)
                                    {{ $value }}{{ (++$i < $array_count) ? ',':'' }}
                                    @endforeach
                                        ],
                                        "backgroundColor": "#0177CD",
                                        "borderColor": "#0177CD"
                                      },
                                      {
                                        "label": "{{ translate('commission')}}",
                                        "data": [
                                    @php($i = 0)
                                    @php($array_count = count($commission_data))
                                    @foreach($commission_data as $value)
                                    {{ $value }}{{ (++$i < $array_count) ? ',':'' }}
                                    @endforeach
                                        ],
                                        "backgroundColor": "#FFB36D",
                                        "borderColor": "#FFB36D"
                                      }]
                                    },
                                    "options": {
                                    "legend": {
                                        "display": true,
                                        "position": "top",
                                        "align": "center",
                                        "labels": {
                                            "usePointStyle": true,
                                            "boxWidth": 6,
                                            "fontColor": "#758590",
                                            "fontSize": 14
                                        }
                                    },
                                      "scales": {
                                        "yAxes": [{
                                          "gridLines": {
                                                "color": "rgba(180, 208, 224, 0.5)",
                                                "borderDash": [8, 4],
                                                "drawBorder": false,
                                                "zeroLineColor": "rgba(180, 208, 224, 0.5)"
                                          },
                                          "ticks": {
                                            "beginAtZero": true,
                                            "fontSize": 12,
                                            "fontColor": "#97a4af",
                                            "fontFamily": "Open Sans, sans-serif",
                                            "padding": 10,
                                            "postfix": " {{\App\CPU\BackEndHelper::currency_symbol()}}"
                                  }
                                }],
                                "xAxes": [{
                                  "gridLines": {
                                        "color": "rgba(180, 208, 224, 0.5)",
                                        "display": true,
                                        "drawBorder": true,
                                        "zeroLineColor": "rgba(180, 208, 224, 0.5)"
                                  },
                                  "ticks": {
                                    "fontSize": 12,
                                    "fontColor": "#97a4af",
                                    "fontFamily": "Open Sans, sans-serif",
                                    "padding": 5
                                  },
                                  "categoryPercentage": 0.5,
                                  "maxBarThickness": "7"
                                }]
                              },
                              "cornerRadius": 3,
                              "tooltips": {
                                "prefix": " ",
                                "hasIndicator": true,
                                "mode": "index",
                                "intersect": false
                              },
                              "hover": {
                                "mode": "nearest",
                                "intersect": true
                              }
                            }
                          }'></canvas>
                        </div>
                        <!-- End Bar Chart -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-4">
                <!-- Card -->
                <div class="card h-100 remove-card-shadow">
                    @include('seller-views.partials._top-selling-products',['top_sell'=>$data['top_sell']])
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-4">
                <!-- Card -->
                <div class="card h-100 remove-card-shadow">
                    @include('seller-views.partials._most-rated-products',['most_rated_products'=>$data['most_rated_products']])
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-4">
                <!-- Card -->
                <div class="card h-100 remove-card-shadow">
                    @include('seller-views.partials._top-delivery-man',['top_deliveryman'=>$data['top_deliveryman']])
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{asset('public/assets/back-end')}}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/chart.js.extensions/chartjs-extensions.js"></script>
    <script
        src="{{asset('public/assets/back-end')}}/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>
@endpush

@push('script_2')
    <script>
        function earningStatisticsUpdate(t) {
            let value = $(t).attr('data-earn-type');

            $.ajax({
                url: '{{route('seller.dashboard.earning-statistics')}}',
                type: 'GET',
                data: {
                    type: value
                },
                beforeSend: function () {
                    $('#loading').fadeIn();
                },
                success: function (response_data) {
                    document.getElementById("updatingData").remove();
                    let graph = document.createElement('canvas');
                    graph.setAttribute("id", "updatingData");
                    document.getElementById("set-new-graph").appendChild(graph);

                    var ctx = document.getElementById("updatingData").getContext("2d");
                    var options = {
                        responsive: true,
                        bezierCurve: false,
                        maintainAspectRatio: false,
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    color: "rgba(180, 208, 224, 0.5)",
                                    zeroLineColor: "rgba(180, 208, 224, 0.5)",
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    color: "rgba(180, 208, 224, 0.5)",
                                    zeroLineColor: "rgba(180, 208, 224, 0.5)",
                                    borderDash: [8, 4],
                                }
                            }]
                        },
                        legend: {
                            display: true,
                            position: "top",
                            labels: {
                                usePointStyle: true,
                                boxWidth: 6,
                                fontColor: "#758590",
                                fontSize: 14
                            }
                        },
                        plugins: {
                            datalabels: {
                                display: false
                            }
                        },
                    };
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: [],
                            datasets: [
                                {
                                    label: "{{ translate('seller')}}",
                                    data: [],
                                    backgroundColor: "#0177CD",
                                    borderColor: "#0177CD",
                                    fill: false,
                                    lineTension: 0.3,
                                    radius: 0
                                },
                                {
                                    label: "{{ translate('In-house')}}",
                                    data: [],
                                    backgroundColor: "#FFB36D",
                                    borderColor: "#FFB36D",
                                    fill: false,
                                    lineTension: 0.3,
                                    radius: 0
                                }
                            ]
                        },
                        options: options
                    });

                    myChart.data.labels = response_data.seller_label;
                    myChart.data.datasets[0].data = response_data.seller_earn;
                    myChart.data.datasets[1].data = response_data.commission_earn;

                    myChart.update();
                },
                complete: function () {
                    $('#loading').fadeOut();
                }
            });
        }
    </script>
    <script>
        // INITIALIZATION OF CHARTJS
        // =======================================================
        Chart.plugins.unregister(ChartDataLabels);

        $('.js-chart').each(function () {
            $.HSCore.components.HSChartJS.init($(this));
        });

        var updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));
    </script>

    <script>
        $(document).ready(function () {
            let method_id = $('#withdraw_method').val()
            withdraw_method_field(method_id);
        });

        $('#withdraw_method').on('change', function () {
            withdraw_method_field(this.value);
        });

        function withdraw_method_field(method_id){

            // Set header if need any otherwise remove setup part
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('seller.withdraw.method-list')}}" + "?method_id=" + method_id,
                data: {},
                processData: false,
                contentType: false,
                type: 'get',
                success: function (response) {
                    let method_fields = response.content.method_fields;
                    $("#method-filed__div").html("");
                    method_fields.forEach((element, index) => {
                        console.log(element.input_name);
                        $("#method-filed__div").append(`
                        <div class="mt-3">
                            <label for="wr_num" class="fz-16 c1 mb-2" style="color: #5b6777 !important;">${element.input_name.replaceAll('_', ' ')}</label>
                            <input type="${element.input_type}" class="form-control" name="${element.input_name}" placeholder="${element.placeholder}" ${element.is_required === 1 ? 'required' : ''}>
                        </div>
                    `);
                    })

                },
                error: function () {

                }
            });
        }
    </script>

    <script>
        var ctx = document.getElementById('business-overview');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    '{{translate('customer')}} ',
                    '{{translate('store')}} ',
                    '{{translate('product')}} ',
                    '{{translate('order')}} ',
                    '{{translate('brand')}} ',
                ],
                datasets: [{
                    label: '{{translate('business')}}',
                    data: ['{{$data['customer']}}', '{{$data['store']}}', '{{$data['product']}}', '{{$data['order']}}', '{{$data['brand']}}'],
                    backgroundColor: [
                        '#041562',
                        '#DA1212',
                        '#EEEEEE',
                        '#11468F',
                        '#000000',
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        $(function () {

            //get the doughnut chart canvas
            var ctx1 = $("#user_overview");

            //doughnut chart data
            var data1 = {
                labels: ["Customer", "Seller", "Delivery Man"],
                datasets: [
                    {
                        label: "User Overview",
                        data: [88297, 34546, 15000],
                        backgroundColor: [
                            "#017EFA",
                            "#51CBFF",
                            "#56E7E7",
                        ],
                        borderColor: [
                            "#017EFA",
                            "#51CBFF",
                            "#56E7E7",
                        ],
                        borderWidth: [1, 1, 1]
                    }
                ]
            };

            //options
            var options = {
                responsive: true,
                legend: {
                    display: true,
                    position: "bottom",
                    align: "start",
                    maxWidth: 100,
                    labels: {
                        usePointStyle: true,
                        boxWidth: 6,
                        fontColor: "#758590",
                        fontSize: 14
                    }
                },
                plugins: {
                    datalabels: {
                        display: false
                    }
                },
            };

            //create Chart class object
            var chart1 = new Chart(ctx1, {
                type: "doughnut",
                data: data1,
                options: options
            });
        });
    </script>

    <script>
        function call_duty() {
            toastr.warning('{{translate('update_your_bank_info_first')}}!', '{{translate('warning')}}!', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>

    <script>
        function choose_delivery_type()
        {
            $('.choose_delivery_man').hide();
            $('#by_third_party_delivery_service_info').show();
            $('#third_party_delivery_service_modal').modal("show");
        }
    </script>

    <script>
        function order_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('seller.dashboard.order-stats')}}',
                data: {
                    statistics_type: type
                },
                beforeSend: function () {
                    $('#loading').fadeIn();
                },
                success: function (data) {
                    $('#order_stats').html(data.view)
                },
                complete: function () {
                    $('#loading').fadeOut();
                }
            });
        }

        function business_overview_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.dashboard.business-overview')}}',
                data: {
                    business_overview: type
                },
                beforeSend: function () {
                    $('#loading').fadeIn();
                },
                success: function (data) {
                    console.log(data.view)
                    $('#business-overview-board').html(data.view)
                },
                complete: function () {
                    $('#loading').fadeOut();
                }
            });
        }
    </script>
@endpush

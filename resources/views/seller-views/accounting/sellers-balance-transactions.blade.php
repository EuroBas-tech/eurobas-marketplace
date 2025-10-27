@extends('layouts.back-end.app-seller')

@section('title', translate('balance_transactions'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2 align-items-center">
                <img width="20" src="{{asset('public/assets/back-end/img/accounting.png')}}" alt="">
                {{translate('accounting')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inlile Menu -->
        @include('seller-views.accounting.partials.product-report-inline-menu')
        <!-- End Inlile Menu -->

        <div class="card mb-2">
            <div class="card-body">
                <h4 class="mb-3">{{translate('filter_Data')}}</h4>
                <form action="#" id="form-data" method="GET" class="w-100">
                    <div class="row  gx-2 gy-3 align-items-center text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        <div class="col-sm-6 col-md-3">
                            <div class="">
                                <select class="form-control __form-control" name="transaction_type">
                                    <option class="text-center" value="0" disabled>
                                        ---{{translate('select_type')}}---
                                    </option>
                                    <option class="text-capitalize"
                                            value="all" {{ $transaction_type == 'all'? 'selected' : '' }} >{{translate('all_types')}} </option>
                                    <option class="text-capitalize"
                                            value="automatic" {{ $transaction_type == 'automatic'? 'automatic' : '' }} >{{translate('automatic')}} </option>
                                    <option class="text-capitalize"
                                            value="manually" {{ $transaction_type == 'manually'? 'selected' : '' }}>{{translate('manually')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <select class="form-control __form-control" name="date_type" id="date_type">
                                <option value="this_year" {{ $date_type == 'this_year'? 'selected' : '' }}>{{translate('this_Year')}}</option>
                                <option value="this_month" {{ $date_type == 'this_month'? 'selected' : '' }}>{{translate('this_Month')}}</option>
                                <option value="this_week" {{ $date_type == 'this_week'? 'selected' : '' }}>{{translate('this_Week')}}</option>
                                <option value="custom_date" {{ $date_type == 'custom_date'? 'selected' : '' }}>{{translate('custom_Date')}}</option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3" id="from_div">
                            <div class="form-floating">
                                <input type="date" name="from" value="{{$from}}" id="from_date" class="form-control __form-control">
                                <label>{{translate('start_date')}}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3" id="to_div">
                            <div class="form-floating">
                                <input type="date" value="{{$to}}" name="to" id="to_date" class="form-control __form-control">
                                <label>{{translate('end_date')}}</label>
                            </div>
                        </div>
                        <div class="col-md-12 d-flex justify-content-end gap-2 pt-0">
                            <button type="submit" class="btn btn--primary px-4 min-w-120 __h-45px" onclick="formUrlChange(this)"
                                    data-action="{{ url()->current() }}">
                                {{translate('filter')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header flex-wrap gap-2">
                        <h5 class="mb-0 text-capitalize">{{ translate('receive_Request_Table')}}
                            <span class="badge badge-soft-dark radius-50 fz-12 ml-1">{{ $transactions->total() }}</span>
                        </h5>
                        <div class="d-flex align-items-center" >
                            <form action="{{ url()->full() }}" method="GET" class="mb-0">
                                <!-- Search -->
                                <div class="input-group input-group-merge input-group-custom">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" name="date_type" value="{{ $date_type }}">
                                    <input type="hidden" name="from" value="{{ $from }}">
                                    <input type="hidden" name="to" value="{{ $to }}">
                                    <input id="datatableSearch_" type="search" name="search" class="form-control"
                                        placeholder="{{ translate('search_by_name_or_seller_id_or_amount')}}"
                                        aria-label="Search costs"
                                        value="{{ $search }}"
                                        required>
                                    <button type="submit" class="btn btn--primary">{{ translate('search')}}</button>
                                </div>
                                <!-- End Search -->
                            </form>
                            <div class="mx-2" >
                                <a href="{{ route('seller.accounting.balance-transaction-summary-pdf', ['date_type'=>request('date_type'), 'type' =>request('type'),'seller_id'=>request('seller_id'), 'from'=>request('from'), 'to'=>request('to')]) }}" class="btn btn-outline--primary text-nowrap btn-block">
                                    <i class="tio-file-text"></i>
                                    {{translate('download_PDF')}}
                                </a>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline--primary text-nowrap btn-block"
                                        data-toggle="dropdown">
                                    <i class="tio-download-to"></i>
                                    {{translate('export')}}
                                    <i class="tio-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a class="dropdown-item"
                                        href="{{ route('seller.accounting.balance-transaction-export-excel', ['date_type'=>request('date_type'), 'from'=>request('from'), 'to'=>request('to'), 'search'=>request('search')]) }}"  >
                                            <img width="14" src="{{asset('public/assets/back-end/img/excel.png')}}" alt="">
                                            {{translate('excel')}}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="datatable"
                                style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{translate('SL')}}</th>
                                    <th>{{translate('amount')}}</th>
                                    <th>{{translate('payment_method')}}</th>
                                    <th>{{translate('transaction_type')}}</th>
                                    <th>{{translate('transaction_id')}}</th>
                                    <th>{{translate('date')}}</th>
                                    <th class="text-center">{{translate('action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($transactions->count() > 0)
                                @foreach($transactions as $key=>$transaction)
                                    <tr>
                                        <td>{{$transactions->firstitem()+$key}}</td>
                                        <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($transaction['amount']))}}</td>
                                        <td>{{$transaction->paymentMethod->method_name}}</td>
                                        <td>
                                            <label class="badge badge-soft-{{ ($transaction->type == 'manually') ? 'primary' : (($transaction->type == 'automatic') ? 'secondary' : 'success') }}" >{{ translate($transaction->type) }}</label>
                                        </td>
                                        <td>{{ $transaction->transaction_id }}</td>
                                        <td>{{date("F jS, Y", strtotime($transaction->created_at))}} ({{ $transaction->created_at->diffForHumans() }})</td>
                                        <td class="text-center">
                                            <form method="POST" action="{{ route('seller.accounting.pdf-balance-transaction') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $transaction->id }}" >
                                                <button type="submit" class="btn btn-outline-success square-btn btn-sm">
                                                    <i class="tio-download-to"></i>
                                                </button> 
                                            </form>  
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td colspan="5" class="text-center">
                                    <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description">
                                    <p class="mb-0">{{translate('no_data_to_show')}}</p>
                                </td>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-lg-end">
                            <!-- Pagination -->
                            {{$transactions->links()}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- End Stats -->
    </div>
@endsection

@push('script_2')
  <script>
      function status_filter(type) {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.post({
              url: '{{route('seller.business-settings.withdraw.status-filter')}}',
              data: {
                  withdraw_status_filter: type
              },
              beforeSend: function () {
                  $('#loading').fadeIn();
              },
              success: function (data) {
                 location.reload();
              },
              complete: function () {
                  $('#loading').fadeOut();
              }
          });
      }
  </script>

  <script>
      function close_request(route_name) {
          swal({
              title: "{{translate('are_you_sure')}}?",
              text: "{{translate('once_deleted_you_will_not_be_able_to_recover_this')}}",
              icon: "{{translate('warning')}}",
              buttons: true,
              dangerMode: true,
              confirmButtonText: "{{translate('ok')}}",
          })
              .then((willDelete) => {
                  if (willDelete.value) {
                      window.location.href = (route_name);
                  }
              });
      }
  </script>
@endpush


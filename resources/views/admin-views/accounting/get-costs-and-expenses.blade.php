@extends('layouts.back-end.app')

@section('title', translate('costs_and_expenses'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2 align-items-center">
                <img width="20" src="{{asset('assets/back-end/img/accounting.png')}}" alt="">
                {{translate('accounting')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inlile Menu -->
        @include('admin-views.accounting.partials.product-report-inline-menu')
        <!-- End Inlile Menu -->

        <div class="card mb-2">
            <div class="card-body">
                <h4 class="mb-3">{{translate('filter_Data')}}</h4>
                <form action="#" id="form-data" method="GET" class="w-100">
                    <div class="row  gx-2 gy-3 align-items-center text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">

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

        <div class="row mt-2">

            <div class="col-md-12 my-2" >
                <div class="text-end" >
                    <a href="#" onclick="choose_delivery_type()" class="btn btn--primary" >{{ translate('add_new') }}</a>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header flex-wrap gap-2">
                        <h5 class="mb-0 text-capitalize">{{ translate('costs_and_expenses_Table')}}
                            <span class="badge badge-soft-dark radius-50 fz-12 ml-1">{{ $costs->count() }}</span>
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
                                        placeholder="{{ translate('search_by_title_or_amount')}}"
                                        aria-label="Search costs"
                                        value="{{ $search }}"
                                        required>
                                    <button type="submit" class="btn btn--primary">{{ translate('search')}}</button>
                                </div>
                                <!-- End Search -->
                            </form>
                            <div class="mx-2" >
                                <a href="{{ route('admin.accounting.cost-summary-pdf', ['date_type'=>request('date_type'), 'type' =>request('type'),'seller_id'=>request('seller_id'), 'from'=>request('from'), 'to'=>request('to')]) }}" class="btn btn-outline--primary text-nowrap btn-block">
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
                                        href="{{ route('admin.accounting.cost-export-excel', ['date_type'=>request('date_type'), 'from'=>request('from'), 'to'=>request('to'), 'search'=>request('search')]) }}"  >
                                            <img width="14" src="{{asset('assets/back-end/img/excel.png')}}" alt="">
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
                                    <th>{{translate('title')}}</th>
                                    <th>{{translate('description')}}</th>
                                    <th>{{translate('value')}}</th>
                                    <th>{{translate('date')}}</th>
                                    <th class="text-center">{{translate('action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($costs->count() > 0)
                                @foreach($costs as $key=>$cost)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{ substr($cost->title, 0, 60) }}{{ strlen($cost->title) >= 60 ? '...' : '' }}</td>
                                        <td>{{ substr($cost->description, 0, 60) }}{{ strlen($cost->description) >= 60 ? '...' : '' }}</td>
                                        <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($cost->amount)) }}</td>
                                        <td>{{ $cost->created_at }} ({{ $cost->created_at->diffForHumans() }})</td>
                                        <td class="text-center d-flex align-items-center">
                                            <form method="POST" action="{{ route('admin.accounting.pdf-costs-and-expenses') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$cost->id}}" >
                                                <button type="submit" class="btn btn-outline-success square-btn btn-sm">
                                                    <i class="tio-download-to"></i>
                                                </button>
                                            </form>
                                            <a onclick="edit_cost({{$key+1}})" class="btn btn-outline-info mx-2 square-btn btn-sm">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.accounting.delete-costs-and-expenses') }}">
                                                @csrf
                                                <input  type="hidden" name="id" value="{{$cost->id}}" >
                                                <button type="submit" class="btn btn-outline-danger square-btn btn-sm">
                                                    <i class="tio-delete"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <div class="modal" id="edit_cost_modal{{$key+1}}" role="dialog" tabindex="-1" >
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{translate('add_new_cost_and_expense')}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <form action="{{ route('admin.accounting.update-costs-and-expenses') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{$cost->id}}">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <div class="d-flex align-items-center justify-content-between" >
                                                                            <label for="title">{{translate('title')}}</label>
                                                                        </div>

                                                                        <input class="form-control"  placeholder="{{ translate('add_a_cost_title') }}" type="text" name="title" value="{{ $cost->title }}" id="title" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="d-flex align-items-center justify-content-between" >
                                                                            <label for="description">{{translate('description')}}</label>
                                                                        </div>

                                                                        <textarea class="form-control" id="description" required placeholder="{{ translate('add_a_cost_description') }}" name="description" id="description">{{ substr($cost->description, 0, 60) }}</textarea>
                                                                    </div>

                                                                    <div class="form-group" >
                                                                        <div class="d-flex align-items-center justify-content-between" >
                                                                            <label for="amount">{{ translate('amount') }}</label>
                                                                        </div>
                                                                        <input class="form-control" id="amount" placeholder="{{ translate('add_a_cost_amount') }}" value="{{ \App\CPU\BackEndHelper::usd_to_currency($cost->amount) }}" type="number" step="0.01" name="amount" >
                                                                    </div>

                                                                    <button class="btn btn--primary" type="submit">{{translate('save')}}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                @endforeach
                            @else
                                <td colspan="5" class="text-center">
                                    <img class="mb-3 w-160" src="{{asset('assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description">
                                    <p class="mb-0">{{translate('no_data_to_show')}}</p>
                                </td>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-lg-end">
                            <!-- Pagination -->
                            {{$costs->links()}}
                        </div>
                    </div>
                </div>
            </div>

        </div>




        <div class="modal" id="third_party_delivery_service_modal" role="dialog" tabindex="-1" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{translate('add_new_cost_and_expense')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('admin.accounting.store-costs-and-expenses') }}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="d-flex align-items-center justify-content-between" >
                                                <label for="title">{{translate('title')}}</label>
                                            </div>

                                            <input class="form-control" placeholder="{{ translate('add_a_cost_title') }}" type="text" name="title" value="" id="title" required>
                                        </div>

                                        <div class="form-group">
                                            <div class="d-flex align-items-center justify-content-between" >
                                                <label for="description">{{translate('description')}}</label>
                                            </div>

                                            <textarea class="form-control" id="description" required placeholder="{{ translate('add_a_cost_description') }}" name="description" id="description"></textarea>
                                        </div>

                                        <div class="form-group" >
                                            <div class="d-flex align-items-center justify-content-between" >
                                                <label for="amount">{{ translate('amount') }}</label>
                                            </div>

                                            <input class="form-control" id="amount" placeholder="{{ translate('add_a_cost_amount') }}" type="number" step="0.01" name="amount" >
                                        </div>

                                        <button class="btn btn--primary" type="submit">{{translate('save')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Stats -->




        <!-- End Stats -->
    </div>
@endsection

@push('script_2')

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

    <script>
        function choose_delivery_type()
        {
            $('.choose_delivery_man').hide();
            $('#by_third_party_delivery_service_info').show();
            $('#third_party_delivery_service_modal').modal("show");
        }

        function edit_cost($id)
        {
            $('.choose_delivery_man').hide();
            $('#edit_cost_modal'+$id).show();
            $('#edit_cost_modal'+$id).modal("show");
        }
    </script>
@endpush


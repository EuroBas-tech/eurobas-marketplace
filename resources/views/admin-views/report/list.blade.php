@extends('layouts.back-end.app')

@section('title', translate('report_List'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Title -->
        <div class="mb-4">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/assets/back-end/img/report.png')}}" alt="">
                {{translate('reports_list')}}
                <span class="badge badge-soft-dark radius-50">{{ \App\Model\AdReport::count() }}</span>
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="px-3 py-4">
                <div class="row gy-2 align-items-center">
                    <div class="col-sm-8 col-md-6 col-lg-4">
                        <!-- Search -->
                        <form action="{{ url()->current() }}" method="GET" >
                            <div class="input-group input-group-merge input-group-custom">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                    placeholder="{{translate('search_by_Name_or_Email_or_Phone')}}"
                                    aria-label="Search orders" value="{{ $search }}">
                                <button type="submit" class="btn btn--primary">{{translate('search')}}</button>
                            </div>
                        </form>
                        <!-- End Search -->
                    </div>
                    <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                        <div class="d-flex justify-content-sm-end">
                            <button type="button" class="btn btn-outline--primary" data-toggle="dropdown">
                                <i class="tio-download-to"></i>
                                {{translate('export')}}
                                <i class="tio-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a class="dropdown-item" href="{{route('admin.report.export',['search'=>request('search')])}}">
                                        <img width="14" src="{{asset('/assets/back-end/img/excel.png')}}" alt="">
                                        {{translate('excel')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table
                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                    class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                    <thead class="thead-light thead-50 text-capitalize">
                    <tr>
                        <th>{{translate('SL')}}</th>
                        <th>{{translate('message')}}</th>
                        <th>{{translate('ad')}}</th>
                        <th>{{translate('user')}}</th>
                        <th>{{translate('date')}}</th>
                        <th class="text-center">{{translate('report_status')}}</th>
                        <th class="text-center">{{translate('action')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach($reports as $key=>$report)
                            <tr>
                                <td>
                                    {{$reports->firstItem()+$key}}
                                </td>
                                <td>{{$report['message']}}</td>
                                <td class="mx-5" >
                                    <a href="{{route('ads-show', $report['ad']['slug'])}}" target="_blank" >
                                        {{substr($report['ad']['title'], 0, 40).(strlen($report['ad']['title']) > 40 ? '...' : '') ?? '/' }}
                                    </a>
                                </td>
                                <td>{{$report['user']['name'] ?? '/' }}</td>
                                <td>
                                    <div>{{$report->created_at->format('d-m-Y')}}</div>
                                    <div>{{$report->created_at->diffForHumans()}}</div>
                                </td>
                                <td class="text-center" >
                                    @if($report->status == 0)
                                        <span class="badge badge-info" >{{ translate('pending') }}</span>
                                    @elseif($report->status == 1)
                                        <span class="badge badge-success" >{{ translate('confirmed') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a title="{{translate('view')}}"
                                        class="btn btn-outline-info btn-sm square-btn"
                                        href="{{route('admin.report.view',[$report['id']])}}">
                                            <i class="tio-invisible"></i>
                                        </a>
                                        @if($report['id'] != '0')
                                            <a title="{{translate('delete')}}"
                                            class="btn btn-outline-danger btn-sm delete square-btn" href="javascript:"
                                            onclick="form_alert('report-{{$report['id']}}','{{translate('want_to_delete_this_report').'?'}}')">
                                                <i class="tio-delete"></i>
                                            </a>
                                        @endif
                                    </div>
                                    <form action="{{route('admin.report.delete')}}" method="POST" id="report-{{$report['id']}}">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="id" value="{{$report['id']}}" >
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <div class="table-responsive mt-4">
                <div class="px-4 d-flex justify-content-lg-end">
                    <!-- Pagination -->
                    {!! $reports->links() !!}
                </div>
            </div>

            @if(count($reports)==0)
                <div class="text-center p-4">
                    <img class="mb-3 w-160" src="{{asset('assets/back-end')}}/svg/illustrations/sorry.svg"
                         alt="Image Description">
                    <p class="mb-0">{{translate('no_data_to_show')}}</p>
                </div>
            @endif
        <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script_2')

@endpush

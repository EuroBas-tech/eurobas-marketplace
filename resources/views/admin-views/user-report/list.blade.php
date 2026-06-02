@extends('layouts.back-end.app')

@section('title', translate('user_reports_list'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Title -->
        <div class="mb-4">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <i class="tio-flag-outlined"></i>
                {{translate('user_reports_list')}}
                <span class="badge badge-soft-dark radius-50">{{ \App\Model\UserReport::count() }}</span>
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="px-3 py-4">
                <div class="row gy-2 align-items-center">
                    <div class="col-sm-8 col-md-6 col-lg-4">
                        <form action="{{ url()->current() }}" method="GET">
                            <div class="input-group input-group-merge input-group-custom">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                    placeholder="{{translate('search_by_reason_or_message')}}"
                                    aria-label="Search" value="{{ $search }}">
                                <button type="submit" class="btn btn--primary">{{translate('search')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
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
                        <th>{{translate('reported_by')}}</th>
                        <th>{{translate('reported_user')}}</th>
                        <th>{{translate('type')}}</th>
                        <th>{{translate('reason')}}</th>
                        <th>{{translate('date')}}</th>
                        <th class="text-center">{{translate('status')}}</th>
                        <th class="text-center">{{translate('action')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach($reports as $key=>$report)
                            <tr>
                                <td>{{$reports->firstItem()+$key}}</td>
                                <td>{{$report->reporter->name ?? '/' }}</td>
                                <td>{{$report->reported->name ?? '/' }}</td>
                                <td><span class="badge badge-soft-secondary text-capitalize">{{ $report->type }}</span></td>
                                <td>{{ \Illuminate\Support\Str::limit($report->reason ?: $report->message, 40, '...') ?: '/' }}</td>
                                <td>
                                    <div>{{$report->created_at->format('d-m-Y')}}</div>
                                    <div>{{$report->created_at->diffForHumans()}}</div>
                                </td>
                                <td class="text-center">
                                    @if($report->status == 'pending')
                                        <span class="badge badge-info">{{ translate('pending') }}</span>
                                    @elseif($report->status == 'reviewed')
                                        <span class="badge badge-success">{{ translate('reviewed') }}</span>
                                    @else
                                        <span class="badge badge-secondary">{{ translate('dismissed') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a title="{{translate('view')}}"
                                           class="btn btn-outline-info btn-sm square-btn"
                                           href="{{route('admin.user-reports.view',[$report->id])}}">
                                            <i class="tio-invisible"></i>
                                        </a>
                                        <a title="{{translate('delete')}}"
                                           class="btn btn-outline-danger btn-sm delete square-btn" href="javascript:"
                                           onclick="form_alert('user-report-{{$report->id}}','{{translate('want_to_delete_this_report').'?'}}')">
                                            <i class="tio-delete"></i>
                                        </a>
                                    </div>
                                    <form action="{{route('admin.user-reports.delete')}}" method="POST" id="user-report-{{$report->id}}">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="id" value="{{$report->id}}">
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
                    {!! $reports->links() !!}
                </div>
            </div>

            @if(count($reports)==0)
                <div class="text-center p-4">
                    <img class="mb-3 w-160" src="{{asset('assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description">
                    <p class="mb-0">{{translate('no_data_to_show')}}</p>
                </div>
            @endif
        </div>
        <!-- End Card -->
    </div>
@endsection

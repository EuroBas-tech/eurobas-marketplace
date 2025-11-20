@extends('layouts.back-end.app')

@section('title', translate('report_details'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Title -->
        <div class="mb-4">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/assets/back-end/img/report.png')}}" alt="">
                {{translate('report_details')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Card -->
        <div class="card p-5">
            <div class="row">
                <div class="col-md-9">
                    <div class="d-flex align-items-center gap-2 mb-3" >
                        <h2 class="" >{{translate('ad_reported_by')}} : </h2>
                        <h4 class="" >
                            <a href="{{ route('show-profile', [$report->ad->user->id, $report->ad->user->name]) }}?tap=ads">
                                {{$report->user->name}}
                            </a>
                        </h4>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-3" >
                        <h2 class="" >{{translate('reported_ad')}} : </h4>
                        <h4 class="fw-lighter" >
                            <a href="{{route('ads-show', $report->ad->slug)}}">{{$report->ad->title}}</a>
                        </h4>
                    </div>
                    <div class="d-flex flex-column gap-2 mb-3" >
                        <h2 class="" >{{translate('report_message')}} : </h2>
                        <h4 class="fw-lighter p-2 bg-secondary text-white rounded" style="width: min-content;" >{{$report->message}}</h4>
                    </div>
                </div>
                <div class="col-md-3 text-end">
                    <img class="rounded img-fit" width="200px" height="200px" src="{{cloudfront('ad/thumbnail/'.$report->ad->thumbnail)}}" alt="ad_thumbnail">
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 mt-4" >
                @if($report->status == 0)
                    <a href="{{route('admin.report.confirm', $report->id)}}" class="btn btn-outline-primary" >
                        <i class="tio-checkmark-circle"></i>
                        {{translate('confirm')}}
                    </a>
                @else
                    <a href="#" class="btn btn-success report-confirmed" disabled >
                        <i class="tio-done"></i>
                        {{translate('confirmed')}}
                    </a>
                @endif
                <a href="javascript:" class="btn btn-outline-danger" title="{{translate('delete')}}"
                    onclick="form_alert('report-{{$report['id']}}','{{translate('want_to_delete_this_report').'?'}}')">
                    <i class="tio-delete"></i>
                    {{translate('delete')}}
                </a>
                <form action="{{route('admin.report.delete')}}" method="POST" id="report-{{$report['id']}}">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="id" value="{{$report['id']}}" >
                </form>
            </div>
        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script_2')
    <script>
        document.querySelector('.report-confirmed').addEventListener('click', function() {
            toastr.info("{{translate('report_already_confirmed')}}");
        });
    </script>
@endpush

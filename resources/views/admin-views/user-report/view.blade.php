@extends('layouts.back-end.app')

@section('title', translate('user_report_details'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="mb-4">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <i class="tio-flag-outlined"></i>
                {{translate('user_report_details')}} #{{ $report->id }}
            </h2>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">{{ translate('report_information') }}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width:30%">{{ translate('reported_by') }}</th>
                                <td>{{ $report->reporter->name ?? '/' }} ({{ translate('id') }}: {{ $report->reporter_id }})</td>
                            </tr>
                            <tr>
                                <th>{{ translate('reported_user') }}</th>
                                <td>{{ $report->reported->name ?? '/' }} ({{ translate('id') }}: {{ $report->reported_id }})</td>
                            </tr>
                            <tr>
                                <th>{{ translate('type') }}</th>
                                <td class="text-capitalize">{{ $report->type }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('reason') }}</th>
                                <td>{{ $report->reason ?: '/' }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('message') }}</th>
                                <td>{{ $report->message ?: '/' }}</td>
                            </tr>
                            @if($report->chatting)
                                <tr>
                                    <th>{{ translate('reported_message') }}</th>
                                    <td>{!! \Illuminate\Support\Str::limit(strip_tags($report->chatting->message), 200) !!}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>{{ translate('date') }}</th>
                                <td>{{ $report->created_at->format('d-m-Y h:i A') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">{{ translate('update_status') }}</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            {{ translate('current_status') }}:
                            @if($report->status == 'pending')
                                <span class="badge badge-info">{{ translate('pending') }}</span>
                            @elseif($report->status == 'reviewed')
                                <span class="badge badge-success">{{ translate('reviewed') }}</span>
                            @else
                                <span class="badge badge-secondary">{{ translate('dismissed') }}</span>
                            @endif
                        </p>
                        <form action="{{ route('admin.user-reports.status') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $report->id }}">
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>{{ translate('pending') }}</option>
                                    <option value="reviewed" {{ $report->status == 'reviewed' ? 'selected' : '' }}>{{ translate('reviewed') }}</option>
                                    <option value="dismissed" {{ $report->status == 'dismissed' ? 'selected' : '' }}>{{ translate('dismissed') }}</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn--primary">{{ translate('update') }}</button>
                        </form>
                    </div>
                </div>
                <a href="{{ route('admin.user-reports.list') }}" class="btn btn-outline--primary w-100">
                    <i class="tio-back-ui"></i> {{ translate('back_to_list') }}
                </a>
            </div>
        </div>
    </div>
@endsection

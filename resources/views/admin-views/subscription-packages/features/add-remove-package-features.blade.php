@extends('layouts.back-end.app')
@section('title', translate('package_feature_settings') . ' - Eurobas.com')

@push('css_or_js')
    <link href="{{asset('assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .currency-absolute-span {
            top: 50%;
            transform: translateY(-50%);
            left: 4px;
        }
        .custom-switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
        }
        .custom-switch input {
            display: none;
        }
        .custom-switch-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        .custom-switch-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        .custom-switch input:checked + .custom-switch-slider {
            background-color: #007bff;
        }
        .custom-switch input:checked + .custom-switch-slider:before {
            transform: translateX(22px);
        }
    </style>
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" src="{{asset('/assets/back-end/img/brand.png')}}" alt="">
            {{translate($package->name)}} {{translate('features')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card px-3 py-2">
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form action="{{route('admin.subscription.packages.store-remove-features')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="package_id" value="{{$package->id}}">

                        <div class="row flex-column gap-2">
                            @foreach($features as $feature)

                            @php($is_feature_exists = $package->features->contains('id', $feature->id))

                                <div class="d-flex align-items-center gap-2">
                                    <label role="button" class="custom-switch mb-2" for="feature_{{$loop->index}}">
                                        <input
                                            type="checkbox"
                                            id="feature_{{$loop->index}}"
                                            name="features[]"
                                            value="{{ $feature->id }}"
                                            {{ $is_feature_exists ? 'checked' : '' }}>
                                        <span class="custom-switch-slider"></span>
                                    </label>
                                    <label role="button" for="feature_{{$loop->index}}" class="mb-0">
                                        <h3>{{ translate($feature->name) }}</h3>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex gap-3 justify-content-end">
                            <button type="submit" class="btn btn--primary px-4">{{ translate('save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')



@endpush

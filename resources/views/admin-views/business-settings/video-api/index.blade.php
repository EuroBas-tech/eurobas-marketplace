@extends('layouts.back-end.app')

@section('title', translate('payment_Method'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/3rd-party.png')}}" alt="">
                {{translate('3rd_party')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inlile Menu -->
        @include('admin-views.business-settings.third-party-inline-menu')
        <!-- End Inlile Menu -->

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{route('admin.business-settings.video-api.update')}}"
                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" method="post">
                    @csrf

                    <h5 class="mb-4 text-uppercase d-flex text-capitalize">{{translate('mux_api_credentials')}}</h5>

                    <div class="row">
                        <div class="col-xl-4 col-sm-6 mb-4">
                            <input class="form-control" placeholder="{{translate('mux_api_token')}}" 
                            value="{{ $mux_api_token }}" type="text" name="mux_api_token" id="mux_api_token">
                        </div>
                        
                        <div class="col-xl-4 col-sm-6 mb-4">
                            <input class="form-control" placeholder="{{translate('mux_secret_key')}}" 
                            value="{{ $mux_secret_key }}" type="text" name="mux_secret_key" id="mux_secret_key">
                        </div>

                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn--primary px-5 text-uppercase">{{translate('save')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    
@endpush

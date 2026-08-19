@extends('theme-views.layouts.app')

@section('title', translate('add_new_ad').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@push('css_or_js')
    <meta property="og:image" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">
    <meta property="twitter:card" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">
    <style>
        .card-custom-shadow { box-shadow: 1px 1px 4px #00000024, -1px 1px 4px #00000024; }
        .select2-container .select2-selection--single .select2-selection__rendered { overflow: visible !important; }
        select, input[type="text"], input[type="number"] { height: 39px !important; }
        .price-text { font-size: 35px; }
        .fixed-description-height { min-height: 3em; line-height: 1.5em; overflow: hidden; }
    </style>
@endpush

@section('content')
    <main class="main-content d-flex flex-column gap-3 py-3 mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card h-lg-100 card-custom-shadow">
                        <div class="card-body p-4 pb-4">
                            <h1 class="pb-3 fs-30">{{translate('post_an_add')}}</h1>
                            <div class="d-flex align-items-center gap-2">
                                @if($data && $data['category_name'])
                                    <h5>{{translate('selected_category')}} : </h5>
                                    <h6 class="mt-1 fs-14">
                                        <span class="bg-primary py-2 px-2 rounded text-light">
                                            <i class="bi bi-tags-fill"></i>
                                            <span id="dynamic-cat-name">{{$data['category_name']}}</span>
                                        </span>
                                    </h6>
                                @endif
                            </div>
                            <div class="mt-4">
                                <form action="" method="POST" id="ads-store-form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">

                                        @include('theme-views.ad.add-pages.partials.identification-information')

                                        @include('theme-views.ad.add-pages.partials.media-data')

                                        @include('theme-views.ad.add-pages.partials.price-data')

                                        @include('theme-views.ad.add-pages.partials.contact-and-location-data')

                                        @include('theme-views.sponsor.partials._sponsor-packages-blade-code')

                                        <div class="col-12">
                                            <div class="d-flex justify-content-end gap-3">
                                                <button id="add-button" type="button" class="btn btn-primary">
                                                    {{translate('Add')}}
                                                </button>
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
    </main>
@endsection

@push('script')
    @include('theme-views.sponsor.partials._global-adding-js-code')
    @include('theme-views.sponsor.partials._sponsor-packages-js-code')
    @include('theme-views.sponsor.partials._video-uploading-api-js-code')
    @include('theme-views.sponsor.partials._payment-methods-js-code')
    @include('theme-views.sponsor.partials._google-map-api-adding-ad-js-code')
@endpush

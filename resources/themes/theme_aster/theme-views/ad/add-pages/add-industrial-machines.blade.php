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
        .card-custom-shadow {
            box-shadow: 1px 1px 4px #00000024, -1px 1px 4px #00000024;
        }
        .select2-container .select2-selection--single .select2-selection__rendered {
            overflow: visible !important;
        }
        select ,input[type="text"], input[type="number"]{
            height: 39px !important;
        }
        .price-text {
            font-size: 35px;
        }

        .fixed-description-height {
            min-height: 3em; /* adjust this based on your font size */
            line-height: 1.5em;
            overflow: hidden;
        }

        .pricing-card {
            border: 1px solid #d9d9d9;
            box-shadow: 0px 0px 2px #858585;
        }

        .pricing-card.active {
            border: 1px solid #198754;
            transform: scale(1.08);
            transition: .2s;
        }


        .payment-card {
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        position: relative;
        overflow: hidden;
        background: #ffffff;
        transform: translateY(0);
        border: 1px solid #d9d9d9;
        box-shadow: 0px 0px 2px #858585;
    }

    .payment-card:hover {
        transform: translateY(-5px);
        border-color: #007bff;
    }

    .payment-card.selected {
        border-color: var(--bs-success);
        transform: translateY(-8px) scale(1.05);
    }

    .payment-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s;
    }

    .payment-card:hover::before {
        left: 100%;
    }

    .payment-card .card-body {
        position: relative;
        z-index: 2;
        padding: 1.5rem;
    }

    .payment-card img {
        transition: transform 0.3s ease;
        filter: grayscale(30%);
    }

    .payment-card:hover img,
    .payment-card.selected img {
        transform: scale(1.1);
        filter: grayscale(0%);
    }

    /* Checkmark animation */
    .payment-card .checkmark {
        position: absolute;
        top: 6px;
        right: 6px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transform: scale(0);
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        font-size: 18px;
    }

    .payment-card.selected .checkmark {
        opacity: 1;
        transform: scale(1);
    }

    /* Ripple effect */
    .payment-card .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(var(--bs-success-rgb), 0.3);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .payment-card.selected {
            transform: translateY(-3px) scale(1.02);
        }

        .col-auto {
            margin-bottom: 1rem;
        }
    }

    </style>

@endpush

@section('content')
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Sidebar-->
                <div class="col-lg-10">
                    <div class="card h-lg-100 card-custom-shadow">
                        <div class="card-body p-4 pb-4">
                            <h1 class="pb-3 fs-30" >{{translate('post_an_add')}}</h1>
                            <div class="d-flex align-items-center gap-2">
                                @if($data && $data['category_name'])
                                    <h5>{{translate('selected_category')}} : </h5>
                                    <h6 class="mt-1 fs-14">
                                        <span class="bg-primary py-2 px-2 rounded text-light">
                                            <i class="bi bi-tags-fill"></i>
                                            <span id="dynamic-cat-name" >{{$data['category_name']}}</span>
                                        </span>
                                    </h6>
                                @endif
                            </div>

                            <div class="mt-4">
                                <form  action="" method="POST" id="ads-store-form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">

                                        @include('theme-views.ad.add-pages.partials.identification-information')

                                        @include('theme-views.ad.add-pages.partials.industrial-machines-data')

                                        @include('theme-views.ad.add-pages.partials.media-data')

                                        @include('theme-views.ad.add-pages.partials.price-data')

                                        @include('theme-views.ad.add-pages.partials.dimensions-and-sizes')

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
    <!-- End Main Content -->
@endsection

@push('script')

    @include('theme-views.sponsor.partials._global-adding-js-code')

    @include('theme-views.sponsor.partials._sponsor-packages-js-code')

    @include('theme-views.sponsor.partials._video-uploading-api-js-code')

    @include('theme-views.sponsor.partials._payment-methods-js-code')

    @include('theme-views.sponsor.partials._google-map-api-adding-ad-js-code')

@endpush





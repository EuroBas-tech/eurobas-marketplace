@extends('theme-views.layouts.app')

@section('title', $ad['name'].' | '.$web_config['name']->value.' '.translate('ecommerce'))


@push('css_or_js')
    <meta name="description" content="{{$ad->slug}}">
    <meta name="keywords" content="@foreach(explode(' ',$ad['name']) as $keyword) {{$keyword.' , '}} @endforeach">
    <meta name="author" content="{{$web_config['name']->value}}">
    <!-- Viewport-->

    @if($ad['meta_image'])
        <meta property="og:image" content="{{env_asset("storage/ad/meta")}}/{{$ad->meta_image}}"/>
        <meta property="twitter:card"
              content="{{env_asset("storage/ad/meta")}}/{{$ad->meta_image}}"/>
    @else
        <meta property="og:image" content="{{env_asset("storage/ad/thumbnail")}}/{{$ad->thumbnail}}"/>
        <meta property="twitter:card"
              content="{{env_asset("storage/ad/thumbnail/")}}/{{$ad->thumbnail}}"/>
    @endif

    @if($ad['meta_title'])
        <meta property="og:title" content="{{$ad->meta_title}}"/>
        <meta property="twitter:title" content="{{$ad->meta_title}}"/>
    @else
        <meta property="og:title" content="{{$ad->name}}"/>
        <meta property="twitter:title" content="{{$ad->name}}"/>
    @endif
    <meta property="og:url" content="{{route('ads-show',[$ad->slug])}}">

    {{--
        @if($ad['meta_description'])
            <meta property="twitter:description" content="{!! $ad['meta_description'] !!}">
            <meta property="og:description" content="{!! $ad['meta_description'] !!}">
        @else
    --}}
        <meta property="og:description"
              content="@foreach(explode(' ',$ad['name']) as $keyword) {{$keyword.' , '}} @endforeach">
        <meta property="twitter:description"
              content="@foreach(explode(' ',$ad['name']) as $keyword) {{$keyword.' , '}} @endforeach">

    <meta property="twitter:url" content="{{route('ads-show',[$ad->slug])}}">
    <link rel="stylesheet" href="{{ theme_asset('assets/css/lightbox.min.css') }}">

    <style>
        .modal-backdrop {
            display: none !important;
        }

        .custom-bg-color-cool-blue {
            background: #4c6a8f;
        }

        #location_map_canvas {
            position: relative;
        }

        .shadow-none {
            box-shadow: none !important;
        }

        .responsive-ad-image {
            width: 100%;
        }

        .seller-card {
            background: #0f407ddb;
            font-weight: 400;
            border-radius: 4px;
        }

        .note-span {
            line-height: 1;
            font-size: 14px;
        }

        /* Base styles for aspect ratio container */
        .aspect-0 {
            aspect-ratio: 16/9 !important;
            overflow: hidden;
        }

        .pd-img-wrap .position-relative[style*="aspect-ratio"] {
            padding-bottom: 0 !important;
            height: 100% !important;
            overflow: hidden;
        }

        .pd-img-wrap iframe {
            height: 100% !important;
            width: 100% !important;
            object-fit: cover !important; /* This will crop the video to fill the container */
        }

        /* Add these styles to your existing CSS */
        .similar-ads-swiper .swiper-wrapper {
        align-items: stretch;
        }

        .similar-ads-swiper .swiper-slide {
        height: auto;
        display: flex;
        }

        .similar-ads-swiper .swiper-slide > div {
        width: 100%;
        display: flex;
        flex-direction: column;
        }

        .product-card-shadow .card {
        height: 100%;
        display: flex;
        flex-direction: column;
        }

        .product-card-shadow .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        }

        .product-card-shadow .card-content {
        flex: 1;
        }

        .custom-img-object {
            object-fit: fill !important;
        }

        .profile-image {
            width: 50px !important;
            height: 50px !important;
        }
        
        /* More than 1200px (≥1200px) */
        @media (min-width: 1200px) {
            .responsive-ad-image {
                /* height: 415px !important; */
            }
            .side-col {
              max-width: 325px;
            }
        }
        
        @media (min-width: 1300px) {
            .side-bar-min-width {
                min-width: 345px !important;
            }
        }

        @media (max-width: 1300px) {
            .side-bar-min-width {
                min-width: 320px !important;
            }
        }

        @media (min-width: 992px) {
            .col-lg-custom-8-5 {
                flex: 0 0 calc((100% / 12) * 8.5);
                max-width: calc((100% / 12) * 8.5);
            }
            .col-lg-custom-3-5 {
                flex: 0 0 calc((100% / 12) * 3.5);
                max-width: calc((100% / 12) * 3.5);
            }
        }

        /* just on mobile */
        @media (max-width: 767.98px) {
            .gmnoprint.gm-style-mtc-bbw {
                display: none;
            }
        }

        @media (max-width: 575.98px) {
            .width-100-sm {
                width: 100% !important;
            }
            .custom-img-object {
                object-fit: cover !important;
            }
        }
        
        @media (max-width: 576px) {
            .mobile-responsive-style {
                height: 330px;
                width: 100%;
            }
        }

    </style>

@endpush

@section('content')

    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 pt-3 mb-sm-5">
        <div class="container px-0 px-sm-3">
            <div class="row gx-3 gy-4">
                <div class="col-lg-8 col-xl-8 flex-grow-1 px-sm-3 px-0">
                    <div class="card h-100 mb-3 px-sm-0 px-3">
                        <div class="card-body px-sm-3 px-0">
                            <div class="quickview-content">
                                <div class="mb-4" >
                                    <div class="d-flex align-items-start justify-content-between" >
                                        <div>
                                            <h2 class="product_title mb-3">{{$ad->title}}</h2>
                                            <div class="d-flex align-items-start mt-4 mt-sm-0 align-items-sm-center gap-3 flex-column flex-sm-row" >
                                                <h6 class="">
                                                    <span class="bg-primary py-2 px-2 rounded text-light">
                                                        <i class="bi bi-tags-fill"></i>
                                                        {{$ad->category->name}}
                                                    </span>
                                                </h6>
                                                <div class="d-flex align-items-center gap-3" >
                                                    <div class="d-flex align-items-center gap-1 text-primary" >
                                                        <span><i class="bi bi-eye fs-16" ></i></span>
                                                        <span class="fs-16" >{{$ad_views_number}}</span>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-1 text-primary" >
                                                        <span><i class="bi bi-suit-heart fs-16"></i></span>
                                                        <span id="ad-wishlist-count" class="fs-16" >{{$ad->wish_list->count()}}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center gap-1 text-primary" >
                                                    <span><i class="bi bi-calendar-event fs-16"></i></i></span>

                                                    @php 
                                                        $locale = SOLVE_LOCALE_CODES[app()->getLocale()] ?? app()->getLocale();
                                                    @endphp

                                                    <span class="fs-16">
                                                        {{ $ad->created_at->locale($locale)->translatedFormat('d F Y') }}
                                                        ({{ $ad->created_at->locale($locale)->diffForHumans() }})
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product__actions d-flex flex-column gap-1">
                                            <a onclick="addWishlist('{{$ad['id']}}','{{route('store-wishlist')}}')"
                                                id="wishlist-{{$ad['id']}}"
                                                class="btn-wishlist add_to_wishlist d-flex align-items-center justify-content-center cursor-pointer"
                                                title="{{translate('add_to_wishlist')}}">
                                                <i class="bi bi-heart fs-10"></i>
                                            </a>
                                            <div class="product-share-icons">
                                                <a class="d-flex align-items-center justify-content-center cursor-pointer" href="javascript:" title="Share">
                                                    <i class="bi bi-share-fill fs-10"></i>
                                                </a>
                                                <ul style="z-index: 11111;" >
                                                    <li style="margin-block-end: 0;" >
                                                        <a href="javascript:"
                                                            onclick="shareOnFacebook('{{route('ads-show',$ad->slug)}}', 'facebook.com/sharer/sharer.php?u='); return false;">
                                                            <i class="bi bi-facebook"></i>
                                                        </a>
                                                    </li>
                                                    <li style="margin-block-end: 0;" >
                                                        <a href="javascript:"
                                                            onclick="shareOnFacebook('{{route('ads-show',$ad->slug)}}', 'twitter.com/intent/tweet?text='); return false;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                                                                <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z"/>
                                                            </svg>
                                                        </a>
                                                    </li>
                                                    <li style="margin-block-end: 0;" >
                                                        <a href="javascript:"
                                                            onclick="shareOnFacebook('{{route('ads-show',$ad->slug)}}', 'linkedin.com/shareArticle?mini=true&url='); return false;">
                                                            <i class="bi bi-linkedin"></i>
                                                        </a>
                                                    </li>
                                                    <li style="margin-block-end: 0;" >
                                                        <a href="javascript:"
                                                            onclick="shareOnFacebook('{{route('ads-show',$ad->slug)}}', 'api.whatsapp.com/send?text='); return false;">
                                                            <i class="bi bi-whatsapp"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            @if(auth('customer')->check())
                                                <a
                                                    data-bs-toggle="modal" data-bs-target="#reportModal"
                                                    class="btn-wishlist add_to_wishlist d-flex align-items-center justify-content-center cursor-pointer"
                                                    title="{{translate('report_this_ad')}}">
                                                    <i class="bi bi-flag fs-10"></i>
                                                </a>
                                                @include('theme-views.layouts.partials.modal._report', ['id' => $ad->id])
                                            @else
                                                <a
                                                    data-bs-toggle="modal" data-bs-target="#loginModal"
                                                    class="btn-wishlist add_to_wishlist d-flex align-items-center justify-content-center cursor-pointer"
                                                    title="{{translate('report_this_ad')}}">
                                                    <i class="bi bi-flag fs-10"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row gy-4 d-flex align-items-stretch justify-content-center">
                                    <div class="col-sm-11 col-12 px-sm-2 px-0">
                                        <!-- Product Details Image Wrap -->
                                        <div class="pd-img-wrap position-relative h-100">
                                            <div class="swiper-container mobile-responsive-style quickviewSlider2 border rounded aspect-0" style="--bs-border-color: #d6d6d6">
                                                @if($ad->images!=null && json_decode($ad->images)>0)
                                                    <div class="swiper-wrapper">
                                                        @if($ad_promotional_video)
                                                            <div class="swiper-slide video-slide position-relative w-100 h-100">
                                                                <div class="position-relative" style="width:100%;height:100%;aspect-ratio:16/9.45;">
                                                                    <mux-player
                                                                        stream-type="on-demand"
                                                                        playback-id="{{$ad_promotional_video->playback_id}}"
                                                                        metadata-video-title="Uploaded Video"
                                                                        accent-color="#0F407D"
                                                                        style="width: 100%; height: 100%;"
                                                                    ></mux-player>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="swiper-slide image-slide position-relative w-100">
                                                            <div class="easyzoom easyzoom--overlay h-100 width-100-sm">
                                                                <a class="w-100" href="{{env_asset("storage/ad/thumbnail/".$ad['thumbnail'])}}">
                                                                    <img src="{{env_asset('storage/ad/thumbnail/'.$ad->thumbnail)}}" class="dark-support responsive-ad-image custom-img-object" alt="">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        @foreach (json_decode($ad->images) as $key => $photo)
                                                            <div class="swiper-slide image-slide position-relative w-100">
                                                                <div class="easyzoom easyzoom--overlay h-100 width-100-sm">
                                                                    <a class="w-100" href="{{env_asset("storage/ad/".$photo)}}">
                                                                        <img src="{{env_asset('storage/ad/'.$photo)}}" class="dark-support responsive-ad-image custom-img-object" alt="">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="mt-2 user-select-none">
                                                <div class="quickviewSliderThumb2 swiper-container position-relative ">
                                                    @if($ad->images!=null && json_decode($ad->images)>0)
                                                        <div class="swiper-wrapper auto-item-width justify-content-center" style="--width: 4rem; --bs-border-color: #d6d6d6">
                                                            @if($ad_promotional_video)
                                                                <div class="swiper-slide position-relative aspect-1">
                                                                    <img src="https://image.mux.com/{{$ad_promotional_video['playback_id']}}/thumbnail.jpg" class="dark-support rounded" alt="">
                                                                    <span class="position-absolute" style="top:50%; right: 50%; transform: translate(50%,-50%)">
                                                                        <i class="bi bi-play-circle text-white fs-28"></i>
                                                                    </span>
                                                                </div>
                                                            @endif
                                                            <div class="swiper-slide position-relative aspect-1">
                                                                <img src="{{env_asset("storage/ad/thumbnail/".$ad['thumbnail'])}}" class="dark-support rounded" alt="">
                                                            </div>
                                                            @foreach (json_decode($ad->images) as $key => $photo)
                                                                <div class="swiper-slide position-relative aspect-1">
                                                                    <img src="{{env_asset("storage/ad/".$photo)}}" class="dark-support rounded" alt="">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    <div class="swiper-button-next swiper-quickview-button-next" style="--size: 1.5rem"></div>
                                                    <div class="swiper-button-prev swiper-quickview-button-prev" style="--size: 1.5rem"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Product Details Image Wrap -->
                                    </div>

                                    <div class="col-12 h-100">
                                        <!-- Product Details Content -->
                                        <div class="product-details-content position-relative">
                                            @if($ad->brand_id || $ad->custom_brand || $ad->model_id || $ad->color)                                            
                                                <div class="d-flex align-items-center justify-content-between mb-2 mt-2" >
                                                    <div class="d-flex flex-column gap-1" >
                                                        @if($ad->brand_id || $ad->custom_brand)
                                                            <div class="d-flex gap-2 flex-wrap align-items-center">
                                                                <h5 class="fw-bold">{{translate('brand')}} :</h5>
                                                                <div class="d-flex align-items-center" >
                                                                    <span class="mx-1" >{{$ad->brand_id ? $ad->brand->name : $ad->custom_brand ?? '/'}}</span>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if($ad->model_id)
                                                            <div class="d-flex gap-2 flex-wrap align-items-center">
                                                                <h5 class="fw-bold">{{translate('model')}} :</h5>
                                                                <div class="d-flex align-items-center" >
                                                                    <span class="mx-1" >{{$ad->model->name ?? '/'}}</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        
                                                        @if($ad->color)
                                                            <div class="d-flex gap-2 flex-wrap align-items-center">
                                                                <h5 class="fw-bold">{{translate('ad_color')}} :</h5>
                                                                <div class="d-flex align-items-center" >
                                                                    <span style="width: 15px; height: 15px;border-radius: 2px;background: {{$ad->color}};" ></span>
                                                                    <span class="mx-1" >({{translate($ad->color)}})</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @if($ad->brand_id)
                                                        <div>
                                                            <img class="rounded border" 
                                                                width="70px" 
                                                                onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                                                src='{{asset("storage/brand")}}/{{ $ad->brand->image ?? "" }}'
                                                                alt="brand-image">
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                            
                                            <div class="product__price d-flex flex-wrap align-items-center gap-2 my-3">
                                                <ins
                                                    class="product__new-price text-primary fs-30 currency-font">
                                                    @if($ad->price_type == 'fixed_price')
                                                        {{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}
                                                    @elseif($ad->price_type == 'free')
                                                        <span class="fs-18 fw-medium" >{{ translate('free') }}</span>
                                                    @elseif($ad->price_type == 'asking_price')
                                                            <span class="fs-30 fw-medium" >{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</span>
                                                    @elseif($ad->price_type == 'auction')
                                                        <span class="fs-30 fw-medium" >
                                                            {{translate('auction')}}
                                                        </span>
                                                    @endif
                                                </ins>
                                            </div>
                                            

                                            <div class="row" >
                                                @if($ad->ad_status)
                                                    <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                        <div class="card shadow-none">
                                                            <div class="d-flex align-items-center gap-2" >
                                                                <div>
                                                                    <span>
                                                                        <img width="25px" src="{{ theme_asset('assets/img/svg/status.png') }}" alt="">
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <h5>{{ translate('status') }}</h5>
                                                                    <span>{{ translate($ad->ad_status) }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($ad->year)
                                                    <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                        <div class="card shadow-none">
                                                            <div class="d-flex align-items-center gap-2" >
                                                                <div>
                                                                    <span>
                                                                        <img width="25px" src="{{ theme_asset('assets/img/svg/year.svg') }}" alt="">
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <h5>{{ translate('year_of_release') }}</h5>
                                                                    <span>{{ $ad->year }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($ad->category->category_type == 'vehicles')
                                                
                                                    @if($ad->body_type)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/body-types.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('body_type') }}</h5>
                                                                        <span>{{ translate($ad->body_type) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($ad->mileage)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/mileage-counter.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('mileage') }}</h5>
                                                                        <span>{{ $ad->mileage }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($ad->engine_size)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/engine-size.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('engine_size') }}</h5>
                                                                        <span>{{ $ad->engine_size }}L</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($ad->fuel_type)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/fuel-type.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('fuel_type') }}</h5>
                                                                        <span>{{ translate($ad->fuel_type) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($ad->engine_cylinders)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/cylinder.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('engine_cylinders') }}</h5>
                                                                        <span>{{ $ad->engine_cylinders }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($ad->engine_power)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/engine-power.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('engine_power') }}</h5>
                                                                        <span>{{ $ad->engine_power }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($ad->transmission_type)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/transmission.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('transmission_type') }}</h5>
                                                                        <span>{{ translate($ad->transmission_type) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($ad->previous_scan_date)
                                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/date.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('previous_scan_date') }}</h5>
                                                                        <span>{{ $ad->previous_scan_date }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($ad->acceleration_0_100)
                                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/acceleration-0-100.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('acceleration_0_100') }}</h5>
                                                                        <span>{{ $ad->acceleration_0_100 }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($ad->bicycle_type)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/bicycle-type.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('bicycle_type') }}</h5>
                                                                        <span>{{ translate($ad->bicycle_type) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($ad->bicycle_size)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/bicycle-size.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('bicycle_size') }}</h5>
                                                                        <span>{{ $ad->bicycle_size }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($ad->beds_number)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/bed.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('number_of_beds') }}</h5>
                                                                        <span>{{ $ad->beds_number }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                        
                                                @endif

                                                @if($ad->category->category_type == 'real estate')
                                                    @if($ad->listing_type)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/listing.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('listing_type') }}</h5>
                                                                        <span>{{ translate($ad->listing_type) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($ad->property_type)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/property.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('property_type') }}</h5>
                                                                        <span>{{ translate($ad->property_type) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($ad->property_size)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/size.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('property_size') }}</h5>
                                                                        <span>{{ $ad->property_size }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($ad->floor)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/floor.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('floor') }}</h5>
                                                                        <span>{{ $ad->floor }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($ad->rooms_number)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/room.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('number_of_rooms') }}</h5>
                                                                        <span>{{ $ad->rooms_number }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                                @if($ad->category->category_type == 'furniture')
                                                
                                                    @if($ad->furniture_type)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/furniture-type.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('furniture_type') }}</h5>
                                                                        <span>{{ translate($ad->furniture_type) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($ad->material)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none min-width-max-content">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/material.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('furniture_material') }}</h5>
                                                                        <span>{{ translate($ad->material) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                @endif

                                                @if($ad->category->category_type == 'industrial machines')
                                                    @if($ad->machine_type)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/machine-type.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('machine_type') }}</h5>
                                                                        <span>{{ translate($ad->machine_type) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($ad->manufacturer)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none min-width-max-content">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/manufacturer.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('manufacturer') }}</h5>
                                                                        <span>{{ $ad->manufacturer }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($ad->power_capacity)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none min-width-max-content">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/power-capacity.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('power_capacity') }}</h5>
                                                                        <span>{{ $ad->power_capacity }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($ad->power_source)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none min-width-max-content">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/power-capacity.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('power_source') }}</h5>
                                                                        <span>{{ translate($ad->power_source) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                                @if($ad->category->category_type == 'electronics')
                                                    @if($ad->electronic_type)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/electronic-type.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('type') }}</h5>
                                                                        <span>{{ translate($ad->electronic_type) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                                
                                                @if($ad->category->category_type == 'home appliances')
                                                    @if($ad->home_appliance_type)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/home-appliance-type.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('type') }}</h5>
                                                                        <span>{{ translate($ad->home_appliance_type) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                                
                                                @if($ad->category->category_type == 'home garden')
                                                    @if($ad->material)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/material.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('material') }}</h5>
                                                                        <span>{{ translate($ad->material) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($ad->usage_type)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/usage.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('usage') }}</h5>
                                                                        <span>{{ translate($ad->usage_type) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                                @if($ad->category->category_type == 'shipbuilding marine')
                                                    @if($ad->shipbuilding_type)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/yacht-type.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('type') }}</h5>
                                                                        <span>{{ translate($ad->shipbuilding_type) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                     @if($ad->fuel_type)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/fuel-type.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('fuel_type') }}</h5>
                                                                        <span>{{ translate($ad->fuel_type) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($ad->maximum_speed)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/maximum-speed.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('maximum_speed') }}</h5>
                                                                        <span>{{ translate($ad->maximum_speed) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($ad->engines_number)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/engines.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('engines') }}</h5>
                                                                        <span>{{ translate($ad->engines_number) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($ad->engines_number)
                                                        <div class="col-lg-3 col-xl-3 col-md-4 col-6 mb-4">
                                                            <div class="card shadow-none">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/cabins.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('cabins') }}</h5>
                                                                        <span>{{ translate($ad->cabins_number) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <!-- End Product Details Content -->
                                    </div>
                                    
                                    <div class="mt-4" >
                                        <h3 class="my-4" >{{translate('description')}}</h3>
                                        <div class="fs-18 text-dark" >
                                            {!! $ad->description !!}
                                        </div>
                                    </div>
                                    
                                    <div class="accordion mt-5" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed bg-light" style="border-bottom: none !important;" 
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <div class="d-flex align-items-center gap-1" >
                                                    <img width="20px" src="{{ theme_asset('assets/img/svg/dimensions.svg') }}" alt="">
                                                    <span class="fw-medium text-dark mx-1" >{{ translate('dimensions_and_sizes') }}</span>
                                                </div>
                                            </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse @if(!$is_dimensions_and_sizes_empty) show @endif" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    @if(!$is_dimensions_and_sizes_empty)
                                                        <div class="row" >
                                                            @if($ad->height)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2" >
                                                                            <div>
                                                                                <span>
                                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/height.svg') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate('height') }}</h5>
                                                                                <span>{{ $ad->height }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        
                                                            @if($ad->width)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2" >
                                                                            <div>
                                                                                <span>
                                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/width.svg') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate('width') }}</h5>
                                                                                <span>{{ $ad->width }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        
                                                            @if($ad->length)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2" >
                                                                            <div>
                                                                                <span>
                                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/height.svg') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate('length') }}</h5>
                                                                                <span>{{ $ad->length }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        
                                                        
                                                            @if($ad->bag_capacity)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2" >
                                                                            <div>
                                                                                <span>
                                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/capacity.png') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate('bag_capacity') }}</h5>
                                                                                <span>{{ $ad->bag_capacity }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        
                                                        
                                                            @if($ad->weight)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2" >
                                                                            <div>
                                                                                <span>
                                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/weight.svg') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate('weight') }}</h5>
                                                                                <span>{{ $ad->weight }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        
                                                            @if($ad->max_weight)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2" >
                                                                            <div>
                                                                                <span>
                                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/weight.svg') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate('max_weight') }}</h5>
                                                                                <span>{{ $ad->max_weight }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            
                                                            @if($ad->seats_number)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2" >
                                                                            <div>
                                                                                <span>
                                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/seats.svg') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate('seats_number') }}</h5>
                                                                                <span>{{ $ad->seats_number }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            
                                                            @if($ad->doors_number)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2" >
                                                                            <div>
                                                                                <span>
                                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/doors.svg') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate('doors_number') }}</h5>
                                                                                <span>{{ $ad->doors_number }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        
                                                        
                                                            
                                                        </div>
                                                    @else
                                                        <div>
                                                            <h5 class="text-muted" >{{ translate('there_is_no_information_to_show_in_this_section') }}</h5>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed bg-light" style="border-bottom: none !important;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                <div class="d-flex align-items-center gap-1" >
                                                    <img width="20px" src="{{ theme_asset('assets/img/svg/environment.svg') }}" alt="">
                                                    <span class="fw-medium text-dark mx-1" >{{ translate('environmental_informations') }}</span>
                                                </div>
                                            </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    @if(!$is_environmental_information_empty)
                                                        <div class="row" >
                                                            @if($ad->co2_emissions)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <div>
                                                                                <span>
                                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/co2.svg') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate('co2_emissions') }}</h5>
                                                                                <span>{{ $ad->co2_emissions }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        
                                                            @if($ad->gas_emission_tax)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <div>
                                                                                <span>
                                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/emissions.svg') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate('gas_emission_tax') }}</h5>
                                                                                <span>{{ $ad->gas_emission_tax }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        
                                                            @if($ad->energy_source)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <div>
                                                                                <span>
                                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/energysource.svg') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate('energy_source') }}</h5>
                                                                                <span>{{ $ad->energy_source }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        
                                                            @if($ad->energy_consumption)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <div>
                                                                                <span>
                                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/energy.svg') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate('energy_consumption') }}</h5>
                                                                                <span>{{ $ad->energy_consumption }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <div>
                                                            <h5 class="text-muted" >{{ translate('there_is_no_information_to_show_in_this_section') }}</h5>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>     

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingFour">
                                            <button class="accordion-button collapsed bg-light" style="border-bottom: none !important;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                <div class="d-flex align-items-center gap-1" >
                                                    <img width="20px" src="{{ theme_asset('assets/img/svg/battery.svg') }}" alt="">
                                                    <span class="fw-medium text-dark mx-1" >{{ translate('battery_informations') }}</span>
                                                </div>
                                            </button>
                                            </h2>
                                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    @if(!$is_battery_information_empty)
                                                        <div class="row" >
                                                            @if($ad->battery_charging_time)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <div>
                                                                                <span>
                                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/batterytime.svg') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate('battery_charging_time') }}</h5>
                                                                                <span>{{ $ad->battery_charging_time }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        
                                                            @if($ad->fast_battery_charging_time)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <div>
                                                                                <span>
                                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/batteryfast.svg') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate('fast_battery_charging_time') }}</h5>
                                                                                <span>{{ $ad->fast_battery_charging_time }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        
                                                            @if($ad->battery_life)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <div>
                                                                                <span>
                                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/batterylife.svg') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate('battery_life') }}</h5>
                                                                                <span>{{ $ad->battery_life }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <div>
                                                            <h5 class="text-muted" >{{ translate('there_is_no_information_to_show_in_this_section') }}</h5>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        @if($ad->category->category_type == 'vehicles' && $ad->category->slug != 'bicycles' 
                                        && $ad->category->slug != 'spare-parts' && $ad->category->slug != 'vehicle-accessories')
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingFive">
                                                <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                    <div class="d-flex align-items-center gap-1" >
                                                        <img width="20px" src="{{ theme_asset('assets/img/svg/options.svg') }}" alt="">
                                                        <span class="fw-medium text-dark mx-1" >{{ translate('ad_options') }}</span>
                                                    </div>
                                                </button>
                                                </h2>
                                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row" >
                                                            @php
                                                                $options = [
                                                                    '360_camera',
                                                                    '4x4',
                                                                    'modified_for_disabled',
                                                                    'abs',
                                                                    'rear_view_camera',
                                                                    'adaptive_lights',
                                                                    'adaptive_cruise_control',
                                                                    'airbags',
                                                                    'air_conditioning',
                                                                    'alarm',
                                                                    'android_auto',
                                                                    'apple_carplay',
                                                                    'autonomous_driving',
                                                                    'bluetooth',
                                                                    'cornering_lights',
                                                                    'onboard_computer',
                                                                    'central_locking',
                                                                    'climate_control',
                                                                    'cruise_control',
                                                                    'roof_rails',
                                                                    'blind_spot_monitor',
                                                                    'electric_tailgate',
                                                                    'electric_mirrors',
                                                                    'electric_seat_adjustment',
                                                                    'electronic_stability_program',
                                                                    'electric_windows',
                                                                    'emergency_brake_assist',
                                                                    'head_up_display',
                                                                    'isofix',
                                                                    'keyless_entry',
                                                                    'lane_departure_warning',
                                                                    'lane_keeping_assist',
                                                                    'led_lights',
                                                                    'leather_seats',
                                                                    'alloy_wheels',
                                                                    'light_sensor',
                                                                    'metallic_paint',
                                                                    'fog_lights',
                                                                    'navigation_system',
                                                                    'sunroof',
                                                                    'panoramic_roof',
                                                                    'parking_assist',
                                                                    'parking_camera',
                                                                    'parking_sensors',
                                                                    'radio',
                                                                    'rain_sensor',
                                                                    'sliding_door',
                                                                    'sport_package',
                                                                    'sport_seats',
                                                                    'voice_control',
                                                                    'immobilizer',
                                                                    'start_stop_system',
                                                                    'seat_massage',
                                                                    'seat_ventilation',
                                                                    'heated_seats',
                                                                    'steering_wheel_heating',
                                                                    'traction_control',
                                                                    'tow_bar',
                                                                    'usb_ports',
                                                                    'traffic_sign_recognition',
                                                                    'fatigue_detection',
                                                                    'heated_mirrors',
                                                                    'front_view_camera',
                                                                    'xenon_lights',
                                                                    'cd_player',
                                                                    'daytime_running_lights',
                                                                    'gps',
                                                                    'multifunction_steering_wheel',
                                                                    'power_steering',
                                                                    'rear_ac_vents',
                                                                    'remote_start',
                                                                    'touchscreen_display',
                                                                    'tpms',
                                                                    'wireless_charging',
                                                                ];

                                                                $ad_options = json_decode($ad->options, true);

                                                            @endphp

                                                            @foreach($options as $option)
                                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                                                    <div class="card shadow-none">
                                                                        <div class="d-flex align-items-center gap-2" >
                                                                            <div>
                                                                                <span>
                                                                                    <img width="20px" src="{{ theme_asset('assets/img/svg/checkbox-'.$ad_options[$option].'.png') }}" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <h5>{{ translate($option) }}</h5>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- map section -->
                                    <div class="col-md-12" >
                                        <div>
                                            <h5 style="font-weight: 600;" ><i class="bi bi-geo-alt"></i>{{$ad->country}}{{$ad->state !== $ad->city ? ', '.$ad->city : ''}}</h5>
                                        </div>
                                        <div id="shippingMapContainer" class="container my-3 p-1">
                                            <input type="hidden" id="adCountry" value="{{ $ad->country }}">
                                            <input type="hidden" id="adCity" value="{{ $ad->city }}">
                                            <input type="hidden" id="userCountry" value="{{ auth('customer')->check() ? auth('customer')->user()->country : '' }}">
                                            <input type="hidden" id="userCity" value="{{ auth('customer')->check() ? auth('customer')->user()->city : '' }}">
                                            <div class="modal-content border-0 shadow-none">
                                                <div class="modal-body">
                                                    <div class="product-quickview">
                                                        <input id="pac-input" class="controls rounded __inline-46" 
                                                            title="{{translate('search_your_location_here')}}" 
                                                            type="text" placeholder="{{translate('search_here')}}"/>
                                                        <div id="location_map_canvas" class="dark-support rounded w-100" style="height: 14rem;"></div>
                                                        <input type="hidden" id="latitude"
                                                            name="latitude" class="form-control d-inline"
                                                            placeholder="{{ translate('Ex') }} : -94.22213" 
                                                            value="0" required readonly>
                                                        <input type="hidden"
                                                            name="longitude" class="form-control"
                                                            placeholder="{{ translate('Ex') }} : 103.344322" id="longitude" 
                                                            value="0" required >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="location-data" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12" >
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="" >
                                <div class="d-flex align-items-start justify-content-between" >
                                    <div class="d-flex align-items-center mb-3 gap-2" >
                                        <div>
                                            <img class="rounded profile-image"  
                                            src="{{ $ad->user->image ? env_asset('storage/profile/images/'.$ad->user->image) : theme_asset('assets/img/avatar/def-image.jpg') }}"
                                            alt="user-image">
                                        </div>
                                        <div>
                                            <h5 class="mb-1">{{$ad->user->name}}</h5>
                                            <p class="fs-12 m-0">{{translate('Joined')}} {{date('M, Y',strtotime($ad->user->created_at))}}</p>
                                            @php 
                                                $locale = SOLVE_LOCALE_CODES[app()->getLocale()] ?? app()->getLocale();
                                            @endphp
                                            <p class="fs-12">({{$ad->user->created_at->locale($locale)->diffForHumans()}})</p>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('show-profile', [$ad->user->id, $ad->user->name]) }}?tap=ads" class="btn btn-primary btn-sm px-2 fs-12" >
                                            <i class="bi bi-person-circle"></i>
                                            {{ translate('profile') }}
                                        </a>
                                    </div>
                                </div>

                                <div>
                                    <a href="{{ route('show-profile', [$ad->user->id, $ad->user->name]) }}?tap=ads" style="text-decoration: underline;">
                                        <h6 class="mb-3" style="font-weight: 500;" >{{ translate('show_all_ads_of_this_user') }}</h6>
                                    </a>
                                    
                                    <p class="p-2 text-light seller-card" >
                                        {{$ad->user->account_type == 'company' ? translate('this_seller_is_a_business_account') : translate('this_seller_is_an_individual_and_does_not_represent_any_private_ad_sales_company')}}.
                                    </p>
                                </div>

                                <div class="mt-4 mb-4 pb-2">
                                    <h4 class="mb-3 fw-normal" >{{ translate('seller_contact_informations') }}</h4>
                                    @php($guest_checkout=\App\CPU\Helpers::get_business_settings('guest_checkout'))
                                        @if($ad->show_email_address == 1)
                                            <button style="background: #0d6efd;font-size: 15px;margin-bottom: 11px;" 
                                                onclick="get_email_address('{{$ad->user->email}}', this)"
                                                class="btn buy-now-btn-hover py-3 px-2 w-100 text-white" >
                                                <i class="bi bi-envelope-fill me-1"></i>
                                                {{translate('Email_address')}}
                                            </button>
                                        @endif

                                        @if($ad->show_phone_number == 1)
                                            @if($ad->whatsapp_availability == 1)
                                                <button style="background: #25D366; font-size: 15px;margin-bottom: 11px;"
                                                    onclick="get_phone_number_and_whatsapp('{{$ad->contact_phone_number}}', this)"
                                                    class="btn buy-now-btn-hover py-3 px-2 w-100 text-white">
                                                    <i class="bi bi-whatsapp me-1"></i>
                                                    {{translate('WhatApp_number')}}
                                                </button>
                                            @else
                                                <button style="background: #25D366; font-size: 15px;margin-bottom: 11px;"
                                                    onclick="get_phone_number('{{$ad->contact_phone_number}}', this)"
                                                    class="btn buy-now-btn-hover py-3 px-2 w-100 text-white">
                                                    <i class="bi bi-telephone me-1"></i>
                                                    {{translate('phone_number')}}
                                                </button>
                                            @endif
                                        @endif

                                    @if (auth('customer')->check())
                                        <button style="font-size: 15px;" class="btn primary-blue-bg-color buy-now-btn-hover mb-2 py-3 px-2 w-100 text-white" 
                                        data-bs-toggle="modal" data-bs-target="#contact_sellerModal">
                                            <i class="bi bi-chat-square-fill"></i> 
                                            {{translate('Chat_with_Seller')}}
                                        </button>
                                    @else
                                        <button style="font-size: 15px;" class="btn primary-blue-bg-color buy-now-btn-hover p-auto py-3 px-2 w-100 text-white" 
                                        data-bs-toggle="modal" data-bs-target="#loginModal">
                                            <i class="bi bi-chat-square-fill"></i> 
                                            {{translate('Chat_with_Seller')}}
                                        </button>
                                    @endif
                                </div>

                                @include('theme-views.layouts.partials.modal._chat-with-seller',['ad'=>$ad])

                                @if($ad->price_type == 'auction')
                                    <div class="mb-2" >
                                        <div>
                                            <input type="hidden" name="id" value="{{$ad->id}}">
                                            <input type="hidden" id="starting_price" value="{{$ad->starting_price}}">
                                            <div class="form-group">
                                                <label class="m-0" for="price">{{translate('add_an_offer')}}</label>
                                                @if($ad->starting_price)
                                                    <div>
                                                        <span class="fz-14" >{{translate('starting_form')}} : {{\App\CPU\BackEndHelper::set_price_currency($ad->starting_price, $ad->currency)}}</span>
                                                    </div>
                                                @endif
                                                <div class="position-relative" >
                                                    <span id="ad-currency" class="position-absolute fw-bold currency-font" 
                                                    style="top:50%;left:15px;transform: translateY(-50%);" >{{\App\CPU\BackEndHelper::set_currency($ad->currency)}}</span>
                                                    <input type="number" id="auction_price_input" value="{{old('price')}}"
                                                    class="form-control mb-3 mt-1 px-4" value="{{old('price')}}" 
                                                    name="price">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                @if(auth('customer')->check())
                                                    <button type="button" style="font-size: 15px;" class="btn primary-blue-bg-color 
                                                    buy-now-btn-hover mb-2 py-3 px-2 w-100 text-white" id="openAuctionOfferModalBtn"
                                                    >
                                                        <i class="bi bi-hammer"></i> 
                                                        {{translate('send_the_offer')}}
                                                    </button>
                                                @else
                                                    <button type="button" style="font-size: 15px;" class="btn primary-blue-bg-color
                                                    buy-now-btn-hover mb-2 py-3 px-2 w-100 text-white" 
                                                    data-bs-toggle="modal" data-bs-target="#loginModal">
                                                        <i class="bi bi-hammer"></i> 
                                                        {{translate('send_the_offer')}}
                                                    </button>
                                                @endif
                                            </div>

                                            @if(auth('customer')->check())
                                            <!-- Review Modal -->
                                            <div class="modal fade" id="makeAnOfferModal" style="display: none; background: rgba(0, 0, 0, 0.13);" aria-labelledby="makeAnOfferModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" style="top: 140px;">
                                                    <div class="modal-content">
                                                        <div class="modal-header px-sm-4 pb-1">
                                                            <h5 class="" id="makeAnOfferModalLabel">{{translate('make_an_offer')}}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body px-sm-4">
                                                            <form action="{{route('messages_store')}}" method="POST" id="make_an_offer_form" data-success-message="{{translate('offer_sended_successfully')}}">
                                                                @csrf
                                                                <input type="hidden" name="message_type" value="make_an_offer">
                                                                <input type="hidden" name="ad_id" value="{{$ad->id}}">
                                                                <input type="hidden" name="seller_id" value="{{$ad->user->id}}" >
                                                                <input type="hidden" id="auction_price_value" name="auction_price" value="" >
<textarea readonly id="auctionMessageBox" style="block-size: 115px;" name="message" class="form-control" rows="18" required placeholder="{{ translate('type_your_offer_message') }}">
{{ translate('dear') }} {{ $ad->user->f_name }},
{{ translate('i_would_like_to_offer') }} {{\App\CPU\BackEndHelper::set_currency($ad->currency)}}[[PRICE]] {{translate('for_your_listing')}} "{{$ad->title}}".
{{ translate('i_look_forward_to_hearing_from_you') }},
{{ translate('kind_regards') }},
{{ auth('customer')->user()->f_name }} {{auth('customer')->user()->l_name}}
</textarea>
                                                                <div class="pt-3" >
                                                                    <span class="note-span" ><span class="fw-medium" >{{translate('note')}}</span> : {{translate('the_message_text_will_be_changed_to_english_if_your_language_is_different_from_the_seller_language')}}</span>
                                                                </div>
                                                                <div class="d-flex justify-content-between mt-3">
                                                                    <div class="d-flex">
                                                                        <button type="button" onclick="submitMakeAnOfferForm()" class="btn btn-primary me-2" >{{translate('send')}}</button>
                                                                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">{{translate('close')}}</button>
                                                                    </div>
                                                                    <div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                        </div>
                                    </div>
                                    @if($ad->auctions->count() > 0)
                                        <div class="mb-3" >
                                            <div class="card" style="--bs-border-color: #d6d6d6">
                                                <div class="card-body px-0">
                                                    <div class="row" >
                                                        @foreach($ad->auctions->sortByDesc('created_at')->take(3) as $auction)
                                                            <div class="d-flex align-items-center justify-content-between pb-2 mb-2" >
                                                                <span class="fw-medium d-block fs-13" >{{$auction->user->name}}</span>
                                                                <span class="fw-bold fs-13" >{{\App\CPU\BackEndHelper::set_price_currency($auction->price, $ad->currency)}}</span>
                                                                <span class="fw-normal d-block fs-12">{{ date('d M y', strtotime($auction->created_at)) }}</span>
                                                                @if($auction->user->id == auth('customer')->id())
                                                                    <form action="{{route('ads-delete-auction')}}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="id" value="{{$auction->id}}">
                                                                        <button type="button" onclick="post_route_alert(this, '{{translate('are_you_sure_you_want_to_delete_this_auction')}}')" class="bg-transparent border-0 text-danger p-0" ><i class="bi bi-trash"></i></button>
                                                                    </form>
                                                                @else
                                                                    <span class="mx-2"></span>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mb-4" >
                                            <h5 class="fw-medium" >{{ translate('there_are_no_offers_yet') }}</h5>
                                        </div>
                                    @endif
                                @endif
                                
                                @if($ad->price_type == 'asking_price')
                                    @if($ad->allow_offers)
                                        <div class="mb-2" >
                                            <div>
                                                <input type="hidden" id="first_price" value="{{$ad->first_price}}">
                                                <div class="form-group mb-3">
                                                    <label class="m-0" for="price">{{translate('auction')}}</label>
                                                    @if($ad->first_price)
                                                        <div>
                                                            <span class="fz-14" >{{translate('starting_form')}} : {{\App\CPU\BackEndHelper::set_price_currency($ad->first_price, $ad->currency)}}</span>
                                                        </div>
                                                    @endif
                                                    <div class="position-relative" >
                                                        <span class="position-absolute fw-bold currency-font" 
                                                        style="top:50%;left:15px;transform: translateY(-50%);" >{{\App\CPU\BackEndHelper::set_currency($ad->currency)}}</span>
                                                        <input type="number"  id="asking_price_input" value="{{old('price')}}"
                                                        class="form-control mb-3 mt-1 px-4" value="{{old('price')}}" 
                                                        name="price">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    @if(auth('customer')->check())
                                                        <button type="submit" style="font-size: 15px;" 
                                                        class="btn primary-blue-bg-color 
                                                        buy-now-btn-hover mb-2 py-3 px-2 w-100 text-white" id="openAskingPriceOfferModalBtn" >
                                                            <i class="bi bi-hammer"></i> 
                                                            {{translate('send_the_offer')}}
                                                        </button>
                                                    @else
                                                        <button type="button" style="font-size: 15px;" 
                                                        class="btn primary-blue-bg-color 
                                                        buy-now-btn-hover mb-2 py-3 px-2 w-100 text-white" 
                                                        data-bs-toggle="modal" data-bs-target="#loginModal">
                                                            <i class="bi bi-hammer"></i> 
                                                            {{translate('send_the_offer')}}
                                                        </button>
                                                    @endif
                                                </div>

                                            @if(auth('customer')->check())
                                            <!-- Review Modal -->
                                            <div class="modal fade" id="askingPriceModal" style="display: none; background: rgba(0, 0, 0, 0.13);" aria-labelledby="askingPriceModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" style="top: 140px;">
                                                    <div class="modal-content">
                                                        <div class="modal-header px-sm-4 pb-1">
                                                            <h5 class="" id="askingPriceModalLabel">{{translate('make_an_offer')}}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body px-sm-4">
                                                            <form action="{{route('messages_store')}}" method="post" id="asking_price_form" data-success-message="{{translate('offer_sended_successfully')}}">
                                                                @csrf
                                                                <input type="hidden" name="message_type" value="asking_price">
                                                                <input type="hidden" name="ad_id" value="{{$ad->id}}">
                                                                <input type="hidden" name="seller_id" value="{{$ad->user->id}}" >
                                                                <input type="hidden" id="asking_price_value" name="asking_price" value="" >
<textarea readonly id="askingPriceMessageBox" style="block-size: 115px;" name="message" class="form-control" rows="18" required placeholder="{{ translate('type_your_offer_message') }}">
{{ translate('dear') }} {{ $ad->user->f_name }},
{{ translate('i_would_like_to_offer') }} {{\App\CPU\BackEndHelper::set_currency($ad->currency)}}[[PRICE]] {{translate('for_your_listing')}} "{{$ad->title}}".
{{ translate('i_look_forward_to_hearing_from_you') }},
{{ translate('kind_regards') }},
{{ auth('customer')->user()->f_name }} {{auth('customer')->user()->l_name}}
</textarea>
                                                                <div class="pt-3" >
                                                                    <span class="note-span" ><span class="fw-medium" >{{translate('note')}}</span> : {{translate('the_message_text_will_be_changed_to_english_if_your_language_is_different_from_the_seller_language')}}</span>
                                                                </div>
                                                                <div class="d-flex justify-content-between mt-3">
                                                                    <div class="d-flex">
                                                                        <button type="button" onclick="submitAskingPriceForm()" class="btn btn-primary me-2" >{{translate('send')}}</button>
                                                                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">{{translate('close')}}</button>
                                                                    </div>
                                                                    <div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            </div>
                                        </div>
                                        @if($ad->askingPrice->count() > 0)
                                            <div class="mb-3" >
                                                <div class="card" style="--bs-border-color: #d6d6d6">
                                                    <div class="card-body px-0">
                                                        <div class="row" >
                                                            @foreach($ad->askingPrice->sortByDesc('created_at')->take(3) as $asking_price)
                                                                <div class="d-flex align-items-center justify-content-between pb-2 mb-2" >
                                                                    <span class="fw-medium d-block fs-13" >{{$asking_price->user->name}}</span>
                                                                    <span class="fw-bold fs-13" >{{\App\CPU\BackEndHelper::set_price_currency($asking_price->price, $ad->currency)}}</span>
                                                                    <span class="fw-normal d-block fs-12">{{ date('d M y', strtotime($asking_price->created_at)) }}</span>
                                                                    @if($asking_price->user->id == auth('customer')->id())
                                                                        <form action="{{route('ads-delete-asking-price')}}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="id" value="{{$asking_price->id}}">
                                                                            <button type="button" onclick="post_route_alert(this, '{{translate('are_you_sure_you_want_to_delete_this_auction')}}')" class="bg-transparent border-0 text-danger p-0" >
                                                                                <i class="bi bi-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <span class="mx-2"></span>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="mb-4" >
                                                <h5 class="fw-medium" >{{ translate('there_are_no_offers_yet') }}</h5>
                                            </div>
                                        @endif
                                    @endif
                                @endif

                                @if($paid_banners->count() > 0)
                                    <div class="mt-4">
                                        <h4 class="mb-4">{{ translate('advertising_space') }}</h4>
                                        <div class="row">
                                            @foreach($paid_banners as $banner)
                                                <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
                                                    <a href="{{ $banner->banner_url ?? '#' }}">
                                                        <img style="height: 120px !important;" 
                                                        class="rounded" 
                                                        width="100%" 
                                                        src="{{ env_asset('storage/paid-banners/'.$banner->banner_image) }}" 
                                                        alt="paid_banner_image">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="card order-1 order-sm-0 mt-5">
                                    <div class="card-body p-0">
                                        <h5 class="mb-3">{{translate('More_from_the_Store')}}</h5>

                                        <div class="d-flex flex-wrap gap-3">
                                            @if ($more_ads_from_user->count()>0)
                                                @foreach($more_ads_from_user as $key => $item)
                                                    <div class="card border-primary-light transparent-shadow-hover flex-grow-1">
                                                        <a href="{{route('ads-show',$item->slug)}}"
                                                        class="media align-items-centr gap-3 p-2">
                                                            <div class="avatar" style="--size: 5.375rem">
                                                                <img
                                                                    src="{{env_asset('storage/ad/thumbnail/'.$item->thumbnail)}}"
                                                                    alt=""
                                                                    class="img-fit dark-support rounded img-fluid overflow-hidden"
                                                                    onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'">
                                                            </div>
                                                            @php($item_review = \App\CPU\ProductManager::get_overall_rating($item->reviews))

                                                            <div class="media-body d-flex flex-column justify-content-center gap-0">
                                                                <h6 class="text-capitalize mb-1">{{ Str::limit($item['title'], 24) }}</h6>
                                                                <span><i class="bi bi-person" ></i> {{ $ad->user->f_name }} {{ $ad->user->l_name }}</span>
                                                                <h6 class="text-primary" >{{$item->category->name ?? '/'}}</h6>
                                                                <div class="product__price text-end">
                                                                    <ins class="product__new-price currency-font">
                                                                        @if($item->price_type == 'fixed_price')
                                                                            {{\App\CPU\BackEndHelper::set_price_currency($item->price, $item->currency)}}
                                                                        @elseif($item->price_type == 'free')
                                                                            <span class="fw-medium" >{{ translate('free') }}</span>
                                                                        @elseif($item->price_type == 'asking_price')
                                                                            <span class="fw-medium" >
                                                                                <span>{{\App\CPU\BackEndHelper::set_price_currency($item->price, $item->currency)}}</span>
                                                                            </span>
                                                                        @elseif($item->price_type == 'auction')
                                                                            <span class="fw-medium" >
                                                                                {{translate('auction')}}</span>
                                                                        @endif
                                                                    </ins>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="card border-primary-light flex-grow-1">
                                                    <a href="javaScript:void(0)" class="media align-items-centr gap-3 p-3">
                                                        <div class="media-body d-flex flex-column gap-2">
                                                            <h6>{{translate('similar_product_not_available')}}</h6>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Similar Products From Other Stores -->
            <div class="py-4 mt-3">
                <div class="d-flex justify-content-between gap-3 mb-4">
                    <h2>{{ translate('similar_Products_From_Other_Stores') }}</h2>
                    <div class="swiper-nav d-flex gap-2 align-items-center">
                        <div class="swiper-button-prev top-rated-nav-prev position-static rounded-10"></div>
                        <div class="swiper-button-next top-rated-nav-next position-static rounded-10"></div>
                    </div>
                </div>
                <div class="swiper-container">
                    <div class="position-relative">
                        <div class="similar-ads-swiper py-2 product-card-shadow">
                            <div class="swiper-wrapper">
                                @if (count($relatedAds) > 0)
                                    @foreach($relatedAds as $key => $ad)
                                        <div class="swiper-slide">
                                            @include('theme-views.partials._product-large-card', ['ad' => $ad])
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card w-100 rounded">
                                        <h5 class="text-muted">{{ translate('no_similar_products_found') }}</h5>
                                    </div>
                                @endif
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

    <script src="https://cdn.jsdelivr.net/npm/@mux/mux-player"></script>

    <script>
        $('.remove-mask-img').on('click', function(){
            $('.show-more--content').removeClass('active')
        })

        function get_phone_number(phone_number, element) {
            const originalHTML = '<i class="bi bi-telephone me-1"></i> {{translate('phone_number')}}';

            element.innerHTML = '<i class="bi bi-telephone me-1"></i> ' + phone_number;

            navigator.clipboard.writeText(phone_number).then(() => {
                toastr.success('{{translate("phone_number_copied_to_clipboard")}}!');

                // Revert after 3 seconds
                setTimeout(() => {
                    element.innerHTML = originalHTML;
                }, 3000);
            }).catch(() => {
                toastr.error('{{translate("failed_to_copy_phone_number")}} .');
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Get elements
            const auctionOfferButton = document.getElementById('openAuctionOfferModalBtn');
            const askingPriceOfferButton = document.getElementById('openAskingPriceOfferModalBtn');
            
            const auctionPriceInput = document.getElementById('auction_price_input');
            const askingPriceInput = document.getElementById('asking_price_input');
            
            const auctionPriceValue = document.getElementById('auction_price_value');
            const askingPriceValue = document.getElementById('asking_price_value');

            const makeAnOfferModal = document.getElementById('makeAnOfferModal');
            const askingPriceModal = document.getElementById('askingPriceModal');
            
            const auctionMessageBox = document.getElementById('auctionMessageBox');
            const askingPriceMessageBox = document.getElementById('askingPriceMessageBox');
            
            // Check if elements exist before accessing them
            const startingPrice = document.getElementById('starting_price') ? 
                parseFloat(document.getElementById('starting_price').value) : 0;
            
            const firstPrice = document.getElementById('first_price') ? 
                parseFloat(document.getElementById('first_price').value) : 0;
            
            // Define original message templates
            const currencySymbol = document.getElementById('ad-currency') ? 
                                document.getElementById('ad-currency').textContent.trim() : '';
            
            const auctionOriginalMessage = auctionMessageBox ? auctionMessageBox.value : '';
            const askingPriceOriginalMessage = askingPriceMessageBox ? askingPriceMessageBox.value : '';
        
            // Add event listeners if buttons exist
            if (auctionOfferButton) {
                auctionOfferButton.addEventListener('click', function () {
                    if (!auctionPriceInput) {
                        return;
                    }
                    
                    let price = auctionPriceInput.value.trim();
                    if (!price) {
                        toastr.error('{{translate("please_type_the_offer_price")}}');
                        return;
                    }
                    
                    price = parseFloat(price);
                    if (startingPrice && price <= startingPrice) {
                        toastr.error('{{translate("offer_price_must_be_greater_than_starting_price")}}');
                        return;
                    }
                    
                    // Set the message dynamically
                    if (auctionMessageBox) {
                        auctionMessageBox.value = auctionOriginalMessage.replace('[[PRICE]]', price);
                        auctionPriceValue.value = price;
                    }
                    
                    // Manually open the modal
                    if (makeAnOfferModal) {
                        let modal = new bootstrap.Modal(makeAnOfferModal);
                        modal.show();
                    }
                });
            }
        
            if (askingPriceOfferButton) {
                askingPriceOfferButton.addEventListener('click', function () {
                    if (!askingPriceInput) {
                        return;
                    }
                    
                    let price = askingPriceInput.value.trim();
                    if (!price) {
                        toastr.error('{{translate("please_type_the_offer_price")}}');
                        return;
                    }
                    
                    price = parseFloat(price);
                    if (firstPrice && price <= firstPrice) {
                        toastr.error('{{translate("offer_price_must_be_greater_than_starting_price")}}');
                        return;
                    }
                    
                    // Set the message dynamically
                    if (askingPriceMessageBox) {
                        askingPriceMessageBox.value = askingPriceOriginalMessage.replace('[[PRICE]]', price);
                        askingPriceValue.value = price;
                    }
                    
                    // Manually open the modal
                    if (askingPriceModal) {
                        let modal = new bootstrap.Modal(askingPriceModal);
                        modal.show();
                    }
                });
            }
        
        });

        function get_phone_number_and_whatsapp(phone_number, element) {
            const originalHTML = '<i class="bi bi-whatsapp me-1"></i> {{translate('whatsapp_number')}}';

            element.innerHTML = '<i class="bi bi-whatsapp me-1"></i> ' + phone_number;

            navigator.clipboard.writeText(phone_number).then(() => {
                toastr.success('{{translate("Phone_number_copied_to_clipboard")}}!');

                // Revert after 3 seconds
                setTimeout(() => {
                    element.innerHTML = originalHTML;
                }, 3000);
            }).catch(() => {
                toastr.error('{{translate("failed_to_copy_phone_number")}}.');
            });
        }

        function get_email_address(email_address, element) {
            const originalHTML = '<i class="bi bi-envelope-fill me-1"></i> Email Address';

            element.innerHTML = '<i class="bi bi-envelope-fill me-1"></i> ' + email_address;

            // Set Toastr options to use the primary blue background
            toastr.options = {
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "closeButton": true,
                "backgroundColor": "blue", // Bootstrap primary color
            };

            navigator.clipboard.writeText(email_address).then(() => {
                toastr.success('{{translate("email_address_copied_to_clipboard")}}!');

                // Revert after 3 seconds
                setTimeout(() => {
                    element.innerHTML = originalHTML;
                }, 3000);
            }).catch(() => {
                toastr.error('{{translate("failed_to_copy_email_address")}}.');
            });
        }

        function post_route_alert(button, message) {
            Swal.fire({
                title: '{{translate("are_you_sure_you_want_to_delete_this_auction")}}?',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '{{$web_config['primary_color']}}',
                cancelButtonText: '{{translate('no')}}',
                confirmButtonText: '{{translate('yes')}}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    button.closest('form').submit();
                }
            })
        }

    </script>

    @if(auth('customer')->check() && auth('customer')->user()->id != $ad['user_id'])
        <script>

            function initAutocomplete() {
                const adCountry = document.getElementById('adCountry').value;
                const adCity = document.getElementById('adCity').value;
                const fullAddress = adCity + ", " + adCountry;

                const userCountry = document.getElementById('userCountry')?.value || "";
                const userCity = document.getElementById('userCity')?.value || "";
                const userFullAddress = userCity + ", " + userCountry;

                const geocoder = new google.maps.Geocoder();

                geocoder.geocode({ address: fullAddress }, function(results, status) {
                    if (status === "OK") {
                        const adLatLng = results[0].geometry.location;

                        const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                            center: adLatLng,
                            zoom: 13,
                            mapTypeId: "roadmap",
                        });

                        const adMarker = new google.maps.Marker({
                            map: map,
                            position: adLatLng,
                            title: `Ad Location: ${adCity}, ${adCountry}`,
                        });

                        const adInfoWindow = new google.maps.InfoWindow({
                            content: `<div><strong>Ad Location</strong><br>${adCity}, ${adCountry}</div>`
                        });

                        adMarker.addListener("click", () => {
                            adInfoWindow.open(map, adMarker);
                        });

                        // Now geocode the user location
                        geocoder.geocode({ address: userFullAddress }, function(userResults, userStatus) {
                            if (userStatus === "OK") {
                                const userLatLng = userResults[0].geometry.location;

                                const userMarker = new google.maps.Marker({
                                    map: map,
                                    position: userLatLng,
                                    title: `Your Location: ${userCity}, ${userCountry}`,
                                });

                                const userInfoWindow = new google.maps.InfoWindow({
                                    content: `<div><strong>Your Location</strong><br>${userCity}, ${userCountry}</div>`
                                });

                                userMarker.addListener("click", () => {
                                    userInfoWindow.open(map, userMarker);
                                });

                                const distance = calculateDistance(
                                    adLatLng.lat(), adLatLng.lng(),
                                    userLatLng.lat(), userLatLng.lng()
                                );

                                const directionsService = new google.maps.DirectionsService();
                                const directionsRenderer = new google.maps.DirectionsRenderer({
                                    map: map,
                                    suppressMarkers: true,
                                    polylineOptions: {
                                        strokeColor: '#2979FF',
                                        strokeWeight: 5,
                                        strokeOpacity: 0.8
                                    }
                                });

                                let locationData = 
                                ` 
                                    <div>
                                        <div>
                                            <h3 class="my-3" >{{translate('distance_from_your_location_to_the_seller_location')}}</h3>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center gap-5 mb-2" >
                                                <div class="d-flex align-items-center gap-2" >
                                                    <span class="bg-primary p-1 px-2 rounded" ><i style="font-size: 20px;" class="bi bi-car-front-fill text-light"></i></span>
                                                    <h2 class="fw-normal" >{{translate('drive')}}</h2>
                                                </div>
                                                <div>
                                                    <h3 style="font-size: 18px;" class="fw-bold" id="carDistance"></h3>
                                                </div>
                                                <div>
                                                    <h3 style="font-size: 18px;" class="fw-bold" id="carTime"></h3>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-5" >
                                                <div class="d-flex align-items-center gap-2" >
                                                    <span class="bg-primary p-1 px-2 rounded" ><i style="font-size: 20px;" class="bi bi-bicycle text-light"></i></span>
                                                    <h2 class="fw-normal" >{{translate('bicycle')}}</h2>
                                                </div>
                                                <div>
                                                    <h3 style="font-size: 18px;" class="fw-bold" id="bicycleDistance"></h3>
                                                </div>
                                                <div>
                                                    <h3 style="font-size: 18px;" class="fw-bold" id="bicycleTime"></h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="errorInfo" style="color:red;"></div>
                                    </div>  
                                `;

                                directionsService.route(
                                    {
                                        origin: adLatLng,
                                        destination: userLatLng,
                                        travelMode: google.maps.TravelMode.DRIVING,
                                    },
                                    (response, status) => {
                                        if (status === "OK") {
                                            directionsRenderer.setDirections(response);
                                            const route = response.routes[0];
                                            const leg = route.legs[0];

                                            document.getElementById("carDistance").innerText = leg.distance.text;
                                            document.getElementById("carTime").innerText = leg.duration.text;
                                        } else {
                                            document.getElementById("errorInfo").innerText =
                                                `Directions request failed due to ${status}`;
                                        }
                                    }
                                );

                                directionsService.route(
                                    {
                                        origin: adLatLng,
                                        destination: userLatLng,
                                        travelMode: google.maps.TravelMode.BICYCLING,
                                    },
                                    (response, status) => {
                                        if (status === "OK") {
                                            const route = response.routes[0];
                                            const leg = route.legs[0];
                                            document.getElementById("bicycleDistance").innerText = leg.distance.text;
                                            document.getElementById("bicycleTime").innerText = leg.duration.text;
                                        } else {
                                            document.getElementById("bicycleTravelInfo").innerText =
                                                `Bicycle directions request failed: ${status}`;
                                        }
                                    }
                                );

                                document.getElementById("location-data").insertAdjacentHTML("beforeend", locationData);

                                const bounds = new google.maps.LatLngBounds();
                                bounds.extend(adLatLng);
                                bounds.extend(userLatLng);
                                map.fitBounds(bounds);

                            } else {
                                console.error("{{translate('user_location_geocoding_failed')}}:", userStatus);
                            }
                        });

                        const input = document.getElementById("pac-input");
                        const searchBox = new google.maps.places.SearchBox(input);
                        map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

                        map.addListener("bounds_changed", () => {
                            searchBox.setBounds(map.getBounds());
                        });

                        let markers = [];

                        searchBox.addListener("places_changed", () => {
                            const places = searchBox.getPlaces();

                            if (places.length == 0) {
                                return;
                            }

                            markers.forEach((marker) => {
                                marker.setMap(null);
                            });
                            markers = [];

                            const bounds = new google.maps.LatLngBounds();
                            places.forEach((place) => {
                                if (!place.geometry || !place.geometry.location) {
                                    console.log("Returned place contains no geometry");
                                    return;
                                }
                                var mrkr = new google.maps.Marker({
                                    map,
                                    title: place.name,
                                    position: place.geometry.location,
                                });

                                google.maps.event.addListener(mrkr, "click", function (event) {
                                    document.getElementById('latitude').value = this.position.lat();
                                    document.getElementById('longitude').value = this.position.lng();
                                });

                                markers.push(mrkr);

                                if (place.geometry.viewport) {
                                    bounds.union(place.geometry.viewport);
                                } else {
                                    bounds.extend(place.geometry.location);
                                }
                            });
                            map.fitBounds(bounds);
                        });

                    } else {
                        console.error("Geocode failed due to: " + status);
                    }
                });
            }


            // Calculate distance between two coordinates using Haversine formula
            function calculateDistance(lat1, lon1, lat2, lon2) {
                const R = 6371; // Radius of the earth in km
                const dLat = deg2rad(lat2 - lat1);
                const dLon = deg2rad(lon2 - lon1);
                const a = 
                    Math.sin(dLat/2) * Math.sin(dLat/2) +
                    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
                    Math.sin(dLon/2) * Math.sin(dLon/2); 
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
                const distance = R * c; // Distance in km
                return distance;
            }

            function deg2rad(deg) {
                return deg * (Math.PI/180);
            }

            // Get directions and travel time information
            function getDirections(directionsService, origin, destination, travelMode) {
                // Only process DRIVING and BICYCLING modes
                if (travelMode !== "DRIVING" && travelMode !== "BICYCLING") {
                    return;
                }
                
                directionsService.route(
                    {
                        origin: origin,
                        destination: destination,
                        travelMode: google.maps.TravelMode[travelMode],
                    },
                    (response, status) => {
                        if (status === "OK" && response) {
                            const route = response.routes[0];
                            const leg = route.legs[0];
                            
                            // Log only distance and duration for car and bicycle
                            console.log(`${travelMode === "DRIVING" ? "Car" : "Bicycle"} travel: ${leg.distance.text}, time: ${leg.duration.text}`);
                        } else {
                            console.log(`${travelMode} directions request failed due to ${status}`);
                        }
                    }
                );
            }

            // Keeping original billingMap function intact
            function billingMap() {
                let myLatLng = { lat: -33.8688, lng: 151.2195 };
                const map = new google.maps.Map(document.getElementById("billing_location_map_canvas"), {
                    center: { lat: -33.8688, lng: 151.2195 },
                    zoom: 13,
                    mapTypeId: "roadmap",
                });

                let marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                });

                marker.setMap( map );
                var geocoder = geocoder = new google.maps.Geocoder();
                google.maps.event.addListener(map, 'click', function (mapsMouseEvent) {
                    var coordinate = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                    var coordinates = JSON.parse(coordinate);
                    var latlng = new google.maps.LatLng( coordinates['lat'], coordinates['lng'] ) ;
                    marker.setPosition( latlng );
                    map.panTo( latlng );

                    document.getElementById('billing_latitude').value = coordinates['lat'];
                    document.getElementById('billing_longitude').value = coordinates['lng'];

                    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[1]) {
                                document.getElementById('billing_address').value = results[1].formatted_address;
                                console.log(results[1].formatted_address);
                            }
                        }
                    });
                });

                // Create the search box and link it to the UI element.
                const input = document.getElementById("pac-input-billing");

                const searchBox = new google.maps.places.SearchBox(input);

                map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
                // Bias the SearchBox results towards current map's viewport.
                map.addListener("bounds_changed", () => {
                    searchBox.setBounds(map.getBounds());
                });
                let markers = [];
                // Listen for the event fired when the user selects a prediction and retrieve
                // more details for that place.
                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }
                    // Clear out the old markers.
                    markers.forEach((marker) => {
                        marker.setMap(null);
                    });
                    markers = [];
                    // For each place, get the icon, name and location.
                    const bounds = new google.maps.LatLngBounds();
                    places.forEach((place) => {
                        if (!place.geometry || !place.geometry.location) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        var mrkr = new google.maps.Marker({
                            map,
                            title: place.name,
                            position: place.geometry.location,
                        });

                        google.maps.event.addListener(mrkr, "click", function (event) {
                            document.getElementById('billing_latitude').value = this.position.lat();
                            document.getElementById('billing_longitude').value = this.position.lng();

                        });

                        markers.push(mrkr);

                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);
                });
            }

            // Keeping original mapsShopping function intact
            function mapsShopping() {
                try {
                    initAutocomplete();
                } catch (error) {
                    console.error("Error in initAutocomplete:", error);
                }
                try {
                    billingMap();
                } catch (error) {
                    console.error("Error in billingMap:", error);
                }
            }

            // Keep the original event handler
            $(document).on("keydown", "input", function(e) {
                if (e.which==13) e.preventDefault();
            });

        </script>
    @else
        <script>
            function initAutocomplete() {
                
                const country = document.getElementById('adCountry').value;
                const city = document.getElementById('adCity').value;
                const fullAddress = city + ", " + country;

                const geocoder = new google.maps.Geocoder();
                geocoder.geocode({ address: fullAddress }, function(results, status) {
                    if (status === "OK") {
                        const myLatLng = results[0].geometry.location;

                        const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                            center: myLatLng,
                            zoom: 13,
                            mapTypeId: "roadmap",
                        });

                        // Create the search box and link it to the UI element.
                        const input = document.getElementById("pac-input");

                        const searchBox = new google.maps.places.SearchBox(input);

                        map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
                        // Bias the SearchBox results towards current map's viewport.
                        map.addListener("bounds_changed", () => {
                            searchBox.setBounds(map.getBounds());
                        });
                        let markers = [];
                        // Listen for the event fired when the user selects a prediction and retrieve
                        // more details for that place.
                        searchBox.addListener("places_changed", () => {
                            const places = searchBox.getPlaces();

                            if (places.length == 0) {
                                return;
                            }
                            // Clear out the old markers.
                            markers.forEach((marker) => {
                                marker.setMap(null);
                            });
                            markers = [];
                            // For each place, get the icon, name and location.
                            const bounds = new google.maps.LatLngBounds();
                            places.forEach((place) => {
                                if (!place.geometry || !place.geometry.location) {
                                    console.log("Returned place contains no geometry");
                                    return;
                                }
                                var mrkr = new google.maps.Marker({
                                    map,
                                    title: place.name,
                                    position: place.geometry.location,
                                });

                                google.maps.event.addListener(mrkr, "click", function (event) {
                                    document.getElementById('latitude').value = this.position.lat();
                                    document.getElementById('longitude').value = this.position.lng();

                                });

                                markers.push(mrkr);

                                if (place.geometry.viewport) {
                                    // Only geocodes have viewport.
                                    bounds.union(place.geometry.viewport);
                                } else {
                                    bounds.extend(place.geometry.location);
                                }
                            });
                            map.fitBounds(bounds);
                        });

                    } else {
                        console.error("Geocode failed due to: " + status);
                    }
                });
            }

            $(document).on("keydown", "input", function(e) {
                if (e.which==13) e.preventDefault();
            });
            
            function billingMap() {
                let myLatLng = { lat: -33.8688, lng: 151.2195 };
                const map = new google.maps.Map(document.getElementById("billing_location_map_canvas"), {
                    center: { lat: -33.8688, lng: 151.2195 },
                    zoom: 13,
                    mapTypeId: "roadmap",
                });
            
                let marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                });
            
                marker.setMap( map );
                var geocoder = geocoder = new google.maps.Geocoder();
                google.maps.event.addListener(map, 'click', function (mapsMouseEvent) {
                    var coordinate = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                    var coordinates = JSON.parse(coordinate);
                    var latlng = new google.maps.LatLng( coordinates['lat'], coordinates['lng'] ) ;
                    marker.setPosition( latlng );
                    map.panTo( latlng );
            
                    document.getElementById('billing_latitude').value = coordinates['lat'];
                    document.getElementById('billing_longitude').value = coordinates['lng'];
            
                    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[1]) {
                                document.getElementById('billing_address').value = results[1].formatted_address;
                                console.log(results[1].formatted_address);
                            }
                        }
                    });
                });
            
                // Create the search box and link it to the UI element.
                const input = document.getElementById("pac-input-billing");
            
                const searchBox = new google.maps.places.SearchBox(input);
            
                map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
                // Bias the SearchBox results towards current map's viewport.
                map.addListener("bounds_changed", () => {
                    searchBox.setBounds(map.getBounds());
                });
                let markers = [];
                // Listen for the event fired when the user selects a prediction and retrieve
                // more details for that place.
                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();
            
                    if (places.length == 0) {
                        return;
                    }
                    // Clear out the old markers.
                    markers.forEach((marker) => {
                        marker.setMap(null);
                    });
                    markers = [];
                    // For each place, get the icon, name and location.
                    const bounds = new google.maps.LatLngBounds();
                    places.forEach((place) => {
                        if (!place.geometry || !place.geometry.location) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        var mrkr = new google.maps.Marker({
                            map,
                            title: place.name,
                            position: place.geometry.location,
                        });
            
                        google.maps.event.addListener(mrkr, "click", function (event) {
                            document.getElementById('billing_latitude').value = this.position.lat();
                            document.getElementById('billing_longitude').value = this.position.lng();
            
                        });
            
                        markers.push(mrkr);
            
                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);
                });
            };

            $(document).on("keydown", "input", function(e) {
                if (e.which==13) e.preventDefault();
            });
            
            function mapsShopping() {
                try {
                    initAutocomplete();
                } catch (error) {
                }
                try {
                    billingMap();
                } catch (error) {
                }
            }
        </script>
    @endif

    <script src="https://maps.googleapis.com/maps/api/js?key={{\App\CPU\Helpers::get_business_settings('map_api_key')}}&callback=mapsShopping&libraries=places&v=3.49" defer></script>
    
    <script src="{{ theme_asset('assets/js/lightbox.min.js') }}"></script>
    
    <script src="{{ theme_asset('assets/plugins/easyzoom/easyzoom.min.js') }}"></script>

    <script>
        $(".easyzoom").each(function () {
            $(this).easyZoom();
        });
    </script>
@endpush

@extends('theme-views.layouts.app')

@section('title', $ad['name'].' | '.$web_config['name']->value.' '.translate('ecommerce'))


@push('css_or_js')
    <meta name="description" content="{{$ad->slug}}">
    <meta name="keywords" content="@foreach(explode(' ',$ad['name']) as $keyword) {{$keyword.' , '}} @endforeach">
    <meta name="author" content="{{$web_config['name']->value}}">
    <!-- Viewport-->

    @if($ad['meta_image'])
        <meta property="og:image" content="{{asset("storage/app/public/ad/meta")}}/{{$ad->meta_image}}"/>
        <meta property="twitter:card"
              content="{{asset("storage/app/public/ad/meta")}}/{{$ad->meta_image}}"/>
    @else
        <meta property="og:image" content="{{asset("storage/app/public/ad/thumbnail")}}/{{$ad->thumbnail}}"/>
        <meta property="twitter:card"
              content="{{asset("storage/app/public/ad/thumbnail/")}}/{{$ad->thumbnail}}"/>
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
    </style>

@endpush

@section('content')




    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 pt-3 mb-sm-5">
        <div class="container">
            <div class="row gx-3 gy-4">
                <div class="col-lg-9 col-xl-9">
                    <div class="card h-100 mb-3">
                        <div class="card-body">
                            <div class="quickview-content">
                                <div class="row gy-4 d-flex align-items-stretch">
                                    <div class="col-lg-6">
                                        <!-- Product Details Image Wrap -->
                                        <div class="pd-img-wrap position-relative h-100">
                                            <div class="swiper-container quickviewSlider2 rounded aspect-0"
                                                 style="--bs-border-color: #d6d6d6">
                                                <div class="product__actions d-flex flex-column gap-2">
                                                    <a onclick="addWishlist('{{$ad['id']}}','{{route('store-wishlist')}}')"
                                                       id="wishlist-{{$ad['id']}}"
                                                       class="btn-wishlist add_to_wishlist cursor-pointer wishlist-{{$ad['id']}} {{($wishlist_status == 1?'wishlist_icon_active':'')}}"
                                                       title="{{translate('add_to_wishlist')}}">
                                                        <i class="bi bi-heart"></i>
                                                    </a>
                                                    <div class="product-share-icons">
                                                        <a href="javascript:" title="Share">
                                                            <i class="bi bi-share-fill"></i>
                                                        </a>

                                                        <ul>
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
                                                </div>

                                                @if($ad->images!=null && json_decode($ad->images)>0)
                                                    <div class="swiper-wrapper">
                                                        @foreach (json_decode($ad->images) as $key => $photo)
                                                            <div class="swiper-slide position-relative w-100">
                                                                <div class="easyzoom easyzoom--overlay">
                                                                    <a class="w-100"  href="{{asset("storage/app/public/ad/".$photo)}}">
                                                                        <img style="height: 415px; width: 100%;" src="https://cdn.bmwblog.com/wp-content/uploads/2024/08/2025-bmw-x3-m50-dune-grey-13.jpg" class="dark-support" alt="">
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
                                                            @foreach (json_decode($ad->images) as $key => $photo)
                                                                <div class="swiper-slide position-relative aspect-1">
                                                                    <img src="https://cdn.bmwblog.com/wp-content/uploads/2024/08/2025-bmw-x3-m50-dune-grey-13.jpg" class="dark-support rounded" alt="">
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

                                    <div class="col-lg-6 h-100">
                                        <!-- Product Details Content -->
                                        <div class="product-details-content position-relative">                                            
                                            <h2 class="product_title mb-4">{{$ad->name}}</h2>

                                            <h6 class="mt-3 mb-4">
                                                <span class="bg-primary py-2 px-2 rounded text-light">
                                                    <i class="bi bi-tags-fill"></i>
                                                    {{$ad->category->name}}
                                                </span>
                                            </h6>

                                            <div class="d-flex align-items-center justify-content-between mb-2 mt-2" >
                                                <div>
                                                    <div class="d-flex gap-2 flex-wrap align-items-center mb-3">
                                                        <h5 class="fw-bold">{{translate('brand')}} :</h5>
                                                        <div class="d-flex align-items-center" >
                                                            <span class="mx-1" >{{$ad->brand->name}}</span>
                                                        </div>
                                                    </div>
    
                                                    <div class="d-flex gap-2 flex-wrap align-items-center mb-3">
                                                        <h5 class="fw-bold">{{translate('model')}} :</h5>
                                                        <div class="d-flex align-items-center" >
                                                            <span class="mx-1" >{{$ad->model->name}}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="d-flex gap-2 flex-wrap align-items-center mb-3">
                                                        <h5 class="fw-bold">{{translate('ad_color')}} :</h5>
                                                        <div class="d-flex align-items-center" >
                                                            <span style="width: 15px; height: 15px;border-radius: 2px;background: {{$ad->color}};" ></span>
                                                            <span class="mx-1" >({{$ad->color}})</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <img class="rounded border" width="120px" src="https://logowik.com/content/uploads/images/398_bmw.jpg" alt="">
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="product__price d-flex flex-wrap align-items-center gap-2 mb-3">
                                                <ins
                                                    class="product__new-price text-dark fs-28 currency-font">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($ad->price))}}</ins>
                                            </div>

                                            <div class="row" >
                                                <div class="col-md-4 mb-3">
                                                    <div class="card">
                                                        <div class="d-flex align-items-center gap-2" >
                                                            <div>
                                                                <span>
                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/calendar.svg') }}" alt="">
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <h5>{{ translate('year_of_release') }}</h5>
                                                                <span>{{ $ad->year }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="card">
                                                        <div class="d-flex align-items-center gap-2" >
                                                            <div>
                                                                <span>
                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/status.png') }}" alt="">
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <h5>{{ translate('ad_status') }}</h5>
                                                                <span>{{ $ad->ad_status }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="card">
                                                        <div class="d-flex align-items-center gap-2" >
                                                            <div>
                                                                <span>
                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/engine.svg') }}" alt="">
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <h5>{{ translate('engine_type') }}</h5>
                                                                <span>{{ $ad->engine_type }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="card">
                                                        <div class="d-flex align-items-center gap-2" >
                                                            <div>
                                                                <span>
                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/mileage.svg') }}" alt="">
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <h5>{{ translate('mileage') }}</h5>
                                                                <span>{{ $ad->mileage }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="card">
                                                        <div class="d-flex align-items-center gap-2" >
                                                            <div>
                                                                <span>
                                                                    <img width="25px" src="{{ theme_asset('assets/img/svg/body.svg') }}" alt="">
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <h5>{{ translate('body_type') }}</h5>
                                                                <span>{{ $ad->body_type }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="card">
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
                                            </div>
                                            {{--
                                                @include('theme-views.layouts.partials.modal._chat-with-seller',['seller_id'=>$product->seller->id,'shop_id'=>$product->seller->shop->id])
                                            --}}
                                        </div>
                                        <!-- End Product Details Content -->
                                    </div>


                                    <div class="accordion mt-5" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed bg-light dashed-border" style="border-bottom: none !important;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <div class="d-flex align-items-center gap-1" >
                                                    <img width="20px" src="{{ theme_asset('assets/img/svg/dimensions.svg') }}" alt="">
                                                    <span class="fw-bold" >{{ translate('dimensions_and_sizes') }}</span>
                                                </div>
                                            </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row" >
                                                        <div class="col-md-3 mb-3">
                                                            <div class="card">
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
                                                        <div class="col-md-3 mb-3">
                                                            <div class="card">
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
                                                        <div class="col-md-3 mb-3">
                                                            <div class="card">
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
                                                        <div class="col-md-3 mb-3">
                                                            <div class="card">
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
                                                        <div class="col-md-4 mb-3">
                                                            <div class="card">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/weight.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('ad_weight') }}</h5>
                                                                        <span>{{ $ad->weight }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed bg-light dashed-border" style="border-bottom: none !important;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                <div class="d-flex align-items-center gap-1" >
                                                    <img width="20px" src="{{ theme_asset('assets/img/svg/environment.svg') }}" alt="">
                                                    <span class="fw-bold" >{{ translate('environmental_informations') }}</span>
                                                </div>
                                            </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row" >
                                                        <div class="col-md-3 mb-3">
                                                            <div class="card">
                                                                <div class="d-flex align-items-center gap-2" >
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
                                                        <div class="col-md-3 mb-3">
                                                            <div class="card">
                                                                <div class="d-flex align-items-center gap-2" >
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
                                                        <div class="col-md-3 mb-3">
                                                            <div class="card">
                                                                <div class="d-flex align-items-center gap-2" >
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
                                                        <div class="col-md-3 mb-3">
                                                            <div class="card">
                                                                <div class="d-flex align-items-center gap-2" >
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>          
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingFour">
                                            <button class="accordion-button collapsed bg-light dashed-border" style="border-bottom: none !important;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                <div class="d-flex align-items-center gap-1" >
                                                    <img width="20px" src="{{ theme_asset('assets/img/svg/battery.svg') }}" alt="">
                                                    <span class="fw-bold" >{{ translate('battery_informations') }}</span>
                                                </div>
                                            </button>
                                            </h2>
                                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row" >
                                                        <div class="col-md-3 mb-3">
                                                            <div class="card">
                                                                <div class="d-flex align-items-center gap-2" >
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
                                                        <div class="col-md-3 mb-3">
                                                            <div class="card">
                                                                <div class="d-flex align-items-center gap-2" >
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
                                                        <div class="col-md-3 mb-3">
                                                            <div class="card">
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span>
                                                                            <img width="25px" src="{{ theme_asset('assets/img/svg/batterylife.svg') }}" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h5>{{ translate('battery_life') }}</h5>
                                                                        <span>{{ $ad->battery_life}}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingFive">
                                            <button class="accordion-button collapsed bg-light dashed-border" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                <div class="d-flex align-items-center gap-1" >
                                                    <img width="20px" src="{{ theme_asset('assets/img/svg/options.svg') }}" alt="">
                                                    <span class="fw-bold" >{{ translate('ad_options') }}</span>
                                                </div>
                                            </button>
                                            </h2>
                                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row" >
                                                    
                                                        @php
                                                            $options = [
                                                                'abs',
                                                                'airbags',
                                                                'air_conditioning',
                                                                'alloy_wheels',
                                                                'android_auto',
                                                                'apple_carplay',
                                                                'automatic_climate_control',
                                                                'backup_camera',
                                                                'blind_spot_monitor',
                                                                'bluetooth',
                                                                'cd_player',
                                                                'central_locking',
                                                                'cruise_control',
                                                                'daytime_running_lights',
                                                                'electric_mirrors',
                                                                'electric_windows',
                                                                'fog_lights',
                                                                'gps',
                                                                'heated_seats',
                                                                'hill_start_assist',
                                                                'keyless_entry',
                                                                'lane_departure_warning',
                                                                'leather_seats',
                                                                'led_headlights',
                                                                'multifunction_steering_wheel',
                                                                'parking_sensors',
                                                                'power_steering',
                                                                'rear_ac_vents',
                                                                'remote_start',
                                                                'reversing_camera',
                                                                'roof_rails',
                                                                'sunroof',
                                                                'tpms',
                                                                'touchscreen_display',
                                                                'traction_control',
                                                                'usb_ports',
                                                                'wireless_charging',
                                                            ];

                                                            $ad_options = json_decode($ad->options, true);

                                                        @endphp

                                                        @foreach($options ?? [] as $option)


                                                            @php($true_or_false = $ad_options[$option] == true ? 'true' : 'false') 

                                                            <div class="col-md-3 mb-3">
                                                                <div class="card">
                                                                    <div class="d-flex align-items-center gap-2" >
                                                                        <div>
                                                                            <span>
                                                                               @if(isset($ad_options) && is_array($ad_options) && isset($ad_options[$option]))
                                                                                <img width="20px" src="{{ theme_asset('assets/img/svg/checkbox-' . $ad_options[$option] . '.png') }}" alt="">
                                                                                @endif
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3" >
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="" >
                                <div class="d-flex align-items-start justify-content-between" >
                                    <div class="d-flex align-items-center mb-3" >
                                        <div>
                                            <img width="65px" class="rounded" src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8dXNlcnxlbnwwfHwwfHx8MA%3D%3D" alt="user-image">
                                        </div>
                                        <div class="mx-3">
                                            <h5 class="mb-1">{{$customer_detail->f_name}} {{$customer_detail->l_name}}</h5>
                                            <p class="fs-12 m-0">{{translate('Joined')}} {{date('M, Y',strtotime($customer_detail->created_at))}}</p>
                                            <p class="fs-12">({{$customer_detail->created_at->diffForHumans()}})</p>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="#" class="btn btn-primary btn-sm px-2" >
                                            <i class="bi bi-person-circle"></i>
                                            {{ translate('profile') }}
                                        </a>
                                    </div>
                                </div>

                                <div>
                                    <h6 class="mb-3" style="font-weight: 500;" ><i class="bi bi-geo-alt"></i> Amesterdam, netherland</h6>

                                    <a href="show" style="text-decoration: underline;">
                                        <h6 class="mb-3" style="font-weight: 500;" >{{ translate('show_all_ads_of_this_user') }}</h6>
                                    </a>

                                    <p style="background: #0f407ddb;font-weight: 400;border-radius: 4px;" class="p-2 text-light" >This seller is an individual and does not represent any private ad sales company.</p>
                                </div>

                                <div class="mt-5 mb-4 pb-2">
                                    @php($guest_checkout=\App\CPU\Helpers::get_business_settings('guest_checkout'))
                                        <button style="background: #0d6efd;font-size: 15px;margin-bottom: 11px;" 
                                            onclick="get_email_address('example@test.com', this)"
                                            class="btn buy-now-btn-hover py-3 px-2 w-100 text-white" >
                                            <i class="bi bi-envelope-fill me-1"></i>
                                            {{translate('Email_address')}}
                                        </button>
                                        <button style="background: #25D366; font-size: 15px;margin-bottom: 11px;"
                                        onclick="get_phone_number('123456789', this)"
                                        class="btn buy-now-btn-hover py-3 px-2 w-100 text-white">
                                        <i class="bi bi-whatsapp me-1"></i>
                                        {{translate('WhatApp_number')}}
                                    </button>

                                    @if (auth('customer')->check())
                                        <button style="font-size: 15px;" class="btn primary-blue-bg-color buy-now-btn-hover mb-2 py-3 px-2 w-100 text-white" 
                                        data-bs-toggle="modal" data-bs-target="#contact_sellerModal">
                                            <i class="bi bi-chat-square-fill"></i> 
                                            {{translate('Chat_with_Seller')}}
                                        </button>
                                    @else
                                        <button style="font-size: 15px;" class="btn primary-blue-bg-color buy-now-btn-hover p-auto px-2 w-100 text-white" 
                                        data-bs-toggle="modal" data-bs-target="#loginModal">
                                            <i class="bi bi-chat-square-fill"></i> 
                                            {{translate('Chat_with_Seller')}}
                                        </button>
                                    @endif
                                </div>

                                <div class="card order-1 order-sm-0 mt-5">
                                    <div class="card-body p-0">
                                        <h5 class="mb-3">{{translate('More_from_the_Store')}}</h5>

                                        <div class="d-flex flex-wrap gap-3">
                                            @if ($more_ads_from_user->count()>0)
                                                @foreach($more_ads_from_user as $key => $item)
                                                    <div class="card border-primary-light transparent-shadow-hover flex-grow-1">
                                                        <a href="{{route('ads-show',$item->slug)}}"
                                                        class="media align-items-centr gap-3 p-2">
                                                            <div class="avatar" style="--size: 4.375rem">
                                                                <img
                                                                    src="https://img.freepik.com/free-photo/organic-cosmetic-product-with-dreamy-aesthetic-fresh-background_23-2151382816.jpg"
                                                                    alt=""
                                                                    class="img-fit dark-support rounded img-fluid overflow-hidden"
                                                                    onerror="this.src='img.freepik.com/free-photo/organic-cosmetic-product-with-dreamy-aesthetic-fresh-background_23-2151382816.jpg'">
                                                            </div>
                                                            @php($item_review = \App\CPU\ProductManager::get_overall_rating($item->reviews))

                                                            <div class="media-body d-flex flex-column justify-content-center gap-1">
                                                                <h6 class="text-capitalize">{{ Str::limit($item['name'], 18) }}</h6>
                                                                <span class="mb-2" >{{ $ad->brand->name }}</span>
                                                                <div class="d-flex align-items-center justify-content-between" >
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <div class="star-rating text-gold fs-12">
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                @if ($i <= (int)$item_review[0])
                                                                                    <i class="bi bi-star-fill"></i>
                                                                                @elseif ($item_review[0] != 0 && $i <= (int)$item_review[0] + 1.1 && $item_review[0] > ((int)$item_review[0]))
                                                                                    <i class="bi bi-star-half"></i>
                                                                                @else
                                                                                    <i class="bi bi-star"></i>
                                                                                @endif
                                                                            @endfor
                                                                        </div>
                                                                        <span>({{$item->reviews_count}})</span>
                                                                    </div>
                                                                    <div class="product__price text-end">
                                                                        <ins class="product__new-price currency-font">
                                                                            {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($ad->price))}}
                                                                        </ins>
                                                                    </div>
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

                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <nav>
                                <div class="nav justify-content-center gap-4 nav--tabs" id="nav-tab" role="tablist">
                                    <button class="active" id="product-details-tab" data-bs-toggle="tab"
                                            data-bs-target="#product-details" type="button" role="tab"
                                            aria-controls="product-details"
                                            aria-selected="true">{{translate('Product_Details')}}</button>
                                    <button id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                            type="button" role="tab" aria-controls="reviews"
                                            aria-selected="false">{{translate("reviews")}}</button>
                                </div>
                            </nav>
                            <div class="tab-content mt-3" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="product-details" role="tabpanel"
                                        aria-labelledby="product-details-tab" tabindex="0">
                                    <div class="details-content-wrap custom-height ov-hidden show-more--content active">
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead class="table-light">
                                                <tr>
                                                    <div class="border-0 dashed-border-important text-dark rounded bg-light custom-padding-0-9-rem fw-bold">{{translate('details_Description')}}</div>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        @if($ad->video_url != null && (str_contains($ad->video_url, "youtube.com/embed/")))
                                                            <div class="col-12 mb-4 text-center">
                                                                <iframe width="560" height="315"
                                                                        src="{{$product->video_url}}">
                                                                </iframe>
                                                            </div>
                                                        @endif
                                                        {!! $ad->description !!}
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-2">
                                        <button
                                            class="btn btn-outline-primary see-more-details">{{translate('see_more')}}</button>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab"
                                        tabindex="0">
                                    <div class="details-content-wrap custom-height ov-hidden show-more--content active">
                                        <div class="row gy-4">
                                            <div class="col-lg-5">
                                                <div class="rating-review mx-auto text-center mb-30">
    
                                                    @if(count($ad->reviews)==0)
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h6 class="text-danger text-center m-0">{{translate('product_review_not_available')}}</h6>
                                                            </div>
                                                        </div>
                                                    @endif
    
                                                    <h2 class="rating-review__title"><span
                                                            class="rating-review__out-of">{{round($overallRating[0], 1)}}</span>/5
                                                    </h2>
                                                    <div class="rating text-gold mb-2">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= (int)$overallRating[0])
                                                                <i class="bi bi-star-fill"></i>
                                                            @elseif ($overallRating[0] != 0 && $i <= (int)$overallRating[0] + 1.1 && $overallRating[0] > ((int)$overallRating[0]))
                                                                <i class="bi bi-star-half"></i>
                                                            @else
                                                                <i class="bi bi-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <div class="rating-review__info">
                                                        <span>{{$reviews_of_product->total()}} {{translate('ratings')}}</span>
                                                    </div>
                                                </div>
    
    
                                                <ul class="list-rating gap-10">
                                                    <li>
                                                        <span class="review-name">5 {{translate('star')}}</span>
    
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                    style="width: {{($rating[0] != 0?number_format($rating[0]*100 / array_sum($rating)):0)}}%"
                                                                    aria-valuenow="95" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <span class="review-name">4 {{translate('star')}}</span>
    
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                    style="width: {{($rating[1] != 0?number_format($rating[1]*100 / array_sum($rating)):0)}}%"
                                                                    aria-valuenow="35" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <span class="review-name">3 {{translate('star')}}</span>
    
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                    style="width: {{($rating[2] != 0?number_format($rating[2]*100 / array_sum($rating)):0)}}%"
                                                                    aria-valuenow="35" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <span class="review-name">2 {{translate('star')}}</span>
    
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                    style="width: {{($rating[3] != 0?number_format($rating[3]*100 / array_sum($rating)):0)}}%"
                                                                    aria-valuenow="20" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <span class="review-name">1 {{translate('star')}}</span>
    
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                    style="width: {{($rating[4] != 0?number_format($rating[4]*100 / array_sum($rating)):0)}}%"
                                                                    aria-valuenow="10" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="d-flex flex-wrap gap-3" id="product-review-list">
                                                    @foreach ($reviews_of_product as $item)
                                                        <div class="card border-primary-light flex-grow-1">
                                                            <div class="media flex-wrap align-items-centr gap-3 p-3">
                                                                <div class="avatar overflow-hidden border rounded-circle"
                                                                        style="--size: 3.437rem">
                                                                    <img
                                                                        src="https://img.freepik.com/free-photo/organic-cosmetic-product-with-dreamy-aesthetic-fresh-background_23-2151382816.jpg"
                                                                        alt=""
                                                                        class="img-fit dark-support"
                                                                        onerror="this.src='img.freepik.com/free-photo/organic-cosmetic-product-with-dreamy-aesthetic-fresh-background_23-2151382816.jpg'">
                                                                </div>
                                                                <div class="media-body d-flex flex-column gap-2">
                                                                    <div
                                                                        class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                                                                        <div>
                                                                            <h6 class="mb-1">{{isset($item->user)?$item->user->f_name:translate('User_Not_Exist')}}</h6>
                                                                            <div
                                                                                class="d-flex gap-2 align-items-center">
                                                                                <div
                                                                                    class="star-rating text-gold fs-12">
                                                                                    @for ($inc=0; $inc < 5; $inc++)
                                                                                        @if ($inc < $item->rating)
                                                                                            <i class="bi bi-star-fill"></i>
                                                                                        @else
                                                                                            <i class="bi bi-star"></i>
                                                                                        @endif
                                                                                    @endfor
                                                                                </div>
                                                                                <span>({{$item->rating}}/5)</span>
                                                                            </div>
                                                                        </div>
                                                                        <div>{{$item->updated_at->format("d M Y h:i:s A")}}</div>
                                                                    </div>
                                                                    <p>{{$item->comment}}</p>
    
                                                                    <div class="d-flex flex-wrap gap-2 products-comments-img">
                                                                        @foreach(json_decode($item->attachment) as $img)
                                                                            @if(file_exists(base_path("storage/app/public/review/".$img)))
                                                                                <a href="{{asset("storage/app/public/review/".$img)}}" data-lightbox="">
                                                                                    <img src="https://img.freepik.com/free-photo/organic-cosmetic-product-with-dreamy-aesthetic-fresh-background_23-2151382816.jpg" class="remove-mask-img"
                                                                                            onerror="this.src='img.freepik.com/free-photo/organic-cosmetic-product-with-dreamy-aesthetic-fresh-background_23-2151382816.jpg'">
                                                                                </a>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-2">
                                        @if(count($ad->reviews) > 2)
                                            <button class="btn btn-outline-primary see-more-details-review m-1 view_text"
                                                onclick="seemore()"
                                                data-productid="{{$ad->id}}"
                                                data-routename="{{route('review-list-product')}}"
                                                data-afterextend="{{translate('see_less')}}"
                                                data-seemore="{{translate('see_more')}}"
                                                data-onerror="{{translate('no_more_review_remain_to_load')}}">{{translate('see_more')}}</button>
                                        @else
                                            <button class="btn btn-outline-primary see-more-details m-1">{{translate('see_more')}}</button>
                                        @endif
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
                    <h2>{{translate('similar_Products_From_Other_Stores')}}</h2>
                    <div class="swiper-nav d-flex gap-2 align-items-center">
                        <div class="swiper-button-prev top-rated-nav-prev position-static rounded-10"></div>
                        <div class="swiper-button-next top-rated-nav-next position-static rounded-10"></div>
                    </div>
                </div>
                <div class="swiper-container">
                    <!-- Swiper -->
                    <div class="position-relative">
                        <div class="swiper" data-swiper-loop="false" data-swiper-margin="20" data-swiper-autoplay="true"
                             data-swiper-pagination-el="null" data-swiper-navigation-next=".top-rated-nav-next"
                             data-swiper-navigation-prev=".top-rated-nav-prev"
                             data-swiper-breakpoints='{"0": {"slidesPerView": "1"}, "320": {"slidesPerView": "2"}, "992": {"slidesPerView": "3"}, "1200": {"slidesPerView": "4"}, "1400": {"slidesPerView": "5"}}'>
                            <div class="swiper-wrapper">
                                @if (count($relatedads)>0)
                                    @foreach($relatedads as $key=>$product)
                                        <div class="swiper-slide">
                                            {{--
                                                @include('theme-views.partials._similar-product-large-card',['product'=>$product])
                                            --}}
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card w-100 px-3 py-3 dashed-border rounded">
                                        <h5 class="text-muted">{{translate('no_similar_products_found')}}</h5>
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

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    <script>
        $('.remove-mask-img').on('click', function(){
            $('.show-more--content').removeClass('active')
        })

        function get_phone_number(phone_number, element) {
            const originalHTML = '<i class="bi bi-whatsapp me-1"></i> WhatApp Number';

            element.innerHTML = '<i class="bi bi-whatsapp me-1"></i> ' + phone_number;

            navigator.clipboard.writeText(phone_number).then(() => {
                toastr.success('Phone number copied to clipboard!');

                // Revert after 3 seconds
                setTimeout(() => {
                    element.innerHTML = originalHTML;
                }, 3000);
            }).catch(() => {
                toastr.error('Failed to copy phone number.');
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
                toastr.success('Email Address copied to clipboard!');

                // Revert after 3 seconds
                setTimeout(() => {
                    element.innerHTML = originalHTML;
                }, 3000);
            }).catch(() => {
                toastr.error('Failed to copy email address.');
            });
        }

    </script>

    <script>
        getVariantPrice();
    </script>

    <script src="{{ theme_asset('assets/js/lightbox.min.js') }}"></script>
    <script src="{{ theme_asset('assets/plugins/easyzoom/easyzoom.min.js') }}"></script>
    <script>
        $(".easyzoom").each(function () {
            $(this).easyZoom();
        });

    </script>
@endpush

@extends('theme-views.layouts.app')

@section('title', $ad['name'].' | '.$web_config['name']->value.' '.translate('ecommerce'))


@push('css_or_js')
    <meta name="description" content="{{$ad->slug}}">
    <meta name="keywords" content="@foreach(explode(' ',$ad['name']) as $keyword) {{$keyword.' , '}} @endforeach">
    <meta name="author" content="{{$web_config['name']->value}}">
    <!-- Viewport-->

    @if($ad['meta_image'])
        <meta property="og:image" content="{{asset("public/storage/ad/meta")}}/{{$ad->meta_image}}"/>
        <meta property="twitter:card"
              content="{{asset("public/storage/ad/meta")}}/{{$ad->meta_image}}"/>
    @else
        <meta property="og:image" content="{{asset("public/storage/ad/thumbnail")}}/{{$ad->thumbnail}}"/>
        <meta property="twitter:card"
              content="{{asset("public/storage/ad/thumbnail/")}}/{{$ad->thumbnail}}"/>
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
                                <div class="mb-4" >
                                    <div class="d-flex align-items-start justify-content-between" >
                                        <div>
                                            <h2 class="product_title mb-3">{{$ad->title}}</h2>
                                            <div class="d-flex align-items-center gap-3" >
                                                <h6 class="">
                                                    <span class="bg-primary py-2 px-2 rounded text-light">
                                                        <i class="bi bi-tags-fill"></i>
                                                        {{$ad->category->name}}
                                                    </span>
                                                </h6>
                                                <div class="d-flex align-items-center gap-1 mt-1 text-primary" >
                                                    <span><i class="bi bi-eye fs-16" ></i></span>
                                                    <span class="fs-16" >{{$ad_views_number}}</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-1 mt-1 text-primary" >
                                                    <span><i class="bi bi-suit-heart fs-16"></i></span>
                                                    <span id="ad-wishlist-count" class="fs-16" >{{$ad->wish_list->count()}}</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-1 mt-1 text-primary" >
                                                    <span><i class="bi bi-calendar-event fs-16"></i></i></span>
                                                    <span class="fs-16" >{{ $ad->created_at->translatedFormat('d F Y H:i') }} ({{ $ad->created_at->diffForHumans() }})</span>
                                                </div>
                                            </div>
                                        </div>
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
                                        </div>
                                    </div>
                                </div>

                                <div class="row gy-4 d-flex align-items-stretch">
                                    <div class="col-lg-8">
                                        <!-- Product Details Image Wrap -->
                                        <div class="pd-img-wrap position-relative h-100">
                                            <div class="swiper-container quickviewSlider2 border rounded aspect-0"
                                            style="--bs-border-color: #d6d6d6">
                                                @if($ad->images!=null && json_decode($ad->images)>0)
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide position-relative w-100">
                                                            <div class="easyzoom easyzoom--overlay">
                                                                <a class="w-100"  href="{{asset("public/storage/ad/thumbnail/".$ad->thumbnail)}}">
                                                                    <img style="height: 415px; width: 100%;" src="{{asset("public/storage/ad/thumbnail/".$ad->thumbnail)}}" class="dark-support" alt="">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        @foreach (json_decode($ad->images) as $key => $photo)
                                                            <div class="swiper-slide position-relative w-100">
                                                                <div class="easyzoom easyzoom--overlay">
                                                                    <a class="w-100"  href="{{asset("public/storage/ad/".$photo)}}">
                                                                        <img style="height: 415px; width: 100%;" src="{{asset("public/storage/ad/".$photo)}}" class="dark-support" alt="">
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
                                                            <div class="swiper-slide position-relative aspect-1">
                                                                <img src="{{asset("public/storage/ad/thumbnail/".$ad->thumbnail)}}" class="dark-support rounded" alt="">
                                                            </div>
                                                            @foreach (json_decode($ad->images) as $key => $photo)
                                                                <div class="swiper-slide position-relative aspect-1">
                                                                    <img src="{{asset("public/storage/ad/".$photo)}}" class="dark-support rounded" alt="">
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

                                    <div class="col-lg-4 h-100">
                                        <!-- Product Details Content -->
                                        <div class="product-details-content position-relative">                                            
                                            <div class="d-flex align-items-center justify-content-between mb-2 mt-2" >
                                                <div class="d-flex flex-column gap-1" >
                                                    <div class="d-flex gap-2 flex-wrap align-items-center">
                                                        <h5 class="fw-bold">{{translate('brand')}} :</h5>
                                                        <div class="d-flex align-items-center" >
                                                            <span class="mx-1" >{{$ad->brand->name ?? '/'}}</span>
                                                        </div>
                                                    </div>
    
                                                    <div class="d-flex gap-2 flex-wrap align-items-center">
                                                        <h5 class="fw-bold">{{translate('model')}} :</h5>
                                                        <div class="d-flex align-items-center" >
                                                            <span class="mx-1" >{{$ad->model->name ?? '/'}}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    @if($ad->color)
                                                        <div class="d-flex gap-2 flex-wrap align-items-center">
                                                            <h5 class="fw-bold">{{translate('ad_color')}} :</h5>
                                                            <div class="d-flex align-items-center" >
                                                                <span style="width: 15px; height: 15px;border-radius: 2px;background: {{$ad->color}};" ></span>
                                                                <span class="mx-1" >({{$ad->color}})</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <img class="rounded border" 
                                                        width="70px" 
                                                        src="{{ theme_asset('assets/img/svg/example-brand-image.jpg') }}" 
                                                        alt="">
                                                </div>
                                            </div>
                                            
                                            
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
                                                    <div class="col-md-6 mb-3">
                                                        <div class="card">
                                                            <div class="d-flex align-items-center gap-2" >
                                                                <div>
                                                                    <span>
                                                                        <img width="25px" src="{{ theme_asset('assets/img/svg/status.png') }}" alt="">
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <h5>{{ translate('status') }}</h5>
                                                                    <span>{{ str_replace('_', ' ', $ad->ad_status) }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($ad->year)
                                                    <div class="col-md-6 mb-3">
                                                        <div class="card">
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

                                                @if($ad->body_type)
                                                    <div class="col-md-6 mb-3">
                                                        <div class="card">
                                                            <div class="d-flex align-items-center gap-2" >
                                                                <div>
                                                                    <span>
                                                                        <img width="25px" src="{{ theme_asset('assets/img/svg/body-types.svg') }}" alt="">
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <h5>{{ translate('body_type') }}</h5>
                                                                    <span>{{ $ad->body_type }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($ad->mileage)
                                                    <div class="col-md-6 mb-3">
                                                        <div class="card">
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
                                                    <div class="col-md-6 mb-3">
                                                        <div class="card">
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

                                                @if($ad->engine_cylinders)
                                                    <div class="col-md-6 mb-3">
                                                        <div class="card">
                                                            <div class="d-flex align-items-center gap-2" >
                                                                <div>
                                                                    <span>
                                                                        <img width="25px" src="{{ theme_asset('assets/img/svg/cylinder.svg') }}" alt="">
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <h5>{{ translate('engine_cylinders') }}</h5>
                                                                    <span>{{ $ad->engine_cylinders }} {{ translate('cylinder') }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($ad->engine_power)
                                                    <div class="col-md-6 mb-3">
                                                        <div class="card">
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

                                                @if($ad->fuel_type)
                                                    <div class="col-md-6 mb-3">
                                                        <div class="card">
                                                            <div class="d-flex align-items-center gap-2" >
                                                                <div>
                                                                    <span>
                                                                        <img width="25px" src="{{ theme_asset('assets/img/svg/fuel-type.svg') }}" alt="">
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <h5>{{ translate('fuel_type') }}</h5>
                                                                    <span>{{ $ad->fuel_type }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            
                                            
                                            
                                            
                                            

                                            {{--
                                                @include('theme-views.layouts.partials.modal._chat-with-seller',['seller_id'=>$product->seller->id,'shop_id'=>$product->seller->shop->id])
                                            --}}
                                        </div>
                                        <!-- End Product Details Content -->
                                    </div>
                                    
                                    <div class="mt-4" >
                                        <h3 class="my-4" >{{translate('description')}}</h3>
                                        @if($ad->video_url != null && (str_contains($ad->video_url, "youtube.com/embed/")))
                                            <div class="col-12 mb-4 text-center">
                                                <iframe width="560" height="315"
                                                    src="{{$product->video_url}}">
                                                </iframe>
                                            </div>
                                        @endif
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
                                                            @endif
                                                        
                                                            @if($ad->width)
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
                                                            @endif
                                                        
                                                            @if($ad->length)
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
                                                            @endif
                                                        
                                                        
                                                            @if($ad->bag_capacity)
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
                                                            @endif
                                                        
                                                        
                                                            @if($ad->weight)
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="card">
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
                                                                <div class="col-md-3 mb-3">
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
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="card">
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
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="card">
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
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="card">
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
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="card">
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
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="card">
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
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="card">
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
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="card">
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
                                        @if($ad->category->is_vehicle == 1)
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
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="card">
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
                                            <h5 class="mb-1">{{$ad->user->f_name}} {{$ad->user->l_name}}</h5>
                                            <p class="fs-12 m-0">{{translate('Joined')}} {{date('M, Y',strtotime($ad->user->created_at))}}</p>
                                            <p class="fs-12">({{$ad->user->created_at->diffForHumans()}})</p>
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
                                    <a href="show" style="text-decoration: underline;">
                                        <h6 class="mb-3" style="font-weight: 500;" >{{ translate('show_all_ads_of_this_user') }}</h6>
                                    </a>

                                    <p style="background: #0f407ddb;font-weight: 400;border-radius: 4px;" class="p-2 text-light" >This seller is an individual and does not represent any private ad sales company.</p>
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

                                @if($ad->price_type == 'auction')
                                    @if($ad->auctions->count() > 0)
                                        <div class="mb-3" >
                                            <div class="card rounded border" style="--bs-border-color: #d6d6d6">
                                                <div class="card-header" style="background: #0f407ddb;">
                                                    <span class="fw-medium text-light" >{{ translate('latest_offers') }}</span>
                                                </div>
                                                <div class="card-body p-3 pb-0">
                                                    <div class="row" >
                                                        @foreach($ad->auctions->sortByDesc('created_at')->take(5) as $auction)
                                                            <div class="d-flex align-items-center @if(!$loop->last) border-bottom @endif justify-content-between pb-2 mb-2" >
                                                                <div class="d-flex align-items-center gap-2" >
                                                                    <div>
                                                                        <span><i class="bi bi-person" style="font-size: 22px;" ></i></span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="fw-medium d-block fs-13" >{{$auction->user->f_name}} {{$auction->user->l_name}}</span>
                                                                        <span class="fw-bold fs-13" >\App\CPU\BackEndHelper::usd_to_currency($auction->price)}}</span>
                                                                    </div>

                                                                </div>
                                                                <div>
                                                                    <span class="fw-normal d-block fs-12" >{{$auction->created_at->format('Y-m-d')}}</span>
                                                                    <span class="fw-normal d-block fs-12" >{{$auction->created_at->toTimeString()}}</span>

                                                                </div>
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

                                    @if(auth('customer')->check())
                                        <div class="mb-4" >
                                            <form action="{{ route('ads-store-auction') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$ad->id}}">
                                                <div class="form-group mb-3">
                                                    <label for="price">{{translate('add_an_offer')}}</label>
                                                    <input type="number"  id="price" value="{{old('price')}}"
                                                    class="form-control" value="{{old('price')}}" 
                                                    name="price" placeholder="{{translate('price')}}">
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" style="font-size: 15px;" class="btn primary-blue-bg-color 
                                                    buy-now-btn-hover mb-2 py-3 px-2 w-100 text-white" >
                                                        <i class="bi bi-hammer"></i> 
                                                        {{translate('send_the_offer')}}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                @endif
                                
                                @if($ad->price_type == 'asking_price')
                                    @if(auth('customer')->check())
                                        <div class="mb-4" >
                                            <form action="{{ route('ads-store-asking-price') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$ad->id}}">
                                                <div class="form-group mb-3">
                                                    <label for="price">{{translate('auction')}}</label>
                                                    <input type="number"  id="price" value="{{old('price')}}"
                                                    class="form-control" value="{{old('price')}}" 
                                                    name="price" placeholder="{{translate('price')}}">
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" style="font-size: 15px;" class="btn primary-blue-bg-color 
                                                    buy-now-btn-hover mb-2 py-3 px-2 w-100 text-white" >
                                                        <i class="bi bi-hammer"></i> 
                                                        {{translate('send_the_offer')}}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                @endif
                                
                                <div>
                                    <h6 class="mb-3" style="font-weight: 500;" ><i class="bi bi-geo-alt"></i>{{$ad->country}}{{$ad->state !== $ad->city ? ', '.$ad->city : ''}}</h6>
                                    <div>
                                        <img class="rounded" src="{{ theme_asset('assets/img/svg/example-map.png') }}" alt="map-image">
                                    </div>
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
                                                            <div class="avatar" style="--size: 5.375rem">
                                                                <img
                                                                    src="{{asset("public/storage/ad/thumbnail/".$item->thumbnail)}}"
                                                                    alt=""
                                                                    class="img-fit dark-support rounded img-fluid overflow-hidden"
                                                                    onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'">
                                                            </div>
                                                            @php($item_review = \App\CPU\ProductManager::get_overall_rating($item->reviews))

                                                            <div class="media-body d-flex flex-column justify-content-center gap-0">
                                                                <h6 class="text-capitalize mb-1">{{ Str::limit($item['title'], 24) }}</h6>
                                                                <span><i class="bi bi-person" ></i> {{ $ad->user->f_name }} {{ $ad->user->l_name }}</span>
                                                                <h6 class="text-primary" >{{$ad->category->name}}</h6>
                                                                <div class="product__price text-end">
                                                                    <ins class="product__new-price currency-font">
                                                                        @if($ad->price_type == 'fixed_price')
                                                                            {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($ad->price))}}
                                                                        @elseif($ad->price_type == 'free')
                                                                            <span class="fs-18 fw-medium" >{{ translate('free') }}</span>
                                                                        @elseif($ad->price_type == 'asking_price')
                                                                            <span class="fw-medium" >
                                                                                <span>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($ad->starting_price))}}</span>
                                                                            </span>
                                                                        @elseif($ad->price_type == 'auction')
                                                                            <span class="fs-18 fw-medium" >
                                                                                {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($ad->auctions()->latest()->value('price')))}}</span>
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
                    <h2>{{translate('similar_Products_From_Other_Stores')}}</h2>
                    <div class="swiper-nav d-flex gap-2 align-items-center">
                        <div class="swiper-button-prev top-rated-nav-prev position-static rounded-10"></div>
                        <div class="swiper-button-next top-rated-nav-next position-static rounded-10"></div>
                    </div>
                </div>
                <div class="swiper-container">
                    <!-- Swiper -->
                    <div class="position-relative">
                        <div class="similar-ads-swiper py-2 product-card-shadow" data-swiper-loop="false" data-swiper-margin="20" data-swiper-autoplay="true"
                             data-swiper-pagination-el="null" data-swiper-navigation-next=".top-rated-nav-next"
                             data-swiper-navigation-prev=".top-rated-nav-prev"
                             data-swiper-breakpoints='
                                {"0": {"slidesPerView": "1"},
                                "320": {"slidesPerView": "2"},
                                "992": {"slidesPerView": "3"},
                                "1200": {"slidesPerView": "4"},
                                "1400": {"slidesPerView": "4"}},
                                "1900": {"slidesPerView": "5"}}'
                            >
                            <div class="swiper-wrapper">
                                @if (count($relatedAds)>0)
                                    @foreach($relatedAds as $key=>$product)
                                        <div class="swiper-slide">
                                            @include('theme-views.partials._product-large-card',['ad'=>$ad])
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card w-100  rounded">
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
        const swiper = new Swiper('.similar-ads-swiper', {
            slidesPerView: 5,       // Show 3 slides at once
            spaceBetween: 20,       // Space between slides
            slidesPerGroup: 1,      // Move one slide at a time
            loop: false,            // No looping
            navigation: false,      // No navigation arrows
            speed: 1200,
            autoplay: {
                delay: 10000,          // 6 seconds between each slide
                disableOnInteraction: false,  // Keep autoplay even after user interaction
                pauseOnMouseEnter: true, 
            },
        });
    </script>


    <script>
        $('.remove-mask-img').on('click', function(){
            $('.show-more--content').removeClass('active')
        })

        function get_phone_number(phone_number, element) {
            const originalHTML = '<i class="bi bi-telephone me-1"></i> {{translate('phone_number')}}';

            element.innerHTML = '<i class="bi bi-telephone me-1"></i> ' + phone_number;

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
        
        function get_phone_number_and_whatsapp(phone_number, element) {
            const originalHTML = '<i class="bi bi-whatsapp me-1"></i> {{translate('whatsapp_number')}}';

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

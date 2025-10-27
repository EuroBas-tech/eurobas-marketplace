@extends('theme-views.layouts.app')

@section('title', $product['name'].' | '.$web_config['name']->value.' '.translate('ecommerce'))

@push('css_or_js')
    <meta name="description" content="{{$product->slug}}">
    <meta name="keywords" content="@foreach(explode(' ',$product['name']) as $keyword) {{$keyword.' , '}} @endforeach">
    @if($product->added_by=='seller')
        <meta name="author" content="{{ $product->seller->shop?$product->seller->shop->name:$product->seller->f_name}}">
    @elseif($product->added_by=='admin')
        <meta name="author" content="{{$web_config['name']->value}}">
    @endif
    <!-- Viewport-->

    @if($product['meta_image'])
        <meta property="og:image" content="{{asset("storage/app/public/product/meta")}}/{{$product->meta_image}}"/>
        <meta property="twitter:card"
              content="{{asset("storage/app/public/product/meta")}}/{{$product->meta_image}}"/>
    @else
        <meta property="og:image" content="{{asset("storage/app/public/product/thumbnail")}}/{{$product->thumbnail}}"/>
        <meta property="twitter:card"
              content="{{asset("storage/app/public/product/thumbnail/")}}/{{$product->thumbnail}}"/>
    @endif

    @if($product['meta_title'])
        <meta property="og:title" content="{{$product->meta_title}}"/>
        <meta property="twitter:title" content="{{$product->meta_title}}"/>
    @else
        <meta property="og:title" content="{{$product->name}}"/>
        <meta property="twitter:title" content="{{$product->name}}"/>
    @endif
    <meta property="og:url" content="{{route('product',[$product->slug])}}">

    @if($product['meta_description'])
        <meta property="twitter:description" content="{!! $product['meta_description'] !!}">
        <meta property="og:description" content="{!! $product['meta_description'] !!}">
    @else
        <meta property="og:description"
              content="@foreach(explode(' ',$product['name']) as $keyword) {{$keyword.' , '}} @endforeach">
        <meta property="twitter:description"
              content="@foreach(explode(' ',$product['name']) as $keyword) {{$keyword.' , '}} @endforeach">
    @endif
    <meta property="twitter:url" content="{{route('product',[$product->slug])}}">
    <link rel="stylesheet" href="{{ theme_asset('assets/css/lightbox.min.css') }}">
    
    <style>
        .custom-cool-blue {
            background: #4285F4;
        }
        .custom-green {
            background: #34A853;
        }

        .countries-style {
            width: 16rem;
        }
        .price-size {
            font-size: 35px !important;
        }
        .custom-responsive-display {
            display: flex;
            align-items: start;
            justify-content: space-between;
        }
        
        .small-responsive-margin-top {
            margin-top: -50px;
        }

        .responsive-margin-top {
            margin-top: -60px;
        }

        @media (max-width: 576px) {
            .price-size {
                font-size: 24px !important;
            }
            .custom-responsive-display {
                display: block !important;
            }
            
            .countries-style {
                margin-bottom: 8px;
            }
            
            .responsive-margin-top {
                margin-top: 0px !important;
            }
            
            .small-responsive-margin-top {
                margin-top: 0px !important;
            }


        }
        button.btn.remove-default-hover:hover {
            background-color: inherit !important;
            color: inherit !important;
            box-shadow: none !important;
            border-color: inherit !important;
            text-decoration: none !important;
        }
        
        .custom-chat-btn {
            background: #4285F4 !important;
        }
        .custom-chat-btn:hover {
            opacity: 90% !important;
            transation: 0.5s;
        }
        
.countries-scroll {
  max-height: 55px;
  overflow-y: auto;
  padding-left: 15px;

  /* Firefox */
  scrollbar-width: thin;
  scrollbar-color: white #0000002e;
}

/* WebKit (Chrome, Safari, Edge) */
.countries-scroll::-webkit-scrollbar {
  width: 6px;
}

.countries-scroll::-webkit-scrollbar-track {
  background: gray; /* scrollbar background */
}

.countries-scroll::-webkit-scrollbar-thumb {
  background-color: white; /* scrollbar thumb */
  border-radius: 10px;
}

.countries-scroll::-webkit-scrollbar-thumb:hover {
  background: #eee;
}

    </style>        
    
@endpush

@section('content')
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 pt-3 mb-sm-5">
        <div class="container">
            <div class="row gx-3 gy-4">
                <div class="col-lg-12 col-xl-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="quickview-content">
                                <div class="row gap-4">
                                    <div class="col-lg-7" style="max-width:640px;">

                                        <div class="mb-3">
                                            <h2 class="product_title mb-2">{{$product->name}}</h2>

                                            <div class="d-flex gap-2 align-items-center mb-2">
                                                <div class="star-rating text-gold fs-12">
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
                                                <span>({{$product->reviews_count}})</span>
                                            </div>
                                        </div>

                                        <!-- Product Details Image Wrap -->
                                        <div class="pd-img-wrap position-relative h-100">
                                            <div class="swiper-container quickviewSlider2 border-0 aspect-0"
                                                 style="--bs-border-color: #d6d6d6;border-radius: 12px;">
                                                <div class="product__actions d-flex flex-column gap-2">
                                                    <a onclick="addWishlist('{{$product['id']}}','{{route('store-wishlist')}}')"
                                                       id="wishlist-{{$product['id']}}"
                                                       class="btn-wishlist add_to_wishlist cursor-pointer wishlist-{{$product['id']}} {{($wishlist_status == 1?'wishlist_icon_active':'')}}"
                                                       title="{{translate('add_to_wishlist')}}">
                                                        <i class="bi bi-heart"></i>
                                                    </a>
                                                    <a onclick="addCompareList('{{$product['id']}}','{{route('store-compare-list')}}')"
                                                    id="compare_list-{{$product['id']}}"
                                                       class="btn-compare stopPropagation add_to_compare compare_list-{{$product['id']}} {{($compare_list == 1?'compare_list_icon_active':'')}}"
                                                       title="{{translate('add_to_wishlist')}}">
                                                        <i class="bi bi-repeat"></i>
                                                    </a>
                                                    <div class="product-share-icons">
                                                        <a href="javascript:" title="Share">
                                                            <i class="bi bi-share-fill"></i>
                                                        </a>

                                                        <ul>
                                                            <li style="margin-block-end: 0;" >
                                                                <a href="javascript:"
                                                                   onclick="shareOnFacebook('{{route('product',$product->slug)}}', 'facebook.com/sharer/sharer.php?u='); return false;">
                                                                    <i class="bi bi-facebook"></i>
                                                                </a>
                                                            </li>
                                                            <li style="margin-block-end: 0;" >
                                                                <a href="javascript:"
                                                                   onclick="shareOnFacebook('{{route('product',$product->slug)}}', 'twitter.com/intent/tweet?text='); return false;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                                                                        <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z"/>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li style="margin-block-end: 0;" >
                                                                <a href="javascript:"
                                                                   onclick="shareOnFacebook('{{route('product',$product->slug)}}', 'linkedin.com/shareArticle?mini=true&url='); return false;">
                                                                    <i class="bi bi-linkedin"></i>
                                                                </a>
                                                            </li>
                                                            <li style="margin-block-end: 0;" >
                                                                <a href="javascript:"
                                                                   onclick="shareOnFacebook('{{route('product',$product->slug)}}', 'api.whatsapp.com/send?text='); return false;">
                                                                    <i class="bi bi-whatsapp"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                @if($product->images!=null && json_decode($product->images)>0)
                                                    <div class="swiper-wrapper">
                                                        @if(json_decode($product->colors) && $product->color_image)
                                                            @foreach (json_decode($product->color_image) as $key => $photo)
                                                                @if($photo->color != null)
                                                                    <div class="swiper-slide position-relative w-100" id="preview-box-{{ $photo->color }}">
                                                                        <div class="easyzoom easyzoom--overlay">
                                                                            @if ($product->discount > 0 && $product->discount_type === "percent")
                                                                                <span class="product__discount-badge">-{{$product->discount}}%</span>
                                                                            @elseif($product->discount > 0)
                                                                                <span class="product__discount-badge currency-font">-{{\App\CPU\Helpers::currency_converter($product->discount)}}</span>
                                                                            @endif

                                                                            <a href="{{asset("storage/app/public/product/".$photo->image_name)}}">
                                                                                <img style="height: 415px; width: 100%;" src="{{asset("storage/app/public/product/".$photo->image_name)}}" class="dark-support" alt="" onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="swiper-slide position-relative w-100" id="preview-box-{{ $photo->color }}">
                                                                        <div class="easyzoom easyzoom--overlay">
                                                                            @if ($product->discount > 0 && $product->discount_type === "percent")
                                                                                <span class="product__discount-badge">-{{$product->discount}}%</span>
                                                                            @elseif($product->discount > 0)
                                                                                <span class="product__discount-badge currency-font">-{{\App\CPU\Helpers::currency_converter($product->discount)}}</span>
                                                                            @endif
                                                                            <a href="{{asset("storage/app/public/product/".$photo->image_name)}}">
                                                                                <img style="height: 415px; width: 100%;" src="{{asset("storage/app/public/product/".$photo->image_name)}}" class="dark-support" alt="" onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'" >
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            @foreach (json_decode($product->images) as $key => $photo)
                                                                <div class="swiper-slide position-relative w-100">
                                                                    <div class="easyzoom easyzoom--overlay">
                                                                        @if ($product->discount > 0 && $product->discount_type === "percent")
                                                                            <span class="product__discount-badge">-{{$product->discount}}%</span>
                                                                        @elseif($product->discount > 0)
                                                                            <span class="product__discount-badge currency-font">-{{\App\CPU\Helpers::currency_converter($product->discount)}}</span>
                                                                        @endif
                                                                        <a class="w-100" href="{{asset("storage/app/public/product/".$photo)}}">
                                                                            <img src="{{asset("storage/app/public/product/".$photo)}}" onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'" class="dark-support" alt="" style="height: 415px; width: 100%;" >
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="mt-2 user-select-none">
                                                <div class="quickviewSliderThumb2 swiper-container position-relative ">
                                                    @if($product->images!=null && json_decode($product->images)>0)
                                                        <div class="swiper-wrapper auto-item-width justify-content-center" style="--width: 4rem; --bs-border-color: #d6d6d6">
                                                            @if(json_decode($product->colors) && $product->color_image)
                                                                @foreach (json_decode($product->color_image) as $key => $photo)
                                                                    @if($photo->color != null)
                                                                        <div class="swiper-slide position-relative aspect-1">
                                                                            <img src="{{asset("storage/app/public/product/".$photo->image_name)}}" onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'" class="dark-support rounded" alt="">
                                                                        </div>
                                                                    @endif
                                                                @endforeach

                                                                @foreach (json_decode($product->color_image) as $key => $photo)
                                                                    @if($photo->color == null)
                                                                        <div class="swiper-slide position-relative aspect-1">
                                                                            <img src="{{asset("storage/app/public/product/".$photo->image_name)}}" onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'" class="dark-support rounded" alt="">
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                @foreach (json_decode($product->images) as $key => $photo)
                                                                    <div class="swiper-slide position-relative aspect-1">
                                                                        <img src="{{asset("storage/app/public/product/".$photo)}}" onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'" class="dark-support rounded" alt="">
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    @endif

                                                    <div class="swiper-button-next swiper-quickview-button-next" style="--size: 1.5rem"></div>
                                                    <div class="swiper-button-prev swiper-quickview-button-prev" style="--size: 1.5rem"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- End Product Details Image Wrap -->
                                    </div>
                                    <div class="col-lg-5 flex-grow-1">
                                        <!-- Product Details Content -->
                                        <div class="product-details-content position-relative">

                                            <div class="custom-responsive-display" >
                                                <div>
                                                    <div class="d-flex align-items-center justify-content-between mt-2 mb-4" >
                                                        <div class="" >
                                                            @if ($product->discount > 0 && $product->discount_type === "percent")
                                                                <span class="product__save-amount">{{translate('save')}} {{$product->discount}}%</span>
                                                            @elseif($product->discount > 0)
                                                                <div class="d-flex justify-content-between w-100 pt-3" >
                                                                    <span class="product__save-amount currency-font">
                                                                        {{translate('save')}} {{\App\CPU\Helpers::currency_converter($product->discount)}}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    @if(($product['product_type'] == 'physical') && ($product['current_stock']<=0))
                                                        <p class="fw-semibold text-muted custom-text-danger"><i class="bi bi-exclamation-circle me-2"></i>{{translate('out_of_stock')}}</p>
                                                    @else
                                                    @if($product['product_type'] == 'physical')
                                                            <div class="fw-semibold py-2 pb-3 d-flex align-items-center">
                                                                <svg class="me-2" fill="gray" width="15px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M290.8 48.6l78.4 29.7L288 109.5 206.8 78.3l78.4-29.7c1.8-.7 3.8-.7 5.7 0zM136 92.5l0 112.2c-1.3 .4-2.6 .8-3.9 1.3l-96 36.4C14.4 250.6 0 271.5 0 294.7L0 413.9c0 22.2 13.1 42.3 33.5 51.3l96 42.2c14.4 6.3 30.7 6.3 45.1 0L288 457.5l113.5 49.9c14.4 6.3 30.7 6.3 45.1 0l96-42.2c20.3-8.9 33.5-29.1 33.5-51.3l0-119.1c0-23.3-14.4-44.1-36.1-52.4l-96-36.4c-1.3-.5-2.6-.9-3.9-1.3l0-112.2c0-23.3-14.4-44.1-36.1-52.4l-96-36.4c-12.8-4.8-26.9-4.8-39.7 0l-96 36.4C150.4 48.4 136 69.3 136 92.5zM392 210.6l-82.4 31.2 0-89.2L392 121l0 89.6zM154.8 250.9l78.4 29.7L152 311.7 70.8 280.6l78.4-29.7c1.8-.7 3.8-.7 5.7 0zm18.8 204.4l0-100.5L256 323.2l0 95.9-82.4 36.2zM421.2 250.9c1.8-.7 3.8-.7 5.7 0l78.4 29.7L424 311.7l-81.2-31.1 78.4-29.7zM523.2 421.2l-77.6 34.1 0-100.5L528 323.2l0 90.7c0 3.2-1.9 6-4.8 7.3z"/></svg>
                                                                <span class="me-1" >{{$product->current_stock}}</span>
                                                                <span>{{translate('in_Stock')}}</span> 
                                                            </div>
                                                        @endif
                                                    @endif
                                                    <div class="product__price d-flex flex-wrap align-items-center mb-2 gap-2">
                                                        @if($product->discount > 0)
                                                            <del class="product__old-price currency-font">{{\App\CPU\Helpers::currency_converter($product->unit_price)}}</del>
                                                        @endif
                                                        <ins class="product__new-price price-size currency-font">{{\App\CPU\Helpers::get_price_range($product) }}</ins>
                                                    </div>
                                                </div>                                                
                
                                                @if($countryNames ||  $product->origin)
                                                    <div class="card order-1 order-sm-0 p-0 countries-style" >
                                                        <div class="card-body p-0">
                                                            <div class=" gap-3">
                                                                @if($product->origin )
                                                                    <div  class="custom-green rounded p-2 my-2">
                                                                        <div>
                                                                            <b class="key text-nowrap text-light">{{translate(' Origin Product ')}}</b>
                                                                            <span class="text-light" >:</span>
                                                                            <span class="value text-light">{{$product->origin}}</span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                    
                                    
                                                                @if($countryNames)
                                                                    <div  class="custom-green rounded p-2">
                                                                        <div  class="text-light"  >
                                                                            <b>
                                                                                {{translate('shipping_country')}}
                                                                            </b>
                                                                        </div>
                                                                        <div class="text-light countries-scroll" style="max-height: 100px; overflow-y: auto;padding-left: 15px; " >
                                                                            @foreach ($countryNames as  $countryNameslist)
                                                                                <div class="text-light" >{{ $countryNameslist }}</div>
                                                                                <div class="text-light" >----------</div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Add to Cart Form -->
                                            <form class="cart add_to_cart_form @if($countryNames && count($countryNames) > 1) @if(count($countryNames) == 2) small-responsive-margin-top @else responsive-margin-top @endif @endif" action="{{ route('cart.add') }}"
                                                  id="add-to-cart-form" data-redirecturl="{{route('checkout-details')}}"
                                                  data-varianturl="{{ route('cart.variant_price') }}"
                                                  data-errormessage="{{translate('please_choose_all_the_options')}}"
                                                  data-outofstock="{{translate('Sorry_Out_of_stock')}}.">
                                                @csrf
                                                <div class="">
                                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                                    @if (count(json_decode($product->colors)) > 0)
                                                        <div class="d-flex gap-4 flex-wrap align-items-center mb-3">
                                                            <h6 class="fw-bold">{{translate('color')}}</h6>
                                                            <ul class="option-select-btn custom_01_option flex-wrap weight-style--two gap-2 pt-2">
                                                                @foreach (json_decode($product->colors) as $key => $color)
                                                                    <li>
                                                                        <label>
                                                                            <input type="radio" hidden=""
                                                                                   id="{{ $product->id }}-color-{{ str_replace('#','',$color) }}"
                                                                                   name="color" value="{{ $color }}"
                                                                                {{ $key == 0 ? 'checked' : '' }}
                                                                            >
                                                                            <span
                                                                                class="color_variants color-border-radius p-0 {{ $key == 0 ? 'color_variant_active':''}}"
                                                                                style="background: {{ $color }};"
                                                                                for="{{ $product->id }}-color-{{ str_replace('#','',$color) }}"
                                                                                onclick="focus_preview_image_by_color('preview-box-{{ str_replace('#','',$color) }}')"
                                                                                id="color_variants_preview-box-{{ str_replace('#','',$color) }}"
                                                                            ></span>
                                                                        </label>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    <!--  -->
                                                    @foreach (json_decode($product->choice_options) as $key => $choice)
                                                        <div class="d-flex gap-4 flex-wrap align-items-center mb-4">
                                                            <h6 class="fw-bold">{{translate($choice->title)}}</h6>
                                                            <ul class="option-select-btn custom_01_option flex-wrap weight-style--two gap-2">
                                                                @foreach ($choice->options as $key => $option)
                                                                    <li>
                                                                        <label>
                                                                            <input type="radio" hidden=""
                                                                                   id="{{ $choice->name }}-{{ $option }}"
                                                                                   name="{{ $choice->name }}"
                                                                                   value="{{ $option }}"
                                                                                   @if($key == 0) checked @endif >
                                                                            <span>{{$option}}</span>
                                                                        </label>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endforeach
                                                    <div class="d-flex gap-4 flex-wrap align-items-center mb-4">
                                                        <h6 class="fw-bold">{{translate('quantity')}} {{ $product->minimum_order_qty >1 ? translate('(Min Order)') : ""}} </h6>

                                                        <div class="quantity quantity--style-two">
                                                            <span class="quantity__minus single_quantity__minus">
                                                                <i class="bi bi-trash3-fill text-danger fs-10"></i>
                                                            </span>
                                                            <input type="text"
                                                                   class="quantity__qty product_quantity__qty"
                                                                   name="quantity"
                                                                   value="{{ $product->minimum_order_qty ?? 1 }}"
                                                                   min="{{ $product->minimum_order_qty ?? 1 }}"
                                                                   max="{{$product['product_type'] == 'physical' ? $product->current_stock : 100}}">
                                                            <span class="quantity__plus single_quantity__plus" {{($product->current_stock == 1?'disabled':'')}}>
                                                                <i class="bi bi-plus"></i>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="mx-w" style="--width: 16rem">
                                                        <div class="bg-light dashed-border w-100 rounded p-3">
                                                            <div class="flex-between-gap-3">
                                                                <div class="">
                                                                    <h6 class="flex-middle-gap-2 mb-2">
                                                                        <span>{{translate('total_price')}} : </span>
                                                                        <span class="total_price currency-font">{{\App\CPU\Helpers::currency_converter($product->unit_price)}}</span>
                                                                    </h6>
                                                                    <h6 class="flex-middle-gap-2 mb-2">
                                                                        <span>{{translate('Tax')}} : </span>
                                                                        <span
                                                                            class="product_vat currency-font">{{ $product->tax_model == 'include' ? 'incl.' : \App\CPU\Helpers::currency_converter($product->tax)}}</span>
                                                                    </h6>
                                                                    <h6 class="flex-middle-gap-2 mb-2">
                                                                        <span>{{translate('product_unit')}} : </span>
                                                                        <span>{{$product->unit}}</span>
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="d-flex flex-wrap gap-3 my-4"
                                                         style="--width: 24rem">
                                                        @if(($product->added_by == 'seller' && ($seller_temporary_close || (isset($product->seller->shop) && $product->seller->shop->vacation_status && $current_date >= $seller_vacation_start_date && $current_date <= $seller_vacation_end_date))) ||
                                                        ($product->added_by == 'admin' && ($inhouse_temporary_close || ($inhouse_vacation_status && $current_date >= $inhouse_vacation_start_date && $current_date <= $inhouse_vacation_end_date))))
                                                            <button type="button"
                                                                    class="buy_now_button btn primary-blue-bg-color buy-now-btn-hover fs-16 flex-grow-1"
                                                                    disabled><i class="bi bi-bag me-1"></i>{{translate('buy_now')}}</span></button>
                                                            <button type="button"
                                                                    class="update_cart_button btn btn-primary fs-16 flex-grow-1"
                                                                    disabled><i class="bi bi-cart-plus me-1"></i>{{translate('add_to_Cart')}}</button>
                                                        @else
                                                            @php($guest_checkout=\App\CPU\Helpers::get_business_settings('guest_checkout'))
                                                            <button type="button"
                                                                class="buy_now_button btn primary-blue-bg-color buy-now-btn-hover text-white fs-16"
                                                                onclick="buy_now('add-to-cart-form', {{($guest_checkout==1 || Auth::guard('customer')->check()?'true':'false')}}, '{{route('shop-cart')}}')"><i class="bi bi-bag me-1"></i>{{translate('buy_now')}}</span>
                                                            </button>

                                                            <button type="button"
                                                                    class="update_cart_button btn btn-primary fs-16"
                                                                    onclick="addToCart('add-to-cart-form')"><i class="bi bi-cart-plus me-1"></i>{{translate('add_to_Cart')}}</button>
                                                            @if (auth('customer')->check())
                                                                <button class="btn btn-primary custom-chat-btn d-inline text-white fs-16 border-0" data-bs-toggle="modal" data-bs-target="#contact_sellerModal">
                                                                    <i class="bi bi-chat-square-fill"></i> {{translate('Chat_with_Seller')}}
                                                                </button>
                                                            @else
                                                                <button class="btn btn-primary custom-chat-btn d-inline text-white fs-16 border-0" data-bs-toggle="modal" data-bs-target="#loginModal">
                                                                    <i class="bi bi-chat-square-fill"></i> {{translate('Chat_with_Seller')}}
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    
                                                    @if(($product->added_by == 'seller' && ($seller_temporary_close || (isset($product->seller->shop) && $product->seller->shop->vacation_status && $current_date >= $seller_vacation_start_date && $current_date <= $seller_vacation_end_date))) ||
                                                    ($product->added_by == 'admin' && ($inhouse_temporary_close || ($inhouse_vacation_status && $current_date >= $inhouse_vacation_start_date && $current_date <= $inhouse_vacation_end_date))))
                                                        <div class="alert alert-danger mt-3" role="alert">
                                                            {{translate('this_shop_is_temporary_closed_or_on_vacation')}}
                                                            .
                                                            {{translate('You_cannot_add_product_to_cart_from_this_shop_for_now')}}
                                                        </div>
                                                    @endif
                                                </div>
                                            </form>
                                            
                                            @include('theme-views.layouts.partials.modal._chat-with-seller',['seller_id'=>$product->seller->id,'shop_id'=>$product->seller->shop->id])
                                            
                                        </div>
                                        <!-- End Product Details Content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-9 col-xl-9" >
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
                                                        @if($product->video_url != null && (str_contains($product->video_url, "youtube.com/embed/")))
                                                            <div class="col-12 mb-4 text-center">
                                                                <iframe width="560" height="315"
                                                                        src="{{$product->video_url}}">
                                                                </iframe>
                                                            </div>
                                                        @endif
                                                        <span class="fw-bold fs-17" >{!! $product->details !!}</span>
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

                                                    @if(count($product->reviews)==0)
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
                                                                        src="{{asset("storage/app/public/profile")}}/{{(isset($item->user)?$item->user->image:'')}}"
                                                                        alt=""
                                                                        class="img-fit dark-support"
                                                                        onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'" >
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
                                                                                    <img src="{{asset("storage/app/public/review/".$img)}}" class="remove-mask-img"
                                                                                         onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'">
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
                                        @if(count($product->reviews) > 2)
                                            <button class="btn btn-outline-primary see-more-details-review m-1 view_text"
                                                onclick="seemore()"
                                                data-productid="{{$product->id}}"
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

                
                <div class="col-lg-4 col-xl-3 d-flex flex-column gap-3">
                    <div class="card order-1 order-sm-0">
                        <div class="card-body">
                            <h5 class="mb-3">{{translate('More_from_the_Store')}}</h5>

                            <div class="d-flex flex-wrap gap-3">
                                @if (count($more_product_from_seller)>0)
                                    @foreach($more_product_from_seller as $key => $item)
                                        <div class="card border-primary-light transparent-shadow-hover flex-grow-1">
                                            <a href="{{route('product',$item->slug)}}"
                                               class="media align-items-centr gap-3 p-2">
                                                <div class="avatar" style="--size: 4.375rem">
                                                    <img
                                                        src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$item['thumbnail']}}"
                                                        alt=""
                                                        class="img-fit dark-support rounded img-fluid overflow-hidden"
                                                        onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'">
                                                </div>
                                                @php($item_review = \App\CPU\ProductManager::get_overall_rating($item->reviews))

                                                <div class="media-body d-flex flex-column gap-2">
                                                    <h6 class="text-capitalize">{{ Str::limit($item['name'], 18) }}</h6>
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
                                                            {{\App\CPU\Helpers::currency_converter(
                                                                $item->unit_price-(\App\CPU\Helpers::get_product_discount($item,$item->unit_price))
                                                            )}}
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
                    @if($product->added_by=='seller')
                        @if(isset($product->seller->shop))
                            <div class="card order-0 order-sm-1">
                                <div class="card-body">
                                    <div class="p-2 overlay shop-bg-card"
                                         data-bg-img="{{asset('storage/app/public/shop/banner')}}/{{$product->seller->shop->banner}}">
                                        <div class="media flex-wrap gap-2 p-2">
                                            <div class="avatar border rounded-circle" style="--size: 3.437rem">
                                                <img
                                                    src="{{asset('storage/app/public/shop')}}/{{$product->seller->shop->image}}"
                                                    alt="" class="img-fit dark-support border-radius-15-percent"
                                                    onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'">
                                            </div>
                                            <div class="media-body d-flex flex-column gap-2 text-absolute-whtie">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="fs-14">{{ \Illuminate\Support\Str::limit($product->seller->shop->name, 10) }}</h5>
                                                    <div class="d-flex gap-2 align-items-center ">
                                                        <div class="star-rating text-gold fs-12">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= (int)$avg_rating)
                                                                    <i class="bi bi-star-fill"></i>
                                                                @elseif ($avg_rating != 0 && $i <= (int)$avg_rating + 1.1 && $avg_rating > ((int)$avg_rating))
                                                                    <i class="bi bi-star-half"></i>
                                                                @else
                                                                    <i class="bi bi-star"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <span>({{$total_reviews}})</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center text-center flex-column" >
                                            <h6 class="fw-semibold">{{$products_for_review->count()}} {{translate('products')}}</h6>
                                            <div class="mb-3">
                                                <div class="text-center d-inline-block">
                                                    <h3 class="mb-1">{{round($rating_percentage)}}%</h3>
                                                    <div class="fs-12">{{translate('positive_review')}}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <a href="{{ route('shopView',[$product->seller->id]) }}"
                                               class="btn btn-primary btn-block">{{translate('Visit_Store')}}
                                            </a>
                                                            {{--
                                                                @if (auth('customer')->id() == '')
                                                                <div class="btn-circle chat-btn" style="--size: 2.5rem"
                                                                data-bs-toggle="modal" data-bs-target="#loginModal">
                                                                <i class="bi bi-chat-square-dots"></i>
                                                </div>
                                            @else
                                            <div class="btn-circle chat-btn" style="--size: 2.5rem"
                                            data-bs-toggle="modal" data-bs-target="#contact_sellerModal">
                                            <i class="bi bi-chat-square-dots"></i>
                                        </div>
                                        @endif
                                        --}}

                                        </div>
                                    </div>
                                </div>
                            </div>

                            @include('theme-views.layouts.partials.modal._chat-with-seller',['seller_id'=>$product->seller->id,'shop_id'=>$product->seller->shop->id])

                        @endif
                    @else
                        <div class="card  order-0 order-sm-1">
                            <div class="card-body p-2">
                                <div class="pt-1 overlay shop-bg-card"
                                     data-bg-img="{{asset("storage/app/public/shop/")}}/{{ \App\CPU\Helpers::get_business_settings('shop_banner') }}">
                                    <div class="media flex-wrap gap-2 pb-2">
                                        <div class="avatar border rounded-circle" style="--size: 3.437rem">
                                            <img
                                                src="{{asset("storage/app/public/company")}}/{{$web_config['fav_icon']->value}}"
                                                alt="" class="img-fit dark-support border-radius-15-percent"
                                                onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'" >
                                        </div>

                                        <div class="media-body d-flex flex-column gap-2 text-absolute-whtie">
                                            <div class="d-flex flex-column gap-1 justify-content-start">
                                                <div class="mb-3" >
                                                    <h5 class="mb-1 pt-2">{{$web_config['name']->value}}</h5>
                                                    <div class="d-flex gap-2 align-items-center ">
                                                        <div class="star-rating text-gold fs-12">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= (int)$avg_rating)
                                                                    <i class="bi bi-star-fill"></i>
                                                                @elseif ($avg_rating != 0 && $i <= (int)$avg_rating + 1.1 && $avg_rating > ((int)$avg_rating))
                                                                    <i class="bi bi-star-half"></i>
                                                                @else
                                                                    <i class="bi bi-star"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
    
                                                        <span>({{$total_reviews}})</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-50" >
                                        <h6 class="fw-semibold text-end">{{$products_for_review->count()}} {{translate('Products')}}</h6>
                                        <div class="mb-3 text-end">
                                            <div class="text-center d-inline-block">
                                                <h3 class="mb-1">{{round($rating_percentage)}}
                                                    %</h3>
                                                <div
                                                    class="fs-12">{{translate('positive_review')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('shopView',[0]) }}"
                                       class="btn btn-primary btn-block">{{translate('Visit_Store')}}</a>
                                </div>
                            </div>
                        </div>
                    @endif
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
                                @if (count($relatedProducts)>0)
                                    @foreach($relatedProducts as $key=>$product)
                                        <div class="swiper-slide">
                                            @include('theme-views.partials._similar-product-large-card',['product'=>$product])
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

    <script>
        $('.remove-mask-img').on('click', function(){
            $('.show-more--content').removeClass('active')
        })
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


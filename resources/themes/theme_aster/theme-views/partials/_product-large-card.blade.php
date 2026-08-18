<style>
    .flag-rectangle {
      width: 28px;
      height: 15px;
      background-size: cover;
      background-position: center;
      border: 1px solidrgb(210, 210, 210);
    }

    .label {
      text-align: center;
      margin-top: 5px;
      font-size: 12px;
    }

    .flag-box {
      text-align: center;
    }

    .torn-paper-sticker {
        background-color: #ff0018;
        animation: urgentDance 5s infinite;
        clip-path: polygon(
            0% 0%,
            95% 0%,
            100% 15%,
            98% 25%,
            100% 35%,
            97% 45%,
            100% 55%,
            96% 65%,
            100% 75%,
            95% 85%,
            100% 100%,
            5% 100%,
            0% 85%,
            2% 75%,
            0% 65%,
            3% 55%,
            0% 45%,
            4% 35%,
            0% 25%,
            2% 15%
        );
    }

    @keyframes urgentDance {
        0%, 85%, 100% {
            transform: translateX(0);
        }
        5% {
            transform: translateX(-2px);
        }
        10% {
            transform: translateX(2px);
        }
        15% {
            transform: translateX(-1.5px);
        }
        20% {
            transform: translateX(1.5px);
        }
        25% {
            transform: translateX(-1px);
        }
        30% {
            transform: translateX(1px);
        }
        35% {
            transform: translateX(0);
        }
    }

    /* Add these styles to your existing CSS */
    .product-card-shadow .swiper-slide {
        height: auto;
    }

    .product-card-shadow .product {
        height: 100% !important;
        display: flex !important;
        flex-direction: column !important;
    }

    .product-card-shadow .product__summary {
        flex: 1 !important;
        display: flex !important;
        flex-direction: column !important;
    }

    .product-card-shadow .product__price {
        margin-top: auto !important;
    }

</style>

<div class="product border rounded text-center d-flex flex-column ov-hidden cursor-pointer product-card-shadow scale-image-hover-effect"
     onclick="location.href='{{route('ads-show',$ad->slug)}}'">
    <!-- Product top -->
    <div class="product__top" style="--width: 100%;">
        @php($wishlist = count($ad->wish_list)>0 ? 1 : 0)
        <div class="product__actions d-flex flex-column gap-2">
            <a href="javascript:" onclick="addWishlist('{{$ad['id']}}','{{route('store-wishlist')}}')"
               id="wishlist-{{$ad['id']}}"
               class="btn-wishlist stopPropagation add_to_wishlist wishlist-{{$ad['id']}} {{($wishlist == 1?'wishlist_icon_active':'')}}"
               title="{{ translate('Add to wishlist') }}">
                <i class="bi bi-heart"></i>
            </a>
            <a onclick="location.href='{{route('ads-show',$ad->slug)}}'"
               class="btn-wishlist stopPropagation"
               title="{{ translate('Show add') }}">
                <i class="bi bi-eye"></i>
            </a>
        </div>
        <div class="product__thumbnail position-relative">
            <img src="{{cloudfront('ad/thumbnail/'.$ad->thumbnail)}}"
            onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
            class="img-fit card-product-image dark-support custom-bottom-border-radius prod-imag2" alt="">
            @if($ad->sale_status == 'sold')
                <div style="position:absolute;inset:0;background:rgba(0,0,0,0.45);z-index:1;border-radius:inherit;display:flex;align-items:center;justify-content:center;">
                    <span style="background:#dc3545;color:#fff;font-size:18px;font-weight:800;padding:8px 24px;border-radius:8px;letter-spacing:1px;text-transform:uppercase;">
                        {{ translate('sold') }}
                    </span>
                </div>
            @elseif($ad->sale_status == 'reserved')
                <div style="position:absolute;inset:0;background:rgba(0,0,0,0.35);z-index:1;border-radius:inherit;display:flex;align-items:center;justify-content:center;">
                    <span style="background:#f5920c;color:#fff;font-size:18px;font-weight:800;padding:8px 24px;border-radius:8px;letter-spacing:1px;text-transform:uppercase;">
                        {{ translate('reserved') }}
                    </span>
                </div>
            @endif
            @if($ad->has_urgent_sale_sticker == 1)
                <span class="text-white fw-bold px-2 py-1 torn-paper-sticker"
                    style="position: absolute;bottom: 10px;left: 10px;z-index: 2;">
                    {{translate('urgent_sale')}}
                </span>
            @endif
        </div>
    </div>

    <div class="product__summary px-2 py-md-3 pt-2 pb-1 cursor-pointer">
        <div class="d-flex align-items-center justify-content-between" >
            <div class="flag-rectangle"
                style="background-image: url('{{ 'https://flagcdn.com/w320/'.SYSTEM_COUNTRIES_FLAGS[$ad->country] }}');">
            </div>

            <div>
                <h6 class="bg-primary py-1 px-md-2 px-1 rounded text-light d-flex align-items-center gap-1" ><i class="bi bi-tags-fill fs-12"></i><span class="fs-12-mobile" >{{$ad->category->name ?? '/'}}</span></h6>
            </div>
        </div>
        <h6 class="product__title text-truncate text-start p-0 my-2 responsive-sides-padding">
            {{ \Illuminate\Support\Str::limit($ad['title'], 30) }}
        </h6>
        <div class="product__price d-flex align-items-end-md align-items-start-sm  flex-column flex-md-row justify-content-between">
            <div class="text-start fs-12-small-screens" >
                <div class="mb-1" >
                    @if(isset($ad->brand->name))
                        <span>{{ $ad->brand->name ?? '/' }} • </span>
                    @endif
                    @if($ad->year)
                        <span>{{ $ad->year }}</span>
                    @endif
                </div>
                <div>
                    @if($ad->mileage)
                   <span dir="ltr">{{ number_format((int)$ad->mileage, 0, ',', '.') }} {{ translate('km') }}</span>
                    @endif
                </div>
            </div>
            <ins class="product__new-price text-primary text-end mt-auto" >
                @if($ad->price_type == 'fixed_price')
                <b class="currency-font" style="font-size: 18px;" dir="ltr">{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</b>
                @elseif($ad->price_type == 'free')
                    <b style="font-size: 18px;" >{{translate('free')}}</b>
                @elseif($ad->price_type == 'asking_price')
                   <b class="currency-font" style="font-size: 18px;" dir="ltr">{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</b> 
                @elseif($ad->price_type == 'auction')
                    <b class="currency-font" style="font-size: 18px;" >{{translate('auction')}}</b>
                @endif
            </ins>
        </div>
    </div>
</div>


{{--





    <style>
    .flag-rectangle {
      width: 28px;
      height: 15px;
      background-size: cover;
      background-position: center;
      border: 1px solidrgb(210, 210, 210);
    }

    .label {
      text-align: center;
      margin-top: 5px;
      font-size: 12px;
    }

    .flag-box {
      text-align: center;
    }

    .torn-paper-sticker {
        background-color: #ff0018;
        animation: urgentDance 5s infinite;
        clip-path: polygon(
            0% 0%,
            95% 0%,
            100% 15%,
            98% 25%,
            100% 35%,
            97% 45%,
            100% 55%,
            96% 65%,
            100% 75%,
            95% 85%,
            100% 100%,
            5% 100%,
            0% 85%,
            2% 75%,
            0% 65%,
            3% 55%,
            0% 45%,
            4% 35%,
            0% 25%,
            2% 15%
        );
    }

    @keyframes urgentDance {
        0%, 85%, 100% {
            transform: translateX(0);
        }
        5% {
            transform: translateX(-2px);
        }
        10% {
            transform: translateX(2px);
        }
        15% {
            transform: translateX(-1.5px);
        }
        20% {
            transform: translateX(1.5px);
        }
        25% {
            transform: translateX(-1px);
        }
        30% {
            transform: translateX(1px);
        }
        35% {
            transform: translateX(0);
        }
    }

    /* Add these styles to your existing CSS */
    .product-card-shadow .swiper-slide {
        height: auto;
    }

    .product-card-shadow .product {
        height: 100% !important;
        display: flex !important;
        flex-direction: column !important;
    }

    .product-card-shadow .product__summary {
        flex: 1 !important;
        display: flex !important;
        flex-direction: column !important;
    }

    .product-card-shadow .product__price {
        margin-top: auto !important;
    }

/* Product image container - fixed height, no skeleton */
.product-image-container {
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: #f8f9fa;
}

.product-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

</style>

<div class="product border rounded text-center d-flex flex-column ov-hidden cursor-pointer product-card-shadow scale-image-hover-effect"
     onclick="location.href='{{route('ads-show',$ad->slug)}}'">
    <!-- Product top -->
    <div class="product__top" style="--width: 100%;">
        @php($wishlist = count($ad->wish_list)>0 ? 1 : 0)
        <div class="product__actions d-flex flex-column gap-2">
            <a href="javascript:" onclick="addWishlist('{{$ad['id']}}','{{route('store-wishlist')}}')"
                id="wishlist-{{$ad['id']}}"
                class="btn-wishlist stopPropagation add_to_wishlist wishlist-{{$ad['id']}} {{($wishlist == 1?'wishlist_icon_active':'')}}"
                title="{{ translate('Add to wishlist') }}">
                <i class="bi bi-heart"></i>
            </a>
            <a onclick="location.href='{{route('ads-show',$ad->slug)}}'"
                class="btn-wishlist stopPropagation"
                title="{{ translate('Show add') }}">
                <i class="bi bi-eye"></i>
            </a>
        </div>
        <div class="product__thumbnail position-relative">
            <div class="product-image-container custom-bottom-border-radius">
                <img src="{{cloudfront('ad/thumbnail/'.$ad->thumbnail)}}"
                onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                loading="lazy"
                class="img-fit card-product-image dark-support custom-bottom-border-radius prod-imag2"
                alt="">
            </div>
            @if($ad->sale_status == 'sold')
                <div style="position:absolute;inset:0;background:rgba(0,0,0,0.45);z-index:1;border-radius:inherit;display:flex;align-items:center;justify-content:center;">
                    <span style="background:#dc3545;color:#fff;font-size:18px;font-weight:800;padding:8px 24px;border-radius:8px;letter-spacing:1px;text-transform:uppercase;">
                        {{ translate('sold') }}
                    </span>
                </div>
            @elseif($ad->sale_status == 'reserved')
                <div style="position:absolute;inset:0;background:rgba(0,0,0,0.35);z-index:1;border-radius:inherit;display:flex;align-items:center;justify-content:center;">
                    <span style="background:#f5920c;color:#fff;font-size:18px;font-weight:800;padding:8px 24px;border-radius:8px;letter-spacing:1px;text-transform:uppercase;">
                        {{ translate('reserved') }}
                    </span>
                </div>
            @endif
            @if($ad->has_urgent_sale_sticker == 1)
                <span class="text-white fw-bold px-2 py-1 torn-paper-sticker"
                    style="position: absolute;bottom: 10px;left: 10px;z-index: 2;">
                    {{translate('urgent_sale')}}
                </span>
            @endif
        </div>
    </div>

    <div class="product__summary px-2 py-md-3 pt-2 pb-1 cursor-pointer">
        <div class="d-flex align-items-center justify-content-between" >
            <div class="flag-rectangle"
                style="background-image: url('{{ 'https://flagcdn.com/w320/'.SYSTEM_COUNTRIES_FLAGS[$ad->country] }}');">
            </div>

            <div>
                <h6 class="bg-primary py-1 px-md-2 px-1 rounded text-light d-flex align-items-center gap-1" ><i class="bi bi-tags-fill fs-12"></i><span class="fs-12-mobile" >{{$ad->category->name ?? '/'}}</span></h6>
            </div>
        </div>
        <h6 class="product__title text-truncate text-start p-0 my-2 responsive-sides-padding">
            {{ \Illuminate\Support\Str::limit($ad['title'], 30) }}
        </h6>
        <div class="product__price d-flex align-items-end-md align-items-start-sm  flex-column flex-md-row justify-content-between">
            <div class="text-start fs-12-small-screens" >
                <div class="mb-1" >
                    @if(isset($ad->brand->name))
                        <span>{{ $ad->brand->name ?? '/' }} • </span>
                    @endif
                    @if($ad->year)
                        <span>{{ $ad->year }}</span>
                    @endif
                </div>
                <div>
                    @if($ad->mileage)
                    <span dir="ltr">{{ number_format((int)$ad->mileage, 0, ',', '.') }} {{ translate('km') }}</span>
                    @endif
                </div>
            </div>
            <ins class="product__new-price text-primary text-end mt-auto" >
                @if($ad->price_type == 'fixed_price')
                    <b class="currency-font" style="font-size: 18px;" >{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</b>
                @elseif($ad->price_type == 'free')
                    <b style="font-size: 18px;" >{{translate('free')}}</b>
                @elseif($ad->price_type == 'asking_price')
                    <b class="currency-font" style="font-size: 18px;" >{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</b>
                @elseif($ad->price_type == 'auction')
                    <b class="currency-font" style="font-size: 18px;" >{{translate('auction')}}</b>
                @endif
            </ins>
        </div>
    </div>
</div>





--}}

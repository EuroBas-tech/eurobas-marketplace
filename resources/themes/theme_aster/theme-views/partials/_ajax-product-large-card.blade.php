@php($locale = SOLVE_LOCALE_CODES[app()->getLocale()] ?? app()->getLocale())

<style>
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

    @media(max-width: 1199px) {
        .responsive-title-font-size {
            font-size: 16px;
        }
    }

    /* Mobile-only solution: Make cards equal height only on mobile screens */
    @media (max-width: 767px) {
        .auto-col {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .auto-col .col-sm-6.d-md-none {
            display: flex;
            flex: 0 0 calc(50% - 0.5rem); /* 50% width minus half the gap */
        }

        /* Force mobile product cards to be full height */
        .d-md-none .product {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Fixed height for mobile card images */
        .d-md-none .product__thumbnail {
            height: 270px !important;
        }

        .d-md-none .product__thumbnail img {
            height: 270px !important;
            object-fit: cover;
        }

        /* Make the content area flexible on mobile */
        .d-md-none .product .d-flex.flex-column.justify-content-between {
            flex: 1;
            display: flex !important;
            flex-direction: column;
        }

        /* Push price section to bottom on mobile */
        .d-md-none .product .d-flex.flex-column.justify-content-between > div:last-child {
            margin-top: auto;
        }
    }

    /* Responsive adjustments for very small screens */
    @media (max-width: 576px) {
        .auto-col .col-sm-6.d-md-none {
            flex: 0 0 100%;
        }
    }

</style>

<div class="col-md-12 mb-4 d-none d-md-block" >
    <div class="product rounded ov-hidden product-card-shadow card-border cursor-default">
        <input type="hidden" data-shown-ads="{{$ad->id}}">
        <!-- Product top -->
        <div class="d-flex justify-content-between gap-3 scale-image-hover-effect text-center" >
            <div>
                <a href="{{route('ads-show',$ad->slug)}}">
                    <div class="product__top h-100" style="--width: 100%;z-index: 0;">
                        <div class="product__thumbnail h-100 ov-hidden">
                            <img src="{{cloudfront('ad/thumbnail/'.$ad->thumbnail)}}"
                            onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'" loading="lazy"
                            class="img-fit card-product-image h-100 dark-support custom-bottom-border-radius rounded prod-imag2-list" alt="">
                        </div>
                    </div>
                </a>
            </div>

            <div class="product__summary d-flex flex-column justify-content-between">
                <div class="w-100" >
                    <div class="d-flex align-items-start justify-content-between mb-3" >
                        <div>
                            <h3 class="text-start p-0 responsive-sides-padding fw-medium responsive-title-font-size" >
                                <a href="{{route('ads-show',$ad->slug)}}">
                                    {{ substr($ad['title'], 0, 55) }}{{ strlen($ad['title']) > 55 ? '...' : '' }}
                                </a>
                            </h3>
                        </div>
                        @php($wishlist = count($ad->wish_list)>0 ? 1 : 0)
                        <div class="d-flex gap-2">
                            <a href="javascript:" onclick="addWishlist('{{$ad['id']}}','{{route('store-wishlist')}}')"
                                id="wishlist-{{$ad['id']}}"
                                class="stopPropagation icon-white-on-hover btn btn-outline-primary px-2 py-1 wishlist-{{$ad['id']}} {{($wishlist == 1?'wishlist_icon_active':'')}}"
                                title="{{ translate('Add to wishlist') }}">
                                <i class="bi bi-heart"></i>
                            </a>
                            <a onclick="location.href='{{route('ads-show',$ad->slug)}}'"
                                class="btn btn-outline-primary stopPropagation px-2 py-1 icon-white-on-hover"
                                title="{{ translate('Show add') }}">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>

                    <div class="mb-3" >
                        <h6 class="bg-primary p-0 px-2 rounded fs-14 d-inline text-white" >
                            <i class="bi bi-tags-fill fs-13"></i><span class="mx-1" >{{$ad->category->name ?? '/'}}</span>
                        </h6>
                    </div>
                    <div class="product__price d-flex align-items-end justify-content-between fw-medium">
                        <div class="text-start" >
                            @if($ad->category->category_type == 'vehicles' && $ad->category->slug != 'bicycles')
                                <div class="mb-1 d-flex align-items-center gap-3" style="font-size: 15px;" >
                                    @if(isset($ad->brand->name))
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 32 32"><path fill="currentColor" d="M28.59 10.78h-2.242a.496.496 0 0 0-.333.134c-.716-1.143-1.457-2.058-2.032-2.633c-2-2-14-2-16 0c-.573.574-1.31 1.483-2.022 2.618a.483.483 0 0 0-.308-.117H3.41c-.275 0-.5.226-.5.5v1.01c0 .274.22.54.49.593l1.36.26c-1.174 2.618-1.866 5.876-.778 9.14v1.937c0 .553.14 1 .313 1h2.562c.173 0 .313-.447.313-1v-1.584c2.298.22 5.55.46 8.812.46c3.232 0 6.52-.236 8.814-.454v1.578c0 .553.14 1 .312 1h2.562c.172 0 .312-.447.312-1l-.002-1.938c1.087-3.26.397-6.516-.775-9.134l1.392-.265a.63.63 0 0 0 .49-.594v-1.01a.498.498 0 0 0-.497-.5zM7.107 18.907a1.813 1.813 0 0 1 0-3.624a1.813 1.813 0 0 1-.001 3.624zm-1.524-5.19C6.543 11.52 7.88 9.8 8.69 8.988c.584-.585 3.34-1.207 7.292-1.207c3.953 0 6.708.623 7.293 1.208c.81.81 2.146 2.53 3.106 4.728c-2.132.236-6.285-.31-10.398-.31s-8.266.546-10.4.31zm19.274 5.19a1.813 1.813 0 0 1 0-3.624a1.813 1.813 0 0 1-.001 3.624z"/></svg>
                                            </span>
                                            <span>{{ $ad->brand->name ?? '/' }}</span>
                                            @if(isset($ad->model->name))
                                                <span> • {{ $ad->model->name ?? '/' }}</span>
                                            @endif
                                        </span>
                                    @endif
                                    @if($ad->year)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span><span><i class="bi bi-calendar-event"></i></span></span>
                                            <span>{{ $ad->year }}</span>
                                        </span>
                                    @endif
                                </div>
                                <div class="mb-1 d-flex align-items-center gap-3" style="font-size: 15px;" >
                                    @if($ad->mileage)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24">
                                                    <path data-v-35b30767="" fill="currentColor" opacity="1.00" d="M12 14c-.6 0-1 .4-1 1v5c0 .6.4 1 1 1s1-.4 1-1v-5c0-.6-.4-1-1-1Zm0-6c-.6 0-1 .4-1 1v2c0 .6.4 1 1 1s1-.4 1-1V9c0-.6-.4-1-1-1ZM5.2 2c-.6-.1-1.1.3-1.2.8l-3 18c-.1.5.3 1.1.8 1.2H2c.5 0 .9-.3 1-.8l3-18c.1-.6-.3-1.1-.8-1.2ZM12 3c-.6 0-1 .4-1 1v1c0 .6.4 1 1 1s1-.4 1-1V4c0-.6-.4-1-1-1Zm8-.2c-.1-.5-.6-.9-1.2-.8-.5.1-.9.6-.8 1.2l3 18c.1.5.5.8 1 .8h.2c.5-.1.9-.6.8-1.2l-3-18Z"></path>
                                                </svg>
                                            </span>
                                            <span>{{ $ad->mileage }}</span><span>{{ translate('km') }}</span>
                                        </span>
                                    @endif
                                    @if($ad->body_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 197.1" width="24" height="24">
                                                <path fill="currentColor" d="M474.9 65c-19.2-7.9-45.1-8.9-75.2-10.2-9.1-.4-18.4-.8-28.2-1.3l-3.3-2.4C333.3 25.5 300.3 1.4 230.7.1c-.8-.1-1.7-.2-2.6-.1-.2 0-.3 0-.5.1h-2.8C150.2 0 124.7 17.4 92.4 39.5c-2.9 2-5.8 4-8.9 6l-49.1 3.1c-.8.1-1.6.2-2.4.4-12.4 3.7-21.5 16-22.7 30.5-.2 3.5-.3 7-.3 10.7 0 1.7 0 3.4-.1 5.2-4.3 5.2-5.9 12.7-5.9 18.7V135c0 19.1 11.2 31.9 27.7 31.9h47.4c8.1 17.8 26 30.3 46.8 30.3s38.7-12.4 46.8-30.3h173.8c8.1 17.8 26 30.3 46.8 30.3 20.8 0 38.8-12.5 46.8-30.3h4.5c2.8 0 5.4.1 8.1.1 26.4 0 44.5-2 52.7-10.1 3.1-3 4.8-7 4.8-11.1v-24.7c-.1-28.3-11.3-46.6-34.3-56.1zM219.5 21l2.8 32.2H178c-12.5 0-23.2-.1-27.5-1.8-1.3-.5-2.2-.9-4.8-7.8l-2.9-9.4c18-7.8 40.6-12.7 76.7-13.2zm23.8 32.3-2.7-31.8c43.6 2.5 70 15.3 94.6 31.8h-91.9zM124.9 176.1c-16.7 0-30.3-13.6-30.3-30.3s13.6-30.3 30.3-30.3 30.3 13.6 30.3 30.3-13.6 30.3-30.3 30.3zm267.4 0c-16.7 0-30.3-13.6-30.3-30.3s13.6-30.3 30.3-30.3 30.3 13.6 30.3 30.3-13.6 30.3-30.3 30.3zm95.8-33.5c-3.9 1.5-14.7 3.7-44.2 3.3h-.2v-.1c0-28.3-23-51.3-51.3-51.3-28.3 0-51.3 23-51.3 51.3v.1H176.2v-.1c0-28.3-23-51.3-51.3-51.3s-51.3 23-51.3 51.3v.1H30.7c-4.5 0-6.7-3.7-6.7-10.9v-20.8c0-2.1.6-4.2 1-5.1 2.8-1.8 4.5-4.9 4.7-8.2.2-3.7.2-7.2.3-10.4 0-3.4.1-6.6.3-9.3.4-5.4 3.2-10.1 6.8-11.7l50.5-3.2c1.8-.1 3.6-.7 5.1-1.7 4-2.7 7.8-5.2 11.5-7.7 6.7-4.6 13-8.9 19.5-12.8l1.9 6.1c.1.2.1.4.2.6 3.2 8.4 6.8 16.3 16.9 20.2 7.2 2.9 16.3 3.3 35.3 3.3h189.6c10.9.7 21.3 1.1 31.3 1.5 28.1 1.2 52.3 2.1 68.1 8.6 11 4.5 21.1 12.1 21.1 36.7v21.5z"/>
                                            </svg>
                                            <span>{{ translate($ad->body_type) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->fuel_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <i class="bi bi-fuel-pump-diesel"></i>
                                            </span>
                                            <span>{{ translate($ad->fuel_type) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->transmission_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 512 512"><path fill="currentColor" d="M82.64 48.26a51.94 51.94 0 0 0-51.68 51.94a51.94 51.94 0 0 0 42.2 50.9v209.7a51.94 51.94 0 0 0-42.2 51a51.94 51.94 0 0 0 51.94 51.9a51.94 51.94 0 0 0 51.9-51.9a51.94 51.94 0 0 0-42.15-51v-95.1H246.2v95.1a51.94 51.94 0 0 0-42.2 51a51.94 51.94 0 0 0 52 51.9a51.94 51.94 0 0 0 51.9-51.9a51.94 51.94 0 0 0-42.2-51v-95.1h173.1V151.1a51.94 51.94 0 0 0 42.2-50.9a51.94 51.94 0 0 0-51.9-51.94a51.94 51.94 0 0 0-.2 0a51.94 51.94 0 0 0-51.7 51.94a51.94 51.94 0 0 0 42.2 50.9v95.1H265.7v-95.1a51.94 51.94 0 0 0 42.2-50.9A51.94 51.94 0 0 0 256 48.26a51.94 51.94 0 0 0-.2 0A51.94 51.94 0 0 0 204 100.2a51.94 51.94 0 0 0 42.2 50.9v95.1H92.65v-95.1a51.94 51.94 0 0 0 42.15-50.9a51.94 51.94 0 0 0-51.9-51.94a51.94 51.94 0 0 0-.26 0z"/></svg>
                                            </span>
                                            <span>{{ translate($ad->transmission_type) }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            @if($ad->category->category_type == 'furniture')
                                <div class="mb-1 d-flex align-items-center gap-3" style="font-size: 15px;" >
                                    @if($ad->furniture_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg width="17" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M64 160C64 89.3 121.3 32 192 32l256 0c70.7 0 128 57.3 128 128l0 33.6c-36.5 7.4-64 39.7-64 78.4l0 48-384 0 0-48c0-38.7-27.5-71-64-78.4L64 160zM544 272c0-20.9 13.4-38.7 32-45.3c5-1.8 10.4-2.7 16-2.7c26.5 0 48 21.5 48 48l0 176c0 17.7-14.3 32-32 32l-32 0c-17.7 0-32-14.3-32-32L96 448c0 17.7-14.3 32-32 32l-32 0c-17.7 0-32-14.3-32-32L0 272c0-26.5 21.5-48 48-48c5.6 0 11 1 16 2.7c18.6 6.6 32 24.4 32 45.3l0 48 0 32 32 0 384 0 32 0 0-32 0-48z"/></svg>
                                            </span>
                                            <span>{{ translate($ad->furniture_type) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->material)
                                        <span class="d-flex align-items-center gap-1" >
                                            <img width="17px" src="{{ theme_asset('assets/img/svg/material-gray.svg') }}" alt="">
                                            <span>{{ translate($ad->material) }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            @if($ad->category->category_type == 'vehicles' && $ad->category->slug == 'bicycles')
                                <div class="mb-1 d-flex align-items-center gap-3" style="font-size: 15px;" >
                                    @if(isset($ad->brand->name))
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>

                                            </span>
                                            <span>{{ $ad->brand->name ?? '/' }}</span>
                                        </span>
                                    @endif
                                    @if($ad->bicycle_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <i class="bi bi-bicycle"></i>
                                            </span>
                                            <span>{{ translate($ad->bicycle_type) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->bicycle_size)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <i class="bi bi-arrows-angle-expand"></i>
                                            </span>
                                            <span>{{ $ad->bicycle_size }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            @if($ad->category->category_type == 'industrial machines')
                                <div class="mb-1 d-flex align-items-center gap-3" style="font-size: 15px;" >
                                    @if(isset($ad->brand->name))
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>{{ $ad->brand->name ?? '/' }}</span>
                                        </span>
                                    @endif
                                    @if($ad->manufacturer)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>{{ $ad->manufacturer }}</span>
                                        </span>
                                    @endif
                                    @if($ad->year)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <span><span><i class="bi bi-calendar-event"></i></span></span>
                                            </span>
                                            <span>{{ $ad->year }}</span>
                                        </span>
                                    @endif
                                    @if($ad->power_source)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg width="15" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M349.4 44.6c5.9-13.7 1.5-29.7-10.6-38.5s-28.6-8-39.9 1.8l-256 224c-10 8.8-13.6 22.9-8.9 35.3S50.7 288 64 288l111.5 0L98.6 467.4c-5.9 13.7-1.5 29.7 10.6 38.5s28.6 8 39.9-1.8l256-224c10-8.8 13.6-22.9 8.9-35.3s-16.6-20.7-30-20.7l-111.5 0L349.4 44.6z"/></svg>
                                            </span>
                                            <span>{{ translate($ad->power_source) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->power_capacity)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg width="15" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M349.4 44.6c5.9-13.7 1.5-29.7-10.6-38.5s-28.6-8-39.9 1.8l-256 224c-10 8.8-13.6 22.9-8.9 35.3S50.7 288 64 288l111.5 0L98.6 467.4c-5.9 13.7-1.5 29.7 10.6 38.5s28.6 8 39.9-1.8l256-224c10-8.8 13.6-22.9 8.9-35.3s-16.6-20.7-30-20.7l-111.5 0L349.4 44.6z"/></svg>
                                            </span>
                                            <span>{{ $ad->power_capacity }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            @if($ad->category->category_type == 'real estate')
                                <div class="mb-1 d-flex align-items-center gap-3" style="font-size: 15px;" >
                                    @if($ad->listing_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg width="17" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c.2 35.5-28.5 64.3-64 64.3l-320.4 0c-35.3 0-64-28.7-64-64l0-160.4-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L416 100.7 416 64c0-17.7 14.3-32 32-32l32 0c17.7 0 32 14.3 32 32l0 121 52.8 46.4c8 7 12 15 11 24zM248 192c-13.3 0-24 10.7-24 24l0 80c0 13.3 10.7 24 24 24l80 0c13.3 0 24-10.7 24-24l0-80c0-13.3-10.7-24-24-24l-80 0z"/></svg>
                                            </span>
                                            <span>{{ translate($ad->listing_type) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->property_size)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <i class="bi bi-arrows-angle-expand"></i>
                                            </span>
                                            <span>{{ $ad->property_size }}<span class="fs-12" >{{translate('km²')}}</span></span>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            @if($ad->category->category_type == 'shipbuilding marine')
                                <div class="mb-1 d-flex align-items-center gap-3" style="font-size: 15px;" >
                                    @if($ad->shipbuilding_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg width="17px" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M256 16c0-7 4.5-13.2 11.2-15.3s13.9 .4 17.9 6.1l224 320c3.4 4.9 3.8 11.3 1.1 16.6s-8.2 8.6-14.2 8.6l-224 0c-8.8 0-16-7.2-16-16l0-320zM212.1 96.5c7 1.9 11.9 8.2 11.9 15.5l0 224c0 8.8-7.2 16-16 16L80 352c-5.7 0-11-3-13.8-8s-2.9-11-.1-16l128-224c3.6-6.3 11-9.4 18-7.5zM5.7 404.3C2.8 394.1 10.5 384 21.1 384l533.8 0c10.6 0 18.3 10.1 15.4 20.3l-4 14.3C550.7 473.9 500.4 512 443 512L133 512C75.6 512 25.3 473.9 9.7 418.7l-4-14.3z"/></svg>
                                            </span>
                                            <span>{{ translate($ad->shipbuilding_type) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->year)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span><span><i class="bi bi-calendar-event"></i></span></span>
                                            <span>{{ $ad->year }}</span>
                                        </span>
                                    @endif
                                    @if($ad->maximum_speed)
                                        <span class="d-flex align-items-center gap-1" >
                                            <svg width="17px" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M192 32c0-17.7 14.3-32 32-32L352 0c17.7 0 32 14.3 32 32l0 32 48 0c26.5 0 48 21.5 48 48l0 128 44.4 14.8c23.1 7.7 29.5 37.5 11.5 53.9l-101 92.6c-16.2 9.4-34.7 15.1-50.9 15.1c-19.6 0-40.8-7.7-59.2-20.3c-22.1-15.5-51.6-15.5-73.7 0c-17.1 11.8-38 20.3-59.2 20.3c-16.2 0-34.7-5.7-50.9-15.1l-101-92.6c-18-16.5-11.6-46.2 11.5-53.9L96 240l0-128c0-26.5 21.5-48 48-48l48 0 0-32zM160 218.7l107.8-35.9c13.1-4.4 27.3-4.4 40.5 0L416 218.7l0-90.7-256 0 0 90.7zM306.5 421.9C329 437.4 356.5 448 384 448c26.9 0 55.4-10.8 77.4-26.1c0 0 0 0 0 0c11.9-8.5 28.1-7.8 39.2 1.7c14.4 11.9 32.5 21 50.6 25.2c17.2 4 27.9 21.2 23.9 38.4s-21.2 27.9-38.4 23.9c-24.5-5.7-44.9-16.5-58.2-25C449.5 501.7 417 512 384 512c-31.9 0-60.6-9.9-80.4-18.9c-5.8-2.7-11.1-5.3-15.6-7.7c-4.5 2.4-9.7 5.1-15.6 7.7c-19.8 9-48.5 18.9-80.4 18.9c-33 0-65.5-10.3-94.5-25.8c-13.4 8.4-33.7 19.3-58.2 25c-17.2 4-34.4-6.7-38.4-23.9s6.7-34.4 23.9-38.4c18.1-4.2 36.2-13.3 50.6-25.2c11.1-9.4 27.3-10.1 39.2-1.7c0 0 0 0 0 0C136.7 437.2 165.1 448 192 448c27.5 0 55-10.6 77.5-26.1c11.1-7.9 25.9-7.9 37 0z"/></svg>
                                            <span>{{ $ad->maximum_speed }}<span class="fs-12" >{{translate('km/h')}}</span></span>
                                        </span>
                                    @endif
                                    @if($ad->fuel_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <i class="bi bi-fuel-pump-diesel"></i>
                                            <span>{{ translate($ad->fuel_type) }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif

                            @if($ad->category->category_type == 'home appliances')
                                <div class="mb-1 d-flex align-items-center gap-3" style="font-size: 15px;" >
                                    @if(isset($ad->custom_brand))
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>

                                            </span>
                                            <span>{{ $ad->custom_brand ?? '/' }}</span>
                                        </span>
                                    @endif
                                    @if($ad->home_appliance_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <img width="25px" src="{{ theme_asset('assets/img/svg/home-appliance-type.svg') }}" alt="">
                                            </span>
                                            <span>{{ translate($ad->home_appliance_type) }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif

                            @if($ad->category->category_type == 'home garden')
                                <div class="mb-1 d-flex align-items-center gap-3" style="font-size: 15px;" >
                                    @if(isset($ad->custom_brand))
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg width="17" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M343.9 213.4L245.3 312l65.4 65.4c7.9 7.9 11.1 19.4 8.4 30.3s-10.8 19.6-21.5 22.9l-256 80c-11.4 3.5-23.8 .5-32.2-7.9S-2.1 481.8 1.5 470.5l80-256c3.3-10.7 12-18.9 22.9-21.5s22.4 .5 30.3 8.4L200 266.7l98.6-98.6c-14.3-14.6-14.2-38 .3-52.5l95.4-95.4c26.9-26.9 70.5-26.9 97.5 0s26.9 70.5 0 97.5l-95.4 95.4c-14.5 14.5-37.9 14.6-52.5 .3z"/></svg>
                                            </span>
                                            <span>{{ $ad->custom_brand ?? '/' }}</span>
                                        </span>
                                    @endif
                                    @if($ad->material)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <img width="17px" src="{{ theme_asset('assets/img/svg/material-gray.svg') }}" alt="">
                                            </span>
                                            <span>{{ translate($ad->material) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->usage_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <img width="17px" src="{{ theme_asset('assets/img/svg/usage-gray.svg') }}" alt="">
                                            <span>{{ translate($ad->usage_type) }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif

                            @if($ad->category->category_type == 'electronics')
                                <div class="mb-1 d-flex align-items-center gap-3" style="font-size: 15px;" >
                                    @if($ad->electronic_type)
                                    <span class="d-flex align-items-center gap-1" >
                                        <span>
                                            <svg width="17px" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M176 24c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40c-35.3 0-64 28.7-64 64l-40 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l40 0 0 56-40 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l40 0 0 56-40 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l40 0c0 35.3 28.7 64 64 64l0 40c0 13.3 10.7 24 24 24s24-10.7 24-24l0-40 56 0 0 40c0 13.3 10.7 24 24 24s24-10.7 24-24l0-40 56 0 0 40c0 13.3 10.7 24 24 24s24-10.7 24-24l0-40c35.3 0 64-28.7 64-64l40 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-40 0 0-56 40 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-40 0 0-56 40 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-40 0c0-35.3-28.7-64-64-64l0-40c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40-56 0 0-40c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40-56 0 0-40zM160 128l192 0c17.7 0 32 14.3 32 32l0 192c0 17.7-14.3 32-32 32l-192 0c-17.7 0-32-14.3-32-32l0-192c0-17.7 14.3-32 32-32zm192 32l-192 0 0 192 192 0 0-192z"/></svg>
                                        </span>
                                        <span>{{ translate($ad->electronic_type) }}</span>
                                    </span>
                                    @endif
                                    @if(isset($ad->custom_brand))
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg width="17px" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M384 96l0 224L64 320 64 96l320 0zM64 32C28.7 32 0 60.7 0 96L0 320c0 35.3 28.7 64 64 64l117.3 0-10.7 32L96 416c-17.7 0-32 14.3-32 32s14.3 32 32 32l256 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-74.7 0-10.7-32L384 384c35.3 0 64-28.7 64-64l0-224c0-35.3-28.7-64-64-64L64 32zm464 0c-26.5 0-48 21.5-48 48l0 352c0 26.5 21.5 48 48 48l64 0c26.5 0 48-21.5 48-48l0-352c0-26.5-21.5-48-48-48l-64 0zm16 64l32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16s7.2-16 16-16zm-16 80c0-8.8 7.2-16 16-16l32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16zm32 160a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                                            </span>
                                            <span>{{ $ad->custom_brand ?? '/' }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            <div style="font-size: 15px;" >
                                <span class="d-flex align-items-center gap-2" >
                                    <span>{{ date('d M y', strtotime($ad->created_at)) }} ({{ $ad->created_at->locale($locale)->diffForHumans() }})</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100 d-flex align-items-end justify-content-between" >
                    <div>
                        <h6 class="d-flex align-items-end gap-1" >
                            <i class="bi bi-geo-alt"></i>
                            <span class="fw-medium d-flex">
                                <span>{{$ad->country}}</span><span> , </span><span>&nbsp;{{$ad->city}}&nbsp;</span>
                            </span>
                        </h6>
                    </div>
                    <div class="d-flex align-items-end gap-2" >
                        @if($ad->sponsor()->where('type', 'urgent_sale_sticker')->where('expiration_date', '>', now())->exists())
                            <div>
                                <span class="text-white fw-bold p-1 torn-paper-sticker urgent-sale-sticker-text">
                                    {{translate('urgent_sale')}}
                                </span>
                            </div>
                        @endif
                        <div>
                            @if($ad->price_type == 'fixed_price')
                                <h5 class="text-primary currency-font filter-card-price-text"  >{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</h5>
                            @elseif($ad->price_type == 'free')
                                <h5 class="text-primary currency-font filter-card-price-text" >{{translate('free')}}</h5>
                            @elseif($ad->price_type == 'asking_price')
                                <h5 class="text-primary currency-font filter-card-price-text" >{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</h5>
                            @elseif($ad->price_type == 'auction')
                                <h5 class="text-primary currency-font filter-card-price-text" >{{translate('auction')}}</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-sm-6 col-12 mb-4 d-md-none d-block" >
    <div class="product rounded ov-hidden product-card-shadow card-border cursor-default">
        <input type="hidden" data-shown-ads="{{$ad->id}}">
        <!-- Product top -->
        <div class="d-flex flex-column justify-content-between gap-3 scale-image-hover-effect text-center" >
            <div>
                <a href="{{route('ads-show',$ad->slug)}}">
                    <div class="h-100" style="--width: 100%;z-index: 0;">
                        <div class="product__thumbnail h-100 ov-hidden">
                            <img src="{{cloudfront('ad/thumbnail/'.$ad->thumbnail)}}"
                            onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'" loading="lazy"
                            class="img-fit card-product-image h-100 dark-support custom-bottom-border-radius rounded prod-imag2-list" alt="">
                        </div>
                    </div>
                </a>
            </div>

            <div class="d-flex flex-column justify-content-between">
                <div class="w-100" >
                    <div class="d-flex align-items-start justify-content-between mb-3" >
                        <div>
                            <h3 class="text-start p-0 responsive-sides-padding fw-medium responsive-title-font-size" >
                                <a href="{{route('ads-show',$ad->slug)}}">
                                    {{ substr($ad['title'], 0, 55) }}{{ strlen($ad['title']) > 55 ? '...' : '' }}
                                </a>
                            </h3>
                        </div>
                        @php($wishlist = count($ad->wish_list)>0 ? 1 : 0)
                        {{--
                        <div class="d-flex gap-2">
                            <a href="javascript:" onclick="addWishlist('{{$ad['id']}}','{{route('store-wishlist')}}')"
                                id="wishlist-{{$ad['id']}}"
                                class="stopPropagation icon-white-on-hover btn btn-outline-primary px-2 py-1 wishlist-{{$ad['id']}} {{($wishlist == 1?'wishlist_icon_active':'')}}"
                                title="{{ translate('Add to wishlist') }}">
                                <i class="bi bi-heart"></i>
                            </a>
                            <a onclick="location.href='{{route('ads-show',$ad->slug)}}'"
                                class="btn btn-outline-primary stopPropagation px-2 py-1 icon-white-on-hover"
                                title="{{ translate('Show add') }}">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                        --}}
                    </div>

                    <div class="mb-3 text-start" >
                        <h6 class="bg-primary p-0 px-2 rounded fs-12 d-inline text-white" >
                            <i class="bi bi-tags-fill fs-12"></i><span class="mx-1" >{{$ad->category->name ?? '/'}}</span>
                        </h6>
                    </div>
                    <div class="product__price d-flex align-items-end justify-content-between fw-medium">
                        <div class="text-start" >
                            @if($ad->category->category_type == 'vehicles' && $ad->category->slug != 'bicycles')
                                <div class="mb-1 d-flex align-items-center gap-1 flex-wrap" style="font-size: 12px;" >
                                    @if(isset($ad->brand->name))
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 32 32"><path fill="currentColor" d="M28.59 10.78h-2.242a.496.496 0 0 0-.333.134c-.716-1.143-1.457-2.058-2.032-2.633c-2-2-14-2-16 0c-.573.574-1.31 1.483-2.022 2.618a.483.483 0 0 0-.308-.117H3.41c-.275 0-.5.226-.5.5v1.01c0 .274.22.54.49.593l1.36.26c-1.174 2.618-1.866 5.876-.778 9.14v1.937c0 .553.14 1 .313 1h2.562c.173 0 .313-.447.313-1v-1.584c2.298.22 5.55.46 8.812.46c3.232 0 6.52-.236 8.814-.454v1.578c0 .553.14 1 .312 1h2.562c.172 0 .312-.447.312-1l-.002-1.938c1.087-3.26.397-6.516-.775-9.134l1.392-.265a.63.63 0 0 0 .49-.594v-1.01a.498.498 0 0 0-.497-.5zM7.107 18.907a1.813 1.813 0 0 1 0-3.624a1.813 1.813 0 0 1-.001 3.624zm-1.524-5.19C6.543 11.52 7.88 9.8 8.69 8.988c.584-.585 3.34-1.207 7.292-1.207c3.953 0 6.708.623 7.293 1.208c.81.81 2.146 2.53 3.106 4.728c-2.132.236-6.285-.31-10.398-.31s-8.266.546-10.4.31zm19.274 5.19a1.813 1.813 0 0 1 0-3.624a1.813 1.813 0 0 1-.001 3.624z"/></svg>
                                            </span>
                                            <span>{{ $ad->brand->name ?? '/' }}</span>
                                            @if(isset($ad->model->name))
                                                <span> • {{ $ad->model->name ?? '/' }}</span>
                                            @endif
                                        </span>
                                    @endif
                                    @if($ad->year)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span><span><i class="bi bi-calendar-event"></i></span></span>
                                            <span>{{ $ad->year }}</span>
                                        </span>
                                    @endif
                                </div>
                                <div class="mb-1 d-flex align-items-center gap-1 flex-wrap" style="font-size: 12px;" >
                                    @if($ad->mileage)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24">
                                                    <path data-v-35b30767="" fill="currentColor" opacity="1.00" d="M12 14c-.6 0-1 .4-1 1v5c0 .6.4 1 1 1s1-.4 1-1v-5c0-.6-.4-1-1-1Zm0-6c-.6 0-1 .4-1 1v2c0 .6.4 1 1 1s1-.4 1-1V9c0-.6-.4-1-1-1ZM5.2 2c-.6-.1-1.1.3-1.2.8l-3 18c-.1.5.3 1.1.8 1.2H2c.5 0 .9-.3 1-.8l3-18c.1-.6-.3-1.1-.8-1.2ZM12 3c-.6 0-1 .4-1 1v1c0 .6.4 1 1 1s1-.4 1-1V4c0-.6-.4-1-1-1Zm8-.2c-.1-.5-.6-.9-1.2-.8-.5.1-.9.6-.8 1.2l3 18c.1.5.5.8 1 .8h.2c.5-.1.9-.6.8-1.2l-3-18Z"></path>
                                                </svg>
                                            </span>
                                            <span>{{ $ad->mileage }}</span><span>{{ translate('km') }}</span>
                                        </span>
                                    @endif
                                    @if($ad->body_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 197.1" width="24" height="24">
                                                <path fill="currentColor" d="M474.9 65c-19.2-7.9-45.1-8.9-75.2-10.2-9.1-.4-18.4-.8-28.2-1.3l-3.3-2.4C333.3 25.5 300.3 1.4 230.7.1c-.8-.1-1.7-.2-2.6-.1-.2 0-.3 0-.5.1h-2.8C150.2 0 124.7 17.4 92.4 39.5c-2.9 2-5.8 4-8.9 6l-49.1 3.1c-.8.1-1.6.2-2.4.4-12.4 3.7-21.5 16-22.7 30.5-.2 3.5-.3 7-.3 10.7 0 1.7 0 3.4-.1 5.2-4.3 5.2-5.9 12.7-5.9 18.7V135c0 19.1 11.2 31.9 27.7 31.9h47.4c8.1 17.8 26 30.3 46.8 30.3s38.7-12.4 46.8-30.3h173.8c8.1 17.8 26 30.3 46.8 30.3 20.8 0 38.8-12.5 46.8-30.3h4.5c2.8 0 5.4.1 8.1.1 26.4 0 44.5-2 52.7-10.1 3.1-3 4.8-7 4.8-11.1v-24.7c-.1-28.3-11.3-46.6-34.3-56.1zM219.5 21l2.8 32.2H178c-12.5 0-23.2-.1-27.5-1.8-1.3-.5-2.2-.9-4.8-7.8l-2.9-9.4c18-7.8 40.6-12.7 76.7-13.2zm23.8 32.3-2.7-31.8c43.6 2.5 70 15.3 94.6 31.8h-91.9zM124.9 176.1c-16.7 0-30.3-13.6-30.3-30.3s13.6-30.3 30.3-30.3 30.3 13.6 30.3 30.3-13.6 30.3-30.3 30.3zm267.4 0c-16.7 0-30.3-13.6-30.3-30.3s13.6-30.3 30.3-30.3 30.3 13.6 30.3 30.3-13.6 30.3-30.3 30.3zm95.8-33.5c-3.9 1.5-14.7 3.7-44.2 3.3h-.2v-.1c0-28.3-23-51.3-51.3-51.3-28.3 0-51.3 23-51.3 51.3v.1H176.2v-.1c0-28.3-23-51.3-51.3-51.3s-51.3 23-51.3 51.3v.1H30.7c-4.5 0-6.7-3.7-6.7-10.9v-20.8c0-2.1.6-4.2 1-5.1 2.8-1.8 4.5-4.9 4.7-8.2.2-3.7.2-7.2.3-10.4 0-3.4.1-6.6.3-9.3.4-5.4 3.2-10.1 6.8-11.7l50.5-3.2c1.8-.1 3.6-.7 5.1-1.7 4-2.7 7.8-5.2 11.5-7.7 6.7-4.6 13-8.9 19.5-12.8l1.9 6.1c.1.2.1.4.2.6 3.2 8.4 6.8 16.3 16.9 20.2 7.2 2.9 16.3 3.3 35.3 3.3h189.6c10.9.7 21.3 1.1 31.3 1.5 28.1 1.2 52.3 2.1 68.1 8.6 11 4.5 21.1 12.1 21.1 36.7v21.5z"/>
                                            </svg>
                                            <span>{{ translate($ad->body_type) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->fuel_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <i class="bi bi-fuel-pump-diesel"></i>
                                            </span>
                                            <span>{{ translate($ad->fuel_type) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->transmission_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 512 512"><path fill="currentColor" d="M82.64 48.26a51.94 51.94 0 0 0-51.68 51.94a51.94 51.94 0 0 0 42.2 50.9v209.7a51.94 51.94 0 0 0-42.2 51a51.94 51.94 0 0 0 51.94 51.9a51.94 51.94 0 0 0 51.9-51.9a51.94 51.94 0 0 0-42.15-51v-95.1H246.2v95.1a51.94 51.94 0 0 0-42.2 51a51.94 51.94 0 0 0 52 51.9a51.94 51.94 0 0 0 51.9-51.9a51.94 51.94 0 0 0-42.2-51v-95.1h173.1V151.1a51.94 51.94 0 0 0 42.2-50.9a51.94 51.94 0 0 0-51.9-51.94a51.94 51.94 0 0 0-.2 0a51.94 51.94 0 0 0-51.7 51.94a51.94 51.94 0 0 0 42.2 50.9v95.1H265.7v-95.1a51.94 51.94 0 0 0 42.2-50.9A51.94 51.94 0 0 0 256 48.26a51.94 51.94 0 0 0-.2 0A51.94 51.94 0 0 0 204 100.2a51.94 51.94 0 0 0 42.2 50.9v95.1H92.65v-95.1a51.94 51.94 0 0 0 42.15-50.9a51.94 51.94 0 0 0-51.9-51.94a51.94 51.94 0 0 0-.26 0z"/></svg>
                                            </span>
                                            <span>{{ translate($ad->transmission_type) }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            @if($ad->category->category_type == 'furniture')
                                <div class="mb-1 d-flex align-items-center gap-1 flex-wrap" style="font-size: 12px;" >
                                    @if($ad->furniture_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg width="17" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M64 160C64 89.3 121.3 32 192 32l256 0c70.7 0 128 57.3 128 128l0 33.6c-36.5 7.4-64 39.7-64 78.4l0 48-384 0 0-48c0-38.7-27.5-71-64-78.4L64 160zM544 272c0-20.9 13.4-38.7 32-45.3c5-1.8 10.4-2.7 16-2.7c26.5 0 48 21.5 48 48l0 176c0 17.7-14.3 32-32 32l-32 0c-17.7 0-32-14.3-32-32L96 448c0 17.7-14.3 32-32 32l-32 0c-17.7 0-32-14.3-32-32L0 272c0-26.5 21.5-48 48-48c5.6 0 11 1 16 2.7c18.6 6.6 32 24.4 32 45.3l0 48 0 32 32 0 384 0 32 0 0-32 0-48z"/></svg>
                                            </span>
                                            <span>{{ translate($ad->furniture_type) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->material)
                                        <span class="d-flex align-items-center gap-1" >
                                            <img width="17px" src="{{ theme_asset('assets/img/svg/material-gray.svg') }}" alt="">
                                            <span>{{ translate($ad->material) }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            @if($ad->category->category_type == 'vehicles' && $ad->category->slug == 'bicycles')
                                <div class="mb-1 d-flex align-items-center gap-1 flex-wrap" style="font-size: 12px;" >
                                    @if(isset($ad->brand->name))
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>

                                            </span>
                                            <span>{{ $ad->brand->name ?? '/' }}</span>
                                        </span>
                                    @endif
                                    @if($ad->bicycle_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <i class="bi bi-bicycle"></i>
                                            </span>
                                            <span>{{ translate($ad->bicycle_type) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->bicycle_size)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <i class="bi bi-arrows-angle-expand"></i>
                                            </span>
                                            <span>{{ $ad->bicycle_size }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            @if($ad->category->category_type == 'industrial machines')
                                <div class="mb-1 d-flex align-items-center gap-1 flex-wrap" style="font-size: 12px;" >
                                    @if(isset($ad->brand->name))
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>{{ $ad->brand->name ?? '/' }}</span>
                                        </span>
                                    @endif
                                    @if($ad->manufacturer)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>{{ $ad->manufacturer }}</span>
                                        </span>
                                    @endif
                                    @if($ad->year)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <span><span><i class="bi bi-calendar-event"></i></span></span>
                                            </span>
                                            <span>{{ $ad->year }}</span>
                                        </span>
                                    @endif
                                    @if($ad->power_source)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg width="15" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M349.4 44.6c5.9-13.7 1.5-29.7-10.6-38.5s-28.6-8-39.9 1.8l-256 224c-10 8.8-13.6 22.9-8.9 35.3S50.7 288 64 288l111.5 0L98.6 467.4c-5.9 13.7-1.5 29.7 10.6 38.5s28.6 8 39.9-1.8l256-224c10-8.8 13.6-22.9 8.9-35.3s-16.6-20.7-30-20.7l-111.5 0L349.4 44.6z"/></svg>
                                            </span>
                                            <span>{{ translate($ad->power_source) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->power_capacity)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg width="15" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M349.4 44.6c5.9-13.7 1.5-29.7-10.6-38.5s-28.6-8-39.9 1.8l-256 224c-10 8.8-13.6 22.9-8.9 35.3S50.7 288 64 288l111.5 0L98.6 467.4c-5.9 13.7-1.5 29.7 10.6 38.5s28.6 8 39.9-1.8l256-224c10-8.8 13.6-22.9 8.9-35.3s-16.6-20.7-30-20.7l-111.5 0L349.4 44.6z"/></svg>
                                            </span>
                                            <span>{{ $ad->power_capacity }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            @if($ad->category->category_type == 'real estate')
                                <div class="mb-1 d-flex align-items-center gap-1 flex-wrap" style="font-size: 12px;" >
                                    @if($ad->listing_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg width="17" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c.2 35.5-28.5 64.3-64 64.3l-320.4 0c-35.3 0-64-28.7-64-64l0-160.4-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L416 100.7 416 64c0-17.7 14.3-32 32-32l32 0c17.7 0 32 14.3 32 32l0 121 52.8 46.4c8 7 12 15 11 24zM248 192c-13.3 0-24 10.7-24 24l0 80c0 13.3 10.7 24 24 24l80 0c13.3 0 24-10.7 24-24l0-80c0-13.3-10.7-24-24-24l-80 0z"/></svg>
                                            </span>
                                            <span>{{ translate($ad->listing_type) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->property_size)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <i class="bi bi-arrows-angle-expand"></i>
                                            </span>
                                            <span>{{ $ad->property_size }}<span class="fs-12" >{{translate('km²')}}</span></span>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            @if($ad->category->category_type == 'shipbuilding marine')
                                <div class="mb-1 d-flex align-items-center gap-1 flex-wrap" style="font-size: 12px;" >
                                    @if($ad->shipbuilding_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg width="17px" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M256 16c0-7 4.5-13.2 11.2-15.3s13.9 .4 17.9 6.1l224 320c3.4 4.9 3.8 11.3 1.1 16.6s-8.2 8.6-14.2 8.6l-224 0c-8.8 0-16-7.2-16-16l0-320zM212.1 96.5c7 1.9 11.9 8.2 11.9 15.5l0 224c0 8.8-7.2 16-16 16L80 352c-5.7 0-11-3-13.8-8s-2.9-11-.1-16l128-224c3.6-6.3 11-9.4 18-7.5zM5.7 404.3C2.8 394.1 10.5 384 21.1 384l533.8 0c10.6 0 18.3 10.1 15.4 20.3l-4 14.3C550.7 473.9 500.4 512 443 512L133 512C75.6 512 25.3 473.9 9.7 418.7l-4-14.3z"/></svg>
                                            </span>
                                            <span>{{ translate($ad->shipbuilding_type) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->year)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span><span><i class="bi bi-calendar-event"></i></span></span>
                                            <span>{{ $ad->year }}</span>
                                        </span>
                                    @endif
                                    @if($ad->maximum_speed)
                                        <span class="d-flex align-items-center gap-1" >
                                            <svg width="17px" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M192 32c0-17.7 14.3-32 32-32L352 0c17.7 0 32 14.3 32 32l0 32 48 0c26.5 0 48 21.5 48 48l0 128 44.4 14.8c23.1 7.7 29.5 37.5 11.5 53.9l-101 92.6c-16.2 9.4-34.7 15.1-50.9 15.1c-19.6 0-40.8-7.7-59.2-20.3c-22.1-15.5-51.6-15.5-73.7 0c-17.1 11.8-38 20.3-59.2 20.3c-16.2 0-34.7-5.7-50.9-15.1l-101-92.6c-18-16.5-11.6-46.2 11.5-53.9L96 240l0-128c0-26.5 21.5-48 48-48l48 0 0-32zM160 218.7l107.8-35.9c13.1-4.4 27.3-4.4 40.5 0L416 218.7l0-90.7-256 0 0 90.7zM306.5 421.9C329 437.4 356.5 448 384 448c26.9 0 55.4-10.8 77.4-26.1c0 0 0 0 0 0c11.9-8.5 28.1-7.8 39.2 1.7c14.4 11.9 32.5 21 50.6 25.2c17.2 4 27.9 21.2 23.9 38.4s-21.2 27.9-38.4 23.9c-24.5-5.7-44.9-16.5-58.2-25C449.5 501.7 417 512 384 512c-31.9 0-60.6-9.9-80.4-18.9c-5.8-2.7-11.1-5.3-15.6-7.7c-4.5 2.4-9.7 5.1-15.6 7.7c-19.8 9-48.5 18.9-80.4 18.9c-33 0-65.5-10.3-94.5-25.8c-13.4 8.4-33.7 19.3-58.2 25c-17.2 4-34.4-6.7-38.4-23.9s6.7-34.4 23.9-38.4c18.1-4.2 36.2-13.3 50.6-25.2c11.1-9.4 27.3-10.1 39.2-1.7c0 0 0 0 0 0C136.7 437.2 165.1 448 192 448c27.5 0 55-10.6 77.5-26.1c11.1-7.9 25.9-7.9 37 0z"/></svg>
                                            <span>{{ $ad->maximum_speed }}<span class="fs-12" >{{translate('km/h')}}</span></span>
                                        </span>
                                    @endif
                                    @if($ad->fuel_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <i class="bi bi-fuel-pump-diesel"></i>
                                            <span>{{ translate($ad->fuel_type) }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif

                            @if($ad->category->category_type == 'home appliances')
                                <div class="mb-1 d-flex align-items-center gap-1 flex-wrap" style="font-size: 12px;" >
                                    @if(isset($ad->custom_brand))
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>

                                            </span>
                                            <span>{{ $ad->custom_brand ?? '/' }}</span>
                                        </span>
                                    @endif
                                    @if($ad->home_appliance_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <img width="25px" src="{{ theme_asset('assets/img/svg/home-appliance-type.svg') }}" alt="">
                                            </span>
                                            <span>{{ translate($ad->home_appliance_type) }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif

                            @if($ad->category->category_type == 'home garden')
                                <div class="mb-1 d-flex align-items-center gap-1 flex-wrap" style="font-size: 12px;" >
                                    @if(isset($ad->custom_brand))
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg width="17" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M343.9 213.4L245.3 312l65.4 65.4c7.9 7.9 11.1 19.4 8.4 30.3s-10.8 19.6-21.5 22.9l-256 80c-11.4 3.5-23.8 .5-32.2-7.9S-2.1 481.8 1.5 470.5l80-256c3.3-10.7 12-18.9 22.9-21.5s22.4 .5 30.3 8.4L200 266.7l98.6-98.6c-14.3-14.6-14.2-38 .3-52.5l95.4-95.4c26.9-26.9 70.5-26.9 97.5 0s26.9 70.5 0 97.5l-95.4 95.4c-14.5 14.5-37.9 14.6-52.5 .3z"/></svg>
                                            </span>
                                            <span>{{ $ad->custom_brand ?? '/' }}</span>
                                        </span>
                                    @endif
                                    @if($ad->material)
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <img width="17px" src="{{ theme_asset('assets/img/svg/material-gray.svg') }}" alt="">
                                            </span>
                                            <span>{{ translate($ad->material) }}</span>
                                        </span>
                                    @endif
                                    @if($ad->usage_type)
                                        <span class="d-flex align-items-center gap-1" >
                                            <img width="17px" src="{{ theme_asset('assets/img/svg/usage-gray.svg') }}" alt="">
                                            <span>{{ translate($ad->usage_type) }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif

                            @if($ad->category->category_type == 'electronics')
                                <div class="mb-1 d-flex align-items-center gap-1 flex-wrap" style="font-size: 12px;" >
                                    @if($ad->electronic_type)
                                    <span class="d-flex align-items-center gap-1" >
                                        <span>
                                            <svg width="17px" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M176 24c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40c-35.3 0-64 28.7-64 64l-40 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l40 0 0 56-40 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l40 0 0 56-40 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l40 0c0 35.3 28.7 64 64 64l0 40c0 13.3 10.7 24 24 24s24-10.7 24-24l0-40 56 0 0 40c0 13.3 10.7 24 24 24s24-10.7 24-24l0-40 56 0 0 40c0 13.3 10.7 24 24 24s24-10.7 24-24l0-40c35.3 0 64-28.7 64-64l40 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-40 0 0-56 40 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-40 0 0-56 40 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-40 0c0-35.3-28.7-64-64-64l0-40c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40-56 0 0-40c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40-56 0 0-40zM160 128l192 0c17.7 0 32 14.3 32 32l0 192c0 17.7-14.3 32-32 32l-192 0c-17.7 0-32-14.3-32-32l0-192c0-17.7 14.3-32 32-32zm192 32l-192 0 0 192 192 0 0-192z"/></svg>
                                        </span>
                                        <span>{{ translate($ad->electronic_type) }}</span>
                                    </span>
                                    @endif
                                    @if(isset($ad->custom_brand))
                                        <span class="d-flex align-items-center gap-1" >
                                            <span>
                                                <svg width="17px" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M384 96l0 224L64 320 64 96l320 0zM64 32C28.7 32 0 60.7 0 96L0 320c0 35.3 28.7 64 64 64l117.3 0-10.7 32L96 416c-17.7 0-32 14.3-32 32s14.3 32 32 32l256 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-74.7 0-10.7-32L384 384c35.3 0 64-28.7 64-64l0-224c0-35.3-28.7-64-64-64L64 32zm464 0c-26.5 0-48 21.5-48 48l0 352c0 26.5 21.5 48 48 48l64 0c26.5 0 48-21.5 48-48l0-352c0-26.5-21.5-48-48-48l-64 0zm16 64l32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16s7.2-16 16-16zm-16 80c0-8.8 7.2-16 16-16l32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16zm32 160a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                                            </span>
                                            <span>{{ $ad->custom_brand ?? '/' }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="w-100 d-flex align-items-end justify-content-between mt-2" >
                    {{--
                        <div>
                            <h6 class="d-flex align-items-end gap-1" >
                                <i class="bi bi-geo-alt"></i>
                                <span class="fw-medium d-flex">
                                    <span>{{$ad->country}}</span><span> , </span><span>&nbsp;{{$ad->city}}&nbsp;</span>
                                </span>
                            </h6>
                        </div>
                    --}}
                    <div style="font-size: 11px;" >
                        <span class="d-flex align-items-center gap-1" >
                            <span>{{ date('d M y', strtotime($ad->created_at)) }} ({{ $ad->created_at->diffForHumans() }})</span>
                            <span>{{ date('d M y', strtotime($ad->created_at)) }} ({{ $ad->created_at->locale($locale)->diffForHumans() }})</span>
                        </span>
                    </div>
                    <div class="d-flex align-items-end gap-1" >
                        @if($ad->sponsor()->where('type', 'urgent_sale_sticker')->where('expiration_date', '>', now())->exists())
                            <div>
                                <span class="text-white fw-bold p-1 torn-paper-sticker urgent-sale-sticker-text">
                                    {{translate('urgent_sale')}}
                                </span>
                            </div>
                        @endif
                        <div>
                            @if($ad->price_type == 'fixed_price')
                                <h5 class="text-primary currency-font filter-card-price-text"  >{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</h5>
                            @elseif($ad->price_type == 'free')
                                <h5 class="text-primary currency-font filter-card-price-text" >{{translate('free')}}</h5>
                            @elseif($ad->price_type == 'asking_price')
                                <h5 class="text-primary currency-font filter-card-price-text" >{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</h5>
                            @elseif($ad->price_type == 'auction')
                                <h5 class="text-primary currency-font filter-card-price-text" >{{translate('auction')}}</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@extends('theme-views.layouts.home-app')

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <style>

        @font-face {
            font-family: 'NotoColorEmojiLimited';
            unicode-range: U+1F1E6-1F1FF;
            src: url('https://raw.githack.com/googlefonts/noto-emoji/main/fonts/NotoColorEmoji.ttf') format('truetype');
        }

        .emoji-font {
            font-family: 'NotoColorEmojiLimited', -apple-system, BlinkMacSystemFont, 
            'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 
            'Segoe UI Emoji', 'Segoe UI Symbol';
        }

        .select-category-button {
            display: none;
        }
        .position-relative {
                position: relative;
        }
        .category-name {
            position: absolute;
            top: 75px;
            right: 30px;
            margin: 0px;
            background: rgba(0, 0, 0, 0.5);
            background: linear-gradient(to bottom right, #00008b, #1e90ff); /* تدرج لوني من الأزرق الداكن إلى الأزرق الفاتح */
            color: white;
            width: 205px; 
            height: 55px;
            /* padding: 0 20px; */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            border-radius: 5px;
            text-align: center;
            overflow: hidden; /* إخفاء الفائض */
            text-overflow: ellipsis; /* نقاط للحذف */
            white-space: nowrap; /* منع التفاف النص */
        }
        /* @media (max-width: 990px) and (min-width: 767px) {
            .category-name {
                padding: 7px;
                font-size: 13px;
                right: 28px;
            }
        } */

        .home-banner-swiper {
            width: 100%;
            height: 180px;
        }
        .secondary-swiper {
            width: 100%;
            height: 140px;
        }
        .swiper-slide {
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;

        }
        .secondary-swiper .swiper-slide {
            border: 1px solid #d4d4d4;
        }

        .swiper-slide img {
            width: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .secondary-swiper .swiper-slide img {
            object-fit: fill;
        }

        .secondary-swiper .swiper-slide img {
            width: 95px;
            height: 80px;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
                color: black !important;
            }
        .select2-selection__clear {
            display: none !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid gray !important;
            border-radius: 4px !important;
        }
        .select2-container .select2-selection--single .select2-selection__rendered {
            border: 1px solid #dbdbdb !important;
            border-radius: 6px !important;
        }

        .select2.select2-container {
            display: block !important;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            border: none !important;
        }
        .select2-container--default .select2-selection--single {
            border: none !important;
        }
        .select2-dropdown {
            top: 12px !important;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            height: 36px !important;
        }

        .modal-backdrop {
            display: none !important;
        }

        @media (min-width: 576px) {
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 38px !important;
                height: 40px !important;
            }
        }
        
        @media (max-width: 575px) {
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 36px !important;
                height: 38px !important;
            }
        }
    </style>

@endpush

@section('title', $web_config['name']->value.' '.translate('Online_Shopping').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@php($lang=app()->getLocale())

@section('content')
    
    <main class="main-content d-flex flex-column gap-3 py-3">
        <div>

            
            <div class="px-sm-3" >
                <div class="d-flex align-items-center gap-2 my-4 " >
                    <h2>{{translate('all_ads_of_category')}} :</h2> 
                    <h6 class="mt-1 fs-14">
                        <span class="bg-primary py-2 px-2 rounded text-light">
                            <i class="bi bi-tags-fill"></i>
                            <span id="dynamic-cat-name" >{{$category_name}}</span>
                        </span>
                    </h6>
                </div>
                <div class="auto-col mobile-items-2 gap-2 gap-sm-3 recommended-product-grid" style="--minWidth: 12rem;">
                    @foreach($ads as $ad)
                        @include('theme-views.partials._product-large-card',['ad'=>$ad])
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')

@endpush







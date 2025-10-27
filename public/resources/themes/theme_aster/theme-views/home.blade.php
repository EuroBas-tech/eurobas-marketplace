@extends('theme-views.layouts.home-app')

@section('title', $web_config['name']->value.' '.translate('Online_Shopping').' | '.$web_config['name']->value.' '.translate('ecommerce'))
@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">
@endpush
@php($lang=app()->getLocale())

@section('content')
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

    .swiper {
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

</style>
    
    <main class="main-content d-flex flex-column gap-3 py-3">
        <!-- Main Banner -->
        <div class="container" >
            <div
            style="background: url('{{asset('storage/app/public/banner/main-background-img')}}') 
                no-repeat;background-size: cover;background-position: 50%;
                height: calc(95vh - 135px);
                max-height: 520px;"
                class="pt-2 rounded d-flex align-items-end mb-3"
            >
                <div class="d-flex mx-auto align-items-center 
                justify-content-center w-100 p-2 px-5" style="border-radius: 4px 4px 0 0;" >
                    @include('theme-views.partials._ad-filter')
                </div>
            </div>
        </div>

        <div class="container" >
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="https://img.freepik.com/free-psd/car-rental-automotive-facebook-cover-template_120329-4447.jpg?semt=ais_hybrid&w=740" 
                        alt="Image 1">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://img.freepik.com/free-psd/car-rental-automotive-facebook-cover-template_106176-2483.jpg" 
                        alt="Image 2">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://www.aboudcar.com/wp-content/uploads/2017/10/GAC_Hyundai-Banner-.jpg" 
                        alt="Image 3">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://graphicsfamily.com/wp-content/uploads/edd/2021/07/Car-Dealer-or-Showroom-Editable-Banner-Design-Template-scaled.jpg" 
                        alt="Image 4">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://www.aboudcar.com/wp-content/uploads/2017/10/GAC_Hyundai-Banner-.jpg" 
                        alt="Image 5">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://storage.pixteller.com/designs/designs-images/2020-12-21/04/rent-a-car-sale-banner-1-5fe0b5604db74.png" 
                        alt="Image 6">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recommended For You -->
        @include('theme-views.partials._recommended-product')
        
        <!-- Show System Vehicle Brands -->
        @include('theme-views.partials._brands')
            
    </main>
@endsection




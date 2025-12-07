@extends('theme-views.layouts.home-app')

@push('css_or_js')
    <meta property="og:image" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <meta property="twitter:card" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

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
        /* Add this CSS to fix only the paid banners section */
        .home-banner-swiper {
            overflow: hidden !important;
            max-width: 100vw !important;
        }
        .home-banner-swiper .swiper-wrapper {
            max-width: 100% !important;
        }
        .home-banner-swiper .swiper-slide {
            max-width: 100% !important;
        }
        .home-banner-swiper .swiper-slide img {
            width: 100% !important;
            max-width: 100% !important;
            height: 170 !important;
        }

        @media (min-width: 576px) {
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 38px !important;
                height: 40px !important;
                font-size: 16px;
            }
        }
        @media (max-width: 575px) {
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 36px !important;
                height: 38px !important;
            }
        }
        .hero-background-image {
            background: url("{{ cloudfront('banner') }}/{{ $banner['photo'] ?? '' }}") no-repeat;
            background-size: cover;
        }
        .hero-card {
            background-size: cover;
            background-position: 20% 20%;
            height: 200px;
        }
        /* For RTL screens */
        :dir(rtl) .hero-card {
            background-position: 75% 20%;
        }
        @media (min-width: 768px) {
            .hero-card {
                height: 280px;
            }
        }
    </style>

@endpush

@section('title', $web_config['name']->value.' - '.translate('Europe’s marketplace').' | '.translate('Europe’s Auto Market'))

@php($lang=app()->getLocale())

@section('content')

    <main class="main-content d-flex flex-column gap-3 pt-0 pt-lg-3 pb-3">
        <!-- Main Banner -->
        <div class="container" >

            @php($isMobile = request()->header('User-Agent') && preg_match('/Mobile|Android|iP(ad|hone)/i', request()->header('User-Agent')))

            @if($isMobile)
                <div class="mobile-hero-wrapper">
                    <!-- Background Card -->
                    <div class="card rounded overflow-hidden mb-3 hero-card hero-background-image"></div>
                    <!-- Filter Under Card -->
                    <div class="d-flex mx-auto align-items-center justify-content-center
                        w-100 p-2 px-2 mb-3" style="border-radius: 4px; background: #fff;">
                        @include('theme-views.partials._ad-filter-mobile')
                    </div>
                </div>
            @else
                <div style="background-position: 50%;height: calc(95vh - 135px);max-height: 520px;"
                    class="hero-background-image pt-2 rounded d-flex align-items-end mb-3">
                    <div class="d-flex mx-auto align-items-center justify-content-center
                        w-100 p-2 px-4 px-sm-5" style="border-radius: 4px 4px 0 0;">
                        @include('theme-views.partials._ad-filter')
                    </div>
                </div>
            @endif
        </div>

        <div class="container" >
            <div class="home-banner-swiper">
                <div class="swiper-wrapper">
                    @foreach($paid_banners as $banner)
                    <div class="swiper-slide" onclick="window.location.href='{{$banner->banner_url}}'" role="button">
                        <img src="{{ {{ cloudfront('paid-banners') }}/{{ $banner->banner_image }}"
                        alt="banner_image">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recommended For You -->
        @include('theme-views.partials._recommended-product')

    </main>
@endsection

@push('script')

    <script>
        // Initialize Swiper FIRST
        const swiper = new Swiper('.home-banner-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            slidesPerGroup: 1,
            loop: false,
            navigation: false,
            speed: 1200,
            autoplay: {
                delay: 10000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                }
            },
        });
    </script>

    <script>
        $(document).ready(function () {
            let isCategoryChanging = false;

            $('.filter-input').on('change', function () {
                if (isCategoryChanging) {
                    return;
                }
                filterAds($(this));
            });

            function filterAds(changedInput) {
                const parentForm = changedInput.closest('form');
                const formData = parentForm.serialize();

                parentForm.find('.filter_count_loader').removeClass('d-none');

                $.ajax({
                    url: "{{ route('ads-filter-count') }}",
                    method: "GET",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        parentForm.find('.ads-count-number').text(response.count);
                    },
                    error: function (xhr) {
                        console.error("AJAX Error: ", xhr.responseText);
                    },
                    complete: function () {
                        parentForm.find('.filter_count_loader').addClass('d-none');
                    }
                });
            }

            window.triggerFilterManually = function (clickedElement) {
                isCategoryChanging = true;
                
                $('#selectedCategoryId').val($(clickedElement).data('id'));
                
                $('.form-data select').each(function () {
                    $(this).prop('selectedIndex', 0);
                });
                $('#brand').val('all').trigger('change');
                $('#model').val('all').trigger('change');
                
                isCategoryChanging = false;
                filterAds($('#selectedCategoryId'));
            };
        });
    </script>
@endpush







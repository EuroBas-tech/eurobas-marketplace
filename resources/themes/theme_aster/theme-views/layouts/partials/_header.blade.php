<!-- Top Offer Bar -->
@if (isset($web_config['announcement']) && $web_config['announcement']['status']==1)
    <div class="offer-bar py-3 announcement-color" data-bg-img="{{theme_asset('assets/img/media/top-offer-bg.png')}}">
        <div class="d-flex gap-2 align-items-center">
            <div class="offer-bar-close">
                <i class="bi bi-x-lg"></i>
            </div>
            <div class="top-offer-text flex-grow-1 d-flex justify-content-center fw-semibold ">
                {{ $web_config['announcement']['announcement'] }}
            </div>
        </div>
    </div>

    <div class="up-header p-2 p-sm-2" style="background-color:#005eca" >
        <h1 class="text-center text-white"  style="font-weight: 800;"> {{ translate('Euro Marketn') }}</h1>
        <h2 class="text-center text-white" style="font-weight: 600;">
        {!! trans('messages.marketplace') !!}
        </h2>
    </div>
@endif

@php(
    $categories = Cache::rememberForever('home_categories', function () {
        return \App\Model\Category::homeEnabled()
        ->priority()
        ->take(11)
        ->get();
    })
)

@php(
    $brands = Cache::rememberForever('active_brands', function () {
        return \App\Model\Brand::active()
        ->take(14)
        ->get();
    })
)

@php(
    $sponsorTypes = Cache::rememberForever('sponsor_types', function () {
        return \App\Model\SponsoredAdType::where('status', 1)->pluck('status', 'name');
    })
)

    <style>

        .complete-profile-bar {
            background-color: #7280FD;
            color: #fff;
        }

        .text-orange {
            color: #c65919;
        }

        .sidebar {
            height: 100%;
            width: 300px;
            transform: translateX(-335px);
            position: fixed;
            z-index: 99999;
            top: 0;
            left: 0;
            background: #fff;
            overflow-x: hidden;
            transition: 0.4s;
            padding: 60px 18px;
        }

        .sidebar a {
            padding: 8px 0 8px 32px;
            text-decoration: none;
            font-size: 18px;
            color: #001E61;
            display: block;
            transition: 0.3s;
            /* text-align: right; */
        }

        .sidebar a:hover {
            opacity: 70%;
        }

        .sidebar .closebtn {
            position: absolute;
            top: 15px;
            right: 18px;
        }

        /* Style the scrollbar for the specific div */
        #mySidebar::-webkit-scrollbar {
            width: 10px;
        }

        #mySidebar::-webkit-scrollbar-track {
            background: #f0f0f0; /* Light gray background */
            border-radius: 10px;
        }

        #mySidebar::-webkit-scrollbar-thumb {
            background: #6c757d;
            border-radius: 7px;
        }

        #mySidebar::-webkit-scrollbar-thumb:hover {
            background: darkgray;
        }

        .openbtn {
            /* font-size: 20px; */
            cursor: pointer;
            /* background-color: #111; */
            padding: 10px 15px;
            border: none;
        }

        #main {
            transition: margin-left .5s;
            padding: 16px;
        }

        .dropdown-menu.show.grid-dropdown {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 10px !important;
            max-height: 500px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #888  #f1f1f1;
            scroll-behavior: smooth;
        }

        /* Custom scrollbar for WebKit browsers */
        .dropdown-menu.show.grid-dropdown::-webkit-scrollbar {
            width: 8px; /* Adjust width */
        }

        .custom-vertical-padding {
            padding: 6.5px 0px;
        }

        /* CSS Code - Add this to your stylesheet */
        .pointing-hand {
            position: relative;
            display: inline-block;
        }

        .pointing-hand::after {
            content: '👉';
            position: absolute;
            top: 50%;
            font-size: 1.3em;
            color: #FFD700;
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.3));
            transform: translateY(-50%);
        }

        /* Left to Right (LTR) - Hand points from left to the element */
        .pointing-hand.left-direction::after {
            left: -60px;
            animation: pointRight 2s infinite;
        }

        .dropdown-btn-font-size {
            font-size: 0.88rem;
        }

        .sponsor-dropdown-list:hover , .sponsor-dropdown-item:hover {
            background-color: #fff !important;
        }

        .modal-content.sponsor-modal {
            width: max-content !important;
            min-width: 900px !important;
            margin: auto !important;
        }

        .border-cool-primary {
            border-color: #0f407d86 !important;
        }

        .sponsor-card:hover {
            transition: .2s;
            border-width: 2px;
            background-color: #e7e7e795 !important;
        }

        .voice-search-icon {
            font-size: 16px;
            color: #666666ff;
        }


        /***************** start voice recording css code  ***********/

/* Simple Voice Search Styles */

/* Make sure button can position the dot */
.search_voice {
    position: relative !important;
}

/* Recording pulse indicator - small blinking red dot over icon */
.recording-pulse {
    position: absolute;
    top: 5px;
    right: 10px;
    width: 8px;
    height: 8px;
    background-color: #ff4444;
    border-radius: 50%;
    z-index: 1000;
    pointer-events: none;
    opacity: 0; /* Hidden by default */
}

/* Show and blink the dot when recording */
.search_voice.recording .recording-pulse {
    opacity: 1;
    animation: blink 0.8s ease-in-out infinite;
}

/* Simple blinking animation - show/hide */
@keyframes blink {
    0%, 50% {
        opacity: 1;
    }
    51%, 100% {
        opacity: 0;
    }
}

/* Voice search icon styles */
.voice-search-icon {
    transition: color 0.3s ease;
}

/* Hover effect for voice button */
.search_voice:hover:not(.recording) {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.search_voice:hover:not(.recording) .voice-search-icon {
    color: #007bff;
}

/* Recording state icon - red color */
.search_voice.recording .voice-search-icon {
    color: #ff4444 !important;
}

        /***************** end voice recording css code  ***********/


        @keyframes pointRight {
            0%, 100% {
                transform: translateY(-50%) translateX(0);
            }
            50% {
                transform: translateY(-50%) translateX(15px);
            }
        }

        /* Right to Left (RTL) - Hand points from right to the element */
        .pointing-hand.right-direction::after {
            content: '👈';
            right: -60px;
            animation: pointLeft 2s infinite;
        }

        @keyframes pointLeft {
            0%, 100% {
                transform: translateY(-50%) translateX(0);
            }
            50% {
                transform: translateY(-50%) translateX(-15px);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .pointing-hand.left-direction::after {
                left: -40px;
                font-size: 1.2em;
            }

            .pointing-hand.right-direction::after {
                right: -40px;
                font-size: 1.2em;
            }
        }

        /* Modern Menu Css Code Start */

        .modern-menu .nav-menu {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 0;
            padding: 0;
            overflow: visible;
        }

        .modern-menu .nav-item {
            position: relative;
            display: inline-block;
        }

        .modern-menu .nav-link {
            display: block;
            padding: 18px 30px;
            text-decoration: none;
            color: #333;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            border-radius: 12px;
            white-space: nowrap;
            position: relative;
        }

        /* Dropdown Container */
        .modern-menu .dropdown {
            position: absolute;
            top: 100%;
            width: max-content;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 9999999999999 !important;
            /* min-width: 1030px; */
            margin-top: 10px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .modern-menu .dropdown::before {
            content: '';
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid white;
            z-index: 9999999999999 !important;
        }

        .modern-menu .dropdown::after {
            content: '';
            position: absolute;
            top: -9px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 9px solid transparent;
            border-right: 9px solid transparent;
            border-bottom: 9px solid rgba(0, 0, 0, 0.1);
            z-index: 9999999999998 !important;
        }

        /* Horizontal dropdown content */
        .modern-menu .dropdown-content {
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
            gap: 20px;
            justify-content: center;
            transition: all 0.4s ease;
            position: relative;
            z-index: 9999999999999 !important;
        }

        /* Card styling similar to Bootstrap cards */
        .modern-menu .card {
            background: white;
            border: 1px solid #e3e6f0;
            border-radius: 12px;
            padding: 24px;
            width: 230px;
            text-align: center;
            transition: all 0.4s ease;
            cursor: pointer;
            transform: translateY(10px);
            opacity: 1;
            position: relative;
            z-index: 9999999999999 !important;
        }

        .modern-menu .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.06);
            border-color: #667eea;
            z-index: 9999999999999 !important;
        }

        .modern-menu .card a {
            position: relative;
            z-index: 9999999999999 !important;
        }

        .modern-menu .card-icon {
            font-size: 2.5rem;
            margin-bottom: 16px;
            display: block;
            position: relative;
            z-index: 9999999999999 !important;
        }

        .modern-menu .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 12px;
            margin-top: 0;
            position: relative;
            z-index: 9999999999999 !important;
        }

        .modern-menu .card-text {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 20px;
            margin-top: 0;
            position: relative;
            z-index: 9999999999999 !important;
        }

        .modern-menu .card-btn {
            display: inline-block;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            position: relative;
            z-index: 9999999999999 !important;
        }

        /* Show dropdown on hover */
        .modern-menu .nav-item:hover .dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
            z-index: 9999999999999 !important;
        }

        .modern-menu .nav-item:hover .card {
            transform: translateY(0);
            z-index: 9999999999999 !important;
        }

        .modern-menu .nav-item:hover .card:nth-child(1) {
            transition-delay: 0.1s;
        }

        .modern-menu .nav-item:hover .card:nth-child(2) {
            transition-delay: 0.2s;
        }

        .modern-menu .nav-item:hover .card:nth-child(3) {
            transition-delay: 0.3s;
        }

        .modern-menu .nav-item:hover .card:nth-child(4) {
            transition-delay: 0.4s;
        }

        .modern-menu .custom-max-inline-size {
            max-inline-size: 82%;
            position: relative;
            z-index: 9999999999999 !important;
        }

        /* Force everything inside modern-menu to highest z-index */
        .modern-menu .dropdown * {
            position: relative;
            z-index: 9999999999999 !important;
        }

        /* Responsive design */
        @media (max-width: 768px) {

            .modern-menu {
                display: none;
            }

            .modern-menu .nav-menu {
                flex-direction: column;
                align-items: center;
                z-index: 9999999999999 !important;
            }

            .modern-menu .dropdown {
                min-width: 300px;
                z-index: 9999999999999 !important;
            }

            .modern-menu .dropdown-content {
                flex-direction: column;
                align-items: center;
                z-index: 9999999999999 !important;
            }

            .modern-menu .card {
                width: 100%;
                max-width: 280px;
                z-index: 9999999999999 !important;
            }
        }

        /* Demo title */
        .modern-menu .demo-title {
            text-align: center;
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 9999999999999 !important;
        }

        .modern-menu .demo-description {
            text-align: center;
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
            z-index: 9999999999999 !important;
        }

    /* Modern Menu Css Code End */

</style>

<!-- Header -->
<header class="header" style="height: 135px;" >
    @if (auth('customer')->check() && (!auth('customer')->user()->phone_code || !auth('customer')->user()->phone || !auth('customer')->user()->country || !auth('customer')->user()->city))
        <div class="complete-profile-bar py-2">
            <div class="d-flex gap-2 align-items-center">
                <div class="top-offer-text flex-grow-1 d-flex justify-content-center fw-normal ">
                    {{ translate('please_complete_your_profile_data_to_enjoy_all_features') }} &nbsp; <a class="text-decoration-underline text-primary pointing-hand {{ app()->getLocale() == 'ae' ? 'left-direction' : 'right-direction' }}" href="{{route('user-account')}}"> {{ translate('complete_now') }}</a>
                </div>
            </div>
        </div>
    @endif
    <div class="header-top bg-primary py-2 d-xl-none">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between" >
                <div class="d-flex align-items-center justify-content-between">
                    <ul class="nav justify-content-center w-100 align-items-center gap-4 d-xl-none">
                        <li class="" >
                            <div class="language-dropdown">
                                <button type="button" class="border-0 bg-transparent d-flex custom-fs-16 gap-1 align-items-center dropdown-toggle text-dark text-white p-0 text-white" data-bs-toggle="dropdown" aria-expanded="false">
                                    @php( $local = \App\CPU\Helpers::default_lang())
                                    @foreach(json_decode($language['value'],true) as $data)
                                    @if($data['code']==$local)
                                        <img width="20" src="{{theme_asset('assets/img/flags')}}/{{ strtolower($data['code']).'.svg' }}" class="dark-support" alt="Eng" />
                                        {{ ucwords($data['name']) }}
                                    @endif
                                    @endforeach
                                </button>
                                <ul class="dropdown-menu" style="--bs-dropdown-min-width: 10rem;overflow-x: auto;max-height: 500px;">
                                    @foreach(json_decode($language['value'],true) as $key =>$data)
                                    @if($data['status']==1)
                                    <li>
                                        <a class="d-flex gap-2 align-items-center" href="{{route('lang',[$data['code']])}}">
                                            <img width="20" src="{{theme_asset('assets/img/flags')}}/{{ strtolower($data['code']).'.svg' }}" loading="lazy" class="dark-support" alt="{{$data['name']}}" />
                                            {{ ucwords($data['name']) }}
                                        </a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>

                @if(auth('customer')->check())
                    <a href="{{ route('ads-adding-type') }}" class="btn btn-light text-light bg-orange fw-normal custom-fs-16 border-0 d-flex gap-1 px-2 py-1">
                        <i class="bi bi-plus-circle mx-1"></i>
                        {{ translate('post_your_ad') }}
                    </a>
                @else
                    <a href=""
                    data-bs-toggle="modal" data-bs-target="#loginModal"
                    class="btn btn-light text-light bg-orange fw-normal custom-fs-16 border-0 d-flex gap-1 px-2 py-1">
                        <i class="bi bi-plus-circle mx-1"></i>
                        {{ translate('post_your_ad') }}
                    </a>
                @endif
            </div>

        </div>
    </div>
    <div class="header-middle border-bottom py-3 d-none d-xl-block">
        <div class="container">
            <div class="d-flex align-items-center w-100 justify-content-between gap-2">
                <a class="logo" href="{{route('home')}}">
                    <img src="{{cloudfront("company")."/".$web_config['web_logo']->value}}" class="dark-support svg h-45" onerror="this.src='{{theme_asset('assets/img/image-place-holder-2_1.png')}}'" alt="Logo" />
                </a>

                <div class="desktop-search-container">
                    <div class="d-flex align-items-center gap-3">
                        <div class="search-box position-relative d-flex align-items-center gap-3">
                            <form class="m-0" action="{{route('products')}}">
                                <div class="d-flex">
                                    <div class="search-bar search_dropdown">
                                        <input type="search" name="name" class="form-control search-bar-input-mobile" autocomplete="off" placeholder="{{ translate('Search_for_items') }}...">
                                        <input name="page" value="1" hidden="">
                                        <div class="d-flex align-items-center" style="width: 30px;" >
                                            <div class="spinner-border" id="loading" style="width: 1.3rem; height: 1.3rem;display: none;" role="status">
                                                <span class="visually-hidden"></span>
                                            </div>
                                        </div>
                                        <button type="button" class="search_voice" title="{{translate('search_by_voice')}}" data-bs-toggle="tooltip" data-bs-placement="top">
                                            <span><i class="bi bi-mic voice-search-icon"></i></span>
                                            <span class="recording-pulse"></span>
                                        </button>
                                    </div>
                                </div>
                                <div style="overflow-y: auto;max-height: 462px;scrollbar-width: thin;" class="card large-screen-aside-shadow search-card __inline-13 position-absolute z-99 w-100 bg-white start-0 search-result-box d--none"></div>
                            </form>
                        </div>
                    </div>
                </div>

                <ul class="nav justify-content-center justify-content-sm-end align-items-center">
                    <li>
                        <div class="language-dropdown">
                            @php($country = session('show_by_country') ? session('show_by_country') : SYSTEM_COUNTRIES[0])
                            <button type="button" class="border-0 emoji-font bg-transparent d-flex gap-2 align-items-center dropdown-toggle text-dark text-white  p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                {{$country['emoji']}} {{$country['name']}}
                            </button>
                            <ul class="dropdown-menu" style="--bs-dropdown-min-width: 10rem
                            ;overflow-x: auto;max-height: 500px;">
                                @foreach (SYSTEM_COUNTRIES as $key => $data)
                                    <li>
                                        <a class="d-flex gap-2 emoji-font align-items-center"
                                        href="{{route('show-by-country', ['code' => $data['code'], 'flag' => $data['emoji']])}}">
                                            {{$data['emoji']}} {{ ucwords($data['name']) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    <li class="large-margin-x" >
                        <div class="language-dropdown">
                            <button type="button" class="border-0 bg-transparent d-flex gap-2 align-items-center dropdown-toggle text-dark text-white  p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                @php( $local = \App\CPU\Helpers::default_lang())
                                @foreach(json_decode($language['value'],true) as $data)
                                @if($data['code']==$local)
                                <img width="20" src="{{theme_asset('assets/img/flags')}}/{{ $data['code'].'.svg' }}" class="dark-support" alt="Eng" />
                                {{ ucwords($data['name']) }}
                                @endif
                                @endforeach
                            </button>
                            <ul class="dropdown-menu grid-dropdown" style="--bs-dropdown-min-width: 10rem">
                                @foreach(json_decode($language['value'],true) as $key =>$data)
                                    @if($data['status']==1)
                                        <li>
                                            <a class="d-flex gap-2 align-items-center" href="{{route('lang',[$data['code']])}}">
                                                <img width="20" src="{{theme_asset('assets/img/flags')}}/{{ $data['code'].'.svg' }}" loading="lazy" class="dark-support" alt="{{$data['name']}}" />
                                                {{ ucwords($data['name']) }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    <li>
                        @if(auth('customer')->check())
                            <a href="{{ route('ads-adding-type') }}" class="btn btn-light text-light bg-orange fw-normal fs-16 border-0 d-flex gap-1 ps-3 py-2">
                                <i class="bi bi-plus-circle mx-1"></i>
                                {{ translate('post_your_ad') }}
                            </a>
                        @else
                            <a href=""
                            data-bs-toggle="modal" data-bs-target="#loginModal"
                            class="btn btn-light text-light bg-orange fw-normal fs-16 border-0 d-flex gap-1 ps-3 py-2">
                                <i class="bi bi-plus-circle mx-1"></i>
                                {{ translate('post_your_ad') }}
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="header-main love-sticky py-xl-0 shadow-sm">
        <div class="container">
            <!-- Aside -->
            <aside class="aside d-flex flex-column d-xl-none">
                <div class="aside-close p-3 pb-2">
                    <i class="bi bi-x-lg"></i>
                </div>
                <!-- Aside Body -->
                <div>
                    <div class="aside-body" data-trigger="scrollbar">

                        <div class="mobile-search-container">
                            <div class="d-flex align-items-center gap-3 w-100">
                                <div class="search-box position-relative d-flex align-items-center gap-3 w-100">
                                    <form class="m-0 w-100" action="{{route('products')}}">
                                        <div class="d-flex w-100">
                                            <div class="search-bar search_dropdown w-100">
                                                <input type="search" name="name" class="form-control search-bar-input-mobile" autocomplete="off" placeholder="{{ translate('Search_for_items') }}...">
                                                <input name="page" value="1" hidden="">
                                                <button type="button" class="search_voice" title="{{translate('search_by_voice')}}" data-bs-toggle="tooltip" data-bs-placement="top">
                                                    <span><i class="bi bi-mic voice-search-icon"></i></span>
                                                    <span class="recording-pulse"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div style="overflow-y: auto;max-height: 462px;scrollbar-width: thin;" class="card large-screen-aside-shadow search-card __inline-13 position-absolute z-99 w-100 bg-white start-0 search-result-box d--none"></div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Nav -->
                        <ul class="main-nav nav">
                            @if(auth('customer')->check() && $sponsorTypes->isNotEmpty())
                                <li class="text-primary">
                                    <a class="fw-medium text-primary" href="#">
                                        {{ translate('Highlight your ad – Sell faster') }} !
                                    </a>
                                    <!-- Sub Menu -->
                                    <ul class="sub_menu">
                                        <li class="ps-2">

                                            @if(isset($sponsorTypes['appearance_in_first_results']) && $sponsorTypes['appearance_in_first_results'] == 1)
                                                <a class="d-flex align-items-center gap-1 p-0 pb-3" href="{{route('create.sponsor')}}?type=appearance-in-first-results">
                                                    <img width="40px" src="{{ cloudfront('sponsor/appear-on-first-results.png') }}" alt="sponsor-image">
                                                    <span class="fw-medium text-primary">{{ translate('first_results_appearance') }}</span>
                                                </a>
                                            @endif

                                            @if(isset($sponsorTypes['urgent_sale_sticker']) && $sponsorTypes['urgent_sale_sticker'] == 1)
                                                <a class="d-flex align-items-center gap-1 p-0 pb-3" href="{{route('create.sponsor')}}?type=urgent-sale-sticker">
                                                    <img width="40px" src="{{ cloudfront('sponsor/urgent-sale-sticker.png') }}" alt="sponsor-image">
                                                    <span class="fw-medium text-primary">{{ translate('urgent_sale_sticker') }}</span>
                                                </a>
                                            @endif

                                            @if(isset($sponsorTypes['promotional_video']) && $sponsorTypes['promotional_video'] == 1)
                                                <a class="d-flex align-items-center gap-1 p-0 pb-3" href="{{route('create.sponsor')}}?type=promotional-video">
                                                    <img width="40px" src="{{ cloudfront('sponsor/promotional-video.png') }}" alt="sponsor-image">
                                                    <span class="fw-medium text-primary">{{ translate('promotional_video') }}</span>
                                                </a>
                                            @endif

                                            @if(isset($sponsorTypes['promotional_banner']) && $sponsorTypes['promotional_banner'] == 1)
                                                <a class="d-flex align-items-center gap-1 p-0 pb-3" href="{{route('create.paid-banners')}}">
                                                    <img width="40px" src="{{ cloudfront('sponsor/promotional-banner.png') }}" alt="sponsor-image">
                                                    <span class="fw-medium text-primary">{{ translate('promotional_banner') }}</span>
                                                </a>
                                            @endif
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            <li>
                                <a href="{{route('home')}}">{{ translate('home') }}</a>
                            </li>
                            <li>
                                <a href="{{route('categories')}}#">{{ translate('categories') }}</a>
                                <!-- Sub Menu -->
                                <ul class="sub_menu">
                                    @foreach($categories as $key => $category)
                                        <li>
                                            <a href="javascript:">
                                                <span onclick="location.href='{{ url('ads/filter?category_id=' . $category->id) }}'">
                                                    {{ $category->name }}
                                                </span>
                                            </a>
                                            <ul class="sub_menu"></ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>

                            @if($web_config['brand_setting'])
                                <li>
                                    <a href="javascript:">{{ translate('brands') }}</a>
                                    <!-- Sub Menu -->
                                    <ul class="sub_menu">
                                        @foreach($brands as $brand)
                                            <li>
                                                <a href="{{ route('products',['id'=> $brand->id,'data_from'=>'brand','page'=>1]) }}">
                                                    {{ $brand->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        </ul>
                        <!-- End Nav -->
                    </div>

                    <div class="d-flex align-items-center gap-2 justify-content-between p-4">
                        <span class="text-dark">{{ translate('theme_mode') }}</span>
                        <div class="theme-bar p-1">
                            <button class="light_button active">
                                <img src="{{theme_asset('assets/img/svg/light.svg')}}" alt="" class="svg">
                            </button>
                            <button class="dark_button">
                                <img src="{{theme_asset('assets/img/svg/dark.svg')}}" alt="" class="svg">
                            </button>
                        </div>
                    </div>
                </div>

                @if(auth('customer')->check())
                    <div class="d-flex justify-content-center mb-5 pb-5 mt-auto px-4">
                        <a href="{{route('customer.auth.logout')}}" class="btn btn-primary w-100">{{ translate('logout') }}</a>
                    </div>
                @else
                    <div class="d-flex justify-content-center mb-5 pb-5 mt-auto px-4 gap-2">
                        <a href="" data-bs-toggle="modal" data-bs-target="#loginModal" class="btn btn-primary w-100">
                            {{ translate('login') }}
                        </a>
                        <a href="{{route('customer.auth.sign-up-type')}}" class="btn btn-primary w-100">
                            {{ translate('register') }}
                        </a>
                    </div>
                @endif
            </aside>

            <div style="padding: 12px 0;" class="d-flex justify-content-between gap-3 align-items-center position-relative">
                <ul class="dropdown-menu dropdown--menu">
                    <li>
                        <a href="{{route('products',['data_from'=>'latest'])}}" class="btn-link text-primary">
                            {{ translate('view_all') }}
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center ">
                    <!-- Main Nav -->
                    <div class="nav-wrapper">
                        <div class="d-xl-none">
                            <a class="logo" href="{{route('home')}}">
                                <img width="" src="{{cloudfront("company/dark-logo.png")}}" onerror="this.src='{{theme_asset('assets/img/image-place-holder-2_1.png')}}'" class="dark-support mobile-logo-cs" alt="Logo" />
                            </a>
                        </div>

                        <ul class="nav main-menu align-items-center d-none d-xl-flex flex-nowrap">
                            <li class="{{request()->is('/')?'active':''}}">
                                <a href="{{route('home')}}">{{ translate('Home')}}</a>
                            </li>
                            <li>
                                <a class="cursor-pointer">{{ translate('Categories') }}</a>
                                <div class="sub-menu megamenu p-3" style="--bs-dropdown-min-width: max-content;z-index: 1111111;overflow-y:auto;max-height: 540px;">
                                    <div class="d-flex gap-4 flex-column">
                                        <div class="">
                                            @foreach($categories as $key=>$category)
                                                <a href="{{url('ads/filter?category_id='.$category->id)}}" class="media gap-3 align-items-center border-bottom">
                                                    <div class="avatar rounded-circle" style="--size: 2rem">
                                                        <img width="50px"
                                                        onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                                        src="{{ cloudfront('category/'.$category->icon)}}" alt="">
                                                    </div>
                                                    <div class="media-body text-truncate" style="--width: 7rem" title="Bata">
                                                        {{ $category->name }}
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @if($web_config['brand_setting'])
                                <li>
                                    <a class="cursor-pointer">{{ translate('brands') }}</a>
                                    <div class="sub-menu megamenu p-3" style="--bs-dropdown-min-width: max-content;z-index: 1111111;">
                                        <div class="d-flex gap-4">
                                            <div class="column-2">
                                                @foreach($brands as $brand)
                                                    <a href="{{url('ads/filter?brand_id='.$brand->id)}}" class="media gap-3 align-items-center border-bottom">
                                                        <div class="avatar" style="--size: 2.25rem">
                                                            <img
                                                                onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                                                src="{{ cloudfront('brand/'.$brand->image) }}"
                                                                loading="lazy" class="dark-support" alt="" width="80px" />
                                                        </div>
                                                        <div class="media-body text-truncate" style="--width: 7rem" title="Brand">
                                                            {{ $brand->name }}
                                                        </div>
                                                    </a>
                                                @endforeach
                                                <div class="d-flex">
                                                    <a href="{{route('brands')}}" class="fw-bold text-primary d-flex justify-content-center">{{ translate('view_all') }}...
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <!-- End Main Nav -->
                </div>

                @if(auth('customer')->check() && $sponsorTypes->isNotEmpty())
                    <div class="modern-menu" >
                        <ul class="nav-menu m-0">
                            <li class="nav-item">
                                <a href="#" class="nav-link btn bg-transparent text-primary border-0 p-0 dropdown-btn-font-size w-100">
                                    <span><i class="bi bi-rocket"></i></span>
                                    <span class="fw-bold" >{{ translate('Highlight your ad – Sell faster') }} !</span>
                                </a>
                                <div class="dropdown">
                                    <div class="dropdown-content">

                                        @if(isset($sponsorTypes['appearance_in_first_results']))
                                            <div class="card border border-cool-primary p-3 sponsor-card">
                                                <a href="{{route('create.sponsor')}}?type=appearance-in-first-results" class="d-block rounded " role="button" >
                                                    <h5 class="text-center text-primary" >{{ translate('first_results_appearance') }}</h5>
                                                    <div>
                                                        <img class="custom-max-inline-size" src="{{ cloudfront('sponsor/appear-on-first-results.png') }}" alt="sponsor-image">
                                                    </div>
                                                </a>
                                            </div>
                                        @endif

                                        @if(isset($sponsorTypes['urgent_sale_sticker']))
                                            <div class="card border border-cool-primary p-3 sponsor-card">
                                                <a href="{{route('create.sponsor')}}?type=urgent-sale-sticker" class="d-block rounded border-0" role="button" >
                                                    <h5 class="text-center text-primary" >{{ translate('urgent_sale_sticker') }}</h5>
                                                    <div>
                                                        <img class="custom-max-inline-size" src="{{ cloudfront('sponsor/urgent-sale-sticker.png') }}" alt="sponsor-image">
                                                    </div>
                                                </a>
                                            </div>
                                        @endif

                                        @if(isset($sponsorTypes['promotional_video']))
                                            <div class="card border border-cool-primary p-3 sponsor-card">
                                                <a href="{{route('create.sponsor')}}?type=promotional-video" class="d-block rounded border-0" role="button" >
                                                    <h5 class="text-center text-primary" >{{ translate('promotional_video') }}</h5>
                                                    <div>
                                                        <img class="custom-max-inline-size" src="{{ cloudfront('sponsor/promotional-video.png') }}" alt="sponsor-image">
                                                    </div>
                                                </a>
                                            </div>
                                        @endif

                                        @if(isset($sponsorTypes['promotional_banner']))
                                            <div class="card border border-cool-primary p-3 sponsor-card">
                                                <a href="{{route('create.paid-banners')}}" class="d-block rounded" role="button" >
                                                    <h5 class="text-center text-primary" >{{ translate('promotional_banner') }}</h5>
                                                    <div>
                                                        <img class="custom-max-inline-size" src="{{ cloudfront('sponsor/promotional-banner.png') }}" alt="sponsor-image">
                                                    </div>
                                                </a>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endif

                <ul class="list-unstyled list-separator mb-0">

                    @if(auth('customer')->check())
                        <li class="login-register d-flex align-items-center gap-4">
                            <div class="profile-dropdown">
                                <button type="button" class="border-0 bg-transparent d-flex gap-2 align-items-center dropdown-toggle text-dark p-0 user" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="avatar overflow-hidden header-avatar rounded-circle" style="--size: 1.5rem">
                                        <img loading="lazy" src="{{auth('customer')->user()->image != 'def-image.jpg' ? cloudfront('profile/images/'.auth('customer')->user()->image) : theme_asset('assets/img/icons/profile-icon.png') }}"
                                        onerror="this.src='{{theme_asset('assets/img/icons/profile-icon.png')}}'" class="img-fit" alt="" />
                                    </span>
                                </button>
                                <ul class="dropdown-menu p-0" style="--bs-dropdown-min-width: 10rem">
                                    <li>
                                        <a class="d-flex align-items-center gap-2" href="{{route('user-profile')}}">
                                            <i class="bi bi-person-square"></i>
                                            <span>{{ translate('my_profile') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="d-flex align-items-center gap-2" href="{{route('user-ads')}}">
                                            <i class="bi bi-car-front-fill"></i>
                                            <span>{{ translate('my_ads') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="d-flex align-items-center gap-2" href="{{route('index.paid-banners')}}">
                                            <i class="bi bi-image-alt nav-indicator-icon"></i>
                                            <span>{{ translate('my_banners') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="d-flex align-items-center gap-2" href="{{ route('data.sponsor') }}">
                                            <i class="bi bi-megaphone nav-indicator-icon"></i>
                                            <span>{{ translate('promotion_area') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="d-flex align-items-center gap-2" href="{{route('customer.auth.logout')}}">
                                            <i class="bi bi-box-arrow-left"></i>
                                            <span>{{ translate('logout') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="menu-btn d-xl-none">
                                <i class="bi bi-list fs-30"></i>
                            </div>
                        </li>
                    @else
                        <li class="login-register d-flex gap-4">
                            <button class="media gap-2 align-items-center text-uppercase fs-12 bg-transparent border-0 p-0" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <span class="avatar header-avatar rounded-circle d-xl-none" style="--size: 1.5rem">
                                    <img loading="lazy" src="{{theme_asset('assets/img/user.png')}}" class="img-fit rounded-circle" alt="" />
                                </span>
                                <span class="media-body d-none d-xl-block hover-primary fw-bold">{{ translate('login') }}</span>
                            </button>
                            <div class="menu-btn d-xl-none">
                                <i class="bi bi-list fs-30"></i>
                            </div>
                        </li>
                        <li class="d-none d-xl-block">
                            <a href="{{route('customer.auth.sign-up-type')}}" class="media gap-2 align-items-center text-uppercase fs-12 bg-transparent border-0 p-0" >
                                <span class="media-body d-none d-xl-block hover-primary fw-bold">{{ translate('register') }}</span>
                            </a>
                        </li>
                    @endif

                    @if(auth('customer')->check())
                        <li class="d-none d-xl-block">
                            <a href="{{ route('chat', 'user') }}" class="position-relative">
                                <i class="bi bi-envelope fs-18"></i>
                                @php($unread_message_count=\App\Model\Chatting::where(['receiver_id'=>auth('customer')->id(),'seen'=>0])->count())
                                <span class="count bg-danger">{{$unread_message_count}}</span>
                            </a>
                        </li>
                    @endif
                    <li class="d-none d-xl-block">
                        @if(auth('customer')->check())
                            <a href="{{ route('wishlists') }}" class="position-relative">
                                <i class="bi bi-heart fs-18"></i>
                                <span class="count wishlist_count_status">{{session()->has('wish_list')?count(session('wish_list')):0}}</span>
                            </a>
                        @else
                            <a href="javascript:" class="position-relative" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="bi bi-heart fs-18"></i>
                            </a>
                        @endif
                    </li>

                </ul>
            </div>
            <div id="mySidebar" class="sidebar" >
                <span role="button" class="closebtn" onclick="closeNav()">
                    <i class="bi bi-x-circle main-text-color exit-btn"></i>
                </span>
            </div>

        </div>
    </div>
</header>

<script>
    function openNav() {
        document.getElementById("mySidebar").style.transform = "translateX(0)";
        // document.getElementById("main").style.marginLeft = "250px";
    }

    function closeNav() {
        document.getElementById("mySidebar").style.transform = "translateX(-335px)";
        // document.getElementById("main").style.marginLeft= "0";
    }

    function toggleIcon(element) {
        let icon = element.querySelector("i");
        if (icon) {
            icon.classList.toggle("bi-plus");
            icon.classList.toggle("bi-dash");
        }
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.modern-menu .nav-item');

    navItems.forEach(item => {
        const dropdown = item.querySelector('.dropdown');
        let hoverTimeout;

        if (dropdown) {
            item.addEventListener('mouseenter', function() {
                clearTimeout(hoverTimeout);
                dropdown.style.display = 'block';
            });

            item.addEventListener('mouseleave', function() {
                hoverTimeout = setTimeout(() => {
                    dropdown.style.display = '';
                }, 100); // Small delay to prevent flickering
            });
        }

        // Add click animation for the anchor tags directly
        const cardLinks = item.querySelectorAll('.modern-menu .card a');
        cardLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Add subtle click animation to the parent card
                const card = this.closest('.card');
                if (card) {
                    card.style.transform = 'translateY(-8px) scale(0.98)';
                    setTimeout(() => {
                        card.style.transform = '';
                    }, 150);
                }
                // Let the link navigate naturally - don't prevent default
            });
        });
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (session()->has('redirect_to_login')): ?>
            <?php session()->forget('redirect_to_login'); ?>
            var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        <?php endif; ?>
    });
</script>

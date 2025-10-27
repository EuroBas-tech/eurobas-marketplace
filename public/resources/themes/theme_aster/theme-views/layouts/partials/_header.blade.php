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
</h2>        </div> </div>

@endif
@php($categories = \App\Model\Category::with('childes.childes')->where(['position'=> 0])->priority()->take(11)->get())
@php($brands = \App\Model\Brand::active()->take(15)->get())
<style>

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

</style>
<!-- Header -->
<header class="header" style="height: 135px;" >
    <div class="header-top py-2 d-sm-none">
        <div class="container">
            <div class="d-flex align-items-center flex-wrap justify-content-between">
                <ul class="nav justify-content-between w-100 justify-content-sm-end align-items-center gap-3  d-sm-none ">
                    <li>
                        <a href="#">
                            <div class="tnh-current-country openPopupBtnmob">
                                <div class="shipping-to text-white">
                                    Ship to:
                                </div>

                                @if (session('country_shipping')=="All")
                                    <h6 class="text-primary"> All Country
                                    </h6>
                                @endif
                                @if(session('country_shipping')!="All")

                                <img class="tnh-country-flag" width="20" src=" {{ theme_asset('assets/img/flags') }}/{{ strtolower(session('country_shipping')) }}.svg" />

                                @endif
                                <div class="shipping-to m-2 text-white">
                                    @foreach (SYSTEM_COUNTRIES as $country)
                                        @if ($country['code'] === session('country_shipping'))
                                            {{ substr($country['name'], 0, 5)  }}
                                        @endif
                                    @endforeach
                                    - {{session('currency_symbol')}}
                                </div>
                            </div>

                        </a>

                        <div id="popupmob" class="popup" style="display: none;">
                            <div class="popup-content">
                                <span class="closemob">&times;</span>
                                <div style="height: 8px;
                                width: 16px;
                                position: absolute;
                                background: transparent;
                                color: rgb(255 255 255);
                                transform: rotate(0deg) translateY(-100%) translateX(-50%);
                                left: 40%;
                                /* bottom: 93.5%; */
                                z-index: 10;
                                top: 0%;"><svg data-testid="arrow" class="popup-arrow functional-arrow tnh-ship-to-arrow" viewBox="0 0 32 16" style="position: absolute;">
                                        <path d="M16 0l16 16H0z" fill="currentcolor"></path>
                                    </svg></div>

                                <div class="custom-select-wrapper">
                                    <h5 class="mb-2"> {{ translate('Specify your location')}}
                                        </h5>
                                        <p>{{ translate('Shipping options and fees vary based on your location')}} </p>
                                    <input type="text" id="searchInputmob" placeholder="Search for countries...">
                                    <div class="custom-select-mob">
                                        <ul id="countryListmob">

                                            <li class="country-item-mob" data-value="all">
                                                <a class="d-flex gap-2 align-items-center" href="{{ route('country-shipping', ['code' =>'All']) }}">
                                                    {{ translate('All COUNTRIES')}}
                                                    All COUNTRIES
                                                </a>
                                            </li>
                                            @foreach (COUNTRIES as $key => $data)
                                            <li class="country-item-mob" data-value="{{ $data['code'] }}">
                                                <a class="d-flex gap-2 align-items-center" href="{{ route('country-shipping', ['code' => $data['code']]) }}">
                                                    <img width="20" src="{{theme_asset('assets/img/flags')}}/{{ strtolower($data['code']).'.svg' }}" alt="{{$data['name']}}" />
                                                    {{ ucwords($data['name']) }}
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                   <div class="card-currency dark-support " >
                                    <h5 class="my-2">{{ translate('SetCurrency')}}
                                    </h5>
                                    <p>
                                        {{ translate(' Select your preferred currency. You can update the settings at any time.')}}
                                       </p>

                                 <div class="currency_box">
                                    @if($web_config['currency_model']=='multi_currency')
                                    <input type="text" id="currencySearchInputmob" placeholder="Search for currencies...">
                                    <div class="custom-select-mob-currency">
                                        <ul id="currencyListmob">
                                            @foreach ($web_config['currencies'] as $key => $currency)
                                                <li class="currency-item-mob" data-value="{{ $currency['code'] }}">
                                                    <a class="d-flex gap-2 align-items-center" href="javascript:" onclick="currency_change('{{$currency['code']}}')">
                                                        {{ $currency['name'] }}  ({{$currency['code']}})
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                 </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="large-margin-x" >
                        <div class="language-dropdown">
                            <button type="button" class="border-0 bg-transparent d-flex gap-2 align-items-center dropdown-toggle text-dark text-white p-0 text-white" data-bs-toggle="dropdown" aria-expanded="false">
                                @php( $local = \App\CPU\Helpers::default_lang())
                                @foreach(json_decode($language['value'],true) as $data)
                                @if($data['code']==$local)
                                <img width="20" src="{{theme_asset('assets/img/flags')}}/{{ strtolower($data['code']).'.svg' }}" class="dark-support" alt="Eng" />
                                {{ ucwords($data['name']) }}
                                @endif
                                @endforeach
                            </button>
                            <ul class="dropdown-menu" style="--bs-dropdown-min-width: 10rem">
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
        </div>
    </div>
    <div class="header-middle border-bottom py-3 d-none d-xl-block">
        <div class="container">
            <div class="d-flex align-items-center w-100 justify-content-between gap-2">
                <a class="logo" href="{{route('home')}}">
                    <img src="{{asset("storage/app/public/company")."/".$web_config['web_logo']->value}}" class="dark-support svg h-45" onerror="this.src='{{theme_asset('assets/img/image-place-holder-2_1.png')}}'" alt="Logo" />
                </a>


                <div class="d-flex align-items-center gap-3" >
                    <div class="search-box position-relative d-flex align-items-center gap-3">
                        <form class="m-0" action="{{route('products')}}">
                            <div class="d-flex" >
                                <div class="search-bar search_dropdown">
                                    <input type="search" name="name" class="form-control search-bar-input-mobile" autocomplete="off" placeholder="{{ translate('Search_for_items') }}...">
                                    <input name="page" value="1" hidden="">
                                    <button type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card search-card __inline-13 position-absolute z-99 w-100 bg-white start-0 search-result-box d--none"></div>
                        </form>
                    </div>
                </div>
                <ul class="nav justify-content-center justify-content-sm-end align-items-center">
                    <li>
                        <div class="language-dropdown">
                            <button type="button" class="border-0 emoji-font bg-transparent d-flex gap-2 align-items-center dropdown-toggle text-dark text-white  p-0" data-bs-toggle="dropdown" aria-expanded="false">                                   
                            {{SYSTEM_COUNTRIES[0]['emoji']}} {{SYSTEM_COUNTRIES[0]['name']}}
                            </button>
                            <ul class="dropdown-menu" style="--bs-dropdown-min-width: 10rem
                            ;overflow-x: auto;max-height: 500px;">
                                @foreach (SYSTEM_COUNTRIES as $key => $data)
                                    <li>
                                        <a class="d-flex gap-2 emoji-font align-items-center" 
                                        href="#">
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
    <div class="header-main love-sticky py-lg-3 py-xl-0 shadow-sm">
        <div class="container">
            <!-- Aside -->
            <aside class="aside d-flex flex-column d-xl-none">
                <div class="aside-close p-3 pb-2">
                    <i class="bi bi-x-lg"></i>
                </div>
                <!-- Aside Body -->
                <div>
                    <div class="aside-body" data-trigger="scrollbar">
                        <!-- Search -->
                        <form data-bs-toggle="modal" data-bs-target="#search_Modal" action="{{route('products')}}" class="mb-3">
                            <div class="search-bar">
                                <input type="search" name="name" class="form-control search-bar-input-mobile" autocomplete="off" placeholder="{{ translate('Search_for_items') }}...">
                                <input name="data_from" value="search" hidden="">
                                <input name="page" value="1" hidden="">
                                <button type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <div class="card search-card __inline-13 position-absolute z-99 w-100 bg-white start-0 search-result-box d--none"></div>
                        </form>

                        <!-- Nav -->
                        <ul class="main-nav nav">
                            <li>
                                <a href="{{route('categories')}}#">{{ translate('categories') }}</a>
                                <!-- Sub Menu -->
                                <ul class="sub_menu">
                                    @foreach($categories as $key=>$category)
                                    <li>
                                        <a href="javascript:">
                                            <span onclick="location.href='{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}'">{{ $category['name'] }}</span>
                                        </a>
                                        @if ($category->childes->count() > 0)
                                        <ul class="sub_menu">
                                            @foreach($category['childes'] as $subCategory)
                                            <li>
                                                <a href="javascript:">
                                                    <span onclick="location.href='{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}'">{{$subCategory['name']}}</span>
                                                </a>
                                                @if($subCategory->childes->count()>0)
                                                <ul class="sub_menu">
                                                    @foreach($subCategory['childes'] as $subSubCategory)
                                                    <li>
                                                        <a href="{{route('products',['id'=> $subSubCategory['id'],'data_from'=>'category','page'=>1])}}">
                                                            {{$subSubCategory['name']}}
                                                        </a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                @endif
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li>
                                <a href="{{route('home')}}">{{ translate('home') }}</a>
                            </li>
                            @if($web_config['business_mode'] == 'multi')
                            <li>
                                <a href="javascript:">{{ translate('stores') }}</a>
                                <!-- Sub Menu -->
                                <ul class="sub_menu">
                                    @foreach($web_config['shops'] as $shop)
                                    <li>
                                        <a href="{{route('shopView',['id'=>$shop['id']])}}">{{Str::limit($shop->name, 14)}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif

                            @if($web_config['brand_setting'])
                            <li>
                                <a href="javascript:">{{ translate('brands') }}</a>
                                <!-- Sub Menu -->
                                <ul class="sub_menu">
                                    @foreach($brands as $brand)
                                    <li>
                                        <a href="{{ route('products',['id'=> $brand['id'],'data_from'=>'brand','page'=>1]) }}">{{ $brand->name }}</a>
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
                <div class="d-flex justify-content-center mb-5 pb-5 mt-auto px-4">
                    <a href="" data-bs-toggle="modal" data-bs-target="#loginModal" class="btn btn-primary w-100">
                        {{ translate('login') }} / {{ translate('register') }}
                    </a>
                </div>
                @endif
            </aside>

            <div style="padding: 12px 0;" class="d-flex justify-content-between gap-3 align-items-center position-relative">
                <ul class="dropdown-menu dropdown--menu">
                    @foreach($categories as $key=>$category)
                    <li class="{{ $category->childes->count() > 0 ? 'menu-item-has-children':'' }}">
                        <a href="javascript:" onclick="location.href='{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}'">
                            {{$category['name']}}
                        </a>
                        @if ($category->childes->count() > 0)
                        <ul class="sub-menu">
                            @foreach($category['childes'] as $subCategory)
                            <li class="{{ $subCategory->childes->count()>0 ? 'menu-item-has-children':'' }}">
                                <a href="javascript:" onclick="location.href='{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}'">
                                    {{$subCategory['name']}}
                                </a>
                                @if($subCategory->childes->count()>0)
                                <ul class="sub-menu">
                                    @foreach($subCategory['childes'] as $subSubCategory)
                                    <li>
                                        <a href="{{route('products',['id'=> $subSubCategory['id'],'data_from'=>'category','page'=>1])}}">
                                            {{$subSubCategory['name']}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
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
                                <img src="{{asset("storage/app/public/company")."/".$web_config['mob_logo']->value}}" onerror="this.src='{{theme_asset('assets/img/image-place-holder-2_1.png')}}'" class="dark-support mobile-logo-cs" alt="Logo" />
                            </a>
                        </div>
                        <ul class="nav main-menu align-items-center d-none d-xl-flex flex-nowrap">
                            <li class="{{request()->is('/')?'active':''}}">
                                <a href="{{route('home')}}">{{ translate('Home')}}</a>
                            </li>
                            <li>
                                <a class="cursor-pointer">{{ translate('Categories') }}</a>
                                <div class="sub-menu megamenu p-3" style="--bs-dropdown-min-width: max-content;z-index: 1111111;">
                                    <div class="d-flex gap-4 flex-column">
                                        <div class="">
                                            @foreach($categories as $key=>$category)
                                            <a href="{{ route('products',['id'=> $brand['id'],'data_from'=>'brand','page'=>1]) }}" class="media gap-3 align-items-center border-bottom">
                                                <div class="avatar rounded-circle" style="--size: 2rem">
                                                    <img width="50px" src="{{ theme_asset('assets/img/svg/'.str_replace(' ', '-', $category->name).'-icon.svg') }}" alt="">
                                                </div>
                                                <div class="media-body text-truncate" style="--width: 7rem" title="Bata">
                                                    {{ $category->name }}
                                                </div>
                                            </a>
                                            @endforeach
                                            <div class="d-flex">
                                                <a href="" class="fw-bold text-primary d-flex justify-content-center">{{ translate('view_all') }}...
                                                </a>
                                            </div>
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
                                            <a href="{{ route('products',['id'=> $brand['id'],'data_from'=>'brand','page'=>1]) }}" class="media gap-3 align-items-center border-bottom">
                                                <div class="avatar rounded-circle" style="--size: 1.25rem">
                                                    <img onerror="" src="{{theme_asset('assets/img/image-place-holder.png')}}" loading="lazy" class="img-fit rounded-circle dark-support" alt="" />
                                                    {{-- {{asset("storage/app/public/brand")}}/{{ $brand->image }} --}}
                                                </div>
                                                <div class="media-body text-truncate" style="--width: 7rem" title="Bata">
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
                
                <ul class="list-unstyled list-separator mb-0">

                    @if(auth('customer')->check())
                        <li class="login-register d-flex align-items-center gap-4">
                            <div class="profile-dropdown">
                                <button type="button" class="border-0 bg-transparent d-flex gap-2 align-items-center dropdown-toggle text-dark p-0 user" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="avatar overflow-hidden header-avatar rounded-circle" style="--size: 1.5rem">
                                        <img loading="lazy" src="{{asset('storage/app/public/profile/'.auth('customer')->user()->image)}}" onerror="this.src='{{theme_asset('assets/img/icons/profile-icon.png')}}'" class="img-fit" alt="" />
                                    </span>
                                </button>
                                <ul class="dropdown-menu" style="--bs-dropdown-min-width: 10rem">
                                    <li><a href="{{route('user-ads')}}"><i class="bi bi-car-front-fill me-2"></i>{{ translate('my_ads') }}</a></li>
                                    <li><a href="{{route('user-profile')}}"><i class="bi bi-person-square me-2"></i>{{ translate('my_profile') }}</a></li>
                                    <li><a href="{{route('customer.auth.logout')}}"><i class="bi bi-box-arrow-left me-2"></i>{{ translate('logout') }}</a></li>
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
                                <span class="media-body d-none d-xl-block hover-primary fw-bold">{{ translate('login') }} / {{ translate('register') }}</span>
                            </button>
                            <div class="menu-btn d-xl-none">
                                <i class="bi bi-list fs-30"></i>
                            </div>
                        </li>
                    @endif

                    @if(auth('customer')->check())
                        <li class="d-none d-xl-block">
                            <a href="{{ route('chat', 'seller') }}" class="position-relative">
                                <i class="bi bi-envelope fs-18"></i>
                                @php($message=\App\Model\Chatting::where(['seen_by_customer'=>0,'user_id'=>auth('customer')->id()])->count())
                                <span class="count bg-danger">{{$message}}</span>
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


                {{--
                    <ul class="sub_menu">
                        @foreach($categories as $key=>$category)
                        <li>
                            <a href="javascript:">
                                <span onclick="location.href='{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}'">{{ $category['name'] }}</span>
                            </a>
                            @if ($category->childes->count() > 0)
                            <ul class="sub_menu">
                                @foreach($category['childes'] as $subCategory)
                                <li>
                                    <a href="javascript:">
                                        <span onclick="location.href='{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}'">{{$subCategory['name']}}</span>
                                    </a>
                                    @if($subCategory->childes->count()>0)
                                    <ul class="sub_menu">
                                        @foreach($subCategory['childes'] as $subSubCategory)
                                        <li>
                                            <a href="{{route('products',['id'=> $subSubCategory['id'],'data_from'=>'category','page'=>1])}}">
                                                {{$subSubCategory['name']}}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                --}}


                @foreach($categories as $key=>$category)
                    <a href="#">
                        <div class="d-flex align-items-center justify-content-between" >
                            <span onclick="location.href='{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}'" class="font-size-17">{{ $category['name'] }}</span>
                            <span class="position-relative" data-bs-toggle="collapse" href="#sidenav-item-{{$key}}" role="button" aria-expanded="false" aria-controls="sidenav-item-{{$key}}" class="collapsed" onclick="setTimeout(() => toggleIcon(this), 400)" >
                                @if ($category->childes->count() > 0)
                                    <i class="bi bi-plus"></i>                
                                @endif
                            </span>
                        </div>
                    </a>

                    @if ($category->childes->count() > 0)

                        {{--
                            <ul class="sub_menu">
                                @foreach($category['childes'] as $subCategory)
                                <li>
                                    <a href="javascript:">
                                        <span onclick="location.href='{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}'">{{$subCategory['name']}}</span>
                                    </a>
                                    @if($subCategory->childes->count()>0)
                                    <ul class="sub_menu">
                                        @foreach($subCategory['childes'] as $subSubCategory)
                                        <li>
                                            <a href="{{route('products',['id'=> $subSubCategory['id'],'data_from'=>'category','page'=>1])}}">
                                                {{$subSubCategory['name']}}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        --}}


                        <div class="main-bg-color px-3 border-radius-8 collapse" id="sidenav-item-{{$key}}" style="">
                            @foreach($category['childes'] as $subCategory)
                                <a class="custom-transparent-border-bottom py-2" href="#"><span class="font-size-15">{{ $subCategory['name'] }}</span></a>
                            @endforeach
                        </div>

                    @endif





                    
                @endforeach

                                                               
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


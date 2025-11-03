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
        max-height: 420px;
        overflow-y: auto;
        scrollbar-width: thin; /* For Firefox */
        scrollbar-color: #888 #f1f1f1; /* Thumb and track color */
        scroll-behavior: smooth; /* Enables smooth scrolling */
    }

    .custom-vertical-padding {
        padding: 6.5px 0px;
    }

</style>
<!-- Header -->
<header class="header">
    <div class="header-top py-2 d-sm-none">
        <div class="container">
            <div class="d-flex align-items-center flex-wrap justify-content-between gap-2">
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

                                <img class="tnh-country-flag" width=20 " src=" {{ theme_asset('assets/img/flags') }}/{{ strtolower(session('country_shipping')) }}.svg" />

                                @endif
                                <div class="shipping-to m-2 text-white">
                                    @foreach (COUNTRIES as $country)
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
                                left: 50%;
                                left: 50%;
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
                    <li>
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
                    @if($web_config['business_mode'] == 'multi' && $web_config['seller_registration'])
                    <li class="d-none d-xl-block text-white">
                        <a href="{{route('shop.apply')}}" class="d-flex">
                            <div class="fz-16"><i class="bi bi-person-fill-add me-2"></i>{{ translate('Become_a_Seller')}}</div>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="header-middle border-bottom py-3 d-none d-xl-block">
        <div class="container">
            <div class="d-flex align-items-center w-100 justify-content-between gap-2">
                <a class="logo" href="{{route('home')}}">
                    <img src="https://dev.eurobas.de/storage/app/public/company/2024-10-03-66feb0d4490f9.webp" class="dark-support svg h-45" onerror="this.src='{{theme_asset('assets/img/image-place-holder-2_1.png')}}'" alt="Logo" />
                </a>


                <div class="d-flex align-items-center gap-3" >

                    <div class="hide-on-medium-and-small" >
                        <button style="border: solid 1px white !important;color: white;border-radius: 0.375rem;" type="button" class="border-0 px-3 custom-vertical-padding d-flex dropdown-toggle bg-transparent align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i style="transform: translateY(1px);font-size: 17px;" class="bi bi-list me-1"></i>{{ translate('Categories') }}
                        </button>
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
                    </div>

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
                <ul class="nav justify-content-center justify-content-sm-end align-items-center gap-2">
                    <li>

                        <a href="#">
                            <div class="tnh-current-country openPopupBtn">
                                <div class="shipping-to text-white">
                                    {{ translate('Ship to:')}}
                                </div>

                                @if (session('country_shipping')=="All")
                                <h6 class="text-primary"> {{ translate('All Country')}}
                                </h6>
                                @endif
                                @if(session('country_shipping')!="All")

                                <img class="tnh-country-flag" width=20 " src=" {{ theme_asset('assets/img/flags') }}/{{ strtolower(session('country_shipping')) }}.svg" />

                                @endif
                                <div class="shipping-to m-2 text-white">
                                    @foreach (COUNTRIES as $country)
                                    @if ($country['code'] === session('country_shipping'))
                                    {{ substr($country['name'], 0, 5)  }}
                                    @endif
                                    @endforeach
                                    - {{session('currency_symbol')}}
                                </div>

                            </div>

                        </a>

                        <div id="popup" class="popup" style="display: none;">
                            <div class="popup-content">
                                <span class="close">&times;</span>
                                <div style="height: 8px;
                                width: 16px;
                                position: absolute;
                                background: transparent;
                                color: rgb(255 255 255);
                                transform: rotate(0deg) translateY(-100%) translateX(-50%);
                                left: 50%;
                                left: 50%;
                                /* bottom: 93.5%; */
                                z-index: 10;
                                top: 0%;"><svg data-testid="arrow" class="popup-arrow functional-arrow tnh-ship-to-arrow" viewBox="0 0 32 16" style="position: absolute;">
                                        <path d="M16 0l16 16H0z" fill="currentcolor"></path>
                                    </svg></div>

                                <div class="custom-select-wrapper">
                                    <h5 class="my-2"> {{ translate('Specify your location')}}
                                        </h5>
                                        <p>{{ translate('Shipping options and fees vary based on your location')}} </p>
                                    <input type="text" id="searchInput" placeholder="Search for countries...">
                                    <div class="custom-select">
                                        <ul id="countryList">

                                            <li style="margin-block-end: 0;" class="country-item"  data-value="all">

                                                <a class="d-flex gap-2 align-items-center" href="{{ route('country-shipping', ['code' =>'All']) }}">

                                                    {{ translate('All COUNTRIES')}}
                                                </a>
                                            </li>
                                            @foreach (COUNTRIES as $key => $data)
                                            <li style="margin-block-end: 0;" class="country-item" data-value="{{ $data['code'] }}">
                                                 <a class="d-flex gap-2 align-items-center" href="{{ route('country-shipping', ['code' => $data['code']]) }}">
                                                    <img width="20" src="{{theme_asset('assets/img/flags')}}/{{ strtolower($data['code']).'.svg' }}" alt="{{$data['name']}}" />
                                                    {{ ucwords($data['name']) }}
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                   <div class="card-currency">
                                    <h3 class="my-2">
                                        {{ translate('SetCurrency')}}
                                    </h3>
                                    <p>
                                        {{ translate('Select your preferred currency. You can update the settings at any time.')}}
                                    </p>

                                 <div class="currency_box">
                                    @if($web_config['currency_model']=='multi_currency')

                                    <input type="text" id="currencySearchInput" placeholder="Search for currencies...">
                                    <div class="custom-select-currency">
                                        <ul >
                                            @foreach ($web_config['currencies'] as $key => $currency)
                                                <li style="margin-block-end: 0;" class="custom-select-currency-list" data-value="{{ $currency['code'] }}">
                                                    <a class="d-flex gap-2 align-items-center py-1" href="javascript:" onclick="currency_change('{{$currency['code']}}')">
                                                        {{ $currency['name'] }}  ({{$currency['code']}})
                                                    </a>
                                                </li>
                                            @endforeach
                                            <span id="currency-route" data-currency-route="{{route('currency.change')}}"></span>
                                        </ul>

                                    </div>
                                    @endif
                                 </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="language-dropdown">

                        </div>
                    </li>
                    <li>
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
                    @if($web_config['business_mode'] == 'multi' && $web_config['seller_registration'])
                    <li class="d-none d-xl-block">
                        <a href="{{route('shop.apply')}}" class="d-flex text-white white-outlined-button">
                            <div class="fz-16"><i class="bi bi-person-fill-add me-2"></i>{{ translate('Become_a_Seller')}}</div>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="header-main love-sticky py-2 py-lg-3 py-xl-0 shadow-sm">
        <div class="container py-1">
            <!-- Aside -->
            <aside class="aside d-flex flex-column d-xl-none">
                <div class="aside-close p-3 pb-2">
                    <i class="bi bi-x-lg"></i>
                </div>
                <!-- Aside Body -->
                <div>
                    <div class="aside-body" data-trigger="scrollbar">
                        <!-- Search -->
                        <form action="{{route('products')}}" class="mb-3">
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
                            @if($web_config['featured_deals']->count()>0 || $web_config['flash_deals'])
                            <li>
                                <a href="javascript:">{{ translate('offers')}}</a>
                                <ul class="sub_menu">
                                    @if($web_config['featured_deals']->count()>0)
                                    <li><a href="{{route('products',['data_from'=>'featured_deal'])}}">{{ translate('featured_Deal') }}</a></li>
                                    @endif

                                    @if($web_config['flash_deals'])
                                    <li><a href="{{route('flash-deals',[$web_config['flash_deals']?$web_config['flash_deals']['id']:0])}}">{{ translate('Flash_Deal') }}</a></li>
                                    @endif
                                </ul>
                            </li>
                            @endif

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

                            @if ($web_config['discount_product']>0)
                            <li>
                                <a class="d-flex gap-2 align-items-center" href="{{route('products',['data_from'=>'discounted','page'=>1])}}">
                                    {{ translate('Discounted_Products')}}
                                    <i class="bi bi-patch-check-fill text-warning"></i>
                                </a>
                            </li>
                            @endif

                            @if($web_config['business_mode'] == 'multi' && $web_config['seller_registration'])
                                <li class="d-xl-none">
                                    <a href="{{route('shop.apply')}}" class="d-flex orange-color-hover">
                                        <div>{{ translate('Become_a_Seller')}}</div>
                                    </a>
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

            <div class="d-flex justify-content-between gap-3 align-items-center position-relative">
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
                                <img src="{{cloudfront("company")."/".$web_config['mob_logo']->value}}" onerror="this.src='{{theme_asset('assets/img/image-place-holder-2_1.png')}}'" class="dark-support mobile-logo-cs" alt="Logo" />
                            </a>
                        </div>
                        <ul class="nav main-menu align-items-center d-none d-xl-flex flex-nowrap">
                            <li class="{{request()->is('/')?'active':''}}">
                                <a href="{{route('home')}}">{{ translate('Home')}}</a>
                            </li>
                            @if($web_config['featured_deals']->count()>0 || $web_config['flash_deals'])
                            <li>
                                <a class="cursor-pointer">{{ translate('Offers')}}</a>
                                <ul class="sub-menu">
                                    @if($web_config['featured_deals']->count()>0)
                                    <li>
                                        <a href="{{route('products',['data_from'=>'featured_deal'])}}">{{ translate('Featured_Deal') }}</a>
                                    </li>
                                    @endif

                                    @if($web_config['flash_deals'])
                                    <li>
                                        <a href="{{route('flash-deals',[$web_config['flash_deals']?$web_config['flash_deals']['id']:0])}}">{{ translate('Flash_Deal') }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif
                            @if($web_config['business_mode'] == 'multi')
                            <li>
                                <a class="cursor-pointer">{{ translate('stores') }}</a>
                                <div class="sub-menu megamenu p-3" style="--bs-dropdown-min-width: max-content">
                                    <div class="d-flex gap-5">
                                        <div class="column-2 row-gap-3">
                                            @foreach($web_config['shops'] as $shop)
                                            <a href="{{route('shopView',['id'=>$shop['id']])}}" class="media gap-3 align-items-center border-bottom">
                                                <div class="avatar rounded" style="--size: 2.5rem">
                                                    <img onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'" src="{{asset("storage/app/public/shop")}}/{{ $shop->image }}" loading="lazy" class="img-fit rounded dark-support overflow-hidden" alt="" />
                                                </div>
                                                <div class="media-body text-truncate" style="--width: 7rem" title="Morning Mart">
                                                    {{Str::limit($shop->name, 14)}}
                                                </div>
                                            </a>
                                            @endforeach
                                            <div class="d-flex">
                                                <a href="{{route('sellers')}}" class="fw-bold text-primary d-flex justify-content-center">
                                                    {{ translate('view_all') }}...
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </li>
                            @endif

                            @if($web_config['brand_setting'])
                            <li>
                                <a class="cursor-pointer">{{ translate('brands') }}</a>
                                <div class="sub-menu megamenu p-3" style="--bs-dropdown-min-width: max-content">
                                    <div class="d-flex gap-4">
                                        <div class="column-2">
                                            @foreach($brands as $brand)
                                            <a href="{{ route('products',['id'=> $brand['id'],'data_from'=>'brand','page'=>1]) }}" class="media gap-3 align-items-center border-bottom">
                                                <div class="avatar rounded-circle" style="--size: 1.25rem">
                                                    <img onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'" src="{{cloudfront("brand")}}/{{ $brand->image }}" loading="lazy" class="img-fit rounded-circle dark-support" alt="" />
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
                            @if ($web_config['discount_product']>0)
                            <li class="">
                                <a class="d-flex gap-2 align-items-center discount-product-menu {{request()->is('/')?'active':''}}" href="{{route('products',['data_from'=>'discounted','page'=>1])}}">
                                    {{ translate('discounted_products') }}
                                    <i class="bi bi-patch-check-fill text-warning"></i></a>
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
                                    <li><a href="{{route('account-oder')}}"><i class="bi bi-bag-check me-2"></i>{{ translate('my_order') }}</a></li>
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

                    @if(!auth('seller')->check())
                        <li class="login-register d-flex gap-4">
                            <a href="{{ route('seller.auth.login') }}" class="media gap-2 align-items-center text-uppercase fs-12 bg-transparent border-0 p-0">
                                <span class="media-body d-none d-xl-block hover-primary fw-bold">
                                    <i class="bi bi-box-arrow-in-right me-1 fs-17"></i>{{ translate('Seller Login') }}
                                </span>
                            </a>
                        </li>
                    @endif

                        @if(auth('customer')->check())
                            <li class="d-none d-xl-block">
                                <a href="{{ route('chat', 'seller') }}" class="position-relative">
                                    <i class="bi bi-envelope fs-18"></i>
                                    @php($message=\App\Model\Chatting::where(['seen_by_customer'=>0,'user_id'=>auth('customer')->id()])->count())
                                    <span class="count wishlist_count_status bg-danger">{{$message}}</span>
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
                    <li class="d-none d-xl-block" id="cart_items">
                        @include('theme-views.layouts.partials._cart')
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


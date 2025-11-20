@extends('theme-views.layouts.app')

@section('title', translate('My_Profile').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@push('css_or_js')
    <style>
        .cover-image-size {
            width: 100% !important;
            block-size: 15rem !important;
            object-fit: cover;
        }
        .profile-image-size {
            width: 80px !important;
            height: 80px !important;
            object-fit: cover;
        }

        .profile-name {
            font-size: 30px;
            font-weight: 700;
        }

        .profile-description {
            font-size: 18px;
            font-weight: 500;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            height: 36px !important;
        }

        .tab-pane {
            min-height: 80vh;
        }
        .nav-fw {
            font-weight: 500 !important;
        }
        .fs-17 {
            font-size: 17px !important;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            overflow: visible !important;
        }

        .select2-selection__clear {
            display: none !important;
        }

        .line-height-15 {
            line-height: 1.5 !important;
        }
        .bio-text p{
            font-size: 16px;
            font-weight: 400 !important;
        }

        .min-width-filter {
            min-width: 300px;
        }

        .small-responsive-icon {
            width: 40px;
        }

        @media (min-width: 768px) {
            .small-responsive-icon {
                width: 65px;
            }
        }

        @media only screen and (max-width: 991px) {
            .filter-toggle-aside.active {
                -webkit-transform: translateX(-15px) !important;
                -ms-transform: translateX(-15px) !important;
                transform: translateX(-15px) !important;
            }

            .min-width-filter {
                min-width: 330px;
            }
        }

    </style>
@endpush

@section('content')

    <!-- Aside Toggle Button -->
    <div class="aside-toggle-btn d-block d-lg-none bg-light filter-menu-toggle rounded-0 rounded-end">
        <span class="bg-orange rounded d-flex cursor-pointer text-white align-items-center justify-content-center" >
            <i class="bi bi-funnel fs-16"></i>
        </span>
    </div>

    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-4">
        <div class="container">
            <div class="row g-4 px-sm-4 px-0">
                <!-- Full-width row item (col-12) -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="position-relative" >
                                <img class="cover-image-size rounded" src="{{$user_profile['cover_image'] ? cloudfront('profile/covers/'.$user_profile['cover_image']) : theme_asset('assets/img/avatar/def-cover-image.jpg') }}" alt="profile_cover_image">

                                <div class="d-flex align-items-center gap-3 position-absolute bottom-0 start-0 p-3">
                                    <div class="text-center" >
                                        <img class="rounded profile-image-size" src="{{$user_profile['image'] ? cloudfront('profile/images/'.$user_profile['image']) : theme_asset('assets/img/avatar/def-image.jpg') }}" alt="profile_image">
                                    </div>
                                    <div class="d-flex flex-column gap-1" >
                                        <h3 class="text-white profile-name">{{$user_profile->name}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link nav-fw {{ request('tap') == 'ads' ? 'active' : '' }}" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">{{translate('profile_ads')}}</button>
                            <button class="nav-link nav-fw {{ request('tap') == 'profile' ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">{{translate('profile_details')}}</button>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade pt-4 {{ request('tap') == 'ads' ? 'show active' : '' }}" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                            <div class="row">
                                <div class="col-lg-2 responsive-aside filter-toggle-aside min-width-filter" >
                                    <div class="card card-border aside-shadow custom-scroll">
                                        <div class="card-body position-relative">
                                            <div class="d-lg-none close-filter" >
                                                <button class="filter-aside-close border-0 bg-primary text-white rounded-circle pt-1">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                            <form id="filter-form">
                                                @csrf
                                                <div>
                                                    <h4 class="mb-3" >
                                                        <span class="fw-lighter fs-15" >{{translate('results_for_this_filter')}}</span>
                                                        (<span class="fw-bold fs-15" id="ads-count-number">{{ $user_profile->ads->count() }}</span>)
                                                    </h4>
                                                </div>
                                                <button type="button" id="clear-filters" class="btn btn-outline-danger d-inline mb-3 px-1 py-1" >
                                                    <i class="bi bi-x-lg"></i>
                                                    <span class="mx-1" >{{translate('clear_filter')}}</span>
                                                </button>

                                                <div class="mb-2 d-flex gap-0 flex-wrap" id="active-filters">
                                                    @if(request('category_id') && request('category_id') != 'all')
                                                        <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                                        p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item"
                                                        data-id="category" role="button">
                                                            <span>{{translate('categories')}}</span>
                                                            <span class="ms-1 fs-15">&times;</span>
                                                        </span>
                                                    @endif

                                                    @if(request('brand_id') && request('brand_id') != 'all')
                                                        <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                                        p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item"
                                                        data-id="brands" role="button">
                                                            <span>{{translate('brand')}}</span>
                                                            <span class="ms-1 fs-15">&times;</span>
                                                        </span>
                                                    @endif

                                                    @if(request('model_id') && request('model_id') != 'all')
                                                        <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                                        p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item"
                                                        data-id="models" role="button">
                                                            <span>{{translate('model')}}</span>
                                                            <span class="ms-1 fs-15">&times;</span>
                                                        </span>
                                                    @endif

                                                    @if(request('construction_year') && request('construction_year') != 'all')
                                                        <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                                        p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item"
                                                        data-id="min_construction_year" role="button">
                                                            <span>{{translate('min_construction_year')}}</span>
                                                            <span class="ms-1 fs-15">&times;</span>
                                                        </span>
                                                    @endif

                                                    @if(request('price_range') && request('price_range') != 'all')
                                                        <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                                        p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item"
                                                        data-id="max_price" role="button">
                                                            <span>{{translate('max_price')}}</span>
                                                            <span class="ms-1 fs-15">&times;</span>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="mb-3" >
                                                    <div class="form-group mb-2">
                                                        <label for="category">{{ translate('category') }}</label>
                                                        <select style="height: 38px;" data-filter-label="{{translate('category')}}" data-filter-id="category"
                                                        class="form-control custom-input-height filter-input fw-medium" name="category_id" id="category">
                                                            <option data-is-vehicle="1" value="all">{{translate('all')}}</option>
                                                            @foreach($categories as $category)
                                                                <option
                                                                data-is-vehicle="{{$category->category_type == 'vehicles' ? 1 : 0}}" value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-3 my-4">
                                                        <label for="brand">{{ translate('brand') }}</label>
                                                        <select style="height: 38px;" class="form-control filter-input fw-medium"
                                                        data-filter-label="{{translate('brand')}}" data-filter-id="brand" name="brand_id" id="brand">
                                                            <option value="all">{{translate('all')}}</option>
                                                            @foreach($brands as $brand)
                                                                <option
                                                                value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-3 pt-2">
                                                        <label for="model">{{ translate('model') }}</label>
                                                        <select style="height: 38px;" data-filter-label="{{translate('model')}}" data-filter-id="model" id="model"
                                                        class="form-control filter-input fw-medium"
                                                        name="model_id" id="model">
                                                            <option value="all">{{translate('all')}}</option>
                                                            @foreach($models as $model)
                                                                <option
                                                                data-brand-id="{{ $model['brand_id'] }}"
                                                                data-category-id="{{ $model['category_id'] }}"
                                                                value="{{ $model['id'] }}">{{ $model['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-3 mt-2 pt-3" id="status-box">
                                                        <div class="dropdown w-100">
                                                            <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                                                    style="height: 38px;"
                                                                    type="button"
                                                                    id="firstmultiSelectDropdown"
                                                                    data-bs-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                {{translate('status')}}
                                                            </button>
                                                            <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="firstmultiSelectDropdown"
                                                            style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;">
                                                                <li class="dropdown-item p-2 px-3">
                                                                    <label class="d-flex align-items-center gap-1 m-0">
                                                                        <input class="form-check-input filter-input m-0"
                                                                        data-filter-label="{{translate('status')}}" data-filter-name="status[]" type="checkbox" name="status[]" value="never_used">
                                                                        <span>{{ translate('never_used') }}</span>
                                                                    </label>
                                                                </li>
                                                                <li class="dropdown-item p-2 px-3">
                                                                    <label class="d-flex align-items-center gap-1 m-0">
                                                                        <input class="form-check-input filter-input m-0"
                                                                        data-filter-label="{{translate('status')}}" data-filter-name="status[]" type="checkbox" name="status[]" value="new">
                                                                        <span>{{ translate('new') }}</span>
                                                                    </label>
                                                                </li>
                                                                <li class="dropdown-item p-2 px-3">
                                                                    <label class="d-flex align-items-center gap-1 m-0">
                                                                        <input class="form-check-input filter-input m-0"
                                                                        data-filter-label="{{translate('status')}}" data-filter-name="status[]" type="checkbox" name="status[]" value="used">
                                                                        <span>{{ translate('used') }}</span>
                                                                    </label>
                                                                </li>
                                                                <li class="dropdown-item p-2 px-3">
                                                                    <label class="d-flex align-items-center gap-1 m-0">
                                                                        <input class="form-check-input filter-input m-0"
                                                                        data-filter-label="{{translate('status')}}" data-filter-name="status[]" type="checkbox" name="status[]" value="old">
                                                                        <span>{{ translate('old') }}</span>
                                                                    </label>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- Price range -->
                                                    <div class="mb-3" >
                                                        <label for="price">{{translate('Price')}}</label>
                                                        <div class="row">
                                                            <div class="col-6 pe-1" >
                                                                <div class="form-group">
                                                                    <select style="height: 38px;" data-filter-label="{{translate('min_price')}}" data-filter-id="ad_min_price"
                                                                    class="form-select fw-medium filter-input" id="ad_min_price" name="min_price">
                                                                        <option value="{{null}}">{{translate('from')}}</option>
                                                                        <option value="500">500</option>
                                                                        <option value="1000">1,000</option>
                                                                        <option value="1500">1,500</option>
                                                                        <option value="2000">2,000</option>
                                                                        <option value="2500">2,500</option>
                                                                        <option value="3000">3,000</option>
                                                                        <option value="3500">3,500</option>
                                                                        <option value="4000">4,000</option>
                                                                        <option value="4500">4,500</option>
                                                                        <option value="5000">5,000</option>
                                                                        <option value="5500">5,500</option>
                                                                        <option value="6000">6,000</option>
                                                                        <option value="6500">6,500</option>
                                                                        <option value="7000">7,000</option>
                                                                        <option value="7500">7,500</option>
                                                                        <option value="8000">8,000</option>
                                                                        <option value="8500">8,500</option>
                                                                        <option value="9000">9,000</option>
                                                                        <option value="9500">9,500</option>
                                                                        <option value="10000">10,000</option>
                                                                        <option value="12000">12,500</option>
                                                                        <option value="15000">15,000</option>
                                                                        <option value="17500">17,500</option>
                                                                        <option value="20000">20,000</option>
                                                                        <option value="30000">30,000</option>
                                                                        <option value="40000">40,000</option>
                                                                        <option value="50000">50,000</option>
                                                                        <option value="60000">60,000</option>
                                                                        <option value="70000">70,000</option>
                                                                        <option value="80000">80,000</option>
                                                                        <option value="90000">90,000</option>
                                                                        <option value="100000">100,000</option>
                                                                        <option value="125000">125,000</option>
                                                                        <option value="150000">150,000</option>
                                                                        <option value="175000">175,000</option>
                                                                        <option value="200000">200,000</option>
                                                                        <option value="300000">300,000</option>
                                                                        <option value="400000">400,000</option>
                                                                        <option value="500000">500,000</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 ps-1" >
                                                                <div class="form-group">
                                                                    <select style="height: 38px;" class="form-select fw-medium filter-input" id="ad_max_price"
                                                                    data-filter-label="{{translate('max_price')}}" data-filter-id="ad_max_price" name="max_price">
                                                                        <option value="{{null}}">{{translate('to')}}</option>
                                                                        <option value="500">500</option>
                                                                        <option value="1000">1,000</option>
                                                                        <option value="1500">1,500</option>
                                                                        <option value="2000">2,000</option>
                                                                        <option value="2500">2,500</option>
                                                                        <option value="3000">3,000</option>
                                                                        <option value="3500">3,500</option>
                                                                        <option value="4000">4,000</option>
                                                                        <option value="4500">4,500</option>
                                                                        <option value="5000">5,000</option>
                                                                        <option value="5500">5,500</option>
                                                                        <option value="6000">6,000</option>
                                                                        <option value="6500">6,500</option>
                                                                        <option value="7000">7,000</option>
                                                                        <option value="7500">7,500</option>
                                                                        <option value="8000">8,000</option>
                                                                        <option value="8500">8,500</option>
                                                                        <option value="9000">9,000</option>
                                                                        <option value="9500">9,500</option>
                                                                        <option value="10000">10,000</option>
                                                                        <option value="12000">12,500</option>
                                                                        <option value="15000">15,000</option>
                                                                        <option value="17500">17,500</option>
                                                                        <option value="20000">20,000</option>
                                                                        <option value="30000">30,000</option>
                                                                        <option value="40000">40,000</option>
                                                                        <option value="50000">50,000</option>
                                                                        <option value="60000">60,000</option>
                                                                        <option value="70000">70,000</option>
                                                                        <option value="80000">80,000</option>
                                                                        <option value="90000">90,000</option>
                                                                        <option value="100000">100,000</option>
                                                                        <option value="125000">125,000</option>
                                                                        <option value="150000">150,000</option>
                                                                        <option value="175000">175,000</option>
                                                                        <option value="200000">200,000</option>
                                                                        <option value="300000">300,000</option>
                                                                        <option value="400000">400,000</option>
                                                                        <option value="500000">500,000</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- year range -->
                                                    <div class="mb-3" id="year-box" >
                                                        <label class="mb-2" for="construction_year">{{translate('construction_year')}}</label>
                                                        <div class="row">
                                                            <div class="col-6 pe-1" >
                                                                <div class="form-group">
                                                                    <select style="height: 38px;" class="form-select filter-input fw-medium"
                                                                    data-filter-label="{{translate('min_construction_year')}}" data-filter-id="min_construction_year" name="min_construction_year" id="min_construction_year" >
                                                                        <option value="{{null}}">{{translate('from')}}</option>
                                                                        @for ($year = 2025; $year >= 1940; $year--)
                                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 ps-1" >
                                                                <div class="form-group">
                                                                    <select style="height: 38px;" class="form-select filter-input fw-medium" name="max_construction_year"
                                                                    data-filter-label="{{translate('max_construction_year')}}" data-filter-id="max_construction_year" id="max_construction_year" >
                                                                        <option value="{{null}}">{{translate('to')}}</option>
                                                                        @for ($year = 2025; $year >= 1940; $year--)
                                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Mileage range -->
                                                    <div class="mb-3" id="mileage-box">
                                                        <label class="mb-2" for="mileage">{{translate('mileage')}}</label>
                                                        <div class="row">
                                                            <div class="col-6 pe-1" >
                                                                <div class="form-group">
                                                                    <select style="height: 38px;" class="form-select filter-input fw-medium"
                                                                    data-filter-label="{{translate('min_mileage')}}" data-filter-id="min_mileage" id="min_mileage" name="min_mileage">
                                                                        <option value="{{null}}">{{translate('from')}}</option>
                                                                        <option value="500">500</option>
                                                                        <option value="1000">1,000</option>
                                                                        <option value="1500">1,500</option>
                                                                        <option value="2000">2,000</option>
                                                                        <option value="2500">2,500</option>
                                                                        <option value="3000">3,000</option>
                                                                        <option value="3500">3,500</option>
                                                                        <option value="4000">4,000</option>
                                                                        <option value="4500">4,500</option>
                                                                        <option value="5000">5,000</option>
                                                                        <option value="5500">5,500</option>
                                                                        <option value="6000">6,000</option>
                                                                        <option value="6500">6,500</option>
                                                                        <option value="7000">7,000</option>
                                                                        <option value="7500">7,500</option>
                                                                        <option value="8000">8,000</option>
                                                                        <option value="8500">8,500</option>
                                                                        <option value="9000">9,000</option>
                                                                        <option value="9500">9,500</option>
                                                                        <option value="10000">10000</option>
                                                                        <option value="12000">12,500</option>
                                                                        <option value="15000">15,000</option>
                                                                        <option value="17500">17,500</option>
                                                                        <option value="20000">20,000</option>
                                                                        <option value="30000">30,000</option>
                                                                        <option value="40000">40,000</option>
                                                                        <option value="50000">50,000</option>
                                                                        <option value="60000">60,000</option>
                                                                        <option value="70000">70,000</option>
                                                                        <option value="80000">80,000</option>
                                                                        <option value="90000">90,000</option>
                                                                        <option value="100000">100,000</option>
                                                                        <option value="125000">125,000</option>
                                                                        <option value="150000">150,000</option>
                                                                        <option value="175000">175,000</option>
                                                                        <option value="200000">200,000</option>
                                                                        <option value="300000">300,000</option>
                                                                        <option value="400000">400,000</option>
                                                                        <option value="500000">500,000</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 ps-1" >
                                                                <div class="form-group">
                                                                    <select style="height: 38px;" class="form-select filter-input fw-medium"
                                                                    data-filter-label="{{translate('max_mileage')}}" data-filter-id="max_mileage" id="max_mileage" name="max_mileage">
                                                                        <option value="{{null}}">{{translate('to')}}</option>
                                                                        <option value="500">500</option>
                                                                        <option value="1000">1,000</option>
                                                                        <option value="1500">1,500</option>
                                                                        <option value="2000">2,000</option>
                                                                        <option value="2500">2,500</option>
                                                                        <option value="3000">3,000</option>
                                                                        <option value="3500">3,500</option>
                                                                        <option value="4000">4,000</option>
                                                                        <option value="4500">4,500</option>
                                                                        <option value="5000">5,000</option>
                                                                        <option value="5500">5,500</option>
                                                                        <option value="6000">6,000</option>
                                                                        <option value="6500">6,500</option>
                                                                        <option value="7000">7,000</option>
                                                                        <option value="7500">7,500</option>
                                                                        <option value="8000">8,000</option>
                                                                        <option value="8500">8,500</option>
                                                                        <option value="9000">9,000</option>
                                                                        <option value="9500">9,500</option>
                                                                        <option value="10000">10000</option>
                                                                        <option value="12000">12,500</option>
                                                                        <option value="15000">15,000</option>
                                                                        <option value="17500">17,500</option>
                                                                        <option value="20000">20,000</option>
                                                                        <option value="30000">30,000</option>
                                                                        <option value="40000">40,000</option>
                                                                        <option value="50000">50,000</option>
                                                                        <option value="60000">60,000</option>
                                                                        <option value="70000">70,000</option>
                                                                        <option value="80000">80,000</option>
                                                                        <option value="90000">90,000</option>
                                                                        <option value="100000">100,000</option>
                                                                        <option value="125000">125,000</option>
                                                                        <option value="150000">150,000</option>
                                                                        <option value="175000">175,000</option>
                                                                        <option value="200000">200,000</option>
                                                                        <option value="300000">300,000</option>
                                                                        <option value="400000">400,000</option>
                                                                        <option value="500000">500,000</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        @if($paid_banners->count() > 0)
                                            <div class="mt-2 p-3 banner-sidebar d-lg-none">
                                                <h4 class="mb-4">{{ translate('advertising_space') }}</h4>
                                                @foreach($paid_banners as $banner)
                                                    <div class="mb-4">
                                                        <a href="{{ $banner->banner_url ?? '#' }}">
                                                            <img style="height: 140px !important;" class="rounded" width="100%"
                                                            src="{{ cloudfront('paid-banners/'.$banner->banner_image) }}"
                                                            alt="paid_banner_image">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                    </div>

                                    @if($paid_banners->count() > 0)
                                        <div class="mt-4 banner-sidebar d-lg-block d-none">
                                            <h4 class="mb-4">{{ translate('advertising_space') }}</h4>
                                            @foreach($paid_banners as $banner)
                                                <div class="mb-4">
                                                    <a href="{{ $banner->banner_url ?? '#' }}">
                                                        <img style="height: 140px !important;" class="rounded" width="100%"
                                                        src="{{ cloudfront('paid-banners/'.$banner->banner_image) }}"
                                                        alt="paid_banner_image">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="col">
                                    @include('theme-views.partials._ajax-products-view',['ads'=>$user_ads])
                                    <div id="fullscreen-loader" class="d-none"
                                        style="position: fixed;top: 50%;left: 50%;transform: translate(-50%, -50%);z-index: 9999999;z-index: 9999999;">
                                        <div class="spinner-border text-primary" role="status" style="width: 7rem; height: 7rem;">
                                            <span class="visually-hidden">{{translate('Loading')}}...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade {{ request('tap') == 'profile' ? 'show active' : '' }}" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                            <div class="card bg-transparent">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card product-card-shadow">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex flex-column gap-2" >
                                                                <img width="40px" src="{{ theme_asset('assets/img/icons/vehicle-icon.png') }}" alt="">
                                                                <h3 class="mb-0 text-primary">{{translate('ads_number')}}</h3>
                                                            </div>
                                                            <p class="fs-28 fw-medium">{{$user_ads_count}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-8 col-12 mb-4" >
                                            <h4 class="bio-text text-secondary line-height-15" >
                                                {!! $user_profile->bio !!}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="row align-items-center gap-4 mb-4">
                                        <div class="col-auto" >
                                            @if($user_profile->show_email_address == 1)
                                                <div class="d-flex align-items-center gap-2 mb-2" >
                                                    <i class="bi bi-envelope fs-16 text-primary"></i>
                                                    <p class="mb-0 fw-normal fs-14 text-dark">{{$user_profile->email}}</p>
                                                </div>
                                            @endif

                                            @if($user_profile->show_location_data == 1)
                                                <div class="d-flex align-items-center gap-2 mb-2" >
                                                    <i class="bi bi-geo-alt fs-16 text-primary"></i>
                                                    <p class="mb-0 fw-normal fs-14 text-dark">{{$user_profile->country}}, {{$user_profile->city}}</p>
                                                </div>
                                            @endif

                                            @if($user_profile->show_location_data == 1)
                                                <div class="d-flex align-items-center gap-2 mb-2" >
                                                    <i class="bi bi-mailbox fs-16 text-primary"></i>
                                                    <p class="mb-0 fw-normal fs-14 text-dark">{{$user_profile->postal_code}}</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-auto" >
                                            @if($user_profile->show_phone_number == 1)
                                                <div class="d-flex align-items-center gap-2 mb-2" >
                                                    <i class="bi bi-telephone fs-16 text-primary"></i>
                                                    <p class="mb-0 fw-normal fs-14 text-dark">{{$user_profile->phone_code}}{{$user_profile->phone}}</p>
                                                </div>
                                            @endif

                                            @if($user_profile->show_location_data == 1)
                                                <div class="d-flex align-items-start gap-2 mb-2" >
                                                    <i class="bi bi-pin-map fs-16 text-primary"></i>
                                                    <p class="mb-0 fw-normal fs-14 text-dark">{{ substr($user_profile->street_address,0,150) }}{{strlen($user_profile->street_address) > 150 ? '...' : ''}}</p>
                                                </div>
                                            @endif
                                            <div class="d-flex align-items-start gap-2 mb-2" >
                                                <i class="bi bi-calendar4 fs-16 text-primary"></i>
                                                <p class="mb-0 fw-normal fs-14 text-dark">{{ $user_profile->created_at->format('d F Y') }} ({{ $user_profile->created_at->diffForHumans() }})</p>
                                            </div>
                                        </div>
                                    </div>
                                    @if($user_categories->count() > 0)
                                        <div class="mb-4">
                                            <h3 class="mb-2" >{{translate('we_publishing_on_this_categories')}}</h3>
                                            <div>
                                                <div class="row align-items-center gap-3 flex-wrap" >
                                                    <div class="col-md-8 col-sm-12 col-12">
                                                        <div class="d-flex align-items-center gap-3 flex-wrap" >
                                                            @foreach($user_categories as $category)
                                                                <div class="text-center" >
                                                                    <div>
                                                                        <img class="small-responsive-icon" src="{{cloudfront('category')}}/{{ $category->icon }}" alt="category-icon">
                                                                    </div>
                                                                    <span class="fw-normal fs-12">{{$category->name}}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($user_brands->count() > 0)
                                        <div class="mb-4">
                                            <h3 class="mb-4" >{{translate('and_this_brands')}}</h3>

                                            <div class="row align-items-center gap-3 flex-wrap" >
                                                <div class="col-md-8 col-sm-12 col-12">
                                                    <div class="d-flex align-items-center gap-3 flex-wrap" >
                                                        @foreach($user_brands as $brand)
                                                            <div>
                                                                <img class="small-responsive-icon" src="{{cloudfront('brand')}}/{{ $brand->image }}" alt="category-icon">
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
        </div>
    </main>
    <!-- End Main Content -->
@endsection


@push('script')

    <script>
        $(document).ready(function () {
            const $brandSelect = $('#brand');
            const $modelSelect = $('#model');
            const $colorSelect = $('#color');
            const $categorySelect = $('#category');

            // Select2 init
            $brandSelect.select2({
                placeholder: "{{ translate('brand') }}",
                allowClear: true
            });

            $modelSelect.select2({
                placeholder: "{{ translate('model') }}",
                allowClear: true
            });

            $colorSelect.select2({
                placeholder: "{{ translate('color') }}",
                allowClear: true
            });

            const allBrandOptions = $brandSelect.find('option').clone();
            const allModelOptions = $modelSelect.find('option').clone();

            const allBrandOption = '<option value="all">{{ translate("all") }}</option>';
            const allModelOption = '<option value="all">{{ translate("all") }}</option>';
            const allColorOption = '<option value="all">{{ translate("all") }}</option>';

            function filterBrandsAndModels() {
                const $selectedCategoryOption = $categorySelect.find('option:selected');
                const selectedCategoryId = $selectedCategoryOption.val();
                const selectedCategoryDataId = $selectedCategoryOption.data('id');

                $brandSelect.find('option:not([value="all"])').remove(); // ✅ Fix: keep "all", remove the rest

                allBrandOptions.each(function () {
                    const brandCategories = $(this).data('brand-categories')?.toString().split(',').map(s => s.trim()) || [];

                    if (
                        $(this).val() === 'all' || // optional: can skip this since we kept it already
                        selectedCategoryDataId === 0 ||
                        brandCategories.includes(selectedCategoryId)
                    ) {
                        if ($(this).val() !== 'all') { // prevent appending "all" again
                            $brandSelect.append($(this).clone());
                        }
                    }
                });

                $brandSelect.val('all').trigger('change');
            }

            function filterModels() {
                const selectedCategoryId = $categorySelect.val();
                const selectedBrandId = $brandSelect.val();

                $modelSelect.html(allModelOption);
                const addedValues = new Set(['all']);

                allModelOptions.each(function () {
                    const brandId = $(this).data('brand-id');
                    const modelCategories = $(this).data('model-categories')?.toString().split(',').map(s => s.trim()) || [];
                    const value = $(this).val();

                    const brandMatch = !brandId || brandId == selectedBrandId || selectedBrandId === 'all';
                    const categoryMatch = selectedCategoryId === "all" || modelCategories.includes(selectedCategoryId);

                    if (brandMatch && categoryMatch && !addedValues.has(value)) {
                        $modelSelect.append($(this).clone());
                        addedValues.add(value);
                    }
                });

                $modelSelect.val('all').trigger('change');

                if (selectedBrandId === 'all') {
                    $modelSelect.prop('disabled', true);
                } else {
                    $modelSelect.prop('disabled', false);
                }

            }

            $categorySelect.on('change', function () {
                filterBrandsAndModels();
            });

            $brandSelect.on('change', function () {
                filterModels();
            });

            // Initial trigger
            filterBrandsAndModels();

            // --- COLOR HANDLING ---
            $colorSelect.on('select2:open', function () {
                setTimeout(function () {
                    $('.select2-results__option').each(function () {
                        const color = $(this).text().trim();
                        if (!$(this).find('.color-square').length && color.toLowerCase() !== '{{ strtolower(translate("All")) }}') {
                            const square = $('<span class="color-square"></span>').css({
                                display: 'inline-block',
                                width: '30px',
                                height: '15px',
                                border: 'solid #cfcfcf 1px',
                                backgroundColor: color,
                                marginLeft: '8px',
                                verticalAlign: 'middle',
                                borderRadius: '2px'
                            });
                            $(this).append(square);
                        }
                    });
                }, 0);
            });

            $colorSelect.on('change', function () {
                setTimeout(function () {
                    const $selection = $colorSelect.next('.select2-container').find('.select2-selection__rendered');
                    $selection.find('.selected-color-square').remove();

                    const color = $selection.text().trim();

                    if (color.toLowerCase() === 'all') return;

                    const square = $('<span class="selected-color-square"></span>').css({
                        display: 'inline-block',
                        width: '30px',
                        height: '15px',
                        border: 'solid #cfcfcf 1px',
                        backgroundColor: color,
                        marginLeft: '8px',
                        verticalAlign: 'middle',
                        borderRadius: '2px'
                    });

                    $selection.append(square);
                }, 0);
            });

            $colorSelect.on('select2:open', function () {
                const colorSelectContainer = $colorSelect.data('select2').$dropdown;
                const searchInput = colorSelectContainer.find('.select2-search__field');

                searchInput.off('input').on('input', function () {
                    setTimeout(function applyColorSquares() {
                        const $options = colorSelectContainer.find('.select2-results__option');

                        $options.each(function () {
            const $option = $(this);
            const color = $option.text().trim();

            if (
                !$option.hasClass('select2-results__message') &&
                color &&
                !$option.find('.color-square').length &&
                color.toLowerCase() !== '{{ strtolower(translate("All")) }}'
            ) {
                const square = $('<span class="color-square"></span>').css({
                    display: 'inline-block',
                    width: '30px',
                    height: '15px',
                    border: 'solid #cfcfcf 1px',
                    backgroundColor: color,
                    marginLeft: '8px',
                    verticalAlign: 'middle',
                    borderRadius: '2px'
                });

                $option.append(square);
            }
        });

                        setTimeout(applyColorSquares, 50);
                    }, 0);
                });
            });
        });
    </script>

    <script>
        // Prevent dropdown from closing when clicking inside
        document.querySelectorAll('.dropdown-menu.keep-open').forEach(function(menu) {
            menu.addEventListener('click', function(e) {
            e.stopPropagation();
            });
        });
    </script>

    <script>
        let offset = 5;
        let loading = false;
        let is_available_items = true;
        let shownAdIds = [];
        let initial_ads_number;
        let is_tab_ads_active = $('#nav-profile-tab').hasClass('active');

        $('#nav-profile-tab').on('click', function() {
            is_tab_ads_active = true;
        });

        $('#nav-home-tab').on('click', function() {
            is_tab_ads_active = false;
        });

        $('#ajax-products-view input[data-shown-ads]').each(function() {
            let adId = $(this).data('shown-ads');
            if (adId && !shownAdIds.includes(adId)) {
                shownAdIds.push(adId);
                initial_ads_number = shownAdIds.length;
            }
        });

        let no_additional_to_show = `
            <div class="text-center" >
                <h5 class="pb-4" >{{translate('there_is_no_additional_ads_to_show')}}</h5>
            </div>
        `;

        $(window).on('scroll', function () {
            if (loading) return;

            if(initial_ads_number && initial_ads_number < 4) {
                initial_ads_number = null;
                is_available_items = false;
            }

            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 500 && is_tab_ads_active) {
                loading = true;

                if(is_available_items) {
                    let formData = $('#filter-form').serialize() + `&offset=${offset}&limit=5`;

                    $('#fullscreen-loader').removeClass('d-none');

                    $.ajax({
                        url: "{{ route('ads-filter') }}",
                        method: "POST",
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.html) {
                                response.html.trim();
                                $('#ajax-products-view').append(response.html);

                                if (response.show_ad_ids) {
                                    let newIds = Array.isArray(response.show_ad_ids) ? response.show_ad_ids : Object.values(response.show_ad_ids);
                                    shownAdIds = [...shownAdIds, ...newIds];
                                }
                                offset += 5;
                            }
                            if(response.ads_count == 0) {

                                let formData = $('#filter-form').serializeArray();
                                shownAdIds.forEach(id => {
                                    formData.push({ name: 'shown_ad_ids[]', value: id });
                                });

                                $.ajax({
                                    url: "{{ route('load-related-ads') }}",
                                    method: "POST",
                                    data: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    success: function (related_ads_response) {
                                        if (related_ads_response.related_ads_count > 0) {
                                            $('#ajax-products-view').append(`
                                                <h2 class="pb-4">{{translate('ads_that_may_interest_you')}}</h2>
                                            `);
                                            $('#ajax-products-view').append(related_ads_response.html);
                                        }

                                        $('#ajax-products-view').append(`
                                            <div class="d-flex justify-content-center" >
                                                <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"
                                                class="mb-4 btn btn-primary d-flex align-items-center gap-2" >
                                                    <i class="bi bi-arrow-up"></i>
                                                    {{translate('back_to_top')}}
                                                </button>
                                            </div>
                                        `);
                                    },
                                });

                                is_available_items = false;
                            }
                        },
                        complete: function () {
                            loading = false;
                            $('#fullscreen-loader').addClass('d-none');
                        }
                    });
                }
            }
        });

        function filterAds() {
            var formData = $('#filter-form').serialize();

            formData += '&user_id=' + user_id;

            // Show full-screen loader
            $('#fullscreen-loader').removeClass('d-none');

            $.ajax({
                url: "{{ route('profile-ads-filter') }}",
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    $('#ajax-products-view').html(response.html);
                    $('#ads-count-number').text(response.count);
                    offset = 5;
                    if(response.count > 0) {

                        is_available_items = true;
                        loading = false;
                        if(response.count <= 5) {
                            is_available_items = false;
                            loading = true;
                        }

                        shownAdIds = [];

                        let newIds = Array.isArray(response.show_ad_ids) ? response.show_ad_ids : Object.values(response.show_ad_ids);
                        shownAdIds = [...newIds];

                        if (response.count >= 5) {
                            const scrollPercent = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
                            if (scrollPercent > 30) {
                                window.scrollTo({ top: 0, behavior: 'auto' });
                            }
                        }
                    }
                },
                error: function (xhr) {
                    console.error("AJAX Error: ", xhr.responseText);
                },
                complete: function () {
                    // Hide loader after success or error
                    $('#fullscreen-loader').addClass('d-none');
                }
            });
        }

        $(document).ready(function () {
            // Initialize Select2 when switching to the ads tab, but only for brand and model
            $('#nav-profile-tab').on('shown.bs.tab', function (e) {
                // Reinitialize only brand and model selects
                if ($('#brand').data('select2')) {
                    $('#brand').select2('destroy');
                }
                $('#brand').select2({
                    placeholder: "{{ translate('choose_brand') }}",
                    allowClear: true
                });

                if ($('#model').data('select2')) {
                    $('#model').select2('destroy');
                }
                $('#model').select2({
                    placeholder: "{{ translate('choose_model') }}",
                    allowClear: true
                });
            });

            let debounceTimer;
            $('.filter-input').on('change', function () {
                $('#clear-filters').prop('disabled', false);
                filterAds();
                updateActiveFilters();
            });

            $('.filter-input').on('keyup', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function () {
                    filterAds();
                    $('#clear-filters').prop('disabled', false);
                    updateActiveFilters();
                }, 2000);
            });


            $('#clear-filters').on('click', function () {
                $('.filter-input').each(function () {
                    if ($(this).is(':checkbox')) {
                        $(this).prop('checked', false); // Uncheck checkboxes
                    } else if ($(this).is('select')) {
                        $(this).prop('selectedIndex', 0); // Reset select to first option
                        if ($(this).find('option[value="all"]').length) {
                            $(this).val('all').trigger('change');
                        }
                    } else {
                        $(this).val(''); // Clear text inputs
                    }
                });

                filterAds();
                $('#clear-filters').prop('disabled', true);
                updateActiveFilters();
            });


            function updateActiveFilters() {
                const $container = $('#active-filters');
                $container.html('');

                $('.filter-input').each(function () {
                    const $el = $(this);
                    const label = $el.data('filter-label');
                    const id = $el.data('filter-id');
                    const name = $el.data('filter-name');
                    const value = $el.val();
                    const type = $el.attr('type');

                    // Checkbox group (name)
                    if (type === 'checkbox' && $el.is(':checked') && name) {
                        if ($container.find(`.active-filter-item[data-name="${name}"]`).length === 0) {
                            const filterHtml = `
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item" data-name="${name}" role="button">
                                    <span>${label}</span>
                                    <span class="ms-1 fs-18">&times;</span>
                                </span>
                        `;
                            $container.append(filterHtml);
                        }
                    }

                    else if ($el.is('select')) {
                        if (value && value !== 'all') {
                            if ($container.find(`.active-filter-item[data-id="${id}"]`).length === 0) {
                                const filterHtml = `
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item"
                                    data-id="${id}" role="button">
                                        <span>${label}</span>
                                        <span class="ms-1 fs-18">&times;</span>
                                </span>
                                `;
                                $container.append(filterHtml);
                            }
                        }
                    }

                });

            }

            $(document).on('click', '.active-filter-item', function () {

                const id = $(this).data('id');
                const name = $(this).data('name');

                let $elmByDataId = $('[data-filter-id="' + id + '"]');
                let $elmByName = $('[name="' + name + '"]');

                if (id) {
                    if ($elmByDataId.attr('type') === 'text' || $elmByDataId.attr('type') === 'number') {
                        $elmByDataId.val('');
                    } else if ($elmByDataId.is('select')) {
                        if ($elmByDataId.find('option[value="all"]').length > 0) {
                            $elmByDataId.val('all').trigger('change');
                        } else{
                            $elmByDataId.prop('selectedIndex', 0).trigger('change');
                        }
                    }

                }

                if (name) {
                    $elmByName.each(function () {
                        $(this).prop('checked', false);
                    });
                    filterAds();
                }

                updateActiveFilters();

                if($('#active-filters').html() == '') {
                    $('#clear-filters').prop('disabled', true);
                }
            });

        });

    </script>

@endpush


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
                                        <h3 class="text-white profile-name mb-0">{{$user_profile->name}}</h3>
                                        {{-- Milestone 3: seller average rating --}}
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="star-rating text-gold" style="font-size: 14px;">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $seller_summary['avg'])
                                                        <i class="bi bi-star-fill"></i>
                                                    @elseif ($seller_summary['avg'] != 0 && $i <= (int)$seller_summary['avg'] + 1 && $seller_summary['avg'] >= ((int)$seller_summary['avg'] + .30))
                                                        <i class="bi bi-star-half"></i>
                                                    @else
                                                        <i class="bi bi-star text-white-50"></i>
                                                    @endif
                                                @endfor
                                            </span>
                                            <span class="text-white fw-semibold fs-12" id="seller-rating-text">
                                                {{ $seller_summary['avg'] }} ({{ $seller_summary['count'] }} {{ translate('reviews') }})
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Milestone 3: Seller action toolbar (Contact / Rate / Block / Report) --}}
                @if(!auth('customer')->check() || auth('customer')->id() != $user_profile->id)
                <div class="col-12">
                    <div class="card card-border aside-shadow">
                        <div class="card-body py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div class="d-flex align-items-center gap-2 text-muted fs-14">
                                <i class="bi bi-shield-check"></i>
                                <span>{{ translate('contact_or_review_this_seller') }}</span>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                @if(auth('customer')->check())
                                    <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#contactSellerProfileModal">
                                        <i class="bi bi-chat-square-fill"></i> {{ translate('contact_seller') }}
                                    </button>
                                    <button class="btn btn-outline-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#rateSellerModal">
                                        <i class="bi bi-star-fill"></i> {{ $my_review ? translate('edit_review') : translate('rate_seller') }}
                                    </button>
                                    <button id="profile-block-btn" class="btn btn-outline-secondary d-flex align-items-center gap-2"
                                            onclick="profileToggleBlock({{$user_profile->id}}, {{ $is_blocked ? 'false' : 'true' }})">
                                        <i class="bi {{ $is_blocked ? 'bi-unlock' : 'bi-slash-circle' }}"></i>
                                        <span>{{ $is_blocked ? translate('unblock') : translate('block') }}</span>
                                    </button>
                                    <button class="btn btn-outline-danger d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#reportSellerModal">
                                        <i class="bi bi-flag"></i> {{ translate('report') }}
                                    </button>
                                @else
                                    <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                                        <i class="bi bi-chat-square-fill"></i> {{ translate('contact_seller') }}
                                    </button>
                                    <button class="btn btn-outline-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                                        <i class="bi bi-star-fill"></i> {{ translate('rate_seller') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Milestone 3: Seller reviews list --}}
                @if($seller_reviews->count() > 0)
                <div class="col-12">
                    <div class="card card-border aside-shadow">
                        <div class="card-body">
                            <h5 class="mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-star-fill text-gold"></i>
                                {{ translate('seller_reviews') }}
                                <span class="badge bg-primary">{{ $seller_summary['count'] }}</span>
                            </h5>
                            <div class="d-flex flex-column gap-3">
                                @foreach($seller_reviews as $review)
                                    <div class="border-bottom pb-3">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <img width="32" height="32" class="rounded-circle"
                                                 onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                                 src="{{ cloudfront('profile/images/'.($review->customer->image ?? 'default.png')) }}" alt="">
                                            <span class="fw-medium">{{ $review->customer->name ?? translate('user') }}</span>
                                            <span class="star-rating text-gold ms-1" style="font-size: 12px;">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                @endfor
                                            </span>
                                            <span class="text-muted fs-12 ms-auto">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if($review->comment)
                                            <p class="mb-0 text-muted">{{ $review->comment }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif

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
                                                <input type="hidden" name="profile_id" value="{{$user_profile->id}}" >
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
                                                                        @for ($year = date('Y'); $year >= 1940; $year--)
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
                                                                        @for ($year = date('Y'); $year >= 1940; $year--)
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

    @if(auth('customer')->check() && auth('customer')->id() != $user_profile->id)
        {{-- Milestone 3: Contact Seller modal (reuses existing discussion_store, no logic change) --}}
        <div class="modal fade" id="contactSellerProfileModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ translate('contact_seller') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="contactSellerProfileForm">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="chat_with" value="{{ $user_profile->id }}">
                            <label class="mb-1">{{ translate('your_message') }}</label>
                            <textarea name="message" class="form-control" rows="4" required
                                      placeholder="{{ translate('write_your_message_here') }}"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ translate('cancel') }}</button>
                            <button type="submit" class="btn btn-primary">{{ translate('send_message') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Milestone 3: Rate Seller modal --}}
        <div class="modal fade" id="rateSellerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ translate('rate_seller') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="rateSellerForm">
                        @csrf
                        <div class="modal-body text-center">
                            <input type="hidden" name="seller_id" value="{{ $user_profile->id }}">
                            <input type="hidden" name="rating" id="rateSellerValue" value="{{ $my_review->rating ?? 0 }}">
                            <div class="star-input fs-1 text-gold mb-3" id="rateStarInput">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ ($my_review && $i <= $my_review->rating) ? 'bi-star-fill' : 'bi-star' }} rate-star" data-val="{{ $i }}" style="cursor:pointer;"></i>
                                @endfor
                            </div>
                            <textarea name="comment" class="form-control" rows="3"
                                      placeholder="{{ translate('write_your_review_optional') }}">{{ $my_review->comment ?? '' }}</textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ translate('cancel') }}</button>
                            <button type="submit" class="btn btn-primary">{{ translate('submit_review') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Milestone 3: Report Seller modal (reuses Milestone 2 user_reports) --}}
        <div class="modal fade" id="reportSellerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ translate('report_seller') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="reportSellerForm">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="reported_id" value="{{ $user_profile->id }}">
                            <input type="hidden" name="type" value="seller">
                            <div class="form-group mb-3">
                                <label>{{ translate('reason') }}</label>
                                <select name="reason" class="form-control">
                                    <option value="spam">{{ translate('spam_or_scam') }}</option>
                                    <option value="fraud">{{ translate('fraudulent_listing') }}</option>
                                    <option value="abuse">{{ translate('abusive_or_harassment') }}</option>
                                    <option value="other">{{ translate('other') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ translate('details') }}</label>
                                <textarea name="message" class="form-control" rows="3" placeholder="{{ translate('describe_the_issue') }}"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ translate('cancel') }}</button>
                            <button type="submit" class="btn btn-danger">{{ translate('submit_report') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection


@push('script')
    {{-- Milestone 3: seller profile actions (contact / rate / block / report) --}}
    <script>
        $(function () {
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } });

            // ── Contact seller (first message) ──
            $('#contactSellerProfileForm').on('submit', function (e) {
                e.preventDefault();
                var $f = $(this);
                $.ajax({
                    type: 'post',
                    url: "{{ route('discussion_store') }}",
                    data: $f.serialize(),
                    success: function (res) {
                        if (res.error_message) { toastr.error(res.error_message); return; }
                        toastr.success("{{ translate('message_sent') }}");
                        $('#contactSellerProfileModal').modal('hide');
                        setTimeout(function () {
                            window.location.href = "{{ route('chat', 'user') }}?id={{ $user_profile->id }}";
                        }, 800);
                    },
                    error: function (err) {
                        var msg = (err.responseJSON && typeof err.responseJSON === 'string') ? err.responseJSON : "{{ translate('something_went_wrong') }}";
                        toastr.warning(msg);
                    }
                });
            });

            // ── Rate seller (star picker) ──
            $('#rateStarInput').on('click', '.rate-star', function () {
                var val = $(this).data('val');
                $('#rateSellerValue').val(val);
                $('#rateStarInput .rate-star').each(function () {
                    $(this).toggleClass('bi-star-fill', $(this).data('val') <= val)
                           .toggleClass('bi-star', $(this).data('val') > val);
                });
            });
            $('#rateSellerForm').on('submit', function (e) {
                e.preventDefault();
                if (parseInt($('#rateSellerValue').val()) < 1) { toastr.error("{{ translate('please_select_a_rating') }}"); return; }
                $.ajax({
                    type: 'post',
                    url: "{{ route('seller-review-store') }}",
                    data: $(this).serialize(),
                    success: function (res) {
                        if (res.error_message) { toastr.error(res.error_message); return; }
                        toastr.success(res.message);
                        $('#rateSellerModal').modal('hide');
                        if (res.avg !== undefined) {
                            $('#seller-rating-text').text(res.avg + ' (' + res.count + ' {{ translate('reviews') }})');
                        }
                        setTimeout(function () { location.reload(); }, 900);
                    },
                    error: function () { toastr.error("{{ translate('something_went_wrong') }}"); }
                });
            });

            // ── Report seller ──
            $('#reportSellerForm').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'post',
                    url: "{{ route('report_user') }}",
                    data: $(this).serialize(),
                    success: function (res) {
                        if (res.error_message) { toastr.error(res.error_message); return; }
                        toastr.success(res.message);
                        $('#reportSellerModal').modal('hide');
                        $('#reportSellerForm')[0].reset();
                    },
                    error: function () { toastr.error("{{ translate('something_went_wrong') }}"); }
                });
            });
        });

        // ── Block / unblock seller ──
        function profileToggleBlock(userId, block) {
            $.ajax({
                type: 'post',
                url: block ? "{{ route('block_user') }}" : "{{ route('unblock_user') }}",
                data: { blocked_id: userId, _token: $('meta[name="_token"]').attr('content') },
                success: function (res) {
                    if (res.error_message) { toastr.error(res.error_message); return; }
                    toastr.success(res.message);
                    setTimeout(function () { location.reload(); }, 700);
                },
                error: function () { toastr.error("{{ translate('something_went_wrong') }}"); }
            });
        }
    </script>


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

        // ================== Filter Logic ==================
        function filterAds() {
            var formData = $('#filter-form').serialize();
            $('#fullscreen-loader').removeClass('d-none');

            $.ajax({
                url: "{{ route('ads-filter') }}",
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
                    $('#fullscreen-loader').addClass('d-none');
                }
            });
        }

        // ================== Update Active Filters ==================
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

                if (type === 'checkbox' && $el.is(':checked') && name) {
                    if ($container.find(`.active-filter-item[data-name="${name}"]`).length === 0) {
                        const filterHtml = `
                            <span class="d-flex align-items-center gap-1 bg-primary text-light rounded p-1 px-2 fs-13 fw-medium mb-2 active-filter-item" data-name="${name}" role="button">
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
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded p-1 px-2 fs-13 fw-medium  mb-1 active-filter-item"
                                data-id="${id}" role="button">
                                    <span>${label}</span>
                                    <span class="ms-1 fs-18">&times;</span>
                            </span>
                            `;
                            $container.append(filterHtml);
                        }
                    }
                }
                else if ((type === 'text' || type === 'number') && value && id){
                    if ($container.find(`.active-filter-item[data-id="${name}"]`).length === 0) {
                        const filterHtml = `
                            <span class="d-flex align-items-center gap-1 bg-primary text-light rounded p-1 px-2 fs-13 fw-medium mb-2 active-filter-item" data-id="${id}" role="button">
                                <span>${label}</span>
                                <span class="ms-1 fs-18">&times;</span>
                            </span>
                    `;
                        $container.append(filterHtml);
                    }
                }
            });
        }

        // ================== Toggle Category Fields ==================
        function toggleCategoryFilterFields() {
            let selectedOption = $('#category').find(':selected');
            let selectedType = selectedOption.data('category-type');
            let selectedSlug = selectedOption.data('category-slug');

            $('[data-category-types]').each(function () {
                let allowedTypes = $(this).data('category-types').split(',').map(type => type.trim());
                let showItem = allowedTypes.includes(selectedType) || selectedType === 'all' || allowedTypes.includes('all');
                let isBicycle = $(this).data('is-bicycle');

                if (isBicycle && selectedSlug !== 'bicycles') showItem = false;

                if((selectedSlug == 'spare-parts' || selectedSlug == 'vehicle-accessories') &&
                    $(this).data('vehicle-equipment') == 0) showItem = false;

                if ($(this).data('is-not-bicycle') !== undefined && selectedSlug == 'bicycles') showItem = false;

                if (showItem) {
                    $(this).show();
                } else {
                    $(this).hide();
                }

            });
        }

        // ================== Document Ready ==================
        $(document).ready(function () {
            toggleCategoryFilterFields();

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

            $('#apply_location_search').on('click', function() {
                if($('#location_radius').val() != '' && $('#location_city').val() == '') {
                    toastr.error('{{translate("add_city_before_you_search_by_radius")}} .');
                    return;
                }

                filterAds();
                updateActiveFilters();
            });

            $('#location_city').on('keyup', function() {
                const cityValue = $(this).val().trim();
                const $radiusField = $('#location_radius');

                if (cityValue !== '') {
                    $radiusField.val('').prop('disabled', false);
                } else {
                    $radiusField.prop('disabled', true);
                }
            });

            $('#clear-filters').on('click', function () {
                $('.filter-input').each(function () {
                    if ($(this).is(':checkbox')) {
                        $(this).prop('checked', false);
                    } else if ($(this).is('select')) {
                        $(this).prop('selectedIndex', 0);
                        if ($(this).find('option[value="all"]').length) {
                            if (!$(this).is('#category')) {
                                $(this).val('all').trigger('change');
                            } else {
                                $(this).val('all');
                            }
                        }
                    } else {
                        $(this).val('');
                    }
                });

                $('#location_country').val('All Europe').trigger('change');
                $('#location_city').val('');
                $('#location_radius').val('');
                $('#location_lat').val('');
                $('#location_lng').val('');

                filterAds();
                $('#clear-filters').prop('disabled', true);
                updateActiveFilters();
            });

            $('#category').on('change', function () {
                toggleCategoryFilterFields();

                const categoryVal = $(this).val();

                $('.filter-input').each(function () {
                    if ($(this).is('#category') && categoryVal !== 'all') {
                        return; // skip clearing category if value is not "all"
                    }

                    if ($(this).is(':checkbox')) {
                        $(this).prop('checked', false);
                    } else if ($(this).is('select')) {
                        $(this).prop('selectedIndex', 0);
                        if ($(this).find('option[value="all"]').length) {
                            if (!$(this).is('#category')) {
                                $(this).val('all').trigger('change');
                            } else {
                                $(this).val('all');
                            }
                        }
                    } else {
                        $(this).val('');
                    }
                });

                $('#location_country').val('All Europe').trigger('change');
                $('#location_city').val('');
                $('#location_radius').val('');
                $('#location_lat').val('');
                $('#location_lng').val('');

                filterAds();
                $('#clear-filters').prop('disabled', true);
                updateActiveFilters();
            });

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

                    if($elmByDataId.hasClass('location-filter-input')) {
                        if(id === 'location_city') { $('#location_lat').val(''); $('#location_lng').val(''); }
                        filterAds();
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

        <script>
        let map;
        let geocoder;
        let currentCircle;
        let autocomplete;
        let currentMarker;

        function initAutocomplete() {
            // Get initial center and zoom based on selected country
            const initialMapSettings = getInitialMapSettings();

            // Initialize the map
            map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                zoom: initialMapSettings.zoom,
                center: initialMapSettings.center,
                mapTypeId: "roadmap",
                disableDefaultUI: true,
                draggable: false,
                zoomControl: false,
                scrollwheel: false,
                disableDoubleClickZoom: true,
                gestureHandling: 'none'
            });

            // Initialize geocoder
            geocoder = new google.maps.Geocoder();

            // Listen for country selection changes
            const countrySelect = document.getElementById("location_country");
            if (countrySelect) {
                countrySelect.addEventListener('change', function() {
                    updateMapForCountry(this.value);
                });
            }

            // Initialize autocomplete for city input
            const cityInput = document.getElementById("location_city");
            if (cityInput) {
                autocomplete = new google.maps.places.Autocomplete(cityInput, {
                    types: ['(cities)'],
                    fields: ['place_id', 'geometry', 'name', 'formatted_address']
                });

                // Listen for place selection from autocomplete
                autocomplete.addListener('place_changed', function() {
                    const place = autocomplete.getPlace();
                    if (place.geometry) {
                        focusOnCity(place.geometry.location, place.name);
                    }
                });

                // Listen for manual city input (when user types and presses enter)
                cityInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        searchCity(cityInput.value);
                    }
                });

                // Listen for city input blur (when user clicks away)
                cityInput.addEventListener('blur', function() {
                    if (cityInput.value.trim() !== '') {
                        searchCity(cityInput.value);
                    }
                });
            }

            // Listen for radius input changes
            const radiusInput = document.getElementById("location_radius");
            if (radiusInput) {
                radiusInput.disabled = false; // Enable the radius input

                radiusInput.addEventListener('input', function() {
                    updateRadiusCircle();
                });

                radiusInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        updateRadiusCircle();
                    }
                });
            }
        }

        function searchCity(cityName) {
            if (!cityName.trim()) return;

            geocoder.geocode({ address: cityName }, function(results, status) {
                if (status === 'OK' && results[0]) {
                    const location = results[0].geometry.location;
                    const placeName = results[0].formatted_address.split(',')[0];
                    focusOnCity(location, placeName);
                } else {
                }
            });
        }

        function focusOnCity(location, cityName) {
            // Store coordinates in hidden fields for server-side filtering
            document.getElementById('location_lat').value = location.lat();
            document.getElementById('location_lng').value = location.lng();

            // Center map on the city
            map.setCenter(location);
            map.setZoom(12);

            // Remove existing marker if any
            if (currentMarker) {
                currentMarker.setMap(null);
            }

            // Add marker for the city
            currentMarker = new google.maps.Marker({
                position: location,
                map: map,
                title: cityName,
                icon: {
                    url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32">
                            <path fill="#EA4335" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                    `),
                    scaledSize: new google.maps.Size(32, 32),
                    anchor: new google.maps.Point(16, 32)
                }
            });

            // Update radius circle if radius is set
            updateRadiusCircle();
        }

        function updateRadiusCircle() {
            const radiusInput = document.getElementById("location_radius");
            const radiusValue = parseFloat(radiusInput.value);

            // Remove existing circle
            if (currentCircle) {
                currentCircle.setMap(null);
            }

            // Only draw circle if we have a valid radius and a center point
            if (radiusValue > 0 && currentMarker) {
                const center = currentMarker.getPosition();

                currentCircle = new google.maps.Circle({
                    strokeColor: "#FF0000",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#FF0000",
                    fillOpacity: 0.15,
                    map: map,
                    center: center,
                    radius: radiusValue * 1000, // Convert km to meters
                });

                // Adjust map zoom to fit the circle
                const bounds = currentCircle.getBounds();
                map.fitBounds(bounds);

                // Ensure minimum zoom level for better visibility
                google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
                    if (map.getZoom() > 15) {
                        map.setZoom(15);
                    }
                });
            }
        }

        function getInitialMapSettings() {
            const countrySelect = document.getElementById("location_country");
            const selectedCountry = countrySelect ? countrySelect.value : '';

            // Country coordinates and zoom levels - matching your SYSTEM_COUNTRIES exactly
            const countrySettings = {
                'All Europe': { center: { lat: 54.5260, lng: 15.2551 }, zoom: 4 },
                'Germany': { center: { lat: 51.1657, lng: 10.4515 }, zoom: 6 },
                'United Kingdom': { center: { lat: 55.3781, lng: -3.4360 }, zoom: 6 },
                'France': { center: { lat: 46.2276, lng: 2.2137 }, zoom: 6 },
                'Italy': { center: { lat: 41.8719, lng: 12.5674 }, zoom: 6 },
                'Spain': { center: { lat: 40.4637, lng: -3.7492 }, zoom: 6 },
                'Netherlands': { center: { lat: 52.1326, lng: 5.2913 }, zoom: 7 },
                'Belgium': { center: { lat: 50.5039, lng: 4.4699 }, zoom: 7 },
                'Austria': { center: { lat: 47.5162, lng: 14.5501 }, zoom: 7 },
                'Poland': { center: { lat: 51.9194, lng: 19.1451 }, zoom: 6 },
                'Denmark': { center: { lat: 56.2639, lng: 9.5018 }, zoom: 7 },
                'Sweden': { center: { lat: 60.1282, lng: 18.6435 }, zoom: 5 },
                'Finland': { center: { lat: 61.9241, lng: 25.7482 }, zoom: 5 },
                'Portugal': { center: { lat: 39.3999, lng: -8.2245 }, zoom: 6 },
                'Greece': { center: { lat: 39.0742, lng: 21.8243 }, zoom: 6 },
                'Czech Republic': { center: { lat: 49.8175, lng: 15.4730 }, zoom: 7 },
                'Hungary': { center: { lat: 47.1625, lng: 19.5033 }, zoom: 7 },
                'Romania': { center: { lat: 45.9432, lng: 24.9668 }, zoom: 6 },
                'Bulgaria': { center: { lat: 42.7339, lng: 25.4858 }, zoom: 7 },
                'Slovakia': { center: { lat: 48.6690, lng: 19.6990 }, zoom: 7 },
                'Luxembourg': { center: { lat: 49.8153, lng: 6.1096 }, zoom: 9 },
                'Slovenia': { center: { lat: 46.1512, lng: 14.9955 }, zoom: 8 },
                'Switzerland': { center: { lat: 46.8182, lng: 8.2275 }, zoom: 7 },
                'Norway': { center: { lat: 60.4720, lng: 8.4689 }, zoom: 5 },
                'Iceland': { center: { lat: 64.9631, lng: -19.0208 }, zoom: 6 },
                'Lithuania': { center: { lat: 55.1694, lng: 23.8813 }, zoom: 7 },
                'Latvia': { center: { lat: 56.8796, lng: 24.6032 }, zoom: 7 },
                'Estonia': { center: { lat: 58.5953, lng: 25.0136 }, zoom: 7 },
                'Croatia': { center: { lat: 45.1000, lng: 15.2000 }, zoom: 7 },
                'Serbia': { center: { lat: 44.0165, lng: 21.0059 }, zoom: 7 },
                'Bosnia and Herzegovina': { center: { lat: 43.9159, lng: 17.6791 }, zoom: 7 },
                'Ireland': { center: { lat: 53.1424, lng: -7.6921 }, zoom: 7 },
                'Albania': { center: { lat: 41.1533, lng: 20.1683 }, zoom: 7 },
                'North Macedonia': { center: { lat: 41.6086, lng: 21.7453 }, zoom: 8 },
                'Moldova': { center: { lat: 47.4116, lng: 28.3699 }, zoom: 7 },
                'Ukraine': { center: { lat: 48.3794, lng: 31.1656 }, zoom: 5 },
                'Belarus': { center: { lat: 53.7098, lng: 27.9534 }, zoom: 6 },
                'Russia': { center: { lat: 61.5240, lng: 105.3188 }, zoom: 3 },
                'Kosovo': { center: { lat: 42.6026, lng: 20.9030 }, zoom: 8 },
                'Monaco': { center: { lat: 43.7384, lng: 7.4246 }, zoom: 12 },
                'Cyprus': { center: { lat: 35.1264, lng: 33.4299 }, zoom: 8 },
                'Liechtenstein': { center: { lat: 47.1660, lng: 9.5554 }, zoom: 10 },
                'Malta': { center: { lat: 35.9375, lng: 14.3754 }, zoom: 10 },
                'Montenegro': { center: { lat: 42.7087, lng: 19.3744 }, zoom: 8 },
                'United States': { center: { lat: 39.8283, lng: -98.5795 }, zoom: 4 },
                'Japan': { center: { lat: 36.2048, lng: 138.2529 }, zoom: 6 },
                'South Korea': { center: { lat: 35.9078, lng: 127.7669 }, zoom: 7 },
                'China': { center: { lat: 35.8617, lng: 104.1954 }, zoom: 4 }
            };

            // Return settings for selected country or default to Europe
            return countrySettings[selectedCountry] || countrySettings['All Europe'];
        }

        function updateMapForCountry(countryName) {
            const settings = getInitialMapSettings();

            // Clear existing markers and circles when changing country
            if (currentMarker) {
                currentMarker.setMap(null);
                currentMarker = null;
            }
            if (currentCircle) {
                currentCircle.setMap(null);
                currentCircle = null;
            }

            // Clear city input when changing country
            const cityInput = document.getElementById("location_city");
            if (cityInput) {
                cityInput.value = '';
            }

            // Clear radius input
            const radiusInput = document.getElementById("location_radius");
            if (radiusInput) {
                radiusInput.value = '';
            }

            // Update map view
            map.setCenter(settings.center);
            map.setZoom(settings.zoom);
        }

        function billingMap() {
            // Keep your existing billingMap function if needed
            // or remove this if not used
        }

        // This is the callback function that Google Maps API calls
        function mapsShopping() {
            try {
                initAutocomplete();
            } catch (error) {
                console.error('Error initializing autocomplete:', error);
            }
            try {
                billingMap();
            } catch (error) {
                console.error('Error initializing billing map:', error);
            }
        }

        // Make sure the callback function is available globally
        window.mapsShopping = mapsShopping;

        // Optional: Add event listener for apply button
        document.addEventListener('DOMContentLoaded', function() {
            const applyButton = document.getElementById('apply_location_search');
            if (applyButton) {
                applyButton.addEventListener('click', function() {
                    const cityValue = document.getElementById('location_city').value;
                    const radiusValue = document.getElementById('location_radius').value;

                    console.log('Applied filters:', {
                        city: cityValue,
                        radius: radiusValue
                    });

                    // You can add your filter application logic here
                });
            }
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{\App\CPU\Helpers::get_business_settings('map_api_key')}}&callback=mapsShopping&libraries=places&v=3.49" defer></script>

@endpush

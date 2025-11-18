@extends('theme-views.layouts.app')

@section('title',' '.translate('Filter'))

@push('css_or_js')
    <meta property="og:image" content="{{cloudfront('company')}}/{{$web_config['web_logo']}}"/>
    <meta property="og:title" content="Products of {{$web_config['name']}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <meta property="twitter:card" content="{{cloudfront('company')}}/{{$web_config['web_logo']}}"/>
    <meta property="twitter:title" content="Products of {{$web_config['name']}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <style>
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
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 37px !important;
        }
        .select2.select2-container {
            display: block !important;
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

        #status-box .dropdown-menu {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            transform: none !important;
            inset: auto !important;
            position: absolute !important;
            left: 0 !important;
            right: 0 !important;
            margin-top: 0 !important;
            box-sizing: border-box;
            box-shadow: 0px 0px 2px black;
            border-radius: 0 0 5px 5px;
        }

        .modal-backdrop {
            display: none !important;
        }

        .modal-dialog {
            max-width: var(--bs-modal-width);
            margin-right: auto;
            margin-left: auto;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #location_map_canvas {
            position: relative;
        }

        #pac-input {
            position: absolute !important;
            top: 14px !important;
            left: 50% !important;
            transform: translateX(-50%);
            z-index: 5;
            width: 60%;
            height: 34px;
            max-width: 180px;
            border: 1px gray solid;
        }

        .banner-sidebar {
            position: sticky;
            top: 55px;
            align-self: flex-start;
        }

        .aside-margin-top {
            margin-top: 40px;
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

    <div class="d-flex p-4 gap-4" >
        <aside class="responsive-aside filter-toggle-aside flex-shrink-0 start-0 @if(auth('customer')->check() && (!auth('customer')->user()->phone_code || !auth('customer')->user()->phone || !auth('customer')->user()->country || !auth('customer')->user()->city)) aside-margin-top @endif">
            <div class="card-border aside-shadow rounded p-3 bg-white custom-scroll" >
                <div class="d-lg-none close-filter" >
                    <button class="filter-aside-close border-0 bg-primary text-white rounded-circle pt-1">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="card-body d-flex flex-column">
                    <form id="filter-form">
                        @csrf
                        <div>
                            <h4 class="mb-3" >
                                <span class="fw-lighter fs-15" >{{translate('results_for_this_filter')}}</span>
                                (<span class="fw-bold fs-15" id="ads-count-number">{{$initial_filter_count}}</span>)
                            </h4>
                        </div>
                        <button type="button" id="clear-filters" class="btn btn-outline-danger d-inline mb-3 px-1 py-1" >
                            <i class="bi bi-x-lg"></i>
                            <span class="mx-1" >{{translate('clear_filter')}}</span>
                        </button>

                        <div class="mb-2 d-flex gap-1 flex-wrap" id="active-filters">
                            @if(request('category_id') && request('category_id') != 0)
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item"
                                data-id="category" role="button">
                                    <span>{{translate('category')}}</span>
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

                            @if(request('country') && request('country') != 'All Europe')
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item location-filter-input"
                                data-id="location_country" role="button">
                                    <span>{{translate('country')}}</span>
                                    <span class="ms-1 fs-15">&times;</span>
                                </span>
                            @endif

                            @if(request('furniture_material') && request('furniture_material') != 'all')
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item location-filter-input"
                                data-id="location_country" role="button">
                                    <span>{{translate('furniture_material')}}</span>
                                    <span class="ms-1 fs-15">&times;</span>
                                </span>
                            @endif

                            @if(request('furniture_type') && request('furniture_type') != 'all')
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item location-filter-input"
                                data-id="location_country" role="button">
                                    <span>{{translate('furniture_type')}}</span>
                                    <span class="ms-1 fs-15">&times;</span>
                                </span>
                            @endif

                            @if(request('home_garden_material') && request('home_garden_material') != 'all')
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item location-filter-input"
                                data-id="location_country" role="button">
                                    <span>{{translate('home_garden_material')}}</span>
                                    <span class="ms-1 fs-15">&times;</span>
                                </span>
                            @endif

                            @if(request('shipbuilding_type') && request('shipbuilding_type') != 'all')
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item location-filter-input"
                                data-id="location_country" role="button">
                                    <span>{{translate('shipbuilding_type')}}</span>
                                    <span class="ms-1 fs-15">&times;</span>
                                </span>
                            @endif

                            @if(request('engines_number') && request('engines_number') != 'all')
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item location-filter-input"
                                data-id="location_country" role="button">
                                    <span>{{translate('engines_number')}}</span>
                                    <span class="ms-1 fs-15">&times;</span>
                                </span>
                            @endif

                            @if(request('cabins_number') && request('cabins_number') != 'all')
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item location-filter-input"
                                data-id="location_country" role="button">
                                    <span>{{translate('cabins_number')}}</span>
                                    <span class="ms-1 fs-15">&times;</span>
                                </span>
                            @endif

                            @if(request('usage') && request('usage') != 'all')
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item location-filter-input"
                                data-id="location_country" role="button">
                                    <span>{{translate('home_garden_usage')}}</span>
                                    <span class="ms-1 fs-15">&times;</span>
                                </span>
                            @endif

                            @if(request('machine_type') && request('machine_type') != 'all')
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item location-filter-input"
                                data-id="location_country" role="button">
                                    <span>{{translate('machine_type')}}</span>
                                    <span class="ms-1 fs-15">&times;</span>
                                </span>
                            @endif

                            @if(request('power_source') && request('power_source') != 'all')
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item location-filter-input"
                                data-id="location_country" role="button">
                                    <span>{{translate('power_source')}}</span>
                                    <span class="ms-1 fs-15">&times;</span>
                                </span>
                            @endif

                            @if(request('home_appliance_type') && request('home_appliance_type') != 'all')
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item location-filter-input"
                                data-id="location_country" role="button">
                                    <span>{{translate('home_appliance_type')}}</span>
                                    <span class="ms-1 fs-15">&times;</span>
                                </span>
                            @endif

                            @if(request('electronic_type') && request('electronic_type') != 'all')
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item location-filter-input"
                                data-id="location_country" role="button">
                                    <span>{{translate('electronic_type')}}</span>
                                    <span class="ms-1 fs-15">&times;</span>
                                </span>
                            @endif

                            @if(request('listing_type') && request('listing_type') != 'all')
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item location-filter-input"
                                data-id="location_country" role="button">
                                    <span>{{translate('listing_type')}}</span>
                                    <span class="ms-1 fs-15">&times;</span>
                                </span>
                            @endif

                            @if(request('property_type') && request('property_type') != 'all')
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item location-filter-input"
                                data-id="location_country" role="button">
                                    <span>{{translate('property_type')}}</span>
                                    <span class="ms-1 fs-15">&times;</span>
                                </span>
                            @endif

                            @if(request('floor') && request('floor') != 'all')
                                <span class="d-flex align-items-center gap-1 bg-primary text-light rounded
                                p-1 px-2 fs-13 fw-medium me-2 mb-2 active-filter-item location-filter-input"
                                data-id="location_country" role="button">
                                    <span>{{translate('floor')}}</span>
                                    <span class="ms-1 fs-15">&times;</span>
                                </span>
                            @endif
                        </div>

                        <div class="mb-3" >
                            <div class="form-group mb-2">
                                <label for="category">{{ translate('category') }}</label>
                                <select style="height: 38px;" data-filter-label="{{translate('category')}}" data-filter-id="category"
                                class="form-control custom-input-height filter-input fw-medium" name="category_id" id="category">
                                    <option data-category-type="vehicles"
                                    data-id="0"
                                    value="all">
                                        {{translate('all')}}
                                    </option>
                                    @foreach($categories as $category)
                                        <option
                                        {{ array_key_exists('category_id', $filter_data) && $filter_data['category_id'] == $category['id'] ? 'selected' : '' }}
                                        data-id="{{ $category['id'] }}"
                                        data-category-type="{{ $category->category_type }}"
                                        data-category-slug="{{ $category->slug }}"
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4" data-category-types="vehicles">
                                <label for="brand">{{ translate('brand') }}</label>
                                <select style="height: 38px;" class="form-control filter-input fw-medium"
                                data-filter-label="{{translate('brand')}}" data-filter-id="brand" name="brand_id" id="brand">
                                    <option value="all">{{translate('all')}}</option>
                                    @foreach($brands as $brand)
                                        <option data-brand-categories="{{ implode(', ', $brand['categories']) }}"
                                        {{ array_key_exists('brand_id', $filter_data) && $filter_data['brand_id'] == $brand['id'] ? 'selected' : '' }}
                                        value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3 pt-2" data-category-types="vehicles" data-is-not-bicycle="1">
                                <label for="model">{{ translate('model') }}</label>
                                <select style="height: 38px;" data-filter-label="{{translate('model')}}" data-filter-id="model" id="model"
                                class="form-control filter-input fw-medium"
                                {{ array_key_exists('model_id', $filter_data) && $filter_data['model_id'] == 'all' ? 'disabled' : '' }}
                                name="model_id" id="model">
                                    <option value="all">{{translate('all')}}</option>
                                    @foreach($models as $model)
                                        <option
                                        {{ array_key_exists('model_id', $filter_data) && $filter_data['model_id'] == $model['id'] ? 'selected' : '' }}
                                        data-brand-id="{{ $model['brand_id'] }}"
                                        data-category-id="{{ $model['category_id'] }}"
                                        data-model-categories="{{ implode(', ', $model['categories']) }}"
                                        value="{{ $model['id'] }}">{{ $model['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4 mt-2 pt-3" data-is-not-bicycle="1" data-category-types="vehicles, home appliances, home garden, furniture, electronics, shipbuilding marine">
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
                                    style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
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
                            <div class="form-group mb-4" data-category-types="vehicles" data-is-not-bicycle="1" data-vehicle-equipment="0">
                                <div class="dropdown w-100">
                                    <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                            style="height: 38px;"
                                            type="button"
                                            id="secondmultiSelectDropdown"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        {{translate('gear')}}
                                    </button>
                                    <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="secondmultiSelectDropdown"
                                    style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0"
                                                data-filter-label="{{translate('transmission_type')}}" data-filter-name="transmission_type[]" type="checkbox" name="transmission_type[]" value="automatic">
                                                <span>{{ translate('automatic') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0"
                                                data-filter-label="{{translate('transmission_type')}}" data-filter-name="transmission_type[]" type="checkbox" name="transmission_type[]" value="semi_automatic">
                                                <span>{{ translate('semi_automatic') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('transmission_type')}}" data-filter-name="transmission_type[]" name="transmission_type[]" value="manually">
                                                <span>{{ translate('manually') }}</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group mb-4" data-category-types="vehicles" data-is-not-bicycle="1" data-vehicle-equipment="0">
                                <div class="dropdown w-100">
                                    <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                            style="height: 38px;"
                                            type="button"
                                            id="thirdmultiSelectDropdown"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        {{translate('body_type')}}
                                    </button>
                                    <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown"
                                    style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('body_type')}}" data-filter-name="body_type[]" name="body_type[]" value="compact">
                                                <span>{{ translate('compact') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('body_type')}}" data-filter-name="body_type[]" name="body_type[]" value="suv_off_Road">
                                                <span>{{ translate('suv_off_Road') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('body_type')}}" data-filter-name="body_type[]" name="body_type[]" value="sedan">
                                                <span>{{ translate('sedan') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('body_type')}}" data-filter-name="body_type[]" name="body_type[]" value="convertible">
                                                <span>{{ translate('convertible') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('body_type')}}" data-filter-name="body_type[]" name="body_type[]" value="hatchback">
                                                <span>{{ translate('hatchback') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('body_type')}}" data-filter-name="body_type[]" name="body_type[]" value="coupe">
                                                <span>{{ translate('coupe') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('body_type')}}" data-filter-name="body_type[]" name="body_type[]" value="station_wagon">
                                                <span>{{ translate('station_wagon') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('body_type')}}" data-filter-name="body_type[]" name="body_type[]" value="van">
                                                <span>{{ translate('van') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('body_type')}}" data-filter-name="body_type[]" name="body_type[]" value="transporter">
                                                <span>{{ translate('transporter') }}</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group mb-3" data-category-types="vehicles, shipbuilding marine" data-is-not-bicycle="1" data-vehicle-equipment="0">
                                <div class="dropdown w-100">
                                    <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                            style="height: 38px;"
                                            type="button"
                                            id="forthmultiSelectDropdown"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        {{translate('fuel_type')}}
                                    </button>
                                    <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="forthmultiSelectDropdown"
                                    style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('fuel_type')}}" data-filter-name="fuel_type[]" name="fuel_type[]" value="petrol_gasoline">
                                                <span>{{ translate('petrol_gasoline') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('fuel_type')}}" data-filter-name="fuel_type[]" name="fuel_type[]" value="diesel">
                                                <span>{{ translate('diesel') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('fuel_type')}}" data-filter-name="fuel_type[]" name="fuel_type[]" value="electric_ev">
                                                <span>{{ translate('electric_ev') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('fuel_type')}}" data-filter-name="fuel_type[]" name="fuel_type[]" value="hybrid">
                                                <span>{{ translate('hybrid') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('fuel_type')}}" data-filter-name="fuel_type[]" name="fuel_type[]" value="Plug_in_hybrid_phev">
                                                <span>{{ translate('Plug_in_hybrid_phev') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('fuel_type')}}" data-filter-name="fuel_type[]" name="fuel_type[]" value="lpg">
                                                <span>{{ translate('lpg') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('fuel_type')}}" data-filter-name="fuel_type[]" name="fuel_type[]" value="cng">
                                                <span>{{ translate('cng') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('fuel_type')}}" data-filter-name="fuel_type[]" name="fuel_type[]" value="hydrogen_fcev">
                                                <span>{{ translate('hydrogen_fcev') }}</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('fuel_type')}}" data-filter-name="fuel_type[]" name="fuel_type[]" value="flex_fuel">
                                                <span>{{ translate('flex_fuel') }}</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group mb-3 pt-2" data-category-types="vehicles" data-is-not-bicycle="1" data-vehicle-equipment="0">
                                <div class="dropdown w-100">
                                    <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                            style="height: 38px;"
                                            type="button"
                                            id="fivethmultiSelectDropdown"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        {{translate('number_of_doors')}}
                                    </button>
                                    <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="fivethmultiSelectDropdown"
                                    style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('number_of_doors')}}" data-filter-name="doors_number[]" name="doors_number[]" value="2/3">
                                                <span>2/3</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('number_of_doors')}}" data-filter-name="doors_number[]" name="doors_number[]" value="4/5">
                                                <span>4/5</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('number_of_doors')}}" data-filter-name="doors_number[]" name="doors_number[]" value="6/7">
                                                <span>6/7</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group mb-3 pt-2" data-category-types="vehicles" data-is-not-bicycle="1" data-vehicle-equipment="0">
                                <div class="dropdown w-100">
                                    <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                            style="height: 38px;"
                                            type="button"
                                            id="sixthmultiSelectDropdown"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        {{translate('number_of_seats')}}
                                    </button>
                                    <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="sixthmultiSelectDropdown"
                                    style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('number_of_seats')}}" data-filter-name="seats_number[]" name="seats_number[]" value="1">
                                                <span>1</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('number_of_seats')}}" data-filter-name="seats_number[]" name="seats_number[]" value="2">
                                                <span>2</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('number_of_seats')}}" data-filter-name="seats_number[]" name="seats_number[]" value="3">
                                                <span>3</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('number_of_seats')}}" data-filter-name="seats_number[]" name="seats_number[]" value="4">
                                                <span>4</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('number_of_seats')}}" data-filter-name="seats_number[]" name="seats_number[]" value="5">
                                                <span>5</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('number_of_seats')}}" data-filter-name="seats_number[]" name="seats_number[]" value="6">
                                                <span>6</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('number_of_seats')}}" data-filter-name="seats_number[]" name="seats_number[]" value="7">
                                                <span>7</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('number_of_seats')}}" data-filter-name="seats_number[]" name="seats_number[]" value="8">
                                                <span>8</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('number_of_seats')}}" data-filter-name="seats_number[]" name="seats_number[]" value="9">
                                                <span>9</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('number_of_seats')}}" data-filter-name="seats_number[]" name="seats_number[]" value="10">
                                                <span>10</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('number_of_seats')}}" data-filter-name="seats_number[]" name="seats_number[]" value="11">
                                                <span>11</span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('number_of_seats')}}" data-filter-name="seats_number[]" name="seats_number[]" value="12">
                                                <span>12</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group mb-3 pt-2" data-category-types="vehicles, furniture" data-is-not-bicycle="1">
                                <div class="dropdown w-100">
                                    <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                        style="height: 38px;"
                                        type="button"
                                        id="sevenmultiSelectDropdown"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                            {{translate('color')}}
                                    </button>
                                    <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="sevenmultiSelectDropdown"
                                    style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 350px;overflow-x: auto;">
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="black">
                                                <span>{{translate('Black')}}</span>
                                                <span style="width: 25px;height: 15px;background: black;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-2 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="white">
                                                <span>{{translate('White')}}</span>
                                                <span style="width: 25px;height: 15px;background: white;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-2 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="silver">
                                                <span>{{translate('Silver')}}</span>
                                                <span style="width: 25px;height: 15px;background: silver;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-2 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="gray">
                                                <span>{{translate('gray')}}</span>
                                                <span style="width: 25px;height: 15px;background: gray;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="blue">
                                                <span>{{translate('Blue')}}</span>
                                                <span style="width: 25px;height: 15px;background: blue;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="red">
                                                <span>{{translate('Red')}}</span>
                                                <span style="width: 25px;height: 15px;background: red;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="brown">
                                                <span>{{translate('Brown')}}</span>
                                                <span style="width: 25px;height: 15px;background: brown;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="beige">
                                                <span>{{translate('Beige')}}</span>
                                                <span style="width: 25px;height: 15px;background: beige;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="green">
                                                <span>{{translate('green')}}</span>
                                                <span style="width: 25px;height: 15px;background: green;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="orange">
                                                <span>{{translate('Orange')}}</span>
                                                <span style="width: 25px;height: 15px;background: orange;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="yellow">
                                                <span>{{translate('Yellow')}}</span>
                                                <span style="width: 25px;height: 15px;background: yellow;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="gold">
                                                <span>{{translate('Gold')}}</span>
                                                <span style="width: 25px;height: 15px;background: gold;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="purple">
                                                <span>{{translate('Purple')}}</span>
                                                <span style="width: 25px;height: 15px;background: purple;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="pink">
                                                <span>{{translate('Pink')}}</span>
                                                <span style="width: 25px;height: 15px;background: pink;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="turquoise">
                                                <span>{{translate('Turquoise')}}</span>
                                                <span style="width: 25px;height: 15px;background: turquoise;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="darkred">
                                                <span>{{translate('dark_red')}}</span>
                                                <span style="width: 25px;height: 15px;background: darkred;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="navy">
                                                <span>{{translate('Navy Blue')}}</span>
                                                <span style="width: 25px;height: 15px;background: navy;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="peru">
                                                <span>{{translate('Peru')}}</span>
                                                <span style="width: 25px;height: 15px;background: peru;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="olive">
                                                <span>{{translate('Olive')}}</span>
                                                <span style="width: 25px;height: 15px;background: olive;" ></span>
                                            </label>
                                        </li>
                                        <li class="dropdown-item p-2 px-3">
                                            <label class="d-flex align-items-center gap-1 m-0">
                                                <input class="form-check-input filter-input m-0" type="checkbox"
                                                data-filter-label="{{translate('color')}}" data-filter-name="color[]" name="color[]" value="multicolor/custom">
                                                <span>{{translate('Multicolor / Custom')}}</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <a href="" data-bs-toggle="modal" data-bs-target="#locationSearchModal"
                            class="btn btn-primary btn-sm d-flex align-items-center justify-content-start gap-2">
                                <i class="bi bi-geo-alt"></i>
                                {{ translate('location_search') }}
                            </a>
                            @include('theme-views.layouts.partials.modal._location-search-modal')

                            <!-- Price range -->
                            <div class="mb-3 pt-3" data-category-types="all">
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
                                                <option {{ $max_price == '500' ? 'selected' : '' }} value="500">500</option>
                                                <option {{ $max_price == '1000' ? 'selected' : '' }} value="1000">1,000</option>
                                                <option {{ $max_price == '1500' ? 'selected' : '' }} value="1500">1,500</option>
                                                <option {{ $max_price == '2000' ? 'selected' : '' }} value="2000">2,000</option>
                                                <option {{ $max_price == '2500' ? 'selected' : '' }} value="2500">2,500</option>
                                                <option {{ $max_price == '3000' ? 'selected' : '' }} value="3000">3,000</option>
                                                <option {{ $max_price == '3500' ? 'selected' : '' }} value="3500">3,500</option>
                                                <option {{ $max_price == '4000' ? 'selected' : '' }} value="4000">4,000</option>
                                                <option {{ $max_price == '4500' ? 'selected' : '' }} value="4500">4,500</option>
                                                <option {{ $max_price == '5000' ? 'selected' : '' }} value="5000">5,000</option>
                                                <option {{ $max_price == '5500' ? 'selected' : '' }} value="5500">5,500</option>
                                                <option {{ $max_price == '6000' ? 'selected' : '' }} value="6000">6,000</option>
                                                <option {{ $max_price == '6500' ? 'selected' : '' }} value="6500">6,500</option>
                                                <option {{ $max_price == '7000' ? 'selected' : '' }} value="7000">7,000</option>
                                                <option {{ $max_price == '7500' ? 'selected' : '' }} value="7500">7,500</option>
                                                <option {{ $max_price == '8000' ? 'selected' : '' }} value="8000">8,000</option>
                                                <option {{ $max_price == '8500' ? 'selected' : '' }} value="8500">8,500</option>
                                                <option {{ $max_price == '9000' ? 'selected' : '' }} value="9000">9,000</option>
                                                <option {{ $max_price == '9500' ? 'selected' : '' }} value="9500">9,500</option>
                                                <option {{ $max_price == '10000' ? 'selected' : '' }} value="10000">10,000</option>
                                                <option {{ $max_price == '12000' ? 'selected' : '' }} value="12000">12,500</option>
                                                <option {{ $max_price == '15000' ? 'selected' : '' }} value="15000">15,000</option>
                                                <option {{ $max_price == '17500' ? 'selected' : '' }} value="17500">17,500</option>
                                                <option {{ $max_price == '20000' ? 'selected' : '' }} value="20000">20,000</option>
                                                <option {{ $max_price == '30000' ? 'selected' : '' }} value="30000">30,000</option>
                                                <option {{ $max_price == '40000' ? 'selected' : '' }} value="40000">40,000</option>
                                                <option {{ $max_price == '50000' ? 'selected' : '' }} value="50000">50,000</option>
                                                <option {{ $max_price == '60000' ? 'selected' : '' }} value="60000">60,000</option>
                                                <option {{ $max_price == '70000' ? 'selected' : '' }} value="70000">70,000</option>
                                                <option {{ $max_price == '80000' ? 'selected' : '' }} value="80000">80,000</option>
                                                <option {{ $max_price == '90000' ? 'selected' : '' }} value="90000">90,000</option>
                                                <option {{ $max_price == '100000' ? 'selected' : '' }} value="100000">100,000</option>
                                                <option {{ $max_price == '125000' ? 'selected' : '' }} value="125000">125,000</option>
                                                <option {{ $max_price == '150000' ? 'selected' : '' }} value="150000">150,000</option>
                                                <option {{ $max_price == '175000' ? 'selected' : '' }} value="175000">175,000</option>
                                                <option {{ $max_price == '200000' ? 'selected' : '' }} value="200000">200,000</option>
                                                <option {{ $max_price == '300000' ? 'selected' : '' }} value="300000">300,000</option>
                                                <option {{ $max_price == '400000' ? 'selected' : '' }} value="400000">400,000</option>
                                                <option {{ $max_price == '500000' ? 'selected' : '' }} value="500000">500,000</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- year range -->
                            <div class="mb-3" id="year-box" data-category-types="vehicles, shipbuilding marine, industrial machines">
                                <label class="mb-2" for="construction_year">{{translate('construction_year')}}</label>
                                <div class="row">
                                    <div class="col-6 pe-1" >
                                        <div class="form-group">
                                            <select style="height: 38px;" class="form-select filter-input fw-medium"
                                            data-filter-label="{{translate('min_construction_year')}}" data-filter-id="min_construction_year" name="min_construction_year" id="min_construction_year" >
                                                <option value="{{null}}">{{translate('from')}}</option>
                                                @for ($year = 2025; $year >= 1940; $year--)
                                                    <option {{ $min_construction_year == $year ? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
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
                            <div class="mb-3" id="mileage-box" data-category-types="vehicles" data-vehicle-equipment="0">
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
                        <div class="accordion" id="accordionExample">
                            <!-- First Accordion Item (Original) -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingForth">
                                <button class="accordion-button collapsed px-1 bg-light" style="border-bottom: none !important;padding: 12px;"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseForth" aria-expanded="true" aria-controls="collapseForth">
                                    <div class="" >
                                        <span class="text-dark mx-1 fs-14" >{{ translate('other_types_information') }}</span>
                                    </div>
                                </button>
                                </h2>
                                <div id="collapseForth" class="accordion-collapse collapse" aria-labelledby="headingForth" data-bs-parent="#accordionExample4">
                                    <div class="accordion-body py-2 px-1">

                                        <div class="form-group mb-3" data-category-types="vehicles" data-is-bicycle="1">
                                            <div class="dropdown w-100">
                                                <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                                        style="height: 38px;"
                                                        type="button"
                                                        id="thirdmultiSelectDropdown"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    {{translate('bicycle_type')}}
                                                </button>
                                                <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown"
                                                style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_type') }}" data-filter-name="bicycle_type[]"
                                                            name="multiple_bicycle_type[]" value="road">
                                                            <span>{{ translate('road') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_type') }}" data-filter-name="bicycle_type[]"
                                                            name="multiple_bicycle_type[]" value="mountain">
                                                            <span>{{ translate('mountain') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_type') }}" data-filter-name="bicycle_type[]"
                                                            name="multiple_bicycle_type[]" value="hybrid">
                                                            <span>{{ translate('hybrid') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_type') }}" data-filter-name="bicycle_type[]"
                                                            name="multiple_bicycle_type[]" value="cruiser">
                                                            <span>{{ translate('cruiser') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_type') }}" data-filter-name="bicycle_type[]"
                                                            name="multiple_bicycle_type[]" value="bmx">
                                                            <span>{{ translate('bmx') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_type') }}" data-filter-name="bicycle_type[]"
                                                            name="multiple_bicycle_type[]" value="folding">
                                                            <span>{{ translate('folding') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_type') }}" data-filter-name="bicycle_type[]"
                                                            name="multiple_bicycle_type[]" value="electric">
                                                            <span>{{ translate('electric') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_type') }}" data-filter-name="bicycle_type[]"
                                                            name="multiple_bicycle_type[]" value="tandem">
                                                            <span>{{ translate('tandem') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_type') }}" data-filter-name="bicycle_type[]"
                                                            name="multiple_bicycle_type[]" value="track">
                                                            <span>{{ translate('track') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_type') }}" data-filter-name="bicycle_type[]"
                                                            name="multiple_bicycle_type[]" value="fat_tire">
                                                            <span>{{ translate('fat_tire') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_type') }}" data-filter-name="bicycle_type[]"
                                                            name="multiple_bicycle_type[]" value="fixed_gear">
                                                            <span>{{ translate('fixed_gear') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_type') }}" data-filter-name="bicycle_type[]"
                                                            name="multiple_bicycle_type[]" value="gravel">
                                                            <span>{{ translate('gravel') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_type') }}" data-filter-name="bicycle_type[]"
                                                            name="multiple_bicycle_type[]" value="kids">
                                                            <span>{{ translate('kids') }}</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" data-category-types="vehicles" data-is-bicycle="1">
                                            <div class="dropdown w-100">
                                                <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                                        style="height: 38px;"
                                                        type="button"
                                                        id="thirdmultiSelectDropdown"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    {{translate('bicycle_size')}}
                                                </button>
                                                <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown"
                                                style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_size') }}" data-filter-name="bicycle_size[]"
                                                            name="multiple_bicycle_size[]" value="12">
                                                            <span>12</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_size') }}" data-filter-name="bicycle_size[]"
                                                            name="multiple_bicycle_size[]" value="14">
                                                            <span>14</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_size') }}" data-filter-name="bicycle_size[]"
                                                            name="multiple_bicycle_size[]" value="16">
                                                            <span>16</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_size') }}" data-filter-name="bicycle_size[]"
                                                            name="multiple_bicycle_size[]" value="18">
                                                            <span>18</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_size') }}" data-filter-name="bicycle_size[]"
                                                            name="multiple_bicycle_size[]" value="20">
                                                            <span>20</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_size') }}" data-filter-name="bicycle_size[]"
                                                            name="multiple_bicycle_size[]" value="24">
                                                            <span>24</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_size') }}" data-filter-name="bicycle_size[]"
                                                            name="multiple_bicycle_size[]" value="26">
                                                            <span>26</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_size') }}" data-filter-name="bicycle_size[]"
                                                            name="multiple_bicycle_size[]" value="27.5">
                                                            <span>27.5</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_size') }}" data-filter-name="bicycle_size[]"
                                                            name="multiple_bicycle_size[]" value="28">
                                                            <span>28</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_size') }}" data-filter-name="bicycle_size[]"
                                                            name="multiple_bicycle_size[]" value="29">
                                                            <span>29</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_size') }}" data-filter-name="bicycle_size[]"
                                                            name="multiple_bicycle_size[]" value="xs">
                                                            <span>xs</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_size') }}" data-filter-name="bicycle_size[]"
                                                            name="multiple_bicycle_size[]" value="s">
                                                            <span>s</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_size') }}" data-filter-name="bicycle_size[]"
                                                            name="multiple_bicycle_size[]" value="m">
                                                            <span>m</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_size') }}" data-filter-name="bicycle_size[]"
                                                            name="multiple_bicycle_size[]" value="l">
                                                            <span>l</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('bicycle_size') }}" data-filter-name="bicycle_size[]"
                                                            name="multiple_bicycle_size[]" value="xl">
                                                            <span>xl</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" data-category-types="furniture">
                                            <div class="dropdown w-100">
                                                <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                                        style="height: 38px;"
                                                        type="button"
                                                        id="thirdmultiSelectDropdown"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    {{translate('furniture_material')}}
                                                </button>
                                                <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown"
                                                style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_material')}}" data-filter-name="furniture_material[]" name="multiple_furniture_material[]" value="wood">
                                                            <span>{{ translate('wood') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_material')}}" data-filter-name="furniture_material[]" name="multiple_furniture_material[]" value="leather">
                                                            <span>{{ translate('leather') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_material')}}" data-filter-name="furniture_material[]" name="multiple_furniture_material[]" value="fabric">
                                                            <span>{{ translate('fabric') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_material')}}" data-filter-name="furniture_material[]" name="multiple_furniture_material[]" value="metal">
                                                            <span>{{ translate('metal') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_material')}}" data-filter-name="furniture_material[]" name="multiple_furniture_material[]" value="glass">
                                                            <span>{{ translate('glass') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_material')}}" data-filter-name="furniture_material[]" name="multiple_furniture_material[]" value="plastic">
                                                            <span>{{ translate('plastic') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_material')}}" data-filter-name="furniture_material[]" name="multiple_furniture_material[]" value="marble">
                                                            <span>{{ translate('marble') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_material')}}" data-filter-name="furniture_material[]" name="multiple_furniture_material[]" value="rattan">
                                                            <span>{{ translate('rattan') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_material')}}" data-filter-name="furniture_material[]" name="multiple_furniture_material[]" value="bamboo">
                                                            <span>{{ translate('bamboo') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_material')}}" data-filter-name="furniture_material[]" name="multiple_furniture_material[]" value="foam">
                                                            <span>{{ translate('foam') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_material')}}" data-filter-name="furniture_material[]" name="multiple_furniture_material[]" value="synthetic">
                                                            <span>{{ translate('synthetic') }}</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" data-category-types="furniture">
                                            <div class="dropdown w-100">
                                                <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                                        style="height: 38px;"
                                                        type="button"
                                                        id="thirdmultiSelectDropdown"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    {{translate('furniture_type')}}
                                                </button>
                                                <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown"
                                                style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="sofa">
                                                            <span>{{ translate('sofa') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="bed">
                                                            <span>{{ translate('bed') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="table">
                                                            <span>{{ translate('table') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="chair">
                                                            <span>{{ translate('chair') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="armchair">
                                                            <span>{{ translate('armchair') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="dining_table">
                                                            <span>{{ translate('dining_table') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="coffee_table">
                                                            <span>{{ translate('coffee_table') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="tv_stand">
                                                            <span>{{ translate('tv_stand') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="bookshelf">
                                                            <span>{{ translate('bookshelf') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="wardrobe">
                                                            <span>{{ translate('wardrobe') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="dresser">
                                                            <span>{{ translate('dresser') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="nightstand">
                                                            <span>{{ translate('nightstand') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="cabinet">
                                                            <span>{{ translate('cabinet') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="desk">
                                                            <span>{{ translate('desk') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="bench">
                                                            <span>{{ translate('bench') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="stool">
                                                            <span>{{ translate('stool') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="recliner">
                                                            <span>{{ translate('recliner') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="console_table">
                                                            <span>{{ translate('console_table') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="shoe_rack">
                                                            <span>{{ translate('shoe_rack') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="vanity">
                                                            <span>{{ translate('vanity') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="crib">
                                                            <span>{{ translate('crib') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="bunk_bed">
                                                            <span>{{ translate('bunk_bed') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="sideboard">
                                                            <span>{{ translate('sideboard') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="ottoman">
                                                            <span>{{ translate('ottoman') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="folding_bed">
                                                            <span>{{ translate('folding_bed') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('furniture_type')}}" data-filter-name="furniture_type[]" name="multiple_furniture_type[]" value="rocking_chair">
                                                            <span>{{ translate('rocking_chair') }}</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" data-category-types="home garden">
                                            <div class="dropdown w-100">
                                                <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                                        style="height: 38px;"
                                                        type="button"
                                                        id="thirdmultiSelectDropdown"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    {{translate('home_garden_material')}}
                                                </button>
                                                <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown"
                                                style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('home_garden_material')}}" data-filter-name="home_garden_material[]" name="multiple_home_garden_material[]" value="wood">
                                                            <span>{{ translate('wood') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('home_garden_material')}}" data-filter-name="home_garden_material[]" name="multiple_home_garden_material[]" value="leather">
                                                            <span>{{ translate('leather') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('home_garden_material')}}" data-filter-name="home_garden_material[]" name="multiple_home_garden_material[]" value="fabric">
                                                            <span>{{ translate('fabric') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('home_garden_material')}}" data-filter-name="home_garden_material[]" name="multiple_home_garden_material[]" value="metal">
                                                            <span>{{ translate('metal') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('home_garden_material')}}" data-filter-name="home_garden_material[]" name="multiple_home_garden_material[]" value="glass">
                                                            <span>{{ translate('glass') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('home_garden_material')}}" data-filter-name="home_garden_material[]" name="multiple_home_garden_material[]" value="plastic">
                                                            <span>{{ translate('plastic') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('home_garden_material')}}" data-filter-name="home_garden_material[]" name="multiple_home_garden_material[]" value="marble">
                                                            <span>{{ translate('marble') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('home_garden_material')}}" data-filter-name="home_garden_material[]" name="multiple_home_garden_material[]" value="rattan">
                                                            <span>{{ translate('rattan') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('home_garden_material')}}" data-filter-name="home_garden_material[]" name="multiple_home_garden_material[]" value="bamboo">
                                                            <span>{{ translate('bamboo') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('home_garden_material')}}" data-filter-name="home_garden_material[]" name="multiple_home_garden_material[]" value="foam">
                                                            <span>{{ translate('foam') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('home_garden_material')}}" data-filter-name="home_garden_material[]" name="multiple_home_garden_material[]" value="synthetic">
                                                            <span>{{ translate('synthetic') }}</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" data-category-types="shipbuilding marine">
                                            <div class="dropdown w-100">
                                                <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                                        style="height: 38px;"
                                                        type="button"
                                                        id="thirdmultiSelectDropdown"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    {{translate('shipbuilding_type')}}
                                                </button>
                                                <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown"
                                                style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="yacht">
                                                            <span>{{ translate('yacht') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="fishing_boat">
                                                            <span>{{ translate('fishing_boat') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="cargo_ship">
                                                            <span>{{ translate('cargo_ship') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="tanker">
                                                            <span>{{ translate('tanker') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="container_ship">
                                                            <span>{{ translate('container_ship') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="ferry">
                                                            <span>{{ translate('ferry') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="cruise_ship">
                                                            <span>{{ translate('cruise_ship') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="speedboat">
                                                            <span>{{ translate('speedboat') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="sailboat">
                                                            <span>{{ translate('sailboat') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="barge">
                                                            <span>{{ translate('barge') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="tugboat">
                                                            <span>{{ translate('tugboat') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="patrol_boat">
                                                            <span>{{ translate('patrol_boat') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="naval_ship">
                                                            <span>{{ translate('naval_ship') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="submarine">
                                                            <span>{{ translate('submarine') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="research_vessel">
                                                            <span>{{ translate('research_vessel') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="offshore_support_vessel">
                                                            <span>{{ translate('offshore_support_vessel') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="dredger">
                                                            <span>{{ translate('dredger') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="icebreaker">
                                                            <span>{{ translate('icebreaker') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="fireboat">
                                                            <span>{{ translate('fireboat') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('shipbuilding_type')}}" data-filter-name="shipbuilding_type[]"
                                                            name="multiple_shipbuilding_type[]" value="pilot_boat">
                                                            <span>{{ translate('pilot_boat') }}</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" data-category-types="shipbuilding marine">
                                            <div class="dropdown w-100">
                                                <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                                        style="height: 38px;"
                                                        type="button"
                                                        id="thirdmultiSelectDropdown"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    {{translate('number_of_engines')}}
                                                </button>
                                                <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown"
                                                style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="number_of_engines" data-filter-name="engines_number[]"
                                                            name="multiple_engines_number[]" value="1">
                                                            <span>1</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="number_of_engines" data-filter-name="engines_number[]"
                                                            name="multiple_engines_number[]" value="2">
                                                            <span>2</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="number_of_engines" data-filter-name="engines_number[]"
                                                            name="multiple_engines_number[]" value="3">
                                                            <span>3</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="number_of_engines" data-filter-name="engines_number[]"
                                                            name="multiple_engines_number[]" value="4">
                                                            <span>4</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="number_of_engines" data-filter-name="engines_number[]"
                                                            name="multiple_engines_number[]" value="5">
                                                            <span>5</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" data-category-types="shipbuilding marine">
                                            <div class="dropdown w-100">
                                                <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                                        style="height: 38px;"
                                                        type="button"
                                                        id="thirdmultiSelectDropdown"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    {{translate('number_of_cabines')}}
                                                </button>
                                                <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown"
                                                style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('number_of_cabines')}}" data-filter-name="cabins_number[]"
                                                            name="multiple_cabins_number[]" value="1">
                                                            <span>1</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('number_of_cabines')}}" data-filter-name="cabins_number[]"
                                                            name="multiple_cabins_number[]" value="2">
                                                            <span>2</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('number_of_cabines')}}" data-filter-name="cabins_number[]"
                                                            name="multiple_cabins_number[]" value="3">
                                                            <span>3</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('number_of_cabines')}}" data-filter-name="cabins_number[]"
                                                            name="multiple_cabins_number[]" value="4">
                                                            <span>4</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{translate('number_of_cabines')}}" data-filter-name="cabins_number[]"
                                                            name="multiple_cabins_number[]" value="5">
                                                            <span>5</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" data-category-types="home garden">
                                            <div class="dropdown w-100">
                                                <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                                        style="height: 38px;"
                                                        type="button"
                                                        id="thirdmultiSelectDropdown"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    {{translate('home_garden_usage')}}
                                                </button>
                                                <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown"
                                                style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('home_garden_usage') }}" data-filter-name="usage[]"
                                                            name="multiple_usage[]" value="indoor">
                                                            <span>{{ translate('indoor') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('home_garden_usage') }}" data-filter-name="usage[]"
                                                            name="multiple_usage[]" value="outdoor">
                                                            <span>{{ translate('outdoor') }}</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" data-category-types="industrial machines">
                                            <div class="dropdown w-100">
                                                <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                                        style="height: 38px;"
                                                        type="button"
                                                        id="thirdmultiSelectDropdown"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    {{translate('machine_type')}}
                                                </button>
                                                <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown"
                                                style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="cutting">
                                                            <span>{{ translate('cutting') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="forming">
                                                            <span>{{ translate('forming') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="welding">
                                                            <span>{{ translate('welding') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="molding">
                                                            <span>{{ translate('molding') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="machining">
                                                            <span>{{ translate('machining') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="packaging">
                                                            <span>{{ translate('packaging') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="printing">
                                                            <span>{{ translate('printing') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="assembling">
                                                            <span>{{ translate('assembling') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="mixing">
                                                            <span>{{ translate('mixing') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="pressing">
                                                            <span>{{ translate('pressing') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="extruding">
                                                            <span>{{ translate('extruding') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="rolling">
                                                            <span>{{ translate('rolling') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="grinding">
                                                            <span>{{ translate('grinding') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="polishing">
                                                            <span>{{ translate('polishing') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="bending">
                                                            <span>{{ translate('bending') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="lifting">
                                                            <span>{{ translate('lifting') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="conveying">
                                                            <span>{{ translate('conveying') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="cooling_heating">
                                                            <span>{{ translate('cooling_heating') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="inspection">
                                                            <span>{{ translate('inspection') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('machine_type') }}" data-filter-name="machine_type[]"
                                                            name="multiple_machine_type[]" value="cleaning">
                                                            <span>{{ translate('cleaning') }}</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" data-category-types="industrial machines">
                                            <div class="dropdown w-100">
                                                <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                                        style="height: 38px;"
                                                        type="button"
                                                        id="thirdmultiSelectDropdown"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    {{translate('power_source')}}
                                                </button>
                                                <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown"
                                                style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('power_source') }}" data-filter-name="power_source[]"
                                                            name="multiple_power_source[]" value="electric">
                                                            <span>{{ translate('electric') }}</span>
                                                        </label>
                                                    </li>

                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('power_source') }}" data-filter-name="power_source[]"
                                                            name="multiple_power_source[]" value="diesel">
                                                            <span>{{ translate('diesel') }}</span>
                                                        </label>
                                                    </li>

                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('power_source') }}" data-filter-name="power_source[]"
                                                            name="multiple_power_source[]" value="hydraulic">
                                                            <span>{{ translate('hydraulic') }}</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" data-category-types="electronics">
                                            <div class="dropdown w-100">
                                                <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                                        style="height: 38px;"
                                                        type="button"
                                                        id="thirdmultiSelectDropdown"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    {{translate('electronic_type')}}
                                                </button>
                                                <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown"
                                                style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="tv">
                                                            <span>{{ translate('tv') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="laptop">
                                                            <span>{{ translate('laptop') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="desktop_computer">
                                                            <span>{{ translate('desktop_computer') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="tablet">
                                                            <span>{{ translate('tablet') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="smartphone">
                                                            <span>{{ translate('smartphone') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="smartwatch">
                                                            <span>{{ translate('smartwatch') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="camera">
                                                            <span>{{ translate('camera') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="printer">
                                                            <span>{{ translate('printer') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="scanner">
                                                            <span>{{ translate('scanner') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="gaming_console">
                                                            <span>{{ translate('gaming_console') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="monitor">
                                                            <span>{{ translate('monitor') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="projector">
                                                            <span>{{ translate('projector') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="router">
                                                            <span>{{ translate('router') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="speaker">
                                                            <span>{{ translate('speaker') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="headphones">
                                                            <span>{{ translate('headphones') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="earbuds">
                                                            <span>{{ translate('earbuds') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="drone">
                                                            <span>{{ translate('drone') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="vr_headset">
                                                            <span>{{ translate('vr_headset') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('electronic_type') }}" data-filter-name="electronic_type[]"
                                                            name="multiple_electronic_type[]" value="gps">
                                                            <span>{{ translate('gps') }}</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" data-category-types="real estate">
                                            <div class="dropdown w-100">
                                                <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                                        style="height: 38px;"
                                                        type="button"
                                                        id="thirdmultiSelectDropdown"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    {{translate('listing_type')}}
                                                </button>
                                                <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown"
                                                style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('listing_type') }}" data-filter-name="listing_type[]"
                                                            name="multiple_listing_type[]" value="for_sale">
                                                            <span>{{ translate('for_sale') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('listing_type') }}" data-filter-name="listing_type[]"
                                                            name="multiple_listing_type[]" value="for_rent">
                                                            <span>{{ translate('for_rent') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('listing_type') }}" data-filter-name="listing_type[]"
                                                            name="multiple_listing_type[]" value="for_exchange">
                                                            <span>{{ translate('for_exchange') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('listing_type') }}" data-filter-name="listing_type[]"
                                                            name="multiple_listing_type[]" value="for_takeover">
                                                            <span>{{ translate('for_takeover') }}</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" data-category-types="real estate">
                                            <div class="dropdown w-100">
                                                <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select"
                                                        style="height: 38px;"
                                                        type="button"
                                                        id="thirdmultiSelectDropdown"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    {{translate('property_type')}}
                                                </button>
                                                <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown"
                                                style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 280px;overflow-y: auto;">
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('property_type') }}" data-filter-name="property_type[]"
                                                            name="multiple_property_type[]" value="apartment">
                                                            <span>{{ translate('apartment') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('property_type') }}" data-filter-name="property_type[]"
                                                            name="multiple_property_type[]" value="villa">
                                                            <span>{{ translate('villa') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('property_type') }}" data-filter-name="property_type[]"
                                                            name="multiple_property_type[]" value="house">
                                                            <span>{{ translate('house') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('property_type') }}" data-filter-name="property_type[]"
                                                            name="multiple_property_type[]" value="detached_house">
                                                            <span>{{ translate('detached_house') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('property_type') }}" data-filter-name="property_type[]"
                                                            name="multiple_property_type[]" value="land">
                                                            <span>{{ translate('land') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('property_type') }}" data-filter-name="property_type[]"
                                                            name="multiple_property_type[]" value="farm">
                                                            <span>{{ translate('farm') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('property_type') }}" data-filter-name="property_type[]"
                                                            name="multiple_property_type[]" value="shop">
                                                            <span>{{ translate('shop') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('property_type') }}" data-filter-name="property_type[]"
                                                            name="multiple_property_type[]" value="office">
                                                            <span>{{ translate('office') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('property_type') }}" data-filter-name="property_type[]"
                                                            name="multiple_property_type[]" value="warehouse">
                                                            <span>{{ translate('warehouse') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('property_type') }}" data-filter-name="property_type[]"
                                                            name="multiple_property_type[]" value="building">
                                                            <span>{{ translate('building') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('property_type') }}" data-filter-name="property_type[]"
                                                            name="multiple_property_type[]" value="room">
                                                            <span>{{ translate('room') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('property_type') }}" data-filter-name="property_type[]"
                                                            name="multiple_property_type[]" value="chalet_holiday_home">
                                                            <span>{{ translate('chalet_holiday_home') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('property_type') }}" data-filter-name="property_type[]"
                                                            name="multiple_property_type[]" value="commercial_property">
                                                            <span>{{ translate('commercial_property') }}</span>
                                                        </label>
                                                    </li>
                                                    <li class="dropdown-item p-2 px-3">
                                                        <label class="d-flex align-items-center gap-1 m-0">
                                                            <input class="form-check-input filter-input m-0" type="checkbox"
                                                            data-filter-label="{{ translate('property_type') }}" data-filter-name="property_type[]"
                                                            name="multiple_property_type[]" value="industrial_property">
                                                            <span>{{ translate('industrial_property') }}</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- First Accordion Item (Original) -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSecond">
                                <button class="accordion-button collapsed px-1 bg-light" style="border-bottom: none !important;padding: 12px;"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecond" aria-expanded="true" aria-controls="collapseSecond">
                                    <div class="" >
                                        <span class="text-dark mx-1 fs-14" >{{ translate('dimensions_information') }}</span>
                                    </div>
                                </button>
                                </h2>
                                <div id="collapseSecond" class="accordion-collapse collapse" aria-labelledby="headingSecond" data-bs-parent="#accordionExample">
                                    <div class="accordion-body py-2 px-1">
                                        <div class="form-group mb-2" data-category-types="vehicles, industrial machines, furniture, home garden, home appliances, electronics">
                                            <label for="city">{{translate('length')}}</label>
                                            <input type="number" style="height: 38px;" id="length" value="" name="length"
                                            data-filter-label="{{translate('length')}}" data-filter-id="length" class="form-control filter-input" placeholder="{{translate('Ex: 2.5')}}">
                                        </div>
                                        <div class="form-group mb-2" data-category-types="vehicles, industrial machines, furniture, home garden, home appliances, electronics">
                                            <label for="city">{{translate('height')}}</label>
                                            <input type="number" style="height: 38px;" id="height" value="" name="height"
                                            data-filter-label="{{translate('height')}}" data-filter-id="height" class="form-control filter-input" placeholder="{{translate('Ex: 3.6')}}">
                                        </div>
                                        <div class="form-group mb-2" data-category-types="vehicles, industrial machines, furniture, home garden, home appliances, electronics">
                                            <label for="city">{{translate('width')}}</label>
                                            <input type="number" style="height: 38px;" id="width" value="" name="width"
                                            data-filter-label="{{translate('width')}}" data-filter-id="width" class="form-control filter-input" placeholder="{{translate('Ex: 1.85')}}">
                                        </div>
                                        <div class="form-group mb-2" data-category-types="vehicles, industrial machines, furniture, home garden, home appliances, electronics">
                                            <label for="city">{{translate('max_weight')}}</label>
                                            <input type="number" style="height: 38px;" id="max_weight" value="" name="max_weight"
                                            data-filter-label="{{translate('max_weight')}}" data-filter-id="max_weight" class="form-control filter-input" placeholder="{{translate('Ex: 850')}}">
                                        </div>
                                        <div class="form-group mb-2" data-category-types="vehicles">
                                            <label for="city">{{translate('bag_capacity')}}</label>
                                            <input type="number" style="height: 38px;" id="bag_capacity" value=""
                                            data-filter-label="{{translate('bag_capacity')}}" data-filter-id="bag_capacity" name="bag_capacity" class="form-control filter-input" placeholder="{{translate('Ex: 280')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- First Accordion Item (Original) -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThird">
                                <button class="accordion-button collapsed px-1 bg-light" style="border-bottom: none !important;padding: 12px;"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseThird" aria-expanded="true" aria-controls="collapseThird">
                                    <div class="" >
                                        <span class="text-dark mx-1 fs-14" >{{ translate('additional_information') }}</span>
                                    </div>
                                </button>
                                </h2>
                                <div id="collapseThird" class="accordion-collapse collapse" aria-labelledby="headingThird" data-bs-parent="#accordionExample">
                                    <div class="accordion-body py-2 px-1">
                                        <div class="form-group mb-2" data-category-types="vehicles">
                                            <label for="city">{{translate('battery_charging_time')}}</label>
                                            <input type="text" style="height: 38px;" id="battery_charging_time"
                                            data-filter-label="{{translate('battery_charging_time')}}" data-filter-id="battery_charging_time" value=""
                                            name="battery_charging_time" class="form-control filter-input" placeholder="{{translate('Ex: 90')}}">
                                        </div>
                                        <div class="form-group mb-2" data-category-types="vehicles">
                                            <label for="city">{{translate('fast_battery_charging_time')}}</label>
                                            <input type="text" style="height: 38px;" id="fast_battery_charging_time" value=""
                                            data-filter-label="{{translate('fast_battery_charging_time')}}" data-filter-id="fast_battery_charging_time" name="fast_battery_charging_time" class="form-control filter-input" placeholder="{{translate('Ex: 30')}}">
                                        </div>
                                        <div class="form-group mb-2" data-category-types="vehicles">
                                            <label for="city">{{translate('battery_life')}}</label>
                                            <input type="text" style="height: 38px;" id="battery_life" value="" name="battery_life"
                                            data-filter-label="{{translate('battery_life')}}" data-filter-id="battery_life" class="form-control filter-input" placeholder="{{translate('Ex: 5')}}">
                                        </div>
                                        <div class="form-group mb-2" data-category-types="vehicles">
                                            <label for="city">{{translate('acceleration_0_100')}}</label>
                                            <input type="text" style="height: 38px;" id="acceleration_0_100" value=""
                                            data-filter-label="{{translate('acceleration_0_100')}}" data-filter-id="acceleration_0_100" name="acceleration_0_100" class="form-control filter-input" placeholder="{{translate('Ex: 4')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @if($paid_banners->count() > 0)
                    <div class="mt-4 banner-sidebar d-lg-none">
                        <h4 class="mb-4">{{ translate('advertising_space') }}</h4>

                        @foreach($paid_banners as $banner)
                            <div class="mb-4">
                                <a href="{{ $banner->banner_url ?? '#' }}">
                                    <img style="height: 140px !important;"
                                        class="rounded"
                                        width="100%"
                                        src="{{ cloudfront('paid-banners/'.$banner->banner_image) }}"
                                        alt="paid_banner_image">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            @if($paid_banners->count() > 0)
                <div class="mt-4 banner-sidebar">
                    <h4 class="mb-4">{{ translate('advertising_space') }}</h4>

                    @foreach($paid_banners as $banner)
                        <div class="mb-4">
                            <a href="{{ $banner->banner_url ?? '#' }}">
                                <img style="height: 140px !important;"
                                    class="rounded"
                                    width="100%"
                                    src="{{ cloudfront('paid-banners/'.$banner->banner_image) }}"
                                    alt="paid_banner_image">
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

        </aside>
        <main class="main-content flex-grow-1">
            <!-- Product -->
            <section>
                <div class="container m-0 px-0">
                    <div class="lg-down-1 gap-4">
                        <div class="position-relative h-100" >
                            @include('theme-views.partials._ajax-products-view',['ads'=>$ads])
                            <div id="fullscreen-loader" class="d-none"
                            style="position: fixed;top: 50%;left: 50%;transform: translate(-50%, -50%);z-index: 9999999;z-index: 9999999;">
                                <div class="spinner-border text-primary" role="status" style="width: 7rem; height: 7rem;">
                                    <span class="visually-hidden">{{translate('Loading')}}...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

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
        // ================== Global Variables ==================
        let offset = 5;
        let loading = false;
        let is_available_items = true;
        let shownAdIds = [];
        let initial_ads_number;
        let debounceTimer;

        // ================== Initial Setup ==================
        $('#ajax-products-view input[data-shown-ads]').each(function() {
            let adId = $(this).data('shown-ads');
            if (adId && !shownAdIds.includes(adId)) {
                shownAdIds.push(adId);
                initial_ads_number = shownAdIds.length;
            }
        });

        console.log(shownAdIds);

        let no_additional_to_show = `
            <div class="text-center" >
                <h5 class="pb-4" >{{translate('there_is_no_additional_ads_to_show')}}</h5>
            </div>
        `;

        // ================== Scroll Event ==================
        $(window).on('scroll', function () {
            if (loading) return;

            if(initial_ads_number && initial_ads_number < 4) {
                initial_ads_number = null;
                is_available_items = false;
            }

            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 500) {
                console.log('im here');
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
                                            console.log(related_ads_response.related_ads_count);
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

            if ($('#location_country').val() !== 'All Europe') {
                if ($container.find(`.active-filter-item[data-id="location_country"]`).length === 0) {
                    const filterHtml = `
                        <span class="d-flex align-items-center gap-1 bg-primary text-light rounded p-1 px-2 fs-13 fw-medium mb-2 active-filter-item" data-id="location_country" role="button">
                            <span>Country</span>
                            <span class="ms-1 fs-15">&times;</span>
                        </span>
                `;
                    $container.append(filterHtml);
                }
            }

            if ($('#location_city').val()){
                if ($container.find(`.active-filter-item[data-id="location_city"]`).length === 0) {
                    const filterHtml = `
                        <span class="d-flex align-items-center gap-1 bg-primary text-light rounded p-1 px-2 fs-13 fw-medium mb-2 active-filter-item" data-id="location_city" role="button">
                            <span>City</span>
                            <span class="ms-1 fs-15">&times;</span>
                        </span>
                `;
                    $container.append(filterHtml);
                }
            }

            if ($('#location_radius').val()){
                if ($container.find(`.active-filter-item[data-id="location_radius"]`).length === 0) {
                    const filterHtml = `
                        <span class="d-flex align-items-center gap-1 bg-primary text-light rounded p-1 px-2 fs-13 fw-medium  mb-2 active-filter-item" data-id="location_radius" role="button">
                            <span>Radius</span>
                            <span class="ms-1 fs-15">&times;</span>
                        </span>
                `;
                    $container.append(filterHtml);
                }
            }
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

                    if($elmByDataId.hasClass('location-filter-input')) { filterAds(); }
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

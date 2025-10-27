@extends('theme-views.layouts.app')

@section('title', translate('add_new_ad').' | '.$web_config['name']->value.' '.translate('ecommerce'))

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
        .card-custom-shadow {
            box-shadow: 1px 1px 4px #00000024, -1px 1px 4px #00000024;
        }
    </style>

@endpush


@section('content')
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Sidebar-->
                <div class="col-lg-10">
                    <div class="card h-lg-100 card-custom-shadow">
                        <div class="card-body p-4 pb-0">
                            <h1 class="pb-3 fs-30" >{{translate('post_an_add')}}</h1>
                            <div class="d-flex align-items-center gap-2">
                                @if($data && $data['category_name'])
                                    <h5>{{translate('selected_category')}} : </h5>
                                    <h6 class="mt-1 fs-14">
                                        <span class="bg-primary py-2 px-2 rounded text-light">
                                            <i class="bi bi-tags-fill"></i>
                                            <span id="dynamic-cat-name" >{{$data['category_name']}}</span>
                                        </span>
                                    </h6>
                                @endif
                            </div>

                            <div class="mt-4">
                                <form  action="{{route('ads-store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">
                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('identification_informations') }}</h2>
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <div class="form-group">
                                                    <label for="title">{{translate('title')}}</label>
                                                    <input type="text" id="title" class="form-control" value="{{ $data['title'] ?? old('title') }}" name="title" placeholder="{{translate('ad_title')}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" id="description" rows="5" class="form-control">{{ old('description') }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('technical_informations') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="category">{{translate('category')}}</label>
                                                        <select class="form-control" name="category_id" id="category">
                                                            <option value=""> -- {{ translate('choose_category') }} --</option>
                                                            @foreach($categories as $category)
                                                                <option data-is-vehicle="{{$category->is_vehicle}}" {{ $category['id'] == $data['category_id'] ? 'selected' : ''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="status">{{translate('status')}}</label>
                                                        <select class="form-control" name="status" id="status">
                                                            <option value="never_used">never used</option>
                                                            <option {{ old('status') == 'new' ? 'selected' : ''}} value="new">new</option>
                                                            <option {{ old('status') == 'used' ? 'selected' : ''}} value="used">used</option>
                                                            <option {{ old('status') == 'old' ? 'selected' : ''}} value="old">old</option>
                                                            <option {{ old('status') == 'very_old' ? 'selected' : ''}} value="very_old">very old</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="brand">{{ translate('brand') }}</label>
                                                        <select class="form-control" name="brand_id" id="brand">
                                                            <option value=""> -- {{ translate('choose_brand') }} -- </option>
                                                            @foreach($brands as $brand)
                                                                <option {{ $brand['id'] == ($data['brand_id'] ?? '') || $brand['id'] == old('brand_id') ? 'selected' : ''}} 
                                                                value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                            @endforeach
                                                            <option value="other" >{{ translate('other_brand') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="model">{{ translate('model') }}</label>
                                                        <select class="form-control" name="model_id" id="model">
                                                            <option value=""> -- {{ translate('choose_model') }} -- </option>
                                                            @foreach($models as $model)
                                                                <option 
                                                                data-brand-id="{{ $model->brand_id }}"
                                                                data-category-id="{{ $model->category_id }}"
                                                                {{ $model['id'] == ($data['model_id'] ?? '') || $model['id'] == old('model_id') ? 'selected' : ''}}
                                                                value="{{ $model->id }}">{{ $model->name }}</option>
                                                            @endforeach
                                                            <option value="other" >{{ translate('other_model') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                    <div class="col-sm-12 mb-3">
                                                        <div class="form-group">
                                                            <label for="color">{{translate('color')}}</label>
                                                            <select class="form-control" name="color" id="color">
                                                                <option value=""> -- {{ translate('choose_color') }} -- </option>
                                                                @foreach (\App\Model\Color::orderBy('name', 'asc')->get() as $key => $color)
                                                                    <option {{ $color['name'] == old('color') ? 'selected' : ''}} value="{{$color->name}}">
                                                                        {{$color->name}}
                                                                        <span style="width: 10px;height: 10px;background: {{$color->name}};" ></span>
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div id="year-box" class="col-sm-12 mb-3 @if($data && $data['is_vehicle'] == 0) d-none @endif">
                                                        <div class="form-group">
                                                            <label for="year">{{translate('year')}}</label>
                                                            <input type="number" min="1950" max="2025"  id="year" class="form-control" value="{{old('year')}}" 
                                                            name="year" placeholder="{{translate('year')}}">
                                                        </div>
                                                    </div>

                                                    <div id="engine-type-box" class="col-sm-12 mb-3 @if($data && $data['is_vehicle'] == 0) d-none @endif">
                                                        <div class="form-group">
                                                            <label for="fuel_type">{{translate('fuel_type')}}</label>
                                                            <select class="form-control" name="fuel_type" id="fuel_type">
                                                                <option value=""> -- {{translate('choose_engine_type')}} -- </option>
                                                                <option {{ old('fuel_type') == 'Petrol (Gasoline)' ? 'selected' : ''}} value="Petrol (Gasoline)">Petrol (Gasoline)</option>
                                                                <option {{ old('fuel_type') == 'Diesel' ? 'selected' : ''}} value="Diesel">Diesel</option>
                                                                <option {{ old('fuel_type') == 'Electric (EV)' ? 'selected' : ''}} value="Electric (EV)">Electric (EV)</option>
                                                                <option {{ old('fuel_type') == 'gas' ? 'selected' : ''}} value="Hybrid">Hybrid</option>
                                                                <option {{ old('fuel_type') == 'Plug-in Hybrid (PHEV)' ? 'selected' : ''}} value="Plug-in Hybrid (PHEV)">Plug-in Hybrid (PHEV)</option>
                                                                <option {{ old('fuel_type') == 'LPG' ? 'selected' : ''}} value="LPG">LPG</option>
                                                                <option {{ old('fuel_type') == 'CNG' ? 'selected' : ''}} value="CNG">CNG</option>
                                                                <option {{ old('fuel_type') == 'Hydrogen (FCEV)' ? 'selected' : ''}} value="Hydrogen (FCEV)">Hydrogen (FCEV)</option>
                                                                <option {{ old('fuel_type') == 'Flex-Fuel' ? 'selected' : ''}} value="Flex-Fuel">Flex-Fuel</option>
                                                                <option {{ old('fuel_type') == 'Other' ? 'selected' : ''}} value="other">Other</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="engine-size-box" class="col-sm-12 mb-3 @if($data && $data['is_vehicle'] == 0) d-none @endif">
                                                        <div class="form-group">
                                                            <label for="engine-size">{{translate('engine_size')}}</label>
                                                            <select class="form-control" name="engine_size" id="engine-size">
                                                                <option value=""> -- {{ translate('choose_engine_size') }} -- </option>
                                                                <option {{ old('engine_size') == '0.2' ? 'selected' : '' }} value="0.2">0.2L</option>
                                                                <option {{ old('engine_size') == '0.3' ? 'selected' : '' }} value="0.3">0.3L</option>
                                                                <option {{ old('engine_size') == '0.4' ? 'selected' : '' }} value="0.4">0.4L</option>
                                                                <option {{ old('engine_size') == '0.5' ? 'selected' : '' }} value="0.5">0.5L</option>
                                                                <option {{ old('engine_size') == '0.6' ? 'selected' : '' }} value="0.6">0.6L</option>
                                                                <option {{ old('engine_size') == '0.7' ? 'selected' : '' }} value="0.7">0.7L</option>
                                                                <option {{ old('engine_size') == '0.8' ? 'selected' : '' }} value="0.8">0.8L</option>
                                                                <option {{ old('engine_size') == '0.9' ? 'selected' : '' }} value="0.9">0.9L</option>
                                                                <option {{ old('engine_size') == '1.0' ? 'selected' : '' }} value="1.0">1.0L</option>
                                                                <option {{ old('engine_size') == '1.1' ? 'selected' : '' }} value="1.1">1.1L</option>
                                                                <option {{ old('engine_size') == '1.2' ? 'selected' : '' }} value="1.2">1.2L</option>
                                                                <option {{ old('engine_size') == '1.3' ? 'selected' : '' }} value="1.3">1.3L</option>
                                                                <option {{ old('engine_size') == '1.4' ? 'selected' : '' }} value="1.4">1.4L</option>
                                                                <option {{ old('engine_size') == '1.5' ? 'selected' : '' }} value="1.5">1.5L</option>
                                                                <option {{ old('engine_size') == '1.6' ? 'selected' : '' }} value="1.6">1.6L</option>
                                                                <option {{ old('engine_size') == '1.7' ? 'selected' : '' }} value="1.7">1.7L</option>
                                                                <option {{ old('engine_size') == '1.8' ? 'selected' : '' }} value="1.8">1.8L</option>
                                                                <option {{ old('engine_size') == '1.9' ? 'selected' : '' }} value="1.9">1.9L</option>
                                                                <option {{ old('engine_size') == '2.0' ? 'selected' : '' }} value="2.0">2.0L</option>
                                                                <option {{ old('engine_size') == '2.1' ? 'selected' : '' }} value="2.1">2.1L</option>
                                                                <option {{ old('engine_size') == '2.2' ? 'selected' : '' }} value="2.2">2.2L</option>
                                                                <option {{ old('engine_size') == '2.3' ? 'selected' : '' }} value="2.3">2.3L</option>
                                                                <option {{ old('engine_size') == '2.4' ? 'selected' : '' }} value="2.4">2.4L</option>
                                                                <option {{ old('engine_size') == '2.5' ? 'selected' : '' }} value="2.5">2.5L</option>
                                                                <option {{ old('engine_size') == '2.6' ? 'selected' : '' }} value="2.6">2.6L</option>
                                                                <option {{ old('engine_size') == '2.7' ? 'selected' : '' }} value="2.7">2.7L</option>
                                                                <option {{ old('engine_size') == '2.8' ? 'selected' : '' }} value="2.8">2.8L</option>
                                                                <option {{ old('engine_size') == '2.9' ? 'selected' : '' }} value="2.9">2.9L</option>
                                                                <option {{ old('engine_size') == '3.0' ? 'selected' : '' }} value="3.0">3.0L</option>
                                                                <option {{ old('engine_size') == '3.1' ? 'selected' : '' }} value="3.1">3.1L</option>
                                                                <option {{ old('engine_size') == '3.2' ? 'selected' : '' }} value="3.2">3.2L</option>
                                                                <option {{ old('engine_size') == '3.3' ? 'selected' : '' }} value="3.3">3.3L</option>
                                                                <option {{ old('engine_size') == '3.4' ? 'selected' : '' }} value="3.4">3.4L</option>
                                                                <option {{ old('engine_size') == '3.5' ? 'selected' : '' }} value="3.5">3.5L</option>
                                                                <option {{ old('engine_size') == '3.6' ? 'selected' : '' }} value="3.6">3.6L</option>
                                                                <option {{ old('engine_size') == '3.7' ? 'selected' : '' }} value="3.7">3.7L</option>
                                                                <option {{ old('engine_size') == '3.8' ? 'selected' : '' }} value="3.8">3.8L</option>
                                                                <option {{ old('engine_size') == '3.9' ? 'selected' : '' }} value="3.9">3.9L</option>
                                                                <option {{ old('engine_size') == '4.0' ? 'selected' : '' }} value="4.0">4.0L</option>
                                                                <option {{ old('engine_size') == '4.1' ? 'selected' : '' }} value="4.1">4.1L</option>
                                                                <option {{ old('engine_size') == '4.2' ? 'selected' : '' }} value="4.2">4.2L</option>
                                                                <option {{ old('engine_size') == '4.3' ? 'selected' : '' }} value="4.3">4.3L</option>
                                                                <option {{ old('engine_size') == '4.4' ? 'selected' : '' }} value="4.4">4.4L</option>
                                                                <option {{ old('engine_size') == '4.5' ? 'selected' : '' }} value="4.5">4.5L</option>
                                                                <option {{ old('engine_size') == '4.6' ? 'selected' : '' }} value="4.6">4.6L</option>
                                                                <option {{ old('engine_size') == '4.7' ? 'selected' : '' }} value="4.7">4.7L</option>
                                                                <option {{ old('engine_size') == '4.8' ? 'selected' : '' }} value="4.8">4.8L</option>
                                                                <option {{ old('engine_size') == '4.9' ? 'selected' : '' }} value="4.9">4.9L</option>
                                                                <option {{ old('engine_size') == '5.0' ? 'selected' : '' }} value="5.0">5.0L</option>
                                                                <option {{ old('engine_size') == '5.1' ? 'selected' : '' }} value="5.1">5.1L</option>
                                                                <option {{ old('engine_size') == '5.2' ? 'selected' : '' }} value="5.2">5.2L</option>
                                                                <option {{ old('engine_size') == '5.3' ? 'selected' : '' }} value="5.3">5.3L</option>
                                                                <option {{ old('engine_size') == '5.4' ? 'selected' : '' }} value="5.4">5.4L</option>
                                                                <option {{ old('engine_size') == '5.5' ? 'selected' : '' }} value="5.5">5.5L</option>
                                                                <option {{ old('engine_size') == '5.6' ? 'selected' : '' }} value="5.6">5.6L</option>
                                                                <option {{ old('engine_size') == '5.7' ? 'selected' : '' }} value="5.7">5.7L</option>
                                                                <option {{ old('engine_size') == '5.8' ? 'selected' : '' }} value="5.8">5.8L</option>
                                                                <option {{ old('engine_size') == '5.9' ? 'selected' : '' }} value="5.9">5.9L</option>
                                                                <option {{ old('engine_size') == '6.0' ? 'selected' : '' }} value="6.0">6.0L</option>
                                                                <option {{ old('engine_size') == '6.1' ? 'selected' : '' }} value="6.1">6.1L</option>
                                                                <option {{ old('engine_size') == '6.2' ? 'selected' : '' }} value="6.2">6.2L</option>
                                                                <option {{ old('engine_size') == '6.3' ? 'selected' : '' }} value="6.3">6.3L</option>
                                                                <option {{ old('engine_size') == '6.4' ? 'selected' : '' }} value="6.4">6.4L</option>
                                                                <option {{ old('engine_size') == '6.5' ? 'selected' : '' }} value="6.5">6.5L</option>
                                                                <option {{ old('engine_size') == '6.6' ? 'selected' : '' }} value="6.6">6.6L</option>
                                                                <option {{ old('engine_size') == '6.7' ? 'selected' : '' }} value="6.7">6.7L</option>
                                                                <option {{ old('engine_size') == '6.8' ? 'selected' : '' }} value="6.8">6.8L</option>
                                                                <option {{ old('engine_size') == '6.9' ? 'selected' : '' }} value="6.9">6.9L</option>
                                                                <option {{ old('engine_size') == '7.0' ? 'selected' : '' }} value="7.0">7.0L</option>
                                                                <option {{ old('engine_size') == '7.1' ? 'selected' : '' }} value="7.1">7.1L</option>
                                                                <option {{ old('engine_size') == '7.2' ? 'selected' : '' }} value="7.2">7.2L</option>
                                                                <option {{ old('engine_size') == '7.3' ? 'selected' : '' }} value="7.3">7.3L</option>
                                                                <option {{ old('engine_size') == '7.4' ? 'selected' : '' }} value="7.4">7.4L</option>
                                                                <option {{ old('engine_size') == '7.5' ? 'selected' : '' }} value="7.5">7.5L</option>
                                                                <option {{ old('engine_size') == '7.6' ? 'selected' : '' }} value="7.6">7.6L</option>
                                                                <option {{ old('engine_size') == '7.7' ? 'selected' : '' }} value="7.7">7.7L</option>
                                                                <option {{ old('engine_size') == '7.8' ? 'selected' : '' }} value="7.8">7.8L</option>
                                                                <option {{ old('engine_size') == '7.9' ? 'selected' : '' }} value="7.9">7.9L</option>
                                                                <option {{ old('engine_size') == '8.0' ? 'selected' : '' }} value="8.0">8.0L</option>
                                                                <option {{ old('engine_size') == '8.1' ? 'selected' : '' }} value="8.1">8.1L</option>
                                                                <option {{ old('engine_size') == '8.2' ? 'selected' : '' }} value="8.2">8.2L</option>
                                                                <option {{ old('engine_size') == '8.3' ? 'selected' : '' }} value="8.3">8.3L</option>
                                                                <option {{ old('engine_size') == '8.4' ? 'selected' : '' }} value="8.4">8.4L</option>
                                                                <option {{ old('engine_size') == 'other' ? 'selected' : '' }} value="other">{{translate('other')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="cylinders-box" class="col-sm-12 mb-3 @if($data && $data['is_vehicle'] == 0) d-none @endif">
                                                        <div class="form-group">
                                                            <label for="engine-cylinders">{{translate('cylinders')}}</label>
                                                            <select class="form-control" name="engine_cylinders" id="engine-cylinders">
                                                                <option value=""> -- {{translate('choose_cylinder_number')}} -- </option>
                                                                <option {{ old('engine_cylinders') == '1' ? 'selected' : ''}} value="1">1 Cylinder</option>
                                                                <option {{ old('engine_cylinders') == '2' ? 'selected' : ''}} value="2">2 Cylinders</option>
                                                                <option {{ old('engine_cylinders') == '3' ? 'selected' : ''}} value="3">3 Cylinders</option>
                                                                <option {{ old('engine_cylinders') == '4' ? 'selected' : ''}} value="4">4 Cylinders</option>
                                                                <option {{ old('engine_cylinders') == '6' ? 'selected' : ''}} value="6">6 Cylinders</option>
                                                                <option {{ old('engine_cylinders') == '8' ? 'selected' : ''}} value="8">8 Cylinders</option>
                                                                <option {{ old('engine_cylinders') == '10' ? 'selected' : ''}} value="10">10 Cylinders</option>
                                                                <option {{ old('engine_cylinders') == '12' ? 'selected' : ''}} value="12">12 Cylinders</option>
                                                                <option {{ old('engine_cylinders') == '16' ? 'selected' : ''}} value="16">16 Cylinders</option>
                                                                <option {{ old('engine_cylinders') == '18' ? 'selected' : ''}} value="18">18 Cylinders</option>
                                                                <option {{ old('engine_cylinders') == 'other' ? 'selected' : '' }} value="other">{{translate('other')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>                                                    
                                                    <div  id="power-box" class="col-sm-12 mb-3 @if($data && $data['is_vehicle'] == 0) d-none @endif">
                                                        <div class="form-group">
                                                            <label for="engine-power">{{translate('power')}}</label>
                                                            <input type="text" id="engine-power" class="form-control" value="{{old('engine_power')}}" name="engine_power" placeholder="{{translate('Ex:300hp (224kW)')}}">
                                                        </div>
                                                    </div>
                                                    
                                                    <div  id="mileage-box" class="col-sm-12 mb-3 @if($data && $data['is_vehicle'] == 0) d-none @endif">
                                                        <div class="form-group">
                                                            <label for="mileage">{{translate('mileage')}}</label>
                                                            <input type="number" id="mileage" class="form-control" value="{{old('mileage')}}" name="mileage" placeholder="{{translate('mileage')}}">
                                                        </div>
                                                    </div>
                                                    <div id="transmission-type-box" class="col-sm-12 mb-3 @if($data && $data['is_vehicle'] == 0) d-none @endif">
                                                        <div class="form-group">
                                                            <label for="transmission_type">{{translate('transmission_type')}}</label>
                                                            <select class="form-control" name="transmission_type" id="transmission_type">
                                                                <option {{ old('transmission_type') == 'automatic' ? 'selected' : ''}} value="automatic">automatic</option>
                                                                <option {{ old('transmission_type') == 'manually' ? 'selected' : ''}} value="manually">manually</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>

                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('media_information') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-3">
                                                        <label>{{translate('ad_thumbnail')}}</label>
                                                        <div class="d-flex flex-column gap-3">
                                                            <div class="upload-file" style="width: min-content;">
                                                                <input type="file" class="upload-file__input"  name="image" multiple aria-required="true" accept="image/*">
                                                                <div class="upload-file__img">
                                                                    <div class="temp-img-box">
                                                                        <div class="d-flex align-items-center flex-column gap-2">
                                                                            <i class="bi bi-upload fs-30"></i>
                                                                            <div class="fs-12 text-muted">{{translate('ad_image')}}</div>
                                                                        </div>
                                                                    </div>
                                                                    <img src="#" class="dark-support img-fit-contain border" alt="" hidden="">
                                                                </div>
                                                            </div>

                                                            <div class="text-muted">{{translate('Image_ratio_should_be')}} 1:1</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ translate('ad_images') }}</label>
                                                        <div class="d-flex gap-3" id="additional_Image_Section">
                                                            <div class="upload-file" style="width: min-content;">
                                                                <input 
                                                                    type="file" 
                                                                    class="upload-file__input"  
                                                                    onchange="addMoreImage(this, '#additional_Image_Section')"
                                                                    name="images[]" 
                                                                    aria-required="true" 
                                                                    accept="image/*">

                                                                <div class="upload-file__img">
                                                                    <div class="temp-img-box">
                                                                        <div class="d-flex align-items-center flex-column gap-2">
                                                                            <i class="bi bi-upload fs-30"></i>
                                                                            <div class="fs-12 text-muted">{{ translate('ad_images') }}</div>
                                                                        </div>
                                                                    </div>
                                                                    <img src="#" class="dark-support img-fit-contain border" alt="" hidden="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-muted">{{ translate('Image_ratio_should_be') }} 1:1</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('price_details') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group mb-2">
                                                        <label for="currency">{{translate('currency')}}</label>
                                                        <select class="form-control" name="currency" id="currency">
                                                            <option> -- {{ translate('choose_a_currency') }} -- </option>
                                                            <option {{ old('currency') == 'USD' ? 'selected' : ''}} value="USD">USD</option>
                                                            <option {{ old('currency') == 'EUR' ? 'selected' : ''}} value="EUR">EUR</option>
                                                            <option {{ old('currency') == 'GBP' ? 'selected' : ''}} value="GBP">GBP</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group mb-2">
                                                        <label for="">{{translate('price_type')}}</label>
                                                        <select class="form-control" name="price_type" id="price_type">
                                                            <option value=""> -- {{ translate('choose_a_price_type') }} -- </option>
                                                            <option {{ old('price_type') == 'fixed_price' ? 'selected' : ''}} value="fixed_price">{{ translate('fixed_price') }}</option>
                                                            <option {{ old('price_type') == 'asking_price' ? 'selected' : ''}} value="asking_price">{{ translate('asking_price') }}</option>
                                                            <option {{ old('price_type') == 'auction' ? 'selected' : ''}} value="auction">{{ translate('auction') }}</option>
                                                            <option {{ old('price_type') == 'free' ? 'selected' : ''}} value="free">{{ translate('free') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="starting-price-box" class="col-sm-12 d-none">
                                                    <div class="form-group mb-2">
                                                        <input type="number" id="starting-price" class="form-control" 
                                                        value="{{old('starting_price')}}" name="starting_price" 
                                                        placeholder="{{translate('starting_price')}}">
                                                    </div>
                                                </div>
                                                <div id="price-box" class="col-sm-12 d-none">
                                                    <div class="form-group">
                                                        <input type="number" id="price" class="form-control" value="{{old('price')}}" name="price" placeholder="{{translate('price')}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="offers-box" class="col-sm-12 d-none mt-2">
                                                <div class="form-group form-check form-switch d-flex gap-5 p-0 align-items-center">
                                                    <label class="m-0" for="show-phone-number">{{translate('allow_offers')}} ?</label>
                                                    <input class="form-check-input" checked
                                                    name="allow_offers" type="checkbox" role="switch" id="allow-offers">
                                                </div>
                                                <div class="form-group" id="first-price">
                                                    <input type="number" id="first-price-input" class="form-control" value="{{old('first_price')}}" 
                                                    name="first_price" placeholder="{{translate('first_price')}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('dimensions_and_sizes') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div id="body-type-box" class="col-sm-12 mb-3 @if($data && $data['is_vehicle'] == 0) d-none @endif">
                                                    <div class="form-group">
                                                        <label for="body_type">{{translate('body_type')}} ({{ translate('Optional') }})</label>
                                                        <select class="form-control" name="body_type" id="body_type">
                                                            <option value=""> -- {{translate('choose_body_type')}} -- </option>
                                                            <option {{ old('body_type') == 'Compact' ? 'selected' : ''}} value="suv">Compact</option>
                                                            <option {{ old('body_type') == 'SUV/Off-Road' ? 'selected' : ''}} value="suv">SUV/Off-Road</option>
                                                            <option {{ old('body_type') == 'Sedan' ? 'selected' : ''}} value="sedan">Sedan</option>
                                                            <option {{ old('body_type') == 'Convertible' ? 'selected' : ''}} value="Convertible">Convertible</option>
                                                            <option {{ old('body_type') == 'Coupe' ? 'selected' : ''}} value="Coupe">Coupe</option>
                                                            <option {{ old('body_type') == 'Hatchback' ? 'selected' : ''}} value="Hatchback">Hatchback</option>
                                                            <option {{ old('body_type') == 'Station Wagon' ? 'selected' : ''}} value="Station Wagon">Station Wagon</option>
                                                            <option {{ old('body_type') == 'Van' ? 'selected' : ''}} value="Van">Van</option>
                                                            <option {{ old('body_type') == 'Transporter' ? 'selected' : ''}} value="Transporter">Transporter</option>
                                                            <option {{ old('body_type') == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="length">{{translate('length')}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="length" class="form-control" value="{{old('length')}}" name="length" placeholder="{{translate('length')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="height">{{translate('height')}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="height" class="form-control" value="{{old('height')}}" name="height" placeholder="{{translate('height')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="width">{{translate('width')}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="width" class="form-control" value="{{old('width')}}" name="width" placeholder="{{translate('width')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="max_weight">{{translate("max_weight")}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="max_weight" class="form-control" value="{{old('max_weight')}}" name="max_weight" placeholder="{{translate('max_weight')}}">
                                                    </div>
                                                </div>

                                                <div id="bag-capacity-box" class="col-sm-12 mb-3 @if($data && $data['is_vehicle'] == 0) d-none @endif">
                                                    <div class="form-group">
                                                        <label for="bag_capacity">{{translate("bag_capacity")}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="bag_capacity" class="form-control" value="{{old('bag_capacity')}}" name="bag_capacity" placeholder="{{translate('bag_capacity')}}">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('contact_informations') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="name">{{translate('name_on_ad')}}</label>
                                                        <input disabled type="text" id="name" class="form-control" 
                                                        value="{{ auth('customer')->user()->f_name.' '.auth('customer')->user()->l_name }}" name="name" placeholder="{{translate('name')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group form-check form-switch d-flex gap-5 p-0 align-items-center">
                                                        <label class="m-0" for="show-email-address">{{translate('show_email_address_on_ad')}} ?</label>
                                                        <input class="form-check-input" checked
                                                        name="show_email_address" type="checkbox" role="switch" id="show-email-address">
                                                    </div>
                                                </div>
                                                <div id="email-address" class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <input disabled type="text" id="email_address" class="form-control" 
                                                        value="{{ auth('customer')->user()->email }}" name="email_address" placeholder="{{translate('email_address')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group form-check form-switch d-flex gap-5 p-0 align-items-center">
                                                        <label class="m-0" for="show-phone-number">{{translate('show_phone_number_on_ad')}} ?</label>
                                                        <input class="form-check-input" checked
                                                        name="show_phone_number" type="checkbox" role="switch" id="show-phone-number">
                                                    </div>
                                                </div>
                                                <div id="phone-number" class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <div class="d-flex align-items-center gap-2 mb-2" >
                                                            <input class="form-check-input m-0" name="whatsapp_availability" 
                                                            {{ old('whatsapp_availability') == 'on' ? 'checked' : '' }} type="checkbox" id="whatsapp_availability">
                                                            <label class="m-0 fs-13" for="whatsapp_availability">{{translate('whatsApp_available')}} ?</label>
                                                        </div>
                                                        <input type="text" id="phone_number" class="form-control" value="{{old('phone_number')}}" 
                                                        name="phone_number" placeholder="{{translate('phone_number')}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group mb-3">
                                                        <label for="delivery_service_name" class="fw-medium">{{ translate('country') }}</label>
                                                        <select class="form-control custom-input-height emoji-font" name="country" >
                                                            <option value="">{{ translate('choose_the_country') }}</option>
                                                            @foreach (array_slice(SYSTEM_COUNTRIES, 1) as $country)
                                                                <option {{ old('country') == $country['name'] ? 'selected' : '' }} class="emoji-font" value="{{$country['name']}}">{{$country['emoji']}} {{ $country['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="city">{{translate("city")}}</label>
                                                        <input type="text" id="city" class="form-control" 
                                                        value="{{old('city')}}" name="city" 
                                                        placeholder="{{translate('city')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="postal_code">{{translate("postal_code")}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="postal_code" class="form-control" 
                                                        value="{{old('postal_code')}}" name="postal_code" 
                                                        placeholder="{{translate('postal_code')}}">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div id="environmental-information-box" class="mb-1 border @if($data && $data['is_vehicle'] == 0) d-none @endif px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('environmental_information') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="co2_emissions">{{translate('co2_emissions')}} ({{ translate('gram_on_ kilometre') }}) ({{ translate('Optional') }})</label>
                                                        <input type="text" id="co2_emissions" class="form-control" value="{{old('co2_emissions')}}" name="co2_emissions" placeholder="{{translate('co2_emissions')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="energy_consumption">{{translate('energy_consumption')}} ({{ translate('litre_on_ kilometre') }}) ({{ translate('Optional') }})</label>
                                                        <input type="text" id="energy_consumption" class="form-control" value="{{old('energy_consumption')}}" name="energy_consumption" placeholder="{{translate('energy_consumption')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="gas_emission_tax">{{translate('gas_emission_tax')}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="gas_emission_tax" class="form-control" value="{{old('gas_emission_tax')}}" name="gas_emission_tax" placeholder="{{translate('gas_emission_tax')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="ad-options-box" class="mb-1 border px-3 py-3 @if($data && $data['is_vehicle'] == 0) d-none @endif rounded custom-gray-border-color" >
                                            <div class="mb-3" >
                                                <h2>{{ translate('ad_options') }}</h2>
                                            </div>

                                            @php
                                                $options = [
                                                    '360_camera',
                                                    '4x4',
                                                    'modified_for_disabled',
                                                    'abs',
                                                    'rear_view_camera',
                                                    'adaptive_lights',
                                                    'adaptive_cruise_control',
                                                    'airbags',
                                                    'air_conditioning',
                                                    'alarm',
                                                    'android_auto',
                                                    'apple_carplay',
                                                    'autonomous_driving',
                                                    'bluetooth',
                                                    'cornering_lights',
                                                    'onboard_computer',
                                                    'central_locking',
                                                    'climate_control',
                                                    'cruise_control',
                                                    'roof_rails',
                                                    'blind_spot_monitor',
                                                    'electric_tailgate',
                                                    'electric_mirrors',
                                                    'electric_seat_adjustment',
                                                    'electronic_stability_program',
                                                    'electric_windows',
                                                    'emergency_brake_assist',
                                                    'head_up_display',
                                                    'isofix',
                                                    'keyless_entry',
                                                    'lane_departure_warning',
                                                    'lane_keeping_assist',
                                                    'led_lights',
                                                    'leather_seats',
                                                    'alloy_wheels',
                                                    'light_sensor',
                                                    'metallic_paint',
                                                    'fog_lights',
                                                    'navigation_system',
                                                    'sunroof',
                                                    'panoramic_roof',
                                                    'parking_assist',
                                                    'parking_camera',
                                                    'parking_sensors',
                                                    'radio',
                                                    'rain_sensor',
                                                    'sliding_door',
                                                    'sport_package',
                                                    'sport_seats',
                                                    'voice_control',
                                                    'immobilizer',
                                                    'start_stop_system',
                                                    'seat_massage',
                                                    'seat_ventilation',
                                                    'heated_seats',
                                                    'steering_wheel_heating',
                                                    'traction_control',
                                                    'tow_bar',
                                                    'usb_ports',
                                                    'traffic_sign_recognition',
                                                    'fatigue_detection',
                                                    'heated_mirrors',
                                                    'front_view_camera',
                                                    'xenon_lights',
                                                    'cd_player',
                                                    'daytime_running_lights',
                                                    'gps',
                                                    'multifunction_steering_wheel',
                                                    'power_steering',
                                                    'rear_ac_vents',
                                                    'remote_start',
                                                    'touchscreen_display',
                                                    'tpms',
                                                    'wireless_charging',
                                                ];

                                                $old_options = old('options');

                                            @endphp

                                            <div class="row">
                                                @foreach($options as $option)
                                                    <div class="col-sm-3 mb-3">
                                                        <div class="form-group d-flex gap-1 align-items-center">
                                                            <input type="hidden" name="options[{{ $option }}]" value="false">
                                                            <input 
                                                            type="checkbox" 
                                                            id="{{ $option }}" 
                                                            {{ filter_var($old_options[$option] ?? false, FILTER_VALIDATE_BOOLEAN) ? 'checked' : '' }}
                                                            name="options[{{ $option }}]" value="true">
                                                            <label class="m-0" value="false" for="{{$option}}">{{translate($option)}}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>


                                        <div id="additional-information-box" class="mb-1 border px-3 py-3 rounded @if($data && $data['is_vehicle'] == 0) d-none @endif custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('additional_information') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="previous_scan_date">{{translate('previous_scan_date')}} ({{ translate('Optional') }})</label>
                                                        <input type="date" id="previous_scan_date" class="form-control" value="{{old('previous_scan_date')}}" name="previous_scan_date" placeholder="{{translate('previous_scan_date')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="battery_charging_time">{{translate("battery_charging_time")}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="battery_charging_time" class="form-control" value="{{old('battery_charging_time')}}" name="battery_charging_time" placeholder="{{translate('battery_charging_time')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="fast_battery_charging_time">{{translate("fast_battery_charging_time")}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="fast_battery_charging_time" class="form-control" value="{{old('fast_battery_charging_time')}}" name="fast_battery_charging_time" placeholder="{{translate('battery_charging_time')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="battery_life">{{translate("battery_life")}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="battery_life" class="form-control" value="{{old('battery_life')}}" name="battery_life" placeholder="{{translate('battery_life')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="Acceleration_0_100">{{translate("Acceleration_0_100")}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="Acceleration_0_100" class="form-control" value="{{old('acceleration_0_100')}}" name="acceleration_0_100" placeholder="{{translate('Acceleration_0_100')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex justify-content-end gap-3">
                                                <button type="submit" class="btn btn-primary">{{translate('Add')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End Main Content -->
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the checkbox and phone number elements
        const showEmailCheckbox = document.getElementById('show-email-address');
        const showPhoneCheckbox = document.getElementById('show-phone-number');

        const allowOffers = document.getElementById('allow-offers');
        const firstPrice = document.getElementById('first-price');
        
        const categorySelect = document.getElementById('category');
        const categoryName = document.getElementById('dynamic-cat-name');

        const emailAddressDiv = document.getElementById('email-address');
        const phoneNumberDiv = document.getElementById('phone-number');
        
        // Add event listener to the checkbox
        showPhoneCheckbox.addEventListener('change', function() {
            if (this.checked) {
                // If checkbox is checked, remove d-none class
                phoneNumberDiv.classList.remove('d-none');
            } else {
                // If checkbox is unchecked, add d-none class
                phoneNumberDiv.classList.add('d-none');
            }
        });

        // Add event listener to the checkbox
        showEmailCheckbox.addEventListener('change', function() {
            if (this.checked) {
                // If checkbox is checked, remove d-none class
                emailAddressDiv.classList.remove('d-none');
            } else {
                // If checkbox is unchecked, add d-none class
                emailAddressDiv.classList.add('d-none');
            }
        });

        // Add event listener to the checkbox
        allowOffers.addEventListener('change', function() {
            
            document.getElementById('first-price-input').value = '';
            
            if (this.checked) {
                // If checkbox is checked, remove d-none class
                firstPrice.classList.remove('d-none');
            } else {

                // If checkbox is unchecked, add d-none class
                firstPrice.classList.add('d-none');
            }
        });
        
        // Add event listener to the checkbox
        categorySelect.addEventListener('change', function() {
            categoryName.innerHTML = this.options[this.selectedIndex].text;
        });

    });
</script>

<script>

function addMoreImage(input, targetSection) {
    const files = input.files;
    if (!files || files.length === 0) return;

    let images_box = document.getElementById('additional_Image_Section');

    if(images_box.children.length <= 10) {
        const reader = new FileReader();
        const previewImg = input.closest('.upload-file').querySelector('img');
        const tempBox = input.closest('.upload-file').querySelector('.temp-img-box');
    
        reader.onload = function (e) {
            previewImg.src = e.target.result;
            previewImg.hidden = false;
            if (tempBox) tempBox.style.display = 'none';
        };
    
        console.log(images_box.children.length);
    
        reader.readAsDataURL(files[0]);
    
        // Check if this is the last .upload-file inside the target section
        const $fileInputs = document.querySelectorAll(`${targetSection} input[type='file']`);
        const isLastInput = input === $fileInputs[$fileInputs.length - 1];
    
        if (isLastInput) {
            const newInputIndex = $fileInputs.length;
    
            const newInputHTML = `
                <div class="upload-file">
                    <input 
                        type="file" 
                        class="upload-file__input"  
                        onchange="addMoreImage(this, '${targetSection}')"
                        name="images[]" 
                        multiple 
                        aria-required="true" 
                        accept="image/*">
    
                    <div class="upload-file__img">
                        <div class="temp-img-box">
                            <div class="d-flex align-items-center flex-column gap-2">
                                <i class="bi bi-upload fs-30"></i>
                                <div class="fs-12 text-muted">{{translate('ad_images')}}</div>
                            </div>
                        </div>
                        <img src="#" class="dark-support img-fit-contain border" alt="" hidden="">
                    </div>
                </div>
            `;
    
            // Append the new input to the target section
            const container = document.querySelector(targetSection);
            container.insertAdjacentHTML('beforeend', newInputHTML);
        }
    } else {

        toastr.error("{{translate('maximum_10_images_allowed')}}", Error, {
            CloseButton: true,
            ProgressBar: true
        });

    }

}
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const purchaseTypeSelect = document.getElementById('price_type');
        const priceBox = document.getElementById('price-box');
        const startingPriceBox = document.getElementById('starting-price-box');
        const offersBox = document.getElementById('offers-box');
        
        function togglePriceFields() {
            const selectedValue = purchaseTypeSelect.value;

            document.getElementById('price').value = '';
            document.getElementById('starting-price').value = '';
            document.getElementById('first-price-input').value = '';

            offersBox.classList.add('d-none');

            if (selectedValue === 'fixed_price' || selectedValue === 'asking_price') {
                priceBox.classList.remove('d-none');
                startingPriceBox.classList.add('d-none');

                if (selectedValue === 'asking_price') {
                    offersBox.classList.remove('d-none');
                } 
            } else if (selectedValue === 'auction') {
                startingPriceBox.classList.remove('d-none');
                priceBox.classList.add('d-none');
            } else {
                // Hide both if nothing is selected or placeholder is selected
                priceBox.classList.add('d-none');
                startingPriceBox.classList.add('d-none');
            }
        }

        purchaseTypeSelect.addEventListener('change', togglePriceFields);

    });
</script>



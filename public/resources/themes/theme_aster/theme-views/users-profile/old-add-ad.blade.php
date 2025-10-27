@extends('theme-views.layouts.app')

@section('title', translate('add_new_vehicle').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@section('content')
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-4">
        <div class="container">
            <div class="row g-3">
                <!-- Sidebar-->
                @include('theme-views.partials._profile-aside')
                <div class="col-lg-9">
                    <div class="card h-lg-100">
                        <div class="card-body p-lg-4">
                            <div class="">
                                <h1>{{translate('post_an_add')}}</h1>
                            </div>

                            <div class="mt-4">
                                <form  action="{{route('ads-store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">
                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('identification_informations') }}</h2>
                                            </div>
                                            <div class="col-sm-12 mb-2">
                                                <div class="form-group">
                                                    <label for="name">{{translate('name')}}</label>
                                                    <input type="text" id="name" class="form-control" value="{{ old('name') }}" name="name" placeholder="{{translate('car_name')}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 mb-2">
                                                <div class="form-group">
                                                    <label for="slug">{{translate('slug')}}</label>
                                                    <input type="text" id="slug" class="form-control" value="{{ old('slug') }}" name="slug" placeholder="{{translate('car_slug')}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 mb-2">
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
                                                <div class="col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="category">{{translate('category')}}</label>
                                                        <select class="form-control" name="category_id" id="category">
                                                            <option value=""> -- {{ translate('choose_category') }} --</option>
                                                            @foreach($categories as $category)
                                                                <option {{ $category['id'] == old('category_id') ? 'selected' : ''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="brand">{{ translate('brand') }}</label>
                                                        <select class="form-control" name="brand_id" id="brand">
                                                            <option value=""> -- {{ translate('choose_brand') }} -- </option>
                                                            @foreach($brands as $brand)
                                                                <option {{ $brand['id'] == old('brand_id') ? 'selected' : ''}} value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="model">{{ translate('model') }}</label>
                                                        <select class="form-control" name="model_id" id="model">
                                                            <option value=""> -- {{ translate('choose_model') }} -- </option>
                                                            @foreach($models as $model)
                                                                <option 
                                                                data-brand-id="{{ $model->brand_id }}"
                                                                data-category-id="{{ $model->category_id }}"
                                                                {{ $model['id'] == old('model_id') ? 'selected' : ''}}
                                                                value="{{ $model->id }}">{{ $model->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-2">
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
                                                
                                                <div class="col-sm-4 mb-2">
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
                                                            <option value=""> -- {{translate('choose_fuel_type')}} -- </option>
                                                            <option {{ old('fuel_type') == 'Petrol (Gasoline)' ? 'selected' : ''}} value="Petrol (Gasoline)">Petrol (Gasoline)</option>
                                                            <option {{ old('fuel_type') == 'Diesel' ? 'selected' : ''}} value="Diesel">Diesel</option>
                                                            <option {{ old('fuel_type') == 'Electric (EV)' ? 'selected' : ''}} value="Electric (EV)">Electric (EV)</option>
                                                            <option {{ old('fuel_type') == 'gas' ? 'selected' : ''}} value="Hybrid">Hybrid</option>
                                                            <option {{ old('fuel_type') == 'Plug-in Hybrid (PHEV)' ? 'selected' : ''}} value="Plug-in Hybrid (PHEV)">Plug-in Hybrid (PHEV)</option>
                                                            <option {{ old('fuel_type') == 'LPG' ? 'selected' : ''}} value="LPG">LPG</option>
                                                            <option {{ old('fuel_type') == 'CNG' ? 'selected' : ''}} value="CNG">CNG</option>
                                                            <option {{ old('fuel_type') == 'Hydrogen (FCEV)' ? 'selected' : ''}} value="Hydrogen (FCEV)">Hydrogen (FCEV)</option>
                                                            <option {{ old('fuel_type') == 'Flex-Fuel' ? 'selected' : ''}} value="Flex-Fuel">Flex-Fuel</option>
                                                            <option {{ old('fuel_type') == 'other' ? 'selected' : ''}} value="other">Other</option>
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
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="mileage">{{translate('mileage')}}</label>
                                                        <input type="number" id="mileage" class="form-control" value="{{old('mileage')}}" name="mileage" placeholder="{{translate('mileage')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
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
                                                        <label>{{translate('vehicle_thumbnail')}}</label>
                                                        <div class="d-flex flex-column gap-3">
                                                            <div class="upload-file" style="width: min-content;">
                                                                <input type="file" class="upload-file__input"  name="image" multiple aria-required="true" accept="image/*">
                                                                <div class="upload-file__img">
                                                                    <div class="temp-img-box">
                                                                        <div class="d-flex align-items-center flex-column gap-2">
                                                                            <i class="bi bi-upload fs-30"></i>
                                                                            <div class="fs-12 text-muted">{{translate('vehicle_image')}}</div>
                                                                        </div>
                                                                    </div>
                                                                    <img src="#" class="dark-support img-fit-contain border" alt="" hidden="">
                                                                </div>
                                                            </div>

                                                            <div class="text-muted">{{translate('Image_ratio_should_be')}} 1:1</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ translate('vehicle_images') }}</label>
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
                                                                            <div class="fs-12 text-muted">{{ translate('vehicle_images') }}</div>
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

                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('price_details') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group mb-2">
                                                        <label for="purchase_type">{{translate('purchase_type')}}</label>
                                                        <select class="form-control" name="purchase_type" id="purchase_type">
                                                            <option value="fixed_price"> -- {{ translate('choose_a_purchase_type') }} -- </option>
                                                            <option {{ old('purchase_type') == 'fixed_price' ? 'selected' : ''}} value="fixed_price">{{ translate('fixed_price') }}</option>
                                                            <option {{ old('purchase_type') == 'auction' ? 'selected' : ''}} value="auction">{{ translate('auction') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="starting-price-box" class="col-sm-6 d-none">
                                                    <div class="form-group mb-2">
                                                        <label for="starting_price">{{translate('starting_price')}}</label>
                                                        <input type="number" id="starting_price" class="form-control" value="{{old('starting_price')}}" name="starting_price" placeholder="{{translate('starting_price')}}">
                                                    </div>
                                                </div>
                                                <div id="price-box" class="col-sm-6 d-none">
                                                    <div class="form-group">
                                                        <label for="price">{{translate('price')}}</label>
                                                        <input type="number" id="price" class="form-control" value="{{old('price')}}" name="price" placeholder="{{translate('price')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('vehicle_dimensions_and_sizes') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="body_type">{{translate('body_type')}}</label>
                                                        <select class="form-control" name="body_type" id="body_type">
                                                            <option {{ old('body_type') == 'suv' ? 'selected' : ''}} value="suv">suv</option>
                                                            <option {{ old('body_type') == 'sedan' ? 'selected' : ''}} value="sedan">sedan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="length">{{translate('length')}}</label>
                                                        <input type="text" id="length" class="form-control" value="{{old('length')}}" name="length" placeholder="{{translate('length')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="height">{{translate('height')}}</label>
                                                        <input type="text" id="height" class="form-control" value="{{old('height')}}" name="height" placeholder="{{translate('height')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="width">{{translate('width')}}</label>
                                                        <input type="text" id="width" class="form-control" value="{{old('width')}}" name="width" placeholder="{{translate('width')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="max_weight">{{translate("max_weight")}}</label>
                                                        <input type="text" id="max_weight" class="form-control" value="{{old('max_weight')}}" name="max_weight" placeholder="{{translate('max_weight')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="bag_capacity">{{translate("bag_capacity")}}</label>
                                                        <input type="text" id="bag_capacity" class="form-control" value="{{old('bag_capacity')}}" name="bag_capacity" placeholder="{{translate('bag_capacity')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('environmental_information') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="co2_emissions">{{translate('co2_emissions')}} ({{ translate('gram_on_ kilometre') }})</label>
                                                        <input type="text" id="co2_emissions" class="form-control" value="{{old('co2_emissions')}}" name="co2_emissions" placeholder="{{translate('co2_emissions')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="energy_consumption">{{translate('energy_consumption')}} ({{ translate('litre_on_ kilometre') }})</label>
                                                        <input type="text" id="energy_consumption" class="form-control" value="{{old('energy_consumption')}}" name="energy_consumption" placeholder="{{translate('energy_consumption')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="gas_emission_tax">{{translate('gas_emission_tax')}}</label>
                                                        <input type="text" id="gas_emission_tax" class="form-control" value="{{old('gas_emission_tax')}}" name="gas_emission_tax" placeholder="{{translate('gas_emission_tax')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-3" >
                                                <h2>{{ translate('vehicle_options') }}</h2>
                                            </div>

                                            @php
                                                $options = [
                                                    'abs',
                                                    'airbags',
                                                    'air_conditioning',
                                                    'alloy_wheels',
                                                    'android_auto',
                                                    'apple_carplay',
                                                    'automatic_climate_control',
                                                    'backup_camera',
                                                    'blind_spot_monitor',
                                                    'bluetooth',
                                                    'cd_player',
                                                    'central_locking',
                                                    'cruise_control',
                                                    'daytime_running_lights',
                                                    'electric_mirrors',
                                                    'electric_windows',
                                                    'fog_lights',
                                                    'gps',
                                                    'heated_seats',
                                                    'hill_start_assist',
                                                    'keyless_entry',
                                                    'lane_departure_warning',
                                                    'leather_seats',
                                                    'led_headlights',
                                                    'multifunction_steering_wheel',
                                                    'parking_sensors',
                                                    'power_steering',
                                                    'rear_ac_vents',
                                                    'remote_start',
                                                    'reversing_camera',
                                                    'roof_rails',
                                                    'sunroof',
                                                    'tpms',
                                                    'touchscreen_display',
                                                    'traction_control',
                                                    'usb_ports',
                                                    'wireless_charging',
                                                ];
                                            @endphp

                                            <div class="row">
                                                
                                                @foreach($options as $option)
                                                    <div class="col-sm-3 mb-3">
                                                        <div class="form-group d-flex gap-1 align-items-center">
                                                            <input type="hidden" name="options[{{ $option }}]" value="false">
                                                            <input type="checkbox" id="{{ $option }}" name="options[{{ $option }}]" value="true">
                                                            <label class="m-0" value="false" for="{{$option}}">{{translate($option)}}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('additional_information') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="previous_scan_date">{{translate('previous_scan_date')}}</label>
                                                        <input type="date" id="previous_scan_date" class="form-control" value="{{old('previous_scan_date')}}" name="previous_scan_date" placeholder="{{translate('previous_scan_date')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="battery_charging_time">{{translate("battery_charging_time")}}</label>
                                                        <input type="text" id="battery_charging_time" class="form-control" value="{{old('battery_charging_time')}}" name="battery_charging_time" placeholder="{{translate('battery_charging_time')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="fast_battery_charging_time">{{translate("fast_battery_charging_time")}}</label>
                                                        <input type="text" id="fast_battery_charging_time" class="form-control" value="{{old('fast_battery_charging_time')}}" name="fast_battery_charging_time" placeholder="{{translate('battery_charging_time')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="battery_life">{{translate("battery_life")}}</label>
                                                        <input type="text" id="battery_life" class="form-control" value="{{old('battery_life')}}" name="battery_life" placeholder="{{translate('battery_life')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="Acceleration_0_100">{{translate("Acceleration_0_100")}}</label>
                                                        <input type="text" id="Acceleration_0_100" class="form-control" value="{{old('acceleration_0_100')}}" name="acceleration_0_100" placeholder="{{translate('Acceleration_0_100')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('meta') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-2">
                                                        <label for="meta_title">{{translate("meta_title")}}</label>
                                                        <input type="text" id="meta_title" class="form-control" value="{{old('meta_title')}}" name="meta_title" placeholder="{{translate('meta_title')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>{{translate('meta_image')}}</label>
                                                        <div class="d-flex flex-column gap-3">
                                                            <div class="upload-file">
                                                                <input type="file" class="upload-file__input"  name="meta_image" multiple aria-required="true" accept="image/*">
                                                                <div class="upload-file__img">
                                                                    <div class="temp-img-box">
                                                                        <div class="d-flex align-items-center flex-column gap-2">
                                                                            <i class="bi bi-upload fs-30"></i>
                                                                            <div class="fs-12 text-muted">{{translate('vehicle_meta_image')}}</div>
                                                                        </div>
                                                                    </div>
                                                                    <img src="#" class="dark-support img-fit-contain border" alt="" hidden="">
                                                                </div>
                                                            </div>
                                                            <div class="text-muted">{{translate('Image_ratio_should_be')}} 1:1</div>
                                                        </div>
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

function addMoreImage(input, targetSection) {
    const files = input.files;
    if (!files || files.length === 0) return;

    const reader = new FileReader();
    const previewImg = input.closest('.upload-file').querySelector('img');
    const tempBox = input.closest('.upload-file').querySelector('.temp-img-box');

    reader.onload = function (e) {
        previewImg.src = e.target.result;
        previewImg.hidden = false;
        if (tempBox) tempBox.style.display = 'none';
    };

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
                            <div class="fs-12 text-muted">{{translate('vehicle_images')}}</div>
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
}

</script>


<script>
    // $(document).ready(function() {
    //     // Wait for the select2 to open
    //     $('.select2-results__option--selectable').css('background-color', '#f0f8ff !important'); // light blue
    // });

    document.addEventListener('DOMContentLoaded', function () {
        const brandSelect = document.getElementById('brand');
        const modelSelect = document.getElementById('model');
        const allModelOptions = Array.from(modelSelect.options);

        brandSelect.addEventListener('change', function () {
            const selectedBrandId = this.value;
            modelSelect.innerHTML = '<option value=""> -- {{ translate("choose_model") }} -- </option>';

            allModelOptions.forEach(option => {
                const brandId = option.getAttribute('data-brand-id');
                if (!brandId || brandId === selectedBrandId) {
                    modelSelect.appendChild(option);
                }
            });
        });
    });



</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const purchaseTypeSelect = document.getElementById('purchase_type');
        const priceBox = document.getElementById('price-box');
        const startingPriceBox = document.getElementById('starting-price-box');

        function togglePriceFields() {
            const selectedValue = purchaseTypeSelect.value;

            if (selectedValue === 'fixed_price') {
                priceBox.classList.remove('d-none');
                startingPriceBox.classList.add('d-none');
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

        // Optionally trigger on load in case the edit page has a pre-selected value
        togglePriceFields();
    });
</script>









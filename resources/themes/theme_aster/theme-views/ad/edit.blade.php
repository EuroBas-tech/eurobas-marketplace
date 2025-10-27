@extends('theme-views.layouts.app')

@section('title', translate('add_new_ad').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@push('css_or_js')
    <meta property="og:image" content="{{env_asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <meta property="twitter:card" content="{{env_asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <style>
        .card-custom-shadow {
            box-shadow: 1px 1px 4px #00000024, -1px 1px 4px #00000024;
        }
        .select2-container .select2-selection--single .select2-selection__rendered {
            overflow: visible !important;
        }
        select ,input[type="text"], input[type="number"]{
            height: 39px !important;
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
                        <div class="card-body p-4 pb-4">
                            <h1 class="pb-3 fs-30" >{{translate('post_an_add')}}</h1>
                            <div class="d-flex align-items-center gap-2">
                                <h5>{{translate('selected_category')}} : </h5>
                                <h6 class="mt-1 fs-14">
                                    <span class="bg-primary py-2 px-2 rounded text-light">
                                        <i class="bi bi-tags-fill"></i>
                                        <span id="dynamic-cat-name" >{{$ad->category->name}}</span>
                                    </span>
                                </h6>
                            </div>

                            <div class="mt-4">
                                <form  action="" method="POST" id="ads-update-form" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$ad->id}}">
                                    <div class="row gy-4">
                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-3" >
                                                <h2>{{ translate('identification_informations') }}</h2>
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <div class="form-group">
                                                    <label for="title">{{translate('title')}}</label>
                                                    <input type="text" id="title" class="form-control" value="{{$ad->title}}" name="title" placeholder="{{translate('ad_title')}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <div class="form-group">
                                                    <label for="description">{{translate('description')}}</label>
                                                    <textarea name="description" id="description" rows="5" class="form-control">{{ $ad->description }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-3" >
                                                <h2>{{ translate('technical_informations') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="category">{{translate('category')}}</label>
                                                        <select class="form-control" name="category_id" id="category">
                                                            <option value=""> -- {{ translate('choose_category') }} --</option>
                                                            @foreach($categories as $category)
                                                                <option data-is-vehicle="{{$category->is_vehicle}}" {{ $category['id'] == $ad['category_id'] ? 'selected' : ''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="brand">{{ translate('brand') }}</label>
                                                        <select class="form-control" name="brand_id" id="brand">
                                                            <option value=""> -- {{ translate('choose_brand') }} -- </option>
                                                            @foreach($brands as $brand)
                                                                <option {{ $brand['id'] == $ad['brand_id'] ? 'selected' : ''}} 
                                                                value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                            @endforeach
                                                            <option value="other" >{{ translate('other_brand') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="model">{{ translate('model') }}</label>
                                                        <select class="form-control" name="model_id" id="model">
                                                            <option value=""> -- {{ translate('choose_model') }} -- </option>
                                                            @foreach($models as $model)
                                                                <option 
                                                                data-brand-id="{{ $model->brand_id }}"
                                                                data-category-id="{{ $model->category_id }}"
                                                                {{ $model['id'] == $ad['model_id'] ? 'selected' : ''}}
                                                                value="{{ $model->id }}">{{ $model->name }}</option>
                                                            @endforeach
                                                            <option value="other" >{{ translate('other_model') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="form-group">
                                                        <label for="status">{{translate('status')}}</label>
                                                        <select class="form-control" name="status" id="status">
                                                            <option value="never_used">{{translate('never used')}}</option>
                                                            <option {{ $ad['status'] == 'new' ? 'selected' : ''}} value="new">{{translate('new')}}</option>
                                                            <option {{ $ad['status'] == 'used' ? 'selected' : ''}} value="used">{{translate('used')}}</option>
                                                            <option {{ $ad['status'] == 'old' ? 'selected' : ''}} value="old">{{translate('old')}}</option>
                                                            <option {{ $ad['status'] == 'very_old' ? 'selected' : ''}} value="very_old">{{translate('very old')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 @if($ad->category->is_vehicle == 0) d-none @endif">
                                                    <div class="form-group">
                                                        <label for="year">{{translate('year')}}</label>
                                                        <input type="number" min="1950" max="2025"  id="year" class="form-control" value="{{$ad->year}}" 
                                                        name="year" placeholder="{{translate('year')}}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 @if($ad->category->is_vehicle == 0) d-none @endif">
                                                    <div class="form-group">
                                                        <label for="mileage">{{translate('mileage')}}</label>
                                                        <input type="number" id="mileage" class="form-control" value="{{$ad['mileage']}}" name="mileage" placeholder="{{translate('mileage')}}">
                                                    </div>
                                                </div>

                                                <div style="width:100%;height: 1px;border-bottom: 1px solid #cccccc85;margin: 35px 0 28px;" ></div>

                                                <div class="col-xl-4 mb-3 @if($ad->category->is_vehicle == 0) d-none @endif">
                                                    <div class="form-group">
                                                        <label for="body_type">{{translate('body_type')}} ({{ translate('Optional') }})</label>
                                                        <select class="form-control" name="body_type" id="body_type">
                                                            <option value=""> -- {{translate('choose_body_type')}} -- </option>
                                                            <option {{ $ad['body_type'] == 'compact' ? 'selected' : ''}} value="compact">{{translate('compact')}}</option>
                                                            <option {{ $ad['body_type'] == 'suv_off_road' ? 'selected' : ''}} value="suv_off_road">{{translate('suv_off_Road')}}</option>
                                                            <option {{ $ad['body_type'] == 'sedan' ? 'selected' : ''}} value="sedan">{{translate('sedan')}}</option>
                                                            <option {{ $ad['body_type'] == 'convertible' ? 'selected' : ''}} value="convertible">{{translate('convertible')}}</option>
                                                            <option {{ $ad['body_type'] == 'coupe' ? 'selected' : ''}} value="coupe">{{translate('coupe')}}</option>
                                                            <option {{ $ad['body_type'] == 'hatchback' ? 'selected' : ''}} value="hatchback">{{translate('hatchback')}}</option>
                                                            <option {{ $ad['body_type'] == 'station_wagon' ? 'selected' : ''}} value="station_wagon">{{translate('station_wagon')}}</option>
                                                            <option {{ $ad['body_type'] == 'van' ? 'selected' : ''}} value="van">{{translate('van')}}</option>
                                                            <option {{ $ad['body_type'] == 'transporter' ? 'selected' : ''}} value="transporter">{{translate('transporter')}}</option>
                                                            <option {{ $ad['body_type'] == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 mb-3 @if($ad->category->is_vehicle == 0) d-none @endif">
                                                    <div class="form-group">
                                                        <label for="fuel_type">{{translate('fuel_type')}}</label>
                                                        <select class="form-control" name="fuel_type" id="fuel_type">
                                                            <option value=""> -- {{translate('choose_engine_type')}} -- </option>
                                                            <option {{ $ad['fuel_type'] == 'Petrol (Gasoline)' ? 'selected' : ''}} value="Petrol (Gasoline)">{{translate('petrol_gasoline')}}</option>
                                                            <option {{ $ad['fuel_type'] == 'Diesel' ? 'selected' : ''}} value="Diesel">{{translate('diesel')}}</option>
                                                            <option {{ $ad['fuel_type'] == 'Electric (EV)' ? 'selected' : ''}} value="Electric (EV)">{{translate('electric_ev')}}</option>
                                                            <option {{ $ad['fuel_type'] == 'Hybrid' ? 'selected' : ''}} value="Hybrid">{{translate('hybrid')}}</option>
                                                            <option {{ $ad['fuel_type'] == 'Plug-in Hybrid (PHEV)' ? 'selected' : ''}} value="Plug-in Hybrid (PHEV)">{{translate('plug_in_hybrid_phev')}}</option>
                                                            <option {{ $ad['fuel_type'] == 'LPG' ? 'selected' : ''}} value="LPG">{{translate('lpg')}}</option>
                                                            <option {{ $ad['fuel_type'] == 'CNG' ? 'selected' : ''}} value="CNG">{{translate('cng')}}</option>
                                                            <option {{ $ad['fuel_type'] == 'Hydrogen (FCEV)' ? 'selected' : ''}} value="Hydrogen (FCEV)">{{translate('hydrogen_fcev')}}</option>
                                                            <option {{ $ad['fuel_type'] == 'Flex-Fuel' ? 'selected' : ''}} value="Flex-Fuel">{{translate('flex_fuel')}}</option>
                                                            <option {{ $ad['fuel_type'] == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 mb-3 @if($ad->category->is_vehicle == 0) d-none @endif">
                                                    <div class="form-group">
                                                        <label for="engine-size">{{translate('engine_size')}}</label>
                                                        <select class="form-control" name="engine_size" id="engine-size">
                                                            <option value=""> -- {{ translate('choose_engine_size') }} -- </option>
                                                            @for($i = 2; $i <= 84; $i++)
                                                                @php
                                                                    $value = ($i / 10);
                                                                    $formattedValue = number_format($value, 1);
                                                                @endphp
                                                                <option {{ $ad['engine_size'] == $formattedValue ? 'selected' : '' }} value="{{ $formattedValue }}">{{ $formattedValue }}L</option>
                                                            @endfor
                                                            <option {{ $ad['engine_size'] == 'other' ? 'selected' : '' }} value="other">{{translate('other')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div id="cylinders-box" class="col-xl-4 mb-3 @if($ad->category->is_vehicle == 0) d-none @endif">
                                                    <div class="form-group">
                                                        <label for="engine-cylinders">{{translate('cylinders')}}</label>
                                                        <select class="form-control" name="engine_cylinders" id="engine-cylinders">
                                                            <option value=""> -- {{translate('choose_cylinder_number')}} -- </option>
                                                            <option {{ $ad['engine_cylinders'] == '1' ? 'selected' : ''}} value="1">1</option>
                                                            <option {{ $ad['engine_cylinders'] == '2' ? 'selected' : ''}} value="2">2</option>
                                                            <option {{ $ad['engine_cylinders'] == '3' ? 'selected' : ''}} value="3">3</option>
                                                            <option {{ $ad['engine_cylinders'] == '4' ? 'selected' : ''}} value="4">4</option>
                                                            <option {{ $ad['engine_cylinders'] == '6' ? 'selected' : ''}} value="6">6</option>
                                                            <option {{ $ad['engine_cylinders'] == '8' ? 'selected' : ''}} value="8">8</option>
                                                            <option {{ $ad['engine_cylinders'] == '10' ? 'selected' : ''}} value="10">10</option>
                                                            <option {{ $ad['engine_cylinders'] == '12' ? 'selected' : ''}} value="12">12</option>
                                                            <option {{ $ad['engine_cylinders'] == '16' ? 'selected' : ''}} value="16">16</option>
                                                            <option {{ $ad['engine_cylinders'] == '18' ? 'selected' : ''}} value="18">18</option>
                                                            <option {{ $ad['engine_cylinders'] == 'other' ? 'selected' : '' }} value="other">{{translate('other')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="transmission-type-box" class="col-xl-4 mb-3 @if($ad->category->is_vehicle == 0) d-none @endif">
                                                    <div class="form-group">
                                                        <label for="transmission_type">{{translate('transmission_type')}}</label>
                                                        <select class="form-control" name="transmission_type" id="transmission_type">
                                                            <option {{ $ad['transmission_type'] == 'automatic' ? 'selected' : ''}} value="automatic">{{translate('automatic')}}</option>
                                                            <option {{ $ad['transmission_type'] == 'semi_automatic' ? 'selected' : ''}} value="semi_automatic">{{translate('semi_automatic')}}</option>
                                                            <option {{ $ad['transmission_type'] == 'manually' ? 'selected' : ''}} value="manually">{{translate('manually')}}</option>
                                                        </select>
                                                    </div>
                                                </div>                                               
                                                <div  id="power-box" class="col-xl-4 mb-3 @if($ad->category->is_vehicle == 0) d-none @endif">
                                                    <div class="form-group">
                                                        <label for="engine-power">{{translate('power')}}</label>
                                                        <input type="text" id="engine-power" class="form-control" value="{{$ad['engine_power']}}" name="engine_power" placeholder="{{translate('Ex:300hp (224kW)')}}">
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="color">{{translate('color')}}</label>
                                                        @php
                                                            $colors = [
                                                                'black', 'white', 'silver', 'gray', 'blue', 'red', 'brown', 'beige',
                                                                'green', 'orange', 'yellow', 'gold', 'purple', 'pink', 'turquoise',
                                                                'darkred', 'navy', 'peru', 'olive', 'multicolor/custom'
                                                            ];
                                                        @endphp
                                                        <select class="form-control" name="color" id="color">
                                                            <option value=""> -- {{ translate('choose_color') }} -- </option>
                                                                @foreach ($colors as $color)
                                                                    <option value="{{$color}}" {{ $ad['color'] == $color ? 'selected' : '' }}>
                                                                        {{ translate($color) }}
                                                                        @if (!$loop->last)
                                                                            <span style="width: 10px;height: 10px;background: {{$color}};" ></span>
                                                                        @endif
                                                                    </option>
                                                                @endforeach
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
                                                                <input 
                                                                    type="file" 
                                                                    class="upload-file__input thumbnail"  
                                                                    name="image" 
                                                                    accept="image/*"
                                                                    aria-required="true"
                                                                    data-old="{{env_asset('storage/ad/thumbnail/'.$ad->thumbnail)}}" {{-- this is key for JS to read the old image --}}
                                                                >

                                                                <div class="upload-file__img">
                                                                    <div class="temp-img-box">
                                                                        <div class="d-flex align-items-center flex-column gap-2">
                                                                            <i class="bi bi-upload fs-30"></i>
                                                                            <div class="fs-12 text-muted">{{ translate('ad_image') }}</div>
                                                                        </div>
                                                                    </div>
                                                                    <img 
                                                                        src="#" 
                                                                        class="dark-support img-fit-contain border" 
                                                                        alt="ad Image" 
                                                                        hidden
                                                                    >
                                                                </div>
                                                            </div>

                                                            <div class="text-muted">{{ translate('Image_ratio_should_be') }} 1:1</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ translate('ad_images') }}</label>
                                                        <div class="d-flex gap-3 flex-wrap" id="additional_Image_Section">
                                                            @foreach(json_decode($ad->images) as $image)
                                                                <div class="upload-file">
                                                                    <input type="hidden" name="old_images[]" value="{{$image}}">
                                                                    <input 
                                                                        type="file" 
                                                                        class="upload-file__input ad-images"  
                                                                        name="images[]"
                                                                        multiple
                                                                        data-old="{{ env_asset('storage/ad/'.$image)}}"
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

                                                                    <span style="position: absolute;top: 10px;right: 10px;"
                                                                    class="btn btn-danger btn-sm rounded p-1 d-inline remove-image-btn" >
                                                                        <i class="bi bi-trash3-fill text-white" ></i>
                                                                    </span>
                                                                </div>
                                                            @endforeach
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
                                                            <option value="" > -- {{ translate('choose_a_currency') }} -- </option>
                                                            <option {{ $ad['currency'] == 'USD' ? 'selected' : ''}} value="USD">USD</option>
                                                            <option {{ $ad['currency'] == 'EUR' ? 'selected' : ''}} value="EUR">EUR</option>
                                                            <option {{ $ad['currency'] == 'GBP' ? 'selected' : ''}} value="GBP">GBP</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group mb-2">
                                                        <label for="">{{translate('price_type')}}</label>
                                                        <select class="form-control" name="price_type" id="price_type">
                                                            <option value=""> -- {{ translate('choose_a_price_type') }} -- </option>
                                                            <option {{ $ad['price_type'] == 'fixed_price' ? 'selected' : ''}} value="fixed_price">{{ translate('fixed_price') }}</option>
                                                            <option {{ $ad['price_type'] == 'asking_price' ? 'selected' : ''}} value="asking_price">{{ translate('asking_price') }}</option>
                                                            <option {{ $ad['price_type'] == 'auction' ? 'selected' : ''}} value="auction">{{ translate('auction') }}</option>
                                                            <option {{ $ad['price_type'] == 'free' ? 'selected' : ''}} value="free">{{ translate('free') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="starting-price-box" class="col-sm-12 @if($ad->price_type != 'auction') d-none @endif">
                                                    <div class="form-group mb-2">
                                                        <input type="number" id="starting-price" class="form-control" 
                                                        value="{{$ad['starting_price']}}" step="0.01" min="0" name="starting_price" 
                                                        placeholder="{{translate('starting_price')}}">
                                                    </div>
                                                </div>
                                                <div id="price-box" class="col-sm-12 @if($ad->price_type == 'auction' || $ad->price_type == 'free') d-none @endif">
                                                    <div class="form-group">
                                                        <input type="number" id="price" class="form-control" value="{{$ad['price']}}" name="price" placeholder="{{translate('price')}}" step="0.01" min="0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="offers-box" class="col-sm-12 @if($ad->price_type != 'asking_price') d-none @endif mt-2">
                                                <div class="form-group form-check form-switch d-flex gap-5 p-0 align-items-center">
                                                    <label class="m-0" for="show-phone-number">{{translate('allow_offers')}} ?</label>
                                                    <input class="form-check-input" {{ $ad['allow_offers'] == 1 ? 'checked' : '' }}
                                                    name="allow_offers" type="checkbox" role="switch" id="allow-offers">
                                                </div>
                                                <div class="form-group @if($ad['allow_offers'] == 0) d-none @endif" id="first-price">
                                                    <input type="number" step="0.01" min="0" id="first-price-input" class="form-control" value="{{$ad['first_price']}}" 
                                                    name="first_price" placeholder="{{translate('first_price')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-3" >
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
                                                        <input class="form-check-input" {{ $ad['show_email_address'] == 1 ? 'checked' : '' }}
                                                        name="show_email_address" type="checkbox" role="switch" id="show-email-address">
                                                    </div>
                                                </div>
                                                <div id="email-address" class="col-sm-12 mb-3 @if($ad['show_email_address'] == 0) d-none @endif">
                                                    <div class="form-group">
                                                        <input disabled type="text" id="email_address" class="form-control" 
                                                        value="{{ auth('customer')->user()->email }}" name="email_address" placeholder="{{translate('email_address')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group form-check form-switch d-flex gap-5 p-0 align-items-center">
                                                        <label class="m-0" for="show-phone-number">{{translate('show_phone_number_on_ad')}} ?</label>
                                                        <input class="form-check-input" {{ $ad['show_phone_number'] == 1 ? 'checked' : '' }}
                                                        name="show_phone_number" type="checkbox" role="switch" id="show-phone-number">
                                                    </div>
                                                </div>
                                                <div id="phone-number" class="col-sm-12 mb-3 @if($ad['show_phone_number'] == 0) d-none @endif">
                                                    <div class="form-group">
                                                        <div class="d-flex align-items-center gap-2 mb-2" >
                                                            <img width="28px" src="https://static.vecteezy.com/system/resources/previews/016/716/480/non_2x/whatsapp-icon-free-png.png" alt="">
                                                            <label class="m-0 fs-13" for="whatsapp_availability">{{translate('whatsApp_available')}} ?</label>
                                                            <input class="form-check-input m-0" name="whatsapp_availability" 
                                                            {{ $ad['whatsapp_availability'] == 1 ? 'checked' : '' }} type="checkbox" id="whatsapp_availability">
                                                        </div>
                                                        
                                                        <div class="form-group" id="phone_number">
                                                            <div class="input-group">

                                                                @php
                                                                    $countries = [
                                                                        ['code' => '+1', 'flag' => '🇺🇸', 'name' => 'United States'],
                                                                        ['code' => '+44', 'flag' => '🇬🇧', 'name' => 'United Kingdom'],
                                                                        ['code' => '+33', 'flag' => '🇫🇷', 'name' => 'France'],
                                                                        ['code' => '+49', 'flag' => '🇩🇪', 'name' => 'Germany'],
                                                                        ['code' => '+39', 'flag' => '🇮🇹', 'name' => 'Italy'],
                                                                        ['code' => '+34', 'flag' => '🇪🇸', 'name' => 'Spain'],
                                                                        ['code' => '+31', 'flag' => '🇳🇱', 'name' => 'Netherlands'],
                                                                        ['code' => '+32', 'flag' => '🇧🇪', 'name' => 'Belgium'],
                                                                        ['code' => '+43', 'flag' => '🇦🇹', 'name' => 'Austria'],
                                                                        ['code' => '+48', 'flag' => '🇵🇱', 'name' => 'Poland'],
                                                                        ['code' => '+45', 'flag' => '🇩🇰', 'name' => 'Denmark'],
                                                                        ['code' => '+46', 'flag' => '🇸🇪', 'name' => 'Sweden'],
                                                                        ['code' => '+358', 'flag' => '🇫🇮', 'name' => 'Finland'],
                                                                        ['code' => '+351', 'flag' => '🇵🇹', 'name' => 'Portugal'],
                                                                        ['code' => '+30', 'flag' => '🇬🇷', 'name' => 'Greece'],
                                                                        ['code' => '+420', 'flag' => '🇨🇿', 'name' => 'Czech Republic'],
                                                                        ['code' => '+36', 'flag' => '🇭🇺', 'name' => 'Hungary'],
                                                                        ['code' => '+40', 'flag' => '🇷🇴', 'name' => 'Romania'],
                                                                        ['code' => '+359', 'flag' => '🇧🇬', 'name' => 'Bulgaria'],
                                                                        ['code' => '+421', 'flag' => '🇸🇰', 'name' => 'Slovakia'],
                                                                        ['code' => '+352', 'flag' => '🇱🇺', 'name' => 'Luxembourg'],
                                                                        ['code' => '+386', 'flag' => '🇸🇮', 'name' => 'Slovenia'],
                                                                        ['code' => '+41', 'flag' => '🇨🇭', 'name' => 'Switzerland'],
                                                                        ['code' => '+47', 'flag' => '🇳🇴', 'name' => 'Norway'],
                                                                        ['code' => '+354', 'flag' => '🇮🇸', 'name' => 'Iceland'],
                                                                        ['code' => '+370', 'flag' => '🇱🇹', 'name' => 'Lithuania'],
                                                                        ['code' => '+371', 'flag' => '🇱🇻', 'name' => 'Latvia'],
                                                                        ['code' => '+372', 'flag' => '🇪🇪', 'name' => 'Estonia'],
                                                                        ['code' => '+385', 'flag' => '🇭🇷', 'name' => 'Croatia'],
                                                                        ['code' => '+381', 'flag' => '🇷🇸', 'name' => 'Serbia'],
                                                                        ['code' => '+387', 'flag' => '🇧🇦', 'name' => 'Bosnia and Herzegovina'],
                                                                        ['code' => '+353', 'flag' => '🇮🇪', 'name' => 'Ireland'],
                                                                        ['code' => '+355', 'flag' => '🇦🇱', 'name' => 'Albania'],
                                                                        ['code' => '+389', 'flag' => '🇲🇰', 'name' => 'North Macedonia'],
                                                                        ['code' => '+373', 'flag' => '🇲🇩', 'name' => 'Moldova'],
                                                                        ['code' => '+380', 'flag' => '🇺🇦', 'name' => 'Ukraine'],
                                                                        ['code' => '+375', 'flag' => '🇧🇾', 'name' => 'Belarus'],
                                                                        ['code' => '+86', 'flag' => '🇨🇳', 'name' => 'China'],
                                                                        ['code' => '+7', 'flag' => '🇷🇺', 'name' => 'Russia'],
                                                                        ['code' => '+383', 'flag' => '🇽🇰', 'name' => 'Kosovo'],
                                                                        ['code' => '+377', 'flag' => '🇲🇨', 'name' => 'Monaco'],
                                                                        ['code' => '+357', 'flag' => '🇨🇾', 'name' => 'Cyprus'],
                                                                        ['code' => '+423', 'flag' => '🇱🇮', 'name' => 'Liechtenstein'],
                                                                        ['code' => '+356', 'flag' => '🇲🇹', 'name' => 'Malta'],
                                                                        ['code' => '+382', 'flag' => '🇲🇪', 'name' => 'Montenegro'],
                                                                        ['code' => '+81', 'flag' => '🇯🇵', 'name' => 'Japan'],
                                                                        ['code' => '+82', 'flag' => '🇰🇷', 'name' => 'South Korea'],
                                                                    ];
                                                                @endphp

                                                                <select name="phone_code" class="form-select emoji-font input-height" style="max-width: 150px;">
                                                                    @foreach ($countries as $country)
                                                                        <option
                                                                            class="emoji-font"
                                                                            value="{{ $country['code'] }}"
                                                                            {{ $ad['phone_code'] == $country['code'] ? 'selected' : '' }}
                                                                        >
                                                                            {{ $country['flag'] }} {{ $country['code'] }} {{ $country['name'] }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="tel" class="form-control input-height" value="{{$ad['contact_phone_number']}}" name="contact_phone_number" placeholder="{{translate('Ex:  01xxxxxxxxx')}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group mb-3">
                                                        <label for="delivery_service_name" class="fw-medium">{{ translate('country') }}</label>
                                                        <select class="form-control custom-input-height emoji-font" name="country" >
                                                            <option value="">{{ translate('choose_the_country') }}</option>
                                                            @foreach (array_slice(SYSTEM_COUNTRIES, 1) as $country)
                                                                <option {{ $ad['country'] == $country['name'] ? 'selected' : '' }} class="emoji-font" value="{{$country['name']}}">{{$country['emoji']}} {{ $country['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="city">{{translate("city")}}</label>
                                                        <input type="text" id="city" class="form-control" 
                                                        value="{{$ad['city']}}" name="city" 
                                                        placeholder="{{translate('city')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="postal_code">{{translate("postal_code")}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="postal_code" class="form-control" 
                                                        value="{{$ad['postal_code']}}" name="postal_code" 
                                                        placeholder="{{translate('postal_code')}}">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('location_informations') }}</h2>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-xl-4">
                                                    <div class="form-group mb-3">
                                                        <label for="country" class="fw-medium">{{ translate('country') }}</label>
                                                        <select class="form-control custom-input-height emoji-font" id="country" name="country" >
                                                            <option value="">{{ translate('choose_the_country') }}</option>
                                                            @foreach (array_slice(SYSTEM_COUNTRIES, 1) as $country)
                                                                <option {{ $ad['country'] == $country['name'] ? 'selected' : '' }} class="emoji-font" value="{{$country['name']}}">{{$country['emoji']}} {{ $country['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="form-group">
                                                        <label for="address-city">{{translate("city")}}</label>
                                                        <input type="text" id="address-city" class="form-control" 
                                                        value="{{$ad['city']}}" name="city" 
                                                        placeholder="{{translate('city')}}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="form-group">
                                                        <label for="postal-code">{{translate("postal_code")}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="postal-code" class="form-control" 
                                                        value="{{$ad['postal_code']}}" name="postal_code" 
                                                        placeholder="{{translate('postal_code')}}">
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="mb-3 position-relative">
                                                            <input id="pac-input" class="controls rounded __inline-46" title="{{translate('search_your_location_here')}}" type="text" placeholder="{{translate('search_here')}}"/>
                                                            <div class="dark-support rounded w-100 __h-14rem" id="location_map_canvas"></div>
                                                        </div>
                                                        <div class="d-flex justify-content-end" >
                                                            <button class="btn btn-outline-primary btn-sm" type="button" id="find_location">Find My Location</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="environmental-information-box" class="mb-1 border @if($ad->category->is_vehicle == 0) d-none @endif px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-3" >
                                                <h2>{{ translate('environmental_information') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="co2_emissions">{{translate('co2_emissions')}} ({{ translate('gram_on_ kilometre') }}) ({{ translate('Optional') }})</label>
                                                        <input type="text" id="co2_emissions" class="form-control" value="{{$ad['co2_emissions']}}" name="co2_emissions" placeholder="{{translate('co2_emissions')}}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="energy_consumption">{{translate('energy_consumption')}} ({{ translate('litre_on_ kilometre') }}) ({{ translate('Optional') }})</label>
                                                        <input type="text" id="energy_consumption" class="form-control" value="{{$ad['energy_consumption']}}" name="energy_consumption" placeholder="{{translate('energy_consumption')}}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="gas_emission_tax">{{translate('gas_emission_tax')}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="gas_emission_tax" class="form-control" value="{{$ad['gas_emission_tax']}}" name="gas_emission_tax" placeholder="{{translate('gas_emission_tax')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-1 border px-3 py-3 rounded @if($ad->category->is_vehicle == 0) d-none @endif rounded custom-gray-border-color" >
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

                                                $saved_options = json_decode($ad->options ?? '{}', true);
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

                                        <div id="additional-information-box" class="mb-1 border px-3 py-3 rounded @if($ad->category->is_vehicle == 0) d-none @endif custom-gray-border-color" >
                                            <div class="mb-3" >
                                                <h2>{{ translate('additional_information') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="previous_scan_date">{{translate('previous_scan_date')}} ({{ translate('Optional') }})</label>
                                                        <input type="date" id="previous_scan_date" class="form-control" value="{{$ad['previous_scan_date']}}" name="previous_scan_date" placeholder="{{translate('previous_scan_date')}}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="battery_charging_time">{{translate("battery_charging_time")}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="battery_charging_time" class="form-control" value="{{$ad['battery_charging_time']}}" name="battery_charging_time" placeholder="{{translate('battery_charging_time')}}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="fast_battery_charging_time">{{translate("fast_battery_charging_time")}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="fast_battery_charging_time" class="form-control" value="{{$ad['fast_battery_charging_time']}}" name="fast_battery_charging_time" placeholder="{{translate('battery_charging_time')}}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="battery_life">{{translate("battery_life")}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="battery_life" class="form-control" value="{{$ad['battery_life']}}" name="battery_life" placeholder="{{translate('battery_life')}}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="Acceleration_0_100">{{translate("Acceleration_0_100")}} ({{ translate('Optional') }})</label>
                                                        <input type="text" id="Acceleration_0_100" class="form-control" value="{{$ad['acceleration_0_100']}}" name="acceleration_0_100" placeholder="{{translate('Acceleration_0_100')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex justify-content-end gap-3">
                                                <button id="add-button" type="button" class="btn btn-primary">
                                                    {{translate('Update')}}
                                                    <!-- here -->
                                                </button>
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

@push('script')

    <script>
        window.onload = function () {
            CKEDITOR.replace('description');
        };
    </script>

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
            
            // Set initial state of phone number input fields
            const phoneInput = document.querySelector('input[name="contact_phone_number"]');
            const phoneCodeSelect = document.querySelector('select[name="phone_code"]');
            
            // Initially disable the phone fields if checkbox is not checked
            if (!showPhoneCheckbox.checked) {
                phoneInput.disabled = true;
                phoneCodeSelect.disabled = true;
            }
            
            // Add event listener to the checkbox
            showPhoneCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    // If checkbox is checked, remove d-none class and enable the input
                    phoneNumberDiv.classList.remove('d-none');
                    phoneInput.disabled = false;
                    phoneCodeSelect.disabled = false;
                } else {
                    // If checkbox is unchecked, add d-none class and disable the input
                    phoneNumberDiv.classList.add('d-none');
                    phoneInput.disabled = true;
                    phoneCodeSelect.disabled = true;
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

            // Replace your existing event listener code with this:
            document.addEventListener('click', function(e) {
                // Check if the clicked element is a remove button or its child (like the icon)
                const removeBtn = e.target.closest('.remove-image-btn');
                if (removeBtn) {
                    const uploadFileDiv = removeBtn.closest('.upload-file');
                    if (uploadFileDiv) {
                        uploadFileDiv.remove();
                    }
                }
            });

        });

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

                const removeBtn = `
                    <span style="position: absolute;top: 10px;right: 10px;"
                    class="btn btn-danger btn-sm rounded p-1 d-inline remove-image-btn" >
                    <i class="bi bi-trash3-fill text-white" ></i>
                    </span>
                `;

                if (isLastInput) {
                    const newInputIndex = $fileInputs.length;

                    const newInputHTML = `
                        <div class="upload-file position-relative">
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

                    // Append remove button to second-to-last .upload-file
                    const fileWrappers = document.querySelectorAll(`${targetSection} .upload-file`);
                    
                    if (fileWrappers.length > 0) {
                        const secondLastWrapper = fileWrappers[fileWrappers.length - 1];
                        secondLastWrapper.insertAdjacentHTML('beforeend', removeBtn);
                    }

                    // Append the new input to the target section
                    const container = document.querySelector(targetSection);
                    container.insertAdjacentHTML('beforeend', newInputHTML);
                }
                
            } else {
                toastr.error("{{translate('maximum_10_images_allowed')}}");
                // Reset the input value to clear the selected file
                input.value = '';
            }

        }

        $(window).on("load", function () {
            let input = $(".upload-file__input.thumbnail");
            let img = input
                .siblings(".upload-file__img")
                .find("img")
                .removeAttr("hidden");

            input
                .siblings(".upload-file__img")
                .find(".temp-img-box")
                .remove();

            img.attr("src", input.data("old"));
        });

        $(window).on("load", function () {
            $('.ad-images').each(function(index, image) {
                let $image = $(image); // wrap it in jQuery

                let img = $image
                .siblings(".upload-file__img")
                .find("img")
                .removeAttr("hidden");

                $image
                .siblings(".upload-file__img")
                .find(".temp-img-box")
                .remove();

                img.attr("src", $image.data("old"));
            });
        });

        $(document).ready(function() {
            function storeAd() {
                // Show loader and disable button
                $('#add-button').prop('disabled', true);
                $('#add-button').html(`
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    {{ translate('Processing...') }}
                `);

                if (CKEDITOR.instances.description) {
                    CKEDITOR.instances.description.updateElement();
                }

                // 1. Get the form element
                let form = $('#ads-update-form')[0];
                
                // 2. Create FormData object
                let formData = new FormData(form);

                $.ajax({
                    url: "{{ route('ads-update') }}",
                    type: "POST",
                    data: formData,
                    processData: false,  // Required for FormData
                    contentType: false,   // Required for FormData
                    cache: false,        // Recommended for file uploads
                    success: function(response) {

                        // Restore button
                        $('#add-button').prop('disabled', false);
                        $('#add-button').html(`{{ translate('Add') }}`);


                        if (response.success) {
                            toastr.success(response.message);
                            
                            // Optional: Redirect after success
                            if (response.redirect_url) {
                                setTimeout(function() {
                                    window.location.href = response.redirect_url;
                                }, 1500); // Redirect after 1.5 seconds
                            }
                        } else {
                            // Handle unexpected success=false responses
                            toastr.warning(response.message || 'Operation completed with warnings');
                        }
                    },                    
                    error: function(xhr) {

                        // Restore button
                        $('#add-button').prop('disabled', false);
                        $('#add-button').html(`{{ translate('Add') }}`);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            // Handle as simple array
                            if (Array.isArray(errors)) {
                                errors.forEach(function(error) {
                                    toastr.error(error);
                                });
                            }
                            // Handle as object (if you change backend later)
                            else {
                                $.each(errors, function(field, messages) {
                                    messages.forEach(function(message) {
                                        toastr.error(message);
                                    });
                                });
                            }
                        } else {
                            toastr.error('An error occurred: ' + xhr.responseText);
                        }
                    }


                });
            }
            
            // You need to call it, for example on a button click:
            $('#add-button').on('click', function() {
                storeAd();
            });
        });

        $(document).ready(function () {
            const $brandSelect = $('#brand');
            const $modelSelect = $('#model');
            const $categorySelect = $('#category');

            // Initialize Select2
            $brandSelect.select2({
                placeholder: "{{ translate('choose_brand') }}",
                allowClear: true
            });

            $modelSelect.select2({
                placeholder: "{{ translate('choose_model') }}",
                allowClear: true
            });

            $('#color').select2({
                placeholder: "{{ translate('choose_color') }}",
                allowClear: true
            });

            // Store all model options
            const allModelOptions = $('#model option').clone();
            
            // Create the "Other" options once with value="other"
            const otherBrandOption = '<option value="other">{{ translate("other_brand") }}</option>';
            const otherModelOption = '<option value="other">{{ translate("other_model") }}</option>';

            addPersistentOptions();

            function addPersistentOptions() {
                // Add "Other Brand" if it doesn't exist
                if ($brandSelect.find('option[value="other"]').length === 0) {
                    $brandSelect.append(otherBrandOption);
                }
                
                // Add "Other Model" if it doesn't exist
                if ($modelSelect.find('option[value="other"]').length === 0) {
                    $modelSelect.append(otherModelOption);
                }
            }

            function filterModels() {
                const selectedBrandId = $brandSelect.val();
                const selectedCategoryId = $categorySelect.val();

                // Clear models but keep the "Other Model" and default option
                $modelSelect.find('option').not('[value="other"], [value=""]').remove();
                
                // Filter and add matching models
                allModelOptions.each(function () {
                    const brandId = $(this).data('brand-id');
                    const categoryId = $(this).data('category-id');

                    if (
                        (!brandId || brandId == selectedBrandId) &&
                        (!categoryId || categoryId == selectedCategoryId)
                    ) {
                        $modelSelect.append($(this).clone());
                    }
                });

                // Ensure "Other Model" is at the end and only appears once
                if ($modelSelect.find('option[value="other"]').length > 1) {
                    $modelSelect.find('option[value="other"]').not(':last').remove();
                }
                
                $modelSelect.val(null).trigger('change');
                
                // Ensure "Other Brand" exists
                addPersistentOptions();
            }

            $brandSelect.on('change', function () {
                filterModels();
                $modelSelect.prop('disabled', false);
                addPersistentOptions();
            });

            $categorySelect.on('change', function () {
                $brandSelect.val(null).trigger('change');
                $modelSelect.val(null).trigger('change');

                if($(this).find(':selected').data('is-vehicle') == 1) {
                    $('#year-box').removeClass('d-none');
                    $('#engine-type-box').removeClass('d-none');
                    $('#mileage-box').removeClass('d-none');
                    $('#transmission-type-box').removeClass('d-none');
                    $('#body-type-box').removeClass('d-none');
                    $('#bag-capacity-box').removeClass('d-none');
                    $('#environmental-information-box').removeClass('d-none');
                    $('#ad-options-box').removeClass('d-none');
                    $('#additional-information-box').removeClass('d-none');
                    $('#engine-type-box').removeClass('d-none');
                    $('#engine-size-box').removeClass('d-none');
                    $('#cylinders-box').removeClass('d-none');
                    $('#power-box').removeClass('d-none');
                } else {
                    $('#year-box').addClass('d-none');
                    $('#engine-type-box').addClass('d-none');
                    $('#mileage-box').addClass('d-none');
                    $('#transmission-type-box').addClass('d-none');
                    $('#body-type-box').addClass('d-none');
                    $('#bag-capacity-box').addClass('d-none');
                    $('#environmental-information-box').addClass('d-none');
                    $('#ad-options-box').addClass('d-none');
                    $('#additional-information-box').addClass('d-none');
                    $('#engine-type-box').addClass('d-none');
                    $('#engine-size-box').addClass('d-none');
                    $('#cylinders-box').addClass('d-none');
                    $('#power-box').addClass('d-none');
                }

                filterModels();
                addPersistentOptions();
            });

           $('#color').on('select2:open', function () {
                setTimeout(function () {
                    const $options = $('.select2-results__option');
                    $options.each(function (index) {
                        if (index === $options.length - 1) return;

                        const color = $(this).text().trim();

                        if (!$(this).find('.color-square').length) {
                            const square = $('<span class="color-square"></span>').css({
                                display: 'inline-block',
                                width: '30px',
                                height: '15px',
                                border: 'solid #cfcfcf 1px',
                                'background-color': color,
                                'margin-left': '8px',
                                'vertical-align': 'middle',
                                'border-radius': '2px'
                            });

                            $(this).append(square);
                        }
                    });
                }, 0);
            });

            $('#color').on('change', function () {
                setTimeout(function () {
                    const $selection = $('#color').next('.select2-container').find('.select2-selection__rendered');
                    $selection.find('.selected-color-square').remove();

                    const color = $selection.text().trim();

                    const square = $('<span class="selected-color-square"></span>').css({
                        display: 'inline-block',
                        width: '30px',
                        height: '15px',
                        border: 'solid #cfcfcf 1px',
                        'background-color': color,
                        'margin-left': '8px',
                        'vertical-align': 'middle',
                        'border-radius': '2px'
                    });

                    $selection.append(square);
                }, 0);
            });

            $('#color').on('select2:open', function () {
                const colorSelectContainer = $('#color').data('select2').$dropdown;
                const searchInput = colorSelectContainer.find('.select2-search__field');

                searchInput.off('input').on('input', function () {
                    setTimeout(function applyColorSquares() {
                        const $options = colorSelectContainer.find('.select2-results__option');

                        $options.each(function (index) {
                            if (index === $options.length - 1) return;

                            const $option = $(this);
                            const color = $option.text().trim();

                            if (
                                !$option.hasClass('select2-results__message') &&
                                color &&
                                !$option.find('.color-square').length
                            ) {
                                const square = $('<span class="color-square"></span>').css({
                                    display: 'inline-block',
                                    width: '30px',
                                    height: '15px',
                                    border: 'solid #cfcfcf 1px',
                                    'background-color': color,
                                    'margin-left': '8px',
                                    'vertical-align': 'middle',
                                    'border-radius': '2px'
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
        function initAutocomplete() {
            // Europe center coordinates (initial fallback)
            let myLatLng = { lat: 50.1109, lng: 8.6821 };
            
            // Initialize the map focused on Europe initially
            const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                center: myLatLng,
                zoom: 4,
                mapTypeId: "roadmap",
            });

            // Initialize marker as null - will be created when needed
            let marker = null;

            // Initialize geocoder
            const geocoder = new google.maps.Geocoder();

            // Define debounce function
            function debounce(func, wait, immediate) {
                var timeout;
                return function() {
                    var context = this, args = arguments;
                    var later = function() {
                        timeout = null;
                        if (!immediate) func.apply(context, args);
                    };
                    var callNow = immediate && !timeout;
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                    if (callNow) func.apply(context, args);
                };
            }

            // Function to create or update marker
            function createOrUpdateMarker(position) {
                if (marker) {
                    marker.setPosition(position);
                } else {
                    marker = new google.maps.Marker({
                        position: position,
                        map: map,
                        draggable: true
                    });
                    
                    // Add drag event listener when marker is created
                    google.maps.event.addListener(marker, 'dragend', function(event) {
                        updateFormFields(event.latLng.lat(), event.latLng.lng());
                    });
                }
            }

            // Function to focus map based on current fields
            function focusOnLocation() {
                const country = document.getElementById('country').value;
                const city = document.getElementById('address-city').value;
                const postalCode = document.getElementById('postal-code').value;
                
                let searchQuery = '';
                
                // Build search query based on available data (prioritize more specific)
                if (city && postalCode) {
                    searchQuery = `${postalCode}, ${city}, ${country}`;
                } else if (city && country) {
                    searchQuery = `${city}, ${country}`;
                } else if (country) {
                    searchQuery = country;
                }
                
                if (searchQuery) {
                    geocodeAddress(searchQuery);
                }
            }

            // Function to geocode an address and center map
            function geocodeAddress(address) {
                geocoder.geocode({ address: address }, function(results, status) {
                    if (status === 'OK' && results[0]) {
                        const location = results[0].geometry.location;
                        map.setCenter(location);
                        createOrUpdateMarker(location);
                        
                        // Adjust zoom based on how specific the address is
                        const city = document.getElementById('address-city').value;
                        const postalCode = document.getElementById('postal-code').value;
                        
                        if (city && postalCode) {
                            map.setZoom(14); // Postal code level
                        } else if (city) {
                            map.setZoom(10); // City level
                        } else {
                            map.setZoom(6); // Country level
                        }
                    } else {
                        // If geocoding fails (e.g., city doesn't exist), try with just country
                        const country = document.getElementById('country').value;
                        if (country && address !== country) {
                            geocodeAddress(country);
                        }
                    }
                });
            }

            // Function to update form fields based on coordinates
            function updateFormFields(lat, lng) {
                const latlng = new google.maps.LatLng(lat, lng);
                
                geocoder.geocode({ 'location': latlng }, function(results, status) {
                    if (status === 'OK' && results[0]) {
                        const addressComponents = results[0].address_components;
                        
                        // Extract country, city, and postal code
                        let country = '';
                        let city = '';
                        let postalCode = '';
                        
                        // Parse address components
                        for (let component of addressComponents) {
                            const types = component.types;
                            
                            if (types.includes('country')) {
                                country = component.long_name;
                            }
                            
                            if (types.includes('postal_code')) {
                                postalCode = component.long_name;
                            }
                            
                            if (types.includes('locality')) {
                                city = component.long_name;
                            } else if (types.includes('sublocality_level_1') && !city) {
                                city = component.long_name;
                            } else if (types.includes('administrative_area_level_2') && !city) {
                                city = component.long_name;
                            } else if (types.includes('administrative_area_level_1') && !city) {
                                city = component.long_name;
                            }
                        }
                        
                        // Clean city name
                        if (city) {
                            city = city.replace(/^(Greater|Metropolitan|City of|Municipality of|Borough of)\s+/i, '');
                        }
                        
                        // Update country dropdown
                        const countrySelect = document.getElementById('country');
                        for (let option of countrySelect.options) {
                            if (option.text.includes(country)) {
                                countrySelect.value = option.value;
                                break;
                            }
                        }
                        
                        // Update city field
                        if (city) {
                            document.getElementById('address-city').value = city;
                        }
                        
                        // Update postal code field
                        if (postalCode) {
                            document.getElementById('postal-code').value = postalCode;
                        }
                    }
                });
            }

            // NEW FEATURE: GPS Location Detection Function
            function findUserLocation() {
                const findLocationBtn = document.getElementById('find_location');
                
                // Check if geolocation is supported
                if (!navigator.geolocation) {
                    alert('Geolocation is not supported by this browser.');
                    return;
                }
                
                // Disable button and show loading state
                if (findLocationBtn) {
                    findLocationBtn.disabled = true;
                    findLocationBtn.innerHTML = 'Finding Location...';
                }
                
                // Get current position
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const userLocation = new google.maps.LatLng(lat, lng);
                        
                        // Center map on user location
                        map.setCenter(userLocation);
                        map.setZoom(14); // Set appropriate zoom level for user location
                        
                        // Create or update marker at user location
                        createOrUpdateMarker(userLocation);
                        
                        // Update form fields with user location data
                        updateFormFields(lat, lng);
                        
                        // Reset button state
                        if (findLocationBtn) {
                            findLocationBtn.disabled = false;
                            findLocationBtn.innerHTML = 'Find My Location';
                        }
                    },
                    function(error) {
                        let errorMessage = 'Unable to retrieve your location. ';
                        
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += 'Location access denied by user.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += 'Location information is unavailable.';
                                break;
                            case error.TIMEOUT:
                                errorMessage += 'Location request timed out.';
                                break;
                            default:
                                errorMessage += 'An unknown error occurred.';
                                break;
                        }
                        
                        alert(errorMessage);
                        
                        // Reset button state
                        if (findLocationBtn) {
                            findLocationBtn.disabled = false;
                            findLocationBtn.innerHTML = 'Find My Location';
                        }
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 60000
                    }
                );
            }

            // Map click event
            google.maps.event.addListener(map, 'click', function(mapsMouseEvent) {
                const coordinates = mapsMouseEvent.latLng.toJSON();
                createOrUpdateMarker(new google.maps.LatLng(coordinates.lat, coordinates.lng));
                map.panTo(new google.maps.LatLng(coordinates.lat, coordinates.lng));
                updateFormFields(coordinates.lat, coordinates.lng);
            });

            // Create search box if pac-input exists
            const input = document.getElementById("pac-input");
            if (input) {
                const searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
                
                map.addListener("bounds_changed", () => {
                    searchBox.setBounds(map.getBounds());
                });
                
                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();
                    
                    if (places.length == 0) return;
                    
                    const bounds = new google.maps.LatLngBounds();
                    places.forEach((place) => {
                        if (!place.geometry) return;
                        
                        createOrUpdateMarker(place.geometry.location);
                        map.setCenter(place.geometry.location);
                        updateFormFields(place.geometry.location.lat(), place.geometry.location.lng());
                        
                        if (place.geometry.viewport) {
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    
                    map.fitBounds(bounds);
                });
            }

            // Focus on existing location when page loads (edit page)
            setTimeout(function() {
                const country = document.getElementById('country').value;
                const city = document.getElementById('address-city').value;
                const postalCode = document.getElementById('postal-code').value;
                
                // Check if we have existing data to focus on
                if (country || city || postalCode) {
                    focusOnLocation();
                }
            }, 1000);

            // Define event handlers with debouncing
            const debouncedFocus = debounce(focusOnLocation, 500);
            
            // Country change handler
            document.getElementById('country').addEventListener('change', function() {
                if (this.value) {
                    // Clear city and postal code when country changes
                    document.getElementById('address-city').value = '';
                    document.getElementById('postal-code').value = '';
                    debouncedFocus();
                }
            });

            // City input handler
            document.getElementById('address-city').addEventListener('input', function() {
                if (this.value.trim()) {
                    // Clear postal code when city changes
                    document.getElementById('postal-code').value = '';
                    debouncedFocus();
                }
            });

            // Postal code input handler
            document.getElementById('postal-code').addEventListener('input', function() {
                if (this.value.trim()) {
                    debouncedFocus();
                }
            });

            // NEW FEATURE: Add event listener for GPS location button
            const findLocationBtn = document.getElementById('find_location');
            if (findLocationBtn) {
                findLocationBtn.addEventListener('click', findUserLocation);
            }
        }

        // Initialize when document is ready
        $(document).ready(function() {
            initAutocomplete();
        });

        // Prevent form submission on Enter key
        $(document).on("keydown", "input", function(e) {
            if (e.which == 13) e.preventDefault();
        });
    </script>

    <script defer async src="https://maps.googleapis.com/maps/api/js?key={{\App\CPU\Helpers::get_business_settings('map_api_key')}}&callback=initAutocomplete&libraries=places&v=3.49" ></script>    
@endpush






@extends('theme-views.layouts.app')

@section('title', translate('edit_new_ad').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@section('content')
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-4">
        <div class="container">
            <div class="row g-3">
                <!-- Sidebar-->
                @include('theme-views.partials._profile-aside')
                <div class="col">
                    <div class="card h-lg-100">
                        <div class="card-body p-lg-4">
                            <div class="">
                                <h1>{{translate('edit_ad_informations')}}</h1>
                            </div>

                            <div class="mt-4">
                                <form  action="{{route('ads-update')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="ad_id" value="{{$ad->id}}">
                                    <div class="row gy-4">
                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('identification_informations') }}</h2>
                                            </div>
                                            <div class="col-sm-12 mb-2">
                                                <div class="form-group">
                                                    <label for="name">{{translate('name')}}</label>
                                                    <input type="text" value="{{$ad->name}}" id="name" class="form-control" name="name" placeholder="{{translate('car_name')}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 mb-2">
                                                <div class="form-group">
                                                    <label for="slug">{{translate('slug')}}</label>
                                                    <input type="text" value="{{$ad->slug}}" id="slug" class="form-control" name="slug" placeholder="{{translate('car_slug')}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 mb-2">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" id="description" rows="5" class="form-control">{{$ad->description}}</textarea>
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
                                                                <option {{ $ad['category_id'] == $category['id'] ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
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
                                                                <option {{ $ad['brand_id'] == $brand['id'] ? 'selected' : '' }} value="{{ $brand->id }}">{{ $brand->name }}</option>
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
                                                                {{ $ad['model_id'] == $model['id'] ? 'selected' : '' }}
                                                                data-brand-id="{{ $model->brand_id }}"
                                                                data-category-id="{{ $model->category_id }}"
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
                                                                <option
                                                                    {{ $ad['color'] == $color['name'] ? 'selected' : '' }}
                                                                    value="{{$color->name}}">
                                                                    {{$color->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="year">{{translate('year')}}</label>
                                                        <input type="number" min="1950" max="2025"  id="year" class="form-control" value="{{$ad->year}}" 
                                                        name="year" placeholder="{{translate('year')}}">
                                                    </div>
                                                </div>


                                                <div class="col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="ad_status">{{translate('ad_status')}}</label>
                                                        <select class="form-control" name="ad_status" id="ad_status">
                                                            <option {{ $ad['ad_status'] == 'never_used' ? 'selected' : '' }} value="never_used">never used</option>
                                                            <option {{ $ad['ad_status'] == 'new' ? 'selected' : '' }} value="new">new</option>
                                                            <option {{ $ad['ad_status'] == 'used' ? 'selected' : '' }} value="used">used</option>
                                                            <option {{ $ad['ad_status'] == 'old' ? 'selected' : '' }} value="old">old</option>
                                                            <option {{ $ad['ad_status'] == 'very_old' ? 'selected' : '' }} value="very_old">very old</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="engine_type">{{translate('engine_type')}}</label>
                                                        <select class="form-control" name="engine_type" id="engine_type">
                                                            <option {{ $ad['engine_type'] == 'gasoil' ? 'selected' : '' }} value="gasoil">gasoil</option>
                                                            <option {{ $ad['engine_type'] == 'diesel' ? 'selected' : '' }} value="diesel">new</option>
                                                            <option {{ $ad['engine_type'] == 'electric' ? 'selected' : '' }} value="electric">electric</option>
                                                            <option {{ $ad['engine_type'] == 'gas' ? 'selected' : '' }} value="gas">gas</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="mileage">{{translate('mileage')}}</label>
                                                        <input type="number" id="mileage" class="form-control" value="{{$ad->mileage}}" name="mileage" placeholder="{{translate('mileage')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="transmission_type">{{translate('transmission_type')}}</label>
                                                        <select class="form-control" name="transmission_type" id="transmission_type">
                                                            <option {{ $ad['transmission_type'] == 'automatic' ? 'selected' : '' }} value="automatic">automatic</option>
                                                            <option {{ $ad['transmission_type'] == 'manually' ? 'selected' : '' }} value="manually">manually</option>
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
                                                                    data-old="{{ asset('public/storage/ad/thumbnail')}}/{{$ad->thumbnail }}" {{-- this is key for JS to read the old image --}}
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
                                                                        data-old="{{ asset('public/storage/ad')}}/{{$image}}"
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

                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('price_details') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group mb-2">
                                                        <label for="purchase_type">{{translate('purchase_type')}}</label>
                                                        <select class="form-control" name="purchase_type" id="purchase_type">
                                                            <option {{ $ad['purchase_type'] == 'fixed_price' ? 'selected' : '' }} value="fixed_price">{{ translate('fixed_price') }}</option>
                                                            <option {{ $ad['purchase_type'] == 'auction' ? 'selected' : '' }} value="auction">{{ translate('auction') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="starting-price-box" class="col-sm-6 @if($ad->purchase_type == 'fixed_price') d-none @endif">
                                                    <div class="form-group mb-2">
                                                        <label for="starting_price">{{translate('starting_price')}}</label>
                                                        <input type="number" id="starting_price" class="form-control" value="{{$ad->starting_price}}" name="starting_price" placeholder="{{translate('starting_price')}}">
                                                    </div>
                                                </div>
                                                <div id="price-box" class="col-sm-6 @if($ad->purchase_type == 'auction') d-none @endif">
                                                    <div class="form-group">
                                                        <label for="price">{{translate('price')}}</label>
                                                        <input type="number" id="price" class="form-control" value="{{$ad->price}}" name="price" placeholder="{{translate('price')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('ad_dimensions_and_sizes') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="body_type">{{translate('body_type')}}</label>
                                                        <select class="form-control" name="body_type" id="body_type">
                                                            <option {{ $ad['body_type'] == 'suv' ? 'selected' : '' }} value="suv">suv</option>
                                                            <option {{ $ad['body_type'] == 'sedan' ? 'selected' : '' }} value="sedan">sedan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="length">{{translate('length')}}</label>
                                                        <input type="text" id="length" class="form-control" value="{{$ad->length}}" name="length" placeholder="{{translate('mileage')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="height">{{translate('height')}}</label>
                                                        <input type="text" id="height" class="form-control" value="{{$ad->height}}" name="height" placeholder="{{translate('mileage')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="width">{{translate('width')}}</label>
                                                        <input type="text" id="width" class="form-control" value="{{$ad->width}}" name="width" placeholder="{{translate('mileage')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="max_weight">{{translate("max_weight")}}</label>
                                                        <input type="text" id="max_weight" class="form-control" value="{{$ad->max_weight}}" name="max_weight" placeholder="{{translate('mileage')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="bag_capacity">{{translate("bag_capacity")}}</label>
                                                        <input type="text" id="bag_capacity" class="form-control" value="{{$ad->bag_capacity}}" name="bag_capacity" placeholder="{{translate('mileage')}}">
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
                                                        <input type="text" id="co2_emissions" class="form-control" value="{{$ad->co2_emissions}}" name="co2_emissions" placeholder="{{translate('co2_emissions')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="energy_consumption">{{translate('energy_consumption')}} ({{ translate('litre_on_ kilometre') }})</label>
                                                        <input type="text" id="energy_consumption" class="form-control" value="{{$ad->energy_consumption}}" name="energy_consumption" placeholder="{{translate('energy_consumption')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="gas_emission_tax">{{translate('gas_emission_tax')}}</label>
                                                        <input type="text" id="gas_emission_tax" class="form-control" value="{{$ad->gas_emission_tax}}" name="gas_emission_tax" placeholder="{{translate('gas_emission_tax')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-3" >
                                                <h2>{{ translate('ad_options') }}</h2>
                                            </div>

                                            @php
                                                $options = [
                                                    'abs', 'airbags', 'air_conditioning', 'alloy_wheels', 'android_auto', 'apple_carplay',
                                                    'automatic_climate_control', 'backup_camera', 'blind_spot_monitor', 'bluetooth', 'cd_player',
                                                    'central_locking', 'cruise_control', 'daytime_running_lights', 'electric_mirrors',
                                                    'electric_windows', 'fog_lights', 'gps', 'heated_seats', 'hill_start_assist', 'keyless_entry',
                                                    'lane_departure_warning', 'leather_seats', 'led_headlights', 'multifunction_steering_wheel',
                                                    'parking_sensors', 'power_steering', 'rear_ac_vents', 'remote_start', 'reversing_camera',
                                                    'roof_rails', 'sunroof', 'tpms', 'touchscreen_display', 'traction_control', 'usb_ports',
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
                                                                name="options[{{ $option }}]"
                                                                value="true"
                                                                {{ filter_var($saved_options[$option] ?? false, FILTER_VALIDATE_BOOLEAN) ? 'checked' : '' }}
                                                            >
                                                            <label class="m-0" for="{{ $option }}">{{ translate($option) }}</label>
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
                                                        <input type="date" id="previous_scan_date" class="form-control" value="{{$ad->previous_scan_date}}" name="previous_scan_date" placeholder="{{translate('previous_scan_date')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="battery_charging_time">{{translate("battery_charging_time")}}</label>
                                                        <input type="text" id="battery_charging_time" class="form-control" value="{{$ad->battery_charging_time}}" name="battery_charging_time" placeholder="{{translate('battery_charging_time')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="fast_battery_charging_time">{{translate("fast_battery_charging_time")}}</label>
                                                        <input type="text" id="fast_battery_charging_time" class="form-control" value="{{$ad->fast_battery_charging_time}}" name="fast_battery_charging_time" placeholder="{{translate('battery_charging_time')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="battery_life">{{translate("battery_life")}}</label>
                                                        <input type="text" id="battery_life" class="form-control" value="{{$ad->battery_life}}" name="battery_life" placeholder="{{translate('battery_life')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="acceleration_0_100">{{translate("acceleration_0_100")}}</label>
                                                        <input type="text" id="acceleration_0_100" class="form-control" value="{{$ad->acceleration_0_100}}" name="acceleration_0_100" placeholder="{{translate('acceleration_0_100')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="mb-2" >
                                                <h2>{{ translate('meta_informations') }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-2">
                                                        <label for="meta_title">{{translate("meta_title")}}</label>
                                                        <input type="text" id="meta_title" class="form-control" value="{{$ad->meta_title}}" name="meta_title" placeholder="{{translate('meta_title')}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>{{translate('meta_image')}}</label>
                                                        <div class="d-flex flex-column gap-3">
                                                            <div class="upload-file">
                                                                <input type="file" 
                                                                class="upload-file__input meta_image" 
                                                                name="meta_image" 
                                                                aria-required="true" 
                                                                data-old="{{ asset('storage/app/public/ad/meta')}}/{{$ad->meta_image }}"
                                                                accept="image/*">
                                                                <div class="upload-file__img">
                                                                    <div class="temp-img-box">
                                                                        <div class="d-flex align-items-center flex-column gap-2">
                                                                            <i class="bi bi-upload fs-30"></i>
                                                                            <div class="fs-12 text-muted">{{translate('ad_meta_image')}}</div>
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
                                                <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
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

        (function ($) {

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

            $(window).on("load", function () {
                let input = $(".upload-file__input.meta_image");
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

        })(jQuery);


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


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.remove-image-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const uploadFileDiv = btn.closest('.upload-file');
                    if (uploadFileDiv) {
                        uploadFileDiv.remove(); // Remove from DOM so it's not sent in the form
                    }
                });
            });
        });
    </script>

    <script>
        function initAutocomplete() {
            // Europe center coordinates (roughly centered on Germany/Central Europe)
            let myLatLng = { lat: 50.1109, lng: 8.6821 };
            
            // Initialize the map focused on Europe
            const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                center: myLatLng,
                zoom: 4, // Zoom level to show most of Europe
                mapTypeId: "roadmap",
            });

            // Initialize marker as null - no initial marker
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
                
                // Determine what to search based on what fields are filled
                if (city && postalCode) {
                    searchQuery = `${postalCode}, ${city}, ${country}`;
                } else if (city) {
                    searchQuery = `${city}, ${country}`;
                } else if (postalCode) {
                    searchQuery = `${postalCode}, ${country}`;
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
                        if (postalCode && document.getElementById('postal-code')) {
                            document.getElementById('postal-code').value = postalCode;
                        }
                    }
                });
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
                
                let searchMarkers = [];
                
                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();
                    
                    if (places.length == 0) return;
                    
                    searchMarkers.forEach(marker => marker.setMap(null));
                    searchMarkers = [];
                    
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








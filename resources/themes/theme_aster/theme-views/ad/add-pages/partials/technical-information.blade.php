<div class="mb-1 border px-3 py-3 pb-4 rounded custom-gray-border-color" >
    <div class="mb-2" >
        <h2 class="mb-3" >{{ $selected_category->slug === 'bicycles' ? translate('bicycles_details') :  translate('technical_informations')}}</h2>
    </div>
    <div class="row">
        <input type="hidden" name="category_id" value="{{$data['category_id']}}">
        <div class="col-xl-4 mb-3">
            <div class="form-group">
                <label for="category">{{translate('category')}}</label>
                <select class="form-control" id="category" disabled>
                    <option value=""> -- {{ translate('choose_category') }} --</option>
                    @foreach($categories as $category)
                        <option data-is-vehicle="{{\App\Model\Category::where('id', $category->parent_id)->exists() && 
                            \App\Model\Category::where('id', $category->parent_id)->first()->name == 'Vehicles' 
                                ? 1 
                            : 0}}" {{ $category['id'] == $data['category_id'] ? 'selected' : ''}} value="{{ $category->id }}">{{ $category->name }}</option>
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
                        <option {{ $brand['id'] == ($data['brand_id'] ?? '') || $brand['id'] == old('brand_id') ? 'selected' : ''}} 
                        value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                    <option value="other" >{{ translate('other_brand') }}</option>
                </select>
            </div>
        </div>
        @if($selected_category->slug !== 'bicycles')
            <div class="col-xl-4 mb-3 mt-2 mt-sm-0">
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
        @endif
        <div class="col-xl-4 mt-1 mt-sm-0">
            <div class="form-group">
                <label for="status">{{translate('status')}}</label>
                <select class="form-control" name="status" id="status">
                    <option value="never_used">{{translate('never_used')}}</option>
                    <option {{ old('status') == 'new' ? 'selected' : ''}} value="new">{{translate('new')}}</option>
                    <option {{ old('status') == 'used' ? 'selected' : ''}} value="used">{{translate('used')}}</option>
                    <option {{ old('status') == 'old' ? 'selected' : ''}} value="old">{{translate('old')}}</option>
                </select>
            </div>
        </div>
        @if($selected_category->slug !== 'vehicle-accessories' && $selected_category->slug !== 'spare-parts'
        && $selected_category->slug !== 'bicycles')
            <div class="col-xl-4 mt-2 mt-sm-0">
                <div class="form-group">
                    <label for="year">{{translate('year')}}</label>
                    <input type="number" min="1950" max="2025"  id="year" class="form-control" value="{{old('year')}}" 
                    name="year" placeholder="{{translate('year')}}">
                </div>
            </div>
        @endif
        @if($selected_category->slug !== 'vehicle-accessories' && $selected_category->slug !== 'spare-parts'
        && $selected_category->slug !== 'bicycles')
            <div class="col-xl-4 mt-2 mt-sm-0">
                <div class="form-group">
                    <label for="mileage">{{translate('mileage')}}</label>
                    <input type="number" id="mileage" class="form-control" value="{{old('mileage')}}" name="mileage" 
                    placeholder="{{translate('mileage')}}">
                </div>
            </div>
        @endif

        @if($selected_category->slug == 'bicycles')
            <div class="col-xl-4 mb-3">
                <div class="form-group">
                    <label for="bicycle_type">{{translate('bicycle_type')}}</label>
                    <select class="form-control" name="bicycle_type" id="bicycle_type">
                        <option value=""> -- {{ translate('choose_bicycle_type') }} -- </option>
                        @foreach($list_values->where('list_name', 'bicycle_types')->sortBy('priority') as $list_value)
                            <option {{ old('bicycle_type') == $list_value['value'] ? 'selected' : '' }} value="{{$list_value->value}}">{{translate($list_value->value)}}</option>
                        @endforeach
                        <option {{ old('bicycle_type') == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                        {{--
                            <option {{ old('bicycle_type') == 'road' ? 'selected' : ''}} value="road">{{ translate('road') }}</option>
                            <option {{ old('bicycle_type') == 'mountain' ? 'selected' : ''}} value="mountain">{{ translate('mountain') }}</option>
                            <option {{ old('bicycle_type') == 'hybrid' ? 'selected' : ''}} value="hybrid">{{ translate('hybrid') }}</option>
                            <option {{ old('bicycle_type') == 'cruiser' ? 'selected' : ''}} value="cruiser">{{ translate('cruiser') }}</option>
                            <option {{ old('bicycle_type') == 'bmx' ? 'selected' : ''}} value="bmx">{{ translate('bmx') }}</option>
                            <option {{ old('bicycle_type') == 'folding' ? 'selected' : ''}} value="folding">{{ translate('folding') }}</option>
                            <option {{ old('bicycle_type') == 'electric' ? 'selected' : ''}} value="electric">{{ translate('electric') }}</option>
                            <option {{ old('bicycle_type') == 'tandem' ? 'selected' : ''}} value="tandem">{{ translate('tandem') }}</option>
                            <option {{ old('bicycle_type') == 'track' ? 'selected' : ''}} value="track">{{ translate('track') }}</option>
                            <option {{ old('bicycle_type') == 'fat_tire' ? 'selected' : ''}} value="fat_tire">{{ translate('fat_tire') }}</option>
                            <option {{ old('bicycle_type') == 'fixed_gear' ? 'selected' : ''}} value="fixed_gear">{{ translate('fixed_gear') }}</option>
                            <option {{ old('bicycle_type') == 'gravel' ? 'selected' : ''}} value="gravel">{{ translate('gravel') }}</option>
                            <option {{ old('bicycle_type') == 'kids' ? 'selected' : ''}} value="kids">{{ translate('kids') }}</option>
                        --}}
                    </select>                
                </div>
            </div>
            <div class="col-xl-4 mb-3">
                <div class="form-group">
                    <label for="bicycle_size">{{translate('bicycle_size')}}</label>
                    <select class="form-control" name="bicycle_size" id="bicycle_size">
                        <option value=""> -- {{ translate('choose_bicycle_size') }} -- </option>
                        <option {{ old('bicycle_size') == '12' ? 'selected' : ''}} value="12">12</option>
                        <option {{ old('bicycle_size') == '14' ? 'selected' : ''}} value="14">14</option>
                        <option {{ old('bicycle_size') == '16' ? 'selected' : ''}} value="16">16</option>
                        <option {{ old('bicycle_size') == '18' ? 'selected' : ''}} value="18">18</option>
                        <option {{ old('bicycle_size') == '20' ? 'selected' : ''}} value="20">20</option>
                        <option {{ old('bicycle_size') == '24' ? 'selected' : ''}} value="24">24</option>
                        <option {{ old('bicycle_size') == '26' ? 'selected' : ''}} value="26">26</option>
                        <option {{ old('bicycle_size') == '27.5' ? 'selected' : ''}} value="27.5">27.5</option>
                        <option {{ old('bicycle_size') == '28' ? 'selected' : ''}} value="28">28</option>
                        <option {{ old('bicycle_size') == '29' ? 'selected' : ''}} value="29">29</option>
                        <option {{ old('bicycle_size') == 'xs' ? 'selected' : ''}} value="xs">xs</option>
                        <option {{ old('bicycle_size') == 's' ? 'selected' : ''}} value="s">s</option>
                        <option {{ old('bicycle_size') == 'm' ? 'selected' : ''}} value="m">m</option>
                        <option {{ old('bicycle_size') == 'l' ? 'selected' : ''}} value="l">l</option>
                        <option {{ old('bicycle_size') == 'xl' ? 'selected' : ''}} value="xl">xl</option>
                    </select>                
                </div>
            </div>
        @endif
        
        <div style="width:100%;height: 1px;border-bottom: 1px solid #cccccc85;margin: 35px 0 28px;" ></div>

        @if($selected_category->slug !== 'bicycles' && $selected_category->slug !== 'motorcycles' &&
        $selected_category->slug !== 'vehicle-accessories' && $selected_category->slug !== 'spare-parts'
        && $selected_category->slug !== 'caravans' && $selected_category->slug !== 'motorhomes')
            <div class="col-xl-4 mb-3">
                <div class="form-group">
                    <label for="body_type">{{translate('body_type')}}</label>
                    <select class="form-control" name="body_type" id="body_type">
                        <option value=""> -- {{translate('choose_body_type')}} -- </option>
                        @foreach($list_values->where('list_name', 'body_types')->sortBy('priority') as $list_value)
                            <option {{ old('body_type') == $list_value['value'] ? 'selected' : '' }} value="{{$list_value->value}}">{{translate($list_value->value)}}</option>
                        @endforeach
                        <option {{ old('body_type') == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                        {{--
                            <option {{ old('body_type') == 'compact' ? 'selected' : ''}} value="compact">{{translate('compact')}}</option>
                            <option {{ old('body_type') == 'suv_off_road' ? 'selected' : ''}} value="suv_off_road">{{translate('suv_off_Road')}}</option>
                            <option {{ old('body_type') == 'sedan' ? 'selected' : ''}} value="sedan">{{translate('sedan')}}</option>
                            <option {{ old('body_type') == 'convertible' ? 'selected' : ''}} value="convertible">{{translate('convertible')}}</option>
                            <option {{ old('body_type') == 'coupe' ? 'selected' : ''}} value="coupe">{{translate('coupe')}}</option>
                            <option {{ old('body_type') == 'hatchback' ? 'selected' : ''}} value="hatchback">{{translate('hatchback')}}</option>
                            <option {{ old('body_type') == 'station_wagon' ? 'selected' : ''}} value="station_wagon">{{translate('station_wagon')}}</option>
                            <option {{ old('body_type') == 'van' ? 'selected' : ''}} value="van">{{translate('van')}}</option>
                            <option {{ old('body_type') == 'transporter' ? 'selected' : ''}} value="transporter">{{translate('transporter')}}</option>                        
                        --}}
                    </select>
                </div>
            </div>
        @endif
        @if($selected_category->slug !== 'vehicle-accessories' && $selected_category->slug !== 'spare-parts'
        && $selected_category->slug !== 'bicycles')
            <div class="col-xl-4 mb-3">
                <div class="form-group">
                    <label for="fuel_type">{{translate('fuel_type')}}</label>
                    <select class="form-control" name="fuel_type" id="fuel_type">
                        <option value=""> -- {{translate('choose_engine_type')}} -- </option>
                        @foreach($list_values->where('list_name', 'fuel_types')->sortBy('priority') as $list_value)
                            <option {{ old('fuel_type') == $list_value['value'] ? 'selected' : '' }} value="{{$list_value->value}}">
                                {{translate($list_value->value)}}
                            </option>
                        @endforeach
                        <option {{ old('fuel_type') == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                        {{--
                            <option {{ old('fuel_type') == 'petrol_gasoline' ? 'selected' : ''}} value="petrol_gasoline">{{translate('petrol_gasoline')}}</option>
                            <option {{ old('fuel_type') == 'diesel' ? 'selected' : ''}} value="diesel">{{translate('diesel')}}</option>
                            <option {{ old('fuel_type') == 'electric_ev' ? 'selected' : ''}} value="electric_ev">{{translate('electric_ev')}}</option>
                            <option {{ old('fuel_type') == 'hybrid' ? 'selected' : ''}} value="hybrid">{{translate('hybrid')}}</option>
                            <option {{ old('fuel_type') == 'Plug_in_hybrid_phev' ? 'selected' : ''}} value="Plug_in_hybrid_phev">{{translate('Plug_in_hybrid_phev')}}</option>
                            <option {{ old('fuel_type') == 'lpg' ? 'selected' : ''}} value="lpg">{{translate('lpg')}}</option>
                            <option {{ old('fuel_type') == 'cng' ? 'selected' : ''}} value="cng">{{translate('cng')}}</option>
                            <option {{ old('fuel_type') == 'hydrogen_fcev' ? 'selected' : ''}} value="hydrogen_fcev">{{translate('hydrogen_fcev')}}</option>
                            <option {{ old('fuel_type') == 'flex_fuel' ? 'selected' : ''}} value="flex_fuel">{{translate('flex_fuel')}}</option>
                            <option {{ old('fuel_type') == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                        --}}
                    </select>
                </div>
            </div>
        @endif


        @if($selected_category->slug !== 'bicycles' && $selected_category->slug !== 'vehicle-accessories' && $selected_category->slug !== 'spare-parts')
            <div class="col-xl-4 mb-3">
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
        @endif
        @if($selected_category->slug !== 'bicycles' && $selected_category->slug !== 'vehicle-accessories' && $selected_category->slug !== 'spare-parts')
            <div class="col-xl-4 mb-3">
                <div class="form-group">
                    <label for="engine-cylinders">{{translate('cylinders')}}</label>
                    <select class="form-control" name="engine_cylinders" id="engine-cylinders">
                        <option value=""> -- {{translate('choose_cylinder_number')}} -- </option>
                        <option {{ old('engine_cylinders') == '1' ? 'selected' : ''}} value="1">1</option>
                        <option {{ old('engine_cylinders') == '2' ? 'selected' : ''}} value="2">2</option>
                        <option {{ old('engine_cylinders') == '3' ? 'selected' : ''}} value="3">3</option>
                        <option {{ old('engine_cylinders') == '4' ? 'selected' : ''}} value="4">4</option>
                        <option {{ old('engine_cylinders') == '6' ? 'selected' : ''}} value="6">6</option>
                        <option {{ old('engine_cylinders') == '8' ? 'selected' : ''}} value="8">8</option>
                        <option {{ old('engine_cylinders') == '10' ? 'selected' : ''}} value="10">10</option>
                        <option {{ old('engine_cylinders') == '12' ? 'selected' : ''}} value="12">12</option>
                        <option {{ old('engine_cylinders') == '16' ? 'selected' : ''}} value="16">16</option>
                        <option {{ old('engine_cylinders') == '18' ? 'selected' : ''}} value="18">18</option>
                        <option {{ old('engine_cylinders') == 'other' ? 'selected' : '' }} value="other">{{translate('other')}}</option>
                    </select>
                </div>
            </div>                                                    
        @endif
        @if($selected_category->slug !== 'bicycles' && $selected_category->slug !== 'vehicle-accessories' && $selected_category->slug !== 'spare-parts')
            <div class="col-xl-4 mb-3">
                <div class="form-group">
                    <label for="transmission_type">{{translate('transmission_type')}}</label>
                    <select class="form-control" name="transmission_type" id="transmission_type">
                        @foreach($list_values->where('list_name', 'transmission_types')->sortBy('priority') as $list_value)
                            <option {{ old('transmission_type') == $list_value['value'] ? 'selected' : '' }} value="{{$list_value->value}}">
                                {{translate($list_value->value)}}
                            </option>
                        @endforeach
                        <option {{ old('transmission_type') == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                        {{--
                            <option {{ old('transmission_type') == 'automatic' ? 'selected' : ''}} value="automatic">{{translate('automatic')}}</option>
                            <option {{ old('transmission_type') == 'semi_automatic' ? 'selected' : ''}} value="semi_automatic">{{translate('semi_automatic')}}</option>
                            <option {{ old('transmission_type') == 'manually' ? 'selected' : ''}} value="manually">{{translate('manually')}}</option>
                        --}}
                    </select>
                </div>
            </div>
        @endif
        @if($selected_category->slug !== 'vehicle-accessories' && $selected_category->slug !== 'spare-parts'
        && $selected_category->slug !== 'bicycles')
            <div class="col-xl-4 mb-3">
                <div class="form-group">
                    <label for="engine-power">{{translate('power')}}</label>
                    <input type="text" id="engine-power" class="form-control" value="{{old('engine_power')}}" name="engine_power" placeholder="{{translate('Ex:300hp (224kW)')}}">
                </div>
            </div>
        @endif
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
                        <option value="{{$color}}" data-color="{{$color}}" {{ old('color') == $color ? 'selected' : '' }}>
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
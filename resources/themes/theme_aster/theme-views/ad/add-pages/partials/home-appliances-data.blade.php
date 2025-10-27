<div class="row mb-1 border px-3 py-3 ms-0 mt-4 rounded custom-gray-border-color" >
    <div class="mb-3" >
        <h2>{{ translate('product_details') }}</h2>
    </div>

    <input type="hidden" name="category_id" value="{{$data['category_id']}}">
    <div class="col-xl-4 mb-3">
        <div class="form-group">
            <label for="category">{{translate('category')}}</label>
            <select class="form-control" name="category_id" id="category" disabled>
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

    <div class="col-sm-4 mb-2">
        <div class="form-group mb-2">
            <label for="home_appliances_type">{{ translate('type') }}</label>
            <select class="form-control" name="home_appliance_type" id="home_appliance_type">

                <option value=""> -- {{ translate('choose_home_appliance_type') }} -- </option>
                @foreach($list_values->where('list_name', 'home_appliance_types')->sortBy('priority') as $list_value)
                    <option {{ old('home_appliance_type') == $list_value['value'] ? 'selected' : '' }} value="{{$list_value->value}}">
                        {{translate($list_value->value)}}
                    </option>
                @endforeach
                <option {{ old('home_appliance_type') == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                
                {{--
                    <option {{ old('home_appliance_type') == 'refrigerator' ? 'selected' : ''}} value="refrigerator">{{ translate('refrigerator') }}</option>
                    <option {{ old('home_appliance_type') == 'washing_machine' ? 'selected' : ''}} value="washing_machine">{{ translate('washing_machine') }}</option>
                    <option {{ old('home_appliance_type') == 'microwave' ? 'selected' : ''}} value="microwave">{{ translate('microwave') }}</option>
                    <option {{ old('home_appliance_type') == 'oven' ? 'selected' : ''}} value="oven">{{ translate('oven') }}</option>
                    <option {{ old('home_appliance_type') == 'dishwasher' ? 'selected' : ''}} value="dishwasher">{{ translate('dishwasher') }}</option>
                    <option {{ old('home_appliance_type') == 'freezer' ? 'selected' : ''}} value="freezer">{{ translate('freezer') }}</option>
                    <option {{ old('home_appliance_type') == 'cooker' ? 'selected' : ''}} value="cooker">{{ translate('cooker') }}</option>
                    <option {{ old('home_appliance_type') == 'air_conditioner' ? 'selected' : ''}} value="air_conditioner">{{ translate('air_conditioner') }}</option>
                    <option {{ old('home_appliance_type') == 'vacuum_cleaner' ? 'selected' : ''}} value="vacuum_cleaner">{{ translate('vacuum_cleaner') }}</option>
                    <option {{ old('home_appliance_type') == 'water_dispenser' ? 'selected' : ''}} value="water_dispenser">{{ translate('water_dispenser') }}</option>
                    <option {{ old('home_appliance_type') == 'fan' ? 'selected' : ''}} value="fan">{{ translate('fan') }}</option>
                    <option {{ old('home_appliance_type') == 'heater' ? 'selected' : ''}} value="heater">{{ translate('heater') }}</option>
                    <option {{ old('home_appliance_type') == 'water_heater' ? 'selected' : ''}} value="water_heater">{{ translate('water_heater') }}</option>
                    <option {{ old('home_appliance_type') == 'coffee_machine' ? 'selected' : ''}} value="coffee_machine">{{ translate('coffee_machine') }}</option>
                    <option {{ old('home_appliance_type') == 'blender' ? 'selected' : ''}} value="blender">{{ translate('blender') }}</option>
                    <option {{ old('home_appliance_type') == 'toaster' ? 'selected' : ''}} value="toaster">{{ translate('toaster') }}</option>
                    <option {{ old('home_appliance_type') == 'other' ? 'selected' : ''}} value="other">{{ translate('other') }}</option>
                --}}
            </select>
        </div>
    </div>

    <div class="col-xl-4 mt-2 mt-sm-0">
        <div class="form-group">
            <label for="brand">{{translate('brand')}}</label>
            <input type="text" class="form-control" value="{{old('brand')}}" name="custom_brand" placeholder="{{translate('brand')}}">
        </div>
    </div>

    <div class="col-xl-4 mt-1 mt-sm-0">
        <div class="form-group">
            <label for="status">{{translate('status')}}</label>
            <select class="form-control" name="status" id="status">
                <option value="never_used">{{translate('never_used')}}</option>
                <option {{ old('ad_status') == 'new' ? 'selected' : ''}} value="new">{{translate('new')}}</option>
                <option {{ old('ad_status') == 'used' ? 'selected' : ''}} value="used">{{translate('used')}}</option>
                <option {{ old('ad_status') == 'old' ? 'selected' : ''}} value="old">{{translate('old')}}</option>
            </select>
        </div>
    </div>

</div>
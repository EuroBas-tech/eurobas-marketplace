<div class="row mb-1 border px-3 py-3 ms-0 mt-4 rounded custom-gray-border-color" >
    <div class="mb-3" >
        <h2>{{ translate('property_details') }}</h2>
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
            <label for="listing_type">{{ translate('listing_type') }}</label>
            <select class="form-control" name="listing_type" id="listing_type">
                <option value=""> -- {{ translate('choose_listing_type') }} -- </option>
                @foreach($list_values->where('list_name', 'listing_types')->sortBy('priority') as $list_value)
                    <option {{ old('listing_type') == $list_value['value'] ? 'selected' : '' }} value="{{$list_value->value}}">
                        {{translate($list_value->value)}}
                    </option>
                @endforeach
                <option {{ old('listing_type') == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                {{--
                    <option {{ old('listing_type') == 'for_sale' ? 'selected' : ''}} value="for_sale">{{ translate('for_sale') }}</option>
                    <option {{ old('listing_type') == 'for_rent' ? 'selected' : ''}} value="for_rent">{{ translate('for_rent') }}</option>
                    <option {{ old('listing_type') == 'for_exchange' ? 'selected' : ''}} value="for_exchange">{{ translate('for_exchange') }}</option>
                    <option {{ old('listing_type') == 'for_takeover' ? 'selected' : ''}} value="for_takeover">{{ translate('for_takeover') }}</option>
                --}}
            </select>
        </div>
    </div>
    
    <div class="col-sm-4 mb-2">
        <div class="form-group mb-2">
            <label for="property_type">{{ translate('property_type') }}</label>
            <select class="form-control" name="property_type" id="property_type">
                <option value=""> -- {{ translate('choose_property_type') }} -- </option>

                @foreach($list_values->where('list_name', 'property_types')->sortBy('priority') as $list_value)
                    <option {{ old('property_type') == $list_value['value'] ? 'selected' : '' }} value="{{$list_value->value}}">
                        {{translate($list_value->value)}}
                    </option>
                @endforeach
                <option {{ old('property_type') == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                {{--
                    <option {{ old('property_type') == 'apartment' ? 'selected' : ''}} value="apartment">{{ translate('apartment') }}</option>
                    <option {{ old('property_type') == 'villa' ? 'selected' : ''}} value="villa">{{ translate('villa') }}</option>
                    <option {{ old('property_type') == 'house' ? 'selected' : ''}} value="house">{{ translate('house') }}</option>
                    <option {{ old('property_type') == 'detached_house' ? 'selected' : ''}} value="detached_house">{{ translate('detached_house') }}</option>
                    <option {{ old('property_type') == 'land' ? 'selected' : ''}} value="land">{{ translate('land') }}</option>
                    <option {{ old('property_type') == 'farm' ? 'selected' : ''}} value="farm">{{ translate('farm') }}</option>
                    <option {{ old('property_type') == 'shop' ? 'selected' : ''}} value="shop">{{ translate('shop') }}</option>
                    <option {{ old('property_type') == 'office' ? 'selected' : ''}} value="office">{{ translate('office') }}</option>
                    <option {{ old('property_type') == 'warehouse' ? 'selected' : ''}} value="warehouse">{{ translate('warehouse') }}</option>
                    <option {{ old('property_type') == 'building' ? 'selected' : ''}} value="building">{{ translate('building') }}</option>
                    <option {{ old('property_type') == 'room' ? 'selected' : ''}} value="room">{{ translate('room') }}</option>
                    <option {{ old('property_type') == 'chalet_holiday_home' ? 'selected' : ''}} value="chalet_holiday_home">{{ translate('chalet_holiday_home') }}</option>
                    <option {{ old('property_type') == 'commercial_property' ? 'selected' : ''}} value="commercial_property">{{ translate('commercial_property') }}</option>
                    <option {{ old('property_type') == 'industrial_property' ? 'selected' : ''}} value="industrial_property">{{ translate('industrial_property') }}</option>
                    <option {{ old('property_type') == 'other' ? 'selected' : ''}} value="other">{{ translate('other') }}</option>
                --}}
            </select>
        </div>
    </div>

    <div class="col-xl-4 mt-2 mt-sm-0">
        <div class="form-group">
            <label for="property_size">{{translate('property_size')}}</label>
            <input type="text" class="form-control" value="{{old('property_size')}}" name="property_size" placeholder="{{translate('property_size')}}">
        </div>
    </div>

    <div class="col-xl-4 mb-3">
        <div class="form-group">
            <label for="floor">{{ translate('floor') }}</label>
            <select class="form-control" name="floor" id="floor">
                <option value=""> -- {{ translate('choose_floor') }} -- </option>
                <option {{ old('floor') == 'basement' ? 'selected' : ''}} value="basement">{{ translate('basement') }}</option>
                <option {{ old('floor') == 'ground' ? 'selected' : ''}} value="ground">{{ translate('ground') }}</option>
                @for ($i = 1; $i <= 30; $i++)
                    <option {{ old('floor') == "$i" ? 'selected' : ''}} value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
    </div>

    <div class="col-xl-4 mb-3">
        <div class="form-group">
            <label for="rooms_number">{{translate('number_of_rooms')}}</label>
            <select class="form-control" name="rooms_number" id="rooms_number">
                <option value=""> -- {{translate('choose_number_of_rooms')}} -- </option>
                <option {{ old('number_of_rooms') == '1' ? 'selected' : ''}} value="1">1</option>
                <option {{ old('number_of_rooms') == '2' ? 'selected' : ''}} value="2">2</option>
                <option {{ old('number_of_rooms') == '3' ? 'selected' : ''}} value="3">3</option>
                <option {{ old('number_of_rooms') == '4' ? 'selected' : ''}} value="4">4</option>
                <option {{ old('number_of_rooms') == '5' ? 'selected' : ''}} value="5">5</option>
                <option {{ old('number_of_rooms') == '6' ? 'selected' : ''}} value="6">6</option>
                <option {{ old('number_of_rooms') == '7' ? 'selected' : ''}} value="7">7</option>
                <option {{ old('number_of_rooms') == '8' ? 'selected' : ''}} value="8">8</option>
                <option {{ old('number_of_rooms') == '9' ? 'selected' : ''}} value="9">9</option>
                <option {{ old('number_of_rooms') == '10' ? 'selected' : ''}} value="10">10</option>
                <option {{ old('number_of_rooms') == '11' ? 'selected' : ''}} value="11">11</option>
                <option {{ old('number_of_rooms') == '12' ? 'selected' : ''}} value="12">12</option>
                <option {{ old('number_of_rooms') == '13' ? 'selected' : ''}} value="13">13</option>
                <option {{ old('number_of_rooms') == '14' ? 'selected' : ''}} value="14">14</option>
                <option {{ old('number_of_rooms') == '15' ? 'selected' : ''}} value="15">15</option>
            </select>
        </div>
    </div>

</div>
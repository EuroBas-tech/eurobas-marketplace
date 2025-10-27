<div class="row mb-1 border px-3 py-3 ms-0 mt-4 rounded custom-gray-border-color" >
    <div class="mb-3" >
        <h2>{{ translate('technical_informations') }}</h2>
    </div>

    <input type="hidden" name="category_id" value="{{$ad['category_id']}}">
    <div class="col-xl-4 mb-3">
        <div class="form-group">
            <label for="category">{{translate('category')}}</label>
            <select class="form-control" name="category_id" id="category" disabled>
                <option value=""> -- {{ translate('choose_category') }} --</option>
                @foreach($categories as $category)
                    <option data-is-vehicle="{{\App\Model\Category::where('id', $category->parent_id)->exists() && 
                        \App\Model\Category::where('id', $category->parent_id)->first()->name == 'Vehicles' 
                            ? 1 
                        : 0}}" {{ $category['id'] == $ad['category_id'] ? 'selected' : ''}} value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-4 mb-2">
        <div class="form-group mb-2">
            <label for="type">{{ translate('type') }}</label>
            <select class="form-control" name="shipbuilding_type" id="type">
                <option value=""> -- {{ translate('choose_type') }} -- </option>

                @foreach($list_values->where('list_name', 'shipbuilding_types')->sortBy('priority') as $list_value)
                    <option {{ $ad['shipbuilding_type'] == $list_value['value'] ? 'selected' : ''}} value="{{$list_value->value}}">
                        {{translate($list_value->value)}}
                    </option>
                @endforeach
                <option {{ $ad['shipbuilding_type'] == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                {{--
                    <option {{ $ad['shipbuilding_type'] == 'yacht' ? 'selected' : ''}} value="yacht">{{ translate('yacht') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'fishing_boat' ? 'selected' : ''}} value="fishing_boat">{{ translate('fishing_boat') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'cargo_ship' ? 'selected' : ''}} value="cargo_ship">{{ translate('cargo_ship') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'tanker' ? 'selected' : ''}} value="tanker">{{ translate('tanker') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'container_ship' ? 'selected' : ''}} value="container_ship">{{ translate('container_ship') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'ferry' ? 'selected' : ''}} value="ferry">{{ translate('ferry') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'cruise_ship' ? 'selected' : ''}} value="cruise_ship">{{ translate('cruise_ship') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'speedboat' ? 'selected' : ''}} value="speedboat">{{ translate('speedboat') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'sailboat' ? 'selected' : ''}} value="sailboat">{{ translate('sailboat') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'barge' ? 'selected' : ''}} value="barge">{{ translate('barge') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'tugboat' ? 'selected' : ''}} value="tugboat">{{ translate('tugboat') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'patrol_boat' ? 'selected' : ''}} value="patrol_boat">{{ translate('patrol_boat') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'naval_ship' ? 'selected' : ''}} value="naval_ship">{{ translate('naval_ship') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'submarine' ? 'selected' : ''}} value="submarine">{{ translate('submarine') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'research_vessel' ? 'selected' : ''}} value="research_vessel">{{ translate('research_vessel') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'offshore_support_vessel' ? 'selected' : ''}} value="offshore_support_vessel">{{ translate('offshore_support_vessel') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'dredger' ? 'selected' : ''}} value="dredger">{{ translate('dredger') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'icebreaker' ? 'selected' : ''}} value="icebreaker">{{ translate('icebreaker') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'fireboat' ? 'selected' : ''}} value="fireboat">{{ translate('fireboat') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'pilot_boat' ? 'selected' : ''}} value="pilot_boat">{{ translate('pilot_boat') }}</option>
                    <option {{ $ad['shipbuilding_type'] == 'other' ? 'selected' : ''}} value="other">{{ translate('other') }}</option>
                --}}
            </select>
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


    <div class="col-xl-4 mb-3">
        <div class="form-group">
            <label for="length">{{translate('length')}} ({{ translate('Optional') }})</label>
            <input type="text" id="length" class="form-control" value="{{$ad->length}}" name="length" placeholder="{{translate('Ex: 2.5')}}">
        </div>
    </div>
    
    <div class="col-xl-4 mb-3">
        <div class="form-group">
            <label for="width">{{translate('width')}} ({{ translate('Optional') }})</label>
            <input type="text" id="width" class="form-control" value="{{$ad->width}}" name="width" placeholder="{{translate('Ex: 1.85')}}">
        </div>
    </div>

    <div class="col-xl-4 mt-2 mt-sm-0">
        <div class="form-group">
            <label for="year">{{translate('year_of_manufacture')}}</label>
            <input type="number" min="1950" max="2025"  id="year" class="form-control" value="{{$ad->year}}" 
            name="year" placeholder="{{translate('year_of_manufacture')}}">
        </div>
    </div>

    <div class="col-xl-4 mb-3">
        <div class="form-group">
            <label for="fuel_type">{{translate('fuel_type')}}</label>
            <select class="form-control" name="fuel_type" id="fuel_type">
                <option value=""> -- {{translate('choose_engine_type')}} -- </option>
                @foreach($list_values->where('list_name', 'fuel_types')->sortBy('priority') as $list_value)
                    <option {{ $ad['fuel_type'] == $list_value['value'] ? 'selected' : ''}} value="{{$list_value->value}}">
                        {{translate($list_value->value)}}
                    </option>
                @endforeach
                <option {{ $ad['fuel_type'] == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                {{--
                    <option {{ $ad['fuel_type'] == 'Petrol (Gasoline)' ? 'selected' : ''}} value="Petrol (Gasoline)">{{translate('petrol_gasoline')}}</option>
                    <option {{ $ad['fuel_type'] == 'Diesel' ? 'selected' : ''}} value="Diesel">{{translate('diesel')}}</option>
                    <option {{ $ad['fuel_type'] == 'Electric (EV)' ? 'selected' : ''}} value="Electric (EV)">{{translate('electric_ev')}}</option>
                    <option {{ $ad['fuel_type'] == 'Hybrid' ? 'selected' : ''}} value="Hybrid">{{translate('hybrid')}}</option>
                    <option {{ $ad['fuel_type'] == 'Plug-in Hybrid (PHEV)' ? 'selected' : ''}} value="Plug-in Hybrid (PHEV)">{{translate('Plug_in_hybrid_phev')}}</option>
                    <option {{ $ad['fuel_type'] == 'LPG' ? 'selected' : ''}} value="LPG">{{translate('lpg')}}</option>
                    <option {{ $ad['fuel_type'] == 'CNG' ? 'selected' : ''}} value="CNG">{{translate('cng')}}</option>
                    <option {{ $ad['fuel_type'] == 'Hydrogen (FCEV)' ? 'selected' : ''}} value="Hydrogen (FCEV)">{{translate('hydrogen_fcev')}}</option>
                    <option {{ $ad['fuel_type'] == 'Flex-Fuel' ? 'selected' : ''}} value="Flex-Fuel">{{translate('flex_fuel')}}</option>
                    <option {{ $ad['fuel_type'] == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                --}}
            </select>
        </div>
    </div>

    <div class="col-xl-4 mt-2 mt-sm-0">
        <div class="form-group">
            <label for="maximum_speed">{{translate('maximum_speed')}}</label>
            <input type="number" min="0" max="400"  id="maximum_speed" class="form-control" value="{{$ad->maximum_speed}}" 
            name="maximum_speed" placeholder="{{translate('Ex: 40')}}">
        </div>
    </div>

    <div style="width:100%;height: 1px;border-bottom: 1px solid #cccccc85;margin: 35px 0 28px;" ></div>

    <div class="col-xl-4 mb-3">
        <div class="form-group">
            <label for="engines_number">{{translate('number_of_engines')}}</label>
            <select class="form-control" name="engines_number" id="engines_number">
                <option value=""> -- {{translate('choose_engines_number')}} -- </option>
                <option {{ $ad['engines_number'] == '1' ? 'selected' : ''}} value="1">1</option>
                <option {{ $ad['engines_number'] == '2' ? 'selected' : ''}} value="2">2</option>
                <option {{ $ad['engines_number'] == '3' ? 'selected' : ''}} value="3">3</option>
                <option {{ $ad['engines_number'] == '4' ? 'selected' : ''}} value="4">4</option>
                <option {{ $ad['engines_number'] == '5' ? 'selected' : ''}} value="5">5</option>
                <option {{ $ad['engines_number'] == '6' ? 'selected' : ''}} value="6">6</option>
            </select>
        </div>
    </div>
    
    <div class="col-xl-4 mb-3">
        <div class="form-group">
            <label for="cabins_number">{{translate('number_of_cabins')}}</label>
            <select class="form-control" name="cabins_number" id="cabins_number">
                <option value=""> -- {{translate('choose_cabins_number')}} -- </option>
                <option {{ $ad['cabins_number'] == '1'  ?  'selected' : ''}} value="1">1</option>
                <option {{ $ad['cabins_number'] == '2'  ?  'selected' : ''}} value="2">2</option>
                <option {{ $ad['cabins_number'] == '3'  ?  'selected' : ''}} value="3">3</option>
                <option {{ $ad['cabins_number'] == '4'  ?  'selected' : ''}} value="4">4</option>
                <option {{ $ad['cabins_number'] == '5'  ?  'selected' : ''}} value="5">5</option>
                <option {{ $ad['cabins_number'] == '6'  ?  'selected' : ''}} value="6">6</option>
                <option {{ $ad['cabins_number'] == '7'  ?  'selected' : ''}} value="7">7</option>
                <option {{ $ad['cabins_number'] == '8'  ?  'selected' : ''}} value="8">8</option>
                <option {{ $ad['cabins_number'] == '9'  ?  'selected' : ''}} value="9">9</option>
                <option {{ $ad['cabins_number'] == '10' ? 'selected' : ''}}  value="10">10</option>
                <option {{ $ad['cabins_number'] == '11' ? 'selected' : ''}}  value="11">11</option>
                <option {{ $ad['cabins_number'] == '12' ? 'selected' : ''}}  value="12">12</option>
                <option {{ $ad['cabins_number'] == '13' ? 'selected' : ''}}  value="13">13</option>
                <option {{ $ad['cabins_number'] == '14' ? 'selected' : ''}}  value="14">14</option>
                <option {{ $ad['cabins_number'] == '15' ? 'selected' : ''}}  value="15">15</option>
                <option {{ $ad['cabins_number'] == '16' ? 'selected' : ''}}  value="16">16</option>
                <option {{ $ad['cabins_number'] == '17' ? 'selected' : ''}}  value="17">17</option>
                <option {{ $ad['cabins_number'] == '18' ? 'selected' : ''}}  value="18">18</option>
                <option {{ $ad['cabins_number'] == '19' ? 'selected' : ''}}  value="19">19</option>
                <option {{ $ad['cabins_number'] == '20' ? 'selected' : ''}}  value="20">20</option>
            </select>
        </div>
    </div>
</div>
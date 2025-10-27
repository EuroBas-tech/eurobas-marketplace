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
            <label for="machine_type">{{translate('machine_type')}}</label>
            <select class="form-control" name="machine_type" id="machine_type">
                <option value=""> -- {{ translate('choose_a_machine_type') }} -- </option>
                @foreach($list_values->where('list_name', 'machine_types')->sortBy('priority') as $list_value)
                    <option {{ $ad['machine_type'] == $list_value['value'] ? 'selected' : ''}} value="{{$list_value->value}}">
                        {{translate($list_value->value)}}
                    </option>
                @endforeach
                <option {{ $ad['machine_type'] == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                {{--
                    <option {{ $ad['machine_type'] == 'cutting' ? 'selected' : ''}} value="cutting">{{ translate('cutting') }}</option>
                    <option {{ $ad['machine_type'] == 'forming' ? 'selected' : ''}} value="forming">{{ translate('forming') }}</option>
                    <option {{ $ad['machine_type'] == 'welding' ? 'selected' : ''}} value="welding">{{ translate('welding') }}</option>
                    <option {{ $ad['machine_type'] == 'molding' ? 'selected' : ''}} value="molding">{{ translate('molding') }}</option>
                    <option {{ $ad['machine_type'] == 'machining' ? 'selected' : ''}} value="machining">{{ translate('machining') }}</option>
                    <option {{ $ad['machine_type'] == 'packaging' ? 'selected' : ''}} value="packaging">{{ translate('packaging') }}</option>
                    <option {{ $ad['machine_type'] == 'printing' ? 'selected' : ''}} value="printing">{{ translate('printing') }}</option>
                    <option {{ $ad['machine_type'] == 'assembling' ? 'selected' : ''}} value="assembling">{{ translate('assembling') }}</option>
                    <option {{ $ad['machine_type'] == 'mixing' ? 'selected' : ''}} value="mixing">{{ translate('mixing') }}</option>
                    <option {{ $ad['machine_type'] == 'pressing' ? 'selected' : ''}} value="pressing">{{ translate('pressing') }}</option>
                    <option {{ $ad['machine_type'] == 'extruding' ? 'selected' : ''}} value="extruding">{{ translate('extruding') }}</option>
                    <option {{ $ad['machine_type'] == 'rolling' ? 'selected' : ''}} value="rolling">{{ translate('rolling') }}</option>
                    <option {{ $ad['machine_type'] == 'grinding' ? 'selected' : ''}} value="grinding">{{ translate('grinding') }}</option>
                    <option {{ $ad['machine_type'] == 'polishing' ? 'selected' : ''}} value="polishing">{{ translate('polishing') }}</option>
                    <option {{ $ad['machine_type'] == 'bending' ? 'selected' : ''}} value="bending">{{ translate('bending') }}</option>
                    <option {{ $ad['machine_type'] == 'lifting' ? 'selected' : ''}} value="lifting">{{ translate('lifting') }}</option>
                    <option {{ $ad['machine_type'] == 'conveying' ? 'selected' : ''}} value="conveying">{{ translate('conveying') }}</option>
                    <option {{ $ad['machine_type'] == 'cooling_heating' ? 'selected' : ''}} value="cooling_heating">{{ translate('cooling_heating') }}</option>
                    <option {{ $ad['machine_type'] == 'inspection' ? 'selected' : ''}} value="inspection">{{ translate('inspection') }}</option>
                    <option {{ $ad['machine_type'] == 'cleaning' ? 'selected' : ''}} value="cleaning">{{ translate('cleaning') }}</option>
                    <option {{ $ad['machine_type'] == 'other' ? 'selected' : ''}} value="other">{{ translate('other') }}</option>                    
                --}}
            </select>
        </div>
    </div>

    <div class="col-sm-4 mb-3">
        <div class="form-group">
            <label for="manufacturer">{{translate('manufacturer')}}</label>
            <input type="text" id="manufacturer" class="form-control" value="{{ $ad->manufacturer }}" name="manufacturer" placeholder="{{translate('machine_manufacturer')}}">
        </div>
    </div>
    <div class="col-xl-4 mt-2 mt-sm-0">
        <div class="form-group">
            <label for="year">{{translate('year_of_manufacture')}}</label>
            <input type="number" min="1950" max="2025"  id="year" class="form-control" value="{{$ad->year}}" 
            name="year" placeholder="{{translate('year_of_manufacture')}}">
        </div>
    </div>
    <div class="col-xl-4 mt-1 mt-sm-0">
        <div class="form-group">
            <label for="status">{{translate('status')}}</label>
            <select class="form-control" name="status" id="status">
                <option value="never_used">{{translate('never_used')}}</option>
                <option {{ $ad['ad_status'] == 'new' ? 'selected' : ''}} value="new">{{translate('new')}}</option>
                <option {{ $ad['ad_status'] == 'used' ? 'selected' : ''}} value="used">{{translate('used')}}</option>
                <option {{ $ad['ad_status'] == 'old' ? 'selected' : ''}} value="old">{{translate('old')}}</option>
            </select>
        </div>
    </div>
    <div class="col-sm-4 mb-3">
        <div class="form-group">
            <label for="power_capacity">{{translate('power_capacity')}}</label>
            <input type="text" id="power_capacity" class="form-control" value="{{ $ad->power_capacity }}" name="power_capacity" placeholder="{{translate('power_capacity')}}">
        </div>
    </div>
    <div class="col-xl-4 mt-1 mt-sm-0">
        <div class="form-group">
            <label for="power_source">{{translate('power_source')}}</label>
            <select class="form-control" name="power_source" id="power_source">
                <option value=""> -- {{ translate('choose_a_power_source') }} -- </option>
                @foreach($list_values->where('list_name', 'power_sources')->sortBy('priority') as $list_value)
                    <option {{ $ad['power_source'] == $list_value['value'] ? 'selected' : ''}} value="{{$list_value->value}}">
                        {{translate($list_value->value)}}
                    </option>
                @endforeach
                <option {{ $ad['power_source'] == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                {{--
                    <option {{ $ad['power_source'] == 'electric' ? 'selected' : ''}} value="electric">{{translate('electric')}}</option>
                    <option {{ $ad['power_source'] == 'diesel' ? 'selected' : ''}} value="diesel">{{translate('diesel')}}</option>
                    <option {{ $ad['power_source'] == 'hydraulic' ? 'selected' : ''}} value="hydraulic">{{translate('hydraulic')}}</option>
                --}}
            </select>
        </div>
    </div>
</div>
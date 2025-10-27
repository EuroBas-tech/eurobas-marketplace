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
            <label for="material">{{translate('material')}}</label>
            <select class="form-control" name="material" id="material">
                <option value=""> -- {{ translate('choose_a_home_garden_material') }} -- </option>
                @foreach($list_values->where('list_name', 'home_garden_materials')->sortBy('priority') as $list_value)
                    <option {{ old('material') == $list_value['value'] ? 'selected' : '' }} value="{{$list_value->value}}">
                        {{translate($list_value->value)}}
                    </option>
                @endforeach
                <option {{ old('material') == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                {{--
                    <option {{ old('material') == 'wood' ? 'selected' : ''}} value="wood">{{ translate('wood') }}</option>
                    <option {{ old('material') == 'leather' ? 'selected' : ''}} value="leather">{{ translate('leather') }}</option>
                    <option {{ old('material') == 'fabric' ? 'selected' : ''}} value="fabric">{{ translate('fabric') }}</option>
                    <option {{ old('material') == 'metal' ? 'selected' : ''}} value="metal">{{ translate('metal') }}</option>
                    <option {{ old('material') == 'glass' ? 'selected' : ''}} value="glass">{{ translate('glass') }}</option>
                    <option {{ old('material') == 'plastic' ? 'selected' : ''}} value="plastic">{{ translate('plastic') }}</option>
                    <option {{ old('material') == 'marble' ? 'selected' : ''}} value="marble">{{ translate('marble') }}</option>
                    <option {{ old('material') == 'rattan' ? 'selected' : ''}} value="rattan">{{ translate('rattan') }}</option>
                    <option {{ old('material') == 'bamboo' ? 'selected' : ''}} value="bamboo">{{ translate('bamboo') }}</option>
                    <option {{ old('material') == 'foam' ? 'selected' : ''}} value="foam">{{ translate('foam') }}</option>
                    <option {{ old('material') == 'synthetic' ? 'selected' : ''}} value="synthetic">{{ translate('synthetic') }}</option>
                    <option {{ old('material') == 'other' ? 'selected' : ''}} value="other">{{ translate('other') }}</option>
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

    <div class="col-xl-4 mt-2 mt-sm-0">
        <div class="form-group">
            <label for="brand">{{translate('brand')}}</label>
            <input type="text" class="form-control" value="{{old('brand')}}" name="custom_brand" placeholder="{{translate('brand')}}">
        </div>
    </div>
    
    <div class="col-xl-4 mt-1 mt-sm-0">
        <div class="form-group">
            <label for="usage">{{translate('usage')}}</label>
            <select class="form-control" name="usage" id="usage">
                <option {{ old('usage') == 'indoor' ? 'selected' : ''}} value="indoor">{{translate('indoor')}}</option>
                <option {{ old('usage') == 'outdoor' ? 'selected' : ''}} value="outdoor">{{translate('outdoor')}}</option>
            </select>
        </div>
    </div>

</div>
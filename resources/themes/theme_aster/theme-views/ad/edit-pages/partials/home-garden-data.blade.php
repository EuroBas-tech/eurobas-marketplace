<div class="row mb-1 border px-3 py-3 ms-0 mt-4 rounded custom-gray-border-color" >
    <div class="mb-3" >
        <h2>{{ translate('product_details') }}</h2>
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
            <label for="material">{{translate('material')}}</label>
            <select class="form-control" name="material" id="material">
                <option value=""> -- {{ translate('choose_a_home_garden_material') }} -- </option>
                <option {{ $ad['material'] == 'wood' ? 'selected' : ''}} value="wood">{{ translate('wood') }}</option>
                <option {{ $ad['material'] == 'leather' ? 'selected' : ''}} value="leather">{{ translate('leather') }}</option>
                <option {{ $ad['material'] == 'fabric' ? 'selected' : ''}} value="fabric">{{ translate('fabric') }}</option>
                <option {{ $ad['material'] == 'metal' ? 'selected' : ''}} value="metal">{{ translate('metal') }}</option>
                <option {{ $ad['material'] == 'glass' ? 'selected' : ''}} value="glass">{{ translate('glass') }}</option>
                <option {{ $ad['material'] == 'plastic' ? 'selected' : ''}} value="plastic">{{ translate('plastic') }}</option>
                <option {{ $ad['material'] == 'marble' ? 'selected' : ''}} value="marble">{{ translate('marble') }}</option>
                <option {{ $ad['material'] == 'rattan' ? 'selected' : ''}} value="rattan">{{ translate('rattan') }}</option>
                <option {{ $ad['material'] == 'bamboo' ? 'selected' : ''}} value="bamboo">{{ translate('bamboo') }}</option>
                <option {{ $ad['material'] == 'foam' ? 'selected' : ''}} value="foam">{{ translate('foam') }}</option>
                <option {{ $ad['material'] == 'synthetic' ? 'selected' : ''}} value="synthetic">{{ translate('synthetic') }}</option>
                <option {{ $ad['material'] == 'other' ? 'selected' : ''}} value="other">{{ translate('other') }}</option>
            </select>
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

    <div class="col-xl-4 mt-2 mt-sm-0">
        <div class="form-group">
            <label for="brand">{{translate('brand')}}</label>
            <input type="text" class="form-control" value="{{$ad->custom_brand}}" name="custom_brand" placeholder="{{translate('brand')}}">
        </div>
    </div>
    
    <div class="col-xl-4 mt-1 mt-sm-0">
        <div class="form-group">
            <label for="usage">{{translate('usage')}}</label>
            <select class="form-control" name="usage" id="usage">
                <option {{ $ad['indoor'] == 'new' ? 'selected' : ''}} value="indoor">{{translate('indoor')}}</option>
                <option {{ $ad['outdoor']  == 'used' ? 'selected' : ''}} value="outdoor">{{translate('outdoor')}}</option>
            </select>
        </div>
    </div>
</div>
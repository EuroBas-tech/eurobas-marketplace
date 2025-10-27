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

    <div class="col-xl-4 mt-2 mt-sm-0">
        <div class="form-group">
            <label for="brand">{{translate('brand')}}</label>
            <input type="text" class="form-control" value="{{$ad->custom_brand}}" name="custom_brand" placeholder="{{translate('brand')}}">
        </div>
    </div>

    <div class="col-sm-4 mb-2">
        <div class="form-group mb-2">
            <label for="electronic_type">{{ translate('type') }}</label>
            <select class="form-control" name="electronic_type" id="electronic_type">
                <option value=""> -- {{ translate('choose_electronic_type') }} -- </option>
                @foreach($list_values->where('list_name', 'electronic_types')->sortBy('priority') as $list_value)
                    <option {{ $ad['electronic_type'] == $list_value['value'] ? 'selected' : ''}} value="{{$list_value->value}}">
                        {{translate($list_value->value)}}
                    </option>
                @endforeach
                <option {{ $ad['electronic_type'] == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                {{--
                    <option {{ $ad['electronic_type'] == 'tv' ? 'selected' : ''}} value="tv">{{ translate('tv') }}</option>
                    <option {{ $ad['electronic_type'] == 'laptop' ? 'selected' : ''}} value="laptop">{{ translate('laptop') }}</option>
                    <option {{ $ad['electronic_type'] == 'desktop_computer' ? 'selected' : ''}} value="desktop_computer">{{ translate('desktop_computer') }}</option>
                    <option {{ $ad['electronic_type'] == 'tablet' ? 'selected' : ''}} value="tablet">{{ translate('tablet') }}</option>
                    <option {{ $ad['electronic_type'] == 'smartphone' ? 'selected' : ''}} value="smartphone">{{ translate('smartphone') }}</option>
                    <option {{ $ad['electronic_type'] == 'smartwatch' ? 'selected' : ''}} value="smartwatch">{{ translate('smartwatch') }}</option>
                    <option {{ $ad['electronic_type'] == 'camera' ? 'selected' : ''}} value="camera">{{ translate('camera') }}</option>
                    <option {{ $ad['electronic_type'] == 'printer' ? 'selected' : ''}} value="printer">{{ translate('printer') }}</option>
                    <option {{ $ad['electronic_type'] == 'scanner' ? 'selected' : ''}} value="scanner">{{ translate('scanner') }}</option>
                    <option {{ $ad['electronic_type'] == 'gaming_console' ? 'selected' : ''}} value="gaming_console">{{ translate('gaming_console') }}</option>
                    <option {{ $ad['electronic_type'] == 'monitor' ? 'selected' : ''}} value="monitor">{{ translate('monitor') }}</option>
                    <option {{ $ad['electronic_type'] == 'projector' ? 'selected' : ''}} value="projector">{{ translate('projector') }}</option>
                    <option {{ $ad['electronic_type'] == 'router' ? 'selected' : ''}} value="router">{{ translate('router') }}</option>
                    <option {{ $ad['electronic_type'] == 'speaker' ? 'selected' : ''}} value="speaker">{{ translate('speaker') }}</option>
                    <option {{ $ad['electronic_type'] == 'headphones' ? 'selected' : ''}} value="headphones">{{ translate('headphones') }}</option>
                    <option {{ $ad['electronic_type'] == 'earbuds' ? 'selected' : ''}} value="earbuds">{{ translate('earbuds') }}</option>
                    <option {{ $ad['electronic_type'] == 'drone' ? 'selected' : ''}} value="drone">{{ translate('drone') }}</option>
                    <option {{ $ad['electronic_type'] == 'vr_headset' ? 'selected' : ''}} value="vr_headset">{{ translate('vr_headset') }}</option>
                    <option {{ $ad['electronic_type'] == 'gps' ? 'selected' : ''}} value="gps">{{ translate('gps') }}</option>
                    <option {{ $ad['electronic_type'] == 'other' ? 'selected' : ''}} value="other">{{ translate('other') }}</option>
                --}}
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
</div>
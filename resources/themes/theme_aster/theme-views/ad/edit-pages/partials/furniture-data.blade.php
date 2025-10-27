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
            <label for="furniture_type">{{translate('furniture_type')}}</label>
            <select class="form-control" name="furniture_type" id="furniture_type">
                <option value=""> -- {{ translate('choose_a_furniture_type') }} -- </option>
                @foreach($list_values->where('list_name', 'furniture_types')->sortBy('priority') as $list_value)
                    <option {{ $ad['furniture_type'] == $list_value['value'] ? 'selected' : ''}} value="{{$list_value->value}}">
                        {{translate($list_value->value)}}
                    </option>
                @endforeach
                <option {{ $ad['furniture_type'] == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                {{--
                    <option {{ $ad['furniture_type'] == 'sofa' ? 'selected' : ''}} value="sofa">{{ translate('sofa') }}</option>
                    <option {{ $ad['furniture_type'] == 'bed' ? 'selected' : ''}} value="bed">{{ translate('bed') }}</option>
                    <option {{ $ad['furniture_type'] == 'table' ? 'selected' : ''}} value="table">{{ translate('table') }}</option>
                    <option {{ $ad['furniture_type'] == 'chair' ? 'selected' : ''}} value="chair">{{ translate('chair') }}</option>
                    <option {{ $ad['furniture_type'] == 'armchair' ? 'selected' : ''}} value="armchair">{{ translate('armchair') }}</option>
                    <option {{ $ad['furniture_type'] == 'dining_table' ? 'selected' : ''}} value="dining_table">{{ translate('dining_table') }}</option>
                    <option {{ $ad['furniture_type'] == 'coffee_table' ? 'selected' : ''}} value="coffee_table">{{ translate('coffee_table') }}</option>
                    <option {{ $ad['furniture_type'] == 'tv_stand' ? 'selected' : ''}} value="tv_stand">{{ translate('tv_stand') }}</option>
                    <option {{ $ad['furniture_type'] == 'bookshelf' ? 'selected' : ''}} value="bookshelf">{{ translate('bookshelf') }}</option>
                    <option {{ $ad['furniture_type'] == 'wardrobe' ? 'selected' : ''}} value="wardrobe">{{ translate('wardrobe') }}</option>
                    <option {{ $ad['furniture_type'] == 'dresser' ? 'selected' : ''}} value="dresser">{{ translate('dresser') }}</option>
                    <option {{ $ad['furniture_type'] == 'nightstand' ? 'selected' : ''}} value="nightstand">{{ translate('nightstand') }}</option>
                    <option {{ $ad['furniture_type'] == 'cabinet' ? 'selected' : ''}} value="cabinet">{{ translate('cabinet') }}</option>
                    <option {{ $ad['furniture_type'] == 'desk' ? 'selected' : ''}} value="desk">{{ translate('desk') }}</option>
                    <option {{ $ad['furniture_type'] == 'bench' ? 'selected' : ''}} value="bench">{{ translate('bench') }}</option>
                    <option {{ $ad['furniture_type'] == 'stool' ? 'selected' : ''}} value="stool">{{ translate('stool') }}</option>
                    <option {{ $ad['furniture_type'] == 'recliner' ? 'selected' : ''}} value="recliner">{{ translate('recliner') }}</option>
                    <option {{ $ad['furniture_type'] == 'console_table' ? 'selected' : ''}} value="console_table">{{ translate('console_table') }}</option>
                    <option {{ $ad['furniture_type'] == 'shoe_rack' ? 'selected' : ''}} value="shoe_rack">{{ translate('shoe_rack') }}</option>
                    <option {{ $ad['furniture_type'] == 'vanity' ? 'selected' : ''}} value="vanity">{{ translate('vanity') }}</option>
                    <option {{ $ad['furniture_type'] == 'crib' ? 'selected' : ''}} value="crib">{{ translate('crib') }}</option>
                    <option {{ $ad['furniture_type'] == 'bunk_bed' ? 'selected' : ''}} value="bunk_bed">{{ translate('bunk_bed') }}</option>
                    <option {{ $ad['furniture_type'] == 'sideboard' ? 'selected' : ''}} value="sideboard">{{ translate('sideboard') }}</option>
                    <option {{ $ad['furniture_type'] == 'ottoman' ? 'selected' : ''}} value="ottoman">{{ translate('ottoman') }}</option>
                    <option {{ $ad['furniture_type'] == 'folding_bed' ? 'selected' : ''}} value="folding_bed">{{ translate('folding_bed') }}</option>
                    <option {{ $ad['furniture_type'] == 'rocking_chair' ? 'selected' : ''}} value="rocking_chair">{{ translate('rocking_chair') }}</option>
                    <option {{ $ad['furniture_type'] == 'other' ? 'selected' : ''}} value="other">{{ translate('other') }}</option>
                --}}
            </select>
        </div>
    </div>
   
    <div class="col-sm-4 mb-2">
        <div class="form-group mb-2">
            <label for="furniture_material">{{translate('furniture_material')}}</label>
            <select class="form-control" name="material" id="furniture_material">
                <option value=""> -- {{ translate('choose_a_furniture_material') }} -- </option>
                @foreach($list_values->where('list_name', 'furniture_materials')->sortBy('priority') as $list_value)
                    <option {{ $ad['material'] == $list_value['value'] ? 'selected' : ''}} value="{{$list_value->value}}">
                        {{translate($list_value->value)}}
                    </option>
                @endforeach
                <option {{ $ad['material'] == 'other' ? 'selected' : ''}} value="other">{{translate('Other')}}</option>
                {{--
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
                --}}
            </select>
        </div>
    </div>

    <div class="col-xl-4">
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
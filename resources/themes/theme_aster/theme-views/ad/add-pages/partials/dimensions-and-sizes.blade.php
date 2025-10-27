<div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
    <div class="mb-2" >
        <h2 class="mb-3" >{{ translate('dimensions_and_sizes') }}</h2>
    </div>
    <div class="row">
        <div class="col-xl-4 mb-3">
            <div class="form-group">
                <label for="length">{{translate('length')}} ({{ translate('Optional') }})</label>
                <input type="text" id="length" class="form-control" value="{{old('length')}}" name="length" placeholder="{{translate('Ex: 2.5')}}">
            </div>
        </div>
        <div class="col-xl-4 mb-3">
            <div class="form-group">
                <label for="height">{{translate('height')}} ({{ translate('Optional') }})</label>
                <input type="text" id="height" class="form-control" value="{{old('height')}}" name="height" placeholder="{{translate('Ex: 3.6')}}">
            </div>
        </div>
        <div class="col-xl-4 mb-3">
            <div class="form-group">
                <label for="width">{{translate('width')}} ({{ translate('Optional') }})</label>
                <input type="text" id="width" class="form-control" value="{{old('width')}}" name="width" placeholder="{{translate('Ex: 1.85')}}">
            </div>
        </div>
        <div class="col-xl-4">
            <div class="form-group">
                <label for="max_weight">{{translate("max_weight")}} ({{ translate('Optional') }})</label>
                <input type="text" id="max_weight" class="form-control" value="{{old('max_weight')}}" name="max_weight" placeholder="{{translate('Ex: 850')}}">
            </div>
        </div>

        @if($selected_type == 'vehicles')
            @if($selected_category->slug !== 'bicycles' && $selected_category->slug !== 'vehicle-accessories' && $selected_category->slug !== 'spare-parts')
            
                <div class="col-xl-4 mt-2 mt-sm-0">
                    <div class="form-group">
                        <label for="bag_capacity">{{translate("bag_capacity")}} ({{ translate('Optional') }})</label>
                        <input type="text" id="bag_capacity" class="form-control" value="{{old('bag_capacity')}}" name="bag_capacity" placeholder="{{translate('Ex: 280')}}">
                    </div>
                </div>
            @endif

            @if($selected_category->slug !== 'bicycles' && $selected_category->slug !== 'motorcycles' && 
            $selected_category->slug !== 'vehicle-accessories' && $selected_category->slug !== 'spare-parts')
                <div style="width:100%;height: 1px;border-bottom: 1px solid #cccccc85;margin: 35px 0 28px;" ></div>
                <div class="col-xl-4 mb-3">
                    <div class="form-group">
                        <label for="doors_number">{{translate('number_of_doors')}} ({{ translate('Optional') }})</label>
                        <select class="form-control" name="doors_number" id="doors_number">
                            <option value=""> -- {{translate('choose_number_of_doors')}} -- </option>
                            <option {{ old('doors_number') == '2/3' ? 'selected' : ''}} value="2/3">2/3</option>
                            <option {{ old('doors_number') == '4/5' ? 'selected' : ''}} value="4/5">4/5</option>
                            <option {{ old('doors_number') == '6/7' ? 'selected' : ''}} value="6/7">6/7</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-4 mb-3">
                    <div class="form-group">
                        <label for="seats_number">{{translate('number_of_seats')}} ({{ translate('Optional') }})</label>
                        <select class="form-control" name="seats_number" id="seats_number">
                            <option value=""> -- {{translate('choose_number_of_seats')}} -- </option>
                            <option {{ old('seats_number') == '1' ? 'selected' : ''}} value="1">1</option>
                            <option {{ old('seats_number') == '2' ? 'selected' : ''}} value="2">2</option>
                            <option {{ old('seats_number') == '3' ? 'selected' : ''}} value="3">3</option>
                            <option {{ old('seats_number') == '4' ? 'selected' : ''}} value="4">4</option>
                            <option {{ old('seats_number') == '5' ? 'selected' : ''}} value="5">5</option>
                            <option {{ old('seats_number') == '6' ? 'selected' : ''}} value="6">6</option>
                            <option {{ old('seats_number') == '7' ? 'selected' : ''}} value="7">7</option>
                            <option {{ old('seats_number') == '8' ? 'selected' : ''}} value="8">8</option>
                            <option {{ old('seats_number') == '9' ? 'selected' : ''}} value="9">9</option>
                            <option {{ old('seats_number') == '10' ? 'selected' : ''}} value="10">10</option>
                            <option {{ old('seats_number') == '11' ? 'selected' : ''}} value="11">11</option>
                            <option {{ old('seats_number') == '12' ? 'selected' : ''}} value="12">12</option>
                        </select>
                    </div>
                </div>
            @endif

            @if($selected_category->slug == 'caravans' || $selected_category->slug == 'motorhomes')
                <div class="col-xl-4 mb-3">
                    <div class="form-group">
                        <label for="beds_number">{{translate('number_of_beds')}} ({{ translate('Optional') }})</label>
                        <select class="form-control" name="beds_number" id="beds_number">
                            <option value=""> -- {{translate('choose_number_of_beds')}} -- </option>
                            <option {{ old('beds_number') == '1' ? 'selected' : ''}} value="1">1</option>
                            <option {{ old('beds_number') == '2' ? 'selected' : ''}} value="2">2</option>
                            <option {{ old('beds_number') == '3' ? 'selected' : ''}} value="3">3</option>
                            <option {{ old('beds_number') == '4' ? 'selected' : ''}} value="4">4</option>
                            <option {{ old('beds_number') == '5' ? 'selected' : ''}} value="5">5</option>
                            <option {{ old('beds_number') == '6' ? 'selected' : ''}} value="6">6</option>
                            <option {{ old('beds_number') == '7' ? 'selected' : ''}} value="7">7</option>
                            <option {{ old('beds_number') == '8' ? 'selected' : ''}} value="8">8</option>
                        </select>
                    </div>
                </div>
            @endif
        @endif

    </div>
</div>
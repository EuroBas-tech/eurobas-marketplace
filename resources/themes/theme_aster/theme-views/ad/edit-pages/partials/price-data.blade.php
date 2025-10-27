<div class="mb-4 border px-3 py-3 rounded custom-gray-border-color" >
    <div class="mb-2" >
        <h2>{{ translate('price_details') }}</h2>
    </div>
    <div class="row">
        <div class="col-sm-6 mb-2">
            <div class="form-group mb-2">
                <label for="currency">{{translate('currency')}}</label>
                <select class="form-control" name="currency" id="currency">
                    <option value="" > -- {{ translate('choose_a_currency') }} -- </option>
                    <option {{ $ad['currency'] == 'USD' ? 'selected' : ''}} value="USD">USD</option>
                    <option {{ $ad['currency'] == 'EUR' ? 'selected' : ''}} value="EUR">EUR</option>
                    <option {{ $ad['currency'] == 'GBP' ? 'selected' : ''}} value="GBP">GBP</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6 mb-2">
            <div class="form-group mb-2">
                <label for="">{{translate('price_type')}}</label>
                <select class="form-control" name="price_type" id="price_type">
                    <option value=""> -- {{ translate('choose_a_price_type') }} -- </option>
                    <option {{ $ad['price_type'] == 'fixed_price' ? 'selected' : ''}} value="fixed_price">{{ translate('fixed_price') }}</option>
                    <option {{ $ad['price_type'] == 'asking_price' ? 'selected' : ''}} value="asking_price">{{ translate('asking_price') }}</option>
                    <option {{ $ad['price_type'] == 'auction' ? 'selected' : ''}} value="auction">{{ translate('auction') }}</option>
                    <option {{ $ad['price_type'] == 'free' ? 'selected' : ''}} value="free">{{ translate('free') }}</option>
                </select>
            </div>
        </div>
        <div id="starting-price-box" class="col-sm-12 @if($ad->price_type != 'auction') d-none @endif">
            <div class="form-group mb-2">
                <input type="number" id="starting-price" class="form-control" 
                value="{{$ad['starting_price']}}" step="0.01" min="0" name="starting_price" 
                placeholder="{{translate('starting_price')}}">
            </div>
        </div>
        <div id="price-box" class="col-sm-12 @if($ad->price_type == 'auction' || $ad->price_type == 'free') d-none @endif">
            <div class="form-group">
                <input type="number" id="price" class="form-control" value="{{$ad['price']}}" name="price" placeholder="{{translate('price')}}" step="0.01" min="0">
            </div>
        </div>
    </div>
    <div id="offers-box" class="col-sm-12 @if($ad->price_type != 'asking_price') d-none @endif mt-2">
        <div class="form-group form-check form-switch d-flex gap-5 p-0 align-items-center">
            <label class="m-0" for="show-phone-number">{{translate('allow_offers')}} ?</label>
            <input class="form-check-input" {{ $ad['allow_offers'] == 1 ? 'checked' : '' }}
            name="allow_offers" type="checkbox" role="switch" id="allow-offers">
        </div>
        <div class="form-group @if($ad['allow_offers'] == 0) d-none @endif" id="first-price">
            <input type="number" step="0.01" min="0" id="first-price-input" class="form-control" value="{{$ad['first_price']}}" 
            name="first_price" placeholder="{{translate('first_price')}}">
        </div>
    </div>
</div>
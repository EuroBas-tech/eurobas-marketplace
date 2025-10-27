<div class="modal fade" id="locationSearchModal" style="display: none; background: rgba(0, 0, 0, 0.13);" 
aria-labelledby="search_ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-0">
            <div class="modal-header px-sm-4 pb-1">
                <h2 class="" id="contact_sellerModalLabel">{{translate('location_search')}}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-4">
                <div id="@if(!$is_selected_category_vehicle) d-none @endif">
                    <label class="fw-bold mb-1" for="country">{{translate('country')}}</label>
                    <div class="row">
                        <div class="form-group mb-2">
                            <select class="form-control fw-medium custom-input-height emoji-font location-filter-input" id="location_country" data-filter-id="location_country" name="country" >
                                @foreach (SYSTEM_COUNTRIES as $country)
                                    <option class="emoji-font fw-medium" {{ array_key_exists('country', $filter_data) && $filter_data['country'] == $country['name'] ? 'selected' : '' }} value="{{ $country['name'] }}">{{$country['emoji']}} {{ $country['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="city" class="fw-bold">{{translate('city')}}</label>
                            <input type="text" style="height: 38px;" id="location_city" data-filter-id="location_city" value="" name="city" class="form-control location-filter-input" placeholder="{{translate('Ex:London')}}">
                        </div>
                        <div class="form-group mb-2">
                            <label for="location_radius" class="fw-bold">{{translate('radius')}}</label>
                            <select disabled class="form-control location-filter-input fw-medium" style="height: 38px;"
                            id="location_radius" data-filter-id="location_radius" name="radius">
                                <option class="fw-medium" value="">-- {{translate('specify_radius')}} --</option>
                                <option class="fw-medium" value="1">1 {{ translate('km') }}</option>
                                <option class="fw-medium" value="2">2 {{ translate('km') }}</option>
                                <option class="fw-medium" value="5">5 {{ translate('km') }}</option>
                                <option class="fw-medium" value="10">10 {{ translate('km') }}</option>
                                <option class="fw-medium" value="15">15 {{ translate('km') }}</option>
                                <option class="fw-medium" value="20">20 {{ translate('km') }}</option>
                                <option class="fw-medium" value="25">25 {{ translate('km') }}</option>
                                <option class="fw-medium" value="30">30 {{ translate('km') }}</option>
                                <option class="fw-medium" value="40">40 {{ translate('km') }}</option>
                                <option class="fw-medium" value="50">50 {{ translate('km') }}</option>
                                <option class="fw-medium" value="60">60 {{ translate('km') }}</option>
                                <option class="fw-medium" value="70">70 {{ translate('km') }}</option>
                                <option class="fw-medium" value="80">80 {{ translate('km') }}</option>
                                <option class="fw-medium" value="90">90 {{ translate('km') }}</option>
                                <option class="fw-medium" value="100">100 {{ translate('km') }}</option>
                                <option class="fw-medium" value="120">120 {{ translate('km') }}</option>
                                <option class="fw-medium" value="150">150 {{ translate('km') }}</option>
                                <option class="fw-medium" value="180">180 {{ translate('km') }}</option>
                                <option class="fw-medium" value="200">200 {{ translate('km') }}</option>
                                <option class="fw-medium" value="250">250 {{ translate('km') }}</option>
                                <option class="fw-medium" value="300">300 {{ translate('km') }}</option>
                                <option class="fw-medium" value="400">400 {{ translate('km') }}</option>
                                <option class="fw-medium" value="500">500 {{ translate('km') }}</option>
                                <option class="fw-medium" value="600">600 {{ translate('km') }}</option>
                                <option class="fw-medium" value="700">700 {{ translate('km') }}</option>
                                <option class="fw-medium" value="800">800 {{ translate('km') }}</option>
                                <option class="fw-medium" value="900">900 {{ translate('km') }}</option>
                                <option class="fw-medium" value="1000">1000 {{ translate('km') }}</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <div id="shippingMapContainer" class="container my-2 p-0">
                                <div class="modal-content border-0 shadow-none">
                                    <div class="modal-body p-0">
                                        <div class="product-quickview">
                                            <div id="location_map_canvas" class="dark-support rounded w-100" style="height: 14rem;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" id="apply_location_search" data-bs-dismiss="modal" >{{translate('apply')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

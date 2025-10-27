<div class="modal fade" id="advancedFilterModal" style="display: none; background: rgba(0, 0, 0, 0.13);" 
aria-labelledby="search_ModalLabel" aria-hidden="true">
    <div class="modal-dialog advanced-filter">
        <div class="modal-content p-0" style="max-height: 80vh;overflow-y: auto;">
            <div class="modal-header px-sm-4 pb-1">
                <h2 class="" id="contact_sellerModalLabel">{{translate('advanced_filter')}}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-4">
                <div>
                    <form>
                        <div class="row">
                            <div class="col-xl-4 col-md-4 col-sm-6 col-12 mb-2">
                                <div class="form-group mb-2">
                                    <label for="category">{{ translate('categories') }}</label>
                                    <select style="height: 38px;" data-filter-label="categories" data-filter-id="category"
                                    class="form-control custom-input-height filter-input fw-medium" name="category_id" id="category">
                                        <option data-is-vehicle="1" value="all">{{translate('all')}}</option>
                                        @foreach($categories as $category)
                                            <option 
                                            data-is-vehicle="" value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4 col-sm-6 col-12 mb-2">
                                <div class="form-group">
                                    <label for="brand" class="fw-medium d-block">{{ translate('brand') }}</label>
                                    <select style="height: 40px" class="form-control filter-input brand-select" name="brand_id" id="brand" data-category="{{$category['id']}}">
                                        <option value="all">{{translate('all')}}</option>
                                        @foreach($brands as $brand)
                                            <option {{ $brand['id'] == ($data['brand_id'] ?? '') || $brand['id'] == old('brand_id') ? 'selected' : ''}} 
                                            value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4 col-sm-6 col-12 mb-2">
                                <div class="form-group">
                                    <label for="model" class="fw-medium d-block">{{ translate('model') }}</label>
                                    <select style="height: 40px" class="form-control filter-input model-select" name="model_id" id="model" data-category="{{$category['id']}}" disabled>
                                        <option value="all">{{translate('all')}}</option>
                                        @foreach($models as $model)
                                            <option 
                                            data-brand-id="{{ $model['brand_id'] }}"
                                            data-category-id="{{ $model['category_id'] }}"
                                            {{ $model['id'] == ($data['model_id'] ?? '') || $model['id'] == old('model_id') ? 'selected' : ''}}
                                            value="{{ $model['id'] }}">{{ $model['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-6 col-12 mb-2">
                                <div class="form-group mb-3 padding-top-md">
                                    <label for="construction_year" class="fw-medium">{{ translate('construction_year') }}</label>
                                    <select style="height: 40px" class="form-control filter-input custom-input-height" name="construction_year" id="construction_year}}">
                                        <option value="all">{{translate('year_from')}}</option>
                                        @for ($year = 2025; $year >= 1940; $year--)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-6 col-12 mb-2">
                                <div class="form-group mb-3 padding-top-md">
                                    <label for="price_range_{{$category['id']}}" class="fw-medium">{{ translate('price') }}</label>
                                    <select style="height: 40px" class="form-control filter-input custom-input-height" name="price_range" id="price_range">
                                        <option value="all">{{translate('price_up_to')}}</option>
                                        <option value="500">500€</option>
                                        <option value="1000">1,000€</option>
                                        <option value="1500">1,500€</option>
                                        <option value="2000">2,000€</option>
                                        <option value="2500">2,500€</option>
                                        <option value="3000">3,000€</option>
                                        <option value="3500">3,500€</option>
                                        <option value="4000">4,000€</option>
                                        <option value="4500">4,500€</option>
                                        <option value="5000">5,000€</option>
                                        <option value="5500">5,500€</option>
                                        <option value="6000">6,000€</option>
                                        <option value="6500">6,500€</option>
                                        <option value="7000">7,000€</option>
                                        <option value="7500">7,500€</option>
                                        <option value="8000">8,000€</option>
                                        <option value="8500">8,500€</option>
                                        <option value="9000">9,000€</option>
                                        <option value="9500">9,500€</option>
                                        <option value="10000">10,000€</option>
                                        <option value="12000">12,500€</option>
                                        <option value="15000">15,000€</option>
                                        <option value="17500">17,500€</option>
                                        <option value="20000">20,000€</option>
                                        <option value="30000">30,000€</option>
                                        <option value="40000">40,000€</option>
                                        <option value="50000">50,000€</option>
                                        <option value="60000">60,000€</option>
                                        <option value="70000">70,000€</option>
                                        <option value="80000">80,000€</option>
                                        <option value="90000">90,000€</option>
                                        <option value="100000">100,000€</option>
                                        <option value="125000">125,000€</option>
                                        <option value="150000">150,000€</option>
                                        <option value="175000">175,000€</option>
                                        <option value="200000">200,000€</option>
                                        <option value="300000">300,000€</option>
                                        <option value="400000">400,000€</option>
                                        <option value="500000">500,000€</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group padding-bottom-sm">
                                    <label for="" class="fw-medium">{{ translate('country') }}</label>
                                    <select style="height: 40px" class="form-control filter-input custom-input-height emoji-font country-select" name="country" id="">
                                        @foreach (SYSTEM_COUNTRIES as $country)
                                            <option class="emoji-font" value="{{ $country['name'] }}" dir="ltr">
                                                <bdi>{{ $country['emoji'] }} {{ $country['name'] }}</bdi>
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div style="width:100%;height: 1px;border-bottom: 1px solid #cccccc85;margin: 25px 0 25px;" ></div>

                            <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                <div class="form-group mb-3" id="status-box">
                                    <div class="dropdown w-100">
                                        <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select" 
                                            style="height: 38px;" 
                                            type="button" 
                                            id="sevenmultiSelectDropdown"
                                            data-bs-toggle="dropdown" 
                                            aria-expanded="false">
                                                {{translate('color')}}
                                        </button>
                                        <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="sevenmultiSelectDropdown" 
                                            style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;max-height: 350px;overflow-x: auto;">
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="black">
                                                    <span>{{translate('Black')}}</span>
                                                    <span style="width: 25px;height: 15px;background: black;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-2 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="white">
                                                    <span>{{translate('White')}}</span>
                                                    <span style="width: 25px;height: 15px;background: white;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-2 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="silver">
                                                    <span>{{translate('Silver')}}</span>
                                                    <span style="width: 25px;height: 15px;background: silver;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-2 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="gray">
                                                    <span>{{translate('gray')}}</span>
                                                    <span style="width: 25px;height: 15px;background: gray;" ></span>
                                                </label>
                                            </li>                           
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="blue">
                                                    <span>{{translate('Blue')}}</span>
                                                    <span style="width: 25px;height: 15px;background: blue;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="red">
                                                    <span>{{translate('Red')}}</span>
                                                    <span style="width: 25px;height: 15px;background: red;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="brown">
                                                    <span>{{translate('Brown')}}</span>
                                                    <span style="width: 25px;height: 15px;background: brown;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="beige">
                                                    <span>{{translate('Beige')}}</span>
                                                    <span style="width: 25px;height: 15px;background: beige;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="green">
                                                    <span>{{translate('green')}}</span>
                                                    <span style="width: 25px;height: 15px;background: green;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="orange">
                                                    <span>{{translate('Orange')}}</span>
                                                    <span style="width: 25px;height: 15px;background: orange;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="yellow">
                                                    <span>{{translate('Yellow')}}</span>
                                                    <span style="width: 25px;height: 15px;background: yellow;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="gold">
                                                    <span>{{translate('Gold')}}</span>
                                                    <span style="width: 25px;height: 15px;background: gold;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="purple">
                                                    <span>{{translate('Purple')}}</span>
                                                    <span style="width: 25px;height: 15px;background: purple;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="pink">
                                                    <span>{{translate('Pink')}}</span>
                                                    <span style="width: 25px;height: 15px;background: pink;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="turquoise">
                                                    <span>{{translate('Turquoise')}}</span>
                                                    <span style="width: 25px;height: 15px;background: turquoise;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="darkred">
                                                    <span>{{translate('dark_red')}}</span>
                                                    <span style="width: 25px;height: 15px;background: darkred;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="navy">
                                                    <span>{{translate('Navy Blue')}}</span>
                                                    <span style="width: 25px;height: 15px;background: navy;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="peru">
                                                    <span>{{translate('Peru')}}</span>
                                                    <span style="width: 25px;height: 15px;background: peru;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="olive">
                                                    <span>{{translate('Olive')}}</span>
                                                    <span style="width: 25px;height: 15px;background: olive;" ></span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="color" data-filter-name="color[]" name="color[]" value="multicolor/custom">
                                                    <span>{{translate('Multicolor / Custom')}}</span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                <div class="form-group mb-4" id="status-box">
                                    <div class="dropdown w-100">
                                        <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select" 
                                                style="height: 38px;" 
                                                type="button" 
                                                id="firstmultiSelectDropdown"
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false">
                                            {{translate('status')}}
                                        </button>
                                        <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="firstmultiSelectDropdown" 
                                        style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;">
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" 
                                                    data-filter-label="status" data-filter-name="status[]" type="checkbox" name="status[]" value="never_used">
                                                    <span>{{ translate('never_used') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" 
                                                    data-filter-label="status" data-filter-name="status[]" type="checkbox" name="status[]" value="new">
                                                    <span>{{ translate('new') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" 
                                                    data-filter-label="status" data-filter-name="status[]" type="checkbox" name="status[]" value="used">
                                                    <span>{{ translate('used') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" 
                                                    data-filter-label="status" data-filter-name="status[]" type="checkbox" name="status[]" value="old">
                                                    <span>{{ translate('old') }}</span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                <div class="form-group mb-4" id="status-box">
                                    <div class="dropdown w-100">
                                        <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select" 
                                                style="height: 38px;" 
                                                type="button" 
                                                id="secondmultiSelectDropdown"
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false">
                                            {{translate('gear')}}
                                        </button>
                                        <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="secondmultiSelectDropdown" 
                                        style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;">
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" 
                                                    data-filter-label="Transmission Type" data-filter-name="transmission_type[]" type="checkbox" name="transmission_type[]" value="automatic">
                                                    <span>{{ translate('automatic') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" 
                                                    data-filter-label="Transmission Type" data-filter-name="transmission_type[]" type="checkbox" name="transmission_type[]" value="semi_automatic">
                                                    <span>{{ translate('semi_automatic') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Transmission Type" data-filter-name="transmission_type[]" name="transmission_type[]" value="manually">
                                                    <span>{{ translate('manually') }}</span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                <div class="form-group mb-4" id="status-box">
                                    <div class="dropdown w-100">
                                        <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select" 
                                                style="height: 38px;" 
                                                type="button" 
                                                id="thirdmultiSelectDropdown"
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false">
                                            {{translate('body_type')}}
                                        </button>
                                        <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="thirdmultiSelectDropdown" 
                                        style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;">
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Body Type" data-filter-name="body_type[]" name="body_type[]" value="compact">
                                                    <span>{{ translate('compact') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Body Type" data-filter-name="body_type[]" name="body_type[]" value="suv_off_Road">
                                                    <span>{{ translate('suv_off_Road') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Body Type" data-filter-name="body_type[]" name="body_type[]" value="sedan">
                                                    <span>{{ translate('sedan') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Body Type" data-filter-name="body_type[]" name="body_type[]" value="hatchback">
                                                    <span>{{ translate('hatchback') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Body Type" data-filter-name="body_type[]" name="body_type[]" value="station_wagon">
                                                    <span>{{ translate('station_wagon') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Body Type" data-filter-name="body_type[]" name="body_type[]" value="van">
                                                    <span>{{ translate('van') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Body Type" data-filter-name="body_type[]" name="body_type[]" value="transporter">
                                                    <span>{{ translate('transporter') }}</span>
                                                </label>
                                            </li>                                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                <div class="form-group mb-3" id="status-box">
                                    <div class="dropdown w-100">
                                        <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select" 
                                                style="height: 38px;" 
                                                type="button" 
                                                id="forthmultiSelectDropdown"
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false">
                                            {{translate('fuel_type')}}
                                        </button>
                                        <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="forthmultiSelectDropdown" 
                                        style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;">
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Fuel Type" data-filter-name="fuel_type[]" name="fuel_type[]" value="diesel">
                                                    <span>{{ translate('diesel') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Fuel Type" data-filter-name="fuel_type[]" name="fuel_type[]" value="electric_ev">
                                                    <span>{{ translate('electric_ev') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Fuel Type" data-filter-name="fuel_type[]" name="fuel_type[]" value="hybrid">
                                                    <span>{{ translate('hybrid') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Fuel Type" data-filter-name="fuel_type[]" name="fuel_type[]" value="Plug_in_hybrid_phev">
                                                    <span>{{ translate('Plug_in_hybrid_phev') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Fuel Type" data-filter-name="fuel_type[]" name="fuel_type[]" value="lpg">
                                                    <span>{{ translate('lpg') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Fuel Type" data-filter-name="fuel_type[]" name="fuel_type[]" value="cng">
                                                    <span>{{ translate('cng') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Fuel Type" data-filter-name="fuel_type[]" name="fuel_type[]" value="hydrogen_fcev">
                                                    <span>{{ translate('hydrogen_fcev') }}</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="Fuel Type" data-filter-name="fuel_type[]" name="fuel_type[]" value="flex_fuel">
                                                    <span>{{ translate('flex_fuel') }}</span>
                                                </label>
                                            </li>                                          
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                <div class="form-group mb-3" id="status-box">
                                    <div class="dropdown w-100">
                                        <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select" 
                                                style="height: 38px;" 
                                                type="button" 
                                                id="fivethmultiSelectDropdown"
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false">
                                            {{translate('number_of_doors')}}
                                        </button>
                                        <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="fivethmultiSelectDropdown" 
                                        style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;">
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="doors_number" data-filter-name="doors_number[]" name="doors_number[]" value="2/3">
                                                    <span>2/3</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="doors_number" data-filter-name="doors_number[]" name="doors_number[]" value="4/5">
                                                    <span>4/5</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="doors_number" data-filter-name="doors_number[]" name="doors_number[]" value="6/7">
                                                    <span>6/7</span>
                                                </label>
                                            </li>                               
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                <div class="form-group mb-3" id="status-box">
                                    <div class="dropdown w-100">
                                        <button class="form-control text-start w-100 fw-medium justify-content-between px-2 form-select" 
                                                style="height: 38px;" 
                                                type="button" 
                                                id="sixthmultiSelectDropdown"
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false">
                                            {{translate('number_of_seats')}}
                                        </button>
                                        <ul class="dropdown-menu keep-open p-0 py-2" aria-labelledby="sixthmultiSelectDropdown" 
                                        style="width: calc(100% - 2px); left: 1px; right: 1px; max-width: none;">
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="seats_number" data-filter-name="seats_number[]" name="seats_number[]" value="1">
                                                    <span>1</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="seats_number" data-filter-name="seats_number[]" name="seats_number[]" value="2">
                                                    <span>2</span>
                                                </label>
                                            </li>
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="seats_number" data-filter-name="seats_number[]" name="seats_number[]" value="3">
                                                    <span>3</span>
                                                </label>
                                            </li>                               
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="seats_number" data-filter-name="seats_number[]" name="seats_number[]" value="4">
                                                    <span>4</span>
                                                </label>
                                            </li>                               
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="seats_number" data-filter-name="seats_number[]" name="seats_number[]" value="5">
                                                    <span>5</span>
                                                </label>
                                            </li>                               
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="seats_number" data-filter-name="seats_number[]" name="seats_number[]" value="6">
                                                    <span>6</span>
                                                </label>
                                            </li>                               
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="seats_number" data-filter-name="seats_number[]" name="seats_number[]" value="7">
                                                    <span>7</span>
                                                </label>
                                            </li>                               
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="seats_number" data-filter-name="seats_number[]" name="seats_number[]" value="8">
                                                    <span>8</span>
                                                </label>
                                            </li>                               
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="seats_number" data-filter-name="seats_number[]" name="seats_number[]" value="9">
                                                    <span>9</span>
                                                </label>
                                            </li>                               
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="seats_number" data-filter-name="seats_number[]" name="seats_number[]" value="10">
                                                    <span>10</span>
                                                </label>
                                            </li>                               
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="seats_number" data-filter-name="seats_number[]" name="seats_number[]" value="11">
                                                    <span>11</span>
                                                </label>
                                            </li>                               
                                            <li class="dropdown-item p-2 px-3">
                                                <label class="d-flex align-items-center gap-1 m-0">
                                                    <input class="form-check-input filter-input m-0" type="checkbox" 
                                                    data-filter-label="seats_number" data-filter-name="seats_number[]" name="seats_number[]" value="12">
                                                    <span>12</span>
                                                </label>
                                            </li>                               
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div style="width:100%;height: 1px;border-bottom: 1px solid #cccccc85;margin: 25px 0 25px;" ></div>

                            <!-- Price range -->
                            <div class="mb-3" >
                                <label for="price">{{translate('Price')}}</label>
                                <div class="row">
                                    <div class="col-6 pe-1" >
                                        <div class="form-group">
                                            <select style="height: 38px;" data-filter-label="min price" data-filter-id="ad_min_price"
                                            class="form-select fw-medium filter-input" id="ad_min_price" name="min_price">
                                                <option value="{{null}}">{{translate('from')}}</option>
                                                <option value="500">500</option>
                                                <option value="1000">1,000</option>
                                                <option value="1500">1,500</option>
                                                <option value="2000">2,000</option>
                                                <option value="2500">2,500</option>
                                                <option value="3000">3,000</option>
                                                <option value="3500">3,500</option>
                                                <option value="4000">4,000</option>
                                                <option value="4500">4,500</option>
                                                <option value="5000">5,000</option>
                                                <option value="5500">5,500</option>
                                                <option value="6000">6,000</option>
                                                <option value="6500">6,500</option>
                                                <option value="7000">7,000</option>
                                                <option value="7500">7,500</option>
                                                <option value="8000">8,000</option>
                                                <option value="8500">8,500</option>
                                                <option value="9000">9,000</option>
                                                <option value="9500">9,500</option>
                                                <option value="10000">10,000</option>
                                                <option value="12000">12,500</option>
                                                <option value="15000">15,000</option>
                                                <option value="17500">17,500</option>
                                                <option value="20000">20,000</option>
                                                <option value="30000">30,000</option>
                                                <option value="40000">40,000</option>
                                                <option value="50000">50,000</option>
                                                <option value="60000">60,000</option>
                                                <option value="70000">70,000</option>
                                                <option value="80000">80,000</option>
                                                <option value="90000">90,000</option>
                                                <option value="100000">100,000</option>
                                                <option value="125000">125,000</option>
                                                <option value="150000">150,000</option>
                                                <option value="175000">175,000</option>
                                                <option value="200000">200,000</option>
                                                <option value="300000">300,000</option>
                                                <option value="400000">400,000</option>
                                                <option value="500000">500,000</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 ps-1" >
                                        <div class="form-group">
                                            <select style="height: 38px;" class="form-select fw-medium filter-input" id="ad_max_price"
                                            data-filter-label="Max Price" data-filter-id="ad_max_price" name="max_price">
                                                <option value="{{null}}">{{translate('to')}}</option>
                                                <option value="500">500</option>
                                                <option value="1000">1,000</option>
                                                <option value="1500">1,500</option>
                                                <option value="2000">2,000</option>
                                                <option value="2500">2,500</option>
                                                <option value="3000">3,000</option>
                                                <option value="3500">3,500</option>
                                                <option value="4000">4,000</option>
                                                <option value="4500">4,500</option>
                                                <option value="5000">5,000</option>
                                                <option value="5500">5,500</option>
                                                <option value="6000">6,000</option>
                                                <option value="6500">6,500</option>
                                                <option value="7000">7,000</option>
                                                <option value="7500">7,500</option>
                                                <option value="8000">8,000</option>
                                                <option value="8500">8,500</option>
                                                <option value="9000">9,000</option>
                                                <option value="9500">9,500</option>
                                                <option value="10000">10,000</option>
                                                <option value="12000">12,500</option>
                                                <option value="15000">15,000</option>
                                                <option value="17500">17,500</option>
                                                <option value="20000">20,000</option>
                                                <option value="30000">30,000</option>
                                                <option value="40000">40,000</option>
                                                <option value="50000">50,000</option>
                                                <option value="60000">60,000</option>
                                                <option value="70000">70,000</option>
                                                <option value="80000">80,000</option>
                                                <option value="90000">90,000</option>
                                                <option value="100000">100,000</option>
                                                <option value="125000">125,000</option>
                                                <option value="150000">150,000</option>
                                                <option value="175000">175,000</option>
                                                <option value="200000">200,000</option>
                                                <option value="300000">300,000</option>
                                                <option value="400000">400,000</option>
                                                <option value="500000">500,000</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- year range -->
                            <div class="mb-3" id="year-box" >
                                <label class="mb-2" for="construction_year">{{translate('construction_year')}}</label>
                                <div class="row">
                                    <div class="col-6 pe-1" >
                                        <div class="form-group">
                                            <select style="height: 38px;" class="form-select filter-input fw-medium" 
                                            data-filter-label="Min Year" data-filter-id="min_construction_year" name="min_construction_year" id="min_construction_year" >
                                                <option value="{{null}}">{{translate('from')}}</option>    
                                                @for ($year = 2025; $year >= 1940; $year--)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 ps-1" >
                                        <div class="form-group">
                                            <select style="height: 38px;" class="form-select filter-input fw-medium" name="max_construction_year" 
                                            data-filter-label="Max Year" data-filter-id="max_construction_year" id="max_construction_year" >
                                                <option value="{{null}}">{{translate('to')}}</option>    
                                                @for ($year = 2025; $year >= 1940; $year--)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mileage range -->
                            <div class="mb-3" id="mileage-box">
                                <label class="mb-2" for="mileage">{{translate('mileage')}}</label>
                                <div class="row">
                                    <div class="col-6 pe-1" >
                                        <div class="form-group">
                                            <select style="height: 38px;" class="form-select filter-input fw-medium" 
                                            data-filter-label="Min Mileage" data-filter-id="min_mileage" id="min_mileage" name="min_mileage">
                                                <option value="{{null}}">{{translate('from')}}</option>
                                                <option value="500">500</option>
                                                <option value="1000">1,000</option>
                                                <option value="1500">1,500</option>
                                                <option value="2000">2,000</option>
                                                <option value="2500">2,500</option>
                                                <option value="3000">3,000</option>
                                                <option value="3500">3,500</option>
                                                <option value="4000">4,000</option>
                                                <option value="4500">4,500</option>
                                                <option value="5000">5,000</option>
                                                <option value="5500">5,500</option>
                                                <option value="6000">6,000</option>
                                                <option value="6500">6,500</option>
                                                <option value="7000">7,000</option>
                                                <option value="7500">7,500</option>
                                                <option value="8000">8,000</option>
                                                <option value="8500">8,500</option>
                                                <option value="9000">9,000</option>
                                                <option value="9500">9,500</option>
                                                <option value="10000">10000</option>
                                                <option value="12000">12,500</option>
                                                <option value="15000">15,000</option>
                                                <option value="17500">17,500</option>
                                                <option value="20000">20,000</option>
                                                <option value="30000">30,000</option>
                                                <option value="40000">40,000</option>
                                                <option value="50000">50,000</option>
                                                <option value="60000">60,000</option>
                                                <option value="70000">70,000</option>
                                                <option value="80000">80,000</option>
                                                <option value="90000">90,000</option>
                                                <option value="100000">100,000</option>
                                                <option value="125000">125,000</option>
                                                <option value="150000">150,000</option>
                                                <option value="175000">175,000</option>
                                                <option value="200000">200,000</option>
                                                <option value="300000">300,000</option>
                                                <option value="400000">400,000</option>
                                                <option value="500000">500,000</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 ps-1" >
                                        <div class="form-group">
                                            <select style="height: 38px;" class="form-select filter-input fw-medium" 
                                            data-filter-label="Max Mileage" data-filter-id="max_mileage" id="max_mileage" name="max_mileage">
                                                <option value="{{null}}">{{translate('to')}}</option>
                                                <option value="500">500</option>
                                                <option value="1000">1,000</option>
                                                <option value="1500">1,500</option>
                                                <option value="2000">2,000</option>
                                                <option value="2500">2,500</option>
                                                <option value="3000">3,000</option>
                                                <option value="3500">3,500</option>
                                                <option value="4000">4,000</option>
                                                <option value="4500">4,500</option>
                                                <option value="5000">5,000</option>
                                                <option value="5500">5,500</option>
                                                <option value="6000">6,000</option>
                                                <option value="6500">6,500</option>
                                                <option value="7000">7,000</option>
                                                <option value="7500">7,500</option>
                                                <option value="8000">8,000</option>
                                                <option value="8500">8,500</option>
                                                <option value="9000">9,000</option>
                                                <option value="9500">9,500</option>
                                                <option value="10000">10000</option>
                                                <option value="12000">12,500</option>
                                                <option value="15000">15,000</option>
                                                <option value="17500">17,500</option>
                                                <option value="20000">20,000</option>
                                                <option value="30000">30,000</option>
                                                <option value="40000">40,000</option>
                                                <option value="50000">50,000</option>
                                                <option value="60000">60,000</option>
                                                <option value="70000">70,000</option>
                                                <option value="80000">80,000</option>
                                                <option value="90000">90,000</option>
                                                <option value="100000">100,000</option>
                                                <option value="125000">125,000</option>
                                                <option value="150000">150,000</option>
                                                <option value="175000">175,000</option>
                                                <option value="200000">200,000</option>
                                                <option value="300000">300,000</option>
                                                <option value="400000">400,000</option>
                                                <option value="500000">500,000</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mb-lg-1 mb-lg-1 m-0 font-size-16 custom-width-50-mobile px-sm-3 px-0 input-responsive-height"
                                    onclick="formUrlChange(this)"
                                    data-action="{{ route('show-ads-filter') }}"
                                    data-filter-count="filter-count">
                                    <span class="ads-count-number">
                                        {{ \App\Model\Ad::count() }}
                                    </span>
                                    <span>{{ translate('result') }}</span>
                                    <div class="filter_count_loader spinner-border d-none" style="width: 18px;height: 18px;" role="status">
                                        <span class="visually-hidden"></span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


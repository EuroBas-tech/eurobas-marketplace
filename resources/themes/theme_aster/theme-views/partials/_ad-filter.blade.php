<style>
    #dropdownMenuButton:hover,
    #dropdownMenuButton:focus,
    #dropdownMenuButton:active {
        background-color: white !important;
        border-color: #ced4da !important;
        color: inherit !important;
        box-shadow: none !important;
    }

    .font-size-16 {
        font-size: 16px;
    }
    .font-size-15 {
        font-size: 15px;
    }

    .filter-button {
        max-width: 200px;
        min-width: 160px;
    }

</style>

<section class="banner w-100 sweet-shadow">
    <div class="card moble-border-0">
        <div class="p-0">
            <div class="row g-3 justify-content-center">
                <div class="col-xl-12">
                    <div class="rounded">
                        <div class="tab-content px-3">
                            <div class="tab-pane fade show active">
                                <form class="form-data" method="GET">
                                    <div class="row pb-1 pt-2">
                                        <div class="col-12">
                                            <div class="row align-items-center justify-content-between gap-2">
                                                <div class="col-xl-10 col-md-12 col-sm-12 col-12 px-1 flex-shrink-1" style="min-width:0;">
                                                    <div class="row g-2">
                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 mt-1">
                                                            <div class="form-group padding-bottom-sm">
                                                                <div class="dropup mb-1">
                                                                    <input class="filter-input" type="hidden" name="category_id" id="selectedCategoryId" value="0">
                                                                    <button style="border: 1px solid #ced4da;border-radius: 7px;" class="btn btn-outline-secondary w-100 custom-input-height justify-content-start"
                                                                        type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <span id="selectedCategoryText" class="fw-normal font-size-16" >
                                                                            {{translate('category')}}
                                                                        </span>
                                                                    </button>
                                                                    <ul class="dropdown-menu w-100 p-0" style="max-height: 50vh; overflow-y: auto;">
                                                                        <li class="p-0">
                                                                            <a onclick="triggerFilterManually(this)" class="dropdown-item d-flex font-size-16 align-items-center category-option p-2 gap-2" href="#"
                                                                                data-id="0"
                                                                                data-type="vehicles"
                                                                                data-slug="">
                                                                                {{ translate('category') }}
                                                                            </a>
                                                                        </li>
                                                                        @foreach($categories->where('position', 1) as $category)
                                                                            <li class="p-0">
                                                                                <a onclick="triggerFilterManually(this)" class="dropdown-item font-size-16 d-flex align-items-center category-option p-2 gap-2" href="#"
                                                                                    data-id="{{ $category['id'] }}"
                                                                                    data-type="{{ $category['category_type'] }}"
                                                                                    data-slug="{{ $category['slug'] }}">
                                                                                    <img src="{{ cloudfront('category/'.$category['icon'])}}" alt="" style="width: 25px; height: 25px;">
                                                                                    {{ ucwords($category['name']) }}
                                                                                </a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-12 col-12 px-1 mt-1" data-category-type="all">
                                                            <div class="form-group padding-bottom-sm">
                                                                <select class="form-control filter-input input-responsive-height font-size-16 custom-input-height emoji-font country-select" name="country" id="country_select">
                                                                    @foreach (SYSTEM_COUNTRIES as $country)
                                                                        <option class="emoji-font" value="{{ $country['name'] }}" dir="ltr">
                                                                            <bdi>{{ $country['emoji'] }} {{ $country['name'] }}</bdi>
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="vehicles"
                                                        data-for="cars, trucks, classic-cars, supercars, buses, spare-parts, motorcycles, caravans, heavy-equipment, agricultural-machinery, vehicle-accessories, agricultural-machinery">
                                                            <div class="form-group">
                                                                <select class="form-control filter-input input-responsive-height font-size-16 brand-select" name="brand_id" id="brand">
                                                                    <option value="all">{{translate('brand')}}</option>
                                                                    @foreach($brands as $brand)
                                                                        <option
                                                                        {{ $brand['id'] == ($data['brand_id'] ?? '') || $brand['id'] == old('brand_id') ? 'selected' : ''}}
                                                                        value="{{ $brand['id'] }}"
                                                                        data-brand-categories="{{ implode(', ', $brand['categories']) }}" >
                                                                            {{ $brand['name'] }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1"
                                                        data-category-type="vehicles" data-for="cars, trucks, classic-cars, supercars, spare-parts, motorcycles, buses, motorcycle-parts, caravans, heavy-equipment, agricultural-machinery, agricultural-machinery">
                                                            <div class="form-group">
                                                                <select disabled class="form-control filter-input input-responsive-height font-size-16 model-select" name="model_id" id="model">
                                                                    <option value="all">{{translate('model')}}</option>
                                                                    @foreach($models as $model)
                                                                        <option data-brand-id="{{ $model['brand_id'] }}"
                                                                        data-model-categories="{{ implode(', ', $model['categories']) }}"
                                                                        {{ $model['id'] == ($data['model_id'] ?? '') || $model['id'] == old('model_id') ? 'selected' : ''}}
                                                                        value="{{ $model['id'] }}">
                                                                            {{ $model['name'] }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="vehicles" data-for="bicycles" style="display: none;">
                                                            <div class="form-group">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="bicycle_type" id="bicycle_type">
                                                                    <option value="all">{{ translate('bicycle_type') }}</option>
                                                                    <option {{ old('bicycle_type') == 'road' ? 'selected' : ''}} value="road">{{ translate('road') }}</option>
                                                                    <option {{ old('bicycle_type') == 'mountain' ? 'selected' : ''}} value="mountain">{{ translate('mountain') }}</option>
                                                                    <option {{ old('bicycle_type') == 'hybrid' ? 'selected' : ''}} value="hybrid">{{ translate('hybrid') }}</option>
                                                                    <option {{ old('bicycle_type') == 'cruiser' ? 'selected' : ''}} value="cruiser">{{ translate('cruiser') }}</option>
                                                                    <option {{ old('bicycle_type') == 'bmx' ? 'selected' : ''}} value="bmx">{{ translate('bmx') }}</option>
                                                                    <option {{ old('bicycle_type') == 'folding' ? 'selected' : ''}} value="folding">{{ translate('folding') }}</option>
                                                                    <option {{ old('bicycle_type') == 'electric' ? 'selected' : ''}} value="electric">{{ translate('electric') }}</option>
                                                                    <option {{ old('bicycle_type') == 'tandem' ? 'selected' : ''}} value="tandem">{{ translate('tandem') }}</option>
                                                                    <option {{ old('bicycle_type') == 'track' ? 'selected' : ''}} value="track">{{ translate('track') }}</option>
                                                                    <option {{ old('bicycle_type') == 'fat_tire' ? 'selected' : ''}} value="fat_tire">{{ translate('fat_tire') }}</option>
                                                                    <option {{ old('bicycle_type') == 'fixed_gear' ? 'selected' : ''}} value="fixed_gear">{{ translate('fixed_gear') }}</option>
                                                                    <option {{ old('bicycle_type') == 'gravel' ? 'selected' : ''}} value="gravel">{{ translate('gravel') }}</option>
                                                                    <option {{ old('bicycle_type') == 'kids' ? 'selected' : ''}} value="kids">{{ translate('kids') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="vehicles" data-for="bicycles" style="display: none;">
                                                            <div class="form-group">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="bicycle_size" id="bicycle_size">
                                                                    <option value="all">{{ translate('bicycle_size') }}</option>
                                                                    <option {{ old('bicycle_size') == '12' ? 'selected' : ''}} value="12">12</option>
                                                                    <option {{ old('bicycle_size') == '14' ? 'selected' : ''}} value="14">14</option>
                                                                    <option {{ old('bicycle_size') == '16' ? 'selected' : ''}} value="16">16</option>
                                                                    <option {{ old('bicycle_size') == '18' ? 'selected' : ''}} value="18">18</option>
                                                                    <option {{ old('bicycle_size') == '20' ? 'selected' : ''}} value="20">20</option>
                                                                    <option {{ old('bicycle_size') == '24' ? 'selected' : ''}} value="24">24</option>
                                                                    <option {{ old('bicycle_size') == '26' ? 'selected' : ''}} value="26">26</option>
                                                                    <option {{ old('bicycle_size') == '27.5' ? 'selected' : ''}} value="27.5">27.5</option>
                                                                    <option {{ old('bicycle_size') == '28' ? 'selected' : ''}} value="28">28</option>
                                                                    <option {{ old('bicycle_size') == '29' ? 'selected' : ''}} value="29">29</option>
                                                                    <option {{ old('bicycle_size') == 'xs' ? 'selected' : ''}} value="xs">xs</option>
                                                                    <option {{ old('bicycle_size') == 's' ? 'selected' : ''}} value="s">s</option>
                                                                    <option {{ old('bicycle_size') == 'm' ? 'selected' : ''}} value="m">m</option>
                                                                    <option {{ old('bicycle_size') == 'l' ? 'selected' : ''}} value="l">l</option>
                                                                    <option {{ old('bicycle_size') == 'xl' ? 'selected' : ''}} value="xl">xl</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="vehicles" data-for="cars, trucks, buses, classic-cars, supercars, spare-parts, motorcycles, caravans, heavy-equipment, agricultural-machinery, vehicle-accessories, agricultural-machinery">
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16 custom-input-height" name="construction_year" id="construction_year_select">
                                                                    <option value="all">{{translate('year_from')}}</option>
                                                                    @for ($year = 2025; $year >= 1940; $year--)
                                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="furniture" data-for="furniture" style="display: none;">
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="furniture_material" id="furniture_material">
                                                                    <option value="all">{{ translate('furniture_material') }}</option>
                                                                    <option value="wood">{{ translate('wood') }}</option>
                                                                    <option value="leather">{{ translate('leather') }}</option>
                                                                    <option value="fabric">{{ translate('fabric') }}</option>
                                                                    <option value="metal">{{ translate('metal') }}</option>
                                                                    <option value="glass">{{ translate('glass') }}</option>
                                                                    <option value="plastic">{{ translate('plastic') }}</option>
                                                                    <option value="marble">{{ translate('marble') }}</option>
                                                                    <option value="rattan">{{ translate('rattan') }}</option>
                                                                    <option value="bamboo">{{ translate('bamboo') }}</option>
                                                                    <option value="foam">{{ translate('foam') }}</option>
                                                                    <option value="synthetic">{{ translate('synthetic') }}</option>
                                                                    <option value="other">{{ translate('other') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="furniture" data-for="furniture" style="display: none;">
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="furniture_type" id="furniture_type">
                                                                    <option value="all">{{ translate('furniture_type') }}</option>
                                                                    <option value="sofa">{{ translate('sofa') }}</option>
                                                                    <option value="bed">{{ translate('bed') }}</option>
                                                                    <option value="table">{{ translate('table') }}</option>
                                                                    <option value="chair">{{ translate('chair') }}</option>
                                                                    <option value="armchair">{{ translate('armchair') }}</option>
                                                                    <option value="dining_table">{{ translate('dining_table') }}</option>
                                                                    <option value="coffee_table">{{ translate('coffee_table') }}</option>
                                                                    <option value="tv_stand">{{ translate('tv_stand') }}</option>
                                                                    <option value="bookshelf">{{ translate('bookshelf') }}</option>
                                                                    <option value="wardrobe">{{ translate('wardrobe') }}</option>
                                                                    <option value="dresser">{{ translate('dresser') }}</option>
                                                                    <option value="nightstand">{{ translate('nightstand') }}</option>
                                                                    <option value="cabinet">{{ translate('cabinet') }}</option>
                                                                    <option value="desk">{{ translate('desk') }}</option>
                                                                    <option value="bench">{{ translate('bench') }}</option>
                                                                    <option value="stool">{{ translate('stool') }}</option>
                                                                    <option value="recliner">{{ translate('recliner') }}</option>
                                                                    <option value="console_table">{{ translate('console_table') }}</option>
                                                                    <option value="shoe_rack">{{ translate('shoe_rack') }}</option>
                                                                    <option value="vanity">{{ translate('vanity') }}</option>
                                                                    <option value="crib">{{ translate('crib') }}</option>
                                                                    <option value="bunk_bed">{{ translate('bunk_bed') }}</option>
                                                                    <option value="sideboard">{{ translate('sideboard') }}</option>
                                                                    <option value="ottoman">{{ translate('ottoman') }}</option>
                                                                    <option value="folding_bed">{{ translate('folding_bed') }}</option>
                                                                    <option value="rocking_chair">{{ translate('rocking_chair') }}</option>
                                                                    <option value="other">{{ translate('other') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="home garden" data-for="home-garden" style="display: none;">
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="home_garden_material" id="material">
                                                                    <option value="all">{{ translate('material') }}</option>
                                                                    <option value="wood">{{ translate('wood') }}</option>
                                                                    <option value="leather">{{ translate('leather') }}</option>
                                                                    <option value="fabric">{{ translate('fabric') }}</option>
                                                                    <option value="metal">{{ translate('metal') }}</option>
                                                                    <option value="glass">{{ translate('glass') }}</option>
                                                                    <option value="plastic">{{ translate('plastic') }}</option>
                                                                    <option value="marble">{{ translate('marble') }}</option>
                                                                    <option value="rattan">{{ translate('rattan') }}</option>
                                                                    <option value="bamboo">{{ translate('bamboo') }}</option>
                                                                    <option value="foam">{{ translate('foam') }}</option>
                                                                    <option value="synthetic">{{ translate('synthetic') }}</option>
                                                                    <option value="other">{{ translate('other') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="shipbuilding marine" data-for="ships-yachts" style="display: none;">
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="shipbuilding_type" id="type">
                                                                    <option value="all">{{ translate('shipbulding_marine_type') }}</option>
                                                                    <option {{ old('type') == 'yacht' ? 'selected' : ''}} value="yacht">{{ translate('yacht') }}</option>
                                                                    <option {{ old('type') == 'fishing_boat' ? 'selected' : ''}} value="fishing_boat">{{ translate('fishing_boat') }}</option>
                                                                    <option {{ old('type') == 'cargo_ship' ? 'selected' : ''}} value="cargo_ship">{{ translate('cargo_ship') }}</option>
                                                                    <option {{ old('type') == 'tanker' ? 'selected' : ''}} value="tanker">{{ translate('tanker') }}</option>
                                                                    <option {{ old('type') == 'container_ship' ? 'selected' : ''}} value="container_ship">{{ translate('container_ship') }}</option>
                                                                    <option {{ old('type') == 'ferry' ? 'selected' : ''}} value="ferry">{{ translate('ferry') }}</option>
                                                                    <option {{ old('type') == 'cruise_ship' ? 'selected' : ''}} value="cruise_ship">{{ translate('cruise_ship') }}</option>
                                                                    <option {{ old('type') == 'speedboat' ? 'selected' : ''}} value="speedboat">{{ translate('speedboat') }}</option>
                                                                    <option {{ old('type') == 'sailboat' ? 'selected' : ''}} value="sailboat">{{ translate('sailboat') }}</option>
                                                                    <option {{ old('type') == 'barge' ? 'selected' : ''}} value="barge">{{ translate('barge') }}</option>
                                                                    <option {{ old('type') == 'tugboat' ? 'selected' : ''}} value="tugboat">{{ translate('tugboat') }}</option>
                                                                    <option {{ old('type') == 'patrol_boat' ? 'selected' : ''}} value="patrol_boat">{{ translate('patrol_boat') }}</option>
                                                                    <option {{ old('type') == 'naval_ship' ? 'selected' : ''}} value="naval_ship">{{ translate('naval_ship') }}</option>
                                                                    <option {{ old('type') == 'submarine' ? 'selected' : ''}} value="submarine">{{ translate('submarine') }}</option>
                                                                    <option {{ old('type') == 'research_vessel' ? 'selected' : ''}} value="research_vessel">{{ translate('research_vessel') }}</option>
                                                                    <option {{ old('type') == 'offshore_support_vessel' ? 'selected' : ''}} value="offshore_support_vessel">{{ translate('offshore_support_vessel') }}</option>
                                                                    <option {{ old('type') == 'dredger' ? 'selected' : ''}} value="dredger">{{ translate('dredger') }}</option>
                                                                    <option {{ old('type') == 'icebreaker' ? 'selected' : ''}} value="icebreaker">{{ translate('icebreaker') }}</option>
                                                                    <option {{ old('type') == 'fireboat' ? 'selected' : ''}} value="fireboat">{{ translate('fireboat') }}</option>
                                                                    <option {{ old('type') == 'pilot_boat' ? 'selected' : ''}} value="pilot_boat">{{ translate('pilot_boat') }}</option>
                                                                    <option {{ old('type') == 'other' ? 'selected' : ''}} value="other">{{ translate('other') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="shipbuilding marine" data-for="ships-yachts" style="display: none;">
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="engines_number" id="engines_number">
                                                                    <option value="all">{{translate('number_of_engines')}}</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                    <option value="6">6</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="shipbuilding marine" data-for="ships-yachts" style="display: none;">
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="cabins_number" id="cabins_number">
                                                                    <option value="all">{{translate('number_of_cabins')}}</option>
                                                                    <option {{ old('cabins_number') == '1'  ?  'selected' : ''}} value="1">1</option>
                                                                    <option {{ old('cabins_number') == '2'  ?  'selected' : ''}} value="2">2</option>
                                                                    <option {{ old('cabins_number') == '3'  ?  'selected' : ''}} value="3">3</option>
                                                                    <option {{ old('cabins_number') == '4'  ?  'selected' : ''}} value="4">4</option>
                                                                    <option {{ old('cabins_number') == '5'  ?  'selected' : ''}} value="5">5</option>
                                                                    <option {{ old('cabins_number') == '6'  ?  'selected' : ''}} value="6">6</option>
                                                                    <option {{ old('cabins_number') == '7'  ?  'selected' : ''}} value="7">7</option>
                                                                    <option {{ old('cabins_number') == '8'  ?  'selected' : ''}} value="8">8</option>
                                                                    <option {{ old('cabins_number') == '9'  ?  'selected' : ''}} value="9">9</option>
                                                                    <option {{ old('cabins_number') == '10' ? 'selected' : ''}}  value="10">10</option>
                                                                    <option {{ old('cabins_number') == '11' ? 'selected' : ''}}  value="11">11</option>
                                                                    <option {{ old('cabins_number') == '12' ? 'selected' : ''}}  value="12">12</option>
                                                                    <option {{ old('cabins_number') == '13' ? 'selected' : ''}}  value="13">13</option>
                                                                    <option {{ old('cabins_number') == '14' ? 'selected' : ''}}  value="14">14</option>
                                                                    <option {{ old('cabins_number') == '15' ? 'selected' : ''}}  value="15">15</option>
                                                                    <option {{ old('cabins_number') == '16' ? 'selected' : ''}}  value="16">16</option>
                                                                    <option {{ old('cabins_number') == '17' ? 'selected' : ''}}  value="17">17</option>
                                                                    <option {{ old('cabins_number') == '18' ? 'selected' : ''}}  value="18">18</option>
                                                                    <option {{ old('cabins_number') == '19' ? 'selected' : ''}}  value="19">19</option>
                                                                    <option {{ old('cabins_number') == '20' ? 'selected' : ''}}  value="20">20</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="home garden" data-for="home-garden" style="display: none;">
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="usage" id="usage">
                                                                    <option value="all">{{translate('home_garden_usage')}}</option>
                                                                    <option {{ old('indoor') == 'new' ? 'selected' : ''}} value="indoor">{{translate('indoor')}}</option>
                                                                    <option {{ old('outdoor') == 'used' ? 'selected' : ''}} value="outdoor">{{translate('outdoor')}}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="industrial machines" data-for="industrial-machines" style="display: none;">
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="machine_type" id="machine_type">
                                                                    <option value="all">{{ translate('machine_type') }}</option>
                                                                    <option value="cutting">{{ translate('cutting') }}</option>
                                                                    <option value="forming">{{ translate('forming') }}</option>
                                                                    <option value="welding">{{ translate('welding') }}</option>
                                                                    <option value="molding">{{ translate('molding') }}</option>
                                                                    <option value="machining">{{ translate('machining') }}</option>
                                                                    <option value="packaging">{{ translate('packaging') }}</option>
                                                                    <option value="printing">{{ translate('printing') }}</option>
                                                                    <option value="assembling">{{ translate('assembling') }}</option>
                                                                    <option value="mixing">{{ translate('mixing') }}</option>
                                                                    <option value="pressing">{{ translate('pressing') }}</option>
                                                                    <option value="extruding">{{ translate('extruding') }}</option>
                                                                    <option value="rolling">{{ translate('rolling') }}</option>
                                                                    <option value="grinding">{{ translate('grinding') }}</option>
                                                                    <option value="polishing">{{ translate('polishing') }}</option>
                                                                    <option value="bending">{{ translate('bending') }}</option>
                                                                    <option value="lifting">{{ translate('lifting') }}</option>
                                                                    <option value="conveying">{{ translate('conveying') }}</option>
                                                                    <option value="cooling_heating">{{ translate('cooling_heating') }}</option>
                                                                    <option value="inspection">{{ translate('inspection') }}</option>
                                                                    <option value="cleaning">{{ translate('cleaning') }}</option>
                                                                    <option value="other">{{ translate('other') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="industrial machines" data-for="industrial-machines" style="display: none;">
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="power_source" id="power_source">
                                                                    <option value="all">{{ translate('power_source') }}</option>
                                                                    <option value="electric">{{translate('electric')}}</option>
                                                                    <option value="diesel">{{translate('diesel')}}</option>
                                                                    <option value="hydraulic">{{translate('hydraulic')}}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="home appliances" data-for="home-appliances" style="display: none;">
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="home_appliance_type" id="home_appliance_type">
                                                                    <option value="all">{{ translate('home_appliance_type') }}</option>
                                                                    <option value="refrigerator">{{ translate('refrigerator') }}</option>
                                                                    <option value="washing_machine">{{ translate('washing_machine') }}</option>
                                                                    <option value="microwave">{{ translate('microwave') }}</option>
                                                                    <option value="oven">{{ translate('oven') }}</option>
                                                                    <option value="dishwasher">{{ translate('dishwasher') }}</option>
                                                                    <option value="freezer">{{ translate('freezer') }}</option>
                                                                    <option value="cooker">{{ translate('cooker') }}</option>
                                                                    <option value="air_conditioner">{{ translate('air_conditioner') }}</option>
                                                                    <option value="vacuum_cleaner">{{ translate('vacuum_cleaner') }}</option>
                                                                    <option value="water_dispenser">{{ translate('water_dispenser') }}</option>
                                                                    <option value="fan">{{ translate('fan') }}</option>
                                                                    <option value="heater">{{ translate('heater') }}</option>
                                                                    <option value="water_heater">{{ translate('water_heater') }}</option>
                                                                    <option value="coffee_machine">{{ translate('coffee_machine') }}</option>
                                                                    <option value="blender">{{ translate('blender') }}</option>
                                                                    <option value="toaster">{{ translate('toaster') }}</option>
                                                                    <option value="other">{{ translate('other') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="electronics" data-for="electronics" style="display: none;">
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="electronic_type" id="electronic_type">
                                                                    <option value="all">{{ translate('type') }}</option>
                                                                    <option {{ old('electronic_type') == 'tv' ? 'selected' : ''}} value="tv">{{ translate('tv') }}</option>
                                                                    <option {{ old('electronic_type') == 'laptop' ? 'selected' : ''}} value="laptop">{{ translate('laptop') }}</option>
                                                                    <option {{ old('electronic_type') == 'desktop_computer' ? 'selected' : ''}} value="desktop_computer">{{ translate('desktop_computer') }}</option>
                                                                    <option {{ old('electronic_type') == 'tablet' ? 'selected' : ''}} value="tablet">{{ translate('tablet') }}</option>
                                                                    <option {{ old('electronic_type') == 'smartphone' ? 'selected' : ''}} value="smartphone">{{ translate('smartphone') }}</option>
                                                                    <option {{ old('electronic_type') == 'smartwatch' ? 'selected' : ''}} value="smartwatch">{{ translate('smartwatch') }}</option>
                                                                    <option {{ old('electronic_type') == 'camera' ? 'selected' : ''}} value="camera">{{ translate('camera') }}</option>
                                                                    <option {{ old('electronic_type') == 'printer' ? 'selected' : ''}} value="printer">{{ translate('printer') }}</option>
                                                                    <option {{ old('electronic_type') == 'scanner' ? 'selected' : ''}} value="scanner">{{ translate('scanner') }}</option>
                                                                    <option {{ old('electronic_type') == 'gaming_console' ? 'selected' : ''}} value="gaming_console">{{ translate('gaming_console') }}</option>
                                                                    <option {{ old('electronic_type') == 'monitor' ? 'selected' : ''}} value="monitor">{{ translate('monitor') }}</option>
                                                                    <option {{ old('electronic_type') == 'projector' ? 'selected' : ''}} value="projector">{{ translate('projector') }}</option>
                                                                    <option {{ old('electronic_type') == 'router' ? 'selected' : ''}} value="router">{{ translate('router') }}</option>
                                                                    <option {{ old('electronic_type') == 'speaker' ? 'selected' : ''}} value="speaker">{{ translate('speaker') }}</option>
                                                                    <option {{ old('electronic_type') == 'headphones' ? 'selected' : ''}} value="headphones">{{ translate('headphones') }}</option>
                                                                    <option {{ old('electronic_type') == 'earbuds' ? 'selected' : ''}} value="earbuds">{{ translate('earbuds') }}</option>
                                                                    <option {{ old('electronic_type') == 'drone' ? 'selected' : ''}} value="drone">{{ translate('drone') }}</option>
                                                                    <option {{ old('electronic_type') == 'vr_headset' ? 'selected' : ''}} value="vr_headset">{{ translate('vr_headset') }}</option>
                                                                    <option {{ old('electronic_type') == 'gps' ? 'selected' : ''}} value="gps">{{ translate('gps') }}</option>
                                                                    <option {{ old('electronic_type') == 'other' ? 'selected' : ''}} value="other">{{ translate('other') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="real estate" data-for="real-estate" style="display: none;">
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="listing_type" id="listing_type">
                                                                    <option value="all">{{ translate('listing_type') }}</option>
                                                                    <option {{ old('listing_type') == 'for_sale' ? 'selected' : ''}} value="for_sale">{{ translate('for_sale') }}</option>
                                                                    <option {{ old('listing_type') == 'for_rent' ? 'selected' : ''}} value="for_rent">{{ translate('for_rent') }}</option>
                                                                    <option {{ old('listing_type') == 'for_exchange' ? 'selected' : ''}} value="for_exchange">{{ translate('for_exchange') }}</option>
                                                                    <option {{ old('listing_type') == 'for_takeover' ? 'selected' : ''}} value="for_takeover">{{ translate('for_takeover') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="real estate" data-for="real-estate" style="display: none;">
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="property_type" id="property_type">
                                                                    <option value="all">{{ translate('listing_type') }}</option>
                                                                    <option {{ old('property_type') == 'apartment' ? 'selected' : ''}} value="apartment">{{ translate('apartment') }}</option>
                                                                    <option {{ old('property_type') == 'villa' ? 'selected' : ''}} value="villa">{{ translate('villa') }}</option>
                                                                    <option {{ old('property_type') == 'house' ? 'selected' : ''}} value="house">{{ translate('house') }}</option>
                                                                    <option {{ old('property_type') == 'detached_house' ? 'selected' : ''}} value="detached_house">{{ translate('detached_house') }}</option>
                                                                    <option {{ old('property_type') == 'land' ? 'selected' : ''}} value="land">{{ translate('land') }}</option>
                                                                    <option {{ old('property_type') == 'farm' ? 'selected' : ''}} value="farm">{{ translate('farm') }}</option>
                                                                    <option {{ old('property_type') == 'shop' ? 'selected' : ''}} value="shop">{{ translate('shop') }}</option>
                                                                    <option {{ old('property_type') == 'office' ? 'selected' : ''}} value="office">{{ translate('office') }}</option>
                                                                    <option {{ old('property_type') == 'warehouse' ? 'selected' : ''}} value="warehouse">{{ translate('warehouse') }}</option>
                                                                    <option {{ old('property_type') == 'building' ? 'selected' : ''}} value="building">{{ translate('building') }}</option>
                                                                    <option {{ old('property_type') == 'room' ? 'selected' : ''}} value="room">{{ translate('room') }}</option>
                                                                    <option {{ old('property_type') == 'chalet_holiday_home' ? 'selected' : ''}} value="chalet_holiday_home">{{ translate('chalet_holiday_home') }}</option>
                                                                    <option {{ old('property_type') == 'commercial_property' ? 'selected' : ''}} value="commercial_property">{{ translate('commercial_property') }}</option>
                                                                    <option {{ old('property_type') == 'industrial_property' ? 'selected' : ''}} value="industrial_property">{{ translate('industrial_property') }}</option>
                                                                    <option {{ old('property_type') == 'other' ? 'selected' : ''}} value="other">{{ translate('other') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="real estate" data-for="real-estate" style="display: none;">
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16" name="floor" id="floor">
                                                                    <option value="all">{{ translate('choose_floor') }}</option>
                                                                    <option {{ old('floor') == 'basement' ? 'selected' : ''}} value="basement">{{ translate('basement') }}</option>
                                                                    <option {{ old('floor') == 'ground' ? 'selected' : ''}} value="ground">{{ translate('ground') }}</option>
                                                                    @for ($i = 1; $i <= 30; $i++)
                                                                        <option {{ old('floor') == "$i" ? 'selected' : ''}} value="{{ $i }}">{{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>



                                                        <div class="col-xl-4 col-md-4 col-sm-6 col-6 px-1 input-responsive-height mt-1" data-category-type="all" >
                                                            <div class="form-group mb-3">
                                                                <select class="form-control filter-input input-responsive-height font-size-16 custom-input-height" name="price_range" id="price_range_select">
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

                                                    </div>
                                                </div>
                                                <div class="col-auto col-xl-auto col-md-12 col-sm-12 col-12 flex-grow-1 px-1 flex-shrink-0">
                                                    <div class="form-group d-flex filter-buttons gap-1 mb-2">
                                                        <button type="submit" class="btn btn-primary mb-lg-1 filter-button mb-lg-1 m-0 mt-xl-1 font-size-15 custom-width-50-mobile px-0 input-responsive-height"
                                                            onclick="formUrlChange(this)"
                                                            data-action="{{ route('show-ads-filter') }}"
                                                            data-filter-count="filter-count">
                                                            <span class="ads-count-number">
                                                                {{ \App\Model\Ad::active()->count() }}
                                                            </span>
                                                            <span>{{ translate('result') }}</span>
                                                            <div class="filter_count_loader spinner-border d-none" style="width: 18px;height: 18px;" role="status">
                                                                <span class="visually-hidden"></span>
                                                            </div>
                                                        </button>
                                                        <button type="button"
                                                        data-bs-toggle="modal" data-bs-target="#advancedFilterModal"
                                                        class="d-flex align-items-center gap-1 filter-button font-size-15 btn btn-outline-primary input-responsive-height custom-width-50-mobile px-0">
                                                            <i class="bi bi-funnel"></i>
                                                            <span>{{translate('advanced_filter')}}</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @include('theme-views.layouts.partials.modal._advanced-filter-modal')
                            </div>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ theme_asset('assets/js/jquery-3.6.0.min.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var swiper = new Swiper(".banner-swiper", {
            loop: true,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            speed: 1700,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // This ensures Bootstrap's tab functionality is properly initialized
        var tabElements = document.querySelectorAll('[data-bs-toggle="tab"]');
        tabElements.forEach(function(tabElement) {
            new bootstrap.Tab(tabElement);
        });
    });

</script>

<script>
    $(document).ready(function () {
        const selectedCategoryId = $('#selectedCategoryId').val();

        if (selectedCategoryId != 0) {
            const defaultOption = $(`.category-option[data-id="${selectedCategoryId}"]`);
            if (defaultOption.length) {
                const defaultType = defaultOption.data('type');
                const defaultSlug = defaultOption.data('slug')
                    ?? defaultOption.text().trim().toLowerCase().replace(/&/g, '').replace(/\s+/g, '-');

                $('#selectedCategoryText').html(defaultOption.html());

                $('[data-category-type][data-for]').each(function () {
                    const validTypes = $(this).data('category-type').toString().split(',');
                    const forValues = $(this).attr('data-for')?.split(',').map(s => s.trim()) || [];
                    const matchesType = validTypes.includes(defaultType);
                    const matchesSlug = forValues.includes(defaultSlug);
                    const shouldShow = matchesType && matchesSlug;

                    $(this).toggle(shouldShow).find('select, input, textarea').prop('disabled', !shouldShow);
                });
            }
        }

        $('.category-option').click(function(e) {
            e.preventDefault();

            const categoryType = $(this).data('type');
            const categoryId = $(this).data('id');
            const categorySlug = $(this).data('slug')
                ?? $(this).text().trim().toLowerCase().replace(/&/g, '').replace(/\s+/g, '-');

            $('#selectedCategoryText').html($(this).html());
            $('#selectedCategoryId').val(categoryId);

            // Hide and disable all except `all`
            $('[data-category-type]').not('[data-category-type="all"]').hide().find('select, input, textarea').prop('disabled', true);

            // ✅ Always show "all" filters (like price/country)
            $('[data-category-type="all"]').show().find('select, input, textarea').prop('disabled', false);


            // Show matching filters
            $('[data-category-type]').each(function () {
                const types = $(this).data('category-type').toString().split(',');
                const forList = ($(this).attr('data-for') || '').split(',').map(s => s.trim());

                const matchesType = types.includes('all') || types.includes(categoryType);
                const matchesSlug =
                categorySlug === ''
                    ? forList.includes('cars') // show filters if they support 'cars'
                    : forList.length === 0 || forList.includes(categorySlug);

                const shouldShow = matchesType && matchesSlug;

                if ($(this).data('category-type') !== 'all') {
                    $(this).toggle(shouldShow).find('select, input, textarea').prop('disabled', !shouldShow);
                }
            });

        });
    });

</script>

<script>
    $(document).ready(function () {
        const $brandSelect = $('#brand');
        const $modelSelect = $('#model');
        const $categoryInput = $('#selectedCategoryId');

        $('#model').prop('disabled', true);

        // Initialize Select2
        $brandSelect.select2({
            placeholder: "{{ translate('brand') }}",
            allowClear: true
        });

        $modelSelect.select2({
            placeholder: "{{ translate('model') }}",
            allowClear: true
        });

        const allBrandOptions = $brandSelect.find('option').clone();
        const allModelOptions = $modelSelect.find('option').clone();

        const allBrandOption = '<option value="all">{{ translate("brand") }}</option>';
        const allModelOption = '<option value="all">{{ translate("model") }}</option>';

        function filterBrandsAndModels() {
            const selectedCategoryId = $categoryInput.val();
            const addedBrandValues = new Set(['all']);

            $brandSelect.empty().append(allBrandOption);

            if (selectedCategoryId === "0") {
                allBrandOptions.each(function () {
                    const value = $(this).val();
                    if (value !== 'all' && !addedBrandValues.has(value)) {
                        $brandSelect.append($(this).clone());
                        addedBrandValues.add(value);
                    }
                });
            } else {
                allBrandOptions.each(function () {
                    const value = $(this).val();
                    const brandCategories = $(this).data('brand-categories')?.toString().split(',').map(s => s.trim()) || [];

                    if (
                        value === 'all' ||
                        brandCategories.includes(selectedCategoryId)
                    ) {
                        if (!addedBrandValues.has(value)) {
                            $brandSelect.append($(this).clone());
                            addedBrandValues.add(value);
                        }
                    }
                });
            }

            $brandSelect.val('all').trigger('change');
        }

        function filterModels() {

            const selectedBrandId = $brandSelect.val();
            const selectedCategoryId = $categoryInput.val();

            $modelSelect.empty().append(allModelOption);
            const addedValues = new Set(['all']);

            allModelOptions.each(function () {
                const brandId = $(this).data('brand-id');
                const modelCategories = $(this).data('model-categories')?.toString().split(',').map(s => s.trim()) || [];
                const value = $(this).val();

                const brandMatch = !brandId || brandId == selectedBrandId || selectedBrandId === 'all';
                const categoryMatch = selectedCategoryId === "0" || modelCategories.includes(selectedCategoryId);

                if (brandMatch && categoryMatch && !addedValues.has(value)) {
                    $modelSelect.append($(this).clone());
                    addedValues.add(value);
                }
            });

            // $modelSelect.val('all').trigger('change').prop('disabled', false);
        }

        $('.category-option').on('click', function () {
            const selectedCategoryId = $(this).data('id');
            $categoryInput.val(selectedCategoryId);
            filterBrandsAndModels();
        });

        let initialized = false;

        $brandSelect.on('select2:select', function (e) {
            const selectedValue = e.params.data.id;
            if (initialized) {
                if (selectedValue === 'all') {
                    $modelSelect.val('all').trigger('change').prop('disabled', true);
                } else {
                    $('#model').prop('disabled', false);
                }
            }
        });

        $brandSelect.on('change', function() {
            filterModels();
        });

        filterBrandsAndModels();
        initialized = true;

    });
</script>

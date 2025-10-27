<div id="environmental-information-box" class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
    <div class="mb-2" >
        <h2 class="mb-3" >{{ translate('environmental_information') }}</h2>
    </div>
    <div class="row">
        <div class="col-xl-4 mb-3">
            <div class="form-group">
                <label for="co2_emissions">{{translate('co2_emissions')}} ({{ translate('gram_on_ kilometre') }}) ({{ translate('Optional') }})</label>
                <input type="text" id="co2_emissions" class="form-control" value="{{old('co2_emissions')}}" name="co2_emissions" placeholder="{{translate('co2_emissions')}}">
            </div>
        </div>
        <div class="col-xl-4 mb-3">
            <div class="form-group">
                <label for="energy_consumption">{{translate('energy_consumption')}} ({{ translate('litre_on_ kilometre') }}) ({{ translate('Optional') }})</label>
                <input type="text" id="energy_consumption" class="form-control" value="{{old('energy_consumption')}}" name="energy_consumption" placeholder="{{translate('energy_consumption')}}">
            </div>
        </div>
        <div class="col-xl-4 mb-3">
            <div class="form-group">
                <label for="gas_emission_tax">{{translate('gas_emission_tax')}} ({{ translate('Optional') }})</label>
                <input type="text" id="gas_emission_tax" class="form-control" value="{{old('gas_emission_tax')}}" name="gas_emission_tax" placeholder="{{translate('gas_emission_tax')}}">
            </div>
        </div>
    </div>
</div>
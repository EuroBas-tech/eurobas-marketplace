<div id="additional-information-box" class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
    <div class="mb-2" >
        <h2 class="mb-3" >{{ translate('additional_information') }}</h2>
    </div>
    <div class="row">
        <div class="col-xl-4 mb-3">
            <div class="form-group">
                <label for="previous_scan_date">{{translate('previous_scan_date')}} ({{ translate('Optional') }})</label>
                <input type="date" id="previous_scan_date" class="form-control" value="{{$ad->previous_scan_date}}" name="previous_scan_date" placeholder="{{translate('previous_scan_date')}}">
            </div>
        </div>
        <div class="col-xl-4 mb-3">
            <div class="form-group">
                <label for="battery_charging_time">{{translate("battery_charging_time")}} ({{ translate('Optional') }})</label>
                <input type="text" id="battery_charging_time" class="form-control" value="{{$ad->battery_charging_time}}" name="battery_charging_time" placeholder="{{translate('battery_charging_time')}}">
            </div>
        </div>
        <div class="col-xl-4 mb-3">
            <div class="form-group">
                <label for="fast_battery_charging_time">{{translate("fast_battery_charging_time")}} ({{ translate('Optional') }})</label>
                <input type="text" id="fast_battery_charging_time" class="form-control" value="{{$ad->fast_battery_charging_time}}" name="fast_battery_charging_time" placeholder="{{translate('battery_charging_time')}}">
            </div>
        </div>
        <div class="col-xl-4 mb-3">
            <div class="form-group">
                <label for="battery_life">{{translate("battery_life")}} ({{ translate('Optional') }})</label>
                <input type="text" id="battery_life" class="form-control" value="{{$ad->battery_life}}" name="battery_life" placeholder="{{translate('battery_life')}}">
            </div>
        </div>
        <div class="col-xl-4 mb-3">
            <div class="form-group">
                <label for="Acceleration_0_100">{{translate("Acceleration_0_100")}} ({{ translate('Optional') }})</label>
                <input type="text" id="Acceleration_0_100" class="form-control" value="{{$ad->acceleration_0_100}}" name="acceleration_0_100" placeholder="{{translate('Acceleration_0_100')}}">
            </div>
        </div>
    </div>
</div>
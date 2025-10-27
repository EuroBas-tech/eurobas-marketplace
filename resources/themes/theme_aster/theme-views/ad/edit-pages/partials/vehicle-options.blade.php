<div id="ad-options-box" class="mb-1 border px-3 py-3 rounded custom-gray-border-color">
    <div class="mb-3">
        <h2 class="mb-3">{{ translate('ad_options') }}</h2>
    </div>

    @php
        $options = [
            '360_camera', '4x4', 'modified_for_disabled', 'abs', 'rear_view_camera',
            'adaptive_lights', 'adaptive_cruise_control', 'airbags', 'air_conditioning',
            'alarm', 'android_auto', 'apple_carplay', 'autonomous_driving', 'bluetooth',
            'cornering_lights', 'onboard_computer', 'central_locking', 'climate_control',
            'cruise_control', 'roof_rails', 'blind_spot_monitor', 'electric_tailgate',
            'electric_mirrors', 'electric_seat_adjustment', 'electronic_stability_program',
            'electric_windows', 'emergency_brake_assist', 'head_up_display', 'isofix',
            'keyless_entry', 'lane_departure_warning', 'lane_keeping_assist', 'led_lights',
            'leather_seats', 'alloy_wheels', 'light_sensor', 'metallic_paint', 'fog_lights',
            'navigation_system', 'sunroof', 'panoramic_roof', 'parking_assist', 'parking_camera',
            'parking_sensors', 'radio', 'rain_sensor', 'sliding_door', 'sport_package',
            'sport_seats', 'voice_control', 'immobilizer', 'start_stop_system', 'seat_massage',
            'seat_ventilation', 'heated_seats', 'steering_wheel_heating', 'traction_control',
            'tow_bar', 'usb_ports', 'traffic_sign_recognition', 'fatigue_detection',
            'heated_mirrors', 'front_view_camera', 'xenon_lights', 'cd_player',
            'daytime_running_lights', 'gps', 'multifunction_steering_wheel', 'power_steering',
            'rear_ac_vents', 'remote_start', 'touchscreen_display', 'tpms', 'wireless_charging'
        ];

        // Make sure it's always an array
        $old_options = is_string($ad->options)
            ? json_decode($ad->options, true)
            : ($ad->options ?? []);
    @endphp

    <div class="row">
        @foreach($options as $option)
            <div class="col-sm-3 mb-3">
                <div class="form-group d-flex gap-1 align-items-center">
                    <input type="hidden" name="options[{{ $option }}]" value="false">
                    <input 
                        type="checkbox" 
                        id="{{ $option }}" 
                        name="options[{{ $option }}]" 
                        value="true"
                        {{ isset($old_options[$option]) && $old_options[$option] === 'true' ? 'checked' : '' }}>
                    <label class="m-0" for="{{ $option }}">{{ translate($option) }}</label>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
    <div class="mb-2" >
        <h2 class="mb-3" >{{ translate('contact_informations') }}</h2>
    </div>
    <div class="row">
        <div class="col-sm-12 mb-2">
            <div class="form-group">
                <label class="mb-1" for="name">{{translate('name_on_ad')}}</label>
                <input disabled type="text" id="name" class="form-control" 
                value="{{ auth('customer')->user()->name }}" name="name" placeholder="{{translate('name')}}">
            </div>
        </div>
        <div class="col-sm-12 mb-1">
            <div class="form-group form-check form-switch d-flex gap-5 p-0 align-items-center">
                <label class="m-0" for="show-email-address">{{translate('show_email_address_on_ad')}} ?</label>
                <input class="form-check-input" checked
                name="show_email_address" type="checkbox" role="switch" id="show-email-address">
            </div>
        </div>
        <div id="email-address" class="col-sm-12 mb-3">
            <div class="form-group">
                <input disabled type="text" id="email_address" class="form-control" 
                value="{{ auth('customer')->user()->email }}" name="email_address" placeholder="{{translate('email_address')}}">
            </div>
        </div>
        <div class="col-sm-12 mb-1">
            <div class="form-group form-check form-switch d-flex gap-5 p-0 align-items-center">
                <label class="m-0" for="show-phone-number">{{translate('show_phone_number_on_ad')}} ?</label>
                <input class="form-check-input" checked
                name="show_phone_number" type="checkbox" role="switch" id="show-phone-number">
            </div>
        </div>
        <div id="phone-number" class="col-sm-12 mb-2">
            <div class="form-group">
                <div class="d-flex align-items-center gap-2 mb-2" >
                    <label class="m-0 fs-13 d-flex align-items-center gap-1" for="whatsapp_availability">
                        <img width="28px" src="https://static.vecteezy.com/system/resources/previews/016/716/480/non_2x/whatsapp-icon-free-png.png" alt="">
                        <span>{{translate('whatsApp_available')}} ?</span>
                    </label>
                    <input class="form-check-input m-0" name="whatsapp_availability" 
                    {{ $ad['whatsapp_availability'] ? 'checked' : '' }} type="checkbox" id="whatsapp_availability">
                </div>                                                        
                
                <div class="form-group" id="phone_number">
                    <label for="phone_number">{{translate('phone_number')}}</label>
                    <div class="input-group">
                        <select name="phone_code" id="phone_code_select" class="form-select emoji-font" style="max-width: 110px;">
                            <option {{ $ad['phone_code'] == '+1' ? 'selected' : '' }} class="emoji-font" selected value="+1" data-flag="🇺🇸" data-code="+1">🇺🇸 +1 United States</option>
                            <option {{ $ad['phone_code'] == '+44' ? 'selected' : '' }} class="emoji-font" value="+44" data-flag="🇬🇧" data-code="+44">🇬🇧 +44 United Kingdom</option>
                            <option {{ $ad['phone_code'] == '+33' ? 'selected' : '' }} class="emoji-font" value="+33" data-flag="🇫🇷" data-code="+33">🇫🇷 +33 France</option>
                            <option {{ $ad['phone_code'] == '+49' ? 'selected' : '' }} class="emoji-font" value="+49" data-flag="🇩🇪" data-code="+49">🇩🇪 +49 Germany</option>
                            <option {{ $ad['phone_code'] == '+39' ? 'selected' : '' }} class="emoji-font" value="+39" data-flag="🇮🇹" data-code="+39">🇮🇹 +39 Italy</option>
                            <option {{ $ad['phone_code'] == '+34' ? 'selected' : '' }} class="emoji-font" value="+34" data-flag="🇪🇸" data-code="+34">🇪🇸 +34 Spain</option>
                            <option {{ $ad['phone_code'] == '+31' ? 'selected' : '' }} class="emoji-font" value="+31" data-flag="🇳🇱" data-code="+31">🇳🇱 +31 Netherlands</option>
                            <option {{ $ad['phone_code'] == '+32' ? 'selected' : '' }} class="emoji-font" value="+32" data-flag="🇧🇪" data-code="+32">🇧🇪 +32 Belgium</option>
                            <option {{ $ad['phone_code'] == '+43' ? 'selected' : '' }} class="emoji-font" value="+43" data-flag="🇦🇹" data-code="+43">🇦🇹 +43 Austria</option>
                            <option {{ $ad['phone_code'] == '+48' ? 'selected' : '' }} class="emoji-font" value="+48" data-flag="🇵🇱" data-code="+48">🇵🇱 +48 Poland</option>
                            <option {{ $ad['phone_code'] == '+45' ? 'selected' : '' }} class="emoji-font" value="+45" data-flag="🇩🇰" data-code="+45">🇩🇰 +45 Denmark</option>
                            <option {{ $ad['phone_code'] == '+46' ? 'selected' : '' }} class="emoji-font" value="+46" data-flag="🇸🇪" data-code="+46">🇸🇪 +46 Sweden</option>
                            <option {{ $ad['phone_code'] == '+358' ? 'selected' : '' }} class="emoji-font" value="+358" data-flag="🇫🇮" data-code="+358">🇫🇮 +358 Finland</option>
                            <option {{ $ad['phone_code'] == '+351' ? 'selected' : '' }} class="emoji-font" value="+351" data-flag="🇵🇹" data-code="+351">🇵🇹 +351 Portugal</option>
                            <option {{ $ad['phone_code'] == '+30' ? 'selected' : '' }} class="emoji-font" value="+30" data-flag="🇬🇷" data-code="+30">🇬🇷 +30 Greece</option>
                            <option {{ $ad['phone_code'] == '+420' ? 'selected' : '' }} class="emoji-font" value="+420" data-flag="🇨🇿" data-code="+420">🇨🇿 +420 Czech Republic</option>
                            <option {{ $ad['phone_code'] == '+36' ? 'selected' : '' }} class="emoji-font" value="+36" data-flag="🇭🇺" data-code="+36">🇭🇺 +36 Hungary</option>
                            <option {{ $ad['phone_code'] == '+40' ? 'selected' : '' }} class="emoji-font" value="+40" data-flag="🇷🇴" data-code="+40">🇷🇴 +40 Romania</option>
                            <option {{ $ad['phone_code'] == '+359' ? 'selected' : '' }} class="emoji-font" value="+359" data-flag="🇧🇬" data-code="+359">🇧🇬 +359 Bulgaria</option>
                            <option {{ $ad['phone_code'] == '+421' ? 'selected' : '' }} class="emoji-font" value="+421" data-flag="🇸🇰" data-code="+421">🇸🇰 +421 Slovakia</option>
                            <option {{ $ad['phone_code'] == '+352' ? 'selected' : '' }} class="emoji-font" value="+352" data-flag="🇱🇺" data-code="+352">🇱🇺 +352 Luxembourg</option>
                            <option {{ $ad['phone_code'] == '+386' ? 'selected' : '' }} class="emoji-font" value="+386" data-flag="🇸🇮" data-code="+386">🇸🇮 +386 Slovenia</option>
                            <option {{ $ad['phone_code'] == '+41' ? 'selected' : '' }} class="emoji-font" value="+41" data-flag="🇨🇭" data-code="+41">🇨🇭 +41 Switzerland</option>
                            <option {{ $ad['phone_code'] == '+47' ? 'selected' : '' }} class="emoji-font" value="+47" data-flag="🇳🇴" data-code="+47">🇳🇴 +47 Norway</option>
                            <option {{ $ad['phone_code'] == '+354' ? 'selected' : '' }} class="emoji-font" value="+354" data-flag="🇮🇸" data-code="+354">🇮🇸 +354 Iceland</option>
                            <option {{ $ad['phone_code'] == '+370' ? 'selected' : '' }} class="emoji-font" value="+370" data-flag="🇱🇹" data-code="+370">🇱🇹 +370 Lithuania</option>
                            <option {{ $ad['phone_code'] == '+371' ? 'selected' : '' }} class="emoji-font" value="+371" data-flag="🇱🇻" data-code="+371">🇱🇻 +371 Latvia</option>
                            <option {{ $ad['phone_code'] == '+372' ? 'selected' : '' }} class="emoji-font" value="+372" data-flag="🇪🇪" data-code="+372">🇪🇪 +372 Estonia</option>
                            <option {{ $ad['phone_code'] == '+385' ? 'selected' : '' }} class="emoji-font" value="+385" data-flag="🇭🇷" data-code="+385">🇭🇷 +385 Croatia</option>
                            <option {{ $ad['phone_code'] == '+381' ? 'selected' : '' }} class="emoji-font" value="+381" data-flag="🇷🇸" data-code="+381">🇷🇸 +381 Serbia</option>
                            <option {{ $ad['phone_code'] == '+387' ? 'selected' : '' }} class="emoji-font" value="+387" data-flag="🇧🇦" data-code="+387">🇧🇦 +387 Bosnia and Herzegovina</option>
                            <option {{ $ad['phone_code'] == '+353' ? 'selected' : '' }} class="emoji-font" value="+353" data-flag="🇮🇪" data-code="+353">🇮🇪 +353 Ireland</option>
                            <option {{ $ad['phone_code'] == '+355' ? 'selected' : '' }} class="emoji-font" value="+355" data-flag="🇦🇱" data-code="+355">🇦🇱 +355 Albania</option>
                            <option {{ $ad['phone_code'] == '+389' ? 'selected' : '' }} class="emoji-font" value="+389" data-flag="🇲🇰" data-code="+389">🇲🇰 +389 North Macedonia</option>
                            <option {{ $ad['phone_code'] == '+373' ? 'selected' : '' }} class="emoji-font" value="+373" data-flag="🇲🇩" data-code="+373">🇲🇩 +373 Moldova</option>
                            <option {{ $ad['phone_code'] == '+380' ? 'selected' : '' }} class="emoji-font" value="+380" data-flag="🇺🇦" data-code="+380">🇺🇦 +380 Ukraine</option>
                            <option {{ $ad['phone_code'] == '+375' ? 'selected' : '' }} class="emoji-font" value="+375" data-flag="🇧🇾" data-code="+375">🇧🇾 +375 Belarus</option>
                            <option {{ $ad['phone_code'] == '+86' ? 'selected' : '' }} class="emoji-font" value="+86" data-flag="🇨🇳" data-code="+86">🇨🇳 +86 China</option>
                            <option {{ $ad['phone_code'] == '+7' ? 'selected' : '' }} class="emoji-font" value="+7" data-flag="🇷🇺" data-code="+7">🇷🇺 +7 Russia</option>
                            <option {{ $ad['phone_code'] == '+383' ? 'selected' : '' }} class="emoji-font" value="+383" data-flag="🇽🇰" data-code="+383">🇽🇰 +383 Kosovo</option>
                            <option {{ $ad['phone_code'] == '+377' ? 'selected' : '' }} class="emoji-font" value="+377" data-flag="🇲🇨" data-code="+377">🇲🇨 +377 Monaco</option>
                            <option {{ $ad['phone_code'] == '+357' ? 'selected' : '' }} class="emoji-font" value="+357" data-flag="🇨🇾" data-code="+357">🇨🇾 +357 Cyprus</option>
                            <option {{ $ad['phone_code'] == '+423' ? 'selected' : '' }} class="emoji-font" value="+423" data-flag="🇱🇮" data-code="+423">🇱🇮 +423 Liechtenstein</option>
                            <option {{ $ad['phone_code'] == '+356' ? 'selected' : '' }} class="emoji-font" value="+356" data-flag="🇲🇹" data-code="+356">🇲🇹 +356 Malta</option>
                            <option {{ $ad['phone_code'] == '+382' ? 'selected' : '' }} class="emoji-font" value="+382" data-flag="🇲🇪" data-code="+382">🇲🇪 +382 Montenegro</option>
                            <option {{ $ad['phone_code'] == '+81' ? 'selected' : '' }} class="emoji-font" value="+81" data-flag="🇯🇵" data-code="+81">🇯🇵 +81 Japan</option>
                            <option {{ $ad['phone_code'] == '+82' ? 'selected' : '' }} class="emoji-font" value="+82" data-flag="🇰🇷" data-code="+82">🇰🇷 +82 South Korea</option>
                        </select>
                        <input type="tel" class="form-control input-height" value="{{ $ad->contact_phone_number }}" name="contact_phone_number" placeholder="{{translate('Ex:  01xxxxxxxxx')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
    <div class="mb-2" >
        <h2 class="mb-3" >{{ translate('location_informations') }}</h2>
    </div>
    <div class="row">
        <div class="col-xl-4">
            <div class="form-group mb-3">
                <label for="delivery_service_name">{{ translate('country') }}</label>
                <select class="form-control custom-input-height emoji-font" id="country" name="country" >
                    <option value="">{{ translate('choose_the_country') }}</option>
                    @foreach (array_slice(SYSTEM_COUNTRIES, 1) as $country)
                        <option {{ $ad['country'] == $country['name'] ? 'selected' : '' }} class="emoji-font" value="{{$country['name']}}">{{$country['emoji']}} {{ $country['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="form-group">
                <label for="city">{{translate("city")}}</label>
                <input type="text" id="address-city" class="form-control" 
                value="{{$ad->city}}" name="city" 
                placeholder="{{translate('city')}}">
            </div>
        </div>
        <div class="col-xl-4">
            <div class="form-group">
                <label for="postal_code">{{translate("postal_code")}} ({{ translate('Optional') }})</label>
                <input type="text" id="postal-code" class="form-control" 
                value="{{$ad->postal_code}}" name="postal_code" 
                placeholder="{{translate('postal_code')}}">
            </div>
        </div>                                                
        <div class="col-sm-12">
            <div class="form-group">
                <div class="mb-3 position-relative">
                    <input id="pac-input" class="controls rounded __inline-46" title="{{translate('search_your_location_here')}}" type="text" placeholder="{{translate('search_here')}}"/>
                    <div class="dark-support rounded w-100 __h-14rem" id="location_map_canvas"></div>
                </div>
                <div class="d-flex justify-content-end" >
                    <button class="btn btn-outline-primary btn-sm" type="button" id="find_location">{{ translate('find_my_location') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectElement = document.getElementById('phone_code_select');
        
        // Store original content for all options on page load
        Array.from(selectElement.options).forEach(option => {
            if (!option.getAttribute('data-original')) {
                option.setAttribute('data-original', option.innerHTML);
            }
        });
        
        // Function to update only the selected option display (compact format)
        function updateSelectedDisplay() {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            if (selectedOption) {
                const flag = selectedOption.getAttribute('data-flag');
                const code = selectedOption.getAttribute('data-code');
                
                // Update to show only flag and code for selected option
                selectedOption.innerHTML = `${flag} ${code}`;
            }
        }
        
        // Function to restore full display for ALL options (including selected)
        function restoreAllOptionsToFull() {
            Array.from(selectElement.options).forEach(option => {
                const original = option.getAttribute('data-original');
                if (original) {
                    option.innerHTML = original;
                }
            });
        }
        
        // Update display on page load
        updateSelectedDisplay();
        
        // Handle change event
        selectElement.addEventListener('change', function() {
            // Small delay to ensure the selection is complete
            setTimeout(() => {
                updateSelectedDisplay();
            }, 50);
        });
        
        // When dropdown opens, show full names for all options
        selectElement.addEventListener('focus', function() {
            restoreAllOptionsToFull();
        });
        
        selectElement.addEventListener('click', function() {
            restoreAllOptionsToFull();
        });
        
        // When dropdown closes, make selected option compact again
        selectElement.addEventListener('blur', function() {
            setTimeout(() => {
                updateSelectedDisplay();
            }, 150);
        });
        
        // Handle keyboard navigation
        selectElement.addEventListener('keydown', function(e) {
            // On Enter or Space, restore full display for selection
            if (e.key === 'Enter' || e.key === ' ') {
                restoreAllOptionsToFull();
            }
        });
        
        selectElement.addEventListener('keyup', function(e) {
            // After keyboard selection, update display
            if (e.key === 'Enter' || e.key === 'ArrowUp' || e.key === 'ArrowDown') {
                setTimeout(() => {
                    updateSelectedDisplay();
                }, 50);
            }
        });
    });
</script>

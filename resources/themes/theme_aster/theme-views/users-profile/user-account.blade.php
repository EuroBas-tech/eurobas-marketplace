@extends('theme-views.layouts.app')

@section('title', translate('Personal_Details').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@push('css_or_js')
    <style>
        .label-line-height {
            line-height: 1.1;
        }
    </style>
@endpush

@section('content')

    <!-- Aside Toggle Button -->
    @include('theme-views.partials._aside-toggler-btn')

    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 py-sm-3 pt-0 mb-4">
        <div class="container">
            <div class="row g-4">
                <!-- Sidebar-->
                @include('theme-views.partials._profile-aside')
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body p-lg-4 card-border card-border aside-shadow">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <h5>{{translate('Edit_Personal_Details')}}</h5>
                                <a href="{{ route('user-profile') }}" class="btn-link text-secondary d-flex align-items-baseline">
                                    <i class="bi bi-chevron-left fs-12"></i> {{translate('Go_back')}}
                                </a>
                            </div>

                            <div class="mt-4">
                                <form  action="{{route('user-update')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-3">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="name">{{ $customerDetail['account_type'] == 'company' ? translate('business_name') : translate('profile_name') }}</label>
                                                <input type="text" id="name" class="form-control input-height" value="{{$customerDetail['name']}}" name="name" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="form-group">
                                                <label for="bio">{{translate('bio')}}</label>
                                                <textarea id="bio" class="form-control input-height" name="bio" placeholder="{{translate('describe_your_business')}}">{{ $customerDetail['bio'] }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group" >
                                                <label for="phone_code">{{translate('Phone')}}</label>
                                                <div class="form-check form-switch d-flex gap-1 p-0 align-items-center mb-1">
                                                    <input class="form-check-input m-0" {{$customerDetail['show_phone_number'] == 1 ? 'checked' : ''}}
                                                    name="show_phone_number" type="checkbox" role="switch" id="show-phone-number">
                                                    <label class="m-0 fs-13 label-line-height" for="show-phone-number">{{translate('show_phone_number_on_profile')}} {{app()->getLocale() == 'ae' ? ' ؟' : ' ?'}}</label>
                                                </div>
                                                <div class="input-group">

                                                    @php
                                                        $countries = [
                                                            ['code' => '+1', 'flag' => '🇺🇸', 'name' => 'United States'],
                                                            ['code' => '+44', 'flag' => '🇬🇧', 'name' => 'United Kingdom'],
                                                            ['code' => '+33', 'flag' => '🇫🇷', 'name' => 'France'],
                                                            ['code' => '+49', 'flag' => '🇩🇪', 'name' => 'Germany'],
                                                            ['code' => '+39', 'flag' => '🇮🇹', 'name' => 'Italy'],
                                                            ['code' => '+34', 'flag' => '🇪🇸', 'name' => 'Spain'],
                                                            ['code' => '+31', 'flag' => '🇳🇱', 'name' => 'Netherlands'],
                                                            ['code' => '+32', 'flag' => '🇧🇪', 'name' => 'Belgium'],
                                                            ['code' => '+43', 'flag' => '🇦🇹', 'name' => 'Austria'],
                                                            ['code' => '+48', 'flag' => '🇵🇱', 'name' => 'Poland'],
                                                            ['code' => '+45', 'flag' => '🇩🇰', 'name' => 'Denmark'],
                                                            ['code' => '+46', 'flag' => '🇸🇪', 'name' => 'Sweden'],
                                                            ['code' => '+358', 'flag' => '🇫🇮', 'name' => 'Finland'],
                                                            ['code' => '+351', 'flag' => '🇵🇹', 'name' => 'Portugal'],
                                                            ['code' => '+30', 'flag' => '🇬🇷', 'name' => 'Greece'],
                                                            ['code' => '+420', 'flag' => '🇨🇿', 'name' => 'Czech Republic'],
                                                            ['code' => '+36', 'flag' => '🇭🇺', 'name' => 'Hungary'],
                                                            ['code' => '+40', 'flag' => '🇷🇴', 'name' => 'Romania'],
                                                            ['code' => '+359', 'flag' => '🇧🇬', 'name' => 'Bulgaria'],
                                                            ['code' => '+421', 'flag' => '🇸🇰', 'name' => 'Slovakia'],
                                                            ['code' => '+352', 'flag' => '🇱🇺', 'name' => 'Luxembourg'],
                                                            ['code' => '+386', 'flag' => '🇸🇮', 'name' => 'Slovenia'],
                                                            ['code' => '+41', 'flag' => '🇨🇭', 'name' => 'Switzerland'],
                                                            ['code' => '+47', 'flag' => '🇳🇴', 'name' => 'Norway'],
                                                            ['code' => '+354', 'flag' => '🇮🇸', 'name' => 'Iceland'],
                                                            ['code' => '+370', 'flag' => '🇱🇹', 'name' => 'Lithuania'],
                                                            ['code' => '+371', 'flag' => '🇱🇻', 'name' => 'Latvia'],
                                                            ['code' => '+372', 'flag' => '🇪🇪', 'name' => 'Estonia'],
                                                            ['code' => '+385', 'flag' => '🇭🇷', 'name' => 'Croatia'],
                                                            ['code' => '+381', 'flag' => '🇷🇸', 'name' => 'Serbia'],
                                                            ['code' => '+387', 'flag' => '🇧🇦', 'name' => 'Bosnia and Herzegovina'],
                                                            ['code' => '+353', 'flag' => '🇮🇪', 'name' => 'Ireland'],
                                                            ['code' => '+355', 'flag' => '🇦🇱', 'name' => 'Albania'],
                                                            ['code' => '+389', 'flag' => '🇲🇰', 'name' => 'North Macedonia'],
                                                            ['code' => '+373', 'flag' => '🇲🇩', 'name' => 'Moldova'],
                                                            ['code' => '+380', 'flag' => '🇺🇦', 'name' => 'Ukraine'],
                                                            ['code' => '+375', 'flag' => '🇧🇾', 'name' => 'Belarus'],
                                                            ['code' => '+86', 'flag' => '🇨🇳', 'name' => 'China'],
                                                            ['code' => '+7', 'flag' => '🇷🇺', 'name' => 'Russia'],
                                                            ['code' => '+383', 'flag' => '🇽🇰', 'name' => 'Kosovo'],
                                                            ['code' => '+377', 'flag' => '🇲🇨', 'name' => 'Monaco'],
                                                            ['code' => '+357', 'flag' => '🇨🇾', 'name' => 'Cyprus'],
                                                            ['code' => '+423', 'flag' => '🇱🇮', 'name' => 'Liechtenstein'],
                                                            ['code' => '+356', 'flag' => '🇲🇹', 'name' => 'Malta'],
                                                            ['code' => '+382', 'flag' => '🇲🇪', 'name' => 'Montenegro'],
                                                            ['code' => '+81', 'flag' => '🇯🇵', 'name' => 'Japan'],
                                                            ['code' => '+82', 'flag' => '🇰🇷', 'name' => 'South Korea'],
                                                        ];
                                                    @endphp

                                                    <select name="phone_code" id="phone_code_select" class="form-select emoji-font input-height" style="max-width: 110px;">
                                                        @foreach ($countries as $country)
                                                            <option
                                                                class="emoji-font"
                                                                value="{{ $country['code'] }}"
                                                                data-flag="{{ $country['flag'] }}"
                                                                data-code="{{ $country['code'] }}"
                                                                {{ $customerDetail['phone_code'] == $country['code'] ? 'selected' : '' }}
                                                            >
                                                                {{ $country['flag'] }} {{ $country['code'] }} {{ $country['name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="tel" id="phone_number" class="form-control input-height" value="{{$customerDetail['phone']}}" name="phone_number" placeholder="{{translate('Ex:  01xxxxxxxxx')}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="email">{{translate('Email')}}</label>
                                                <div class="form-check form-switch d-flex gap-1 p-0 align-items-center mb-1">
                                                    <input class="form-check-input m-0" {{$customerDetail['show_email_address'] == 1 ? 'checked' : ''}}
                                                    name="show_email_address" type="checkbox" role="switch" id="show-email-address">
                                                    <label class="m-0 fs-13 line-height" for="show-email-address">{{translate('show_email_address_on_profile')}} {{app()->getLocale() == 'ae' ? ' ؟' : ' ?'}}</label>
                                                </div>
                                                <input type="email" id="email" value="{{$customerDetail['email']}}" name="email" class="form-control input-height" value="">
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="email">{{translate('native_language')}}</label>
                                                <select class="form-control custom-input-height emoji-font" name="native_language" id="native_language" >
                                                    @foreach (SYSTEM_LANGUAGE_FLAGS as $key =>$country)
                                                        <option {{ $country['code'] == $customerDetail['native_language'] ? 'selected' : '' }}
                                                            class="emoji-font" value="{{$country['code']}}">
                                                            {{ $country['flag']}} {{ ucwords($country['name']) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="password2">{{translate('Password')}}</label>
                                                <div class="input-inner-end-ele">
                                                    <input type="password" minlength="6" id="password" class="form-control input-height" name="password" placeholder="{{translate('Ex:_7+ character')}}">
                                                    <i class="bi bi-eye-slash-fill togglePassword custom-inset-block-end"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="confirm_password2">{{translate('Confirm_Password')}}</label>
                                                <div class="input-inner-end-ele">
                                                    <input type="password" minlength="6" id="confirm_password" name="confirm_password" class="form-control input-height" placeholder="{{translate('Ex:_7+_character')}}">
                                                    <i class="bi bi-eye-slash-fill togglePassword custom-inset-block-end"></i>
                                                </div>
                                            </div>
                                            <div id='message'></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>{{translate('image')}}</label>
                                                <div class="d-flex flex-column gap-2">
                                                    <div class="upload-file width-min-content">
                                                        <input
                                                            type="file"
                                                            class="upload-file__input image width-min-content"
                                                            name="image"
                                                            id="thumbnail-input"
                                                            accept="image/*"
                                                            aria-required="true"
                                                            data-old="{{$customerDetail['image'] ? cloudfront('profile/images/'.$customerDetail['image']) : theme_asset('assets/img/avatar/def-image.jpg')  }}"
                                                        >
                                                        <div class="upload-file__img">
                                                            <div class="temp-img-box">
                                                                <div class="d-flex align-items-center flex-column gap-2">
                                                                    <i class="bi bi-upload fs-30"></i>
                                                                    <div class="fs-12 text-muted">{{translate('change_your_profile')}}</div>
                                                                </div>
                                                            </div>
                                                            <img src="#" class="dark-support img-fit-contain border" alt="" hidden="">
                                                        </div>
                                                    </div>

                                                    <div class="text-muted">{{translate('Image_ratio_should_be')}} 1:1</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                                <label>{{ translate('profile_cover') }}</label>
                                                <div class="row d-flex flex-column gap-2">
                                                    <div class="upload-file col-12 col-lg-7 col-md-6">
                                                        <input
                                                            type="file"
                                                            class="upload-file__input cover"
                                                            name="cover_image"
                                                            id="cover-input"
                                                            aria-required="true"
                                                            accept="image/*"
                                                            data-old="{{ $customerDetail['cover_image'] ? env_asset('storage/profile/covers/'.$customerDetail['cover_image']) : theme_asset('assets/img/avatar/def-cover-image.jpg') }}"
                                                        >
                                                        <div class="upload-file__img w-100">
                                                            <div class="temp-img-box">
                                                                <div class="d-flex align-items-center flex-column gap-2">
                                                                    <i class="bi bi-upload fs-30"></i>
                                                                    <div class="fs-12 text-muted">{{ translate('cover_image') }}</div>
                                                                </div>
                                                            </div>
                                                            <img src="#" class="dark-support image-fit-cover border" alt="" hidden="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="width:100%;height: 1px;border-bottom: 1px solid #cccccc85;margin: 40px 0 35px;" ></div>

                                        <div class="col-md-6">
                                            <div class="">
                                                <h6 class="fw-semibold text-muted mb-3">{{translate('Choose_Label')}}</h6>
                                                <ul class="option-select-btn flex-wrap style--two gap-4 mb-3">
                                                    <li>
                                                        <label>
                                                            <input type="radio" name="street_address_type" value="home" hidden {{ $customerDetail['street_address_type'] == 'home' ? 'checked' : '' }}>
                                                            <span><i class="bi bi-house"></i></span>
                                                        </label>
                                                        {{translate('Home')}}
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="radio" name="street_address_type" value="permanent" hidden="" {{ $customerDetail['street_address_type'] == 'permanent' ? 'checked' : '' }}>
                                                            <span><i class="bi bi-paperclip"></i></span>
                                                        </label>
                                                        {{translate('Permanent')}}
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="radio" name="street_address_type" value="office" hidden="" {{ $customerDetail['street_address_type'] == 'office' ? 'checked' : '' }}>
                                                            <span><i class="bi bi-briefcase"></i></span>
                                                        </label>
                                                        {{translate('Office')}}
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="form-check form-switch d-flex gap-1 p-0 align-items-center mb-3">
                                                <input class="form-check-input m-0" {{$customerDetail['show_location_data'] == 1 ? 'checked' : ''}}
                                                name="show_location_data" type="checkbox" role="switch" id="show-location-data">
                                                <label class="m-0 fs-14 line-height" for="show-location-data">{{translate('show_location_data_on_profile')}} {{app()->getLocale() == 'ae' ? ' ؟' : ' ?'}}</label>
                                            </div>

                                            <div class="form-group mb-3 ">
                                                <label for="country">{{translate('Country')}}</label>
                                                <select class="form-control custom-input-height emoji-font" name="country" id="country" >
                                                    @foreach (array_slice(SYSTEM_COUNTRIES, 1) as $country)
                                                        <option {{ $customerDetail['country'] == $country['name'] ? 'selected' : '' }} class="emoji-font" value="{{$country['name']}}">{{$country['emoji']}} {{ $country['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="city">{{translate('City')}}</label>
                                                <input class="form-control input-height" value="{{$customerDetail['city']}}" type="text" id="address-city" name="city" required>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="postal_code">{{translate('postal_code')}}</label>
                                                <input class="form-control input-height" value="{{$customerDetail['postal_code']}}" type="text" id="postal-code" name="postal_code">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="address">{{translate('Address')}}</label>
                                                <textarea name="street_address" id="address" rows="5" class="form-control input-height" placeholder="{{translate('Ex:_1216_Dhaka')}}">{{$customerDetail['street_address']}}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-5 mt-md-0">
                                            <div class="mt-5 mb-2 position-relative">
                                                <input id="pac-input" class="controls rounded __inline-46" title="{{translate('search_your_location_here')}}" type="text" placeholder="{{translate('search_here')}}"/>
                                                <div class="dark-support rounded w-100 __h-14rem" id="location_map_canvas"></div>
                                            </div>
                                            <div class="d-flex justify-content-end" >
                                                <button class="btn btn-outline-primary btn-sm" type="button" id="find_location">{{translate('find_my_location')}}</button>
                                            </div>
                                        </div>
                                        <input type="hidden" id="latitude"
                                               name="latitude" class="form-control d-inline"
                                               placeholder="" value="0" required readonly>
                                        <input type="hidden"
                                               name="longitude" class="form-control"
                                               placeholder="" id="longitude" value="0" required >

                                        <div class="col-12">
                                            <div class="d-flex justify-content-end gap-3">
                                                <button type="reset" class="btn btn-secondary">{{translate('Reset')}}</button>
                                                <button type="submit" class="btn btn-primary">{{translate('Update_Profile')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <!-- End Main Content -->
@endsection

@push('script')


    <script>
        $(document).ready(function() {
            window.onload = function () {
                CKEDITOR.replace('bio');
            };
        });
    </script>

    <script>
        $(window).on("load", function () {
            let input = $(".upload-file__input.image");
            let img = input
                .siblings(".upload-file__img")
                .find("img")
                .removeAttr("hidden");

            input
                .siblings(".upload-file__img")
                .find(".temp-img-box")
                .remove();

            img.attr("src", input.data("old"));
        });

        $(window).on("load", function () {
            let input = $(".upload-file__input.cover");
            let img = input
                .siblings(".upload-file__img")
                .find("img")
                .removeAttr("hidden");

            input
                .siblings(".upload-file__img")
                .find(".temp-img-box")
                .remove();

            img.attr("src", input.data("old"));
        });

    </script>

    <script>
        function checkPasswordMatch() {
            var password = $("#password").val();
            var confirmPassword = $("#confirm_password").val();
            $("#message").removeAttr("style");
            $("#message").html("");
            if (confirmPassword == "") {
                $("#message").attr("style", "color:black");
                $("#message").html("{{translate('Please_ReType_Password')}}");

            } else if (password == "") {
                $("#message").removeAttr("style");
                $("#message").html("");

            } else if (password != confirmPassword) {
                $("#message").html("{{translate('Passwords_do_not_match')}}!");
                $("#message").attr("style", "color:red");
            } else if (confirmPassword.length <= 7) {
                $("#message").html("{{translate('password_Must_Be_8_Character')}}");
                $("#message").attr("style", "color:red");
            } else {

                $("#message").html("{{translate('Passwords_match')}}.");
                $("#message").attr("style", "color:green");
            }
        }
        $(document).ready(function () {
            $("#confirm_password").keyup(checkPasswordMatch);
        });
        $( "#password" ).on("keyup", function() {
            if ($( "#confirm_password" ).val() != '') {
                checkPasswordMatch();
            }
        } );
    </script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById('phone_code_select');

    // Function to update the selected option display
    function updateSelectedDisplay() {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        if (selectedOption) {
            const flag = selectedOption.getAttribute('data-flag');
            const code = selectedOption.getAttribute('data-code');

            // Create a temporary option to show only flag and code
            const tempOption = document.createElement('option');
            tempOption.value = selectedOption.value;
            tempOption.textContent = `${flag} ${code}`;
            tempOption.selected = true;

            // Replace the selected option temporarily
            const originalHTML = selectedOption.innerHTML;
            selectedOption.innerHTML = tempOption.innerHTML;

            // Store original content for when dropdown opens
            selectedOption.setAttribute('data-original', originalHTML);
        }
    }

    // Function to restore full display when dropdown opens
    function restoreFullDisplay() {
        Array.from(selectElement.options).forEach(option => {
            const original = option.getAttribute('data-original');
            if (original) {
                option.innerHTML = original;
                option.removeAttribute('data-original');
            }
        });
    }

    // Update display on page load
    updateSelectedDisplay();

    // Handle change event
    selectElement.addEventListener('change', function() {
        updateSelectedDisplay();
    });

    // Handle focus to show full options
    selectElement.addEventListener('focus', function() {
        restoreFullDisplay();
    });

    // Handle blur to show compact display
    selectElement.addEventListener('blur', function() {
        setTimeout(() => {
            updateSelectedDisplay();
        }, 100);
    });
});
</script>





<script>
        function initAutocomplete() {
            // Check if there's existing data in the form
            const hasExistingData = () => {
                const country = document.getElementById('country').value;
                const city = document.getElementById('address-city').value.trim();
                const postalCode = document.getElementById('postal-code').value.trim();
                const address = document.getElementById('address').value.trim();

                // Only return true if there's meaningful data (not just a default country selection)
                return city || postalCode || address;
            };

            // Europe center coordinates and bounds
            let myLatLng = { lat: 54.5260, lng: 15.2551 }; // Center of Europe

            // Initialize the map
            const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                center: myLatLng,
                zoom: 4, // Zoom level to show all of Europe
                mapTypeId: "roadmap",
            });

            // Create marker variable but don't add it to map initially
            let marker = null;

            // Only create marker if there's existing data
            if (hasExistingData()) {
                marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    draggable: true
                });
            }

            // Initialize geocoder
            const geocoder = new google.maps.Geocoder();

            // Define debounce function
            function debounce(func, wait, immediate) {
                var timeout;
                return function() {
                    var context = this, args = arguments;
                    var later = function() {
                        timeout = null;
                        if (!immediate) func.apply(context, args);
                    };
                    var callNow = immediate && !timeout;
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                    if (callNow) func.apply(context, args);
                };
            }

            // Function to create marker if it doesn't exist
            function createMarkerIfNeeded(position) {
                if (!marker) {
                    marker = new google.maps.Marker({
                        position: position,
                        map: map,
                        draggable: true
                    });

                    // Add drag event listener to new marker
                    google.maps.event.addListener(marker, 'dragend', function(event) {
                        updateFormFields(event.latLng.lat(), event.latLng.lng());
                    });
                }
            }

            // Function to focus map based on current fields
            function focusOnLocation() {
                const country = document.getElementById('country').value;
                const city = document.getElementById('address-city').value;
                const postalCode = document.getElementById('postal-code').value;
                const address = document.getElementById('address').value;

                let searchQuery = '';

                // Determine what to search based on what fields are filled
                if (address) {
                    searchQuery = `${address}, ${city}, ${country}`;
                } else if (postalCode) {
                    searchQuery = `${postalCode}, ${city}, ${country}`;
                } else if (city) {
                    searchQuery = `${city}, ${country}`;
                } else if (country) {
                    searchQuery = country;
                }

                if (searchQuery) {
                    geocodeAddress(searchQuery);
                }
            }

            // Function to geocode an address and center map
            function geocodeAddress(address) {
                geocoder.geocode({ address: address }, function(results, status) {
                    if (status === 'OK' && results[0]) {
                        const location = results[0].geometry.location;
                        map.setCenter(location);

                        // Create marker if it doesn't exist
                        createMarkerIfNeeded(location);
                        marker.setPosition(location);

                        // Adjust zoom based on how specific the address is
                        if (document.getElementById('address').value) {
                            map.setZoom(16); // Very specific (street level)
                        } else if (document.getElementById('postal-code').value) {
                            map.setZoom(14); // Postal code level
                        } else if (document.getElementById('address-city').value) {
                            map.setZoom(10); // City level
                        } else {
                            map.setZoom(5); // Country level
                        }

                        // Update hidden fields if they exist
                        if (document.getElementById('latitude')) {
                            document.getElementById('latitude').value = location.lat();
                        }
                        if (document.getElementById('longitude')) {
                            document.getElementById('longitude').value = location.lng();
                        }
                    }
                });
            }

            // Function to update form fields based on coordinates
            function updateFormFields(lat, lng) {
                const latlng = new google.maps.LatLng(lat, lng);

                geocoder.geocode({ 'location': latlng }, function(results, status) {
                    if (status === 'OK' && results[0]) {
                        const addressComponents = results[0].address_components;
                        const formattedAddress = results[0].formatted_address;

                        // Extract country, city, and postal code
                        let country = '';
                        let city = '';
                        let postalCode = '';

                        // Parse address components
                        for (let component of addressComponents) {
                            const types = component.types;

                            if (types.includes('country')) {
                                country = component.long_name;
                            }

                            if (types.includes('postal_code')) {
                                postalCode = component.long_name;
                            }

                            if (types.includes('locality')) {
                                city = component.long_name;
                            } else if (types.includes('sublocality_level_1') && !city) {
                                city = component.long_name;
                            } else if (types.includes('administrative_area_level_2') && !city) {
                                city = component.long_name;
                            } else if (types.includes('administrative_area_level_1') && !city) {
                                city = component.long_name;
                            }
                        }

                        // Clean city name
                        if (city) {
                            city = city.replace(/^(Greater|Metropolitan|City of|Municipality of|Borough of)\s+/i, '');
                        }

                        // Update country dropdown
                        const countrySelect = document.getElementById('country');
                        for (let option of countrySelect.options) {
                            if (option.text.includes(country)) {
                                countrySelect.value = option.value;
                                break;
                            }
                        }

                        // Update city field
                        if (city) {
                            document.getElementById('address-city').value = city;
                        }

                        // Update postal code field
                        if (postalCode && document.getElementById('postal-code')) {
                            document.getElementById('postal-code').value = postalCode;
                        }

                        // Update address field
                        document.getElementById('address').value = formattedAddress;

                        // Update hidden coordinates
                        if (document.getElementById('latitude')) {
                            document.getElementById('latitude').value = lat;
                        }
                        if (document.getElementById('longitude')) {
                            document.getElementById('longitude').value = lng;
                        }
                    }
                });
            }

            // NEW: Function to find user's current location using GPS
            function findCurrentLocation() {
                const findLocationBtn = document.getElementById('find_location');

                // Check if geolocation is supported
                if (!navigator.geolocation) {
                    alert('Geolocation is not supported by this browser.');
                    return;
                }

                // Show loading state
                if (findLocationBtn) {
                    findLocationBtn.disabled = true;
                    findLocationBtn.textContent = 'Finding location...';
                }

                // Get current position
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const userLocation = new google.maps.LatLng(lat, lng);

                        // Center map on user's location
                        map.setCenter(userLocation);
                        map.setZoom(16); // Set to street level zoom

                        // Create marker if it doesn't exist
                        createMarkerIfNeeded(userLocation);
                        marker.setPosition(userLocation);

                        // Update form fields with the location data
                        updateFormFields(lat, lng);

                        // Reset button state
                        if (findLocationBtn) {
                            findLocationBtn.disabled = false;
                            findLocationBtn.textContent = 'Find My Location';
                        }
                    },
                    function(error) {
                        let errorMessage = 'Unable to retrieve your location. ';

                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += 'Please allow location access.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += 'Location information is unavailable.';
                                break;
                            case error.TIMEOUT:
                                errorMessage += 'Location request timed out.';
                                break;
                            default:
                                errorMessage += 'An unknown error occurred.';
                                break;
                        }

                        alert(errorMessage);

                        // Reset button state
                        if (findLocationBtn) {
                            findLocationBtn.disabled = false;
                            findLocationBtn.textContent = 'Find My Location';
                        }
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 300000 // 5 minutes
                    }
                );
            }

            // NEW: Add event listener for find location button
            const findLocationBtn = document.getElementById('find_location');
            if (findLocationBtn) {
                findLocationBtn.addEventListener('click', findCurrentLocation);
            }

            // Map click event
            google.maps.event.addListener(map, 'click', function(mapsMouseEvent) {
                const coordinates = mapsMouseEvent.latLng.toJSON();

                // Create marker if it doesn't exist
                createMarkerIfNeeded(new google.maps.LatLng(coordinates.lat, coordinates.lng));
                marker.setPosition(new google.maps.LatLng(coordinates.lat, coordinates.lng));
                map.panTo(new google.maps.LatLng(coordinates.lat, coordinates.lng));
                updateFormFields(coordinates.lat, coordinates.lng);
            });

            // Marker drag event (only add if marker exists)
            if (marker) {
                google.maps.event.addListener(marker, 'dragend', function(event) {
                    updateFormFields(event.latLng.lat(), event.latLng.lng());
                });
            }

            // Create search box if pac-input exists
            const input = document.getElementById("pac-input");
            if (input) {
                const searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

                map.addListener("bounds_changed", () => {
                    searchBox.setBounds(map.getBounds());
                });

                let searchMarkers = [];

                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();

                    if (places.length == 0) return;

                    searchMarkers.forEach(marker => marker.setMap(null));
                    searchMarkers = [];

                    const bounds = new google.maps.LatLngBounds();
                    places.forEach((place) => {
                        if (!place.geometry) return;

                        // Create marker if it doesn't exist
                        createMarkerIfNeeded(place.geometry.location);
                        marker.setPosition(place.geometry.location);
                        map.setCenter(place.geometry.location);
                        updateFormFields(place.geometry.location.lat(), place.geometry.location.lng());

                        if (place.geometry.viewport) {
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });

                    map.fitBounds(bounds);
                });
            }

            // Focus on user's existing location when page loads (only if there's existing data)
            if (hasExistingData()) {
                setTimeout(focusOnLocation, 1000);
            }

            // Define event handlers with debouncing
            const debouncedFocus = debounce(focusOnLocation, 500);

            // Country change handler
            document.getElementById('country').addEventListener('change', function() {
                document.getElementById('address-city').value = '';
                document.getElementById('postal-code').value = '';
                document.getElementById('address').value = '';
                debouncedFocus();
            });

            // City input handler
            document.getElementById('address-city').addEventListener('input', function() {
                if (!this.value) return;
                document.getElementById('postal-code').value = '';
                document.getElementById('address').value = '';
                debouncedFocus();
            });

            // Postal code input handler
            document.getElementById('postal-code').addEventListener('input', function() {
                if (!this.value) return;
                document.getElementById('address').value = '';
                debouncedFocus();
            });

            // Address input handler
            document.getElementById('address').addEventListener('input', function() {
                if (!this.value) return;
                debouncedFocus();
            });
        }

        // Initialize when document is ready
        $(document).ready(function() {
            initAutocomplete();
        });

        // Prevent form submission on Enter key
        $(document).on("keydown", "input", function(e) {
            if (e.which == 13) e.preventDefault();
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{\App\CPU\Helpers::get_business_settings('map_api_key')}}&callback=initAutocomplete&libraries=places&v=3.49" defer></script>
@endpush


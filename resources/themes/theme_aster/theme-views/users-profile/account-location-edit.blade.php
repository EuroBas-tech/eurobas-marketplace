@extends('theme-views.layouts.app')

@section('title', translate('My_Address').' | '.$web_config['name']->value.' '.translate('ecommerce'))
@push('css_or_js')
    <link rel="stylesheet" href="{{ theme_asset('assets/plugins/select2/css/select2.min.css') }}">
    <style>
        .select2{
            max-width: 100%;
            border-radius: 0.375rem;
            border: 1px solid #ced4da;
        }
    </style>
@endpush

@section('content')
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-5">
        <div class="container">
            <div class="row g-4">
                <!-- Sidebar-->
                @include('theme-views.partials._profile-aside')
                <div class="col">
                    
                </div>
            </div>
        </div>
    </main>


    <!-- End Main Content -->
@endsection
@push('script')
    <script src="https://maps.googleapis.com/maps/api/js?key={{\App\CPU\Helpers::get_business_settings('map_api_key')}}&callback=initAutocomplete&libraries=places&v=3.49" defer></script>

    <script>
        function initAutocomplete() {
            // Default coordinates
            let myLatLng = { lat: '-33.8688', lng: '151.2195' };
            
            // Initialize the map
            const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                center: myLatLng,
                zoom: 13,
                mapTypeId: "roadmap",
            });

            // Create initial marker
            let marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                draggable: true
            });

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

            // Map click event
            google.maps.event.addListener(map, 'click', function(mapsMouseEvent) {
                const coordinates = mapsMouseEvent.latLng.toJSON();
                marker.setPosition(new google.maps.LatLng(coordinates.lat, coordinates.lng));
                map.panTo(new google.maps.LatLng(coordinates.lat, coordinates.lng));
                updateFormFields(coordinates.lat, coordinates.lng);
            });

            // Marker drag event
            google.maps.event.addListener(marker, 'dragend', function(event) {
                updateFormFields(event.latLng.lat(), event.latLng.lng());
            });

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

            // Focus on user's existing location when page loads
            setTimeout(focusOnLocation, 1000);

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
@endpush

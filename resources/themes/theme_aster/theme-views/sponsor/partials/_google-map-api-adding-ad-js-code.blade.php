<script>
    function initAutocomplete() {
        // Europe center coordinates (roughly centered on Germany/Central Europe)
        let myLatLng = { lat: 50.1109, lng: 8.6821 };
        
        // Initialize the map focused on Europe
        const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
            center: myLatLng,
            zoom: 4, // Zoom level to show most of Europe
            mapTypeId: "roadmap",
        });

        // Initialize marker as null - no initial marker
        let marker = null;

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

        // Function to create or update marker
        function createOrUpdateMarker(position) {
            if (marker) {
                marker.setPosition(position);
            } else {
                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    draggable: true
                });
                
                // Add drag event listener when marker is created
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
            
            let searchQuery = '';
            
            // Determine what to search based on what fields are filled
            if (city && postalCode) {
                searchQuery = `${postalCode}, ${city}, ${country}`;
            } else if (city) {
                searchQuery = `${city}, ${country}`;
            } else if (postalCode) {
                searchQuery = `${postalCode}, ${country}`;
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
                    createOrUpdateMarker(location);
                    
                    // Adjust zoom based on how specific the address is
                    const city = document.getElementById('address-city').value;
                    const postalCode = document.getElementById('postal-code').value;
                    
                    if (city && postalCode) {
                        map.setZoom(14); // Postal code level
                    } else if (city) {
                        map.setZoom(10); // City level
                    } else {
                        map.setZoom(6); // Country level
                    }
                } else {
                    // If geocoding fails (e.g., city doesn't exist), try with just country
                    const country = document.getElementById('country').value;
                    if (country && address !== country) {
                        geocodeAddress(country);
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
                }
            });
        }

        // NEW FEATURE: GPS Location Detection Function
        function findUserLocation() {
            const findLocationBtn = document.getElementById('find_location');
            
            // Check if geolocation is supported
            if (!navigator.geolocation) {
                alert('Geolocation is not supported by this browser.');
                return;
            }
            
            // Disable button and show loading state
            if (findLocationBtn) {
                findLocationBtn.disabled = true;
                findLocationBtn.innerHTML = 'Finding Location...';
            }
            
            // Get current position
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    const userLocation = new google.maps.LatLng(lat, lng);
                    
                    // Center map on user location
                    map.setCenter(userLocation);
                    map.setZoom(14); // Set appropriate zoom level for user location
                    
                    // Create or update marker at user location
                    createOrUpdateMarker(userLocation);
                    
                    // Update form fields with user location data
                    updateFormFields(lat, lng);
                    
                    // Reset button state
                    if (findLocationBtn) {
                        findLocationBtn.disabled = false;
                        findLocationBtn.innerHTML = 'Find My Location';
                    }
                },
                function(error) {
                    let errorMessage = 'Unable to retrieve your location. ';
                    
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage += 'Location access denied by user.';
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
                        findLocationBtn.innerHTML = 'Find My Location';
                    }
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 60000
                }
            );
        }

        // Map click event
        google.maps.event.addListener(map, 'click', function(mapsMouseEvent) {
            const coordinates = mapsMouseEvent.latLng.toJSON();
            createOrUpdateMarker(new google.maps.LatLng(coordinates.lat, coordinates.lng));
            map.panTo(new google.maps.LatLng(coordinates.lat, coordinates.lng));
            updateFormFields(coordinates.lat, coordinates.lng);
        });

        // Create search box if pac-input exists
        const input = document.getElementById("pac-input");
        if (input) {
            const searchBox = new google.maps.places.SearchBox(input);
            // map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            
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
                    
                    createOrUpdateMarker(place.geometry.location);
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

        // Define event handlers with debouncing
        const debouncedFocus = debounce(focusOnLocation, 500);
        
        // Country change handler
        document.getElementById('country').addEventListener('change', function() {
            if (this.value) {
                // Clear city and postal code when country changes
                document.getElementById('address-city').value = '';
                document.getElementById('postal-code').value = '';
                debouncedFocus();
            }
        });

        // City input handler
        document.getElementById('address-city').addEventListener('input', function() {
            if (this.value.trim()) {
                // Clear postal code when city changes
                document.getElementById('postal-code').value = '';
                debouncedFocus();
            }
        });

        // Postal code input handler
        document.getElementById('postal-code').addEventListener('input', function() {
            if (this.value.trim()) {
                debouncedFocus();
            }
        });

        // NEW FEATURE: Add event listener for GPS location button
        const findLocationBtn = document.getElementById('find_location');
        if (findLocationBtn) {
            findLocationBtn.addEventListener('click', findUserLocation);
        }
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

<script defer async src="https://maps.googleapis.com/maps/api/js?key={{\App\CPU\Helpers::get_business_settings('map_api_key')}}&callback=initAutocomplete&libraries=places&v=3.49" ></script>

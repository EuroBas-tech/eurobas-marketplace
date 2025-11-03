@extends('theme-views.layouts.app')

@section('title', translate('add_new_ad').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@push('css_or_js')
    <meta property="og:image" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <meta property="twitter:card" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <style>
        .card-custom-shadow {
            box-shadow: 1px 1px 4px #00000024, -1px 1px 4px #00000024;
        }
        .select2-container .select2-selection--single .select2-selection__rendered {
            overflow: visible !important;
        }
        select ,input[type="text"], input[type="number"]{
            height: 39px !important;
        }
    </style>

@endpush

@section('content')
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Sidebar-->
                <div class="col-lg-10">
                    <div class="card h-lg-100 card-custom-shadow">
                        <div class="card-body p-4 pb-4">
                            <h1 class="pb-3 fs-30" >{{translate('post_an_add')}}</h1>
                            <div class="d-flex align-items-center gap-2">
                                <h5>{{translate('selected_category')}} : </h5>
                                <h6 class="mt-1 fs-14">
                                    <span class="bg-primary py-2 px-2 rounded text-light">
                                        <i class="bi bi-tags-fill"></i>
                                        <span id="dynamic-cat-name" >{{$ad->category->name}}</span>
                                    </span>
                                </h6>
                            </div>

                            <div class="mt-4">
                                <form  action="" method="POST" id="ads-store-form" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$ad->id}}">
                                    <div class="row gy-4">

                                        @include('theme-views.ad.edit-pages.partials.identification-information')

                                        @include('theme-views.ad.edit-pages.partials.home-garden-data')

                                        @include('theme-views.ad.edit-pages.partials.media-data')

                                        @include('theme-views.ad.edit-pages.partials.price-data')

                                        @include('theme-views.ad.edit-pages.partials.dimensions-and-sizes')

                                        @include('theme-views.ad.edit-pages.partials.contact-and-location-data')

                                        <div class="col-12">
                                            <div class="d-flex justify-content-end gap-3">
                                                <button id="add-button" type="button" class="btn btn-primary">
                                                    {{translate('Update')}}
                                                    <!-- here -->
                                                </button>
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
        window.onload = function () {
            CKEDITOR.replace('description');
        };
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the checkbox and phone number elements
            const showEmailCheckbox = document.getElementById('show-email-address');
            const showPhoneCheckbox = document.getElementById('show-phone-number');

            const allowOffers = document.getElementById('allow-offers');
            const firstPrice = document.getElementById('first-price');

            const categorySelect = document.getElementById('category');
            const categoryName = document.getElementById('dynamic-cat-name');

            const emailAddressDiv = document.getElementById('email-address');
            const phoneNumberDiv = document.getElementById('phone-number');

            // Set initial state of phone number input fields
            const phoneInput = document.querySelector('input[name="contact_phone_number"]');
            const phoneCodeSelect = document.querySelector('select[name="phone_code"]');

            // Initially disable the phone fields if checkbox is not checked
            if (!showPhoneCheckbox.checked) {
                phoneInput.disabled = true;
                phoneCodeSelect.disabled = true;
            }

            // Add event listener to the checkbox
            showPhoneCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    // If checkbox is checked, remove d-none class and enable the input
                    phoneNumberDiv.classList.remove('d-none');
                    phoneInput.disabled = false;
                    phoneCodeSelect.disabled = false;
                } else {
                    // If checkbox is unchecked, add d-none class and disable the input
                    phoneNumberDiv.classList.add('d-none');
                    phoneInput.disabled = true;
                    phoneCodeSelect.disabled = true;
                }
            });

            // Add event listener to the checkbox
            showEmailCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    // If checkbox is checked, remove d-none class
                    emailAddressDiv.classList.remove('d-none');
                } else {
                    // If checkbox is unchecked, add d-none class
                    emailAddressDiv.classList.add('d-none');
                }
            });

            // Add event listener to the checkbox
            allowOffers.addEventListener('change', function() {

                document.getElementById('first-price-input').value = '';

                if (this.checked) {
                    // If checkbox is checked, remove d-none class
                    firstPrice.classList.remove('d-none');
                } else {

                    // If checkbox is unchecked, add d-none class
                    firstPrice.classList.add('d-none');
                }
            });

            // Add event listener to the checkbox
            categorySelect.addEventListener('change', function() {
                categoryName.innerHTML = this.options[this.selectedIndex].text;
            });

        });

        document.addEventListener('DOMContentLoaded', function () {
            const purchaseTypeSelect = document.getElementById('price_type');
            const priceBox = document.getElementById('price-box');
            const startingPriceBox = document.getElementById('starting-price-box');
            const offersBox = document.getElementById('offers-box');

            function togglePriceFields() {
                const selectedValue = purchaseTypeSelect.value;

                document.getElementById('price').value = '';
                document.getElementById('starting-price').value = '';
                document.getElementById('first-price-input').value = '';

                offersBox.classList.add('d-none');

                if (selectedValue === 'fixed_price' || selectedValue === 'asking_price') {
                    priceBox.classList.remove('d-none');
                    startingPriceBox.classList.add('d-none');

                    if (selectedValue === 'asking_price') {
                        offersBox.classList.remove('d-none');
                    }
                } else if (selectedValue === 'auction') {
                    startingPriceBox.classList.remove('d-none');
                    priceBox.classList.add('d-none');
                } else {
                    // Hide both if nothing is selected or placeholder is selected
                    priceBox.classList.add('d-none');
                    startingPriceBox.classList.add('d-none');
                }
            }

            purchaseTypeSelect.addEventListener('change', togglePriceFields);

            // Replace your existing event listener code with this:
            document.addEventListener('click', function(e) {
                // Check if the clicked element is a remove button or its child (like the icon)
                const removeBtn = e.target.closest('.remove-image-btn');
                if (removeBtn) {
                    const uploadFileDiv = removeBtn.closest('.upload-file');
                    if (uploadFileDiv) {
                        uploadFileDiv.remove();
                    }
                }
            });

        });

        function addMoreImage(input, targetSection) {
            const files = input.files;
            if (!files || files.length === 0) return;

            let images_box = document.getElementById('additional_Image_Section');

            if(images_box.children.length <= 10) {
                const reader = new FileReader();
                const previewImg = input.closest('.upload-file').querySelector('img');
                const tempBox = input.closest('.upload-file').querySelector('.temp-img-box');

                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewImg.hidden = false;
                    if (tempBox) tempBox.style.display = 'none';
                };

                console.log(images_box.children.length);

                reader.readAsDataURL(files[0]);

                // Check if this is the last .upload-file inside the target section
                const $fileInputs = document.querySelectorAll(`${targetSection} input[type='file']`);
                const isLastInput = input === $fileInputs[$fileInputs.length - 1];

                const removeBtn = `
                    <span style="position: absolute;top: 10px;right: 10px;"
                    class="btn btn-danger btn-sm rounded p-1 d-inline remove-image-btn" >
                    <i class="bi bi-trash3-fill text-white" ></i>
                    </span>
                `;

                if (isLastInput) {
                    const newInputIndex = $fileInputs.length;

                    const newInputHTML = `
                        <div class="upload-file position-relative">
                            <input
                                type="file"
                                class="upload-file__input"
                                onchange="addMoreImage(this, '${targetSection}')"
                                name="images[]"
                                multiple
                                aria-required="true"
                                accept="image/*">

                            <div class="upload-file__img">
                                <div class="temp-img-box">
                                    <div class="d-flex align-items-center flex-column gap-2">
                                        <i class="bi bi-upload fs-30"></i>
                                        <div class="fs-12 text-muted">{{translate('ad_images')}}</div>
                                    </div>
                                </div>
                                <img src="#" class="dark-support img-fit-contain border" alt="" hidden="">
                            </div>
                        </div>
                    `;

                    // Append remove button to second-to-last .upload-file
                    const fileWrappers = document.querySelectorAll(`${targetSection} .upload-file`);

                    if (fileWrappers.length > 0) {
                        const secondLastWrapper = fileWrappers[fileWrappers.length - 1];
                        secondLastWrapper.insertAdjacentHTML('beforeend', removeBtn);
                    }

                    // Append the new input to the target section
                    const container = document.querySelector(targetSection);
                    container.insertAdjacentHTML('beforeend', newInputHTML);
                }

            } else {
                toastr.error("{{translate('maximum_10_images_allowed')}}");
                // Reset the input value to clear the selected file
                input.value = '';
            }

        }

        $(window).on("load", function () {
            let input = $(".upload-file__input.thumbnail");
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
            $('.ad-images').each(function(index, image) {
                let $image = $(image); // wrap it in jQuery

                let img = $image
                .siblings(".upload-file__img")
                .find("img")
                .removeAttr("hidden");

                $image
                .siblings(".upload-file__img")
                .find(".temp-img-box")
                .remove();

                img.attr("src", $image.data("old"));
            });
        });

        // Helper function to add the empty upload box
        function addEmptyUploadBox(container, targetSection) {
            const newInputHTML = `
                <div class="upload-file position-relative">
                    <input
                        type="file"
                        class="upload-file__input"
                        onchange="addMoreImage(this, '${targetSection}')"
                        name="images[]"
                        multiple
                        aria-required="true"
                        accept="image/*">

                    <div class="upload-file__img">
                        <div class="temp-img-box">
                            <div class="d-flex align-items-center flex-column gap-2">
                                <i class="bi bi-upload fs-30"></i>
                                <div class="fs-12 text-muted">{{translate('ad_images')}}</div>
                            </div>
                        </div>
                        <img src="#" class="dark-support img-fit-contain border" alt="" hidden="">
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newInputHTML);
        }

        // Delete handler that maintains the empty box at the end
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-image-btn')) {
                const uploadFile = e.target.closest('.upload-file');
                const container = uploadFile.parentElement;

                uploadFile.remove();

                // Check for an empty upload box
                const allBoxes = container.querySelectorAll('.upload-file');
                const emptyBox = Array.from(allBoxes).find(box => box.querySelector('.temp-img-box'));

                // If there's an empty box, move it to the end, otherwise add one
                if (emptyBox) {
                    // Remove and re-append the empty box to place it at the end
                    container.removeChild(emptyBox);
                    container.appendChild(emptyBox);
                } else {
                    addEmptyUploadBox(container, '#additional_Image_Section');
                }

                // Re-index file inputs if needed (ensures consistent naming)
                updateInputIndices(container);
            }
        });

        // Function to update indices on file inputs if needed
        function updateInputIndices(container) {
            const fileInputs = container.querySelectorAll('.image-file-input');
            fileInputs.forEach((input, index) => {
                // Optional: You can modify the name if you need indexed inputs
                input.name = 'images[]';
            });
        }

        $(document).ready(function() {
            function storeAd() {

                // Show loader and disable button
                $('#add-button').prop('disabled', true);
                $('#add-button').html(`
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    {{ translate('Processing...') }}
                `);

                if (CKEDITOR.instances.description) {
                    CKEDITOR.instances.description.updateElement();
                }

                // 1. Get the form element
                let form = $('#ads-store-form')[0];

                // 2. Create FormData object
                let formData = new FormData(form);

                $.ajax({
                    url: "{{ route('ads-update') }}",
                    type: "POST",
                    data: formData,
                    processData: false,  // Required for FormData
                    contentType: false,   // Required for FormData
                    cache: false,        // Recommended for file uploads
                    success: function(response) {

                        // Restore button
                        $('#add-button').prop('disabled', false);
                        $('#add-button').html(`{{ translate('Add') }}`);


                        if (response.success) {
                            toastr.success(response.message);

                            // Optional: Redirect after success
                            if (response.redirect_url) {
                                setTimeout(function() {
                                    window.location.href = response.redirect_url;
                                }, 1500); // Redirect after 1.5 seconds
                            }
                        } else {
                            // Handle unexpected success=false responses
                            toastr.warning(response.message || '{{translate("Operation completed with warnings")}}');
                        }
                    },
                    error: function(xhr) {

                        // Restore button
                        $('#add-button').prop('disabled', false);
                        $('#add-button').html(`{{ translate('Add') }}`);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            // Handle as simple array
                            if (Array.isArray(errors)) {
                                errors.forEach(function(error) {
                                    toastr.error(error);
                                });
                            }
                            // Handle as object (if you change backend later)
                            else {
                                $.each(errors, function(field, messages) {
                                    messages.forEach(function(message) {
                                        toastr.error(message);
                                    });
                                });
                            }
                        } else {
                            toastr.error('{{translate("an_error_occurred")}}: ' + xhr.responseText);
                        }
                    }


                });
            }

            // You need to call it, for example on a button click:
            $('#add-button').on('click', function() {
                storeAd();
            });
        });

    </script>

    <script>
        $(document).ready(function () {
            const $brandSelect = $('#brand');
            const $modelSelect = $('#model');
            const $categorySelect = $('#category');

            // Initialize Select2
            $brandSelect.select2({
                placeholder: "{{ translate('choose_brand') }}",
                allowClear: true
            });

            $modelSelect.select2({
                placeholder: "{{ translate('choose_model') }}",
                allowClear: true
            });

            $('#color').select2({
                placeholder: "{{ translate('choose_color') }}",
                allowClear: true
            });

            // Store all model options
            const allModelOptions = $('#model option').clone();

            // Create the "Other" options once with value="other"
            const otherBrandOption = '<option value="other">{{ translate("other_brand") }}</option>';
            const otherModelOption = '<option value="other">{{ translate("other_model") }}</option>';

            addPersistentOptions();

            function addPersistentOptions() {
                // Add "Other Brand" if it doesn't exist
                if ($brandSelect.find('option[value="other"]').length === 0) {
                    $brandSelect.append(otherBrandOption);
                }

                // Add "Other Model" if it doesn't exist
                if ($modelSelect.find('option[value="other"]').length === 0) {
                    $modelSelect.append(otherModelOption);
                }
            }

            function filterModels() {
                const selectedBrandId = $brandSelect.val();
                const selectedCategoryId = $categorySelect.val();

                // Clear models but keep the "Other Model" and default option
                $modelSelect.find('option').not('[value="other"], [value=""]').remove();

                // Filter and add matching models
                allModelOptions.each(function () {
                    const brandId = $(this).data('brand-id');
                    const categoryId = $(this).data('category-id');

                    if (
                        (!brandId || brandId == selectedBrandId) &&
                        (!categoryId || categoryId == selectedCategoryId)
                    ) {
                        $modelSelect.append($(this).clone());
                    }
                });

                // Ensure "Other Model" is at the end and only appears once
                if ($modelSelect.find('option[value="other"]').length > 1) {
                    $modelSelect.find('option[value="other"]').not(':last').remove();
                }

                $modelSelect.val(null).trigger('change');

                // Ensure "Other Brand" exists
                addPersistentOptions();
            }

            $brandSelect.on('change', function () {
                filterModels();
                $modelSelect.prop('disabled', false);
                addPersistentOptions();
            });

            $categorySelect.on('change', function () {
                $brandSelect.val(null).trigger('change');
                $modelSelect.val(null).trigger('change');

                if($(this).find(':selected').data('is-vehicle') == 1) {
                    $('#year-box').removeClass('d-none');
                    $('#engine-type-box').removeClass('d-none');
                    $('#mileage-box').removeClass('d-none');
                    $('#transmission-type-box').removeClass('d-none');
                    $('#body-type-box').removeClass('d-none');
                    $('#bag-capacity-box').removeClass('d-none');
                    $('#environmental-information-box').removeClass('d-none');
                    $('#ad-options-box').removeClass('d-none');
                    $('#additional-information-box').removeClass('d-none');
                    $('#engine-type-box').removeClass('d-none');
                    $('#engine-size-box').removeClass('d-none');
                    $('#cylinders-box').removeClass('d-none');
                    $('#power-box').removeClass('d-none');
                } else {
                    $('#year-box').addClass('d-none');
                    $('#engine-type-box').addClass('d-none');
                    $('#mileage-box').addClass('d-none');
                    $('#transmission-type-box').addClass('d-none');
                    $('#body-type-box').addClass('d-none');
                    $('#bag-capacity-box').addClass('d-none');
                    $('#environmental-information-box').addClass('d-none');
                    $('#ad-options-box').addClass('d-none');
                    $('#additional-information-box').addClass('d-none');
                    $('#engine-type-box').addClass('d-none');
                    $('#engine-size-box').addClass('d-none');
                    $('#cylinders-box').addClass('d-none');
                    $('#power-box').addClass('d-none');
                }

                filterModels();
                addPersistentOptions();
            });

            $('#color').on('select2:open', function () {
                setTimeout(function () {
                    const $options = $('.select2-results__option');
                    $options.each(function (index) {
                        if (index === $options.length - 1) return;

                        const color = $(this).text().trim();

                        if (!$(this).find('.color-square').length) {
                            const square = $('<span class="color-square"></span>').css({
                                display: 'inline-block',
                                width: '30px',
                                height: '15px',
                                border: 'solid #cfcfcf 1px',
                                'background-color': color,
                                'margin-left': '8px',
                                'vertical-align': 'middle',
                                'border-radius': '2px'
                            });

                            $(this).append(square);
                        }
                    });
                }, 0);
            });

            $('#color').on('change', function () {
                setTimeout(function () {
                    const $selection = $('#color').next('.select2-container').find('.select2-selection__rendered');
                    $selection.find('.selected-color-square').remove();

                    const color = $selection.text().trim();

                    const square = $('<span class="selected-color-square"></span>').css({
                        display: 'inline-block',
                        width: '30px',
                        height: '15px',
                        border: 'solid #cfcfcf 1px',
                        'background-color': color,
                        'margin-left': '8px',
                        'vertical-align': 'middle',
                        'border-radius': '2px'
                    });

                    $selection.append(square);
                }, 0);
            });

            $('#color').on('select2:open', function () {
                const colorSelectContainer = $('#color').data('select2').$dropdown;
                const searchInput = colorSelectContainer.find('.select2-search__field');

                searchInput.off('input').on('input', function () {
                    setTimeout(function applyColorSquares() {
                        const $options = colorSelectContainer.find('.select2-results__option');

                        $options.each(function (index) {
                            if (index === $options.length - 1) return;

                            const $option = $(this);
                            const color = $option.text().trim();

                            if (
                                !$option.hasClass('select2-results__message') &&
                                color &&
                                !$option.find('.color-square').length
                            ) {
                                const square = $('<span class="color-square"></span>').css({
                                    display: 'inline-block',
                                    width: '30px',
                                    height: '15px',
                                    border: 'solid #cfcfcf 1px',
                                    'background-color': color,
                                    'margin-left': '8px',
                                    'vertical-align': 'middle',
                                    'border-radius': '2px'
                                });

                                $option.append(square);
                            }
                        });

                        setTimeout(applyColorSquares, 50);
                    }, 0);
                });
            });
        });
    </script>

    <script>
        function initAutocomplete() {
            // Europe center coordinates (initial fallback)
            let myLatLng = { lat: 50.1109, lng: 8.6821 };

            // Initialize the map focused on Europe initially
            const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                center: myLatLng,
                zoom: 4,
                mapTypeId: "roadmap",
            });

            // Initialize marker as null - will be created when needed
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

                // Build search query based on available data (prioritize more specific)
                if (city && postalCode) {
                    searchQuery = `${postalCode}, ${city}, ${country}`;
                } else if (city && country) {
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
                        if (postalCode) {
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

                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();

                    if (places.length == 0) return;

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

            // Focus on existing location when page loads (edit page)
            setTimeout(function() {
                const country = document.getElementById('country').value;
                const city = document.getElementById('address-city').value;
                const postalCode = document.getElementById('postal-code').value;

                // Check if we have existing data to focus on
                if (country || city || postalCode) {
                    focusOnLocation();
                }
            }, 1000);

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
@endpush




<script>
    window.isVideoUploaded = false;
</script>

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

    });
    
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

    function addMoreImage(input, targetSection) {
        const files = input.files;
        if (!files || files.length === 0) return;

        // Validate file types and size
        const allowedTypes = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        const maxSize = {{ $ad_images_size }} * 1024 * 1024; // 4MB in bytes
        const invalidFiles = [];
        const oversizedFiles = [];

        Array.from(files).forEach(file => {
            const fileExtension = file.name.split('.').pop().toLowerCase();
            if (!allowedTypes.includes(fileExtension)) {
                invalidFiles.push(file.name);
            }
            if (file.size > maxSize) {
                oversizedFiles.push(file.name);
            }
        });

        if (invalidFiles.length > 0) {
            toastr.error('{{translate("Only JPG, JPEG, PNG, WEBP, AVIF files are acceptable")}}');
            input.value = '';
            return;
        }

        if (oversizedFiles.length > 0) {
            toastr.error(`{{ translate("Maximum file size is") }}` + {{ $ad_images_size }} + `{{ translate('mb') }}`);
            input.value = '';
            return;
        }

        let container = document.querySelector(targetSection);
        
        // First, find and remove all empty upload boxes to ensure proper ordering
        const allBoxes = container.querySelectorAll('.upload-file');
        const emptyBoxes = Array.from(allBoxes).filter(box => box.querySelector('.temp-img-box'));
        emptyBoxes.forEach(box => box.remove());
        
        // Count only boxes with actual images (ignore empty upload boxes that might have been there)
        const imageBoxes = Array.from(container.querySelectorAll('.upload-file'));

        const remainingSlots = {{ $maximum_ad_images_number }} - imageBoxes.length;

        if (files.length > remainingSlots) {
            toastr.error(`{{ translate('maximum_images_allowed_number_is') }} {{ $maximum_ad_images_number }} {{ translate('image') }}`);
            // Add back the empty upload box
            addEmptyUploadBox(container, targetSection);
            input.value = '';
            return;
        }

        // Keep track of processed files to know when to add the upload box
        let processedFiles = 0;
        
        // Process each selected file
        Array.from(files).forEach((file) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const newBoxHTML = `
                    <div class="upload-file position-relative">
                        <input type="file" name="images[]" style="display: none;" class="image-file-input">
                        <div class="upload-file__img">
                            <img src="${e.target.result}" class="dark-support img-fit-contain border">
                        </div>
                        <span style="position: absolute;top: 10px;right: 10px;"
                        class="btn btn-danger btn-sm rounded p-1 d-inline remove-image-btn">
                        <i class="bi bi-trash3-fill text-white"></i>
                        </span>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', newBoxHTML);
                
                // Get the newly added box and attach the file to its input
                const newBox = container.lastElementChild;
                const newInput = newBox.querySelector('.image-file-input');
                
                // Create a new FileList-like object with just this file
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                newInput.files = dataTransfer.files;
                
                processedFiles++;
                
                // If all files have been processed, add the empty input box at the end
                if (processedFiles === files.length) {
                    addEmptyUploadBox(container, targetSection);
                }
            };
            reader.readAsDataURL(file);
        });
    }

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

    // Validation function for thumbnail upload
    function validateThumbnailImage(input) {
        const file = input.files[0];
        if (!file) return true;

        const allowedTypes = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        const maxSize = {{ $ad_images_size }} * 1024 * 1024; // 4MB in bytes
        const fileExtension = file.name.split('.').pop().toLowerCase();
        
        if (!allowedTypes.includes(fileExtension)) {
            toastr.error('{{translate("Only JPG, JPEG, PNG, WEBP, AVIF files are acceptable")}}');
            input.value = '';
            return false;
        }

        if (file.size > maxSize) {
            toastr.error(`{{ translate("Maximum file size is") }}` + {{ $ad_images_size }} + `{{ translate('mb') }}`);
            input.value = '';
            return false;
        }

        return true;
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
                url: "{{ route('ads-store') }}",
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
                        
                        // Redirect after success to payment checkout page 
                        if(response.with_payment) {
                            if (response.checkout_redirect_url) {
                                setTimeout(function() {
                                    // console.log(response.checkout_redirect_url);
                                    window.location.href = response.checkout_redirect_url;
                                }, 2000); // Redirect after 2 seconds
                            }
                        }
                        
                        // Redirect after success to published ad page 
                        else {
                            if (response.redirect_url) {
                                setTimeout(function() {
                                    window.location.href = response.redirect_url;
                                }, 2000); // Redirect after 2 seconds
                            }
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
        const selectedBrandId = $brandSelect.val();
        
        if (!selectedBrandId || selectedBrandId === '') {
            $modelSelect.val(null).trigger('change');
            $modelSelect.prop('disabled', true);
        } else {
            filterModels();
            $modelSelect.prop('disabled', false);
        }
        
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

                const $option = $(this);
                const color = $('#color option').filter(function () {
                    return $(this).text().trim() === $option.text().trim();
                }).val();

                if (!$(this).find('.color-square').length && color) {
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

            const color = $('#color').val(); // Use actual value, not translated text

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
                    const color = $('#color option').filter(function () {
                        return $(this).text().trim() === $option.text().trim();
                    }).val();

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

</script>
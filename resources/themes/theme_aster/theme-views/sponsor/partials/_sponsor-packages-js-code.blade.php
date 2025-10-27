<script>
    const topResultsPackagePrices = @json($appear_on_top_packages->pluck('price', 'id'));
    const videoPackagePrices = @json($promotional_video_packages->pluck('price', 'id'));
    const urgentSalePackagePrices = @json($urgent_sale_sticker_packages->pluck('price', 'id'));

    // Make them globally accessible
    window.topResultsPackagePrices = topResultsPackagePrices;
    window.videoPackagePrices = videoPackagePrices;
    window.urgentSalePackagePrices = urgentSalePackagePrices;
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // ⏳ Cache DOM elements
        const totalPriceSpan = document.getElementById('total_price');
        const topResultsPriceSpan = document.getElementById('top_results_appearance_price');
        const topResultsAppearanceSelected = document.getElementById('top_results_appearance_selected');
        const urgentSaleStickerSelected = document.getElementById('urgent_sale_sticker_selected');
        const promotionalVideoSelected = document.getElementById('promotional_video_selected');
        const promotionalVideoPriceSpan = document.getElementById('promotional_video_price');
        const urgentSalePriceSpan = document.getElementById('urgent_sale_sticker_price');
        
        // Cache the add button
        const addButton = document.getElementById('add-button');

        // Get the form - try both possible IDs
        const form = document.getElementById('ads-store-form') || document.querySelector('form');

        // Package prices from server (these should be defined globally)
        const topResultsPackagePrices = window.topResultsPackagePrices || {};
        const videoPackagePrices = window.videoPackagePrices || {};
        const urgentSalePackagePrices = window.urgentSalePackagePrices || {};

        // State management
        let currentVideoPackageId = null;
        let currentTopResultsPackageId = null;
        let currentUrgentSalePackageId = null;

        // ✅ Create hidden inputs for different package types
        function createHiddenInputs() {
            if (form) {
                // Hidden input for top results
                let topResultsInput = document.getElementById('appear-on-first-input');
                if (!topResultsInput) {
                    topResultsInput = document.createElement('input');
                    topResultsInput.type = 'hidden';
                    topResultsInput.name = 'appear_on_first_results_sponsor';
                    topResultsInput.id = 'appear-on-first-input';
                    form.appendChild(topResultsInput);
                }

                // Hidden input for promotional video
                let videoInput = document.getElementById('promotional-video-input');
                if (!videoInput) {
                    videoInput = document.createElement('input');
                    videoInput.type = 'hidden';
                    videoInput.name = 'promotional_video_sponsor';
                    videoInput.id = 'promotional-video-input';
                    form.appendChild(videoInput);
                }

                // Hidden input for urgent sale sticker
                let urgentSaleInput = document.getElementById('urgent-sale-sticker-input');
                if (!urgentSaleInput) {
                    urgentSaleInput = document.createElement('input');
                    urgentSaleInput.type = 'hidden';
                    urgentSaleInput.name = 'urgent_sale_sticker_sponsor';
                    urgentSaleInput.id = 'urgent-sale-sticker-input';
                    form.appendChild(urgentSaleInput);
                }

                // Hidden input for regular packages (from old system)
                let packageInput = document.getElementById('package_id');
                if (!packageInput) {
                    packageInput = document.createElement('input');
                    packageInput.type = 'hidden';
                    packageInput.name = 'package_id';
                    packageInput.id = 'package_id';
                    form.appendChild(packageInput);
                }
            }
        }

        // Initialize hidden inputs
        createHiddenInputs();

        // Function to deselect video packages when video is deleted
        function deselectVideoPackages() {
            // Get video input
            const videoInput = document.getElementById('promotional-video-input');
            
            // Reset video package state
            if (videoInput && videoInput.value) {
                videoInput.value = '';
                currentVideoPackageId = null;
                
                // Hide promotional video selected indicator
                if (promotionalVideoSelected) {
                    promotionalVideoSelected.classList.add('d-none');
                }
                
                // Reset promotional video price
                if (promotionalVideoPriceSpan) {
                    promotionalVideoPriceSpan.textContent = '0.00';
                }
                
                // Reset video package buttons (only target video-package-btn class)
                document.querySelectorAll('.video-package-btn').forEach(button => {
                    const card = button.closest('.video-pricing-card');
                    if (card) {
                        card.classList.remove('active');
                        card.querySelector('.check-icon')?.remove();
                    }
                    // Reset button text
                    button.innerHTML = button.dataset.originalText || 'Get Started';
                });
                
                // Update total after deselecting video packages
                updateTotal();
            }
        }

        // Make deselectVideoPackages globally accessible for the video upload script
        window.deselectVideoPackages = deselectVideoPackages;

        /**
         * 🧠 Toggle visual effects based on card type
         */
        function toggleVisualEffect(card, isSelected, packageType = 'default') {
            if (isSelected) {
                card.classList.add('active');
                // Remove existing check icon
                card.querySelector('.check-icon')?.remove();

                // Add check icon with appropriate styling based on package type
                const icon = document.createElement('i');
                icon.className = 'bi bi-check-circle-fill text-success position-absolute top-0 end-0 m-2 check-icon fs-4';
                card.appendChild(icon);
            } else {
                card.classList.remove('active');
                card.querySelector('.check-icon')?.remove();
            }
        }

        /**
         * 🎯 Update button text with animation effect
         */
        function updateButtonText(newText) {
            if (!addButton) return;
            
            // Get current text
            const currentText = addButton.textContent.trim();
            
            // If text is the same, no need to update
            if (currentText === newText) return;

            // Wrap content if not already wrapped
            let buttonContent = addButton.querySelector('.button-content');
            if (!buttonContent) {
                buttonContent = document.createElement('span');
                buttonContent.className = 'button-content';
                buttonContent.textContent = addButton.textContent;
                addButton.innerHTML = '';
                addButton.appendChild(buttonContent);
            }

            // Create light ray effect
            const lightRay = document.createElement('div');
            lightRay.className = 'light-ray';
            addButton.appendChild(lightRay);

            // Animation sequence
            buttonContent.classList.add('slide-out-right');
            
            setTimeout(() => {
                buttonContent.textContent = newText;
                buttonContent.classList.remove('slide-out-right');
                buttonContent.classList.add('slide-in-left');
                
                setTimeout(() => {
                    buttonContent.classList.remove('slide-in-left');
                    buttonContent.classList.add('slide-in-center');
                    
                    // Remove light ray after animation
                    setTimeout(() => {
                        lightRay.remove();
                    }, 600);
                }, 50);
            }, 200);
        }

        /**
         * 🔁 Update total price and button text
         */
        function updateTotal() {
            let total = 0;

            // Top Results
            const topResultsInput = document.getElementById('appear-on-first-input');
            const topId = topResultsInput?.value;
            if (topId && topResultsPackagePrices[topId]) {
                total += parseFloat(topResultsPackagePrices[topId]);
            }

            // Promotional Video
            const videoInput = document.getElementById('promotional-video-input');
            const videoId = videoInput?.value;
            if (videoId && videoPackagePrices[videoId]) {
                total += parseFloat(videoPackagePrices[videoId]);
            }

            // Urgent Sale Sticker
            const urgentSaleInput = document.getElementById('urgent-sale-sticker-input');
            const urgentSaleId = urgentSaleInput?.value;
            if (urgentSaleId && urgentSalePackagePrices[urgentSaleId]) {
                total += parseFloat(urgentSalePackagePrices[urgentSaleId]);
            }

            // Update total price display if exists
            if (totalPriceSpan) {
                totalPriceSpan.textContent = total.toFixed(2);
            }

            // Update button text based on total
            const buttonText = total > 0 ? "{{translate('checkout_payment')}}" : "{{translate('add')}}";
            updateButtonText(buttonText);
        }

        /**
         * 🎯 Clear selections in a specific package type
         */
        function clearPackageTypeSelections(packageType, excludeCard = null) {
            document.querySelectorAll('[data-id]').forEach(button => {
                if (button.closest('.pricing-card') === excludeCard || button.closest('.video-pricing-card') === excludeCard) {
                    return; // Skip the excluded card
                }

                const buttonId = button.dataset.id;
                let shouldClear = false;

                // Determine if this button belongs to the same package type
                switch (packageType) {
                    case 'top-results':
                        shouldClear = topResultsPackagePrices[buttonId] !== undefined;
                        break;
                    case 'video':
                        shouldClear = videoPackagePrices[buttonId] !== undefined;
                        break;
                    case 'urgent-sale':
                        shouldClear = urgentSalePackagePrices[buttonId] !== undefined;
                        break;
                    case 'regular':
                        shouldClear = !topResultsPackagePrices[buttonId] && 
                                    !videoPackagePrices[buttonId] && 
                                    !urgentSalePackagePrices[buttonId];
                        break;
                }

                if (shouldClear) {
                    const card = button.closest('.pricing-card') || button.closest('.video-pricing-card');
                    if (card) {
                        card.classList.remove('active');
                        card.querySelector('.check-icon')?.remove();
                    }
                    updateButtonState(button, false);
                }
            });
        }

        /**
         * 🎯 Update button text and state
         */
        function updateButtonState(button, isSelected, packageName = '') {
            if (isSelected) {
                button.innerHTML = `<i class="bi bi-check-circle-fill me-1"></i> ${button.dataset.selectedText || 'Selected'}`;
            } else {
                button.innerHTML = button.dataset.originalText || 'Get Started';
            }
        }

        // 🚀 Handle all package selections with data-id attribute
        document.querySelectorAll('[data-id]').forEach(button => {
            // Store original button text
            button.dataset.originalText = button.innerHTML;
            button.dataset.selectedText = button.dataset.selectedText || 'Selected';

            button.addEventListener('click', function () {
                const selectedId = this.dataset.id;
                const card = this.closest('.pricing-card') || this.closest('.video-pricing-card');
                const packageName = card.querySelector('.package-name')?.textContent || 'Package';

                // Determine package type with priority order
                const isTopResults = topResultsPackagePrices[selectedId] !== undefined;
                const isVideo = videoPackagePrices[selectedId] !== undefined;
                const isUrgentSale = urgentSalePackagePrices[selectedId] !== undefined;

                // Get appropriate hidden inputs
                const topResultsInput = document.getElementById('appear-on-first-input');
                const videoInput = document.getElementById('promotional-video-input');
                const urgentSaleInput = document.getElementById('urgent-sale-sticker-input');
                const packageInput = document.getElementById('package_id');

                // Handle package selection with priority: Top Results > Video > Urgent Sale > Regular
                if (isTopResults && topResultsInput) {
                    // Handle Top Results packages
                    if (currentTopResultsPackageId === selectedId) {
                        // Unselect current package
                        topResultsInput.value = '';
                        currentTopResultsPackageId = null;
                        toggleVisualEffect(card, false);
                        updateButtonState(this, false);

                        if (topResultsAppearanceSelected) {
                            topResultsAppearanceSelected.classList.add('d-none');
                        }
                        if (topResultsPriceSpan) {
                            topResultsPriceSpan.textContent = '0.00';
                        }
                        if (typeof toastr !== 'undefined') {
                            toastr.warning('', '{{translate("Package Removed")}}'); 
                        }
                    } else {
                        // Clear other top results selections (only within top results type)
                        clearPackageTypeSelections('top-results', card);

                        // Select new package
                        topResultsInput.value = selectedId;
                        currentTopResultsPackageId = selectedId;
                        toggleVisualEffect(card, true, 'top-results');
                        updateButtonState(this, true);

                        if (topResultsAppearanceSelected) {
                            topResultsAppearanceSelected.classList.remove('d-none');
                        }
                        if (topResultsPriceSpan) {
                            topResultsPriceSpan.textContent = parseFloat(topResultsPackagePrices[selectedId]).toFixed(2);
                        }
                        if (typeof toastr !== 'undefined') {
                            toastr.success('', '{{translate("Package Selected")}}'); 
                        }
                    }
                } else if (isVideo && videoInput) {
                    // Check if video is uploaded before allowing package selection
                    if (!window.isVideoUploaded) {
                        if (typeof toastr !== 'undefined') {
                            toastr.error("{{translate('You can not select package before uploading the video')}}", 'Error');
                        }
                        return; // Prevent package selection
                    }

                    // Handle Video packages (existing logic)
                    if (currentVideoPackageId === selectedId) {
                        // Unselect current package
                        videoInput.value = '';
                        currentVideoPackageId = null;
                        toggleVisualEffect(card, false, 'video');
                        updateButtonState(this, false);

                        if (promotionalVideoSelected) {
                            promotionalVideoSelected.classList.add('d-none');
                        }
                        if (promotionalVideoPriceSpan) {
                            promotionalVideoPriceSpan.textContent = '0.00';
                        }
                        if (typeof toastr !== 'undefined') {
                            toastr.warning('', '{{translate("Package Removed")}}'); 
                        }
                    } else {
                        // Clear other video selections (only within video type)
                        clearPackageTypeSelections('video', card);

                        // Select new package
                        videoInput.value = selectedId;
                        currentVideoPackageId = selectedId;
                        toggleVisualEffect(card, true, 'video');
                        updateButtonState(this, true);

                        if (promotionalVideoSelected) {
                            promotionalVideoSelected.classList.remove('d-none');
                        }
                        if (promotionalVideoPriceSpan) {
                            const price = videoPackagePrices[selectedId] || 0;
                            console.log('Setting video price:', selectedId, price);
                            promotionalVideoPriceSpan.textContent = parseFloat(price).toFixed(2);
                        }
                        if (typeof toastr !== 'undefined') {
                            toastr.success('', '{{translate("Package Selected")}}'); 
                        }
                    }
                
                } else if (isUrgentSale && urgentSaleInput) {
                    // Handle Urgent Sale Sticker packages
                    if (currentUrgentSalePackageId === selectedId) {
                        // Unselect current package
                        urgentSaleInput.value = '';
                        currentUrgentSalePackageId = null;
                        toggleVisualEffect(card, false);
                        updateButtonState(this, false);

                        if (urgentSaleStickerSelected) {
                            urgentSaleStickerSelected.classList.add('d-none');
                        }
                        if (urgentSalePriceSpan) {
                            urgentSalePriceSpan.textContent = '0.00';
                        }
                        if (typeof toastr !== 'undefined') {
                            toastr.warning('', '{{translate("Package Removed")}}'); 
                        }
                    } else {
                        // Clear other urgent sale selections (only within urgent sale type)
                        clearPackageTypeSelections('urgent-sale', card);

                        // Select new package
                        urgentSaleInput.value = selectedId;
                        currentUrgentSalePackageId = selectedId;
                        toggleVisualEffect(card, true, 'urgent-sale');
                        updateButtonState(this, true);

                        if (urgentSaleStickerSelected) {
                            urgentSaleStickerSelected.classList.remove('d-none');
                        }
                        if (urgentSalePriceSpan) {
                            urgentSalePriceSpan.textContent = parseFloat(urgentSalePackagePrices[selectedId]).toFixed(2);
                        }
                        if (typeof toastr !== 'undefined') {
                            toastr.success('', '{{translate("Package Selected")}}'); 
                        }
                    }
                } else if (!isTopResults && !isVideo && !isUrgentSale && packageInput) {
                    // Handle regular packages (old system)
                    if (packageInput.value === selectedId) {
                        // Unselect current package
                        packageInput.value = '';
                        toggleVisualEffect(card, false);
                        updateButtonState(this, false);
                        if (typeof toastr !== 'undefined') {
                            toastr.warning('', '{{translate("Package Removed")}}'); 
                        }
                    } else {
                        // Clear other regular package selections (only within regular type)
                        clearPackageTypeSelections('regular', card);

                        // Select new package
                        packageInput.value = selectedId;
                        toggleVisualEffect(card, true);
                        updateButtonState(this, true);
                        if (typeof toastr !== 'undefined') {
                            toastr.success('', '{{translate("Package Selected")}}'); 
                        }
                    }
                }

                // Update total price and button text
                updateTotal();
            });
        });

        // Initialize total price calculation and button text
        updateTotal();
        
        // Add CSS for button animation
        const style = document.createElement('style');
        style.textContent = `
            #add-button {
                transition: opacity 0.3s ease, transform 0.3s ease;
            }
        `;
        document.head.appendChild(style);
    });
</script>
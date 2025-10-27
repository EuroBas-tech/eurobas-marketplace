@extends('theme-views.layouts.app')

@section('title', translate('sponsor').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@section('content')

<style>
    body {
        background-color: unset !important;
    }
    .price-text {
        font-size: 35px;
    }

    .fixed-description-height {
        min-height: 3em; /* adjust this based on your font size */
        line-height: 1.5em;
        overflow: hidden;
    }

    .pricing-card {
        border: 1px solid #d9d9d9;
        box-shadow: 0px 0px 2px #858585;
    }
    
    .pricing-card.active {
        border: 1px solid #198754;
        transform: scale(1.08);
        transition: .2s;
    }

        .payment-card {
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        position: relative;
        overflow: hidden;
        background: #ffffff;
        transform: translateY(0);
        border: 1px solid #d9d9d9;
        box-shadow: 0px 0px 2px #858585;
    }

    .payment-card:hover {
        transform: translateY(-5px);
        border-color: #007bff;
    }

    .payment-card.selected {
        border-color: var(--bs-success);
        transform: translateY(-8px) scale(1.05);
    }

    .payment-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s;
    }

    .payment-card:hover::before {
        left: 100%;
    }

    .payment-card .card-body {
        position: relative;
        z-index: 2;
        padding: 1.5rem;
    }

    .payment-card img {
        transition: transform 0.3s ease;
        filter: grayscale(30%);
    }

    .payment-card:hover img,
    .payment-card.selected img {
        transform: scale(1.1);
        filter: grayscale(0%);
    }

    /* Checkmark animation */
    .payment-card .checkmark {
        position: absolute;
        top: 6px;
        right: 6px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transform: scale(0);
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        font-size: 18px;
    }

    .payment-card.selected .checkmark {
        opacity: 1;
        transform: scale(1);
    }

    /* Ripple effect */
    .payment-card .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(var(--bs-success-rgb), 0.3);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .payment-card.selected {
            transform: translateY(-3px) scale(1.02);
        }
        
        .col-auto {
            margin-bottom: 1rem;
        }
    }
    
    /* Button transition styles */
    #sponsor-submit-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    #sponsor-submit-btn .button-content {
        position: relative;
        z-index: 2;
        transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* Light ray animation */
    .light-ray {
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent 0%, 
            rgba(255, 255, 255, 0.2) 20%, 
            rgba(255, 255, 255, 0.6) 50%, 
            rgba(255, 255, 255, 0.2) 80%, 
            transparent 100%
        );
        z-index: 1;
        animation: lightRayPass 0.6s ease-out;
    }

    @keyframes lightRayPass {
        0% {
            left: -50%;
            opacity: 0;
        }
        50% {
            opacity: 1;
        }
        100% {
            left: 100%;
            opacity: 0;
        }
    }

    /* Slide animations */
    .slide-out-right {
        transform: translateX(20px);
        opacity: 0;
    }

    .slide-in-left {
        transform: translateX(-20px);
        opacity: 0;
    }

    .slide-in-center {
        transform: translateX(0);
        opacity: 1;
    }

</style>

<!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-4">
        <div class="container">
            <div class="row g-3">
                <!-- Sidebar-->
                @include('theme-views.partials._profile-aside')
                
                @if($user_ads->count() > 0)
                    @include('theme-views.sponsor.partials._'.$sponsor_type)
                @else
                    <div class="col-auto px-3 flex-grow-1">
                        <div class="alert alert-warning">
                            <h5 class="alert-heading fw-medium">{{ translate('you_dont_have_ads_you_can_publish_ad_by_clicking') }} <a class="text-decoration-underline" href="{{ route('ads-adding-type') }}">{{'here'}}</a></h5>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>
    <!-- End Main Content -->
@endsection

@push('script')

    <script>
        $(document).ready(function () {
            $(".upload-file__input.banner").on("change", function (event) {
                const input = event.target;
                const file = input.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = $(input)
                            .siblings(".upload-file__img")
                            .find("img");

                        img.attr("src", e.target.result).removeAttr("hidden");

                        // Remove temp placeholder box
                        $(input)
                            .siblings(".upload-file__img")
                            .find(".temp-img-box")
                            .remove();
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

    <script>
        const packagePrices = @json($packages->pluck('price', 'id'));
    </script>

    <script> 
        document.addEventListener("DOMContentLoaded", function () { 
            const buttons = document.querySelectorAll('.package-btn');
            const submitButton = document.querySelector('#sponsor-submit-btn');
            let currentlySelectedId = null; 

            // Initialize button content wrapper
            function initializeButtonContent() {
                if (submitButton && !submitButton.querySelector('.button-content')) {
                    const content = submitButton.innerHTML;
                    submitButton.innerHTML = `<div class="button-content">${content}</div>`;
                }
            }

            // Function to create light ray effect
            function createLightRay() {
                if (!submitButton) return;
                
                const lightRay = document.createElement('div');
                lightRay.className = 'light-ray';
                submitButton.appendChild(lightRay);
                
                // Remove light ray after animation completes
                setTimeout(() => {
                    if (lightRay && lightRay.parentNode) {
                        lightRay.parentNode.removeChild(lightRay);
                    }
                }, 600);
            }

            // Track current button state
            let currentButtonState = 'checkout'; // 'add' or 'checkout'

            // Function to update submit button text with smooth animation
            function updateSubmitButtonText(packagePrice) {
                if (!submitButton) return;

                const buttonContent = submitButton.querySelector('.button-content');
                if (!buttonContent) return;

                // Determine new state
                const newState = packagePrice > 0 ? 'checkout' : 'add';
                
                // Only animate if state is actually changing
                if (currentButtonState === newState) {
                    return; // No change needed, exit without animation
                }

                // Update current state
                currentButtonState = newState;

                // Step 1: Slide current text out to the right
                buttonContent.classList.add('slide-out-right');

                setTimeout(() => {
                    // Step 2: Update the text content
                    if (packagePrice > 0) {
                        buttonContent.innerHTML = `
                            <span><i class="bi bi-floppy"></i></span> 
                            <span>{{translate('payment_checkout')}}</span>
                        `;
                    } else {
                        buttonContent.innerHTML = `
                            <span><i class="bi bi-floppy"></i></span> 
                            <span>{{translate('add')}}</span>
                        `;
                    }

                    // Step 3: Position new text to slide in from left
                    buttonContent.classList.remove('slide-out-right');
                    buttonContent.classList.add('slide-in-left');

                    // Step 4: Create light ray effect
                    createLightRay();

                    // Step 5: Slide new text into center position
                    setTimeout(() => {
                        buttonContent.classList.remove('slide-in-left');
                        buttonContent.classList.add('slide-in-center');
                        
                        // Step 6: Return to initial coordinates after animation
                        setTimeout(() => {
                            buttonContent.classList.remove('slide-in-center');
                        }, 300);
                    }, 50);

                }, 200); // Wait for slide out animation
            }

            // Initialize on page load
            initializeButtonContent();

            buttons.forEach(button => { 
                button.addEventListener('click', function () { 
                    const selectedId = this.dataset.id; 
                    const card = this.closest('.pricing-card'); 
                    const packageName = card.querySelector('.package-name')?.textContent || 'package'; 
                    const btn = this;
                    const packagePrice = packagePrices[selectedId] || 0;

                    // Check if clicking the already selected package 
                    if (currentlySelectedId === selectedId) { 
                        card.classList.remove('active'); 
                        card.querySelector('.check-icon')?.remove(); 
                        card.querySelector('#package_id')?.remove(); 
                        currentlySelectedId = null; 

                        // Reset button text 
                        btn.innerHTML = `{{ translate('get_started') }}`; 

                        // Update submit button text (back to original)
                        updateSubmitButtonText(0);

                        toastr.warning('', '{{translate("Package Removed")}}');
                        return; 
                    } 

                    // Clear previous selections 
                    document.querySelectorAll('.pricing-card').forEach(card => { 
                        card.classList.remove('active'); 
                    }); 
                    document.querySelectorAll('.check-icon').forEach(icon => icon.remove()); 
                    document.querySelectorAll('#package_id').forEach(input => input.remove()); 
                    document.querySelectorAll('.package-btn').forEach(btn => { 
                        btn.innerHTML = `{{ translate('get_started') }}`; 
                    }); 

                    // Select new package 
                    card.classList.add('active'); 

                    // Add check icon 
                    const icon = document.createElement('i'); 
                    icon.className = 'bi bi-check-circle-fill text-success position-absolute top-0 end-0 m-2 check-icon fs-4'; 
                    card.appendChild(icon); 

                    // Add hidden input 
                    const hiddenInput = document.createElement('input'); 
                    hiddenInput.type = 'hidden'; 
                    hiddenInput.name = 'package_id'; 
                    hiddenInput.id = 'package_id'; 
                    hiddenInput.value = selectedId; 
                    card.appendChild(hiddenInput); 

                    // Update selection 
                    currentlySelectedId = selectedId; 

                    // Change button text to icon + selected  
                    btn.innerHTML = `<i class="bi bi-check-circle-fill me-1"></i> {{ translate('selected') }}`;  

                    // Update submit button text based on package price
                    updateSubmitButtonText(packagePrice);

                    toastr.success('', '{{translate("Package Selected")}}'); 
                }); 
            }); 
        }); 
    </script>

    <script>
        $(document).ready(function () {
            $('.dropdown-menu .dropdown-item').on('click', function (e) {
                e.preventDefault();

                // Get the ad title from inside the clicked item
                let adTitle = $(this).find('h5').text().trim();

                let adId = $(this).data('id');

                // Update the button text
                $('#selectedCategoryText').text(adTitle);

                // Update hidden input
                $('#selected_ad_id').val(adId);
            });
        });
    </script>

@endpush

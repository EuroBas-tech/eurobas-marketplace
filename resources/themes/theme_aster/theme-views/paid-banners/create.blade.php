@extends('theme-views.layouts.app')

@section('title', translate('My_Profile').' | '.$web_config['name']->value.' '.translate('ecommerce'))

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
    .custom-input-height {
        height: 38px;
    }

    [dir="rtl"] .form-check.form-switch {
        padding-left: 0;
        padding-right: var(--bs-form-check-padding-start);
        text-align: right;
    }
    [dir="rtl"] .form-check.form-switch .form-check-input {
        float: right;
        margin-left: 0;
        margin-right: -var(--bs-form-check-padding-start);
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

    <!-- Aside Toggle Button -->
    @include('theme-views.partials._aside-toggler-btn')

    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 py-sm-3 pt-0 mb-4">
        <div class="container">
            <div class="row g-3">

                <!-- Sidebar-->
                @include('theme-views.partials._profile-aside')

                <div class="col-xxl-10 col-xl-9 col-lg-9 col-md-12 px-3">
                    <div>
                        <form method="POST" action="{{route('store.paid-banners')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-xl-12 mb-2">
                                <div class="form-group">
                                    <h1 class="pt-4 pb-3 sponsor-title" >{{translate('Promote Your Project or Product – Reach More Buyers with a Banner')}}</h1>
                                </div>
                            </div>

                            <div class="col-xl-12 mb-4">
                                <div class="form-check form-switch d-flex align-items-center gap-1 mb-3">
                                    <input class="form-check-input" type="checkbox" name="redirect_to_ads" role="switch" id="redirect_to_ads" >
                                    <label class="form-check-label m-0 pt-1" for="redirect_to_ads">
                                        {{ translate('redirect_to_one_of_your_ads_when_clicked') }}
                                    </label>
                                </div>
                                <div id="user_ads_box" class="form-group d-none">
                                    <div id="user_ads" >
                                        <label for="banner_url">{{translate('banner_url')}}</label>
                                        @include('theme-views.sponsor.partials._user-ads', ['user_ads' => $user_ads])
                                    </div>        
                                </div>
                            </div>

                            <div class="col-12 mb-sm-4 mb-5">
                                <div class="form-group">
                                    <label for="category_id">{{translate('category')}}</label>
                                    <select name="category_id" id="category_id" class="form-control" required>
                                        <option value="">{{translate('select_category')}}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                        <option value="">{{ translate('Other') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mb-sm-4 mb-5">
                                <div class="form-group">
                                    <label >{{translate('banner_image')}}</label>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="row">
                                            <div class="col-xl-6 col-md-7 col-sm-10 col-12">
                                                <div class="upload-file w-100">
                                                    <input 
                                                        type="file"
                                                        class="upload-file__input banner" 
                                                        name="banner_image" 
                                                        id="cover-input"
                                                        aria-required="true"
                                                        accept="image/*"
                                                    >
                                                    <div class="upload-file__img w-100">
                                                        <div class="temp-img-box">
                                                            <div class="d-flex align-items-center flex-column gap-2">
                                                                <i class="bi bi-upload fs-30"></i>
                                                                <div class="fs-12 text-muted">{{translate('banner_image')}}</div>
                                                            </div>
                                                        </div>
                                                        <img src="#" class="dark-support image-fit-cover border" alt="" hidden="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @include('theme-views.sponsor.partials._sponsor-package-blade-code')

                            <div class="col-12 mt-4"> 
                                <div> 
                                    <button id="sponsor-submit-btn" type="submit" class="btn btn-primary d-flex align-items-center gap-1"> 
                                        <span><i class="bi bi-floppy"></i></span> 
                                        <span>{{translate('payment_checkout')}}</span> 
                                    </button> 
                                </div> 
                            </div>

                        </form>
                    </div>
                </div>
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

   <script>
        $(document).ready(function () {
            $('#redirect_to_ads').on('change', function () {
                @if($user_ads->isEmpty())
                    // Always show error if no ads exist
                    toastr.error("There is no ad on this account");
                    // Keep the box hidden
                    $('#redirect_to_ads').prop('checked', false);
                    $('#user_ads_box').addClass('d-none');
                @else
                    if ($(this).is(':checked')) {
                        $('#user_ads_box').removeClass('d-none');
                    } else {
                        $('#user_ads_box').addClass('d-none');
                    }
                @endif
            });
        });
    </script>


    @include('theme-views.sponsor.partials._payment-methods-js-code')

@endpush

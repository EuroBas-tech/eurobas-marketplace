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

        .cke_notification .cke_notification_warning {
            display: none !important;
        }

        .responsive-register-title-font{
            font-size: 2.2rem;
        }
        @media (max-width: 768px) {
            .responsive-register-title-font{
                font-size: 2rem;
            }
        }
        @media (max-width: 576px) {
            .responsive-register-title-font{
                font-size: 1.5rem;
            }
        }

    </style>

@endpush


@section('content')
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 pt-5 mb-4 vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Sidebar-->
                <div class="col-lg-5 col-md-7 col-sm-10 col-12">
                    <div class="card h-lg-100 card-custom-shadow">
                        <div class="card-body p-4 pb-3">
                            <div>
                                <form method="POST" id="register-store-form" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="account_type" value="individual">
                                    <div class="row align-items-center gy-3">
                                        <div class="col-xl-12">
                                            <div class="form-group">
                                                <label for="name">{{translate('profile_name')}}</label>
                                                <input type="text" id="name" class="form-control input-height" value="{{ old('name') }}" name="name" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="form-group">
                                                <label class="mb-1" for="email">{{translate('Email')}}</label>
                                                <input type="email" id="email" class="form-control input-height" value="{{ old('email') }}" name="email" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="password">{{translate('Password')}}</label>
                                                <div class="input-inner-end-ele">
                                                    <input type="password" minlength="6" id="password" class="form-control input-height" name="password" placeholder="{{translate('Ex:_7+ character')}}">
                                                    <i class="bi bi-eye-slash-fill togglePassword custom-inset-block-end"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="password_confirmation">{{translate('Confirm_Password')}}</label>
                                                <div class="input-inner-end-ele">
                                                    <input type="password" minlength="6" id="password_confirmation" class="form-control input-height" name="password_confirmation" placeholder="{{translate('Ex:_7+ character')}}">
                                                    <i class="bi bi-eye-slash-fill togglePassword custom-inset-block-end"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="py-2" >
                                                <div class="d-flex align-items-start gap-1" >
                                                    <input class="form-check-input m-0" type="checkbox" name="agree" id="agree">
                                                    <label for="agree" class="m-0" >
                                                        <span class="fw-normal" >{{translate('i_agree_to_the')}}</span>
                                                        <a class="fw-medium text-primary" target="_blank" href="{{ route('terms') }}">
                                                            {{ translate('terms_and_conditions_and_privacy_policy') }}
                                                        </a>.
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Google reCAPTCHA v2 (Image Challenges) --}}
                                        @if($web_config['recaptcha']['status'] == 1)
                                            <div class="form-group">
                                                <div id="recaptcha_element_customer_register" class="w-100" data-register-id=""></div>
                                            </div>
                                        @endif

                                        <div class="col-12">
                                            <div class="d-flex justify-content-start gap-3">
                                                <button id="add-button" type="button" class="btn btn-primary d-flex align-items-center gap-2">
                                                    <i class="bi bi-person-plus fs-16"></i>
                                                    <span>{{translate('register')}}</span>
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
        $(document).ready(function() {
            function registerStore() {

                // Show loader and disable button
                $('#add-button').prop('disabled', true);
                $('#add-button').html(`
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    {{ translate('Processing...') }}
                `);

                // Check Google reCAPTCHA v2 validation
                @if($web_config['recaptcha']['status'] == 1)
                    var response_customer_register = grecaptcha.getResponse($('#recaptcha_element_customer_register').attr('data-register-id'));

                    if (response_customer_register.length === 0) {
                        // Restore button
                        $('#add-button').prop('disabled', false);
                        $('#add-button').html(`<i class="bi bi-person-plus fs-16"></i><span>{{translate('register')}}</span>`);

                        toastr.error("{{ translate('Please_check_the_recaptcha') }}");
                        return; // Stop execution
                    }
                @endif

                if (CKEDITOR.instances.description) {
                    CKEDITOR.instances.description.updateElement();
                }

                // 1. Get the form element
                let form = $('#register-store-form')[0];

                // 2. Create FormData object
                let formData = new FormData(form);

                $.ajax({
                    url: "{{ route('customer.auth.register-store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,  // Required for FormData
                    contentType: false,   // Required for FormData
                    cache: false,        // Recommended for file uploads
                    success: function(response) {

                        // Restore button
                        $('#add-button').prop('disabled', false);
                        $('#add-button').html(`<i class="bi bi-person-plus fs-16"></i><span>{{translate('register')}}</span>`);

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
                        $('#add-button').html(`<i class="bi bi-person-plus fs-16"></i><span>{{translate('register')}}</span>`);

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
                registerStore();
            });
        });

    </script>

    {{-- Google reCAPTCHA v2 Scripts - Optimized for More Challenges --}}
    <script type="text/javascript">
        var onloadCallbackCustomerRegister = function () {
            // Add some randomization to potentially trigger more challenges
            var randomParam = Math.random().toString(36).substring(7);

            let register_id = grecaptcha.render('recaptcha_element_customer_register', {
                'sitekey': '{{ \App\CPU\Helpers::get_business_settings('recaptcha')['site_key'] }}',
                'size': 'normal',
                'theme': 'light',
                'tabindex': 0,
                'isolated': true,
                'callback': function(response) {
                    console.log('reCAPTCHA completed: ' + randomParam);
                },
                'expired-callback': function() {
                    // Auto-reset on expiry to get new challenge
                    setTimeout(function() {
                        grecaptcha.reset(register_id);
                    }, 500);
                },
                'error-callback': function() {
                    // Auto-reset on error to get new challenge
                    setTimeout(function() {
                        grecaptcha.reset(register_id);
                    }, 1000);
                }
            });
            $('#recaptcha_element_customer_register').attr('data-register-id', register_id);

            // Subtle techniques to potentially increase challenge probability
            // Add some mouse movement simulation
            var recaptchaElement = document.getElementById('recaptcha_element_customer_register');
            if (recaptchaElement) {
                // Simulate natural user behavior patterns
                setTimeout(function() {
                    var event = new Event('mouseover');
                    recaptchaElement.dispatchEvent(event);
                }, Math.random() * 1000 + 500);
            }
        };

        // Additional entropy for session
        (function() {
            var userAgent = navigator.userAgent;
            var screenRes = screen.width + 'x' + screen.height;
            var timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            // These variables add entropy without being intrusive
        })();
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallbackCustomerRegister&render=explicit&hl=en" async defer></script>

@endpush






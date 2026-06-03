@extends('theme-views.layouts.app')

@section('title', translate('login').' | '.$web_config['name']->value)

@push('css_or_js')
    <meta property="og:image" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">

    <style>
        /* Auth page: keep the card near the top and let the page flow naturally to
           the footer (no forced full-viewport height that pushes content down). */
        .auth-wrap {
            min-height: calc(100vh - 320px); /* fills enough so the footer sits low */
        }
        .card-custom-shadow {
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            border: 1px solid #e7e9ec;
        }
        .auth-wrap .form-control,
        .auth-wrap select,
        .auth-wrap input[type="text"],
        .auth-wrap input[type="email"],
        .auth-wrap input[type="password"] {
            height: 48px !important;
            padding: .65rem .9rem;
        }
    </style>
@endpush

@section('content')
    <!-- Main Content -->
    <main class="main-content auth-wrap py-4 py-md-5 mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7 col-sm-10 col-12">
                    <div class="card card-custom-shadow">
                        <div class="card-body p-4 pb-3">

                            <div class="mb-3 text-center">
                                <img
                                    width="180"
                                    src="{{cloudfront('company')}}/{{\App\Model\BusinessSetting::where(['type' => 'company_mobile_logo'])->pluck('value')[0]}}"
                                    onerror="this.src='{{theme_asset('assets/img/image-place-holder-2_1.png')}}'"
                                    alt="" class="dark-support"/>
                            </div>
                            <div class="mb-4 text-center">
                                <h2 class="mb-0">{{ translate('login') }}</h2>
                            </div>

                            <form method="POST" id="customer_login_page_form" action="{{route('customer.auth.login')}}" autocomplete="off">
                                @csrf
                                <input type="hidden" name="redirect_url" value="{{ session('keep_return_url') ?? route('home') }}">

                                <div class="form-group mb-3">
                                    <label for="login-email">{{ translate('email') }}</label>
                                    <input type="text" name="user_id" id="login-email" class="form-control input-height"
                                           value="{{old('user_id')}}"
                                           placeholder="{{translate('Enter_email_or_phone_number')}}" required/>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="login-password">{{ translate('password') }}</label>
                                    <div class="input-inner-end-ele">
                                        <input type="password" name="password" id="login-password" class="form-control input-height"
                                               placeholder="{{ translate('Ex:_6+_character') }}" required/>
                                        <i class="bi bi-eye-slash-fill togglePassword custom-inset-block-end"></i>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between gap-3 align-items-center mb-3">
                                    <label for="remember" class="d-flex gap-1 align-items-center mb-0">
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>
                                        {{ translate('remember_me') }}
                                    </label>
                                    <a href="{{route('customer.auth.recover-password')}}">{{ translate('Forgot_Password') }} ?</a>
                                </div>

                                {{-- Google reCAPTCHA v2 (Image Challenges) --}}
                                @if(recaptcha_enabled())
                                    <div class="form-group mb-3">
                                        <div id="recaptcha_element_customer_login_page" class="w-100" data-login-id=""></div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <button type="submit" id="login-page-button" class="fs-16 btn btn-primary d-block w-100 px-5">
                                        {{ translate('login') }}
                                    </button>
                                </div>
                            </form>

                            @if($web_config['social_login_text'])
                                <p class="text-center text-muted mb-2">{{ translate('or_continue_with') }}</p>
                            @endif

                            <div class="d-flex justify-content-center gap-3 align-items-center flex-wrap pb-3">
                                @foreach ($web_config['socials_login'] as $socialLoginService)
                                    @if (isset($socialLoginService) && $socialLoginService['status']==true)
                                        <a href="{{route('customer.auth.service-login', $socialLoginService['login_medium'])}}">
                                            <img width="35" src="{{ theme_asset('assets/img/svg/'.$socialLoginService['login_medium'].'.svg') }}"
                                                 alt="" class="dark-support"/>
                                        </a>
                                    @endif
                                @endforeach

                                @if (isset($web_config['apple_login']) && $web_config['apple_login'][0]['status']==true)
                                    <a href="{{route('customer.auth.service-login', $web_config['apple_login'][0]['login_medium'])}}">
                                        <img width="35" alt="" class="dark-support"
                                             src="{{asset('/public/assets/back-end/img/apple.png')}}" />
                                    </a>
                                @endif
                            </div>

                            <div class="text-center pt-2 border-top">
                                <span class="text-muted">{{ translate('do_not_have_an_account') }}</span>
                                <a href="{{route('customer.auth.sign-up-type')}}" class="fw-medium text-primary">{{ translate('register') }}</a>
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
        $("#customer_login_page_form").submit(function (e) {
            e.preventDefault();

            var customer_recaptcha = null;

            @if(recaptcha_enabled())
                customer_recaptcha = true;
                var response_customer_login = grecaptcha.getResponse($('#recaptcha_element_customer_login_page').attr('data-login-id'));
                if (response_customer_login.length === 0) {
                    toastr.error("{{ translate('Please_check_the_recaptcha') }}");
                    customer_recaptcha = false;
                }
            @endif

            if (customer_recaptcha === null || customer_recaptcha === true) {
                let form = $(this);
                let btn = $('#login-page-button');
                btn.prop('disabled', true);
                $.ajax({
                    type: 'POST',
                    url: `{{route('customer.auth.login')}}`,
                    data: form.serialize(),
                    success: function (data) {
                        if (data.status === 'success') {
                            toastr.success(`{{translate('Login_successful')}}`);
                            data.redirect_url !== '' ? window.location.href = data.redirect_url : location.reload();
                        } else if (data.status === 'error') {
                            btn.prop('disabled', false);
                            data.redirect_url !== '' ? window.location.href = data.redirect_url : toastr.error(data.message);
                        }
                    },
                    error: function () {
                        btn.prop('disabled', false);
                        toastr.error("{{ translate('an_error_occurred') }}");
                    }
                });
            }
        });
    </script>

    @if(recaptcha_enabled())
        <script type="text/javascript">
            var onloadCallbackCustomerLoginPage = function () {
                let login_id = grecaptcha.render('recaptcha_element_customer_login_page', {
                    'sitekey': '{{ \App\CPU\Helpers::get_business_settings('recaptcha')['site_key'] }}',
                    'size': 'normal',
                    'theme': 'light',
                    'tabindex': 0,
                    'isolated': true,
                    'expired-callback': function() { setTimeout(function() { grecaptcha.reset(login_id); }, 500); },
                    'error-callback': function() { setTimeout(function() { grecaptcha.reset(login_id); }, 1000); }
                });
                $('#recaptcha_element_customer_login_page').attr('data-login-id', login_id);
            };
        </script>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallbackCustomerLoginPage&render=explicit&hl=en" async defer></script>
    @endif
@endpush

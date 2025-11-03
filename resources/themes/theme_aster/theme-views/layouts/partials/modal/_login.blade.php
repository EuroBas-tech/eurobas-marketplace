<!-- Login Modal -->
<div
    class="modal fade"
    id="loginModal"
    tabindex="-1"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body px-4 px-sm-5">
                <div class="mb-4 text-center">
                    <img
                        width="200"
                        src="{{cloudfront('company')}}/{{\App\Model\BusinessSetting::where(['type' => 'company_mobile_logo'])->pluck('value')[0]}}"
                        onerror="this.src='{{theme_asset('assets/img/image-place-holder-2_1.png')}}'"
                        alt=""
                        class="dark-support"
                    />
                </div>
                <div class="mb-4">
                    <h2 class="mb-2">{{ translate('login') }}</h2>
                </div>
                <form action="{{route('customer.auth.login')}}" method="post" id="customer_login_modal" autocomplete="off">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="email">{{ translate('email') }}</label>
                        <input
                            name="user_id" id="si-email"
                            class="form-control" value="{{old('user_id')}}"
                            placeholder="{{translate('Enter_email_or_phone_number')}}" required
                        />
                    </div>

                    <div class="mb-4">
                        <label for="password">{{ translate('password') }}</label>
                        <div class="input-inner-end-ele">
                            <input
                                name="password" type="password" id="si-password"
                                class="form-control"
                                placeholder="{{ translate('Ex:_6+_character') }}"
                                required
                            />
                            <i class="bi bi-eye-slash-fill togglePassword"></i>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between gap-3 align-items-center">
                        <label
                            for="remember_me"
                            class="d-flex gap-1 align-items-center mb-0">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>
                            {{ translate('remember_me') }}
                        </label>

                        <a href="{{route('customer.auth.recover-password')}}">{{ translate('Forgot_Password') }} ?</a>
                    </div>

                    {{-- Google reCAPTCHA v2 (Image Challenges) --}}
                    @if($web_config['recaptcha']['status'] == 1)
                        <div class="form-group mb-4">
                            <div id="recaptcha_element_customer_login" class="w-100 pt-4" data-login-id=""></div>
                        </div>
                    @endif

                    <div class="my-4">
                        <button type="submit" class="fs-16 btn btn-primary d-block w-100 px-5">{{ translate('login') }}</button>
                    </div>
                </form>

                @if($web_config['social_login_text'])
                    <p class="text-center text-muted">{{ translate('or_continue_with') }}</p>
                @endif

                <div class="d-flex justify-content-center gap-3 align-items-center flex-wrap pb-3">
                    @foreach ($web_config['socials_login'] as $socialLoginService)
                        @if (isset($socialLoginService) && $socialLoginService['status']==true)
                            <a href="{{route('customer.auth.service-login', $socialLoginService['login_medium'])}}">
                                <img
                                    width="35"
                                    src="{{ theme_asset('assets/img/svg/'.$socialLoginService['login_medium'].'.svg') }}"
                                    alt=""
                                    class="dark-support"/>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    {{-- Google reCAPTCHA v2 Scripts - Optimized for More Challenges --}}
    <script type="text/javascript">
        var onloadCallbackCustomerLogin = function () {
            // Add some randomization to potentially trigger more challenges
            var randomParam = Math.random().toString(36).substring(7);

            let login_id = grecaptcha.render('recaptcha_element_customer_login', {
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
                        grecaptcha.reset(login_id);
                    }, 500);
                },
                'error-callback': function() {
                    // Auto-reset on error to get new challenge
                    setTimeout(function() {
                        grecaptcha.reset(login_id);
                    }, 1000);
                }
            });
            $('#recaptcha_element_customer_login').attr('data-login-id', login_id);

            // Subtle techniques to potentially increase challenge probability
            // Add some mouse movement simulation
            var recaptchaElement = document.getElementById('recaptcha_element_customer_login');
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
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallbackCustomerLogin&render=explicit&hl=en" async defer></script>

    <script>
        $("#customer_login_modal").submit(function (e) {
            e.preventDefault();

            var customer_recaptcha = null;

            @if($web_config['recaptcha']['status'] == 1)
                var customer_recaptcha = true;

                // Check Google reCAPTCHA v2 validation
                var response_customer_login = grecaptcha.getResponse($('#recaptcha_element_customer_login').attr('data-login-id'));

                if (response_customer_login.length === 0) {
                    e.preventDefault();
                    toastr.error("{{ translate('Please_check_the_recaptcha') }}");
                    customer_recaptcha = false;
                }
            @endif

            if(customer_recaptcha === null || customer_recaptcha === true) {
                let form = $(this);
                $.ajax({
                    type: 'POST',
                    url:`{{route('customer.auth.login')}}`,
                    data: form.serialize(),
                    success: function (data) {
                        if (data.status === 'success') {
                            toastr.success(`{{translate('Login_successful')}}`);
                            data.redirect_url !== '' ? window.location.href = data.redirect_url : location.reload();
                        } else if (data.status === 'error') {
                            data.redirect_url !== '' ? window.location.href = data.redirect_url : toastr.error(data.message);
                        }
                    }
                });
            }
        });
    </script>
@endpush

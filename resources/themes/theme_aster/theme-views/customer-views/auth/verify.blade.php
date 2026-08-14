@extends('theme-views.layouts.app')

@section('title', translate('Customer_Verify').' | '.$web_config['name']->value.''.translate('ecommerce'))

@section('content')
<style>
    .auth-wrapper {
        min-height: 85vh;
        display: flex;
        align-items: center;
        background: #f8faff;
        padding: 40px 0;
    }
    .auth-left {
        background: linear-gradient(145deg, #0f407d 0%, #1a6fd4 60%, #3b82f6 100%);
        border-radius: 20px 0 0 20px;
        padding: 60px 48px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 520px;
        position: relative;
        overflow: hidden;
    }
    .auth-left::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        top: -80px;
        right: -80px;
    }
    .auth-left::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        bottom: -60px;
        left: -60px;
    }
    .auth-left .brand-name {
        font-size: 2.4rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.1;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
    }
    .auth-left .brand-name span { color: #fbbf24; }
    .auth-left .brand-tagline {
        font-size: 1rem;
        color: rgba(255,255,255,0.85);
        margin-bottom: 40px;
        position: relative;
        z-index: 1;
    }
    .auth-left .feature-list {
        list-style: none;
        padding: 0;
        margin: 0;
        position: relative;
        z-index: 1;
    }
    .auth-left .feature-list li {
        color: rgba(255,255,255,0.9);
        font-size: 0.95rem;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .auth-left .feature-list li i {
        width: 32px;
        height: 32px;
        background: rgba(255,255,255,0.15);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }
    .auth-right {
        background: #fff;
        border-radius: 0 20px 20px 0;
        padding: 60px 48px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 520px;
        box-shadow: 4px 0 40px rgba(59,130,246,0.10);
    }
    .auth-right h2 {
        font-size: 1.6rem;
        font-weight: 700;
        color: #0f407d;
        margin-bottom: 8px;
        text-align: center;
    }
    .auth-right .subtitle {
        color: #6b7280;
        font-size: 0.92rem;
        margin-bottom: 32px;
        line-height: 1.6;
        text-align: center;
    }
    .otp-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #e8f0fe, #dbeafe);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    /* OTP Fields */
    .otp-field {
        width: 56px !important;
        height: 64px !important;
        font-size: 24px !important;
        font-weight: 700 !important;
        text-align: center !important;
        border: 2px solid #e0e7ef !important;
        border-radius: 12px !important;
        background: #f8faff !important;
        color: #0f407d !important;
        transition: border-color 0.2s !important;
        direction: ltr !important;
        /* Fix Arabic RTL */
        -webkit-text-fill-color: #0f407d;
    }
    .otp-field:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.10) !important;
        background: #fff !important;
        outline: none !important;
    }
    /* Force LTR for OTP container */
    .otp-container {
        direction: ltr !important;
        display: flex;
        gap: 12px;
        justify-content: center;
        margin: 24px 0;
    }
    .btn-auth-primary {
        background: linear-gradient(135deg, #0f407d, #3b82f6);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 14px;
        font-size: 16px;
        font-weight: 600;
        width: 100%;
        transition: opacity 0.2s;
        cursor: pointer;
    }
    .btn-auth-primary:hover { opacity: 0.92; }
    .btn-auth-primary:disabled { opacity: 0.6; cursor: not-allowed; }
    .btn-resend {
        color: #3b82f6;
        background: transparent;
        border: 1.5px solid #3b82f6;
        border-radius: 10px;
        padding: 13px;
        font-size: 15px;
        width: 100%;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 10px;
    }
    .btn-resend:hover { background: #f0f4ff; }
    .btn-resend:disabled { opacity: 0.5; cursor: not-allowed; }
    .timer-text { color: #3b82f6; font-weight: 600; text-align: center; margin-bottom: 8px; }
    @media (max-width: 767px) {
        .auth-left { border-radius: 20px 20px 0 0; min-height: auto; padding: 40px 24px 32px; }
        .auth-right { border-radius: 0 0 20px 20px; padding: 32px 24px 40px; }
        .otp-field { width: 52px !important; height: 60px !important; font-size: 22px !important; }
    }
</style>

<div class="auth-wrapper">
    <div class="container">
        {{-- OTP Form --}}
        <div class="{{($user_verify == 1 ? 'd-none' : '')}}" id="otp_form_section">
            <div class="row g-0 shadow-lg" style="border-radius:20px;overflow:hidden;max-width:900px;margin:0 auto;">
                {{-- Left side --}}
                <div class="col-lg-5 auth-left">
                    <div class="brand-name">Euro<span>Bas</span>.com</div>
                    <div class="brand-tagline">Europe's Marketplace</div>
                    <ul class="feature-list">
                        <li><i class="bi bi-shield-check"></i> {{ translate('Secure_and_trusted_platform') }}</li>
                        <li><i class="bi bi-globe-europe-africa"></i> {{ translate('All_European_countries') }}</li>
                        <li><i class="bi bi-tag"></i> {{ translate('Free_classifieds_for_everyone') }}</li>
                        <li><i class="bi bi-house"></i> {{ translate('Real_Estate_Vehicles_and_More') }}</li>
                    </ul>
                </div>
                {{-- Right side --}}
                <div class="col-lg-7 auth-right">
                    <div class="otp-icon">
                        <i class="bi bi-envelope-check" style="font-size:24px;color:#3b82f6;"></i>
                    </div>
                    <h2>{{ translate('OTP_Verification') }}</h2>

                    @php($email_verify_status = \App\CPU\Helpers::get_business_settings('email_verification'))
                    @php($phone_verify_status = \App\CPU\Helpers::get_business_settings('phone_verification'))

                    @if($phone_verify_status == 1)
                        <p class="subtitle">{{ translate('An_OTP_(One_Time_Password)_has_been_sent_to') }} <strong>{{$user->phone}}</strong>.<br>{{ translate('Please_enter_the_OTP_in_the_field_below_to_verify_your_phone.') }}</p>
                    @elseif($email_verify_status == 1)
                        <p class="subtitle">{{ translate('An_OTP_(One_Time_Password)_has_been_sent_to_your_email.') }}<br>{{ translate('Please_enter_the_OTP_in_the_field_below_to_verify_your_email.') }}</p>
                    @endif

                    <div class="resend_otp_custom">
                        <p class="timer-text">{{ translate('Resend_code_within') }}</p>
                        <p class="timer-text verifyTimer mb-4">
                            <span class="verifyCounter" data-second="{{$get_time}}"></span>s
                        </p>
                    </div>

                    <form action="{{ route('customer.auth.ajax_verify') }}" class="otp-form" method="POST" id="customer_verify">
                        @csrf
                        {{-- OTP fields - always LTR --}}
                        <div class="otp-container">
                            <input class="otp-field @if($email_verify_status == 1) style--two @endif" type="text" name="opt-field[]" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]*">
                            <input class="otp-field @if($email_verify_status == 1) style--two @endif" type="text" name="opt-field[]" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]*">
                            <input class="otp-field @if($email_verify_status == 1) style--two @endif" type="text" name="opt-field[]" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]*">
                            <input class="otp-field @if($email_verify_status == 1) style--two @endif" type="text" name="opt-field[]" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]*">
                        </div>
                        <input class="otp-value" type="hidden" name="token">
                        <input type="hidden" value="{{$user->id}}" name="id">

                        <div class="d-flex flex-column gap-2 mt-3">
                            <button class="btn-auth-primary" type="submit" @if($email_verify_status != 1 && $phone_verify_status != 1) disabled @endif>
                                <i class="bi bi-check-circle me-2"></i>{{ translate('verify') }}
                            </button>
                            <button class="btn-resend resend-otp-button" type="button" id="resend_otp">
                                <i class="bi bi-arrow-clockwise me-1"></i>{{ translate('Resend_OTP') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Success Message --}}
        <div class="{{($user_verify != 1 ? 'd-none' : '')}}" id="success_message">
            <div class="row g-0 shadow-lg" style="border-radius:20px;overflow:hidden;max-width:600px;margin:0 auto;">
                <div class="col-12" style="background:#fff;padding:60px 48px;text-align:center;border-radius:20px;">
                    <div style="width:72px;height:72px;background:linear-gradient(135deg,#e8f0fe,#dbeafe);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
                        <i class="bi bi-check-circle-fill" style="font-size:32px;color:#3b82f6;"></i>
                    </div>
                    <h3 style="color:#0f407d;font-weight:700;margin-bottom:12px;">{{translate('Verification_Successfully_Completed')}}</h3>
                    <p style="color:#6b7280;margin-bottom:32px;">{{ translate('Thank_you_for_your_verification')}}! {{ translate('Now_you_can_login_your_account_is_ready_to_use') }}</p>
                    <a class="btn-auth-primary" style="display:inline-block;text-decoration:none;padding:14px 40px;width:auto;" href="{{ route('customer.auth.login') }}">
                        {{ translate('login') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $('#customer_verify').on('submit', function (event) {
        event.preventDefault();
        let login_form = $(this);
        $.ajax({
            url: login_form.attr('action'),
            method: 'POST',
            dataType: "json",
            data: login_form.serialize(),
            beforeSend: function () { $("#loading").addClass("d-grid"); },
            success: function (data) {
                if (data.status === 'success') {
                    $('#otp_form_section').addClass('d-none');
                    $('#success_message').removeClass('d-none');
                    toastr.success(data.message);
                    setTimeout(function () { window.location.href = "{{ route('customer.auth.login') }}"; }, 1500);
                } else {
                    toastr.error(data.message);
                }
            },
            complete: function () { $("#loading").removeClass("d-grid"); },
        });
    });

    $('#resend_otp').click(function(){
        $('input.otp-field').val('');
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } });
        $.ajax({
            url: `{{route('customer.auth.resend_otp')}}`,
            method: 'POST',
            dataType: 'json',
            data: { 'user_id': {{$user->id}} },
            beforeSend: function () { $("#loading").addClass("d-grid"); },
            success: function (data) {
                if (data.status == 1) {
                    let new_counter = $(".verifyCounter");
                    let new_seconds = data.new_time;
                    function new_tick() {
                        let m = Math.floor(new_seconds / 60);
                        let s = new_seconds % 60;
                        new_seconds--;
                        new_counter.html(m + ":" + (s < 10 ? "0" : "") + String(s));
                        if (new_seconds > 0) {
                            setTimeout(new_tick, 1000);
                            $('.resend-otp-button').attr('disabled', true);
                            $(".resend_otp_custom").slideDown();
                        } else {
                            $('.resend-otp-button').removeAttr('disabled');
                            $(".verifyCounter").html("0:00");
                            $(".resend_otp_custom").slideUp();
                        }
                    }
                    new_tick();
                    toastr.success(`{{translate('OTP_has_been_sent_again.')}}`);
                } else {
                    toastr.error(`{{translate('please_wait_for_new_code.')}}`);
                }
            },
            complete: function () { $("#loading").removeClass("d-grid"); },
        });
    });
</script>
@endpush

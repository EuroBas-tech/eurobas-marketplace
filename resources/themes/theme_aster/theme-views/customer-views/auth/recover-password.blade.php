@extends('theme-views.layouts.app')

@section('title', translate('Forgot_Password').' | '.$web_config['name']->value)

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
    }
    .auth-right .subtitle {
        color: #6b7280;
        font-size: 0.92rem;
        margin-bottom: 32px;
        line-height: 1.6;
    }
    .auth-right .form-control {
        border-radius: 10px;
        border: 1.5px solid #e0e7ef;
        padding: 13px 16px;
        font-size: 16px;
        transition: border-color 0.2s;
        background: #f8faff;
    }
    .auth-right .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.10);
        background: #fff;
    }
    .auth-right label {
        font-weight: 600;
        color: #374151;
        font-size: 0.9rem;
        margin-bottom: 6px;
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
    .btn-auth-back {
        color: #3b82f6;
        background: transparent;
        border: 1.5px solid #3b82f6;
        border-radius: 10px;
        padding: 13px;
        font-size: 15px;
        width: 100%;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 12px;
    }
    .btn-auth-back:hover { background: #f0f4ff; }
    .lock-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #e8f0fe, #dbeafe);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }
    @media (max-width: 767px) {
        .auth-left { border-radius: 20px 20px 0 0; min-height: auto; padding: 40px 24px 32px; }
        .auth-right { border-radius: 0 0 20px 20px; padding: 32px 24px 40px; }
    }
</style>

<div class="auth-wrapper">
    <div class="container">
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
                <div class="lock-icon">
                    <i class="bi bi-lock" style="font-size:24px;color:#3b82f6;"></i>
                </div>
                <h2>{{ translate('Forget_Password') }}</h2>
                <p class="subtitle">
                    @if($verification_by == 'email')
                        {{ translate('please_enter_your_email_to_send_a_verification_code_for_forget_password') }}
                    @else
                        {{ translate('please_enter_your_phone_to_send_a_verification_code_for_forget_password') }}
                    @endif
                </p>

                <form action="{{ route('customer.auth.forgot-password') }}" method="post">
                    @csrf
                    <div class="form-group mb-4">
                        @if($verification_by == 'email')
                            <label for="recover-email">{{ translate('email') }}</label>
                            <input class="form-control" type="email" name="identity" id="recover-email" autocomplete="off" required placeholder="example@email.com">
                        @else
                            <label for="recover-phone">{{ translate('phone') }}</label>
                            <input class="form-control" type="text" name="identity" id="recover-phone" autocomplete="off" required>
                        @endif
                    </div>
                    <button class="btn-auth-primary" type="submit">
                        <i class="bi bi-send me-2"></i>{{ translate('verify') }}
                    </button>
                    <button class="btn-auth-back" onclick="location.href='{{ route('home') }}'" type="button">
                        <i class="bi bi-arrow-left me-1"></i> {{ translate('back_again') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

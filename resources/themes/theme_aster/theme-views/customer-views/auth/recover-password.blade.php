@extends('theme-views.layouts.app')

@section('title', translate('Forgot_Password').' | '.$web_config['name']->value.''.translate('ecommerce'))

@section('content')
<!-- Premium Custom Styles -->
<style>
    .auth-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
    }
    .auth-card {
        border: none;
        border-radius: 1.5rem;
        box-shadow: 0 20px 40px rgba(13, 50, 181, 0.08);
        background: #ffffff;
        overflow: hidden;
    }
    .auth-visual-side {
        background: linear-gradient(135deg, #0b2265 0%, #0d32b5 100%);
        position: relative;
        overflow: hidden;
    }
    /* Subtle decorative background pattern */
    .auth-visual-side::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 10%, transparent 20%);
        background-size: 30px 30px;
        transform: rotate(15deg);
    }
    .brand-glow-circle {
        width: 110px;
        height: 110px;
        background: rgba(255, 255, 255, 0.1);
        border: 2px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }
    .brand-glow-circle img {
        width: 85px;
        height: 85px;
        object-fit: cover;
        border-radius: 50%;
    }
    .brand-domain {
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        color: #ffffff;
    }
    .brand-domain span {
        color: #ffb703; /* Accent yellow/orange matching logo stars */
    }
    .form-input-group {
        position: relative;
    }
    .form-input-group .input-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 1.25rem;
        color: #94a3b8;
        z-index: 4;
    }
    html[dir="rtl"] .form-input-group .input-icon {
        right: auto;
        left: 1.25rem;
    }
    .form-control-modern {
        height: 54px;
        border-radius: 0.85rem;
        border: 1px solid #e2e8f0;
        padding: 0.75rem 1.25rem;
        font-size: 0.95rem;
        background-color: #f8fafc;
        transition: all 0.25s ease-in-out;
    }
    .form-control-modern:focus {
        background-color: #ffffff;
        border-color: #0d32b5;
        box-shadow: 0 0 0 4px rgba(13, 50, 181, 0.12);
    }
    .btn-action-primary {
        background: linear-gradient(135deg, #0d32b5 0%, #082386 100%);
        color: #ffffff;
        height: 52px;
        border-radius: 0.85rem;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        box-shadow: 0 8px 20px rgba(13, 50, 181, 0.25);
        transition: all 0.3s ease;
    }
    .btn-action-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(13, 50, 181, 0.35);
        color: #ffffff;
    }
    .btn-action-outline {
        border: 1.5 solid #e2e8f0;
        background-color: #ffffff;
        color: #475569;
        height: 52px;
        border-radius: 0.85rem;
        font-weight: 600;
        transition: all 0.25s ease;
    }
    .btn-action-outline:hover {
        background-color: #f1f5f9;
        color: #0f172a;
        border-color: #cbd5e1;
    }
</style>

<!-- Main Content -->
<main class="main-content auth-wrapper py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">
                <div class="card auth-card">
                    <div class="row g-0">
                        
                        <!-- Left Side: Clean Visual Branding -->
                        <div class="col-lg-5 auth-visual-side text-white d-flex flex-column justify-content-center align-items-center p-5 text-center position-relative">
                            <div class="brand-glow-circle mb-4">
                                <img src="{{ theme_asset('assets/img/icon star pay.jpg') }}" alt="EuroBas" onerror="this.style.display='none'">
                            </div>
                            <h2 class="brand-domain mb-2">Euro<span>Bas</span>.com</h2>
                            <div style="width: 40px; height: 3px; background: #ffb703; border-radius: 2px;" class="mb-3"></div>
                            <p class="text-white-50 fs-14 mb-0" style="max-width: 240px; line-height: 1.5;">
                                European Marketplace Platform
                            </p>
                        </div>

                        <!-- Right Side: Clean Form Section -->
                        <div class="col-lg-7 bg-white p-4 p-md-5 d-flex flex-column justify-content-center">
                            
                            <div class="mb-4">
                                <h3 class="fw-bold text-dark mb-2">{{ translate('Forget_Password') }}</h3>
                                <p class="text-muted fs-14 mb-0" style="line-height: 1.6;">
                                    @if($verification_by == 'email')
                                        {{ translate('please_enter_your_email_to_send_a_verification_code_for_forget_password') }}
                                    @elseif($verification_by=='phone')
                                        {{ translate('please_enter_your_phone_to_send_a_verification_code_for_forget_password') }}
                                    @endif
                                </p>
                            </div>

                            <form action="{{route('customer.auth.forgot-password')}}" class="forget-password-form" method="post">
                                @csrf
                                
                                @if($verification_by=='email')
                                    <div class="form-group mb-4">
                                        <label for="recover-email" class="form-label text-dark fw-semibold mb-2 fs-14">{{translate('email')}}</label>
                                        <div class="form-input-group">
                                            <input class="form-control form-control-modern" type="email" name="identity" id="recover-email" autocomplete="off" required placeholder="name@example.com">
                                        </div>
                                        <div class="invalid-feedback">{{translate('Please_provide_valid_email_address.')}}</div>
                                    </div>
                                @else
                                    <div class="form-group mb-4">
                                        <label for="recover-email" class="form-label text-dark fw-semibold mb-2 fs-14">{{translate('phone')}}</label>
                                        <div class="form-input-group">
                                            <input class="form-control form-control-modern" type="text" name="identity" id="recover-email" autocomplete="off" required placeholder="+123456789">
                                        </div>
                                        <div class="invalid-feedback">{{translate('Please_provide_valid_phone_number.')}}</div>
                                    </div>
                                @endif

                                <div class="row g-3 pt-2">
                                    <div class="col-sm-6 order-2 order-sm-1">
                                        <button class="btn btn-action-outline w-100" onclick="location.href='{{ route('home') }}'" type="button">{{ translate('back_again') }}</button>
                                    </div>
                                    <div class="col-sm-6 order-1 order-sm-2">
                                        <button class="btn btn-action-primary w-100" type="submit">{{ translate('verify') }}</button>
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

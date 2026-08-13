@extends('theme-views.layouts.app')

@section('title', translate('Forgot_Password').' | '.$web_config['name']->value.''.translate('ecommerce'))

@section('content')
<!-- Custom Styles for Modern Aesthetic -->
<style>
    .auth-card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        background: #ffffff;
        overflow: hidden;
    }
    .auth-bg-gradient {
        background: linear-gradient(135deg, #0d32b5 0%, #001f8f 100%);
        border-radius: 1.25rem 0 0 1.25rem;
    }
    @media (max-width: 991.98px) {
        .auth-bg-gradient {
            border-radius: 1.25rem 1.25rem 0 0;
        }
    }
    .brand-logo-img {
        max-width: 140px;
        height: auto;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
    }
    .form-control-custom {
        height: 50px;
        border-radius: 0.75rem;
        border: 1px solid #e2e8f0;
        padding-left: 1.25rem;
        padding-right: 1.25rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    .form-control-custom:focus {
        border-color: #0d32b5;
        box-shadow: 0 0 0 4px rgba(13, 50, 181, 0.15);
    }
    .btn-custom-primary {
        background-color: #0d32b5;
        border-color: #0d32b5;
        color: #ffffff;
        height: 48px;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-custom-primary:hover {
        background-color: #082386;
        border-color: #082386;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(13, 50, 181, 0.25);
    }
    .btn-custom-outline {
        border: 1px solid #cbd5e1;
        color: #475569;
        height: 48px;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-custom-outline:hover {
        background-color: #f8fafc;
        border-color: #94a3b8;
        color: #1e293b;
    }
    .icon-wrapper {
        width: 70px;
        height: 70px;
        background: rgba(13, 50, 181, 0.08);
        color: #0d32b5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<!-- Main Content -->
<main class="main-content d-flex flex-column gap-3 py-4 mb-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <div class="card auth-card">
                    <div class="row g-0 align-items-stretch">
                        
                        <!-- Left Side: Visual & Branding Section -->
                        <div class="col-lg-5 auth-bg-gradient text-white d-flex flex-column justify-content-center align-items-center p-5 text-center">
                            <div class="mb-4">
                                <img class="brand-logo-img mb-3" src="{{ theme_asset('assets/img/icon star pay.jpg') }}" alt="Logo">
                            </div>
                            <h3 class="text-white fw-bold mb-3">{{ translate('Forget_Password') }}</h3>
                            <p class="text-white-50 fs-14 mb-0" style="max-width: 280px; line-height: 1.6;">
                                @if($verification_by == 'email')
                                    {{ translate('please_enter_your_email_to_send_a_verification_code_for_forget_password') }}
                                @elseif($verification_by=='phone')
                                    {{ translate('please_enter_your_phone_to_send_a_verification_code_for_forget_password') }}
                                @endif
                            </p>
                        </div>

                        <!-- Right Side: Form Section -->
                        <div class="col-lg-7 bg-white p-4 p-sm-5 d-flex flex-column justify-content-center">
                            
                            <div class="text-center mb-4">
                                <div class="icon-wrapper mx-auto mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-shield-lock" viewBox="0 0 16 16">
                                        <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.126a.5.5 0 0 0 .332 0c.112-.04.27-.101.483-.222a10.8 10.8 0 0 0 2.416-2.263c1.527-1.998 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                                        <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 1 1 9.5 6.5"/>
                                    </svg>
                                </div>
                                <h4 class="fw-bold text-dark mb-1">{{ translate('Forget_Password') }}</h4>
                                <p class="text-muted fs-14">
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
                                        <label for="recover-email" class="form-label text-secondary font-weight-500 mb-2">{{translate('email')}}</label>
                                        <input class="form-control form-control-custom" type="email" name="identity" id="recover-email" autocomplete="off" required placeholder="example@domain.com">
                                        <div class="invalid-feedback">{{translate('Please_provide_valid_email_address.')}}</div>
                                    </div>
                                @else
                                    <div class="form-group mb-4">
                                        <label for="recover-email" class="form-label text-secondary font-weight-500 mb-2">{{translate('phone')}}</label>
                                        <input class="form-control form-control-custom" type="text" name="identity" id="recover-email" autocomplete="off" required placeholder="+123456789">
                                        <div class="invalid-feedback">{{translate('Please_provide_valid_phone_number.')}}</div>
                                    </div>
                                @endif

                                <div class="row g-3 mt-2">
                                    <div class="col-sm-6">
                                        <button class="btn btn-custom-outline w-100" onclick="location.href='{{ route('home') }}'" type="button">{{ translate('back_again') }}</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button class="btn btn-custom-primary w-100" type="submit">{{ translate('verify') }}</button>
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

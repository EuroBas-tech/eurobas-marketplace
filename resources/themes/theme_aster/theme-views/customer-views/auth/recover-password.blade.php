@extends('theme-views.layouts.app')

@section('title', translate('Forgot_Password').' | '.$web_config['name']->value)

@section('content')
<style>
    .auth-page-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%);
        padding: 40px 0;
    }
    .auth-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 40px rgba(59,130,246,0.12);
        overflow: hidden;
        max-width: 480px;
        width: 100%;
        margin: 0 auto;
    }
    .auth-card-header {
        background: linear-gradient(135deg, #0f407d 0%, #1a6fd4 100%);
        padding: 36px 40px 32px;
        text-align: center;
    }
    .auth-card-header img { height: 48px; }
    .auth-card-body { padding: 36px 40px 40px; }
    .auth-card-body h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f407d;
        margin-bottom: 8px;
        text-align: center;
    }
    .auth-card-body .subtitle {
        color: #6b7280;
        text-align: center;
        font-size: 0.95rem;
        margin-bottom: 28px;
    }
    .auth-card-body .form-control {
        border-radius: 10px;
        border: 1.5px solid #e0e7ef;
        padding: 12px 16px;
        font-size: 16px;
        transition: border-color 0.2s;
    }
    .auth-card-body .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.10);
    }
    .auth-card-body label {
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
    }
    .btn-auth-primary {
        background: linear-gradient(135deg, #0f407d, #1a6fd4);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 13px;
        font-size: 16px;
        font-weight: 600;
        width: 100%;
        transition: opacity 0.2s;
    }
    .btn-auth-primary:hover { opacity: 0.92; color: #fff; }
    .btn-auth-back {
        color: #3b82f6;
        background: transparent;
        border: 1.5px solid #3b82f6;
        border-radius: 10px;
        padding: 12px;
        font-size: 15px;
        width: 100%;
        transition: all 0.2s;
    }
    .btn-auth-back:hover { background: #f0f4ff; }
    @media (max-width: 575px) {
        .auth-card-header { padding: 28px 20px 24px; }
        .auth-card-body { padding: 28px 20px 32px; }
    }
</style>

<div class="auth-page-wrapper">
    <div class="container">
        <div class="auth-card">
            <div class="auth-card-header">
                <img src="{{cloudfront('company')}}/{{\App\Model\BusinessSetting::where(['type' => 'company_mobile_logo'])->pluck('value')[0]}}" alt="{{ $web_config['name']->value }}" style="height:48px;" onerror="this.style.display='none'">
            </div>
            <div class="auth-card-body">
                <div class="text-center mb-4">
                    <div style="width:64px;height:64px;background:#e8f0fe;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                        <i class="bi bi-lock" style="font-size:28px;color:#3b82f6;"></i>
                    </div>
                    <h2>{{ translate('Forget_Password') }}</h2>
                    <p class="subtitle">
                        @if($verification_by == 'email')
                            {{ translate('please_enter_your_email_to_send_a_verification_code_for_forget_password') }}
                        @else
                            {{ translate('please_enter_your_phone_to_send_a_verification_code_for_forget_password') }}
                        @endif
                    </p>
                </div>

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

                    <div class="d-flex flex-column gap-3 mt-4">
                        <button class="btn-auth-primary" type="submit">{{ translate('verify') }}</button>
                        <button class="btn-auth-back" onclick="location.href='{{ route('home') }}'" type="button">
                            <i class="bi bi-arrow-left me-1"></i> {{ translate('back_again') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{\App\CPU\translate('Password Reset')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, table, td, a {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table, td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            height: auto;
            line-height: 100%;
            text-decoration: none;
            border: 0;
            outline: none;
        }

        a[x-apple-data-detectors] {
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            color: inherit !important;
            text-decoration: none !important;
        }

        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }

        table {
            border-collapse: collapse !important;
        }

        /* Main styles */
        body {
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333333;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: #0F407D;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.05"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.05"/><circle cx="50" cy="10" r="1" fill="%23ffffff" opacity="0.03"/><circle cx="10" cy="90" r="1" fill="%23ffffff" opacity="0.04"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .logo {
            position: relative;
            z-index: 2;
        }

        .logo-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-text {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .content {
            padding: 50px 40px;
        }

        .title {
            font-size: 24px;
            font-weight: 600;
            color: #1a1a2e;
            margin: 0 0 16px 0;
            text-align: center;
        }

        .subtitle {
            font-size: 16px;
            color: #6b7280;
            margin: 0 0 32px 0;
            text-align: center;
            line-height: 1.5;
        }

        .message {
            background: #f8fafc;
            border-left: 4px solid #667eea;
            padding: 24px;
            margin: 32px 0;
            border-radius: 8px;
            font-size: 15px;
            color: #4b5563;
            line-height: 1.6;
        }

        .button-container {
            text-align: center;
            margin: 40px 0;
        }

        .reset-button {
            display: inline-block;
            background: #0F407D;
            color: #ffffff !important;
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .reset-button:hover {
            transform: translateY(-2px);
        }

        .security-info {
            background: #fef3cd;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 20px;
            margin: 32px 0;
        }

        .security-title {
            font-weight: 600;
            color: #92400e;
            margin: 0 0 8px 0;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .security-text {
            font-size: 14px;
            color: #a16207;
            margin: 0;
            line-height: 1.5;
        }

        .footer {
            background: #f9fafb;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .footer-text {
            font-size: 14px;
            color: #6b7280;
            margin: 0 0 16px 0;
        }

        .company-info {
            font-size: 13px;
            color: #9ca3af;
            margin: 0;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
            margin: 24px 0;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 20px;
                border-radius: 12px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .content {
                padding: 30px 20px;
            }
            
            .footer {
                padding: 20px;
            }
            
            .logo-text {
                font-size: 24px;
            }
            
            .title {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <h1 class="logo-text">Eurobas.com</h1>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <h2 class="title">Reset Your Password</h2>
            <p class="subtitle">We received a request to reset your password. Click the button below to create a new one.</p>

            <div class="message">
                <p>Hello,</p>
                <p>You're receiving this email because we received a password reset request for your account. If you didn't make this request, you can safely ignore this email.</p>
            </div>

            <div class="button-container">
                <a href="{{$url}}" class="reset-button">
                    Reset Password
                </a>
            </div>

            <div class="divider"></div>

            <div class="security-info">
                <div class="security-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 8px;">
                        <path d="M12 1L3 5V11C3 16.55 6.84 21.74 12 23C17.16 21.74 21 16.55 21 11V5L12 1ZM12 7C13.1 7 14 7.9 14 9C14 10.1 13.1 11 12 11C10.9 11 10 10.1 10 9C10 7.9 10.9 7 12 7ZM12 17C10.33 17 8.86 16.28 7.84 15.12C7.98 13.81 10.66 13.15 12 13.15C13.34 13.15 16.02 13.81 16.16 15.12C15.14 16.28 13.67 17 12 17Z"/>
                    </svg>
                    Security Notice
                </div>
                <p class="security-text">
                    This password reset link will expire in 60 minutes for your security. If you didn't request this reset, please contact our support team immediately.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">    
            <p class="company-info">
                © {{ date('Y') }} Eurobas.com All rights reserved.<br>
                This is an automated message, please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html>
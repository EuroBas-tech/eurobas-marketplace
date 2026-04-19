<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{\App\CPU\translate('Password Reset')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        .preheader { display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0; }
        body, table, td, a { -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; }
        body { width: 100% !important; height: 100% !important; margin: 0; padding: 0; background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        table { border-collapse: collapse !important; }
        .main-card { background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e0e0e0; }
        .reset-button { display: block; background-color: #0F407D; color: #ffffff !important; padding: 18px 20px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 18px; text-align: center; margin: 25px 0; }
    </style>
</head>
<body>
    <div class="preheader">
        {{\App\CPU\translate('Reset your password')}}
        &nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
    </div>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" style="padding: 40px 10px;">
                <table width="550" class="main-card" cellpadding="0" cellspacing="0">
                    
                    <tr>
                        <td style="background:#0F407D; padding:25px; text-align:center;">
                            <h1 style="margin:0; font-size: 26px; font-weight: bold; color:white; letter-spacing: 1px;">
                                EuroBas.com
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:40px 40px; text-align:left; direction: ltr;">
                            
                            <h2 style="color:#000000; font-size:24px; font-weight: 800; margin:0 0 20px 0;">
                                {{\App\CPU\translate('Password Reset')}}
                            </h2>
                            
                            <p style="color:#000000; font-size:16px; line-height:1.5; margin-bottom: 25px;">
                                {{\App\CPU\translate('Click the button below to set a new password for your account.')}}
                            </p>

                            <a href="{{$url}}" class="reset-button">
                                {{\App\CPU\translate('Reset Password')}}
                            </a>

                            <p style="color:#000000; font-size:15px; margin: 30px 0 10px 0; line-height: 1.6;">
                                {{\App\CPU\translate('This link is securely generated for your account.')}}
                            </p>
                            
                            <p style="color:#000000; font-size:15px; margin: 0 0 30px 0; line-height: 1.6;">
                                {{\App\CPU\translate('If you didn’t request a password reset, please ignore this email.')}}
                            </p>

                            <div style="border-top: 2px solid #f0f0f0; padding-top: 20px; margin-top: 20px;">
                                <p style="color:#000000; font-size:16px; font-weight: bold; margin: 0;">
                                    {{\App\CPU\translate('This link will expire in 60 minutes.')}}
                                </p>
                            </div>

                        </td>
                    </tr>

                    <tr>
                        <td style="background:#fcfcfc; text-align:center; padding:20px; font-size:12px; color:#666666; border-top: 1px solid #eeeeee;">
                            © {{ date('Y') }} EuroBas.com. {{\App\CPU\translate('All rights reserved')}}
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>

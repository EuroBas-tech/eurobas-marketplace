<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{\App\CPU\translate('Password Reset')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        /* منع ازدحام العنوان في Gmail */
        .preheader { display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0; }
        
        body, table, td, a { -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; }
        body { width: 100% !important; height: 100% !important; margin: 0; padding: 0; background-color: #f4f7f6; font-family: Arial, sans-serif; }
        table { border-collapse: collapse !important; }
        .main-card { background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eeeeee; }
    </style>
</head>
<body>
    <div class="preheader">
        {{\App\CPU\translate('Reset your password')}}
        &nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
    </div>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" style="padding: 40px 10px;">
                <table width="480" class="main-card" cellpadding="0" cellspacing="0">
                    
                    <tr>
                        <td style="background:#0F407D; padding:35px; text-align:center; color:white;">
                            <h1 style="margin:0; font-size: 24px; font-weight: bold; letter-spacing: 1px;">
                                Eurobas.com
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:45px 35px; text-align:center;">
                            <h2 style="color:#1a1a2e; font-size:22px; margin:0 0 15px 0;">
                                {{\App\CPU\translate('Password Reset')}}
                            </h2>
                            
                            <p style="color:#6b7280; font-size:16px; line-height:1.6; margin-bottom: 35px;">
                                {{\App\CPU\translate('Click the button below to set a new password for your account.')}}
                            </p>

                            <div style="margin: 30px 0;">
                                <a href="{{$url}}" style="
                                    display: inline-block;
                                    background-color: #0F407D;
                                    color: #ffffff;
                                    padding: 18px 35px;
                                    text-decoration: none;
                                    border-radius: 10px;
                                    font-weight: bold;
                                    font-size: 16px;
                                ">
                                    {{\App\CPU\translate('Reset Password')}}
                                </a>
                            </div>

                            <div style="margin-top: 40px; padding-top: 25px; border-top: 1px solid #f3f4f6;">
                                <p style="color:#9ca3af; font-size:13px; margin: 5px 0;">
                                    {{\App\CPU\translate('This link will expire in 60 minutes.')}}
                                </p>
                                <p style="color:#d1d5db; font-size:12px; margin: 5px 0;">
                                    {{\App\CPU\translate('If you did not request this, please ignore this email.')}}
                                </p>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#f9fafb; text-align:center; padding:25px; font-size:12px; color:#9ca3af; border-top: 1px solid #eeeeee;">
                            © {{ date('Y') }} EuroBas.com. {{\App\CPU\translate('All rights reserved')}}
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>

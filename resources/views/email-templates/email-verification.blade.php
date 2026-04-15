<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{\App\CPU\translate('Email Verification')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">
        /* منع ظهور نصوص غريبة في المعاينة */
        .preheader { display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0; }
        
        @media screen {
            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
            }
        }

        body, table, td, a { -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; }
        table, td { mso-table-rspace: 0pt; mso-table-lspace: 0pt; }
        body { width: 100% !important; height: 100% !important; margin: 0; padding: 0; background-color: #f4f7f6; font-family: 'Source Sans Pro', Arial, sans-serif; }
        table { border-collapse: collapse !important; }
    </style>
</head>

<body>
    <div class="preheader">
        {{\App\CPU\translate('Your verification code is')}} {{$token}}
    </div>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" style="padding: 40px 10px;">
                <table width="450" style="background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.08);">
                    
                    <tr>
                        <td style="background:#1a73e8; padding:35px 20px; text-align:center; color:white;">
                            <h2 style="margin:0; font-size: 26px; font-weight: 700; letter-spacing: 0.5px;">
                                {{\App\CPU\translate('Email Verification')}}
                            </h2>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:40px 30px; text-align:center;">
                            <p style="color:#444; font-size:18px; margin: 0 0 25px 0; font-weight: 400;">
                                {{\App\CPU\translate('Verify your email')}}
                            </p>

                            <div style="
                                margin:10px 0;
                                font-size:40px;
                                font-weight:bold;
                                letter-spacing:12px;
                                color:#1a73e8;
                                background:#f8fbff;
                                padding:25px;
                                border-radius:12px;
                                display:inline-block;
                                border: 2px solid #eef4fe;
                            ">
                                {{$token}}
                            </div>

                            <p style="color:#777; font-size:15px; margin-top: 30px;">
                                {{\App\CPU\translate('Token')}} : <strong>{{$token}}</strong>
                            </p>

                            <p style="color:#999; font-size:13px; margin-top:25px; line-height: 1.6; padding: 0 20px;">
                                {{\App\CPU\translate('If you did not request this code, you can safely ignore this email.')}}
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#fafafa; text-align:center; padding:25px; font-size:12px; color:#aaaaaa; border-top: 1px solid #eeeeee;">
                            <p style="margin:0 0 5px 0;">© {{ date('Y') }} {{\App\CPU\translate('All rights reserved')}}</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>

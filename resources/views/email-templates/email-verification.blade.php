<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{\App\CPU\translate('Email Verification')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">
        /* تحسين نص المعاينة ومنع الازدحام في العنوان */
        .preheader { display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0; }
        
        body, table, td, a { -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; }
        table, td { mso-table-rspace: 0pt; mso-table-lspace: 0pt; }
        body { width: 100% !important; height: 100% !important; margin: 0; padding: 0; background-color: #f4f7f6; font-family: Arial, sans-serif; }
        table { border-collapse: collapse !important; }
    </style>
</head>

<body>
    <div class="preheader">
        {{\App\CPU\translate('Your code')}}: {{$token}}
        &nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
        &nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
    </div>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" style="padding: 40px 10px;">
                <table width="450" style="background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.08); border: 1px solid #eeeeee;">
                    
                    <tr>
                        <td style="background:#1a73e8; padding:35px 20px; text-align:center; color:white;">
                            <h2 style="margin:0; font-size: 24px; font-weight: bold;">
                                {{\App\CPU\translate('Email Verification')}}
                            </h2>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:40px 30px; text-align:center;">
                            <p style="color:#555; font-size:17px; margin-bottom: 25px;">
                                {{\App\CPU\translate('Verify your email')}}
                            </p>

                            <div style="
                                margin:10px 0;
                                font-size:38px;
                                font-weight:bold;
                                letter-spacing:10px;
                                color:#1a73e8;
                                background:#f0f7ff;
                                padding:20px;
                                border-radius:10px;
                                display:inline-block;
                                border: 1px solid #d0e3ff;
                            ">
                                {{$token}}
                            </div>

                            <p style="color:#999; font-size:13px; margin-top:30px; line-height: 1.5;">
                                {{\App\CPU\translate('If you did not request this code, you can safely ignore this email.')}}
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#fafafa; text-align:center; padding:20px; font-size:12px; color:#aaaaaa; border-top: 1px solid #eeeeee;">
                            © {{ date('Y') }} {{\App\CPU\translate('All rights reserved')}}
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>

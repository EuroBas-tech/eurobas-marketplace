<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{\App\CPU\translate('Email Verification')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">
        @media screen {
            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 700;
                src: url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
            }
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
            border: 0;
            outline: none;
        }

        body {
            width: 100% !important;
            height: 100% !important;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            font-family: 'Source Sans Pro', Arial, sans-serif;
        }

        table {
            border-collapse: collapse !important;
        }
    </style>
</head>

<body>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center">
            <table width="500" style="background:#ffffff; margin:50px auto; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.05); border: 1px solid #eeeeee;">
                
                <tr>
                    <td style="background:#1a73e8; padding:25px; text-align:center; color:white;">
                        <h2 style="margin:0; font-size: 24px;">
                            {{\App\CPU\translate('Email Verification')}}
                        </h2>
                    </td>
                </tr>

                <tr>
                    <td style="padding:40px 30px; text-align:center;">
                        <p style="color:#555; font-size:18px; margin-bottom: 20px;">
                            {{\App\CPU\translate('Verify your email')}}
                        </p>

                        <div style="
                            margin:20px 0;
                            font-size:36px;
                            font-weight:bold;
                            letter-spacing:8px;
                            color:#ff6f00;
                            background:#f1f5ff;
                            padding:20px;
                            border-radius:12px;
                            display:inline-block;
                            border: 1px dashed #1a73e8;
                        ">
                            {{$token}}
                        </div>

                        <p style="color:#777; font-size:14px; margin-top: 25px;">
                            {{\App\CPU\translate('Token')}} : <strong>{{$token}}</strong>
                        </p>

                        <p style="color:#aaa; font-size:12px; margin-top:20px; line-height: 1.5;">
                            إذا لم تقم بطلب هذا الرمز، يمكنك تجاهل هذه الرسالة بأمان.
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="background:#f8f8f8; text-align:center; padding:20px; font-size:12px; color:#999; border-top: 1px solid #eeeeee;">
                        © {{ date('Y') }} {{\App\CPU\translate('All rights reserved')}}
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>

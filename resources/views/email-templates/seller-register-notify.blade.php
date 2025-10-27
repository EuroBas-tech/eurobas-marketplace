<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{\App\CPU\translate('seller_register_notify')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">
        /**
         * Google webfonts. Recommended to include the .woff version for cross-client compatibility.
         */
        @media screen {
            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 700;
                src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
            }
        }

        /**
         * Avoid browser level font resizing.
         * 1. Windows Mobile
         * 2. iOS / OSX
         */
        body,
        table,
        td,
        a {
            -ms-text-size-adjust: 100%; /* 1 */
            -webkit-text-size-adjust: 100%; /* 2 */
        }

        /**
         * Remove extra space added to tables and cells in Outlook.
         */
        table,
        td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
        }

        /**
         * Better fluid images in Internet Explorer.
         */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /**
         * Remove blue links for iOS devices.
         */
        a[x-apple-data-detectors] {
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            color: inherit !important;
            text-decoration: none !important;
        }

        /**
         * Fix centering issues in Android 4.4.
         */
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }

        body {
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;

            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        /**
         * Collapse table borders to avoid space between cells.
         */
        table {
            border-collapse: collapse !important;
        }

        a {
            color: #1a82e2;
        }

        img {
            height: auto;
            line-height: 100%;
            text-decoration: none;
            border: 0;
            outline: none;
        }



        .card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 0 auto;
            max-width: 600px;
            padding: 20px;
            text-align: center;
        }
        .card-header {
            background-color: #007bff;
            border-radius: 8px 8px 0 0;
            color: #ffffff;
            padding: 10px;
            font-size: 24px;
        }
        .card-body {

            margin: -14px 0;
    background-color: #f3f3f3;
    padding: 38px;

    border-radius:  0px 0px 8px 8px;
        }
        .btn {
            background-color: #3cd400;
            border: none;
            border-radius: 4px;
            color: #fff!important;
            display: inline-block;
            font-size: 16px;
            padding: 10px 20px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #2d9e00;
            color: #fff!important;
        }

    </style>

  <?php
    use App\Model\BusinessSetting;
    $company_phone =BusinessSetting::where('type', 'company_phone')->first()->value;
    $company_email =BusinessSetting::where('type', 'company_email')->first()->value;
    $company_name =BusinessSetting::where('type', 'company_name')->first()->value;
    $company_web_logo =BusinessSetting::where('type', 'company_web_logo')->first()->value;
    $company_mobile_logo =BusinessSetting::where('type', 'company_mobile_logo')->first()->value;
?>

</head>

<body>
    <!-- end preheader -->
    <div class="card">
        <div class="card-header">
            {{ sellerTranslate('thank_you_for_registering_with_EuroBas.com') }}
        </div>
        <div class="card-body">
            <span style="font-size: 17px; line-height: 1.5; color: #333333;font-weight: 500;">

              {{\App\CPU\sellerTranslate('dear_seller')}}

              <br/><br/>

              {{\App\CPU\sellerTranslate('thank_you_for_registering_as_a_seller_on_eurobas.de_we_appreciate_your_interest_in_joining_our_platform')}}.

              <br/><br/>

              {{\App\CPU\sellerTranslate('your_application_is_currently_under_review_and_we_will_notify_you_of_our_decision_within_the_next_business_days')}}.

              <br/><br/>

              {{\App\CPU\sellerTranslate('should_you_have_any_questions_or_need_further_assistance_feel_free_to_reach_out_to_us')}}.

              <br/><br/>

              {{\App\CPU\sellerTranslate('best_regards')}}.

              <br/><br/>

              {{\App\CPU\sellerTranslate('the_EuroBas_team')}}.

              <br/><br/>
              
                <a class="btn" href="eurobas.de">
                    {{ sellerTranslate('visit_our_website') }}
                </a>
                
                <br/><br/>

              {{$company_email}}

            </span>
        </div>
    </div>
    </body>
</html>



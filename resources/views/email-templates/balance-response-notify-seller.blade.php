<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>{{\App\CPU\sellerTranslate('balance_notify_seller')}}</title>

    <style>
        body {
            background-color: #FFFFFF;
            padding: 0;
            margin: 0;
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



<body style="background-color: #FFFFFF; padding: 0; margin: 0;">

<table border="0" cellpadding="0" cellspacing="10" height="100%" bgcolor="#FFFFFF" width="100%"
       style="max-width: 650px;" id="bodyTable">

    <tr>

        <td align="center" valign="top">

            <table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailContainer"
                   style="font-family:Arial; color: #333333;">

                <!-- Logo -->
                @php($logo=\App\Model\BusinessSetting::where(['type'=>'company_web_logo'])->first()->value)
                <tr>
                    <td align="left" valign="top" colspan="2"
                        style="border-bottom: 1px solid #CCCCCC; padding-bottom: 10px;">
                        <img alt="" border="0" src="{{url('/').'/storage/app/public/company/'.'dark-logo.png'}}" title=""
                             class="sitelogo" width="60%" style="max-width:180px;text-align: end;"/>
                    </td>
                </tr>

                <!-- Title -->

                <tr>
                    <td align="left" valign="top" colspan="2"
                        style="border-bottom: 1px solid #CCCCCC; padding: 20px 0 10px 0;">
                        <span style="font-size: 18px; font-weight: normal;">{{\App\CPU\sellerTranslate('notification_mail_for_balance_seller_response')}}</span>
                    </td>
                </tr>

                <!-- Messages -->

                <tr>

                    <td align="left" valign="top" colspan="2" style="padding-top: 10px;">

                        <span style="font-size: 12px; line-height: 1.5; color: #333333;">

                            {{\App\CPU\sellerTranslate('we_have_sent_you_this_email_to_notify_that_you_response_a_balance_to_your_account')}}.

                            <br/><br/>

                            {{\App\CPU\sellerTranslate('additional_seller_reponse_mail_message')}}.

                            <br/><br/>

                            {{\App\CPU\sellerTranslate('From')}} {{$web_config['name']->value}}
                            
                            <br/><br/>

                            {{\App\CPU\sellerTranslate('best_regards')}},
                
                            <br/><br/>
                
                            {{\App\CPU\sellerTranslate('the_EuroBas_team')}}.
                
                            <br/><br/>
                              
                            <a class="btn" href="eurobas.de">
                                {{ sellerTranslate('visit_our_website') }}
                            </a>
                                
                            <br/><br/>
                
                            {{$company_email}}

                        </span>

                    </td>

                </tr>

            </table>

        </td>

    </tr>

</table>

</body>

</html>

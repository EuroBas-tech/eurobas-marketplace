@php

    if(!function_exists('testTranslate')) {
        function testTranslate($key, $id) {
            
            $order = App\Model\Order::with('seller')->find($id);
    
            \Illuminate\Support\Facades\Log::debug('locale : '.$order->seller->prefered_language);
            
            \Illuminate\Support\Facades\App::setLocale($order->seller->prefered_language);
        
            try {
                $lang_array = include(base_path('resources/lang/' . $order->seller->prefered_language . '/messages.php'));
                $processed_key = ucfirst(str_replace('_', ' ', \App\CPU\Helpers::remove_invalid_charcaters($key)));
                $key = \App\CPU\Helpers::remove_invalid_charcaters($key);
                if (!array_key_exists($key, $lang_array)) {
                    $lang_array[$key] = $processed_key;
                    $str = "<"."?"."php"." "." return " . var_export($lang_array, true) . ";";
                    file_put_contents(base_path('resources/lang/' . $order->seller->prefered_language . '/messages.php'), $str);
                    $result = $processed_key;
                } else {
                    $result = __('messages.' . $key);
                }
            } catch (\Exception $exception) {
                $result = __('messages.' . $key);
            }
        
            return $result;
            
        }
    }

@endphp


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>{{testTranslate('New order received', $id)}}</title>

    <style>

        body {
            background-color: #FFFFFF;
            padding: 0;
            margin: 0;
        }
    </style>

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
                        <img alt="" border="0" src="{{url('/').'/storage/app/public/company/dark-logo.png'}}" title=""
                             class="sitelogo" width="60%" style="max-width:250px;"/>
                    </td>

                </tr>

                <!-- Title -->

                <tr>

                    <td align="left" valign="top" colspan="2"
                        style="border-bottom: 1px solid #CCCCCC; padding: 20px 0 10px 0;">
                        <span style="font-size: 18px; font-weight: normal;">{{testTranslate('Notification mail for new order received', $id)}}</span>
                    </td>

                </tr>

                <!-- Messages -->

                <tr>

                    <td align="left" valign="top" colspan="2" style="padding-top: 10px;">

                        <span style="font-size: 12px; line-height: 1.5; color: #333333;">

                            {{testTranslate('We have sent you this email to notify that you have a new order. You will be able to see your orders after login to your panel', $id)}}.

                            <br/><br/>

                            {{testTranslate('New order ID for you', $id)}} :

                            <a href="javascript:"> <h3 style="font-weight: 1000">{{$id}}</h3> </a>

                            <br/><br/>

                            {{testTranslate('if_you_need_help', $id)}}, {{testTranslate('or_you_have_any_other_questions', $id)}}, {{testTranslate('feel_free_to_email_us', $id)}}.

                            <br/><br/>

                            {{testTranslate('From', $id)}} {{$web_config['name']->value}}

                        </span>

                    </td>

                </tr>

            </table>

        </td>

    </tr>

</table>

</body>

</html>

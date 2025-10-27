<?php

use App\CPU\Helpers;
use App\Model\Order;
use App\Model\Seller;
use Illuminate\Support\Facades\App;

if(!function_exists('translate')) {
    function  translate($key)
    {
        $local = Helpers::default_lang();
        App::setLocale($local);

        try {
            $lang_array = include(base_path('resources/lang/' . $local . '/messages.php'));
            $processed_key = ucfirst(str_replace('_', ' ', Helpers::remove_invalid_charcaters($key)));
            $key = Helpers::remove_invalid_charcaters($key);
            if (!array_key_exists($key, $lang_array)) {
                $lang_array[$key] = $processed_key;
                $str = "<?php return " . var_export($lang_array, true) . ";";
                file_put_contents(base_path('resources/lang/' . $local . '/messages.php'), $str);
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

if(!function_exists('sellerTranslate')) {
    function  sellerTranslate($key)
    {

        $local = session('seller_prefered_language');

        App::setLocale($local);
        
        try {
            $lang_array = include(base_path('resources/lang/' . $local . '/messages.php'));
            $processed_key = ucfirst(str_replace('_', ' ', Helpers::remove_invalid_charcaters($key)));
            $key = Helpers::remove_invalid_charcaters($key);
            if (!array_key_exists($key, $lang_array)) {
                $lang_array[$key] = $processed_key;
                $str = "<?php return " . var_export($lang_array, true) . ";";
                file_put_contents(base_path('resources/lang/' . $local . '/messages.php'), $str);
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

if(!function_exists('sellerTranslateBySellerId')) {
    function  sellerTranslateBySellerId($key, $seller_id)
    {
        $seller = Seller::find($seller_id);

        $local = $seller ? $seller->prefered_language : 'en';

        App::setLocale($local);

        try {
            $lang_array = include(base_path('resources/lang/' . $local . '/messages.php'));
            $processed_key = ucfirst(str_replace('_', ' ', Helpers::remove_invalid_charcaters($key)));
            $key = Helpers::remove_invalid_charcaters($key);
            if (!array_key_exists($key, $lang_array)) {
                $lang_array[$key] = $processed_key;
                $str = "<?php return " . var_export($lang_array, true) . ";";
                file_put_contents(base_path('resources/lang/' . $local . '/messages.php'), $str);
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


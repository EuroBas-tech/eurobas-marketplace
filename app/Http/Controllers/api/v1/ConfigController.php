<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\BusinessSetting;
use App\Model\Currency;
use App\Model\HelpTopic;
use App\Model\SocialMedia;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function configuration()
    {
        $currency = Currency::where(['status' => 1])->get();

        $social_login = [];
        $social_login_settings = Helpers::get_business_settings('social_login');
        if (is_array($social_login_settings)) {
            foreach ($social_login_settings as $social) {
                $social_login[] = [
                    'login_medium' => $social['login_medium'],
                    'status' => (bool)($social['status'] ?? false),
                ];
            }
        }

        $languages = Helpers::get_business_settings('language');
        $lang_array = [];
        if (is_array($languages)) {
            foreach ($languages as $language) {
                $lang_array[] = [
                    'code' => $language['code'] ?? '',
                    'name' => Helpers::get_language_name($language['code'] ?? ''),
                    'status' => $language['status'] ?? 0,
                    'default' => $language['default'] ?? false,
                    'direction' => $language['direction'] ?? 'ltr',
                ];
            }
        }

        $brands = Brand::active()->take(15)->get();

        $company_logo = $this->getSettingImage('company_web_logo', 'company');
        $company_cover_image = $this->getSettingImage('shop_banner', 'logo');
        $company_fav_icon = $this->getSettingImage('company_fav_icon', 'company');
        $footer_logo = $this->getSettingImage('company_footer_logo', 'company');

        $android = $this->getSettingJsonLink('download_app_google_stroe');
        $ios = $this->getSettingJsonLink('download_app_apple_stroe');

        return response()->json([
            'brands' => $brands,
            'system_default_currency' => (int)(Helpers::get_business_settings('system_default_currency') ?? 0),
            'digital_payment' => (bool)(Helpers::get_business_settings('digital_payment')['status'] ?? false),
            'company_address' => Helpers::get_business_settings('shop_address') ?? '',
            'company_phone' => Helpers::get_business_settings('company_phone') ?? '',
            'company_email' => Helpers::get_business_settings('company_email') ?? '',
            'company_logo' => $company_logo,
            'company_cover_image' => $company_cover_image,
            'company_fav_icon' => $company_fav_icon,
            'footer_logo' => $footer_logo,
            'ios' => $ios,
            'android' => $android,
            'social_media' => SocialMedia::where('active_status', 1)->get(),
            'copyright_text' => $this->getSettingValue('company_copyright_text'),
            'base_urls' => [
                'brand_image_url' => cloudfront('brand'),
                'customer_image_url' => asset('storage/app/public/profile'),
                'banner_image_url' => cloudfront('banner'),
                'category_image_url' => cloudfront('category'),
                'notification_image_url' => asset('storage/app/public/notification'),
            ],
            'about_us' => Helpers::get_business_settings('about_us') ?? '',
            'privacy_policy' => Helpers::get_business_settings('privacy_policy') ?? '',
            'faq' => HelpTopic::all(),
            'terms_&_conditions' => Helpers::get_business_settings('terms_condition') ?? '',
            'currency_list' => $currency,
            'currency_symbol_position' => Helpers::get_business_settings('currency_symbol_position') ?? 'right',
            'business_mode' => Helpers::get_business_settings('business_mode'),
            'maintenance_mode' => (bool)(Helpers::get_business_settings('maintenance_mode') ?? false),
            'language' => $lang_array,
            'email_verification' => (bool)(Helpers::get_business_settings('email_verification') ?? false),
            'phone_verification' => (bool)(Helpers::get_business_settings('phone_verification') ?? false),
            'country_code' => Helpers::get_business_settings('country_code') ?? '',
            'social_login' => $social_login,
            'currency_model' => Helpers::get_business_settings('currency_model'),
            'forgot_password_verification' => Helpers::get_business_settings('forgot_password_verification'),
            'announcement' => Helpers::get_business_settings('announcement'),
            'software_version' => env('SOFTWARE_VERSION'),
            'wallet_status' => Helpers::get_business_settings('wallet_status'),
            'default_location' => Helpers::get_business_settings('default_location'),
        ]);
    }

    private function getSettingValue(string $type): string
    {
        $setting = BusinessSetting::where('type', $type)->first();
        return $setting->value ?? '';
    }

    private function getSettingImage(string $type, string $folder): string
    {
        $setting = BusinessSetting::where('type', $type)->first();
        if (!$setting || !$setting->value) {
            return '';
        }
        return cloudfront($folder) . '/' . $setting->value;
    }

    private function getSettingJsonLink(string $type): string
    {
        $setting = BusinessSetting::where('type', $type)->first();
        if (!$setting || !$setting->value) {
            return '';
        }
        $decoded = json_decode($setting->value);
        return $decoded->link ?? '';
    }
}

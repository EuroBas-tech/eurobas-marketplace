<?php

namespace App\Providers;

use App\User;
use App\Model\Tag;
use App\Model\Shop;
use App\CPU\Helpers;
use App\Model\Banner;
use App\Model\Product;
use App\Model\Setting;
use App\Model\Category;
use App\Model\Currency;
use App\CPU\CartManager;
use App\Model\FlashDeal;
use App\Model\SocialMedia;
use App\Traits\AddonHelper;
use App\Traits\ThemeHelper;
use App\Model\BusinessSetting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

ini_set('memory_limit','512M');
ini_set('upload_max_filesize','180M');
ini_set('post_max_size','200M');

class AppServiceProvider extends ServiceProvider
{
    use AddonHelper;
    use ThemeHelper;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Amirami\Localizator\ServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->setLocale(LaravelLocalization::getCurrentLocale());

        Paginator::useBootstrap();
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Config::set('addon_admin_routes', $this->get_addon_admin_routes());
        Config::set('get_payment_publish_status', $this->get_payment_publish_status());
        Config::set('get_theme_routes', $this->get_theme_routes());

        if (Schema::hasTable('business_settings')) {

            $web = Cache::remember('business_settings', 3600, function () {
                return BusinessSetting::select('type', 'value')->get();
            });

            $settings = Helpers::get_settings($web, 'colors');
            $data = json_decode($settings['value'] ?? '{}', true);

            $web_config = [
                'primary_color' => $data['primary'] ?? '',
                'secondary_color' => $data['secondary'] ?? '',
                'primary_color_light' => $data['primary_light'] ?? '',
                'name' => Helpers::get_settings($web, 'company_name'),
                'phone' => Helpers::get_settings($web, 'company_phone'),
                'web_logo' => Helpers::get_settings($web, 'company_web_logo'),
                'mob_logo' => Helpers::get_settings($web, 'company_mobile_logo'),
                'fav_icon' => Helpers::get_settings($web, 'company_fav_icon'),
                'email' => Helpers::get_settings($web, 'company_email'),
                'about' => Helpers::get_settings($web, 'about_us'),
                'footer_logo' => Helpers::get_settings($web, 'company_footer_logo'),
                'copyright_text' => Helpers::get_settings($web, 'company_copyright_text'),
                'decimal_point_settings' => !empty(\App\CPU\Helpers::get_business_settings('decimal_point_settings')) ? \App\CPU\Helpers::get_business_settings('decimal_point_settings') : 0,
                
                'wallet_status' => Helpers::get_business_settings('wallet_status'),
                'loyalty_point_status' => Helpers::get_business_settings('loyalty_point_status'),
                'guest_checkout_status' => Helpers::get_business_settings('guest_checkout'),
            ];

            if (!Request::is('admin') && !Request::is('admin/*') && !Request::is('seller/*')) {

                $recaptcha = Helpers::get_business_settings('recaptcha');
                $socials_login = Helpers::get_business_settings('social_login');
                $social_login_text = false;
                $apple_login = Helpers::get_business_settings('apple_login');
                
                if (is_array($socials_login)) {
                    foreach ($socials_login as $socialLoginService) {
                        if (isset($socialLoginService) && $socialLoginService['status'] == true) {
                            $social_login_text = true;
                        }
                    }
                }
                        
                if (isset($apple_login) && isset($apple_login[0]['status']) && $apple_login[0]['status'] == true) {
                    $social_login_text = true;
                }

                $social_media = Cache::remember('app_social_media', 86400, function () {
                    return SocialMedia::where('active_status', 1)->get();
                });

                $web_config += [
                    'cookie_setting' => Helpers::get_settings($web, 'cookie_setting'),
                    'announcement' => Helpers::get_business_settings('announcement'),
                    'currency_model' => Helpers::get_business_settings('currency_model'),
                    'currencies' => Cache::remember('currencies_static', 604800, function () {
                        return Currency::where('status', 1)->get();
                    }),
                    'main_categories' => Category::priority()->get(),
                    'business_mode' => Helpers::get_business_settings('business_mode'),
                    'social_media' => $social_media,
                    'ios' => Helpers::get_business_settings('download_app_apple_stroe'),
                    'android' => Helpers::get_business_settings('download_app_google_stroe'),
                    'refund_policy' => Helpers::get_business_settings('refund-policy'),
                    'return_policy' => Helpers::get_business_settings('return-policy'),
                    'cancellation_policy' => Helpers::get_business_settings('cancellation-policy'),
                    'brand_setting' => Helpers::get_business_settings('product_brand'),
                    'discount_product' => 0,
                    'recaptcha' => $recaptcha,
                    'socials_login' => $socials_login,
                    'apple_login' => $apple_login,
                    'social_login_text' => $social_login_text,
                ];
            }

            // Get language setting with caching
            $language = Cache::rememberForever('language', function () {
                return BusinessSetting::where('type', 'language')->first();
            });

            View::share(['web_config' => $web_config, 'language' => $language]);

            Schema::defaultStringLength(191);
        }

        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        if (!session()->has('country_shipping')) {
            session(['country_shipping' => 'All']);
        }
    }
}

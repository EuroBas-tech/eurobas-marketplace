<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\PaymentController;

/*
|--------------------------------------------------------------------------
| React API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['namespace' => 'api\v1', 'prefix' => 'v1', 'middleware' => ['api_lang']], function () {

    Route::group(['prefix' => 'auth', 'namespace' => 'auth'], function () {
        Route::post('register', 'PassportAuthController@register');
        Route::post('login', 'PassportAuthController@login');

        Route::post('check-phone', 'PhoneVerificationController@check_phone');
        Route::post('resend-otp-check-phone', 'PhoneVerificationController@resend_otp_check_phone');
        Route::post('verify-phone', 'PhoneVerificationController@verify_phone');

        Route::post('check-email', 'EmailVerificationController@check_email');
        Route::post('resend-otp-check-email', 'EmailVerificationController@resend_otp_check_email');
        Route::post('verify-email', 'EmailVerificationController@verify_email');

        Route::post('forgot-password', 'ForgotPassword@reset_password_request');
        Route::post('resend-otp-reset-password', 'ForgotPassword@resend_otp');
        Route::post('verify-otp', 'ForgotPassword@otp_verification_submit');
        Route::get('verify-email-token', 'ForgotPassword@verify_email_token');
        Route::put('reset-password', 'ForgotPassword@reset_password_submit');

        Route::any('social-login', 'SocialAuthController@social_login');
        Route::post('update-phone', 'SocialAuthController@update_phone');
    });

    Route::group(['prefix' => 'locale'], function() {
        Route::post('translations/{locale}', 'LocaleController@translations');
    });

    Route::group(['prefix' => 'config'], function () {
        Route::get('/', 'ConfigController@configuration');
    });

     Route::group(['prefix' => 'cart','middleware'=>'apiGuestCheck'], function () {
        Route::get('/', 'CartController@cart');
        Route::post('add', 'CartController@add_to_cart');
        Route::put('update', 'CartController@update_cart');
        Route::delete('remove', 'CartController@remove_from_cart');
        Route::delete('remove-all','CartController@remove_all_from_cart');

    });

    Route::get('faq', 'GeneralController@faq');
    Route::post('subscription', 'GeneralController@subscription');
    Route::get('social-media', 'GeneralController@social_media');

    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/', 'NotificationController@get_notifications');
    });

    Route::group(['prefix' => 'brands'], function () {
        Route::get('products/{brand_id}', 'BrandController@get_products');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'CategoryController@get_categories');
    });
    
    Route::group(['prefix' => 'paid-banners'], function () {
        Route::get('/', 'PaidBannerController@get_paid_banners');
    });

    Route::group(['middleware' => 'apiGuestCheck'], function () {

        Route::group(['prefix' => 'categories'], function () {
            Route::get('products/{category_id}', 'CategoryController@get_products');
            Route::get('popular-categories', 'CategoryController@popular_categories');
        });

        Route::group(['prefix' => 'brands'], function () {
            Route::get('products/{brand_id}', 'BrandController@get_products');
        });

        Route::group(['prefix' => 'customer'], function () {

            Route::get('get-restricted-country-list', 'CustomerController@get_restricted_country_list');
            Route::get('get-restricted-zip-list', 'CustomerController@get_restricted_zip_list');

            Route::group(['prefix' => 'address'], function () {
                Route::post('add', 'CustomerController@add_new_address');
                Route::put('update', 'CustomerController@update_address');
                Route::get('list', 'CustomerController@address_list');
            });

        });
    });

    Route::group(['prefix' => 'customer', 'middleware' => 'auth:api'], function () {

        Route::group(['prefix' => 'profile'], function() {
            Route::post('/', 'CustomerController@get_customer_profile');
            Route::post('update', 'CustomerController@update_profile');
            Route::post('ads', 'CustomerController@get_customer_ads');
            Route::post('paid-banners', 'CustomerController@get_customer_paid_banners');        
        });
        
        Route::get('info', 'CustomerController@info');
        Route::put('cm-firebase-token', 'CustomerController@update_cm_firebase_token');
        Route::get('account-delete','CustomerController@account_delete');

        Route::group(['prefix' => 'address'], function () {
            Route::get('get/{id}', 'CustomerController@get_address');
            Route::delete('delete', 'CustomerController@delete_address');
        });

        Route::group(['prefix' => 'support-ticket'], function () {
            Route::post('create', 'CustomerController@create_support_ticket');
            Route::get('get', 'CustomerController@get_support_tickets');
            Route::get('conv/{ticket_id}', 'CustomerController@get_support_ticket_conv');
            Route::post('reply/{ticket_id}', 'CustomerController@reply_support_ticket');
            Route::post('close', 'CustomerController@support_ticket_close');
        });

        Route::group(['prefix' => 'wish-list'], function () {
            Route::get('/', 'CustomerController@wish_list');
            Route::post('add', 'CustomerController@add_to_wishlist');
            Route::delete('remove', 'CustomerController@remove_from_wishlist');
        });

        // Chatting
        Route::group(['prefix' => 'chat'], function () {
            Route::get('list', 'ChatController@list');
            Route::get('get-messages/{id}', 'ChatController@get_message');
            Route::post('send-message', 'ChatController@send_message');
        });

    });

    Route::get('ads/show/{ad}', 'AdController@show')->name('show-ad');
    Route::get('ads/by-category/{id}', 'AdController@get_ads_by_category')->name('get-ads-by-category');
    Route::post('ads/filter', 'AdController@ads_filter')->name('filter-ads');
    
    Route::post('searched-ads', 'WebController@searched_ads')->name('searched-ads');

    Route::group(['prefix' => 'digital-payment','middleware'=>'apiGuestCheck'], function () {
        Route::get('/', [PaymentController::class, 'payment']);
    });

    Route::group(['prefix' => 'add-to-fund','middleware'=>'auth:api'], function () {
         
        Route::post('/', [PaymentController::class, 'customer_add_to_fund_request']);
    });

    Route::group(['prefix' => 'banners'], function () {
        Route::get('/', 'BannerController@get_banners');
    });

    Route::get('get-guest-id', 'GeneralController@get_guest_id');

    //map api
    Route::group(['prefix' => 'mapapi'], function () {
        Route::get('place-api-autocomplete', 'MapApiController@place_api_autocomplete');
        Route::get('distance-api', 'MapApiController@distance_api');
        Route::get('place-api-details', 'MapApiController@place_api_details');
        Route::get('geocode-api', 'MapApiController@geocode_api');
    });

    Route::post('contact-us', 'GeneralController@contact_store');
});

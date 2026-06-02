<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'api\v1', 'prefix' => 'v1', 'middleware' => ['api_lang']], function () {

    // ─── AUTH (public) ───────────────────────────────────────────────────
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

        Route::post('social-login', 'SocialAuthController@social_login');
        Route::post('update-phone', 'SocialAuthController@update_phone');

        // Authenticated token management
        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('refresh', 'PassportAuthController@refresh');
            Route::post('logout', 'PassportAuthController@logout');
        });
    });

    // ─── LOCALE (public) ─────────────────────────────────────────────────
    Route::group(['prefix' => 'locale'], function() {
        Route::match(['get', 'post'], 'translations/{locale}', 'LocaleController@translations');
        Route::get('translations/{locale}/version', 'LocaleController@version');
    });

    // ─── PUBLIC USER PROFILE ─────────────────────────────────────────────
    Route::get('users/{id}', 'CustomerController@show');

    // ─── CONFIG (public) ─────────────────────────────────────────────────
    Route::group(['prefix' => 'config'], function () {
        Route::get('/', 'ConfigController@configuration');
    });

    // ─── PUBLIC ENDPOINTS ────────────────────────────────────────────────
    Route::get('faq', 'GeneralController@faq');
    Route::post('subscription', 'GeneralController@subscription');
    Route::get('social-media', 'GeneralController@social_media');
    Route::get('get-guest-id', 'GeneralController@get_guest_id');
    Route::post('contact-us', 'GeneralController@contact_store');

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'CategoryController@get_categories');
    });

    Route::group(['prefix' => 'banners'], function () {
        Route::get('/', 'BannerController@get_banners');
    });

    Route::group(['prefix' => 'paid-banners'], function () {
        Route::get('/', 'PaidBannerController@get_paid_banners');
    });

    // ─── ADS (public) ────────────────────────────────────────────────────
    Route::get('ads/show/{ad}', 'AdController@show');
    Route::get('ads/show-by-slug/{slug}', 'AdController@show_by_slug');
    Route::get('ads/by-category/{id}', 'AdController@get_ads_by_category');
    Route::post('ads/filter', 'AdController@ads_filter');
    Route::post('ads/filter-count', 'AdController@filter_count');
    Route::get('ads/load-home-ads', 'AdController@load_home_ads');
    Route::post('searched-ads', 'WebController@searched_ads');

    // ─── BROWSE / DISCOVERY (public) ─────────────────────────────────────
    Route::get('home', 'AdController@home');
    Route::get('categories/{id}/fields', 'AdController@category_fields');
    Route::get('brands', 'BrandController@index');
    Route::get('brands/{id}', 'BrandController@show');
    Route::get('models/{id}/ads', 'BrandController@model_ads');

    // ─── PROMOTIONS CATALOGUE / STATIC PAGES (public) ────────────────────
    Route::get('subscription-packages', 'PromotionController@packages');
    Route::get('pages/{slug}', 'PageController@show');

    // ─── PUBLIC SELLER ADS ───────────────────────────────────────────────
    Route::get('users/{id}/ads', 'CustomerController@user_ads');
    // Milestone 3: public seller reviews
    Route::get('users/{id}/reviews', 'SellerReviewController@list');

    // ─── PAYMENT GATEWAY REDIRECT TARGET (public, stateless) ─────────────
    Route::get('payment/callback/{method}', 'PaymentController@callback');

    // ─── ADS (authenticated) ──────────────────────────────────────────────
    Route::group(['prefix' => 'ads', 'middleware' => 'auth:api'], function () {
        Route::get('create-options', 'AdController@create_options');
        Route::post('auction', 'AdController@store_auction');
        Route::delete('auction/{id}', 'AdController@delete_auction');
        Route::post('asking-price', 'AdController@store_asking_price');
        Route::delete('asking-price/{id}', 'AdController@delete_asking_price');
        Route::post('report', 'AdController@report');
        Route::post('/', 'AdController@store');
        Route::match(['put', 'post'], '{id}', 'AdController@update');
        Route::delete('{id}', 'AdController@destroy');
    });

    // ─── MUX VIDEO + PAYMENT (authenticated) ─────────────────────────────
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('mux/create-upload', 'MuxController@create_upload');
        Route::get('mux/video', 'MuxController@video');

        Route::post('payment/initiate', 'PaymentController@initiate');
        Route::get('payment/verify', 'PaymentController@verify');
    });

    // ─── MAP API (public) ────────────────────────────────────────────────
    Route::group(['prefix' => 'mapapi'], function () {
        Route::get('place-api-autocomplete', 'MapApiController@place_api_autocomplete');
        Route::get('distance-api', 'MapApiController@distance_api');
        Route::get('place-api-details', 'MapApiController@place_api_details');
        Route::get('geocode-api', 'MapApiController@geocode_api');
    });

    // ─── GUEST/AUTH MIXED ENDPOINTS ──────────────────────────────────────
    Route::group(['middleware' => 'apiGuestCheck'], function () {

        Route::group(['prefix' => 'categories'], function () {
            Route::get('popular-categories', 'CategoryController@popular_categories');
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

    // ─── AUTHENTICATED ENDPOINTS ─────────────────────────────────────────
    Route::group(['prefix' => 'customer', 'middleware' => 'auth:api'], function () {

        // Milestone 3: submit/update a seller review
        Route::post('seller-review', 'SellerReviewController@store');

        // Profile - support both GET and POST for mobile compatibility
        Route::group(['prefix' => 'profile'], function() {
            Route::match(['get', 'post'], '/', 'CustomerController@get_customer_profile');
            Route::match(['put', 'post'], 'update', 'CustomerController@update_profile');
            Route::match(['get', 'post'], 'ads', 'CustomerController@get_customer_ads');
            Route::match(['get', 'post'], 'paid-banners', 'CustomerController@get_customer_paid_banners');
        });

        Route::get('info', 'CustomerController@info');
        Route::put('cm-firebase-token', 'CustomerController@update_cm_firebase_token');
        Route::get('account-delete', 'CustomerController@account_delete');

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
            Route::delete('{ticket_id}', 'CustomerController@delete_support_ticket');
        });

        Route::group(['prefix' => 'wish-list'], function () {
            Route::get('/', 'CustomerController@wish_list');
            Route::post('add', 'CustomerController@add_to_wishlist');
            Route::delete('remove', 'CustomerController@remove_from_wishlist');
            Route::delete('clear', 'CustomerController@clear_wishlist');
        });

        Route::group(['prefix' => 'chat'], function () {
            Route::get('list', 'ChatController@list');
            Route::get('unread-count', 'ChatController@unread_count');
            Route::get('get-messages/{id}', 'ChatController@get_message');
            Route::post('send-message', 'ChatController@send_message');
            Route::post('mark-seen', 'ChatController@mark_seen');
            // Milestone 2: messaging enhancements
            Route::post('report', 'ChatController@report_user');
            Route::post('block', 'ChatController@block_user');
            Route::post('unblock', 'ChatController@unblock_user');
            Route::get('blocked-list', 'ChatController@blocked_list');
            Route::post('delete-message', 'ChatController@delete_message');
            Route::post('delete-conversation', 'ChatController@delete_conversation');
        });

        // ─── PROMOTIONS — MANAGE MY PAID BANNERS / SPONSORS (§4) ─────────
        Route::group(['prefix' => 'paid-banners'], function () {
            Route::get('/', 'PromotionController@my_paid_banners');
            Route::post('/', 'PromotionController@store_paid_banner');
            Route::delete('{id}', 'PromotionController@delete_paid_banner');
        });

        Route::group(['prefix' => 'sponsors'], function () {
            Route::get('/', 'PromotionController@my_sponsors');
            Route::post('/', 'PromotionController@store_sponsor');
            Route::delete('{id}', 'PromotionController@delete_sponsor');
        });
    });

    // ─── NOTIFICATIONS (authenticated) ───────────────────────────────────
    Route::group(['prefix' => 'notifications', 'middleware' => 'auth:api'], function () {
        Route::get('/', 'NotificationController@get_notifications');
    });
});

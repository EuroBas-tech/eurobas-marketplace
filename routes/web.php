<?php

ini_set('max_execution_time', 1000);

use App\Model\Ad;
use App\Model\Cart;
use App\CPU\Helpers;
use App\Models\User;
use App\Model\Category;
use App\Model\PaidBanner;
use App\Model\SponsoredAd;
use App\Model\Translation;
use App\Model\SponsorVideo;
use App\Model\BusinessSetting;
use App\Model\LanguageTranslation;
use Illuminate\Support\Facades\DB;
use App\Model\UserCategoryInterest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\MuxApiController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Payment_Methods\PaymentController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Payment_Methods\MultiplePaymentController;
use Firebase\JWT\JWT;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localize','localeSessionRedirect','localizationRedirect']
    ],
    function() {
        
        //for maintenance mode
        Route::get('maintenance-mode', 'Web\WebController@maintenance_mode')->name('maintenance-mode');

        Route::group(['namespace' => 'Web','middleware'=>['maintenance_mode','guestCheck']], function () {
            Route::get('/', 'HomeController@index')->name('home');

            // Add this route to your web.php file
            Route::get('/load-brands', [HomeController::class, 'loadBrands'])->name('load.brands');


            Route::get('/country-shipping/{code}', function ($code) {
                session(['country_shipping' => $code]);

                $user = Helpers::get_customer();

                Cart::where([
                    'customer_id'=> ($user == 'offline' ? session('guest_id') : auth('customer')->id()),
                    'is_guest' => ($user == 'offline' ? 1 : '0'),
                ])->delete();

                return redirect()->back();
            })->name('country-shipping');

            Route::get('quick-view', 'WebController@quick_view')->name('quick-view');
            Route::get('searched-ads', 'WebController@searched_ads')->name('searched-ads');

            Route::group(['middleware'=>['customer']], function () {
                Route::get('submit-review/{id}','UserProfileController@submit_review')->name('submit-review');
                Route::post('review', 'ReviewController@store')->name('review.store');
                Route::get('deliveryman-review/{id}','ReviewController@delivery_man_review')->name('deliveryman-review');
                Route::post('submit-deliveryman-review','ReviewController@delivery_man_submit')->name('submit-deliveryman-review');
            });

            Route::group(['prefix' => 'ads'], function () {
                Route::group(['middleware' => 'customer'], function () {
                    Route::get('adding-type', 'AdController@adding_type')->name('ads-adding-type');

                    Route::withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
                    ->match(['get', 'post'], 'add', 'AdController@add')
                    ->name('ads-add');

                    Route::post('store', 'AdController@store')->name('ads-store');
                    Route::get('edit/{id}', 'AdController@edit')->name('ads-edit');
                    Route::post('update', 'AdController@update')->name('ads-update');
                    Route::get('delete/{id}', 'AdController@delete')->name('ads-delete');
                    
                    Route::post('auction/store', 'AdController@store_auction')->name('ads-store-auction');
                    Route::post('auction/delete', 'AdController@delete_auction')->name('ads-delete-auction');
                    Route::post('asking-price/store', 'AdController@store_asking_price')->name('ads-store-asking-price');
                    Route::post('asking-price/delete', 'AdController@delete_asking_price')->name('ads-delete-asking-price');
                    
                });
                Route::get('show-by-country/{code}/{flag}', 'AdController@show_by_country')->name('show-by-country');
                
                Route::get('filter', 'AdController@filter')->name('show-ads-filter');
                Route::get('ads-filter-count', 'AdController@ads_filter_count')->name('ads-filter-count');
                Route::get('show/{slug}', 'AdController@show')->name('ads-show');
                
                Route::post('report-ad', 'AdController@report_ad')->name('report-ad');

                Route::get('show-by-category/{cat_id}', 'AdController@show_by_category')->name('show-by-category');

                // CSRF-free POST routes using controller@method syntax
                Route::withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
                ->post('ads-filter', 'AdController@ads_filter')->name('ads-filter');

                Route::withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
                ->post('profile-ads-filter', 'AdController@profile_ads_filter')->name('profile-ads-filter');

                Route::withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
                ->post('load-related-ads', 'AdController@load_related_ads')->name('load-related-ads');

                Route::withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
                ->post('load-home-ads', 'AdController@load_home_ads')->name('load-home-ads');
                
            });
            
            Route::group(['prefix' => 'paid-banners'], function () {
                Route::group(['middleware' => 'customer'], function () {
                    Route::get('/', 'PaidBannerController@index')->name('index.paid-banners');
                    Route::get('add', 'PaidBannerController@create')->name('create.paid-banners');
                    Route::post('store', 'PaidBannerController@store')->name('store.paid-banners');
                    Route::get('edit/{id}', 'PaidBannerController@edit')->name('edit.paid-banners');
                    Route::post('update', 'PaidBannerController@update')->name('update.paid-banners');
                    Route::get('delete/{id}', 'PaidBannerController@delete')->name('delete.paid-banners');            
                });        
            });
            
            Route::group(['prefix' => 'sponsor'], function () {
                Route::group(['middleware' => 'customer'], function () {
                    Route::get('/', 'SponsorController@index')->name('index.sponsor');
                    Route::get('add', 'SponsorController@add')->name('create.sponsor');
                    Route::post('store', 'SponsorController@store')->name('store.sponsor');

                    Route::get('data', 'SponsorController@data')->name('data.sponsor');

                    Route::get('edit/{id}', 'SponsorController@edit')->name('edit.sponsor');
                    Route::post('update', 'SponsorController@update')->name('update.sponsor');
                    Route::get('delete/{id}', 'SponsorController@delete')->name('delete.sponsor');            
                });        
            });

            Route::group(['prefix' => 'mux'], function () {
                Route::group(['middleware' => 'customer'], function () {
                    Route::post('upload-url', [MuxApiController::class, 'createUploadUrl'])->name('mux.upload.video');
                    Route::post('get-video-url', [MuxApiController::class, 'getVideoUrl'])->name('mux.get.video.url');
                    Route::post('delete-video', [MuxApiController::class, 'deleteVideo'])->name('mux.delete.video');
                    Route::post('clear-video-session', [MuxApiController::class, 'clearVideoSession'])->name('mux.clear.video.session');            
                });
            });

            Route::group(['prefix' => 'payment-checkout', 'middleware' => 'customer'], function () {

                Route::post('payment-method', [PaymentController::class, 'paymentMethod'])->name('payment.method');
                
                Route::post('redirect-payment-method', [PaymentController::class, 'redirectToPayment'])->name('redirect.payment.method');
                    
                Route::get('pay/{method}/{model_id}/{model_name}', [PaymentController::class, 'pay'])->name('payment.pay')
                ->where('method', 'paypal|stripe');

                Route::get('success/{method}/{sponsor_id}', [PaymentController::class, 'success'])->name('payment.success');
                    
                Route::get('cancel/{method}/{sponsor_id}', [PaymentController::class, 'cancel'])->name('payment.cancel');

                Route::get('/redirect-to-payment', function () {
                    return view('theme-views.sponsor.partials.multiple-redirect-payment-post', [
                        'route' => route('multiple.payment.method')
                    ]);
                })->name('redirect.to.payment');

                Route::post('multiple-payment-method', [MultiplePaymentController::class, 'multiplePaymentMethod'])->name('multiple.payment.method');
                
                Route::post('multiple-redirect-payment-method', [MultiplePaymentController::class, 'multipleRedirectToPayment'])->name('multiple.redirect.payment.method');

                Route::get('multiple/{method}/{model_ids}', [MultiplePaymentController::class, 'pay'])
                ->name('multiple.payment.pay')
                ->where('method', 'paypal|stripe');

                Route::get('multiple/{method}/success/{sponsor_ids}', [MultiplePaymentController::class, 'success'])
                ->name('multiple.payment.success');

                Route::get('multiple/{method}/cancel/{sponsor_ids}', [MultiplePaymentController::class, 'cancel'])
                ->name('multiple.payment.cancel');
            });

            Route::get('web-payment', 'Customer\PaymentController@web_payment_success')->name('web-payment-success');
            Route::get('payment-success', 'Customer\PaymentController@success')->name('payment-success');
            Route::get('payment-fail', 'Customer\PaymentController@fail')->name('payment-fail');

            Route::get('checkout-details', 'WebController@checkout_details')->name('checkout-details');
            Route::get('checkout-shipping', 'WebController@checkout_shipping')->name('checkout-shipping');
            Route::get('checkout-payment', 'WebController@checkout_payment')->name('checkout-payment');
            Route::get('checkout-review', 'WebController@checkout_review')->name('checkout-review');
            Route::get('checkout-complete', 'WebController@checkout_complete')->name('checkout-complete');
            Route::get('delivery-confirmed', 'WebController@delivery_confirmed')->name('delivery-confirmed');
            Route::post('offline-payment-checkout-complete', 'WebController@offline_payment_checkout_complete')->name('offline-payment-checkout-complete');
            Route::get('order-placed', 'WebController@order_placed')->name('order-placed');
            Route::get('shop-cart', 'WebController@shop_cart')->name('shop-cart');
            Route::post('order_note', 'WebController@order_note')->name('order_note');
            Route::get('digital-product-download/{id}', 'WebController@digital_product_download')->name('digital-product-download');
            Route::post('digital-product-download-otp-verify', 'WebController@digital_product_download_otp_verify')->name('digital-product-download-otp-verify');
            Route::post('digital-product-download-otp-reset', 'WebController@digital_product_download_otp_reset')->name('digital-product-download-otp-reset');
            Route::get('pay-offline-method-list', 'WebController@pay_offline_method_list')->name('pay-offline-method-list')->middleware('guestCheck');

            //wallet payment
            Route::get('checkout-complete-wallet', 'WebController@checkout_complete_wallet')->name('checkout-complete-wallet');

            Route::post('subscription', 'WebController@subscription')->name('subscription');
            Route::get('search-shop', 'WebController@search_shop')->name('search-shop');

            Route::get('category-ajax/{id}', 'WebController@categories_by_category')->name('category-ajax');

            Route::get('brands', 'WebController@all_brands')->name('brands');
            Route::get('brand-details/{brand}', 'WebController@brand_details')->name('brand.details');
            Route::get('brand-ads/{vehicleModel}', 'WebController@model_ads')->name('model-ads');
            Route::get('sellers', 'WebController@all_sellers')->name('sellers');
            Route::get('seller-profile/{id}', 'WebController@seller_profile')->name('seller-profile');

            Route::get('flash-deals/{id}', 'WebController@flash_deals')->name('flash-deals');

            /** Pages */
            Route::get('terms', 'PageController@termsand_condition')->name('terms');
            Route::get('privacy-policy', 'PageController@privacy_policy')->name('privacy-policy');
            Route::get('instructions-for-use', 'PageController@instructions_for_use')->name('instructions-for-use');
            Route::get('return-policy', 'PageController@return_policy')->name('return-policy');
            Route::get('cancellation-policy', 'PageController@cancellation_policy')->name('cancellation-policy');
            Route::get('helpTopic', 'PageController@helpTopic')->name('helpTopic');
            Route::get('helpTopic', 'PageController@helpTopic')->name('helpTopic');
            Route::get('contacts', 'PageController@contacts')->name('contacts');
            Route::get('about-us', 'PageController@about_us')->name('about-us');

            Route::post('review-list-product','WebController@review_list_product')->name('review-list-product');
            Route::post('review-list-shop','WebController@review_list_shop')->name('review-list-shop'); // theme fashion
            //Chat with seller from product details
            Route::get('chat-for-product', 'WebController@chat_for_product')->name('chat-for-product');

            Route::get('wishlists', 'WebController@viewWishlist')->name('wishlists')->middleware('customer');
            Route::post('store-wishlist', 'WebController@storeWishlist')->name('store-wishlist');
            Route::post('delete-wishlist', 'WebController@deleteWishlist')->name('delete-wishlist');
            Route::get('delete-wishlist-all', 'WebController@delete_wishlist_all')->name('delete-wishlist-all')->middleware('customer');

            Route::post('/currency', 'CurrencyController@changeCurrency')->name('currency.change');

            // theme_aster compare list
            Route::get('compare-list', 'CompareController@index')->name('compare-list');
            Route::get('delete-compare-list-all', 'CompareController@delete_compare_list_all')->name('delete-compare-list-all');
            Route::any('store-compare-list', 'CompareController@store_compare_list')->name('store-compare-list');
            // end theme_aster compare list
            Route::get('searched-products-for-compare', 'WebController@searched_products_for_compare_list')->name('searched-products-compare'); // theme fashion compare list
            Route::get('delete-compare-list', 'CompareController@delete_compare_list')->name('delete-compare-list');

            //profile Route
            Route::get('show-profile/{id}/{name}', 'UserProfileController@show_profile')->name('show-profile');
            
            Route::get('user-profile', 'UserProfileController@user_profile')->name('user-profile')->middleware('customer'); //theme_aster
            Route::get('user-account', 'UserProfileController@user_account')->name('user-account')->middleware('customer');
            Route::post('user-account-update', 'UserProfileController@user_update')->name('user-update');
            Route::post('user-account-picture', 'UserProfileController@user_picture')->name('user-picture');
            Route::get('edit-location-data', 'UserProfileController@edit_location_data')->name('edit-location-data');
            Route::get('account-address', 'UserProfileController@account_address')->name('account-address');
            Route::post('account-update-location', 'UserProfileController@update_location')->name('update-location');
            Route::get('account-address-delete', 'UserProfileController@address_delete')->name('address-delete');
            Route::get('account-address-edit/{id}','UserProfileController@address_edit')->name('address-edit');
            Route::post('account-address-update', 'UserProfileController@address_update')->name('address-update');
            Route::get('account-payment', 'UserProfileController@account_payment')->name('account-payment');
            Route::get('account-oder', 'UserProfileController@account_oder')->name('account-oder')->middleware('customer');
            Route::get('account-order-details', 'UserProfileController@account_order_details')->name('account-order-details')->middleware('customer');
            Route::get('account-order-details-seller-info', 'UserProfileController@account_order_details_seller_info')->name('account-order-details-seller-info')->middleware('customer');
            Route::get('account-order-details-delivery-man-info', 'UserProfileController@account_order_details_delivery_man_info')->name('account-order-details-delivery-man-info')->middleware('customer');
            Route::get('account-order-details-reviews', 'UserProfileController@account_order_details_reviews')->name('account-order-details-reviews')->middleware('customer');
            Route::get('generate-invoice/{id}', 'UserProfileController@generate_invoice')->name('generate-invoice');
            Route::get('account-wishlist', 'UserProfileController@account_wishlist')->name('account-wishlist'); //add to card not work
            Route::get('refund-request/{id}','UserProfileController@refund_request')->name('refund-request');
            Route::get('refund-details/{id}','UserProfileController@refund_details')->name('refund-details');
            Route::post('refund-store','UserProfileController@store_refund')->name('refund-store');
            Route::get('account-tickets', 'UserProfileController@account_tickets')->name('account-tickets');
            Route::get('order-cancel/{id}', 'UserProfileController@order_cancel')->name('order-cancel');
            Route::post('ticket-submit', 'UserProfileController@ticket_submit')->name('ticket-submit');
            Route::get('account-delete/{id}','UserProfileController@account_delete')->name('account-delete');
            Route::get('refer-earn', 'UserProfileController@refer_earn')->name('refer-earn')->middleware('customer');
            Route::get('user-coupons', 'UserProfileController@user_coupons')->name('user-coupons')->middleware('customer');
            Route::get('user-ads', 'UserProfileController@user_ads')->name('user-ads')->middleware('customer');
            // Chatting start
            Route::get('chat/{type}', 'ChattingController@chat_list')->name('chat')->middleware('customer');
            Route::get('messages', 'ChattingController@messages')->name('messages');
            Route::post('messages-store', 'ChattingController@messages_store')->name('messages_store');
            Route::post('chat-with-seller', 'ChattingController@chat_with_seller')->name('chat_with_seller');
            Route::post('discussion-store', 'ChattingController@discussion_store')->name('discussion_store');
            // chatting end

            //Support Ticket
            Route::group(['prefix' => 'support-ticket', 'as' => 'support-ticket.'], function () {
                Route::get('{id}', 'UserProfileController@single_ticket')->name('index');
                Route::post('{id}', 'UserProfileController@comment_submit')->name('comment');
                Route::get('delete/{id}', 'UserProfileController@support_ticket_delete')->name('delete');
                Route::get('close/{id}', 'UserProfileController@support_ticket_close')->name('close');
            });

            Route::get('account-transaction', 'UserProfileController@account_transaction')->name('account-transaction');
            Route::get('account-wallet-history', 'UserProfileController@account_wallet_history')->name('account-wallet-history');

            Route::get('loyalty','UserLoyaltyController@index')->name('loyalty')->middleware('customer');
            Route::post('loyalty-exchange-currency','UserLoyaltyController@loyalty_exchange_currency')->name('loyalty-exchange-currency');
            Route::get('ajax-loyalty-currency-amount','UserLoyaltyController@ajax_loyalty_currency_amount')->name('ajax-loyalty-currency-amount');

            Route::group(['prefix' => 'track-order', 'as' => 'track-order.'], function () {
                Route::get('', 'UserProfileController@track_order')->name('index');
                Route::get('result-view', 'UserProfileController@track_order_result')->name('result-view');
                Route::get('last', 'UserProfileController@track_last_order')->name('last');
                Route::any('result', 'UserProfileController@track_order_result')->name('result');
                Route::get('order-wise-result-view', 'UserProfileController@track_order_wise_result')->name('order-wise-result-view');
            });

            //top Rated
            Route::get('top-rated', 'WebController@top_rated')->name('topRated');
            Route::get('best-sell', 'WebController@best_sell')->name('bestSell');
            Route::get('new-product', 'WebController@new_product')->name('newProduct');

            Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
                Route::post('store', 'WebController@contact_store')->name('store');
                Route::get('/code/captcha/{tmp}', 'WebController@captcha')->name('default-captcha');
            });
        });

        //Seller shop apply
        Route::group(['prefix' => 'shop', 'as' => 'shop.', 'namespace' => 'Seller\Auth'], function () {
            Route::get('apply', 'RegisterController@create')->name('apply');
            Route::post('apply', 'RegisterController@store');

        });


        Route::get('login/{tab}', 'LoginController@login')->name('login');
        Route::post('login_submit', 'LoginController@submit')->name('login_post')->middleware('actch');
        Route::get('auth/captcha/{tmp}', 'LoginController@captcha')->name('auth-default-captcha');

        //check done
        Route::group(['prefix' => 'cart', 'as' => 'cart.', 'namespace' => 'Web'], function () {
            Route::post('variant_price', 'CartController@variant_price')->name('variant_price');
            Route::post('add', 'CartController@addToCart')->name('add');
            Route::post('update-variation', 'CartController@update_variation')->name('update-variation');//theme fashion
            Route::post('remove', 'CartController@removeFromCart')->name('remove');
            Route::get('remove-all', 'CartController@remove_all_cart')->name('remove-all');//theme fashion
            Route::post('nav-cart-items', 'CartController@updateNavCart')->name('nav-cart');
            Route::post('floating-nav-cart-items', 'CartController@update_floating_nav')->name('floating-nav-cart-items');// theme fashion floating nav
            Route::post('updateQuantity', 'CartController@updateQuantity')->name('updateQuantity');
            Route::post('updateQuantity-guest', 'CartController@updateQuantity_guest')->name('updateQuantity.guest');
            Route::post('order-again', 'CartController@order_again')->name('order-again')->middleware('customer');
        });

        //Seller shop apply
        Route::group(['prefix' => 'coupon', 'as' => 'coupon.', 'namespace' => 'Web'], function () {
            Route::post('apply', 'CouponController@apply')->name('apply');
        });
        //check done

        $is_published = 0;
        try {
            $full_data = include('Modules/Gateways/Addon/info.php');
            $is_published = $full_data['is_published'] == 1 ? 1 : 0;
        } catch (\Exception $exception) {
        }

        Route::get('seller-auth-login', function() {
            return 'empty';
        })->name('seller.auth.login');

        Route::get('seller-auth-forgot-password', function() {
            return 'empty';
        })->name('seller.auth.forgot-password');

        Route::get('clear-cache', function() {
            Cache::forget('home_categories');
            Cache::forget('active_brands');
            Cache::forget('main_banners');
            Cache::forget('sponsor_types');
            Cache::forget('subscription_packages');
            Cache::forget('categories');
            Cache::forget('brands');
            Cache::forget('models');
            Cache::forget('business_settings');
            Cache::forget('business_setting_language');
            Cache::forget('language');
            Cache::forget('adding_brands');
            Cache::forget('adding_models');
            Cache::forget('list_values');
            Cache::forget('adding_subscription_packages');
            Cache::flush();
        });
    }
);

Route::get('store-translations', function() {

    $locale = 'nn';

    $messagesFile = resource_path("lang2/{$locale}/messages.php");

    if (File::exists($messagesFile)) {
        $words = include $messagesFile;
        
        if (is_array($words)) {
            foreach ($words as $key => $value) {
                LanguageTranslation::create([
                    'key' => $key,
                    'value' => $value,
                    'locale' => $locale,
                ]);
            }
            echo "Processed language: {$locale}\n";
        }
    } else {
        echo "Messages file not found for locale: {$locale}\n";
    }

});

Route::get('cache-translations', function () {
    try {
        $locales = array_keys(config('laravellocalization.supportedLocales'));
        
        // Apply mapping
        foreach ($locales as &$locale) {
            $locale = config("laravellocalization.localesMapping.{$locale}", $locale);
        }
        
        $cachedLocales = [];
        
        foreach ($locales as $localeCode) {
            $cacheKey = "translations_{$localeCode}";
            
            // Load and cache translations for this locale
            $translations = LanguageTranslation::where('locale', $localeCode)
                ->pluck('value', 'key')
                ->toArray();
            
            Cache::forever($cacheKey, $translations);
            
            $cachedLocales[] = $localeCode;
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Translations cached successfully',
            'locales' => $cachedLocales,
            'total_locales' => count($cachedLocales)
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error caching translations',
            'error' => $e->getMessage()
        ], 500);
    }
});

Route::get('all-cache-clear', function () {
    Cache::flush();
});

Route::get('clear-app', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    
    return "All caches cleared successfully!";
});

Route::get('supported-locales', function() {
    $locales = array_keys(config('laravellocalization.supportedLocales'));
            $all_locales = [];
            // Apply mapping
            foreach ($locales as &$locale) {
                $all_locales[] = config("laravellocalization.localesMapping.{$locale}", $locale);
            }

    return $all_locales;
});

Route::get('migrate-by-code', function() {

    if (!Schema::hasTable('languages_translations')) {

        $result = Artisan::call('migrate', [
            '--path' => 'database/migrations/2025_11_23_102959_create_languages_translations_table.php',
            '--force' => true
        ]);

        if (Schema::hasTable('languages_translations')) {
            return 'Migration success';
        } 
        
        else {
            return 'Migration failed';
        }

    } 
    
    else {
        return 'Table already exists';
    }

});

Route::get('store-translations/{locale}', function($locale) {

    LanguageTranslation::where('locale', $locale)->delete();

    $messagesFile = resource_path("lang2/{$locale}/messages.php");

    if (File::exists($messagesFile)) {
        $words = include $messagesFile;
        
        if (is_array($words)) {
            foreach ($words as $key => $value) {
                LanguageTranslation::create([
                    'key' => $key,
                    'value' => $value,
                    'locale' => $locale,
                ]);
            }
            echo "Processed language: {$locale}\n";
        }
    } else {
        echo "Messages file not found for locale: {$locale}\n";
    }

});

Route::get('show-translations/{locale}', function($locale) {

    $translations = LanguageTranslation::where('locale', $locale)->count();

    return $translations;

});

Route::get('show-all-translations', function() {

    $translations = LanguageTranslation::get();

    return $translations;

});

Route::get('delete-translations/{locale}', function($locale) {

    $translations = LanguageTranslation::where('locale', $locale)->delete();

    return $translations;

});

Route::get('delete-all-translations', function() {

    $translations = LanguageTranslation::query()->delete();

    return $translations;

});

Route::get('cache-translations', function () {
    try {
        $locales = array_keys(config('laravellocalization.supportedLocales'));
        
        // Apply mapping
        foreach ($locales as &$locale) {
            $locale = config("laravellocalization.localesMapping.{$locale}", $locale);
        }
        
        $cachedLocales = [];
        
        foreach ($locales as $localeCode) {
            $cacheKey = "translations_{$localeCode}";
            
            // Load and cache translations for this locale
            $translations = LanguageTranslation::where('locale', $localeCode)
                ->pluck('value', 'key')
                ->toArray();
            
            Cache::forever($cacheKey, $translations);
            
            $cachedLocales[] = $localeCode;
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Translations cached successfully',
            'locales' => $cachedLocales,
            'total_locales' => count($cachedLocales)
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error caching translations',
            'error' => $e->getMessage()
        ], 500);
    }
});

Route::get('delete-all-sponsors', function() {
    SponsoredAd::query()->delete();
    SponsorVideo::query()->delete();
    return SponsoredAd::all();
});

Route::get('show-all-paid-banners', function() {
    $paidBanners = PaidBanner::get();
    return $paidBanners;
});

Route::get('optimize', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('view:cache');

    return "app optimized successfully!";
});

/* Empty laravel.log */
Route::get('log/clear', function () {
    File::put(storage_path('logs/laravel.log'), '');
    return 'laravel.log cleared';
});

/* Show laravel.log content */
Route::get('log/show', function () {
    $logPath = storage_path('logs/laravel.log');

    if (!File::exists($logPath)) {
        return 'laravel.log not found';
    }

    return response(
        nl2br(e(File::get($logPath))),
        200
    )->header('Content-Type', 'text/html');
});

Route::get('upload-migrations', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2026_03_05_121406_modify_expiration_date_in_paid_banners_table.php',
        '--force' => true,
    ]);

    return 'migration successfully uploaded';
});

Route::get('social-login', function() {
    return BusinessSetting::where('type', 'social_login')->get();
});

Route::get('delete-all-interests', function() {
    return UserCategoryInterest::query()->delete();
});

Route::get('test-helper-function', function() {
    Helpers::trackUserCategoryInterest(476);
});

Route::get('interests-table', function() {
    return UserCategoryInterest::get();
});

// Route::get('show-ads-for-debug', function() {
//     return Ad::whereDoesntHave('user')->delete();
// });

Route::get('apple-login', function() {
    $apple = Helpers::get_business_settings('apple_login');
    return $apple;
});

Route::get('show-apple-file', function () {
    $apple = cloudfront('apple-login') . (
        collect(
            json_decode(
                BusinessSetting::where('type', 'apple_login')->value('value'),
                true
            )
        )->firstWhere('login_medium', 'apple')['service_file'] ?? ''
    );

    return $apple;

});

Route::get('print-env-file', function () {
    return response(
        File::get(base_path('.env')),
        200,
        ['Content-Type' => 'text/plain']
    );
});

Route::get('/apple-secret', function () {

    $teamId = '975WJJG233';
    $clientId = 'com.eurobas.web.login';
    $keyId = '3K94UW8UQW';

    $privateKey = "-----BEGIN PRIVATE KEY-----\nMIGTAgEAMBMGByqGSM49AgEGCCqGSM49AwEHBHkwdwIBAQQgLndok/+oommuz4HswvitFx1aPex0obcyXmbSv64PTDigCgYIKoZIzj0DAQehRANCAAQDYozC+TMlGhKr8xEI+GLMLdxT5F2xd521DuyekNldGPM9eByN9anaWt71OwWiW1dVwfTt4SlpoLvNZRAsJ2oY\n-----END PRIVATE KEY-----";

    $payload = [
        'iss' => $teamId,
        'iat' => time(),
        'exp' => time() + (86400 * 180),
        'aud' => 'https://appleid.apple.com',
        'sub' => $clientId,
    ];

    return JWT::encode($payload, $privateKey, 'ES256', $keyId);
});

Route::get('create-instructions-for-use', function() {
    $instructions_for_use = BusinessSetting::create([
        'type' => 'instructions_for_use',
        'value' => ''
    ]);

    return $instructions_for_use;
});

Route::get('update-terms-and-conditions', function() {

    BusinessSetting::where('type', 'terms_condition')->delete();

    $terms = BusinessSetting::create([
        'type' => 'terms_condition',
        'value' => '<h1><strong>Introduction and Company Rules&nbsp; &nbsp;</strong><em>Effective Date:04-27-2025</em></h1>

<p>Welcome to EuroBas.com.</p>

<p>&nbsp;Europe&rsquo;s &nbsp;Vehicle Marketplace,&nbsp; unified european vehicles marketplace,&nbsp;Europe&#39;s automotive marketplace</p>

<p>Buy and sell all types of vehicles across Europe with ease. Whether you&rsquo;re listing a used or new car, truck, motorcycle, or commercial vehicle, our platform connects private sellers and dealers with interested buyers in one centralized, easy-to-use marketplace. Post your ad for free and reach a European-wide audience today.</p>

<p>1.By using our platform, you agree to comply with these Terms and Conditions.</p>

<p>Our goal is to provide a safe and reliable environment for buying and selling vehicles, spare parts, and related products across Europe.</p>

<p>EuroBas.com&rdquo; is an open digital marketplace for publishing advertisements related to the sale and purchase of used vehicles and spare parts within the European Union. The platform provides advertising space to users and is not a party to any transaction.</p>

<h3>2. Platform Functionality and Liability Limits</h3>

<ul>
	<li>
	<p>The platform operates solely as a classifieds marketplace and is not a financial or commercial intermediary between the buyer and seller.</p>
	</li>
	<li>
	<p>Payments are not made through the platform, and it does not execute or monitor any transaction or agreement.</p>
	</li>
	<li>
	<p>The platform does not receive any commission from sales or purchases, whether directly or indirectly.</p>
	</li>
	<li>
	<p>Users are responsible for posting their own ads, and interested clients contact advertisers directly outside the platform.</p>
	</li>
	<li>
	<p>The platform has no knowledge of whether a transaction is completed and bears no legal or financial responsibility.</p>
	</li>
	<li>
	<p>Users are fully responsible for the accuracy of the ad content, the credibility of other parties, and any resulting obligations.</p>
	</li>
	<li>
	<p>The platform is not subject to the EU DAC7 directive, as it does not facilitate or execute transactions or participate in any payment process.</p>
	</li>
	<li>
	<h2>&nbsp;Posting Ads Policy</h2>

	<h3>2.1 Important Notice Before Posting an Ad</h3>

	<p>To ensure the safety of our community and protect you from fraud, please adhere to the following rules before publishing any advertisement:</p>
	</li>
	<li>
	<p>The vehicle or item listed must be owned by you or you must be authorized to advertise it.</p>
	</li>
	<li>
	<p>Posting false or misleading advertisements is strictly prohibited.</p>
	</li>
	<li>
	<p>It is not allowed to use images taken from the internet or from other ads without explicit permission.</p>
	</li>
	<li>
	<p>Adding external phone numbers or links to other websites for off-platform communication is forbidden.</p>
	</li>
	<li>
	<p>Accounts found posting fraudulent ads will be immediately suspended without prior notice.</p>
	</li>
	<li>
	<p>We work diligently to protect our users by automatically and manually reviewing suspicious advertisements.</p>

	<h3>2.2 Platform and Ads Usage Policy</h3>
	</li>
	<li>
	<p>All advertisements must be genuine and represent an actual vehicle or product available for sale.</p>
	</li>
	<li>
	<p>Publishing fake ads or ads intended to collect users&rsquo; information is strictly prohibited.</p>
	</li>
	<li>
	<p>Reposting the same advertisement multiple times to gain visibility is not allowed.</p>
	</li>
	<li>
	<p>Personal accounts must not be used for organized commercial activities without prior approval from EuroBas.com.</p>
	</li>
	<li>
	<p>EuroBas.com reserves the right to delete or suspend any ad without prior notice if a violation or suspicious activity is suspected.</p>
	</li>
	<li>
	<p>All transactions are conducted directly between users. EuroBas.com is not responsible for any financial dealings between parties but provides tools to help minimize risks.</p>
	</li>
	<li>
	<p>We encourage all users to report any suspicious content or activities to help maintain a safe and professional environment.</p>
	</li>
	<li>
	<p>All rights related to the platform and its content (including text, images, designs, and trademarks) are reserved to EuroBas.com and may not be used without prior written permission.</p>

	<h2>3. Legal Disclaimer</h2>

	<p>EuroBas.com is not responsible for the accuracy or authenticity of ads posted by users.</p>
	</li>
	<li>
	<p>Users are solely responsible for the information they publish and for any damages or losses resulting from their transactions.</p>
	</li>
	<li>
	<h2>4. Amendments to Terms</h2>

	<p>We reserve the right to modify or update these Terms and Conditions at any time. Updates will be announced through the platform, and continued use of the platform constitutes acceptance of the revised terms.</p>

	<h2>5. Intellectual Property Rights.</h2>
	</li>
	<li>
	<p>All rights related to the platform and its content (including text, images, designs, and trademarks) are reserved to EuroBas.com and may not be used without prior written permission.</p>
	</li>
</ul>

<h3>6. Tax and Customs Regulations</h3>

<ul>
	<li>
	<p>Users must comply with local and EU laws regarding taxes, customs, import, and export.</p>
	</li>
	<li>
	<p>The platform does not offer shipping or customs clearance services and assumes no liability for related processes.</p>
	</li>
	<li>
	<p>Users are solely responsible for identifying and fulfilling any tax or customs obligations related to their transactions.</p>
	</li>
</ul>

<h3>7. Paid Ads and Optional Services</h3>

<ul>
	<li>
	<p>The platform offers additional paid services, such as:</p>

	<ul>
		<li>
		<p>Featuring ads on the homepage.</p>
		</li>
		<li>
		<p>Highlighting ads in search results.</p>
		</li>
		<li>
		<p>Monthly or annual subscription plans with added features.</p>
		</li>
	</ul>
	</li>
	<li>
	<p>These services are optional and not mandatory.</p>
	</li>
	<li>
	<p>Users are not entitled to a refund for any paid service, as they are considered fulfilled upon payment.</p>
	</li>
</ul>

<h3>8. Prohibited Content</h3>

<ul>
	<li>
	<p>It is strictly forbidden to publish or advertise any products or services that violate EU or local laws, including but not limited to:</p>

	<ul>
		<li>
		<p>Weapons</p>
		</li>
		<li>
		<p>Controlled substances or drugs</p>
		</li>
		<li>
		<p>Animals (where prohibited by law)</p>
		</li>
		<li>
		<p>Counterfeit or illegal goods</p>
		</li>
	</ul>
	</li>
	<li>
	<p>The platform reserves the right to remove any violating content without prior notice. Repeat violations may result in account suspension.</p>
	</li>
</ul>

<h3>9. Cooperation with Authorities</h3>

<ul>
	<li>
	<p>If tax or legal authorities request user information, the platform will cooperate in accordance with the law and GDPR regulations.</p>
	</li>
</ul>

<h3>10.&nbsp;Data Privacy (GDPR)</h3>

<ul>
	<li>
	<p>The platform complies with the General Data Protection Regulation (GDPR).</p>
	</li>
	<li>
	<p>Users can modify or delete their data at any time directly through their profile without contacting the administration.</p>
	</li>
</ul>

<h3>11. Modifications</h3>

<ul>
	<li>
	<p>The platform reserves the right to modify these terms at any time without prior notice.</p>
	</li>
	<li>
	<p>Continued use of the platform after updates constitutes acceptance of the new terms.</p>
	</li>
</ul>

<h3>12. Applicable Law</h3>

<ul>
	<li>
	<p>These terms are governed by Dutch law.</p>
	</li>
	<li>
	<p>In the event of a dispute, the courts of the Netherlands shall have jurisdiction.</p>
	</li>
	<li>
	<h3>Important Disclaimer on Payments<strong>.</strong></h3>
	</li>
	<li>
	<p>EuroBas.com is a classifieds platform only and does not participate in or monitor any financial transactions between users.</p>

	<p>All users, especially buyers, are strongly advised to exercise extreme caution when engaging in transactions. Please follow these important guidelines:</p>
	</li>
	<li>
	<p>Do not send any money or make advance payments (such as deposits) before verifying the identity and credibility of the seller.</p>
	</li>
	<li>
	<p>Always try to inspect the item in person or use a trusted third party before proceeding with any payment.</p>
	</li>
	<li>
	<p>Prefer to meet in safe, public locations and ensure all transactions are documented.</p>
	</li>
	<li>
	<p>Avoid using untraceable or non-secure payment methods.</p>
	</li>
	<li>
	<p>Any payment, agreement, or transaction is done entirely at the user&rsquo;s own risk.</p>
	</li>
	<li>
	<p>EuroBas.com shall not be held liable for any loss, fraud, or dispute arising from user-to-user transactions. By using the platform, you acknowledge and accept full responsibility for your interactions and payments.</p>
	</li>
</ul>

<h1>Your Acceptance of These Terms</h1>

<ol>
	<li>
	<p>By using this website, you agree to these Terms &amp; Conditions and the associated policies. If you do not agree, please refrain from using the platform. EuroBas</p>
	</li>
</ol>

<p><strong>Contact Us:</strong></p>

<p>If you have any questions or inquiries please contact us via email &nbsp;info@eurobas.com&nbsp;</p>

<p>Last Updated: 04/27/2025</p>

<p>&nbsp;</p>

<p>&nbsp;</p>'
]);

    return $terms;
});

Route::get('check-passport-tables', function () {
    $tables = [
        'oauth_access_tokens',
        'oauth_auth_codes',
        'oauth_clients',
        'oauth_personal_access_clients',
        'oauth_refresh_tokens',
    ];

    $result = [];

    foreach ($tables as $table) {
        $result[$table] = Schema::hasTable($table);
    }

    return response()->json($result);
});

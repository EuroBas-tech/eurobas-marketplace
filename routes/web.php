<?php

ini_set('max_execution_time', 1000);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use App\Model\Ad;
use App\Model\Cart;
use App\CPU\Helpers;
use App\Model\Brand;
use App\Model\Order;
use App\Models\User;
use App\Model\Seller;
use GuzzleHttp\Client;
use App\Model\AdReport;
use App\Model\Category;
use App\Model\Chatting;
use App\Model\Wishlist;
use App\Model\ListValue;
use App\Model\PaidBanner;
use App\Model\AdminWallet;
use App\Model\SponsoredAd;
use App\Model\CategoryType;
use App\Model\SellerWallet;
use App\Model\vehicleModel;
use App\Model\ListAttribute;
use Illuminate\Http\Request;
use App\Model\BusinessSetting;
use App\Model\SponsoredAdType;
use App\Model\WithdrawalMethod;
use App\Model\AdminWalletAction;
use App\Model\WalletTransaction;
use App\Model\SellerWalletAction;
use App\Model\SellerPayoutHistory;
use App\Model\SubscriptionPackage;
use Illuminate\Support\Facades\App;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Model\SellerWalletActionHistory;
use App\Model\SubscriptionPackageFeature;
use GuzzleHttp\Exception\RequestException;
use App\Http\Controllers\Web\HomeController;
use phpseclib3\File\ASN1\Maps\AttributeValue;
use App\Http\Controllers\Shipping\ShipmentController;
use App\Http\Controllers\Payment_Methods\PaytmController;
use App\Http\Controllers\Payment_Methods\LiqPayController;

use App\Http\Controllers\Payment_Methods\PaymobController;

use App\Http\Controllers\Payment_Methods\PayPalController;
use App\Http\Controllers\Payment_Methods\StripeController;
use App\Http\Controllers\Payment_Methods\PaymentController;
use App\Http\Controllers\Payment_Methods\PaytabsController;
use App\Http\Controllers\Payment_Methods\PaystackController;
use App\Http\Controllers\Payment_Methods\RazorPayController;
use App\Http\Controllers\Payment_Methods\SenangPayController;
use App\Http\Controllers\Payment_Methods\IngPaymentController;
use App\Http\Controllers\Payment_Methods\MercadoPagoController;
use App\Http\Controllers\Payment_Methods\BkashPaymentController;
use App\Http\Controllers\Payment_Methods\FlutterwaveV3Controller;
use App\Http\Controllers\Payment_Methods\PaypalPaymentController;
use App\Http\Controllers\Payment_Methods\StripePaymentController;
use App\Http\Controllers\Payment_Methods\MultiplePaymentController;
use App\Http\Controllers\Payment_Methods\SslCommerzPaymentController;

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

            Route::post('upload-url', 'AdController@createUploadUrl')->name('upload.video.bunny');
            Route::post('get-video-url', 'AdController@getVideoUrl')->name('get.bunny.video.url');
            
            Route::post('delete-bunny-video', 'AdController@deleteVideo')->name('delete.bunny.video');
            Route::post('clear-video-session', 'AdController@clearVideoSession')->name('clear.video.session');
            
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

            Route::post('upload-url', 'SponsorController@createUploadUrl')->name('upload.video.bunny');
            Route::post('get-video-url', 'SponsorController@getVideoUrl')->name('get.bunny.video.url');
            
            Route::post('delete-bunny-video', 'SponsorController@deleteVideo')->name('delete.bunny.video');
            Route::post('clear-video-session', 'SponsorController@clearVideoSession')->name('clear.video.session');

            Route::get('edit/{id}', 'SponsorController@edit')->name('edit.sponsor');
            Route::post('update', 'SponsorController@update')->name('update.sponsor');
            Route::get('delete/{id}', 'SponsorController@delete')->name('delete.sponsor');            
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

    Route::get('categories', 'WebController@all_categories')->name('categories');
    Route::get('category-ajax/{id}', 'WebController@categories_by_category')->name('category-ajax');

    Route::get('brands', 'WebController@all_brands')->name('brands');
    Route::get('sellers', 'WebController@all_sellers')->name('sellers');
    Route::get('seller-profile/{id}', 'WebController@seller_profile')->name('seller-profile');

    Route::get('flash-deals/{id}', 'WebController@flash_deals')->name('flash-deals');

    /** Pages */
    Route::get('terms', 'PageController@termsand_condition')->name('terms');
    Route::get('privacy-policy', 'PageController@privacy_policy')->name('privacy-policy');
    Route::get('refund-policy', 'PageController@refund_policy')->name('refund-policy');
    Route::get('return-policy', 'PageController@return_policy')->name('return-policy');
    Route::get('cancellation-policy', 'PageController@cancellation_policy')->name('cancellation-policy');
    Route::get('helpTopic', 'PageController@helpTopic')->name('helpTopic');
    Route::get('helpTopic', 'PageController@helpTopic')->name('helpTopic');
    Route::get('contacts', 'PageController@contacts')->name('contacts');
    Route::get('about-us', 'PageController@about_us')->name('about-us');

    Route::get('/product/{slug}', 'ProductDetailsController@product')->name('product');
    Route::get('products', 'ProductListController@products')->name('products');
    Route::post('ajax-filter-products', 'ShopViewController@ajax_filter_products')->name('ajax-filter-products'); // Theme fashion, ALl purpose
    Route::get('orderDetails', 'WebController@orderdetails')->name('orderdetails');
    Route::get('discounted-products', 'WebController@discounted_products')->name('discounted-products');
    Route::post('/products-view-style', 'WebController@product_view_style')->name('product_view_style');

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

    Route::get('wallet-account','UserWalletController@my_wallet_account')->name('wallet-account'); //theme fashion
    Route::get('wallet','UserWalletController@index')->name('wallet')->middleware('customer');
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

    //sellerShop
    Route::get('shopView/{id}', 'ShopViewController@seller_shop')->name('shopView');
    Route::get('ajax-shop-vacation-check', 'ShopViewController@ajax_shop_vacation_check')->name('ajax-shop-vacation-check');//theme fashion
    Route::post('shopView/{id}', 'WebController@seller_shop_product');
    Route::post('shop-follow', 'ShopFollowerController@shop_follow')->name('shop_follow');

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

if (!$is_published) {
    Route::group(['prefix' => 'payment'], function () {

        //SSLCOMMERZ
        Route::group(['prefix' => 'sslcommerz', 'as' => 'sslcommerz.'], function () {
            Route::get('pay', [SslCommerzPaymentController::class, 'index'])->name('pay');
            Route::post('success', [SslCommerzPaymentController::class, 'success'])
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::post('failed', [SslCommerzPaymentController::class, 'failed'])
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::post('canceled', [SslCommerzPaymentController::class, 'canceled'])
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //RAZOR-PAY
        Route::group(['prefix' => 'razor-pay', 'as' => 'razor-pay.'], function () {
            Route::get('pay', [RazorPayController::class, 'index']);
            Route::post('payment', [RazorPayController::class, 'payment'])->name('payment')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //SENANG-PAY
        Route::group(['prefix' => 'senang-pay', 'as' => 'senang-pay.'], function () {
            Route::get('pay', [SenangPayController::class, 'index']);
            Route::any('callback', [SenangPayController::class, 'return_senang_pay']);
        });

        //PAYTM
        Route::group(['prefix' => 'paytm', 'as' => 'paytm.'], function () {
            Route::get('pay', [PaytmController::class, 'payment']);
            Route::any('response', [PaytmController::class, 'callback'])->name('response')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //FLUTTERWAVE
        Route::group(['prefix' => 'flutterwave-v3', 'as' => 'flutterwave-v3.'], function () {
            Route::get('pay', [FlutterwaveV3Controller::class, 'initialize'])->name('pay');
            Route::get('callback', [FlutterwaveV3Controller::class, 'callback'])->name('callback');
        });

        //PAYSTACK
        Route::group(['prefix' => 'paystack', 'as' => 'paystack.'], function () {
            Route::get('pay', [PaystackController::class, 'index'])->name('pay');
            Route::post('payment', [PaystackController::class, 'redirectToGateway'])->name('payment');
            Route::get('callback', [PaystackController::class, 'handleGatewayCallback'])->name('callback');
        });

        //BKASH

        Route::group(['prefix' => 'bkash', 'as' => 'bkash.'], function () {
            // Payment Routes for bKash
            Route::get('make-payment', [BkashPaymentController::class, 'make_tokenize_payment'])->name('make-payment');
            Route::any('callback', [BkashPaymentController::class, 'callback'])->name('callback');
        });

        //Liqpay
        Route::group(['prefix' => 'liqpay', 'as' => 'liqpay.'], function () {
            Route::get('payment', [LiqPayController::class, 'payment'])->name('payment');
            Route::any('callback', [LiqPayController::class, 'callback'])->name('callback');
        });

        //MERCADOPAGO
        Route::group(['prefix' => 'mercadopago', 'as' => 'mercadopago.'], function () {
            Route::get('pay', [MercadoPagoController::class, 'index'])->name('index');
            Route::post('make-payment', [MercadoPagoController::class, 'make_payment'])->name('make_payment');
        });

        //PAYMOB
        Route::group(['prefix' => 'paymob', 'as' => 'paymob.'], function () {
            Route::any('pay', [PaymobController::class, 'credit'])->name('pay');
            Route::any('callback', [PaymobController::class, 'callback'])->name('callback');
        });

        //PAYTABS
        Route::group(['prefix' => 'paytabs', 'as' => 'paytabs.'], function () {
            Route::any('pay', [PaytabsController::class, 'payment'])->name('pay');
            Route::any('callback', [PaytabsController::class, 'callback'])->name('callback');
            Route::any('response', [PaytabsController::class, 'response'])->name('response');
        });

        //Pay Fast
        Route::group(['prefix' => 'payfast', 'as' => 'payfast.'], function () {
            Route::get('pay', [PayFastController::class, 'payment'])->name('payment');
            Route::any('callback', [PayFastController::class, 'callback'])->name('callback');
        });
    });
}


Route::get('test-session' ,function() {
    return session()->all();
})->name('test-session');

Route::get('show-email-template', function() {
    $id = 100003;
    return view('email-templates.order-received-notify-seller', compact('id'));
});

Route::get('test-db', function() {
    return SellerWallet::with('sellerWalletActionHistories')->get();
});

Route::get('track/{trackingNumber?}', [ShipmentController::class, 'track']);


Route::get('/payment/make', [IngPaymentController::class, 'makePayment']);


// Route::get('register-tracking', [ShipmentController::class, 'registerTracking']);


// Route::get('order-status', function(){
    
//     $order = new Order;

//     $order->order_status = 'delivered';	
//     $order->customer_type = 'customer';	
//     $order->payment_status = 'unpaid';
//     $order->customer_id = 52;	
//     $order->is_guest = 0;	
//     $order->transaction_ref = 'pi_3R4LrYEAkaq8PXfC0aE7DvuQ';	
//     $order->payment_method = 'stripe';	
//     $order->order_amount = 120.56456;	
//     $order->admin_commission = 12.54654;	
//     $order->is_pause = 0;	
//     $order->coupon_discount_bearer = 'inhouse';	
//     $order->shipping_method_id = 0;	
//     $order->order_group_id = '8129-6YTYc-1742309125';	
//     $order->is_shipping_free = 0;	
//     $order->verification_status = 0;	
//     $order->seller_id = 24;	
//     $order->seller_is = 'seller';	
//     $order->order_type = 'default_order';	
//     $order->billing_address = 2135;	
//     $order->extra_discount = 0.01;	
//     $order->free_delivery_bearer = "admin";	
//     $order->billing_address_data = '{"id":646,"customer_id":0,"is_guest":0,"contact_person_name":"amine","email":null,"address_type":"home","address":"40 logt  ferdioua 105","city":"mila","zip":"135698","phone":"086549754","created_at":null,"updated_at":null,"state":null,"country":"Algeria","latitude":"52.1558004","longitude":"5.3924507","is_billing":0}';	
//     $order->shipping_address_data = '{"id":646,"customer_id":0,"is_guest":0,"contact_person_name":"amine","email":null,"address_type":"home","address":"40 logt  ferdioua 105","city":"mila","zip":"135698","phone":"086549754","created_at":null,"updated_at":null,"state":null,"country":"Algeria","latitude":"52.1558004","longitude":"5.3924507","is_billing":0}';	
//     $order->shipping_cost = 0;	
//     $order->shipping_address = 123;	
//     $order->shipping_address = 1234;	
    	
//     $order->save();

//     return $order;

// });

Route::get('seller-auth-login', function() {
    return 'empty';
})->name('seller.auth.login');

Route::get('seller-auth-forgot-password', function() {
    return 'empty';
})->name('seller.auth.forgot-password');









/****** -------------------------------------------------------- *****/



Route::get('test-db', function() {
    return Chatting::with('receiver')->get();
});

Route::get('add-words-to-translations', function () {
    return view('theme-views.add-words-to-translations');
});

Route::post('add-words-to-translations', function (Request $request) {

    $languages = \App\Model\BusinessSetting::where('type', 'language')->first();
    $wordKey = $request->word;

    foreach (json_decode($languages['value'], true) as $data) {

        $local = $data['code'];
        $lang_path = base_path("resources/lang/{$local}/messages.php");
        $lang_array = file_exists($lang_path) ? include($lang_path) : [];
        $updated = false;

        // ✅ Check if the wordKey exists
        if (!array_key_exists($wordKey, $lang_array)) {
            $lang_array[$wordKey] = $wordKey;
            $updated = true;
        }
        if ($updated) {
            // Save only if changes were made
            $str = "<?php return " . var_export($lang_array, true) . ";";
            file_put_contents($lang_path, $str);

            // return back();
        } else {
            // Toastr::error('Translations already exist no need to ad it again!');
            // return back();
        }
        
    }

    Toastr::success('Translations added successfully!');
    return back();
    
})->name('add-words-to-translations');


Route::get('city-validity', function() {

    $city = 'london';
    $country = 'United Kingdom';

    $apiKey = \App\CPU\Helpers::get_business_settings('map_api_key');

    $address ="{$city}, {$country}";

    $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
        'address' => $address,
        'key' => $apiKey
    ]);

    if (!$response->successful()) {
        return response()->json(['error' => 'Geocoding service unavailable'], 503);
    }

    $data = $response->json();

    if ($data['status'] !== 'OK' || empty($data['results'])) {
        return response()->json(['error' => 'Location not found'], 404);
    }

    $location = $data['results'][0]['geometry']['location'];

    return response()->json([
        'latitude' => $location['lat'],
        'longitude' => $location['lng'],
        'formatted_address' => $data['results'][0]['formatted_address']
    ]);

});

Route::get('check-session', function() {
    return session('video_player_url');
});

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

Route::get('clear-app', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    
    return "All caches cleared successfully!";
});








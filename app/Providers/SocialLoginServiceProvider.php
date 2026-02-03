<?php

namespace App\Providers;

use App\CPU\Helpers;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Apple\AppleExtendSocialite;

class SocialLoginServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot()
    {
       
        try {
            $this->app['events']->listen(SocialiteWasCalled::class, [AppleExtendSocialite::class, 'handle']);
        } catch (\Exception $e) {}

       
        try {
            $socialLoginServices = Helpers::get_business_settings('social_login');

            if ($socialLoginServices) {
                foreach ($socialLoginServices as $socialLoginService) {
                    if ($socialLoginService['status'] == true) {
                       
                        if ($socialLoginService['login_medium'] == 'google') {
                            Config::set('services.google', [
                                'client_id'     => $socialLoginService['client_id'],
                                'client_secret' => $socialLoginService['client_secret'],
                                'redirect'      => secure_url('customer/auth/login/google/callback'),
                            ]);
                        } 
                        
                        elseif ($socialLoginService['login_medium'] == 'facebook') {
                            Config::set('services.facebook', [
                                'client_id'     => $socialLoginService['client_id'],
                                'client_secret' => $socialLoginService['client_secret'],
                                'redirect'      => secure_url('customer/auth/login/facebook/callback'),
                            ]);
                        }
                       
                        elseif ($socialLoginService['login_medium'] == 'apple') {
                            Config::set('services.apple', [
                                'client_id'     => $socialLoginService['client_id'],
                                'team_id'       => $socialLoginService['team_id'],
                                'key_id'        => $socialLoginService['key_id'],
                                'redirect'      => secure_url('customer/auth/login/apple/callback'),
                                'client_secret' => null, 
                            ]);
                        }
                    }
                }
            }
        } catch (\Exception $exception) {}
    }
}

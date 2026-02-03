<?php

namespace App\Http\Controllers\Customer\Auth;

use Session;
use App\User;
use App\CPU\Helpers;
use App\Model\Wishlist;
use App\CPU\CartManager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\BusinessSetting;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use SocialiteProviders\Manager\Config;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    
    public function redirectToProvider(Request $request, $service)
    {
        if ($service === 'apple') {
            $apple_config = BusinessSetting::where('type', 'apple_login')->first();
            
            if (!$apple_config || !isset($apple_config->value)) {
                Toastr::error(translate('apple_login_not_configured'));
                return redirect()->route('customer.auth.login');
            }
            
            $config_data = json_decode($apple_config->value, true);
            $config_data = $config_data[0]; // Get first array item
            
            $config = new \SocialiteProviders\Manager\Config(
                $config_data['client_id'],
                $config_data['client_secret'],
                $config_data['redirect_url'],
                [
                    'team_id' => $config_data['team_id'],
                    'key_id' => $config_data['key_id'],
                    'private_key' => cloudfront('paid-banners') . $config_data['service_file'],
                ]
            );
            
            return Socialite::driver('apple')->setConfig($config)->redirect();
        }
        
        return Socialite::driver($service)->redirect();
    }

    public function handleProviderCallback($service)
    {
        try {
            if ($service === 'apple') {
                $user_data = Socialite::driver('apple')->stateless()->user();
                
                // Apple doesn't always return name/email after first login
                $name = $user_data->name ?? $user_data->getName() ?? 'Apple User';
                $email = $user_data->email ?? $user_data->getEmail();
                $user_id = $user_data->id ?? $user_data->getId();
                
            } else {
                $user_data = Socialite::driver($service)->stateless()->user();
                $name = $user_data->getName() ?? 'User';
                $email = $user_data->getEmail();
                $user_id = $user_data->id;
            }

            if (!$email) {
                Toastr::error(translate('email_not_provided_by') . ' ' . ucfirst($service));
                return redirect()->route('customer.auth.login');
            }

            $user = User::where('email', $email)->orWhere('social_id', $user_id)->first() ?? null;

            if (!isset($user)) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'phone' => '',
                    'password' => bcrypt($user_id),
                    'is_active' => 1,
                    'login_medium' => $service,
                    'social_id' => $user_id,
                    'is_phone_verified' => 0,
                    'is_email_verified' => $email ? 1 : 0,
                    'temporary_token' => Str::random(40),
                ]);
            } else {
                $user->temporary_token = Str::random(40);
                $user->save();
            }

            $message = self::login_process($user, $email, $user_id);

            Toastr::info($message);
            return redirect()->route('home');
            
        } catch (\Exception $e) {
            Log::error('Social login error: ' . $e->getMessage());
            Toastr::error(translate('something_went_wrong'));
            return redirect()->route('customer.auth.login');
        }
    }

    public function editPhone($id)
    {
        $user = User::find($id);
        return view('customer-view.auth.update-phone', compact('user'));
    }

    public function updatePhone(Request $request)
    {
        $request->validate([
            'f_name' => 'required',
            'l_name' => 'required',
            'phone' => 'required|unique:users|min:11',
        ], [
            'f_name.required' => translate('first_name_is_required'),
            'l_name.required' => translate('last_name_is_required'),
            'phone.required' => translate('phone_number_is_required'),
            'unique' => translate('phone_number_must_be_unique').'!',
            'phone.min' => translate('phone_number_should_be_minimum_of_11_character')
        ]);

        $user = User::find($request->id);
        $user->f_name = $request->f_name;
        $user->l_name = $request->l_name;
        $user->phone = $request->phone;
        $user->is_active = 1;
        $user->save();

        return redirect(route('customer.auth.check', [$user->id]));
    }

    public static function login_process($user, $email, $user_id)
    {
        $company_name = BusinessSetting::where('type', 'company_name')->first();

        $user = User::where('email', $email)->orWhere('social_id', $user_id)->first();

        if ($user && $user->is_active) {
            auth('customer')->login($user, true);
            session()->regenerate();

            $wish_list = Wishlist::whereHas('wishlistAd', function ($q) {
                return $q;
            })->where('customer_id', $user->id)->pluck('ad_id')->toArray();

            session()->put('wish_list', $wish_list);
            $message = translate('welcome_to') . ' ' . $company_name->value . '!';
            CartManager::cart_to_db();
        } else {
            $message = translate('credentials_are_not_matched_or_your_account_is_not_active') . '!';
        }

        return $message;

    }
    
}

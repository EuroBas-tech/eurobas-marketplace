<?php

namespace App\Http\Controllers\api\v1\auth;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function App\CPU\translate;

class PassportAuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $temporary_token = Str::random(40);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'account_type' => $request->account_type,
            'password' => bcrypt($request->password),
            'is_active' => 1,
            'temporary_token' => $temporary_token,
        ]);

        $phone_verification = Helpers::get_business_settings('phone_verification');
        $email_verification = Helpers::get_business_settings('email_verification');

        if ($phone_verification && !$user->is_phone_verified) {
            return response()->json([
                'temporary_token' => $temporary_token,
                'message' => translate('please_verify_your_phone'),
            ], 200);
        }

        if ($email_verification && !$user->is_email_verified) {
            return response()->json([
                'temporary_token' => $temporary_token,
                'message' => translate('please_verify_your_email'),
            ], 200);
        }

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json([
            'token' => $token,
            'message' => translate('your_account_has_been_created_successfully')
        ], 201);
    }

    public function login(LoginRequest $request)
    {

        $email = $request->email;

        $data = [
            'email' => $email,
            'password' => $request->password
        ];

        $user = User::where('email', $email)->first();

        $max_login_hit = Helpers::get_business_settings('maximum_login_hit') ?? 5;
        $temp_block_time = Helpers::get_business_settings('temporary_login_block_time') ?? 5;

        if (!$user) {
            return response()->json([
                'errors' => [['code' => 'auth-001', 'message' => 'Customer not found or Account suspended']]
            ], 401);
        }

        if (isset($user->temp_block_time) &&
            Carbon::parse($user->temp_block_time)->diffInMinutes() < $temp_block_time
        ) {
            $time = $temp_block_time - Carbon::parse($user->temp_block_time)->diffInMinutes();

            return response()->json([
                'errors' => [['code' => 'auth-001', 'message' => 'Please try again after ' . $time . ' minutes']]
            ], 401);
        }

        // Check verification requirements before attempting login
        $phone_verification = Helpers::get_business_settings('phone_verification');
        $email_verification = Helpers::get_business_settings('email_verification');

        if ($user->is_active && auth()->attempt($data)) {

            if ($phone_verification && !$user->is_phone_verified) {
                $user->temporary_token = Str::random(40);
                $user->save();
                return response()->json([
                    'temporary_token' => $user->temporary_token,
                    'message' => translate('please_verify_your_phone'),
                ], 200);
            }

            if ($email_verification && !$user->is_email_verified) {
                $user->temporary_token = Str::random(40);
                $user->save();
                return response()->json([
                    'temporary_token' => $user->temporary_token,
                    'message' => translate('please_verify_your_email'),
                ], 200);
            }

            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;

            $user->login_hit_count = 0;
            $user->is_temp_blocked = 0;
            $user->temp_block_time = null;
            $user->save();

            return response()->json([
                'token' => $token,
                'message' => translate('login_successful')
            ], 200);
        }

        $user->login_hit_count += 1;

        if ($user->login_hit_count >= $max_login_hit) {
            $user->is_temp_blocked = 1;
            $user->temp_block_time = now();
        }

        $user->save();

        return response()->json([
            'errors' => [['code' => 'auth-001', 'message' => 'Credentials do not match']]
        ], 401);
    }

    public function refresh(Request $request)
    {
        $user = $request->user();

        // Revoke the current token
        $user->token()->revoke();

        // Issue a new token
        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json([
            'token' => $token,
            'message' => translate('token_refreshed_successfully'),
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => translate('logged_out_successfully'),
        ], 200);
    }
}

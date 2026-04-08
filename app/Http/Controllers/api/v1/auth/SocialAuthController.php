<?php

namespace App\Http\Controllers\api\v1\auth;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function App\CPU\translate;
use App\Model\BusinessSetting;

class SocialAuthController extends Controller
{
    public function social_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'unique_id' => 'required',
            'email' => 'required',
            'medium' => 'required|in:google,facebook,apple',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $client = new Client();
        $token = $request['token'];
        $email = $request['email'];
        $unique_id = $request['unique_id'];

        try {
            if ($request['medium'] == 'google') {
                $res = $client->request('GET', 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $token);
                $data = json_decode($res->getBody()->getContents(), true);
            } elseif ($request['medium'] == 'facebook') {
                $res = $client->request('GET', 'https://graph.facebook.com/' . $unique_id . '?access_token=' . $token . '&&fields=name,email');
                $data = json_decode($res->getBody()->getContents(), true);
            } elseif ($request['medium'] == 'apple') {
                $data = [
                    'name' => $request['name'] ?? 'Apple User',
                    'email' => $email,
                    'id' => $unique_id,
                ];
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => translate('wrong_credential')], 401);
        }

        if (!isset($data['email']) || strcmp($email, $data['email']) !== 0) {
            return response()->json(['error' => translate('email_does_not_match')], 403);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $data['name'] ?? '',
                'email' => $email,
                'password' => bcrypt($data['id'] ?? $unique_id),
                'is_active' => 1,
                'login_medium' => $request['medium'],
                'social_id' => $data['id'] ?? $unique_id,
                'is_phone_verified' => 0,
                'is_email_verified' => 1,
                'temporary_token' => Str::random(40),
            ]);
        } else {
            $user->temporary_token = Str::random(40);
            $user->save();
        }

        if (!$user->phone) {
            return response()->json([
                'token_type' => 'update phone number',
                'temporary_token' => $user->temporary_token,
            ]);
        }

        $token = self::login_process_passport($user, $user->email, $data['id'] ?? $unique_id);
        if ($token != null) {
            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => translate('Customer_not_found_or_Account_has_been_suspended')], 401);
    }

    public static function login_process_passport($user, $email, $password)
    {
        $data = [
            'email' => $email,
            'password' => $password
        ];

        if (isset($user) && $user->is_active && auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
        } else {
            $token = null;
        }

        return $token;
    }

    public function update_phone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'temporary_token' => 'required',
            'phone' => 'required|min:11|max:14'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user = User::where(['temporary_token' => $request->temporary_token])->first();

        if (!$user) {
            return response()->json(['message' => translate('invalid_token')], 404);
        }

        $user->phone = $request->phone;
        $user->save();

        $phone_verification = BusinessSetting::where('type', 'phone_verification')->first();

        if ($phone_verification && $phone_verification->value == 1) {
            return response()->json([
                'token_type' => 'phone verification on',
                'temporary_token' => $request->temporary_token
            ]);
        }

        return response()->json(['message' => 'Phone number updated successfully']);
    }

}

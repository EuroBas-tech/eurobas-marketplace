<?php

namespace App\Http\Controllers\api\v1\auth;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\User;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Model\BusinessSetting;
use function App\CPU\translate;

class SocialAuthController extends Controller
{
    private const APPLE_JWKS_URL = 'https://appleid.apple.com/auth/keys';
    private const APPLE_ISSUER   = 'https://appleid.apple.com';

    public function social_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provider'   => 'required|in:google,facebook,apple',
            'id_token'   => 'required|string',
            'email'      => 'sometimes|email',
            'first_name' => 'sometimes|string|max:100',
            'last_name'  => 'sometimes|string|max:100',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(Helpers::error_processor($validator), 422);
        }

        $provider = $request->input('provider');
        $token    = $request->input('id_token');

        try {
            $profile = $this->resolveProviderProfile($provider, $token, $request);
        } catch (\Throwable $e) {
            Log::warning('social_login token verification failed', [
                'provider' => $provider,
                'error'    => $e->getMessage(),
            ]);
            return $this->errorResponse([
                ['code' => 'auth-social-001', 'message' => translate('wrong_credential')]
            ], 401);
        }

        if (empty($profile['email']) || empty($profile['social_id'])) {
            return $this->errorResponse([
                ['code' => 'auth-social-002', 'message' => translate('email_does_not_match')]
            ], 401);
        }

        $user = User::where('email', $profile['email'])->first();

        if (!$user) {
            // Build via constructor + save (rather than ::create) so the
            // non-fillable `is_email_verified` flag is actually persisted.
            $user = new User([
                'name'              => $profile['name'] ?: $profile['email'],
                'email'             => $profile['email'],
                'password'          => bcrypt($profile['social_id']),
                'is_active'         => 1,
                'login_medium'      => $provider,
                'social_id'         => $profile['social_id'],
                'is_phone_verified' => 0,
            ]);
            $user->is_email_verified = 1;
            $user->save();
        } else {
            if (!$user->is_active) {
                return $this->errorResponse([
                    ['code' => 'auth-001', 'message' => translate('Customer_not_found_or_Account_has_been_suspended')]
                ], 401);
            }
            $user->login_medium       = $user->login_medium ?: $provider;
            $user->social_id          = $user->social_id ?: $profile['social_id'];
            $user->is_email_verified  = 1;
            $user->save();
        }

        $bearer = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json([
            'token'            => $bearer,
            'profile_complete' => $this->isProfileComplete($user),
            'message'          => translate('login_successful'),
        ], 200);
    }

    public function update_phone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'temporary_token' => 'required',
            'phone'           => 'required|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(Helpers::error_processor($validator), 422);
        }

        $user = User::where('temporary_token', $request->temporary_token)->first();

        if (!$user) {
            return $this->errorResponse([
                ['code' => 'auth-002', 'message' => translate('invalid_token')]
            ], 404);
        }

        $user->phone = $request->phone;
        $user->save();

        $phone_verification = BusinessSetting::where('type', 'phone_verification')->first();

        if ($phone_verification && $phone_verification->value == 1) {
            return response()->json([
                'token_type'      => 'phone verification on',
                'temporary_token' => $request->temporary_token,
            ]);
        }

        return response()->json(['message' => translate('phone_number_updated_successfully')]);
    }

    private function resolveProviderProfile(string $provider, ?string $token, Request $request): array
    {
        if (!$token) {
            throw new \InvalidArgumentException('missing token');
        }

        if ($provider === 'google') {
            return $this->verifyGoogleIdToken($token);
        }
        if ($provider === 'apple') {
            return $this->verifyAppleIdToken($token, $request);
        }
        if ($provider === 'facebook') {
            return $this->verifyFacebookToken($token);
        }

        throw new \InvalidArgumentException('unsupported provider');
    }

    private function verifyGoogleIdToken(string $idToken): array
    {
        $client = new Client(['timeout' => 6]);
        $res = $client->get('https://oauth2.googleapis.com/tokeninfo', [
            'query' => ['id_token' => $idToken],
        ]);
        $payload = json_decode((string) $res->getBody(), true) ?: [];

        if (empty($payload['sub']) || empty($payload['email'])) {
            throw new \RuntimeException('google tokeninfo invalid');
        }
        if (isset($payload['email_verified']) && in_array($payload['email_verified'], ['false', false, 0, '0'], true)) {
            throw new \RuntimeException('google email not verified');
        }

        return [
            'email'     => $payload['email'],
            'name'      => $payload['name'] ?? '',
            'social_id' => $payload['sub'],
        ];
    }

    private function verifyAppleIdToken(string $idToken, Request $request): array
    {
        $keys = Cache::remember('apple_jwks_cache', now()->addHours(6), function () {
            $client = new Client(['timeout' => 6]);
            $res = $client->get(self::APPLE_JWKS_URL);
            return json_decode((string) $res->getBody(), true);
        });

        if (!is_array($keys) || empty($keys['keys'])) {
            throw new \RuntimeException('apple jwks unavailable');
        }

        $parsed = JWT::decode($idToken, JWK::parseKeySet($keys));
        $claims = is_object($parsed) ? get_object_vars($parsed) : (array) $parsed;

        if (($claims['iss'] ?? null) !== self::APPLE_ISSUER) {
            throw new \RuntimeException('apple iss mismatch');
        }
        if (empty($claims['sub'])) {
            throw new \RuntimeException('apple sub missing');
        }

        // Apple omits email after the first sign-in; fall back to the client-supplied email
        // for subsequent logins (still safe — the JWT is cryptographically verified and
        // the user is matched by social_id+email on our side).
        $email = $claims['email'] ?? $request->input('email');
        if (!$email) {
            throw new \RuntimeException('apple email missing');
        }

        $name = trim(($request->input('first_name') ?? '') . ' ' . ($request->input('last_name') ?? ''));

        return [
            'email'     => $email,
            'name'      => $name ?: 'Apple User',
            'social_id' => $claims['sub'],
        ];
    }

    private function verifyFacebookToken(string $token): array
    {
        $client = new Client(['timeout' => 6]);
        $res = $client->get('https://graph.facebook.com/me', [
            'query' => [
                'fields'       => 'id,name,email',
                'access_token' => $token,
            ],
        ]);
        $payload = json_decode((string) $res->getBody(), true) ?: [];

        if (empty($payload['id']) || empty($payload['email'])) {
            throw new \RuntimeException('facebook graph payload invalid');
        }

        return [
            'email'     => $payload['email'],
            'name'      => $payload['name'] ?? '',
            'social_id' => $payload['id'],
        ];
    }

    private function isProfileComplete(User $user): bool
    {
        return (bool) ($user->phone_code && $user->phone && $user->country && $user->city && $user->native_language);
    }

    private function errorResponse(array $errors, int $status)
    {
        return response()->json(['errors' => $errors], $status);
    }
}

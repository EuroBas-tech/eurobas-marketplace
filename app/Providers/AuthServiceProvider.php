<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        Passport::tokensExpireIn(now()->addDays(7));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addDays(7));

        // If Passport keys are provided via env vars (e.g. AWS Secrets Manager),
        // normalize the PEM content and inject it back into config so Passport
        // uses the key strings directly.
        $privateKey = env('PASSPORT_PRIVATE_KEY');
        $publicKey  = env('PASSPORT_PUBLIC_KEY');

        if ($privateKey && $publicKey) {
            $privateKey = $this->normalizePemKey($privateKey);
            $publicKey  = $this->normalizePemKey($publicKey);

            config([
                'passport.private_key' => $privateKey,
                'passport.public_key'  => $publicKey,
            ]);
        }
    }

    /**
     * Normalize a PEM-encoded key read from an env var. Handles literal "\n"
     * escape sequences, CRLF line endings, and the common failure mode where
     * newlines have been replaced with spaces (e.g. when the key was pasted
     * into a JSON value without proper escaping). Rebuilds the PEM with the
     * standard 64-char body wrapping if the BEGIN/END markers are present.
     */
    protected function normalizePemKey(string $key): string
    {
        $key = str_replace(["\r\n", "\r", '\\n'], ["\n", "\n", "\n"], $key);
        $key = trim($key);

        if (preg_match('/-----BEGIN ([A-Z0-9 ]+)-----(.*?)-----END \1-----/s', $key, $m)) {
            $label = $m[1];
            // Strip every whitespace character from the base64 body, then
            // rewrap at 64 characters per line (RFC 7468).
            $body = preg_replace('/\s+/', '', $m[2]);
            $wrapped = chunk_split($body, 64, "\n");

            return "-----BEGIN {$label}-----\n" . $wrapped . "-----END {$label}-----\n";
        }

        if (substr($key, -1) !== "\n") {
            $key .= "\n";
        }

        return $key;
    }
}

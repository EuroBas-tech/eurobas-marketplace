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

        // If Passport keys are provided via env vars (e.g. AWS Secrets Manager),
        // normalize the PEM content and inject it back into config so Passport
        // uses the key strings directly. This avoids both the filesystem
        // permission issues of writing files at runtime and the "Invalid key
        // supplied" errors caused by escaped \n or CRLF line endings in the
        // raw env var value.
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
     * Normalize a PEM-encoded key read from an env var: convert literal "\n"
     * escapes and CRLF into real newlines, and ensure a trailing newline.
     */
    protected function normalizePemKey(string $key): string
    {
        $key = str_replace(["\r\n", "\r", '\\n'], ["\n", "\n", "\n"], $key);

        if (substr($key, -1) !== "\n") {
            $key .= "\n";
        }

        return $key;
    }
}

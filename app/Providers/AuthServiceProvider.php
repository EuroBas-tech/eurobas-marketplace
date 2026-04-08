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
        // normalize and materialize them to storage so Passport can load them
        // from file. We then clear passport.*_key config so Passport's default
        // config (which reads env directly) falls through to the file loader.
        $privateKey = env('PASSPORT_PRIVATE_KEY');
        $publicKey  = env('PASSPORT_PUBLIC_KEY');

        if ($privateKey && $publicKey) {
            // Handle literal "\n" escape sequences and CRLF line endings.
            $privateKey = str_replace(["\r\n", "\r", '\\n'], ["\n", "\n", "\n"], $privateKey);
            $publicKey  = str_replace(["\r\n", "\r", '\\n'], ["\n", "\n", "\n"], $publicKey);

            // Ensure trailing newline (PEM parsers require it).
            if (substr($privateKey, -1) !== "\n") {
                $privateKey .= "\n";
            }
            if (substr($publicKey, -1) !== "\n") {
                $publicKey .= "\n";
            }

            $privatePath = storage_path('oauth-private.key');
            $publicPath  = storage_path('oauth-public.key');

            // Only write if missing or content differs, to avoid unnecessary
            // I/O on every request. No chmod: Passport disables the strict
            // key-permission check, and chmod fails when the existing file is
            // owned by a different user (e.g. baked into the image as root).
            if (!file_exists($privatePath) || file_get_contents($privatePath) !== $privateKey) {
                file_put_contents($privatePath, $privateKey);
            }
            if (!file_exists($publicPath) || file_get_contents($publicPath) !== $publicKey) {
                file_put_contents($publicPath, $publicKey);
            }

            // Force Passport to use the files we just wrote instead of the
            // raw env-var strings.
            config(['passport.private_key' => null, 'passport.public_key' => null]);
        }

        Passport::loadKeysFrom(storage_path());
    }
}

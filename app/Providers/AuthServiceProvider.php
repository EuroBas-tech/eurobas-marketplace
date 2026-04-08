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
        // materialize them to storage so Passport can load them normally.
        $privateKey = env('PASSPORT_PRIVATE_KEY');
        $publicKey  = env('PASSPORT_PUBLIC_KEY');

        if ($privateKey && $publicKey) {
            $privatePath = storage_path('oauth-private.key');
            $publicPath  = storage_path('oauth-public.key');

            if (!file_exists($privatePath)) {
                file_put_contents($privatePath, $privateKey);
                chmod($privatePath, 0600);
            }
            if (!file_exists($publicPath)) {
                file_put_contents($publicPath, $publicKey);
                chmod($publicPath, 0600);
            }
        }

        Passport::loadKeysFrom(storage_path());
    }
}

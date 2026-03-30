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

        // Check if keys are provided via environment variables (AWS Secrets Manager)
        $hasKeys = (config('passport.private_key') || env('PASSPORT_PRIVATE_KEY')) && 
                   (config('passport.public_key') || env('PASSPORT_PUBLIC_KEY'));

        if (!$hasKeys) {
            // Only attempt to load from storage files if keys are NOT in environment variables
            Passport::loadKeysFrom(storage_path());
        }
    }
}

<?php

if (!function_exists('theme_asset')) {
    function theme_asset($path = null): string
    {
        $theme_name = 'theme_aster';
        return asset("resources/themes/$theme_name/public/$path");
    }
}

if (!function_exists('theme_root_path')) {
    function theme_root_path(): string
    {
        $theme_name = 'theme_aster';
        return $theme_name;
    }
}


if (!function_exists('asset')) {
    function asset($path, $secure = null)
    {
        // Force asset() to point from root instead of public/
        return app('url')->asset($path, $secure);
    }
}

if (!function_exists('cloudfront')) {
    function cloudfront($path)
    {
        $cdnUrl = config('filesystems.disks.s3.url', env('CLOUDFRONT_URL'));
        $cdnUrl = rtrim($cdnUrl, '/');
        $path = ltrim($path, '/');

        return "{$cdnUrl}/{$path}";
    }
}

if (!function_exists('env_asset')) {
    function env_asset($path)
    {
        $base = app()->environment('local') ? '' : 'public/';
        return asset($base . $path);
    }
}

if (! function_exists('cdn_image')) {
    function cdn_image($path)
    {
        $cdnUrl = env('CDN_IMAGE_URL', null);
        return $cdnUrl ? rtrim($cdnUrl, '/') . '/' . ltrim($path, '/') : asset($path);
    }
}

/**
 * True on a local `.test` development host — used to bypass reCAPTCHA so the
 * site can be tested locally without a captcha challenge.
 */
if (! function_exists('is_local_test_host')) {
    function is_local_test_host(): bool
    {
        try {
            $host = request()->getHost();
        } catch (\Throwable $e) {
            return false;
        }
        return $host && \Illuminate\Support\Str::endsWith($host, '.test');
    }
}

/**
 * Whether reCAPTCHA should actually be rendered/validated: enabled in business
 * settings AND not on a local `.test` host.
 */
if (! function_exists('recaptcha_enabled')) {
    function recaptcha_enabled(): bool
    {
        $recaptcha = \App\CPU\Helpers::get_business_settings('recaptcha');
        $on = isset($recaptcha['status']) && $recaptcha['status'] == 1;
        return $on && ! is_local_test_host();
    }
}


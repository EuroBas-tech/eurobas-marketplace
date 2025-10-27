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

if (!function_exists('env_asset')) {
    function env_asset($path)
    {
        $base = app()->environment('local') ? '' : 'public/';
        return asset($base . $path);
    }
}



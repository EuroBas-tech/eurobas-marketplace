<?php

use App\CPU\Helpers;
use App\Model\LanguageTranslation;
use Illuminate\Support\Facades\Cache;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

if(!function_exists('translate')) {
    function translate($key)
    {
        $locale = LaravelLocalization::getCurrentLocale();

        // try {
            // $cacheKey = "translations_{$locale}";
            
            // // Get all translations for locale from cache, or load from DB
            // $translations = Cache::rememberForever($cacheKey, function () use ($locale) {
            //     return LanguageTranslation::where('locale', $locale)
            //     ->pluck('value', 'key')
            //     ->toArray();
            // });

            // $processedKey = ucfirst(str_replace('_', ' ', Helpers::remove_invalid_charcaters($key)));
            // $key = Helpers::remove_invalid_charcaters($key);
            
            // // If key doesn't exist, create it
            // if (!isset($translations[$key])) {
            //     LanguageTranslation::create([
            //         'key' => $key,
            //         'value' => $processedKey,
            //         'locale' => $locale
            //     ]);
                
            //     // Clear cache to refresh
            //     Cache::forget($cacheKey);
                
            //     $result = $processedKey;
            // } else {
            //     $result = $translations[$key];
            // }
        // } catch (\Exception $exception) {
        //     $result = $key;
        // }

        return $key;
    }
}

function getSeoTitle() {
    $seoArray = include(resource_path('lang/' . LaravelLocalization::getCurrentLocale() . '/Seo.php'));
    return $seoArray['meta_title'];
}

function getSeoDescription() {
    $seoArray = include(resource_path('lang/' . LaravelLocalization::getCurrentLocale() . '/Seo.php'));
    return $seoArray['meta_description'];
}


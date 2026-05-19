<?php

use App\CPU\Helpers;
use App\Model\LanguageTranslation;
use Illuminate\Support\Facades\Cache;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

if(!function_exists('translate')) {
    function translate($key)
    {
        static $staticTranslations = [];

        $locale = LaravelLocalization::getCurrentLocale();
        $cacheKey = "translations_{$locale}";

        try {
            if (!isset($staticTranslations[$locale])) {
                $translations = Cache::get($cacheKey);

                if (!$translations) {
                    $translations = LanguageTranslation::where('locale', $locale)
                        ->pluck('value', 'key')
                        ->toArray();
                    
                  Cache::store('file')->forever($cacheKey, $translations);
                     
                }

                $staticTranslations[$locale] = $translations;
            }

            $translations = $staticTranslations[$locale];
            $cleanKey = Helpers::remove_invalid_charcaters($key);

            if (!isset($translations[$cleanKey])) {
                $processedValue = ucfirst(str_replace('_', ' ', $cleanKey));

                LanguageTranslation::updateOrCreate(
                    [
                        'key' => $cleanKey,
                        'locale' => $locale
                    ],
                    [
                        'value' => $processedValue
                    ]
                );

                $staticTranslations[$locale][$cleanKey] = $processedValue;
               
                 Cache::store('file')->forever(
                 $cacheKey,
                 $staticTranslations[$locale]        
                
                );

                return $processedValue;
            }

            return $translations[$cleanKey];

        } catch (\Throwable $exception) {
            return ucfirst(str_replace('_', ' ', $key));
        }
    }
}

if(!function_exists('getSeoTitle')) {
    function getSeoTitle() {
        return Cache::rememberForever('seo_title_' . LaravelLocalization::getCurrentLocale(), function() {
            $path = resource_path('lang/' . LaravelLocalization::getCurrentLocale() . '/Seo.php');
            $seoArray = file_exists($path) ? include($path) : [];
            return $seoArray['meta_title'] ?? 'EuroBas';
        });
    }
}

if(!function_exists('getSeoDescription')) {
    function getSeoDescription() {
        return Cache::rememberForever('seo_desc_' . LaravelLocalization::getCurrentLocale(), function() {
            $path = resource_path('lang/' . LaravelLocalization::getCurrentLocale() . '/Seo.php');
            $seoArray = file_exists($path) ? include($path) : [];
            return $seoArray['meta_description'] ?? '';
        });
    }
}

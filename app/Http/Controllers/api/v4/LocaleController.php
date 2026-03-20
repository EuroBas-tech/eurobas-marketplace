<?php

namespace App\Http\Controllers\api\v4;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Model\LanguageTranslation;

class LocaleController extends Controller
{

    public function translations(string $locale)
    {
        try {
            $cacheKey = "translations_{$locale}";

            $translations = Cache::rememberForever($cacheKey, function () use ($locale) {
                return LanguageTranslation::where('locale', $locale)
                ->pluck('value', 'key')
                ->toArray();
            });

            return response()->json([
                'locale' => $locale,
                'translations' => $translations
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'locale' => $locale,
                'translations' => []
            ], 500);
        }
    }


}

<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Model\LanguageTranslation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

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

            $version = $this->fetchVersion($locale);

            return response()->json([
                'locale'       => $locale,
                'version'      => $version,
                'translations' => (object) $translations,
            ])->header('X-Translations-Version', $version);
        } catch (\Throwable $e) {
            return response()->json([
                'locale'       => $locale,
                'version'      => null,
                'translations' => (object) [],
                'errors'       => [['code' => 'locale-001', 'message' => 'translations_unavailable']],
            ], 500);
        }
    }

    public function version(string $locale)
    {
        try {
            return response()->json([
                'locale'  => $locale,
                'version' => $this->fetchVersion($locale),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'locale'  => $locale,
                'version' => null,
            ], 500);
        }
    }

    private function fetchVersion(string $locale): ?string
    {
        return Cache::remember("translations_version_{$locale}", now()->addMinutes(5), function () use ($locale) {
            $latest = LanguageTranslation::where('locale', $locale)->max('updated_at');
            return $latest ? (string) \Illuminate\Support\Carbon::parse($latest)->timestamp : null;
        });
    }
}

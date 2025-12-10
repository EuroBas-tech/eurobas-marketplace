 <?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SiteMapController extends Controller
{
    // اللغات المتوفرة في الموقع
    private $locales = [
        '',        // English (default, without prefix)
        'nl', 'de', 'tr', 'es', 'it', 'ru', 'fr', 'ar',
        'el', 'pl', 'ro', 'uk', 'bg', 'pt', 'sr', 'da',
        'sv', 'fi', 'no', 'hr', 'hu', 'cs', 'sq', 'bs',
        'lt', 'sl', 'sk', 'zh-Hans', 'ko', 'ja'
    ];

    public function index()
    {
        return view('admin-views.site-map.view');
    }

    public function download()
    {
        $sitemap = Sitemap::create();

        // جميع المسارات المسجلة في laravel
        foreach (Route::getRoutes() as $route) {

            $uri = $route->uri();

            // تجاهل مسارات لوحة التحكم + api + debug
            if (
                str_starts_with($uri, 'admin') ||
                str_starts_with($uri, 'api') ||
                str_contains($uri, 'logout') ||
                str_contains($uri, '_debugbar')
            ) {
                continue;
            }

            foreach ($this->locales as $locale) {

                $prefix = $locale === '' ? '' : "/$locale";

                $fullUrl = url($prefix . '/' . ltrim($uri, '/'));

                $tag = Url::create($fullUrl)
                    ->setLastModificationDate(now())
                    ->setPriority(0.8);

                // إضافة hreflang لكل لغة
                foreach ($this->locales as $altLocale) {
                    $altPrefix = $altLocale === '' ? '' : "/$altLocale";
                    $tag->addAlternate(url($altPrefix . '/' . ltrim($uri, '/')), $altLocale ?: 'en');
                }

                $sitemap->add($tag);
            }
        }

        // حفظ الملف
        $sitemap->writeToFile(public_path('sitemap.xml'));

        return response()->download(public_path('sitemap.xml'));
    }
}

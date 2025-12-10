<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SiteMapController extends Controller
{
    // جميع اللغات + '' للإنجليزية بدون رمز
    private $locales = [
        '',        // English (default, no prefix)
        'nl','de','tr','es','it','ru','fr','ar',
        'el','pl','ro','uk','bg','pt','sr','da',
        'sv','fi','no','hr','hu','cs','sq','bs',
        'lt','sl','sk','zh-Hans','ko','ja'
    ];

    public function index()
    {
        return view('admin-views.site-map.view');
    }

    public function download()
    {
        // إنشاء خريطة جديدة
        $sitemap = Sitemap::create();

        // جميع مسارات Laravel
        foreach (Route::getRoutes() as $route) {

            $uri = $route->uri();

            // حذف مسارات غير مهمة مثل api + debug
            if (
                str_starts_with($uri, 'api') ||
                str_contains($uri, '_ignition') ||
                str_contains($uri, 'telescope') ||
                str_contains($uri, 'sanctum')
            ) {
                continue;
            }

            // لكل لغة
            foreach ($this->locales as $locale) {

                // الإنكليزية بدون رمز
                if ($locale === '') {
                    $fullUrl = url($uri);
                } else {
                    $fullUrl = url("$locale/$uri");
                }

                // إضافة الرابط إلى الخريطة
                $sitemap->add(
                    Url::create($fullUrl)
                        ->setPriority(0.8)
                        ->setChangeFrequency('daily')
                );
            }
        }

        // حفظ الخريطة
        $sitemap->writeToFile(public_path('sitemap.xml'));

        // تنزيل الملف
        return response()->download(public_path('sitemap.xml'));
    }
}

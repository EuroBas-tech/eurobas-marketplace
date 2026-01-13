<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use Illuminate\Http\Request;
use App\Model\BusinessSetting;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use App\Model\LanguageTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;
use function App\CPU\auto_translator;
use function App\CPU\getLanguageCode;
use Illuminate\Support\Facades\Cache;

class LanguageController extends Controller
{

    public function index()
    {
        return view('admin-views.business-settings.language.index');
    }

    public function index_app()
    {
        return view('admin-views.business-settings.language.index-app');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Language is required!',
        ]);

        $language = BusinessSetting::where('type', 'language')->first();
        $lang_array = [];
        $codes = [];
        foreach (json_decode($language['value'], true) as $key => $data) {
            if ($data['code'] != $request['code']) {
                if (!array_key_exists('default', $data)) {
                    $default = array('default' => ($data['code'] == 'en') ? true : false);
                    $data = array_merge($data, $default);
                }
                array_push($lang_array, $data);
                array_push($codes, $data['code']);
            }
        }
        array_push($codes, $request['code']);

        if (!file_exists(base_path('resources/lang/' . $request['code']))) {
            mkdir(base_path('resources/lang/' . $request['code']), 0777, true);
        }

        $lang_file = fopen(base_path('resources/lang/' . $request['code'] . '/' . 'messages.php'), "w") or die("Unable to open file!");
        $read = file_get_contents(base_path('resources/lang/en/messages.php'));
        fwrite($lang_file, $read);

        $lang_array[] = [
            'id' => count(json_decode($language['value'], true)) + 1,
            'name' => $request['name'],
            'code' => $request['code'],
            'direction' => $request['direction'],
            'status' => 0,
            'default' => false,
        ];

        BusinessSetting::updateOrInsert(['type' => 'language'], [
            'value' => $lang_array
        ]);

        DB::table('business_settings')->updateOrInsert(['type' => 'pnc_language'], [
            'value' => json_encode($codes),
        ]);

        Cache::forget('business_settings');
        Cache::forget('business_setting_language');
        Cache::forget('language');
        Cache::flush();

        Toastr::success(translate('Language_Added'));
        return back();
    }

    public function update_status(Request $request)
    {
        $language = BusinessSetting::where('type', 'language')->first();
        $lang_array = [];
        foreach (json_decode($language['value'], true) as $key => $data) {
            if ($data['code'] == $request['code']) {
                $lang = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => $data['status'] == 1 ? 0 : 1,
                    'default' => (array_key_exists('default', $data) ? $data['default'] : (($data['code'] == 'en') ? true : false)),
                ];
                $lang_array[] = $lang;
            } else {
                $lang = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => $data['status'],
                    'default' => (array_key_exists('default', $data) ? $data['default'] : (($data['code'] == 'en') ? true : false)),
                ];
                $lang_array[] = $lang;
            }
        }
        $businessSetting = BusinessSetting::where('type', 'language')->update([
            'value' => $lang_array
        ]);

        Cache::forget('business_settings');
        Cache::forget('business_setting_language');
        Cache::forget('language');
        Cache::flush();

        return $businessSetting;
    }

    public function update_default_status(Request $request)
    {
        $language = BusinessSetting::where('type', 'language')->first();
        $lang_array = [];
        foreach (json_decode($language['value'], true) as $key => $data) {
            if ($data['code'] == $request['code']) {
                $lang = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => 1,
                    'default' => true,
                ];
                $lang_array[] = $lang;
            } else {
                $lang = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => $data['status'],
                    'default' => false,
                ];
                $lang_array[] = $lang;
            }
        }
        BusinessSetting::where('type', 'language')->update([
            'value' => $lang_array
        ]);

        Cache::forget('business_settings');
        Cache::forget('business_setting_language');
        Cache::forget('language');
        Cache::flush();

        Toastr::success(translate('Default_Language_Changed'));
        return back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Language is required!',
        ]);

        $language = BusinessSetting::where('type', 'language')->first();
        $lang_array = [];
        foreach (json_decode($language['value'], true) as $key => $data) {
            if ($data['code'] == $request['code']) {
                $lang = [
                    'id' => $data['id'],
                    'name' => $request['name'],
                    'direction' => $request['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => 0,
                    'default' => (array_key_exists('default', $data) ? $data['default'] : (($data['code'] == 'en') ? true : false)),
                ];
                $lang_array[] = $lang;
            } else {
                $lang = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => $data['status'],
                    'default' => (array_key_exists('default', $data) ? $data['default'] : (($data['code'] == 'en') ? true : false)),
                ];
                $lang_array[] = $lang;
            }
        }
        BusinessSetting::where('type', 'language')->update([
            'value' => $lang_array
        ]);

        Cache::forget('business_settings');
        Cache::forget('business_setting_language');
        Cache::forget('language');
        Cache::flush();

        Toastr::success(translate('Language_updated'));
        return back();
    }

    public function translate($lang)
    {
        return view('admin-views.business-settings.language.translate', compact('lang'));
    }

    public function translate_list($lang)
    {
        $data = [];

        $data = LanguageTranslation::where('locale', $lang)
        ->orderBy('key')
        ->get(['id', 'key', 'value'])
        ->toArray();

        return response()->json($data);

    }

    public function translate_key_remove(Request $request, $lang)
    {
        $full_data = include(base_path('resources/lang/' . $lang . '/messages.php'));
        unset($full_data[$request['key']]);
        $str = "<?php return " . var_export($full_data, true) . ";";
        file_put_contents(base_path('resources/lang/' . $lang . '/messages.php'), $str);
    }

    public function translate_submit(Request $request, $lang)
    {
        $word = LanguageTranslation::where('id', $request['id'])
        ->update(['value' => $request['value']]);

        Cache::flush();
        
        $this->updateCacheTranslations();
        
        return $word;

    }

    public function auto_translate(Request $request, $lang): \Illuminate\Http\JsonResponse
    {
        $lang_code = getLanguageCode($lang);
        $full_data = include(base_path('resources/lang/' . $lang . '/messages.php'));
        $data_filtered = [];

        foreach ($full_data as $key => $data) {
            $data_filtered[Helpers::remove_invalid_charcaters($key)] = $data;
        }

        $translated = auto_translator($request['key'], 'en', $lang_code);
        $data_filtered[$request['key']] = $translated;

        $str = "<?php return " . var_export($data_filtered, true) . ";";
        file_put_contents(base_path('resources/lang/' . $lang . '/messages.php'), $str);

        return response()->json([
            'translated_data' => $translated
        ]);
    }

    public function delete($lang)
    {
        $language = BusinessSetting::where('type', 'language')->first();

        $del_default = false;
        foreach (json_decode($language['value'], true) as $key => $data) {
            if ($data['code'] == $lang && array_key_exists('default', $data) && $data['default'] == true) {
                $del_default = true;
            }
        }

        $lang_array = [];
        foreach (json_decode($language['value'], true) as $key => $data) {
            if ($data['code'] != $lang) {
                $lang_data = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => ($del_default == true && $data['code'] == 'en') ? 1 : $data['status'],
                    'default' => ($del_default == true && $data['code'] == 'en') ? true : (array_key_exists('default', $data) ? $data['default'] : (($data['code'] == 'en') ? true : false)),
                ];
                array_push($lang_array, $lang_data);
            }
        }

        BusinessSetting::where('type', 'language')->update([
            'value' => $lang_array
        ]);

        $dir = base_path('resources/lang/' . $lang);
        if (File::isDirectory($dir)) {
            $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $file) {
                if ($file->isDir()) {
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            rmdir($dir);
        }

        $languages = array();
        $pnc_language = BusinessSetting::where('type', 'pnc_language')->first();
        foreach (json_decode($pnc_language['value'], true) as $key => $data) {
            if ($data != $lang) {
                array_push($languages, $data);
            }
        }
        if (in_array('en', $languages)) {
            unset($languages[array_search('en', $languages)]);
        }
        array_unshift($languages, 'en');

        DB::table('business_settings')->updateOrInsert(['type' => 'pnc_language'], [
            'value' => json_encode($languages),
        ]);

        Cache::forget('business_settings');
        Cache::forget('business_setting_language');
        Cache::forget('language');
        Cache::flush();

        Toastr::success(translate('Removed_Successfully'));
        return back();
    }

    public function updateCacheTranslations() {
        try {
            $locales = array_keys(config('laravellocalization.supportedLocales'));      
            $cachedLocales = [];
            
            foreach ($locales as $localeCode) {
                $cacheKey = "translations_{$localeCode}";
                
                // Load and cache translations for this locale
                $translations = LanguageTranslation::where('locale', $localeCode)
                    ->pluck('value', 'key')
                    ->toArray();
                
                Cache::forever($cacheKey, $translations);
                
                $cachedLocales[] = $localeCode;
            }  
        } catch (\Exception $e) {
            Log::debug([
                'success' => false,
                'message' => 'Error caching translations',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function clearAllCache() {
        Cache::flush();
        Toastr::success(translate('System_cache_cleared_successfully'));
        return back();

    }

}

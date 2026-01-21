<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;
use App\Model\Seller;
use App\CPU\ImageManager;
use Illuminate\Http\Request;
use App\Model\BusinessSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class SharedController extends Controller
{
    public function lang($local)
    {
        $direction = 'ltr';

        $language = BusinessSetting::where('type', 'language')->first();

        foreach (json_decode($language['value'], true) as $key => $data) {
            if ($data['code'] == $local) {
                $direction = isset($data['direction']) ? $data['direction'] : 'ltr';
            }
        }

        session()->forget('language_settings');
        Helpers::language_load();
        session()->put('local', $local);
        Session::put('direction', $direction);
        
        $previousUrl = url()->previous();
        $previousRequest = Request::create($previousUrl);

        Cache::forget('language');
        Cache::forget('business_setting_language');
        Cache::forget('home_categories');
        Cache::forget('categories');
        Cache::flush();

        try {
            $previousRoute = app('router')->getRoutes()->match($previousRequest);

            if (in_array('POST', $previousRoute->methods())) {
                return redirect('/');
            }
        } catch (MethodNotAllowedHttpException $e) {
            // The previous route only supports POST
            return redirect('/');
        }

        return redirect()->back();

    }
    
}

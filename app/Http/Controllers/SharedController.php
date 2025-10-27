<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;
use App\Model\Seller;
use App\CPU\ImageManager;
use App\Model\BusinessSetting;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

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

        $get_previous_page = explode('/', parse_url(url()->previous(), PHP_URL_PATH));
        $user_type = $get_previous_page[1];

        if($user_type == 'seller') {
            $seller = Seller::find(auth('seller')->id());

            if ($seller) {
                $seller->prefered_language = $local;
                $seller->save();
            }

        }

        session()->forget('language_settings');
        Helpers::language_load();
        session()->put('local', $local);
        Session::put('direction', $direction);
        
        $previousUrl = url()->previous();
        $previousRequest = Request::create($previousUrl);

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

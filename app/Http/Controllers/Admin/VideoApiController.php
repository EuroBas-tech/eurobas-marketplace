<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Model\Setting;
use App\Model\Currency;
use App\Traits\Processor;
use Illuminate\Http\Request;
use App\Model\BusinessSetting;
use function App\CPU\translate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class VideoApiController extends Controller
{
    use Processor;

    public function index()
    {
        $mux_api_token = BusinessSetting::where('type', 'mux_api_token')->value('value');
        $mux_secret_key = BusinessSetting::where('type', 'mux_secret_key')->value('value');

        return view('admin-views.business-settings.video-api.index',
        compact('mux_api_token', 'mux_secret_key'));

    }

    public function update(Request $request)
    {

        BusinessSetting::updateOrInsert(['type' => 'mux_api_token'], [
            'value' => $request->mux_api_token,
            'updated_at' => now()
        ]);
        
        BusinessSetting::updateOrInsert(['type' => 'mux_secret_key'], [
            'value' => $request->mux_secret_key,
            'updated_at' => now()
        ]);

        Cache::forget('business_settings');

        Toastr::success(translate('video_api_data_successfully_updated'));
        return back();
    }

}

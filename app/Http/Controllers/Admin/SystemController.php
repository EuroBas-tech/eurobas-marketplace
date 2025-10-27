<?php

namespace App\Http\Controllers\Admin;

use App\Model\OrderDetail;
use Illuminate\Http\Request;
use App\Model\SearchFunction;
use App\Model\BusinessSetting;
use App\Model\WithdrawRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class SystemController extends Controller
{

    //data import into search_function table
    public function importSearchFunctionData(){
        $jsonSidebarData = file_get_contents(storage_path('data/sidebar-search.json'));
        $datas = json_decode($jsonSidebarData, True);

        SearchFunction::truncate();
        foreach($datas as $data){
            SearchFunction::create($data);
        }

        dd('success');
    }

    public function maintenance_mode()
    {
        $maintenance_mode = BusinessSetting::where('type', 'maintenance_mode')->first();

        if (isset($maintenance_mode) == false) {
            DB::table('business_settings')->insert([
                'type' => 'maintenance_mode',
                'value' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            DB::table('business_settings')->where(['type' => 'maintenance_mode'])->update([
                'type' => 'maintenance_mode',
                'value' => $maintenance_mode->value == 1 ? 0 : 1,
                'updated_at' => now(),
            ]);
        }

        Cache::forget('business_settings');

        if (isset($maintenance_mode) && $maintenance_mode->value){
            return response()->json(['message'=>'Maintenance is off.']);
        }
        
        return response()->json(['message'=>'Maintenance is on.']);
    }

    public function order_data()
    {
        $new_order = DB::table('orders')
        ->where(['order_status' => 'pending'])
        ->where(['checked' => 0])
        ->count();
        return response()->json([
            'success' => 1,
            'data' => ['new_order' => $new_order]
        ]);
    }

    public function get_refund_requests()
    {
        $refund_requests = DB::table('refund_requests')
        ->where('admin_checked', 0)
        ->count();

        return response()->json([
            'success' => 1,
            'data' => ['refund_requests' => $refund_requests]
        ]);
    }

}

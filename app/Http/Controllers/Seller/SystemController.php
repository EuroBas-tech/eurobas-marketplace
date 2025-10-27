<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Model\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    public function order_data()
    {
        $sellerId = auth('seller')->id();

        $new_order = DB::table('orders')->where(['seller_is' => 'seller'])
        ->where(['seller_id' => $sellerId])
        ->where(['order_status' => 'pending'])
        ->where(['checked' => 0])->count();
        return response()->json([
            'success' => 1,
            'data' => ['new_order' => $new_order]
        ]);
    }

    public function get_canceled_orders()
    {
        $sellerId = auth('seller')->id();

        $canceled_orders = DB::table('orders')
        ->where(['seller_is' => 'seller'])
        ->where(['seller_id' => $sellerId])
        ->where(['order_status' => 'canceled'])
        ->where(['checked' => 0])->count();

        return response()->json([
            'success' => 1,
            'data' => ['canceled_orders' => $canceled_orders]
        ]);
    }
    
    public function receive_response()
    {
        $sellerId = auth('seller')->id();

        $receive_response = DB::table('withdraw_requests')
        ->where(['seller_id' => $sellerId])
        ->whereIn('approved', [1, 2])
        ->where(['seller_checked' => 0])
        ->count();

        return response()->json([
            'success' => 1,
            'data' => ['receive_response' => $receive_response]
        ]);
    }
    
    public function get_balance_transactions()
    {
        $sellerId = auth('seller')->id();

        $balance_transactions = DB::table('sellers_balance_transactions')
        ->where('seller_id', $sellerId)
        ->where('seller_checked', 0)
        ->count();

        return response()->json([
            'success' => 1,
            'data' => ['balance_transactions' => $balance_transactions]
        ]);
    }
    
    public function get_refund_requests()
    {
        $sellerId = auth('seller')->id();

        $refund_requests = DB::table('refund_requests')
        ->join('orders', 'refund_requests.order_id', '=', 'orders.id')
        ->where('orders.seller_id', $sellerId)
        ->where('seller_checked', 0)
        ->count();

        return response()->json([
            'success' => 1,
            'data' => ['refund_requests' => $refund_requests]
        ]);
    }

}

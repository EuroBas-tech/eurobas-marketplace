<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\CPU\Convert;
use App\CPU\Helpers;
use App\Model\Order;
use App\Model\Seller;
use App\Model\AdminWallet;
use App\Model\OrderDetail;
use App\Model\SellerWallet;
use App\CPU\CustomerManager;
use App\Model\RefundRequest;
use Illuminate\Http\Request;
use function App\CPU\translate;
Use App\Model\RefundStatus;
use App\Model\AdminWalletAction;
use App\Model\RefundTransaction;
use App\Model\SellerWalletAction;
use App\Model\SellerPayoutHistory;
use Illuminate\Support\Facades\DB;
use App\Exports\RefundRequestExport;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\RefundAcceptedResponseMail;
use App\Mail\RefundRejectedResponseMail;
use App\Model\PaymentRequest;
use App\Services\StripePayment;
use App\CPU\BackEndHelper;

class RefundController extends Controller
{
    public function list(Request $request, $status)
    {
        $search = $request->search;
        if (session()->has('show_inhouse_orders') && session('show_inhouse_orders') == 1) {
            $refund_list = RefundRequest::whereHas('order', function ($query) {
                $query->where('seller_is', 'admin');
            });
        }else if (session()->has('show_seller_orders') && session('show_seller_orders') == 1) {
            $refund_list = RefundRequest::whereHas('order', function ($query) {
                $query->where('seller_is', 'seller');
            });
        }else{
            $refund_list = new RefundRequest;
        }

        $refund_requests = DB::table('refund_requests')
        ->where(['admin_checked' => 0])
        ->update(['admin_checked' => 1]);

        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $refund_list = $refund_list->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('order_id', 'like', "%{$value}%")
                        ->orWhere('id', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }
        $refund_list = $refund_list->where('status',$status)->latest()->paginate(Helpers::pagination_limit());

        return view('admin-views.refund.list',compact('refund_list','search'));
    }
    public function details($id)
    {
        $refund = RefundRequest::find($id);

        return view('admin-views.refund.details',compact('refund'));
    }
    
    public function refund_status_update(Request $request)
    {
        $refund = RefundRequest::find($request->id);
        $user = User::find($refund->customer_id);

        if(!isset($user))
        {
            Toastr::warning(translate('this_account_has_been_deleted_you_can_not_modify_the_status'));
            return back();
        }

        $wallet_status = Helpers::get_business_settings('wallet_status');
        $loyalty_point_status = Helpers::get_business_settings('loyalty_point_status');
        $loyalty_point = CustomerManager::count_loyalty_point_for_amount($refund->order_details_id);

        if( $loyalty_point_status == 1)
        {

            if($user->loyalty_point < $loyalty_point && ($request->refund_status == 'refunded' || $request->refund_status == 'approved'))
            {
                Toastr::warning(translate('customer_has_not_sufficient_loyalty_point_to_take_refund_for_this_order'));
                return back();
            }
        }
        $order = Order::find($refund->order_id);
        if($request->refund_status == 'refunded' && $refund->status != 'refunded')
        {

            if($order->seller_is == 'admin')
            {
                $admin_wallet = AdminWallet::where('admin_id',$order->seller_id)->first();
                $admin_wallet->inhouse_earning = $admin_wallet->inhouse_earning - $refund->amount;
                $admin_wallet->save();

                $transaction = new RefundTransaction;
                $transaction->order_id = $refund->order_id;
                $transaction->payment_for = 'Refund Request';
                $transaction->payer_id = $order->seller_id;
                $transaction->payment_receiver_id = $refund->customer_id;
                $transaction->paid_by = $order->seller_is;
                $transaction->paid_to = 'customer';
                $transaction->payment_method = $request->payment_method;
                $transaction->payment_status = $request->payment_method !=null?'paid':'unpaid';
                $transaction->amount = $refund->amount;
                $transaction->transaction_type = 'Refund';
                $transaction->order_details_id = $refund->order_details_id;
                $transaction->refund_id = $refund->id;
                $transaction->save();

            }else{

                $transaction = new RefundTransaction;
                $transaction->order_id = $refund->order_id;
                $transaction->payment_for = 'Refund Request';
                $transaction->payer_id = $order->seller_id;
                $transaction->payment_receiver_id = $refund->customer_id;
                $transaction->paid_by = $order->seller_is;
                $transaction->paid_to = 'customer';
                $transaction->payment_method = $request->payment_method;
                $transaction->payment_status = $request->payment_method !=null?'paid':'unpaid';
                $transaction->amount = $refund->amount;
                $transaction->transaction_type = 'Refund';
                $transaction->order_details_id = $refund->order_details_id;
                $transaction->refund_id = $refund->id;
                $transaction->save();
            }


        }
        if($refund->status != 'refunded')
        {
            $order_details = OrderDetail::find($refund->order_details_id);

            $refund_status = new RefundStatus;
            $refund_status->refund_request_id = $refund->id;
            $refund_status->change_by = 'admin';
            $refund_status->change_by_id = auth('admin')->id();
            $refund_status->status = $request->refund_status;

            if($request->refund_status == 'pending')
            {
                $order_details->refund_request = 1;
            }
            elseif($request->refund_status == 'approved')
            {
                $order_details->refund_request = 2;
                $refund->approved_note = $request->approved_note;

                $refund_status->message = $request->approved_note;

            }
            elseif($request->refund_status == 'received')
            {
                $order_details->refund_request = 5;
            }
            elseif($request->refund_status == 'rejected')
            {
                $order_details->refund_request = 3;
                $refund->rejected_note = $request->rejected_note;

                $refund_status->message = $request->rejected_note;

                $order_wallet_action = SellerWalletAction::with('seller')
                ->where('order_id', $order->id)
                ->get()
                ->first();

                $order_wallet_action->is_suspended = 0;
        
                $order_wallet_action->save();

                session(['seller_prefered_language'=> $order_wallet_action->seller->prefered_language]);
        
                Mail::to($order_wallet_action->seller->email)
                ->send(new \App\Mail\RefundRejectedResponseMail($order_wallet_action->seller->id));
        
                session()->forget('seller_prefered_language');

            }
            elseif($request->refund_status == 'refunded')
            {
                
                $refund_data = [
                    'refund_id' => $refund->id,
                    'refund_amount' => $request->refund_amount,
                    'approved_note' => $request->approved_note,
                    'rejected_note' => $request->rejected_note,
                    'payment_method' => $request->payment_method,
                    'payment_info' => $request->payment_info,
                ];
                
                if($refund->order->payment_method == 'cash_on_delivery') {
                    $this->refund_complete($refund_data);
                    return back();
                    
                } else {
                    $payment = PaymentRequest::where('transaction_id', $refund->order->transaction_ref)
                    ->get()->first();
                    
                    if($refund->order->payment_method == 'stripe') {
                        $data = [];

                        $data['amount'] = $payment->payment_amount - BackEndHelper::usd_to_currency($order->shipping_cost) - (($payment->payment_amount * 2.9) / 100) - 0.29;

                        $data['payment_id'] = $payment->id;
                        
                        return $data;
                        
                        $order_refund = (new StripePayment($payment))->refund($data);
                        
                        if($order_refund['status'] == 'error') {
                            Toastr::error(translate('refund_failed').' : '.$order_refund['message']);
                            return back();
                        }
                        else if($order_refund['status'] == 'success' && ($order_refund['details']['status'] == 'succeeded' || $order_refund['details']['status'] == 'pending') ) {
                            $this->refund_complete($refund_data);
                            return back();
                        }
                        else {
                            return back();
                        }
                    }
                    else if($refund->order->payment_method == 'paypal') {
                        $this->refund_complete($refund_data);
                        return back();
                    }
                }
                
                
            }
            $order_details->save();

            $refund->status = $request->refund_status;
            $refund->change_by = 'admin';
            $refund->save();
            $refund_status->save();

            /** send notification */
            if ($order->seller_is == 'seller') {
                if ($request->refund_status != 'rejected' && $request->refund_status != 'refunded') {
                    Helpers::send_order_notification('refund_request_status_changed_by_admin', 'seller', $order);
                } elseif ($request->refund_status == 'rejected') {
                    Helpers::send_order_notification('refund_request_canceled_message', 'seller', $order);
                } else {
                    Helpers::send_order_notification('order_refunded_message', 'seller', $order);
                }
            }
            if ($request->refund_status == 'refunded') {
                Helpers::send_order_notification('order_refunded_message', 'customer', $order);
            } elseif ($request->refund_status == 'rejected') {
                Helpers::send_order_notification('refund_request_canceled_message', 'customer', $order);
            }
            /** end  */

            Toastr::success(translate('refund_status_updated'));
            return back();

        }else{
            Toastr::warning(translate('refunded status can not be changed'));
            return back();
        }

    }
    
    public function refund_complete($refund_data){
        
        $refund = RefundRequest::find($refund_data['refund_id']);
        
        if($refund_data) {
            
            $order_details = OrderDetail::find($refund->order_details_id);
            
            $refund_status = new RefundStatus;
            $refund_status->refund_request_id = $refund->id;
            $refund_status->change_by = 'admin';
            $refund_status->change_by_id = auth('admin')->id();
            $refund_status->status = 'refunded';
            
            $user = User::find($refund->customer_id);
            $order = Order::find($refund->order_id);
            
            $wallet_status = Helpers::get_business_settings('wallet_status');
            $loyalty_point_status = Helpers::get_business_settings('loyalty_point_status');
            $loyalty_point = CustomerManager::count_loyalty_point_for_amount($refund->order_details_id);
            
            $order_details->refund_request = 4;
            $refund->payment_info = $refund_data['payment_info'];
            $refund_status->message = $refund_data['payment_info'];
    
            if($loyalty_point > 0 && $loyalty_point_status == 1)
            {
                CustomerManager::create_loyalty_point_transaction($refund->customer_id, $refund->order_id, $loyalty_point, 'refund_order');
            }
    
            $wallet_add_refund = Helpers::get_business_settings('wallet_add_refund');
    
            if($wallet_add_refund==1 && $refund_data['payment_method'] == 'customer_wallet')
            {
                CustomerManager::create_wallet_transaction($refund->customer_id, Convert::default($refund->amount), 'order_refund','order_refund');
            }
    
            $seller = Seller::with('wallet')->find($refund->order->seller_id);
    
            $admin_wallet = AdminWallet::where('admin_id', 1)->get()->first();
    
            $order_wallet_action = SellerWalletAction::where('order_id', $order->id)
            ->get()->first();
            
            $order_admin_wallet_action = AdminWalletAction::where('order_id', $order->id)
            ->get()->first();
            
            $seller_payout_history = new SellerPayoutHistory;
            
            $seller_payout_history->old_pending_withdraw = $seller->wallet->pending_withdraw;
            
            $seller_payout_history->amount = $seller->wallet->pending_withdraw;
            
            $seller->wallet->pending_withdraw -= $refund_data['refund_amount'] - $order->admin_commission;
            $seller->wallet->commission_given -= $order->admin_commission;
    
            $admin_wallet->commission_earned -= $order->admin_commission;
            
            $admin_wallet->pending_amount -= $refund_data['refund_amount'] - $order->admin_commission;
            $admin_wallet->total_tax_collected -= $order_wallet_action->total_tax_collected;
            $admin_wallet->collected_cash -= $order_wallet_action->collected_cash;
            
            $order_wallet_action->is_suspended = 1;
            $order_wallet_action->commission_given = 0;
            $order_wallet_action->collected_cash = 0;
            $order_wallet_action->total_tax_collected = 0;
    
            $order_admin_wallet_action->commission_earned = 0;
            $order_admin_wallet_action->collected_cash = 0;
            $order_admin_wallet_action->total_tax_collected = 0;
                        
            $seller_payout_history->old_total_earning = $seller->wallet->total_earning;
            $seller_payout_history->old_withdrawn = $seller->wallet->withdrawn;
            $seller_payout_history->seller_id = $seller->id;
    
            $seller_payout_history->new_pending_withdraw = $seller->wallet->pending_withdraw;
            $seller_payout_history->new_withdrawn = $seller->wallet->withdrawn;
            $seller_payout_history->new_total_earning = $seller->wallet->total_earning;
    
            $order_wallet_action->save();
            $order_admin_wallet_action->save();
            $seller->wallet->save();
            $admin_wallet->save();
            $seller_payout_history->save();
    
            session(['seller_prefered_language'=> $seller->prefered_language]);
    
            Mail::to($seller->email)
            ->send(new \App\Mail\RefundAcceptedResponseMail($seller->id));
    
            session()->forget('seller_prefered_language');
            session()->forget('refund_data');
            
            $order_details->save();
    
            $refund->status = 'refunded';
            $refund->change_by = 'admin';
            $refund->save();
            $refund_status->save();
    
            Helpers::send_order_notification('order_refunded_message', 'seller', $order);
            
            Helpers::send_order_notification('order_refunded_message', 'customer', $order);
    
            Toastr::success(translate('order_returned_with_success'));
        }
        
    }
    
    public function index()
    {
        return view('admin-views.refund.index');
    }
    public function update(Request $request)
    {
        $request->validate([
            'refund_day_limit' => 'required',
        ]);

        DB::table('business_settings')->updateOrInsert(['type' => 'refund_day_limit'], [
            'value' => $request['refund_day_limit']
        ]);
        Toastr::success(translate('refund_day_limit_updated'));
        return back();
    }
    public function inhouse_order_filter(Request $request)
    {
        if($request->has('type') && $request->type == 'all') {
            session()->put('show_inhouse_and_seller_orders', 1);
            session()->put('show_inhouse_orders', 0);
            session()->put('show_seller_orders', 0);
        }

        if($request->has('type') && $request->type == 'inhouse') {
            session()->put('show_inhouse_and_seller_orders', 0);
            session()->put('show_inhouse_orders', 1);
            session()->put('show_seller_orders', 0);
        }

        if($request->has('type') && $request->type == 'seller') {
            session()->put('show_seller_orders', 1);
            session()->put('show_inhouse_and_seller_orders', 0);
            session()->put('show_inhouse_orders', 0);
        }
        return back();
    }

    /** export */
    public function export(Request $request ,$status){
        $search = $request->search;
        $refund_list = RefundRequest::with(['order','order.seller','order.delivery_man', 'product'])
            ->when(session()->has('show_inhouse_orders') && session('show_inhouse_orders') == 1, function ($query) {
                $query->whereHas('order', function ($query) {
                    $query->where('seller_is', 'admin');
                });
            })
            ->when(session()->has('show_seller_orders') && session('show_seller_orders') == 1, function ($query) {
                $query->whereHas('order', function ($query) {
                    $query->where('seller_is', 'seller');
                });
            })->where(function ($query) use ($search) {
                if (!empty($search)) {
                    $keywords = explode(' ', $search);
                    $query->where(function ($subquery) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $subquery->orWhere('order_id', 'like', "%{$keyword}%")
                            ->orWhere('id', 'like', "%{$keyword}%");
                        }
                    });
                }
            })
            ->where('status',$status)->latest()->get();
        $data = [
            'refund_list' => $refund_list,
            'search' => $search,
            'status' => $status,
            'filter_By' => session()->has('show_inhouse_orders') && session('show_inhouse_orders') == 1 ? 'inhouse_request' : (session()->has('show_seller_orders') && session('show_seller_orders') == 1 ? 'seller_request' : 'all') ,
        ];

        return Excel::download(new RefundRequestExport($data), 'refund-request.xlsx');
    }
    /** end export */

}

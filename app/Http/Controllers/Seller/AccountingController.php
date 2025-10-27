<?php

namespace App\Http\Controllers\Seller;

use Carbon\Carbon;
use App\CPU\Convert;

use App\CPU\Helpers;
use App\Model\Order;
use App\Models\User;
use App\Model\Seller;
use App\Model\Product;
use App\Model\Category;
use Carbon\CarbonPeriod;
use App\CPU\BackEndHelper;
use App\Model\OrderDetail;
use App\Model\SellerWallet;
use Illuminate\Support\Str;
use Brian2694\Toastr\Toastr;
use Illuminate\Http\Request;
use App\Model\BusinessSetting;
use App\Model\WithdrawRequest;
use App\Model\OrderTransaction;
use App\Model\WithdrawalMethod;
use Illuminate\Support\Facades\DB;
use App\Model\SellerReceiveRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Model\SellerBalanceTransaction;
use App\Model\SellerPayoutHistory;
use App\Model\SellerWalletAction;
use App\Model\SellerWalletActionHistory;

class AccountingController extends Controller
{

    public function index(Request $request){
        
        $search = $request['search'];
        $from = $request['from'];
        $to = $request['to'];
        $date_type = $request['date_type'] ?? 'this_year';
        $seller_id = auth('seller')->id();
        $customer_id = $request['customer_id'] ?? 'all';
        $status = $request['status'] ?? 'all';

        $query_param = ['search' => $search, 'status' => $status, 
        'customer_id' => $customer_id, 'seller_id' => $seller_id , 
        'date_type' => $date_type, 'from' => $from, 'to' => $to];

        $withdrawal_payment_methods = WithdrawalMethod::ofStatus(1)->select('id', 'method_name')->get();
        
        $seller_wallet = SellerWallet::where('seller_id', auth('seller')->id())->first();

        $seller_wallet_actions_query = SellerWalletAction::where('seller_wallet_id', $seller_wallet?->id);
        
        $seller_wallet_actions = self::date_wise_common_filter($seller_wallet_actions_query,$date_type, $from, $to)
        ->get();

        $seller_wallet_actions_histories_query = SellerWalletActionHistory::where('seller_wallet_id', $seller_wallet?->id);

        $seller_wallet_actions_histories = self::date_wise_common_filter($seller_wallet_actions_histories_query,$date_type, $from, $to)
        ->get();
        
        $suspended_amount_query = $seller_wallet_actions_query
        ->where('is_suspended', 1);


        $suspended_amount = self::date_wise_common_filter($suspended_amount_query,$date_type, $from, $to)->get();
        
        
        $suspended_amount = $suspended_amount->map(function ($action) {
             return $action->pending_withdraw - ($action->order->shipping_cost ?? 0);
        })->sum();

        $data = [];
        
        $data['commission_given'] = $seller_wallet_actions->pluck('commission_given')->sum() ?? 0;
        $data['collected_cash'] = $seller_wallet_actions->pluck('collected_cash')->sum() ?? 0;
        $data['delivery_charge_earned'] = $seller_wallet_actions->pluck('delivery_charge_earned')->sum() ?? 0;
        $data['total_tax_collected'] = $seller_wallet_actions->pluck('total_tax_collected')->sum() ?? 0;
        $data['withdrawn'] = $date_type == 'this_year' ? $seller_wallet?->withdrawn : ($seller_wallet_actions_histories->sum('withdrawn') ?? 0);
        
        $data['total_earning'] = $date_type == 'this_year' ? $seller_wallet?->total_earning : ($seller_wallet_actions_histories->sum('total_earning') ?? 0);
        $data['pending_withdraw'] = $date_type == 'this_year' ? $seller_wallet?->pending_withdraw 
        : ($seller_wallet_actions->where('is_suspended', 0)->sum('pending_withdraw') 
        + $seller_wallet_actions->where('is_suspended', 1)->sum('delivery_charge_earned') ?? 0);
        
        $data['suspended_amount'] = $suspended_amount;
        
        $customers = User::whereNotIn('id', [0])->get();

        $transactions = self::order_transaction_table_data_filter($request);
        $transactions = $transactions->latest('updated_at')->paginate(Helpers::pagination_limit())->appends($query_param);

        $order_transaction_chart = self::order_transaction_chart_filter($request);

        $active_products = Product::where([
            'user_id'=>auth('seller')->id(),
            'added_by'=>'seller',
            'status'=>1,
            'request_status'=>1
        ])->count();

        $inactive_products = Product::where([
            'user_id'=>auth('seller')->id(),
            'added_by'=>'seller',
            'status'=>0,
            'request_status'=>1
        ])->count();

        $pending_products = Product::where([
            'user_id'=>auth('seller')->id(),
            'added_by'=>'seller',
            'status'=>0,
            'request_status'=>0
        ])->count();

        $product_data = [
            'total_products' => $active_products+$inactive_products+$pending_products,
            'active_products' => $active_products,
            'inactive_products' => $inactive_products,
            'pending_products' => $pending_products,
        ];

        $digital_payment_query = Order::whereNotIn('payment_method', ['cash', 'cash_on_delivery', 'pay_by_wallet', 'offline_payment']);
        $digital_payment = self::order_transaction_piechart_query($request, $digital_payment_query)->sum('order_amount');

        $cash_payment_query = Order::whereIn('payment_method', ['cash', 'cash_on_delivery']);
        $cash_payment = self::order_transaction_piechart_query($request, $cash_payment_query)->sum('order_amount');

        $wallet_payment_query = Order::where(['payment_method' => 'pay_by_wallet']);
        $wallet_payment = self::order_transaction_piechart_query($request, $wallet_payment_query)->sum('order_amount');

        $offline_payment_query = Order::where(['payment_method' => 'offline_payment']);
        $offline_payment = self::order_transaction_piechart_query($request, $offline_payment_query)->sum('order_amount');

        $total_payment = $cash_payment + $wallet_payment + $digital_payment + $offline_payment;

        $payment_data = [
            'digital_payment' => $digital_payment,
            'cash_payment' => $cash_payment,
            'wallet_payment' => $wallet_payment,
            'offline_payment' => $offline_payment,
            'total_payment' => $total_payment,
        ];

        

        return view('seller-views.accounting.index', compact('data', 'withdrawal_payment_methods','customers','transactions','product_data', 
        'order_transaction_chart', 'payment_data','status','search', 'date_type', 'from', 'to', 'customer_id'));
    }

    public function order_transaction_chart_filter($request)
    {
        $from = $request['from'];
        $to = $request['to'];
        $date_type = $request['date_type'] ?? 'this_year';

        if ($date_type == 'this_year') { //this year table
            $number = 12;
            $default_inc = 1;
            $current_start_year = date('Y-01-01');
            $current_end_year = date('Y-12-31');
            $from_year = Carbon::parse($from)->format('Y');

            $this_year = self::order_transaction_same_year($request, $current_start_year, $current_end_year, $from_year, $number, $default_inc);
            return $this_year;

        } elseif ($date_type == 'this_month') { //this month table
            $current_month_start = date('Y-m-01');
            $current_month_end = date('Y-m-t');
            $inc = 1;
            $month = date('m');
            $number = date('d', strtotime($current_month_end));

            $this_month = self::order_transaction_same_month($request, $current_month_start, $current_month_end, $month, $number, $inc);
            return $this_month;

        } elseif ($date_type == 'this_week') {
            $this_week = self::order_transaction_this_week($request);
            return $this_week;

        } elseif ($date_type == 'custom_date' && !empty($from) && !empty($to)) {
            $start_date = Carbon::parse($from)->format('Y-m-d 00:00:00');
            $end_date = Carbon::parse($to)->format('Y-m-d 23:59:59');
            $from_year = Carbon::parse($from)->format('Y');
            $from_month = Carbon::parse($from)->format('m');
            $from_day = Carbon::parse($from)->format('d');
            $to_year = Carbon::parse($to)->format('Y');
            $to_month = Carbon::parse($to)->format('m');
            $to_day = Carbon::parse($to)->format('d');

            if ($from_year != $to_year) {
                $different_year = self::order_transaction_different_year($request, $start_date, $end_date, $from_year, $to_year);
                return $different_year;

            } elseif ($from_month != $to_month) {
                $same_year = self::order_transaction_same_year($request, $start_date, $end_date, $from_year, $to_month, $from_month);
                return $same_year;

            } elseif ($from_month == $to_month) {
                $same_month = self::order_transaction_same_month($request, $start_date, $end_date, $from_month, $to_day, $from_day);
                return $same_month;
            }

        }
    }

    public function order_transaction_same_month($request, $start_date, $end_date, $month_date, $number, $default_inc)
    {
        $year_month = date('Y-m', strtotime($start_date));
        $month = date("F", strtotime("$year_month"));
        $orders = self::order_transaction_date_common_query($request, $start_date, $end_date)
            ->selectRaw('sum(order_amount) as order_amount, YEAR(updated_at) year, MONTH(updated_at) month, DAY(updated_at) day')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $day = date('jS', strtotime("$year_month-$inc"));
            $order_amount[$day . '-' . $month] = 0;
            foreach ($orders as $match) {
                if ($match['day'] == $inc) {
                    $order_amount[$day . '-' . $month] = $match['order_amount'];
                }
            }
        }

        return array(
            'order_amount' => $order_amount,
        );
    }

    public function order_transaction_same_year($request, $start_date, $end_date, $from_year, $number, $default_inc)
    {

        $orders = self::order_transaction_date_common_query($request, $start_date, $end_date)
            ->selectRaw('sum(order_amount) as order_amount, YEAR(updated_at) year, MONTH(updated_at) month')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%M')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $month = date("F", strtotime("2023-$inc-01"));
            $order_amount[$month . '-' . $from_year] = 0;
            foreach ($orders as $match) {
                if ($match['month'] == $inc) {
                    $order_amount[$month . '-' . $from_year] = $match['order_amount'];
                }
            }
        }

        return array(
            'order_amount' => $order_amount,
        );
    }

    public function order_transaction_different_year($request, $start_date, $end_date, $from_year, $to_year)
    {

        $orders = self::order_transaction_date_common_query($request, $start_date, $end_date)
            ->selectRaw('sum(order_amount) as order_amount, YEAR(updated_at) year')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%Y')"))
            ->latest('updated_at')->get();

        for ($inc = $from_year; $inc <= $to_year; $inc++) {
            $order_amount[$inc] = 0;
            foreach ($orders as $match) {
                if ($match['year'] == $inc) {
                    $order_amount[$inc] = $match['order_amount'];
                }
            }
        }

        return array(
            'order_amount' => $order_amount,
        );

    }

    public function order_transaction_date_common_query($request, $start_date, $end_date)
    {
        $customer_id = $request['customer_id'] ?? 'all';
        $status = $request['status'] ?? 'all';

        $query = Order::with('order_transaction')
            ->where('payment_status', 'paid')
            ->when($status != 'all', function ($query) use ($status) {
                $query->whereHas('order_transaction', function ($query) use ($status) {
                    $query->where(['status' => $status]);
                });
            })
            ->when($customer_id != 'all', function ($query) use ($customer_id) {
                $query->where('customer_id', $customer_id);
            })
            ->where(['seller_is'=>'seller', 'seller_id'=>auth('seller')->id()])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date);

        return $query;
    }

    public function order_transaction_this_week($request)
    {
        $start_date = Carbon::now()->startOfWeek();
        $end_date = Carbon::now()->endOfWeek();

        $number = 6;
        $period = CarbonPeriod::create(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek());
        $day_name = array();
        foreach ($period as $date) {
            array_push($day_name, $date->format('l'));
        }

        $orders = self::order_transaction_date_common_query($request, $start_date, $end_date)
            ->select(
                DB::raw('sum(order_amount) as order_amount'),
                DB::raw("(DATE_FORMAT(updated_at, '%W')) as day")
            )
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
            ->latest('updated_at')->get();

        for ($inc = 0; $inc <= $number; $inc++) {
            $order_amount[$day_name[$inc]] = 0;
            foreach ($orders as $match) {
                if ($match['day'] == $day_name[$inc]) {
                    $order_amount[$day_name[$inc]] = $match['order_amount'];
                }
            }
        }

        return array(
            'order_amount' => $order_amount,
        );
    }

    public function order_transaction_piechart_query($request, $query)
    {
        $from = $request['from'];
        $to = $request['to'];
        $customer_id = $request['customer_id'] ?? 'all';
        $status = $request['status'] ?? 'all';
        $date_type = $request['date_type'] ?? 'this_year';

        $query_data = $query->where(['payment_status' => 'paid'])
            ->whereHas('order_transaction', function ($query) use ($status) {
                $query->when($status != 'all', function ($query) use ($status) {
                    $query->where(['status' => $status]);
                });
            })
            ->when($customer_id != 'all', function ($query) use ($customer_id) {
                $query->where('customer_id', $customer_id);
            })
            ->where(['seller_is'=>'seller', 'seller_id'=>auth('seller')->id()]);

        return self::date_wise_common_filter($query_data, $date_type, $from, $to);
    }

    public function order_transaction_table_data_filter($request)
    {
        $search = $request['search'];
        $from = $request['from'];
        $to = $request['to'];
        $customer_id = $request['customer_id'] ?? 'all';
        $status = $request['status'] ?? 'all';
        $date_type = $request['date_type'] ?? 'this_year';

        $transaction_query = OrderTransaction::with(['seller.shop', 'customer', 'order.delivery_man'])
            ->with(['order_details'=> function ($query) {
                $query->selectRaw("*, sum(qty*price) as order_details_sum_price, sum(discount) as order_details_sum_discount")
                    ->groupBy('order_id');
            }])
            ->when($search, function ($q) use ($search) {
                $q->orWhere('order_id', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%");
            })
            ->when($status != 'all', function ($query) use ($status) {
                $query->where(['status' => $status]);
            })
            ->when($customer_id != 'all', function ($query) use ($customer_id) {
                $query->where('customer_id', $customer_id);
            })
            ->where(['seller_is'=>'seller', 'seller_id'=>auth('seller')->id()]);
        $transactions = self::date_wise_common_filter($transaction_query, $date_type, $from, $to);

        return $transactions;
    }

    public function seller_transactions_filter($request)
    {
        $search = $request['search'];
        $from = $request['from'];
        $to = $request['to'];
        $transaction_type = $request['transaction_type'] ?? 'all';
        $date_type = $request['date_type'] ?? 'this_year';

        $transaction_query = SellerBalanceTransaction::
            where(['seller_id'=>auth('seller')->id()])
            ->when($search, function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%");
            })
            ->when($transaction_type != 'all', function ($query) use ($transaction_type) {
                $query->where('type', $transaction_type);
            });

        $transactions = self::date_wise_common_filter($transaction_query, $date_type, $from, $to);

        return $transactions;
    }

    public function date_wise_common_filter($query, $date_type, $from, $to)
    {
        return $query->when(($date_type == 'this_year'), function ($query) {
            return $query->whereYear('updated_at', date('Y'));
        })
        ->when(($date_type == 'this_month'), function ($query) {
            return $query->whereMonth('updated_at', date('m'))
                ->whereYear('updated_at', date('Y'));
        })
        ->when(($date_type == 'this_week'), function ($query) {
            return $query->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        })
        ->when(($date_type == 'custom_date' && !is_null($from) && !is_null($to)), function ($query) use ($from, $to) {
            return $query->whereDate('updated_at', '>=', $from)
                ->whereDate('updated_at', '<=', $to);
        });
    }

    public function balance_transactions(Request $request)
    {
        // $all = session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'all' ? 1 : 0;
        // $active = session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'approved' ? 1 : 0;
        // $denied = session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'denied' ? 1 : 0;
        // $pending = session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'pending' ? 1 : 0;

        $search = $request['search'];
        $from = $request['from'];
        $to = $request['to'];
        $transaction_type = $request['transaction_type'];
        $date_type = $request['date_type'] ?? 'this_year';

        DB::table('sellers_balance_transactions')
        ->where(['seller_id' => auth('seller')->id()])
        ->update(['seller_checked' => 1]);

        $transactions_query = self::seller_transactions_filter($request);

        $transactions = $transactions_query->orderBy('id', 'desc')->paginate(Helpers::pagination_limit());
        
        return view('seller-views.accounting.sellers-balance-transactions', 
        compact('transactions', 'from', 'to', 'transaction_type', 'date_type', 'search'));
    }

    public function get_payout_histories(Request $request){

        $search = $request['search'];
        $from = $request['from'];
        $to = $request['to'];
        $date_type = $request['date_type'] ?? 'this_year';

        $payout_histories_query = SellerPayoutHistory::
        when($search, function ($q) use ($search) {
            $amount = Convert::usd($search);
            $q->where('amount', 'like', "%{$amount}%");
        })
        ->where('seller_id', auth('seller')->id());

        $payout_histories = self::date_wise_common_filter($payout_histories_query, $date_type, $from, $to);

        $payout_histories = $payout_histories->orderBy('id', 'desc')->paginate(Helpers::pagination_limit());

        return view('seller-views.accounting.seller-payout-histories', 
        compact('payout_histories', 'from', 'to' , 'date_type', 'search'));

    }

    public function pdf_balance_transaction(Request $request)
    {
        
        $company_phone = BusinessSetting::where('type', 'company_phone')->first()->value;
        $company_email = BusinessSetting::where('type', 'company_email')->first()->value;
        $company_name = BusinessSetting::where('type', 'company_name')->first()->value;
        $company_web_logo = BusinessSetting::where('type', 'company_web_logo')->first()->value;

        $transaction = SellerBalanceTransaction::where('seller_id', auth('seller')->id())
        ->where('id', $request->id)
        ->get()
        ->first();
        
        $mpdf_view = View::make('seller-views.accounting.pdf.wise-balance-transaction', 
        compact('company_phone', 'company_name', 'company_email', 'company_web_logo', 'transaction'));
        Helpers::gen_mpdf($mpdf_view, 'cost_', rand(1000, 9999).time());

    }

    public function pdf_payout_histories(Request $request)
    {
        
        $company_phone = BusinessSetting::where('type', 'company_phone')->first()->value;
        $company_email = BusinessSetting::where('type', 'company_email')->first()->value;
        $company_name = BusinessSetting::where('type', 'company_name')->first()->value;
        $company_web_logo = BusinessSetting::where('type', 'company_web_logo')->first()->value;

        $payout_history = SellerPayoutHistory::find($request->id);
        
        $mpdf_view = View::make('seller-views.accounting.pdf.wise-payout-histories', 
        compact('company_phone', 'company_name', 'company_email', 'company_web_logo', 'payout_history'));
        Helpers::gen_mpdf($mpdf_view, 'cost_', rand(1000, 9999).time());

    }

    public function balance_transaction_summary_pdf(Request $request) {
        
        $search = $request['search'];
        $from = $request['from'];
        $to = $request['to'];
        $type = $request['type'] ?? 'all';
        $date_type = $request['date_type'] ?? 'this_year';

        $company_phone = BusinessSetting::where('type', 'company_phone')->first()->value;
        $company_email = BusinessSetting::where('type', 'company_email')->first()->value;
        $company_name = BusinessSetting::where('type', 'company_name')->first()->value;
        $company_web_logo = BusinessSetting::where('type', 'company_web_logo')->first()->value;
        
        $sum_amount = 0;
        $manually_type = 0;
        $automatic_type = 0;
        $newest_transaction_date = null;
        $oldest_transaction_date = null;

        $balance_transactions_query = self::seller_transactions_filter($request);
        $balance_transactions = $balance_transactions_query->get();

        if($balance_transactions->count() > 0) {
            $amount_sum = $balance_transactions->sum('amount');
            $manually_type = $balance_transactions->where('type', 'manually')->count();
            $automatic_type = $balance_transactions->where('type', 'automatic')->count();
            $newest_transaction_date = $balance_transactions->sortBy('created_at')->first();
            $oldest_transaction_date = $balance_transactions->sortBy('created_at')->first();
        }

        $mpdf_view = View::make('seller-views.accounting.pdf.balance-transaction-summary', 
        compact('company_phone', 'company_name', 'company_email', 'company_web_logo',
        'amount_sum', 'manually_type', 'automatic_type', 'newest_transaction_date',
        'oldest_transaction_date'));

        Helpers::gen_mpdf($mpdf_view, 'cost_', rand(1000, 9999).time());

    }

    public function payout_histories_summary_pdf(Request $request) {
        
        $search = $request['search'];
        $from = $request['from'];
        $to = $request['to'];
        $date_type = $request['date_type'] ?? 'this_year';

        $company_phone = BusinessSetting::where('type', 'company_phone')->first()->value;
        $company_email = BusinessSetting::where('type', 'company_email')->first()->value;
        $company_name = BusinessSetting::where('type', 'company_name')->first()->value;
        $company_web_logo = BusinessSetting::where('type', 'company_web_logo')->first()->value;
        
        $sum_amount = 0;
        $newest_transaction_date = null;
        $oldest_transaction_date = null;

        $payout_histories_query = SellerPayoutHistory::
        when($search, function ($q) use ($search) {
            $amount = Convert::usd($search);
            $q->where('amount', 'like', "%{$amount}%");
        })
        ->where('seller_id', auth('seller')->id());

        $payout_histories = self::date_wise_common_filter($payout_histories_query, $date_type, $from, $to);

        $payout_histories = $payout_histories->orderBy('id', 'desc')->paginate(Helpers::pagination_limit());

        if($payout_histories->count() > 0) {
            $amount_sum = $payout_histories->sum('amount');
            $newest_payout_history_date = $payout_histories->sortBy('created_at')->first();
            $oldest_payout_history_date = $payout_histories->sortBy('created_at')->first();
        }

        $mpdf_view = View::make('seller-views.accounting.pdf.payout-histories-summary', 
        compact('company_phone', 'company_name', 'company_email', 'company_web_logo',
        'amount_sum', 'newest_payout_history_date',
        'oldest_payout_history_date'));

        Helpers::gen_mpdf($mpdf_view, 'cost_', rand(1000, 9999).time());

    }

    public function wallet_actions_pdf(Request $request) {
        
        $from = $request['from'];
        $to = $request['to'];
        $date_type = $request['date_type'] ?? 'this_year';

        $company_phone = BusinessSetting::where('type', 'company_phone')->first()->value;
        $company_email = BusinessSetting::where('type', 'company_email')->first()->value;
        $company_name = BusinessSetting::where('type', 'company_name')->first()->value;
        $company_web_logo = BusinessSetting::where('type', 'company_web_logo')->first()->value;

        $search = $request['search'];
        $from = $request['from'];
        $to = $request['to'];
        $date_type = $request['date_type'] ?? 'this_year';
        $seller_id = auth('seller')->id();
        $customer_id = $request['customer_id'] ?? 'all';
        $status = $request['status'] ?? 'all';

        $query_param = ['search' => $search, 'status' => $status, 
        'customer_id' => $customer_id, 'seller_id' => $seller_id , 
        'date_type' => $date_type, 'from' => $from, 'to' => $to];
        
        $seller_wallet = SellerWallet::where('seller_id', auth('seller')->id())->first();

        $seller_wallet_actions_query = SellerWalletAction::where('seller_wallet_id', $seller_wallet->id);
        
        $seller_wallet_actions = self::date_wise_common_filter($seller_wallet_actions_query,$date_type, $from, $to)
        ->get();

        $seller_wallet_actions_histories_query = SellerWalletActionHistory::where('seller_wallet_id', $seller_wallet->id);

        $seller_wallet_actions_histories = self::date_wise_common_filter($seller_wallet_actions_histories_query,$date_type, $from, $to)
        ->get();
        
        $data = [];
        
        $data['commission_given'] = $seller_wallet_actions->pluck('commission_given')->sum() ?? 0;
        $data['collected_cash'] = $seller_wallet_actions->pluck('collected_cash')->sum() ?? 0;
        $data['delivery_charge_earned'] = $seller_wallet_actions->pluck('delivery_charge_earned')->sum() ?? 0;
        $data['total_tax_collected'] = $seller_wallet_actions->pluck('total_tax_collected')->sum() ?? 0;
        
        $data['total_earning'] = $date_type == 'this_year' ? $seller_wallet->total_earning : ($seller_wallet_actions_histories->sum('current_total_earning') ?? 0);
        $data['withdrawn'] = $date_type == 'this_year' ? $seller_wallet->withdrawn : ($seller_wallet_actions_histories->sum('current_withdrawn') ?? 0);
        $data['pending_withdraw'] = $date_type == 'this_year' ? $seller_wallet->pending_withdraw : ($seller_wallet_actions_histories->sum('current_pending_withdraw') ?? 0);

        $total_earning_actions = [];
        $pending_withdraw_actions = [];

        if($date_type != 'this_year') {
            foreach($seller_wallet_actions_histories as $action) {
                $total_earning_actions[] = [
                    'total_earning'=> $action->current_total_earning,
                    'date' => $action->created_at
                ];
                $pending_withdraw_actions[] = [
                    'pending_withdraw'=> $action->current_pending_withdraw,
                    'date' => $action->created_at
                ];
            }
        }

        $data['suspended_amount'] = $seller_wallet?->walletActions
        ->where('is_suspended', 1)
        ->pluck('pending_withdraw')->sum() ?? 0;


        $mpdf_view = View::make('seller-views.accounting.pdf.wallet_actions', 
        compact('company_phone', 'company_name', 'company_email', 'company_web_logo', 
        'data', 'total_earning_actions', 'pending_withdraw_actions'));

        Helpers::gen_mpdf($mpdf_view, 'cost_', rand(1000, 9999).time());

    }

    public function balance_transaction_export_excel(Request $request)
    {
        
        $search = $request['search'];
        $from = $request['from'];
        $to = $request['to'];
        $seller = $request['seller'] ?? 'all';
        $transaction_type = $request['transaction_type'] ?? 'all';
        $date_type = $request['date_type'] ?? 'this_year';

        $balance_transaction_query = self::seller_transactions_filter($request);

        $balance_transactions = $balance_transaction_query->orderBy('id', 'desc')->paginate(Helpers::pagination_limit());

        if($balance_transactions->count() > 0) {
            foreach($balance_transactions as $transaction) {
                $tranData[] = array(
                    'Id' => $transaction->id,
                    'Amount' => \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($transaction->amount)),
                    'Payment method' => $transaction->paymentMethod->method_name,
                    'type' => $transaction->type,
                    'transaction_id' => $transaction->transaction_id,
                    'balance transaction date' => $transaction->created_at,
                );
            }
        } else {
            return back();
        }

        return (new FastExcel($tranData))->download('balance_transaction_Excel.xlsx');

    }

    public function sellers_payout_histories_export_excel(Request $request)
    {

        $search = $request['search'];
        $from = $request['from'];
        $to = $request['to'];
        $date_type = $request['date_type'] ?? 'this_year';

        $payout_histories_query = SellerPayoutHistory::
        when($search, function ($q) use ($search) {
            $amount = Convert::usd($search);
            $q->where('amount', 'like', "%{$amount}%");
        })
        ->where('seller_id', auth('seller')->id());

        $payout_histories = self::date_wise_common_filter($payout_histories_query, $date_type, $from, $to);

        $payout_histories = $payout_histories_query->orderBy('id', 'desc')->paginate(Helpers::pagination_limit());

        if($payout_histories->count() > 0) {
            foreach($payout_histories as $payout_history) {
                $tranData[] = array(
                    'Id' => $payout_history->id,
                    'Amount' => \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($payout_history->amount)),
                    'Payment method' => $payout_history->paymentMethod->method_name ?? '/',
                    'New pending amount' => $payout_history->new_pending_withdraw,
                    'New total earning' => $payout_history->new_total_earning,
                    'New withdrawn' => $payout_history->new_withdrawn,
                    'Payout history date' => $payout_history->created_at,
                );
            }
        } else {
            return back();
        }

        return (new FastExcel($tranData))->download('payout_histories_Excel.xlsx');

    }

}

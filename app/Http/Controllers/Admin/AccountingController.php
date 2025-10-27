<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Model\Cost;

use App\CPU\Convert;
use App\CPU\Helpers;
use App\Model\Order;
use App\Models\User;
use App\Model\Seller;
use App\Model\Product;
use App\Model\Category;
use Carbon\CarbonPeriod;
use App\CPU\BackEndHelper;
use App\Model\AdminWallet;
use App\Model\OrderDetail;
use App\Model\SellerWallet;
use Illuminate\Support\Str;
use Brian2694\Toastr\Toastr;
use Illuminate\Http\Request;
use App\Model\BusinessSetting;
use App\Model\WithdrawRequest;
use App\Model\OrderTransaction;
use App\Model\WithdrawalMethod;
use App\Model\AdminWalletAction;
use App\Model\RefundTransaction;
use App\Model\SellerWalletAction;
use App\Model\SellerPayoutHistory;
use Illuminate\Support\Facades\DB;
use App\Model\SellerReceiveRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Model\SellerBalanceTransaction;
use App\Model\SellerWalletActionHistory;


class AccountingController extends Controller
{

    public function index(Request $request){

        $from         = $request['from'];
        $to           = $request['to'];
        $date_type    = $request['date_type'] ?? 'this_year';
        $data = [];

        if (AdminWallet::where('admin_id', 1)->first() == false) {
            DB::table('admin_wallets')->insert([
                'admin_id' => 1,
                'withdrawn' => 0,
                'commission_earned' => 0,
                'delivery_charge_earned' => 0,
                'pending_amount' => 0,
                'total_earning' => 0,
                'collected_cash' => 0,
                'total_tax_collected' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $admin_wallet_actions = self::admin_wallet_filter($request)->get();

        $costs = self::admin_cost_filter($request);

        $data['commission_earned'] = $admin_wallet_actions->sum('commission_earned') ?? 0;
        $data['collected_cash'] = $admin_wallet_actions->sum('collected_cash') ?? 0;
        $data['costs_and_expenses'] = $costs->sum('amount') ?? 0;

        $digital_payment_query = Order::where(['order_status' => 'delivered'])->whereNotIn('payment_method', ['cash', 'cash_on_delivery', 'pay_by_wallet', 'offline_payment']);
        $digital_payment = self::earning_common_query($request, $digital_payment_query)->sum('order_amount');

        $cash_payment_query = Order::where(['order_status' => 'delivered'])->whereIn('payment_method', ['cash', 'cash_on_delivery']);
        $cash_payment = self::earning_common_query($request, $cash_payment_query)->sum('order_amount');

        $wallet_payment_query = Order::where(['order_status' => 'delivered'])->where(['payment_method' => 'pay_by_wallet']);
        $wallet_payment = self::earning_common_query($request, $wallet_payment_query)->sum('order_amount');

        $offline_payment_query = Order::where(['payment_method' => 'offline_payment']);
        $offline_payment = self::earning_common_query($request, $offline_payment_query)->sum('order_amount');

        $total_payment = $cash_payment + $wallet_payment + $digital_payment + $offline_payment;

        $payment_data = [
            'total_payment' => $total_payment,
            'cash_payment' => $cash_payment,
            'wallet_payment' => $wallet_payment,
            'offline_payment' => $offline_payment,
            'digital_payment' => $digital_payment,
        ];

        $filter_data = self::earning_common_filter('admin', $date_type, $from, $to);
        $inhouse_earn = $filter_data['earn_from_order'];
        $shipping_earn = $filter_data['shipping_earn'];
        $admin_commission_earn = $filter_data['commission'];
        $refund_given = $filter_data['refund_given'];
        $discount_given = $filter_data['discount_given'];
        $total_tax = $filter_data['total_tax'];
        $total_costs = $filter_data['total_costs'];
        $admin_bearer_free_shipping = $filter_data['admin_bearer_free_shipping'];

        $total_inhouse_earning = 0;
        $total_commission = 0;
        $total_shipping_earn = 0;
        $total_discount_given = 0;
        $total_refund_given = 0;
        $total_tax_final = 0;
        $total_earning_statistics = array();
        $total_commission_statistics = array();
        foreach($inhouse_earn as $key=>$earning) {
            $total_inhouse_earning += $earning;
            $total_commission += $admin_commission_earn[$key];
            $total_shipping_earn += $shipping_earn[$key];
            $total_discount_given += $discount_given[$key];
            $total_tax_final += $total_tax[$key];
            $total_refund_given += $refund_given[$key];
            $total_commission_statistics[$key] = $admin_commission_earn[$key];
            $total_earning_statistics[$key] = ($earning+$admin_commission_earn[$key]+$shipping_earn[$key])-$discount_given[$key]-$refund_given[$key];
        }

        $total_in_house_products_query = Product::where(['added_by' => 'admin']);
        $total_in_house_products = self::earning_common_query($request, $total_in_house_products_query)->count();

        $total_stores_query = Seller::where(['status' => 'approved']);
        $total_stores = self::earning_common_query($request, $total_stores_query)->count();

        $earning_data = [
            'total_inhouse_earning' => $total_inhouse_earning-$total_tax_final,
            'total_commission' => $total_commission,
            'total_shipping_earn' => $total_shipping_earn,
            'total_in_house_products' => $total_in_house_products,
            'total_stores' => $total_stores,
            'total_earning_statistics' => $total_earning_statistics,
            'total_commission_statistics' => $total_commission_statistics,
        ];

        return view('admin-views.accounting.index', compact('earning_data', 'inhouse_earn', 'shipping_earn',
        'admin_commission_earn', 'total_costs','refund_given', 'discount_given', 'data', 'total_tax', 'from', 'to', 'date_type', 'payment_data'));

    }

    public function admin_wallet_filter($request) {

        $from = $request['from'];
        $to = $request['to'];
        $date_type = $request['date_type'] ?? 'all_time';

        $admin_wallet_actions_query = AdminWalletAction::whereHas('adminWallet', function ($query) {
            $query->where('admin_id', 1);
        });
                    
        $admin_wallet_action = self::date_wise_common_filter($admin_wallet_actions_query, $date_type, $from, $to);

        return $admin_wallet_action;

    }

    public function admin_cost_filter($request) {

        $from = $request['from'];
        $to = $request['to'];
        $date_type = $request['date_type'] ?? 'this_year';

        $cost_query = Cost::query();
                    
        $costs = self::date_wise_common_filter($cost_query, $date_type, $from, $to);

        return $costs;

    }

    public function get_costs(Request $request) {

        $from = $request['from'];
        $to = $request['to'];
        $date_type = $request['date_type'];
        $search = $request['search'];

        $costs_query = Cost::when($search, function ($q) use ($search) {
            $q->orWhere('id', 'like', "%{$search}%")
            ->orWhere('title', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
        });

        // return $costs_query->get();

        $costs = self::date_wise_common_filter($costs_query, $date_type, $from, $to);

        $costs = $costs->orderBy('id', 'desc')
        ->paginate(Helpers::pagination_limit());

        return view('admin-views.accounting.get-costs-and-expenses', 
        compact('costs', 'date_type', 'from', 'to', 'search'));
    }

    public function store_costs(Request $request) {
        
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $cost = new Cost;

        $cost->title = $request->title;
        $cost->description = $request->description;
        $cost->amount = Convert::usd($request->amount);

        $cost->save();

        \Toastr::success(translate('cost_added_successfully'));
        return back();

    }

    public function update_costs(Request $request) {
        
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $cost = Cost::find($request->id);

        $cost->title = $request->title;
        $cost->description = $request->description;
        $cost->amount = Convert::usd($request->amount);

        $cost->save();

        \Toastr::success(translate('cost_added_successfully'));
        return back();

    }

    public function delete_costs(Request $request) {
        
        $cost = Cost::find($request->id);

        $cost->delete();

        \Toastr::success(translate('cost_deleted_successfully'));
        return back();

    }

    public function pdf_costs_and_expenses(Request $request)
    {
        
        $company_phone = BusinessSetting::where('type', 'company_phone')->first()->value;
        $company_email = BusinessSetting::where('type', 'company_email')->first()->value;
        $company_name = BusinessSetting::where('type', 'company_name')->first()->value;
        $company_web_logo = BusinessSetting::where('type', 'company_web_logo')->first()->value;

        $cost = Cost::find($request->id);
        
        $mpdf_view = View::make('admin-views.accounting.pdf.cost-wise-pdf', compact('company_phone', 'company_name', 'company_email', 'company_web_logo', 'cost'));
        Helpers::gen_mpdf($mpdf_view, 'cost_', rand(1000, 9999).time());

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

    public function cost_summary_pdf(Request $request) {
        
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

        $costs_query = Cost::when($search, function ($q) use ($search) {
            $q->orWhere('id', 'like', "%{$search}%")
            ->orWhere('title', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
        });

        // return $costs_query->get();

        $costs = self::date_wise_common_filter($costs_query, $date_type, $from, $to);

        $costs = $costs->orderBy('id', 'desc')
        ->paginate(Helpers::pagination_limit());

        if($costs->count() > 0) {
            $amount_sum = $costs->sum('amount');
            $newest_cost_date = $costs->sortBy('created_at')->first();
            $oldest_cost_date = $costs->sortBy('created_at')->first();
        }

        $mpdf_view = View::make('admin-views.accounting.pdf.cost-summary', 
        compact('company_phone', 'company_name', 'company_email', 'company_web_logo',
        'amount_sum', 'newest_cost_date',
        'oldest_cost_date'));

        Helpers::gen_mpdf($mpdf_view, 'cost_summary', rand(1000, 9999).time());

    }

    public function admin_wallet_actions_pdf(Request $request) {
        
        $from = $request['from'];
        $to = $request['to'];
        $date_type = $request['date_type'] ?? 'all_time';
        $data = [];

        $company_phone = BusinessSetting::where('type', 'company_phone')->first()->value;
        $company_email = BusinessSetting::where('type', 'company_email')->first()->value;
        $company_name = BusinessSetting::where('type', 'company_name')->first()->value;
        $company_web_logo = BusinessSetting::where('type', 'company_web_logo')->first()->value;
        
        $admin_wallet_actions = self::admin_wallet_filter($request)->get();

        $costs = self::admin_cost_filter($request);

        $data['commission_earned'] = $admin_wallet_actions->sum('commission_earned') ?? 0;
        $data['collected_cash'] = $admin_wallet_actions->sum('collected_cash') ?? 0;
        $data['costs_and_expenses'] = $costs->sum('amount') ?? 0;

        $mpdf_view = View::make('admin-views.accounting.pdf.admin-wallet-actions-pdf', 
        compact('company_phone', 'company_name', 'company_email', 'company_web_logo',
            'data', 'date_type', 'from', 'to'));

        Helpers::gen_mpdf($mpdf_view, 'admin_wallet_action_', rand(1000, 9999).time());

    }

    public function cost_export_excel(Request $request)
    {

        $search = $request['search'];
        $from = $request['from'];
        $to = $request['to'];
        $date_type = $request['date_type'] ?? 'this_year';

        $costs_query = Cost::when($search, function ($q) use ($search) {
            $q->orWhere('id', 'like', "%{$search}%")
            ->orWhere('title', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
        });

        $costs = self::date_wise_common_filter($costs_query, $date_type, $from, $to);

        $costs = $costs->orderBy('id', 'desc')
        ->paginate(Helpers::pagination_limit());

        if($costs->count() > 0) {
            foreach($costs as $cost) {
                $tranData[] = array(
                    'cost_id' => $cost->id,
                    'amount' => \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($cost->amount)),
                    'title' => $cost->title,
                    'description' => $cost->description,
                    'date' => $cost->created_at,
                );
            }
        } else {
            return back();
        }

        return (new FastExcel($tranData))->download('Costs_and_expenses_Excel.xlsx');

    }

    public function admin_earning_excel_export(Request $request){
        $from         = $request['from'];
        $to           = $request['to'];
        $date_type    = $request['date_type'] ?? 'this_year';

        $filter_data = self::earning_common_filter('admin', $date_type, $from, $to);
        $inhouse_earn = $filter_data['earn_from_order'];
        $admin_commission_earn = $filter_data['commission'];
        $discount_given = $filter_data['discount_given'];
        $total_costs = $filter_data['total_costs'];
        $total_tax = $filter_data['total_tax'];

        $data = array();
        foreach ($inhouse_earn as $key=>$earning) {
            $data[] = array(
                'Duration' => $key,
                'Commission Earning' => BackEndHelper::set_symbol(BackEndHelper::usd_to_currency($admin_commission_earn[$key])),
                'Discount Given' => BackEndHelper::set_symbol(BackEndHelper::usd_to_currency($discount_given[$key])),
                'Tax Collected' => BackEndHelper::set_symbol(BackEndHelper::usd_to_currency($total_tax[$key])),
                'Costs and Expenses' => BackEndHelper::set_symbol(BackEndHelper::usd_to_currency($total_costs[$key])),
                'Total Earning' => BackEndHelper::set_symbol(BackEndHelper::usd_to_currency($admin_commission_earn[$key]-$total_costs[$key])),
            );
        }

        return (new FastExcel($data))->download('admin-earning.xlsx');
    }

    public function admin_earning_pdf(Request $request){
        $from         = $request['from'];
        $to           = $request['to'];
        $date_type    = $request['date_type'] ?? 'this_year';

        $company_phone = BusinessSetting::where('type', 'company_phone')->first()->value;
        $company_email = BusinessSetting::where('type', 'company_email')->first()->value;
        $company_name = BusinessSetting::where('type', 'company_name')->first()->value;
        $company_web_logo = BusinessSetting::where('type', 'company_web_logo')->first()->value;

        $filter_data = self::earning_common_filter('admin', $date_type, $from, $to);
        $inhouse_earn = $filter_data['earn_from_order'];
        $admin_commission_earn = $filter_data['commission'];
        $discount_given = $filter_data['discount_given'];
        $total_costs = $filter_data['total_costs'];
        $total_tax = $filter_data['total_tax'];

        $data = array();
        foreach ($inhouse_earn as $key=>$earning) {
            $data[] = array(
                'duration' => $key,
                'commission_earning' => BackEndHelper::set_symbol(BackEndHelper::usd_to_currency($admin_commission_earn[$key])),
                'discount_given' => BackEndHelper::set_symbol(BackEndHelper::usd_to_currency($discount_given[$key])),
                'tax_collected' => BackEndHelper::set_symbol(BackEndHelper::usd_to_currency($total_tax[$key])),
                'costs_and_expenses' => BackEndHelper::set_symbol(BackEndHelper::usd_to_currency($total_costs[$key])),
                'total_earning' => BackEndHelper::set_symbol(BackEndHelper::usd_to_currency($admin_commission_earn[$key]-$total_costs[$key])),
            );
        }
        
        $mpdf_view = View::make('admin-views.accounting.pdf.admin-earning-pdf', 
        compact('company_phone', 'company_name', 'company_email', 'company_web_logo',
        'data', 'date_type', 'from', 'to'));

        Helpers::gen_mpdf($mpdf_view, 'admin_earning_pdf', rand(1000, 9999).time());

    }

    public function admin_earning(Request $request)
    {
        $from         = $request['from'];
        $to           = $request['to'];
        $date_type    = $request['date_type'] ?? 'this_year';

        $digital_payment_query = Order::where(['order_status' => 'delivered'])->whereNotIn('payment_method', ['cash', 'cash_on_delivery', 'pay_by_wallet', 'offline_payment']);
        $digital_payment = self::earning_common_query($request, $digital_payment_query)->sum('order_amount');

        $cash_payment_query = Order::where(['order_status' => 'delivered'])->whereIn('payment_method', ['cash', 'cash_on_delivery']);
        $cash_payment = self::earning_common_query($request, $cash_payment_query)->sum('order_amount');

        $wallet_payment_query = Order::where(['order_status' => 'delivered'])->where(['payment_method' => 'pay_by_wallet']);
        $wallet_payment = self::earning_common_query($request, $wallet_payment_query)->sum('order_amount');

        $offline_payment_query = Order::where(['payment_method' => 'offline_payment']);
        $offline_payment = self::earning_common_query($request, $offline_payment_query)->sum('order_amount');

        $total_payment = $cash_payment + $wallet_payment + $digital_payment + $offline_payment;

        $payment_data = [
            'total_payment' => $total_payment,
            'cash_payment' => $cash_payment,
            'wallet_payment' => $wallet_payment,
            'offline_payment' => $offline_payment,
            'digital_payment' => $digital_payment,
        ];

        $filter_data = self::earning_common_filter('admin', $date_type, $from, $to);
        $inhouse_earn = $filter_data['earn_from_order'];
        $shipping_earn = $filter_data['shipping_earn'];
        $admin_commission_earn = $filter_data['commission'];
        $refund_given = $filter_data['refund_given'];
        $discount_given = $filter_data['discount_given'];
        $total_tax = $filter_data['total_tax'];
        $admin_bearer_free_shipping = $filter_data['admin_bearer_free_shipping'];

        $total_inhouse_earning = 0;
        $total_commission = 0;
        $total_shipping_earn = 0;
        $total_discount_given = 0;
        $total_refund_given = 0;
        $total_tax_final = 0;
        $total_earning_statistics = array();
        $total_commission_statistics = array();
        foreach($inhouse_earn as $key=>$earning) {
            $total_inhouse_earning += $earning;
            $total_commission += $admin_commission_earn[$key];
            $total_shipping_earn += $shipping_earn[$key];
            $total_discount_given += $discount_given[$key];
            $total_tax_final += $total_tax[$key];
            $total_refund_given += $refund_given[$key];
            $total_commission_statistics[$key] = $admin_commission_earn[$key];
            $total_earning_statistics[$key] = ($earning+$admin_commission_earn[$key]+$shipping_earn[$key])-$discount_given[$key]-$refund_given[$key];
        }

        $total_in_house_products_query = Product::where(['added_by' => 'admin']);
        $total_in_house_products = self::earning_common_query($request, $total_in_house_products_query)->count();

        $total_stores_query = Seller::where(['status' => 'approved']);
        $total_stores = self::earning_common_query($request, $total_stores_query)->count();

        $earning_data = [
            'total_inhouse_earning' => $total_inhouse_earning-$total_tax_final,
            'total_commission' => $total_commission,
            'total_shipping_earn' => $total_shipping_earn,
            'total_in_house_products' => $total_in_house_products,
            'total_stores' => $total_stores,
            'total_earning_statistics' => $total_earning_statistics,
            'total_commission_statistics' => $total_commission_statistics,
        ];

        return view('admin-views.report.admin-earning', compact('earning_data', 'inhouse_earn', 'shipping_earn',
            'admin_commission_earn', 'refund_given', 'discount_given', 'total_tax', 'from', 'to', 'date_type', 'payment_data'));
    }

    public function earning_common_query($request, $query){
        $from         = $request['from'];
        $to           = $request['to'];
        $date_type    = $request['date_type'] ?? 'this_year';

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

    public function earning_common_filter($type, $date_type, $from, $to){

        if($date_type == 'this_year'){ //this year table
            $number = 12;
            $default_inc = 1;
            $current_start_year = date('Y-01-01');
            $current_end_year = date('Y-12-31');
            $from_year = Carbon::parse($from)->format('Y');

            $this_year = self::earning_same_year($type, $current_start_year, $current_end_year, $from_year, $number, $default_inc);
            return $this_year;

        }elseif($date_type == 'this_month'){ //this month table
            $current_month_start = date('Y-m-01');
            $current_month_end = date('Y-m-t');
            $inc = 1;
            $month = date('m');
            $number = date('d',strtotime($current_month_end));

            $this_month = self::earning_same_month($type, $current_month_start, $current_month_end, $month, $number, $inc);
            return $this_month;

        }elseif($date_type == 'this_week'){
            $this_week = self::earning_this_week($type);
            return $this_week;

        }elseif($date_type == 'custom_date' && !empty($from) && !empty($to)){
            $start_date = Carbon::parse($from)->format('Y-m-d 00:00:00');
            $end_date = Carbon::parse($to)->format('Y-m-d 23:59:59');
            $from_year = Carbon::parse($from)->format('Y');
            $from_month = Carbon::parse($from)->format('m');
            $from_day = Carbon::parse($from)->format('d');
            $to_year = Carbon::parse($to)->format('Y');
            $to_month = Carbon::parse($to)->format('m');
            $to_day = Carbon::parse($to)->format('d');

            if($from_year != $to_year){
                $different_year = self::earning_different_year($type, $start_date, $end_date, $from_year, $to_year);
                return $different_year;

            }elseif($from_month != $to_month){
                $same_year = self::earning_same_year($type, $start_date, $end_date, $from_year, $to_month, $from_month);
                return $same_year;

            }elseif($from_month == $to_month){
                $same_month = self::earning_same_month($type, $start_date, $end_date, $from_month, $to_day, $from_day);
                return $same_month;
            }

        }
    }

    public function earning_same_year($type, $start_date, $end_date, $from_year, $number, $default_inc){

        //earn from order
        $earn_from_orders = Order::where(['order_status'=>'delivered', 'seller_is'=>$type])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('(sum(order_amount) - sum(shipping_cost) + sum(CASE WHEN is_shipping_free=1 THEN extra_discount ELSE 0 END)) as earn_from_order, YEAR(updated_at) year, MONTH(updated_at) month')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%M')"))->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $month = date("F", strtotime("2023-$inc-01"));
            $earn_from_order[$month.'-'.$from_year] = 0;
            foreach ($earn_from_orders as $match) {
                if ($match['month'] == $inc) {
                    $earn_from_order[$month.'-'.$from_year] = $match['earn_from_order'];
                }
            }
        }

        //shipping earn
        $shipping_earns = Order::whereHas('delivery_man', function ($query) use($type){
                $query->when($type=='admin', function ($query){
                    $query->where('seller_id', '0');
                })
                ->when($type=='seller', function ($query){
                    $query->where('seller_id', '!=', '0');
                });
            })
            ->selectRaw('sum(shipping_cost) as shipping_earn, YEAR(updated_at) year, MONTH(updated_at) month')
            ->where(['order_type'=>'default_type', 'order_status'=>'delivered'])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%M')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $month = date("F", strtotime("2023-$inc-01"));
            $shipping_earn[$month.'-'.$from_year] = 0;
            foreach ($shipping_earns as $match) {
                if ($match['month'] == $inc) {
                    $shipping_earn[$month.'-'.$from_year] = $match['shipping_earn'];
                }
            }
        }

        //commission
        $commissions = Order::where(['seller_is'=>'seller', 'order_status'=>'delivered'])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(admin_commission) as commission, YEAR(updated_at) year, MONTH(updated_at) month')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%M')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $month = date("F", strtotime("2023-$inc-01"));
            $commission[$month.'-'.$from_year] = 0;
            foreach ($commissions as $match) {
                if ($match['month'] == $inc) {
                    $commission[$month.'-'.$from_year] = $match['commission'];
                }
            }
        }

        //admin bearer free shipping
        $admin_bearer_free_shippings = Order::where(['seller_is'=>'seller', 'order_status'=>'delivered'])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(CASE WHEN is_shipping_free=1 AND free_delivery_bearer="admin" THEN extra_discount ELSE 0 END) as free_shipping_admin_bearer, YEAR(updated_at) year, MONTH(updated_at) month')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%M')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $month = date("F", strtotime("2023-$inc-01"));
            $admin_bearer_free_shipping[$month.'-'.$from_year] = 0;
            foreach ($admin_bearer_free_shippings as $match) {
                if ($match['month'] == $inc) {
                    $admin_bearer_free_shipping[$month.'-'.$from_year] = $match['free_shipping_admin_bearer'];
                }
            }
        }

        //discount_given
        $discounts_given = Order::where(['order_status'=>'delivered'])
            ->when($type=='admin', function ($query){
                $query->selectRaw('(sum(CASE WHEN discount_type="coupon_discount" AND coupon_discount_bearer="inhouse" THEN discount_amount ELSE 0 END) + sum(CASE WHEN is_shipping_free=1 AND free_delivery_bearer="admin" THEN extra_discount ELSE 0 END)) as discount_amount, YEAR(updated_at) year, MONTH(updated_at) month');
            })
            ->when($type=='seller', function ($query){
                $query->selectRaw('(sum(CASE WHEN discount_type="coupon_discount" AND coupon_discount_bearer="seller" THEN discount_amount ELSE 0 END) + sum(CASE WHEN is_shipping_free=1 AND free_delivery_bearer="seller" THEN extra_discount ELSE 0 END)) as discount_amount, YEAR(updated_at) year, MONTH(updated_at) month');
            })
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%M')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $month = date("F", strtotime("2023-$inc-01"));
            $discount_given[$month.'-'.$from_year] = 0;
            foreach ($discounts_given as $match) {
                if ($match['month'] == $inc) {
                    $discount_given[$month.'-'.$from_year] = $match['discount_amount'];
                }
            }
        }

        //vat/tax
        $taxes = OrderTransaction::where(['status'=>'disburse', 'seller_is'=> $type])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(tax) as total_tax, YEAR(updated_at) year, MONTH(updated_at) month')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%M')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $month = date("F", strtotime("2023-$inc-01"));
            $total_tax[$month.'-'.$from_year] = 0;
            foreach ($taxes as $match) {
                if ($match['month'] == $inc) {
                    $total_tax[$month.'-'.$from_year] = $match['total_tax'];
                }
            }
        }

        //refund given
        $refunds = RefundTransaction::where(['payment_status'=>'paid', 'paid_by'=> $type])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(amount) as refund_amount, YEAR(updated_at) year, MONTH(updated_at) month')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%M')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $month = date("F", strtotime("2023-$inc-01"));
            $refund_given[$month.'-'.$from_year] = 0;
            foreach ($refunds as $match) {
                if ($match['month'] == $inc) {
                    $refund_given[$month.'-'.$from_year] = $match['refund_amount'];
                }
            }
        }
        
        //costs and expenses
        $costs = Cost::
            whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(amount) as cost, YEAR(updated_at) year, MONTH(updated_at) month')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%M')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $month = date("F", strtotime("2023-$inc-01"));
            $total_costs[$month.'-'.$from_year] = 0;
            foreach ($costs as $match) {
                if ($match['month'] == $inc) {
                    $total_costs[$month.'-'.$from_year] = $match['cost'];
                }
            }
        }

        $data = array(
            'earn_from_order' => $earn_from_order,
            'shipping_earn' => $shipping_earn,
            'commission' => $commission,
            'discount_given' => $discount_given,
            'total_tax' => $total_tax,
            'refund_given' => $refund_given,
            'total_costs' => $total_costs,
            'admin_bearer_free_shipping' => $admin_bearer_free_shipping,
        );
        return $data;
    }

    public function earning_same_month($type, $start_date, $end_date, $month_date, $number, $default_inc){
        $year_month = date('Y-m', strtotime($start_date));
        $month = date("F", strtotime("$year_month"));

        //earn from order
        $earn_from_orders = Order::where(['order_status'=>'delivered', 'seller_is'=>$type])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('(sum(order_amount) - sum(shipping_cost) + sum(CASE WHEN is_shipping_free=1 THEN extra_discount ELSE 0 END)) as earn_from_order, YEAR(updated_at) year, MONTH(updated_at) month, DAY(updated_at) day')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $day = date('jS', strtotime("$year_month-$inc"));
            $earn_from_order[$day.'-'.$month] = 0;
            foreach ($earn_from_orders as $match) {
                if ($match['day'] == $inc) {
                    $earn_from_order[$day.'-'.$month] = $match['earn_from_order'];
                }
            }
        }

        //shipping earn
        $shipping_earns = Order::whereHas('delivery_man', function ($query) use($type){
                $query->when($type=='admin', function ($query){
                    $query->where('seller_id', '0');
                })
                ->when($type=='seller', function ($query){
                    $query->where('seller_id', '!=', '0');
                });
            })
            ->selectRaw('sum(shipping_cost) as shipping_earn, YEAR(updated_at) year, MONTH(updated_at) month, DAY(updated_at) day')
            ->where(['order_type'=>'default_type', 'order_status'=>'delivered'])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $day = date('jS', strtotime("$year_month-$inc"));
            $shipping_earn[$day.'-'.$month] = 0;
            foreach ($shipping_earns as $match) {
                if ($match['day'] == $inc) {
                    $shipping_earn[$day.'-'.$month] = $match['shipping_earn'];
                }
            }
        }

        //commission
        $commissions = Order::where(['seller_is'=>'seller', 'order_status'=>'delivered'])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(admin_commission) as commission, YEAR(updated_at) year, MONTH(updated_at) month, DAY(updated_at) day')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $day = date('jS', strtotime("$year_month-$inc"));
            $commission[$day.'-'.$month] = 0;
            foreach ($commissions as $match) {
                if ($match['day'] == $inc) {
                    $commission[$day.'-'.$month] = $match['commission'];
                }
            }
        }

        //admin bearer free shipping
        $admin_bearer_free_shippings = Order::where(['seller_is'=>'seller', 'order_status'=>'delivered'])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(CASE WHEN is_shipping_free=1 AND free_delivery_bearer="admin" THEN extra_discount ELSE 0 END) as free_shipping_admin_bearer, YEAR(updated_at) year, MONTH(updated_at) month, DAY(updated_at) day')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $day = date('jS', strtotime("$year_month-$inc"));
            $admin_bearer_free_shipping[$day.'-'.$month] = 0;
            foreach ($admin_bearer_free_shippings as $match) {
                if ($match['day'] == $inc) {
                    $admin_bearer_free_shipping[$day.'-'.$month] = $match['free_shipping_admin_bearer'];
                }
            }
        }

        //discount_given
        $discounts_given = Order::where(['order_status'=>'delivered'])
            ->when($type=='admin', function ($query){
                $query->where('coupon_discount_bearer', 'inhouse');
            })
            ->when($type=='seller', function ($query){
                $query->where('coupon_discount_bearer', 'seller');
            })
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('(sum(CASE WHEN discount_type="coupon_discount" THEN discount_amount ELSE 0 END) + sum(CASE WHEN is_shipping_free=1 AND free_delivery_bearer="admin" THEN extra_discount ELSE 0 END)) as discount_amount, YEAR(updated_at) year, MONTH(updated_at) month, DAY(updated_at) day')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $day = date('jS', strtotime("$year_month-$inc"));
            $discount_given[$day.'-'.$month] = 0;
            foreach ($discounts_given as $match) {
                if ($match['day'] == $inc) {
                    $discount_given[$day.'-'.$month] = $match['discount_amount'];
                }
            }
        }

        //vat/tax
        $taxes = OrderTransaction::where(['seller_is'=> $type, 'status'=>'disburse'])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(tax) as total_tax, YEAR(updated_at) year, MONTH(updated_at) month, DAY(updated_at) day')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $day = date('jS', strtotime("$year_month-$inc"));
            $total_tax[$day.'-'.$month] = 0;
            foreach ($taxes as $match) {
                if ($match['day'] == $inc) {
                    $total_tax[$day.'-'.$month] = $match['total_tax'];
                }
            }
        }

        //refund given
        $refunds = RefundTransaction::where(['payment_status'=>'paid', 'paid_by'=> $type])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(amount) as refund_amount, YEAR(updated_at) year, MONTH(updated_at) month, DAY(updated_at) day')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $day = date('jS', strtotime("$year_month-$inc"));
            $refund_given[$day.'-'.$month] = 0;
            foreach ($refunds as $match) {
                if ($match['day'] == $inc) {
                    $refund_given[$day.'-'.$month] = $match['refund_amount'];
                }
            }
        }

        //costs and expenses
        $costs = Cost::
            whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(amount) as cost, YEAR(updated_at) year, MONTH(updated_at) month, DAY(updated_at) day')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
            ->latest('updated_at')->get();

        for ($inc = $default_inc; $inc <= $number; $inc++) {
            $day = date('jS', strtotime("$year_month-$inc"));
            $total_costs[$day.'-'.$month] = 0;
            foreach ($costs as $match) {
                if ($match['day'] == $inc) {
                    $total_costs[$day.'-'.$month] = $match['cost'];
                }
            }
        }

        $data = array(
            'earn_from_order' => $earn_from_order,
            'admin_bearer_free_shipping' => $admin_bearer_free_shipping,
            'shipping_earn' => $shipping_earn,
            'commission' => $commission,
            'discount_given' => $discount_given,
            'total_tax' => $total_tax,
            'total_costs' => $total_costs,
            'refund_given' => $refund_given,
        );
        return $data;
    }

    public function earning_this_week($type){
        $number = 6;
        $period = CarbonPeriod::create(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek());
        $day_name = array();
        foreach ($period as $date) {
            array_push($day_name, $date->format('l'));
        }

        //earn from order
        $earn_from_orders = Order::where(['order_status'=>'delivered', 'seller_is'=>$type])
            ->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->select(
                DB::raw('(sum(order_amount) - sum(shipping_cost) + sum(CASE WHEN is_shipping_free=1 THEN extra_discount ELSE 0 END)) as earn_from_order'),
                DB::raw("(DATE_FORMAT(updated_at, '%W')) as day")
            )->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))->latest('updated_at')->get();

        for ($inc = 0; $inc <= $number; $inc++) {
            $earn_from_order[$day_name[$inc]] = 0;
            foreach ($earn_from_orders as $match) {
                if ($match['day'] == $day_name[$inc]) {
                    $earn_from_order[$day_name[$inc]] = $match['earn_from_order'];
                }
            }
        }

        //shipping earn
        $shipping_earns = Order::whereHas('delivery_man', function ($query) use($type){
                $query->when($type=='admin', function ($query){
                    $query->where('seller_id', '0');
                })
                ->when($type=='seller', function ($query){
                    $query->where('seller_id', '!=', '0');
                });
            })
            ->select(
                DB::raw('sum(shipping_cost) as shipping_earn'),
                DB::raw("(DATE_FORMAT(updated_at, '%W')) as day")
            )
            ->where(['order_type'=>'default_type', 'order_status'=>'delivered'])
            ->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
            ->latest('updated_at')->get();

        for ($inc = 0; $inc <= $number; $inc++) {
            $shipping_earn[$day_name[$inc]] = 0;
            foreach ($shipping_earns as $match) {
                if ($match['day'] == $day_name[$inc]) {
                    $shipping_earn[$day_name[$inc]] = $match['shipping_earn'];
                }
            }
        }

        //commission
        $commissions = Order::where(['seller_is'=>'seller', 'order_status'=>'delivered'])
            ->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->select(
                DB::raw('sum(admin_commission) as commission'),
                DB::raw("(DATE_FORMAT(updated_at, '%W')) as day")
            )
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
            ->latest('updated_at')->get();

        for ($inc = 0; $inc <= $number; $inc++) {
            $commission[$day_name[$inc]] = 0;
            foreach ($commissions as $match) {
                if ($match['day'] == $day_name[$inc]) {
                    $commission[$day_name[$inc]] = $match['commission'];
                }
            }
        }

        //admin bearer free shipping
        $admin_bearer_free_shippings = Order::where(['seller_is'=>'seller', 'order_status'=>'delivered'])
            ->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->select(
                DB::raw('sum(CASE WHEN is_shipping_free=1 AND free_delivery_bearer="admin" THEN extra_discount ELSE 0 END) as free_shipping_admin_bearer'),
                DB::raw("(DATE_FORMAT(updated_at, '%W')) as day")
            )
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
            ->latest('updated_at')->get();

        for ($inc = 0; $inc <= $number; $inc++) {
            $admin_bearer_free_shipping[$day_name[$inc]] = 0;
            foreach ($admin_bearer_free_shippings as $match) {
                if ($match['day'] == $day_name[$inc]) {
                    $admin_bearer_free_shipping[$day_name[$inc]] = $match['free_shipping_admin_bearer'];
                }
            }
        }

        //discount_given
        $discounts_given = Order::where(['order_status'=>'delivered'])
            ->when($type=='admin', function ($query){
                $query->where('coupon_discount_bearer', 'inhouse');
            })
            ->when($type=='seller', function ($query){
                $query->where('coupon_discount_bearer', 'seller');
            })
            ->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->select(
                DB::raw('(sum(CASE WHEN discount_type="coupon_discount" THEN discount_amount ELSE 0 END) + sum(CASE WHEN is_shipping_free=1 AND free_delivery_bearer="admin" THEN extra_discount ELSE 0 END)) as discount_amount'),
                DB::raw("(DATE_FORMAT(updated_at, '%W')) as day")
            )
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
            ->latest('updated_at')->get();

        for ($inc = 0; $inc <= $number; $inc++) {
            $discount_given[$day_name[$inc]] = 0;
            foreach ($discounts_given as $match) {
                if ($match['day'] == $day_name[$inc]) {
                    $discount_given[$day_name[$inc]] = $match['discount_amount'];
                }
            }
        }

        //vat/tax
        $taxes = OrderTransaction::where(['status'=>'disburse', 'seller_is'=> $type])
            ->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->select(
                DB::raw('sum(tax) as total_tax'),
                DB::raw("(DATE_FORMAT(updated_at, '%W')) as day")
            )
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
            ->latest('updated_at')->get();

        for ($inc = 0; $inc <= $number; $inc++) {
            $total_tax[$day_name[$inc]] = 0;
            foreach ($taxes as $match) {
                if ($match['day'] == $day_name[$inc]) {
                    $total_tax[$day_name[$inc]] = $match['total_tax'];
                }
            }
        }

        //refund given
        $refunds = RefundTransaction::where(['payment_status'=>'paid', 'paid_by'=> $type])
            ->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->select(
                DB::raw('sum(amount) as refund_amount'),
                DB::raw("(DATE_FORMAT(updated_at, '%W')) as day")
            )
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
            ->latest('updated_at')->get();

        for ($inc = 0; $inc <= $number; $inc++) {
            $refund_given[$day_name[$inc]] = 0;
            foreach ($refunds as $match) {
                if ($match['day'] == $day_name[$inc]) {
                    $refund_given[$day_name[$inc]] = $match['refund_amount'];
                }
            }
        }

        //costs and expenses
        $costs = Cost::
        whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->select(
            DB::raw('sum(amount) as cost'),
            DB::raw("(DATE_FORMAT(updated_at, '%W')) as day")
        )
        ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%D')"))
        ->latest('updated_at')->get();

        for ($inc = 0; $inc <= $number; $inc++) {
            $total_costs[$day_name[$inc]] = 0;
            foreach ($costs as $match) {
                if ($match['day'] == $day_name[$inc]) {
                    $total_costs[$day_name[$inc]] = $match['cost'];
                }
            }
        }
    

        $data = array(
            'earn_from_order' => $earn_from_order,
            'shipping_earn' => $shipping_earn,
            'commission' => $commission,
            'discount_given' => $discount_given,
            'total_tax' => $total_tax,
            'refund_given' => $refund_given,
            'total_costs' => $total_costs,
            'admin_bearer_free_shipping' => $admin_bearer_free_shipping,
        );
        return $data;
    }

    public function earning_different_year($type, $start_date, $end_date, $from_year, $to_year){

        //earn from order for different year
        $earn_from_orders = Order::where(['order_status'=>'delivered', 'seller_is'=>$type])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('(sum(order_amount) - sum(shipping_cost) + sum(CASE WHEN is_shipping_free=1 THEN extra_discount ELSE 0 END)) as earn_from_order, YEAR(updated_at) year')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%Y')"))->latest('updated_at')->get();


        for ($inc = $from_year; $inc <= $to_year; $inc++) {
            $earn_from_order[$inc] = 0;
            foreach ($earn_from_orders as $match) {
                if ($match['year'] == $inc) {
                    $earn_from_order[$inc] = $match['earn_from_order'];
                }
            }
        }

        //shipping earn for custom same year
        $shipping_earns = Order::whereHas('delivery_man', function ($query) use($type){
                $query->when($type=='admin', function ($query){
                    $query->where('seller_id', '0');
                })
                ->when($type=='seller', function ($query){
                    $query->where('seller_id', '!=', '0');
                });
            })
            ->where(['order_type'=>'default_type', 'order_status'=>'delivered', 'is_shipping_free'=>'0'])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(shipping_cost) as shipping_earn, YEAR(updated_at) year')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%Y')"))
            ->latest('updated_at')->get();

        for ($inc = $from_year; $inc <= $to_year; $inc++) {
            $shipping_earn[$inc] = 0;
            foreach ($shipping_earns as $match) {
                if ($match['year'] == $inc) {
                    $shipping_earn[$inc] = $match['shipping_earn'];
                }
            }
        }

        //commission
        $commissions = Order::where(['seller_is'=>'seller', 'order_status'=>'delivered'])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(admin_commission) as commission, YEAR(updated_at) year')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%Y')"))
            ->latest('updated_at')->get();

        for ($inc = $from_year; $inc <= $to_year; $inc++) {
            $commission[$inc] = 0;
            foreach ($commissions as $match) {
                if ($match['year'] == $inc) {
                    $commission[$inc] = $match['commission'];
                }
            }
        }

        //admin bearer free shipping
        $admin_bearer_free_shippings = Order::where(['seller_is'=>'seller', 'order_status'=>'delivered'])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(CASE WHEN is_shipping_free=1 AND free_delivery_bearer="admin" THEN extra_discount ELSE 0 END) as free_shipping_admin_bearer, YEAR(updated_at) year')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%Y')"))
            ->latest('updated_at')->get();

        for ($inc = $from_year; $inc <= $to_year; $inc++) {
            $admin_bearer_free_shipping[$inc] = 0;
            foreach ($admin_bearer_free_shippings as $match) {
                if ($match['year'] == $inc) {
                    $admin_bearer_free_shipping[$inc] = $match['free_shipping_admin_bearer'];
                }
            }
        }

        //discount_given
        $discounts_given = Order::where(['discount_type'=>'coupon_discount','order_status'=>'delivered'])
            ->when($type=='admin', function ($query){
                $query->where('coupon_discount_bearer', 'inhouse');
            })
            ->when($type=='seller', function ($query){
                $query->where('coupon_discount_bearer', 'seller');
            })
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('(sum(CASE WHEN discount_type="coupon_discount" THEN discount_amount ELSE 0 END) + sum(CASE WHEN is_shipping_free=1 AND free_delivery_bearer="admin" THEN extra_discount ELSE 0 END)) as discount_amount, YEAR(updated_at) year')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%Y')"))
            ->latest('updated_at')->get();

        for ($inc = $from_year; $inc <= $to_year; $inc++) {
            $discount_given[$inc] = 0;
            foreach ($discounts_given as $match) {
                if ($match['year'] == $inc) {
                    $discount_given[$inc] = $match['discount_amount'];
                }
            }
        }

        //vat/tax
        $taxes = OrderTransaction::where(['status'=>'disburse', 'seller_is'=> $type])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(tax) as total_tax, YEAR(updated_at) year')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%Y')"))
            ->latest('updated_at')->get();

        for ($inc = $from_year; $inc <= $to_year; $inc++) {
            $total_tax[$inc] = 0;
            foreach ($taxes as $match) {
                if ($match['year'] == $inc) {
                    $total_tax[$inc] = $match['total_tax'];
                }
            }
        }

        //refund given
        $refunds = RefundTransaction::where(['payment_status'=>'paid', 'paid_by'=> $type])
            ->whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(amount) as refund_amount, YEAR(updated_at) year')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%Y')"))
            ->latest('updated_at')->get();

        for ($inc = $from_year; $inc <= $to_year; $inc++) {
            $refund_given[$inc] = 0;
            foreach ($refunds as $match) {
                if ($match['year'] == $inc) {
                    $refund_given[$inc] = $match['refund_amount'];
                }
            }
        }

        //refund given
        $costs = Cost::
            whereDate('updated_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->selectRaw('sum(amount) as cost, YEAR(updated_at) year')
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%Y')"))
            ->latest('updated_at')->get();

        for ($inc = $from_year; $inc <= $to_year; $inc++) {
            $total_costs[$inc] = 0;
            foreach ($costs as $match) {
                if ($match['year'] == $inc) {
                    $total_costs[$inc] = $match['cost'];
                }
            }
        }

        $data = array(
            'earn_from_order' => $earn_from_order,
            'shipping_earn' => $shipping_earn,
            'commission' => $commission,
            'discount_given' => $discount_given,
            'total_tax' => $total_tax,
            'refund_given' => $refund_given,
            'total_costs' => $total_costs,
            'admin_bearer_free_shipping' => $admin_bearer_free_shipping,
        );
        return $data;
    }














}

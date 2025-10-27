<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\User;
use App\Model\Ad;
use Carbon\Carbon;
use App\Model\Shop;
use App\Model\Brand;
use App\Model\Order;
use App\Model\Product;
use App\Model\Category;
use App\Model\OrderDetail;
use Illuminate\Http\Request;
use App\Model\OrderTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {

        // $most_viewed_ads = Ad::rightJoin('reviews', 'reviews.ad_id', '=', 'ads.id')
        // ->groupBy('ad_id')
        // ->select(['ad_id',
        //     DB::raw('AVG(reviews.rating) as ratings_average'),
        //     DB::raw('count(*) as total')
        // ])
        // ->orderBy('total', 'desc')
        // ->take(6)
        // ->get();

        $from = Carbon::now()->startOfYear()->format('Y-m-d');
        $to = Carbon::now()->endOfYear()->format('Y-m-d');

        $data = self::order_stats_data();
        $data['brand'] = Brand::count();

        $data['ads_count'] = Ad::count();
        $data['users_count'] = User::count();
        $data['paid_banners_count'] = 0;
        $data['categories_count'] = Category::count();
        $data['categories_ads_count'] = Category::select('id', 'name', 'icon')
        ->withCount('ads')
        ->get();

        return view('admin-views.system.dashboard', compact('data'));
    }

    public function order_stats(Request $request)
    {
        session()->put('statistics_type', $request['statistics_type']);
        $data = self::order_stats_data();

        return response()->json([
            'view' => view('admin-views.partials._dashboard-order-stats', compact('data'))->render()
        ], 200);
    }

    public function order_stats_data()
    {

        $pending_query = Order::where(['order_status' => 'pending']);
        $pending = self::common_query_order_stats($pending_query);

        $confirmed_query = Order::where(['order_status' => 'confirmed']);
        $confirmed = self::common_query_order_stats($confirmed_query);

        $processing_query = Order::where(['order_status' => 'processing']);
        $processing = self::common_query_order_stats($processing_query);

        $out_for_delivery_query = Order::where(['order_status' => 'out_for_delivery']);
        $out_for_delivery = self::common_query_order_stats($out_for_delivery_query);

        $delivered_query = Order::where(['order_status' => 'delivered']);
        $delivered = self::common_query_order_stats($delivered_query);

        $canceled_query = Order::where(['order_status' => 'canceled']);
        $canceled = self::common_query_order_stats($canceled_query);

        $returned_query = Order::where(['order_status' => 'returned']);
        $returned = self::common_query_order_stats($returned_query);

        $failed_query = Order::where(['order_status' => 'failed']);
        $failed = self::common_query_order_stats($failed_query);

        $total_sale_query = OrderDetail::where(['delivery_status' => 'delivered']);
        $total_sale = self::common_query_order_stats($total_sale_query);

        $product_query = new Product();
        $product = self::common_query_order_stats($product_query);

        $order_query = new Order();
        $order = self::common_query_order_stats($order_query);

        $customer_query = new User();
        $customer = self::common_query_order_stats($customer_query);

        $store_query = Shop::whereHas('seller', function($query){
            return $query;
        });
        $store = self::common_query_order_stats($store_query);

        $data = [
            'total_sale' => $total_sale,
            'product' => $product,
            'order' => $order,
            'customer' => $customer,
            'store' => $store,
            'pending' => $pending,
            'confirmed' => $confirmed,
            'processing' => $processing,
            'out_for_delivery' => $out_for_delivery,
            'delivered' => $delivered,
            'canceled' => $canceled,
            'returned' => $returned,
            'failed' => $failed
        ];

        return $data;
    }

    public function common_query_order_stats($query){
        $today = session()->has('statistics_type') && session('statistics_type') == 'today' ? 1 : 0;
        $this_month = session()->has('statistics_type') && session('statistics_type') == 'this_month' ? 1 : 0;

        return $query->when($today, function ($query) {
            return $query->whereDate('created_at', Carbon::today());
        })
            ->when($this_month, function ($query) {
                return $query->whereMonth('created_at', Carbon::now());
            })
            ->count();
    }

    /**
     * get earning statistics by ajax
     */
    public function get_earning_statitics(Request $request){
        $dateType = $request->type;

        $inhouse_data = array();
        if($dateType == 'yearEarn') {
            $number = 12;
            $from = Carbon::now()->startOfYear()->format('Y-m-d');
            $to = Carbon::now()->endOfYear()->format('Y-m-d');

            $inhouse_earnings = OrderTransaction::where([
                'seller_is'=>'admin',
                'status'=>'disburse'
            ])->select(
                DB::raw('IFNULL(sum(seller_amount),0) as sums'),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month')
            )->whereBetween('created_at', [$from, $to])->groupby('year', 'month')->get()->toArray();

            for ($inc = 1; $inc <= $number; $inc++) {
                $inhouse_data[$inc] = 0;
                foreach ($inhouse_earnings as $match) {
                    if ($match['month'] == $inc) {
                        $inhouse_data[$inc] = $match['sums'];
                    }
                }
            }
            $key_range = array("Jan","Feb","Mar","April","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

        }elseif($dateType == 'MonthEarn') {
            $from = date('Y-m-01');
            $to = date('Y-m-t');
            $number = date('d',strtotime($to));
            $key_range = range(1, $number);

            $inhouse_earnings = OrderTransaction::where([
                'seller_is' => 'admin',
                'status' => 'disburse'
            ])->select(
                DB::raw('seller_amount'),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month, DAY(created_at) day')
            )->whereBetween('created_at', [$from, $to])->groupby('day')->get()->toArray();

            for ($inc = 1; $inc <= $number; $inc++) {
                $inhouse_data[$inc] = 0;
                foreach ($inhouse_earnings as $match) {
                    if ($match['day'] == $inc) {
                        $inhouse_data[$inc] = $match['seller_amount'];
                    }
                }
            }

        }elseif($dateType == 'WeekEarn') {

            $from = Carbon::now()->startOfWeek()->format('Y-m-d');
            $to = Carbon::now()->endOfWeek()->format('Y-m-d');

            $number_start =date('d',strtotime($from));
            $number_end =date('d',strtotime($to));

            $inhouse_earnings = OrderTransaction::where([
                'seller_is' => 'admin',
                'status' => 'disburse'
            ])->select(
                DB::raw('seller_amount'),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month, DAY(created_at) day')
            )->whereBetween('created_at', [$from, $to])->get()->toArray();

            for ($inc = $number_start; $inc <= $number_end; $inc++) {
                $inhouse_data[$inc] = 0;
                foreach ($inhouse_earnings as $match) {
                    if ($match['day'] == $inc) {
                        $inhouse_data[$inc] = $match['seller_amount'];
                    }
                }
            }

            $key_range = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        }

        $inhouse_label = $key_range;

        $inhouse_data_final = $inhouse_data;

        $seller_data = array();
        if($dateType == 'yearEarn') {
            $number = 12;
            $from = Carbon::now()->startOfYear()->format('Y-m-d');
            $to = Carbon::now()->endOfYear()->format('Y-m-d');

            $seller_earnings = OrderTransaction::where([
                'seller_is'=>'seller',
                'status'=>'disburse'
            ])->select(
                DB::raw('IFNULL(sum(seller_amount),0) as sums'),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month')
            )->whereBetween('created_at', [$from, $to])->groupby('year', 'month')->get()->toArray();

            for ($inc = 1; $inc <= $number; $inc++) {
                $seller_data[$inc] = 0;
                foreach ($seller_earnings as $match) {
                    if ($match['month'] == $inc) {
                        $seller_data[$inc] = $match['sums'];
                    }
                }
            }
            $key_range = array("Jan","Feb","Mar","April","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

        }elseif($dateType == 'MonthEarn') {
            $from = date('Y-m-01');
            $to = date('Y-m-t');
            $number = date('d',strtotime($to));
            $key_range = range(1, $number);

            $seller_earnings = OrderTransaction::where([
                'seller_is' => 'seller',
                'status' => 'disburse'
            ])->select(
                DB::raw('seller_amount'),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month, DAY(created_at) day')
            )->whereBetween('created_at', [$from, $to])->groupby('day')->get()->toArray();

            for ($inc = 1; $inc <= $number; $inc++) {
                $seller_data[$inc] = 0;
                foreach ($seller_earnings as $match) {
                    if ($match['day'] == $inc) {
                        $seller_data[$inc] = $match['seller_amount'];
                    }
                }
            }

        }elseif($dateType == 'WeekEarn') {

            $from = Carbon::now()->startOfWeek()->format('Y-m-d');
            $to = Carbon::now()->endOfWeek()->format('Y-m-d');

            $number_start =date('d',strtotime($from));
            $number_end =date('d',strtotime($to));

            $seller_earnings = OrderTransaction::where([
                'seller_is' => 'seller',
                'status' => 'disburse'
            ])->select(
                DB::raw('seller_amount'),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month, DAY(created_at) day')
            )->whereBetween('created_at', [$from, $to])->get()->toArray();

            for ($inc = $number_start; $inc <= $number_end; $inc++) {
                $seller_data[$inc] = 0;
                foreach ($seller_earnings as $match) {
                    if ($match['day'] == $inc) {
                        $seller_data[$inc] = $match['seller_amount'];
                    }
                }
            }

            $key_range = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        }

        $seller_label = $key_range;

        $seller_data_final = $seller_data;

        $commission_data = array();
        if($dateType == 'yearEarn') {
            $number = 12;
            $from = Carbon::now()->startOfYear()->format('Y-m-d');
            $to = Carbon::now()->endOfYear()->format('Y-m-d');

            $commission_earnings = OrderTransaction::where([
                'status'=>'disburse'
            ])->select(
                DB::raw('IFNULL(sum(admin_commission),0) as sums'),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month')
            )->whereBetween('created_at', [$from, $to])->groupby('year', 'month')->get()->toArray();

            for ($inc = 1; $inc <= $number; $inc++) {
                $commission_data[$inc] = 0;
                foreach ($commission_earnings as $match) {
                    if ($match['month'] == $inc) {
                        $commission_data[$inc] = $match['sums'];
                    }
                }
            }

            $key_range = array("Jan","Feb","Mar","April","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

        }elseif($dateType == 'MonthEarn') {
            $from = date('Y-m-01');
            $to = date('Y-m-t');
            $number = date('d',strtotime($to));
            $key_range = range(1, $number);

            $commission_earnings = OrderTransaction::where([
                'seller_is' => 'seller',
                'status' => 'disburse'
            ])->select(
                DB::raw('admin_commission'),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month, DAY(created_at) day')
            )->whereBetween('created_at', [$from, $to])->groupby('day')->get()->toArray();

            for ($inc = 1; $inc <= $number; $inc++) {
                $commission_data[$inc] = 0;
                foreach ($commission_earnings as $match) {
                    if ($match['day'] == $inc) {
                        $commission_data[$inc] = $match['admin_commission'];
                    }
                }
            }

        }elseif($dateType == 'WeekEarn') {

            $from = Carbon::now()->startOfWeek()->format('Y-m-d');
            $to = Carbon::now()->endOfWeek()->format('Y-m-d');

            $number_start =date('d',strtotime($from));
            $number_end =date('d',strtotime($to));

            $commission_earnings = OrderTransaction::where([
                'status' => 'disburse'
            ])->select(
                DB::raw('admin_commission'),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month, DAY(created_at) day')
            )->whereBetween('created_at', [$from, $to])->get()->toArray();

            for ($inc = $number_start; $inc <= $number_end; $inc++) {
                $commission_data[$inc] = 0;
                foreach ($commission_earnings as $match) {
                    if ($match['day'] == $inc) {
                        $commission_data[$inc] = $match['admin_commission'];
                    }
                }
            }
            $key_range = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        }

        $commission_label = $key_range;

        $commission_data_final = $commission_data;

        $data = array(
            'inhouse_label' => $inhouse_label,
            'inhouse_earn' => array_values($inhouse_data_final),
            'seller_label' => $seller_label,
            'seller_earn' => array_values($seller_data_final),
            'commission_label' => $commission_label,
            'commission_earn' => array_values($commission_data_final)
        );

        return response()->json($data);
    }
}

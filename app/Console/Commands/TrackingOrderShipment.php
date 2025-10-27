<?php

namespace App\Console\Commands;

use App\CPU\Convert;
use App\CPU\Helpers;
use App\Model\Order;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\CPU\OrderManager;
use App\CPU\BackEndHelper;
use App\Model\OrderDetail;
use App\Traits\CommonTrait;
use App\CPU\CustomerManager;
use App\Model\BusinessSetting;
use Illuminate\Console\Command;
use App\Model\DeliverymanWallet;
use App\Model\OrderStatusHistory;
use App\Services\ShippingTracking;
use Illuminate\Support\Facades\Log;
use App\Model\DeliveryManTransaction;

class TrackingOrderShipment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shipment:tracking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command to make schedule tasks to tracking order if delivered or not';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Order::where('is_tracked', 0)
        ->where('payment_status', 'paid')
        ->whereNotNull('delivery_service_name')
        ->whereNotNull('third_party_delivery_tracking_id')
        ->whereIn('order_status', ['pending', 'confirmed', 'shipped', 'packaging'])
        ->get();

        foreach($orders as $order) {

            $order_shipping_status = (new ShippingTracking)->track($order->third_party_delivery_tracking_id);

            if($order_shipping_status != 'delivered') {
                continue;
            }

            if(!$order->is_guest && !isset($order->customer))
            {
                continue;
            }

            $wallet_status = Helpers::get_business_settings('wallet_status');
            $loyalty_point_status = Helpers::get_business_settings('loyalty_point_status');

            Helpers::send_order_notification($order_shipping_status,'customer',$order);
            
            $order->order_status = $order_shipping_status;
            OrderManager::stock_update_on_order_status_change($order, $order_shipping_status);

            if ($order_shipping_status == 'delivered' && $order['seller_id'] != null) {
                OrderManager::wallet_manage_on_order_status_change($order, 'seller');
                OrderDetail::where('order_id', $order->id)->update(
                    ['delivery_status'=>'delivered']
                );
            }

            $order->save();

            if($wallet_status == 1 && $loyalty_point_status == 1 && !$order->is_guest)
            {
                if($order_shipping_status == 'delivered' && $order->payment_status =='paid'){
                    CustomerManager::create_loyalty_point_transaction($order->customer_id, $order->id, Convert::default($order->order_amount-$order->shipping_cost), 'order_place');
                }
            }

            $ref_earning_status = BusinessSetting::where('type', 'ref_earning_status')->first()->value ?? 0;
            $ref_earning_exchange_rate = BusinessSetting::where('type', 'ref_earning_exchange_rate')->first()->value ?? 0;

            if(!$order->is_guest && $wallet_status == 1 && $ref_earning_status == 1 && $order_shipping_status == 'delivered' && $order->payment_status =='paid'){

                $customer = User::find($order->customer_id);
                $is_first_order = Order::where(['customer_id'=>$order->customer_id,'order_status'=>'delivered','payment_status'=>'paid'])->count();
                $referred_by_user = User::find($customer->referred_by);

                if ($is_first_order == 1 && isset($customer->referred_by) && isset($referred_by_user)){
                    CustomerManager::create_wallet_transaction($referred_by_user->id, floatval($ref_earning_exchange_rate), 'add_fund_by_admin', 'earned_by_referral');
                }
            }

            if ($order->delivery_man_id && $order_shipping_status == 'delivered') {
                $dm_wallet = DeliverymanWallet::where('delivery_man_id', $order->delivery_man_id)->first();
                $cash_in_hand = $order->payment_method == 'cash_on_delivery' ? $order->order_amount : 0;

                if (empty($dm_wallet)) {
                    DeliverymanWallet::create([
                        'delivery_man_id' => $order->delivery_man_id,
                        'current_balance' => BackEndHelper::currency_to_usd($order->deliveryman_charge) ?? 0,
                        'cash_in_hand' => BackEndHelper::currency_to_usd($cash_in_hand),
                        'pending_withdraw' => 0,
                        'total_withdraw' => 0,
                    ]);
                } else {
                    $dm_wallet->current_balance += BackEndHelper::currency_to_usd($order->deliveryman_charge) ?? 0;
                    $dm_wallet->cash_in_hand += BackEndHelper::currency_to_usd($cash_in_hand);
                    $dm_wallet->save();
                }

                if($order->deliveryman_charge && $order_shipping_status == 'delivered'){
                    DeliveryManTransaction::create([
                        'delivery_man_id' => $order->delivery_man_id,
                        'user_id' => auth('seller')->id(),
                        'user_type' => 'seller',
                        'credit' => BackEndHelper::currency_to_usd($order->deliveryman_charge) ?? 0,
                        'transaction_id' => Uuid::uuid4(),
                        'transaction_type' => 'deliveryman_charge'
                    ]);
                }
            }

            $delivery_history = new OrderStatusHistory();
            $delivery_history->order_id = $order->id;
            $delivery_history->user_id = $order->seller_id;
            $delivery_history->user_type = 'seller';
            $delivery_history->status = $order_shipping_status;
            $delivery_history->cause = null;

            $delivery_history->save();

            $order->is_tracked = 1;
            $order->save();
            
            Log::debug('order:'.$order->id.' status changed to delivered successfully');

        }
        
    


    }
}

<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\CPU\Convert;
use App\CPU\Helpers;
use App\Model\Seller;
use App\Model\AdminWallet;
use App\Model\SellerWallet;
use Illuminate\Support\Str;
use App\Model\BusinessSetting;
use App\Model\WithdrawalMethod;
use Illuminate\Console\Command;
use App\Model\SellerPayoutHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Model\SellerBalanceTransaction;
use App\Model\SellerWalletActionHistory;

class SendBalanceAutomatically extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command to send sellers balance automatically each specific duration';

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
        $automatic_balance_request = BusinessSetting::where('type','automatic_balance_request')->first();

        if($automatic_balance_request->value == 1) {

            $last_automatic_balance_sending = BusinessSetting::where('type','last_automatic_balance_sending')->first();
            $automatic_balance_request_duration = BusinessSetting::where('type','automatic_balance_request_duration')->first();
            $minimum_withdraw_value = BusinessSetting::where('type','minimum_withdraw_value')->first();
            
            $default_payment_method = WithdrawalMethod::where('is_default', 1)->get()->first(); 

            $lastAutomaticBalanceSendingDate = Carbon::parse($last_automatic_balance_sending->value);
            
            if($lastAutomaticBalanceSendingDate->diffInDays(now()) > $automatic_balance_request_duration->value) {

                $seller_wallets = SellerWallet::with('seller')->get();
                $admin_wallet = AdminWallet::where('admin_id', 1)->get()->first();
        
                foreach($seller_wallets as $wallet){
                    if($wallet->total_earning > 0 || $wallet->total_earning >= $minimum_withdraw_value->value) {
    
                        $seller_fcm_token = $wallet->seller->cm_firebase_token;
                        if($seller_fcm_token) {
                            $lang = $wallet->seller?->app_language ?? Helpers::default_lang();
                            $value_seller = Helpers::push_notificatoin_message('withdraw_request_status_message','seller',$lang);
                            if ($value_seller != null) {
                                $data = [
                                    'title' => translate('sending_balance_with_success'),
                                    'description' => $value_seller,
                                    'image' => '',
                                    'type' => 'notification'
                                ];
                                Helpers::send_push_notif_to_device($seller_fcm_token, $data);
                            }
                        }

                        $seller_payout_history = new SellerPayoutHistory;
                            
                        $seller_payout_history->old_pending_withdraw = $wallet->pending_withdraw;
                        $seller_payout_history->old_total_earning = $wallet->total_earning;
                        $seller_payout_history->old_withdrawn = $wallet->withdrawn;
                        $seller_payout_history->seller_id = $wallet->seller->id;
                        $seller_payout_history->amount = $wallet->total_earning;
                                 
                        $amount = $wallet->total_earning;
                        
                        $wallet->total_earning -= $amount;
                        $wallet->withdrawn += $amount;
                        
                        $admin_wallet->total_earning -= $amount;
                        $admin_wallet->withdrawn += $amount;

                        $seller_payout_history->new_pending_withdraw = $wallet->pending_withdraw;
                        $seller_payout_history->new_withdrawn = $wallet->withdrawn;
                        $seller_payout_history->new_total_earning = $wallet->total_earning;
                        
                        $wallet->save();
                        $admin_wallet->save();
                        $seller_payout_history->save();
            
                        $transaction = new SellerBalanceTransaction;
            
                        $transaction->withdraw_request_id = null;
                        $transaction->seller_id = $wallet->seller->id;
                        $transaction->amount = $amount;
                        $transaction->type = 'automatic';
                        $transaction->payment_method_id = $seller->default_payment_method ?? $default_payment_method->id;
                        $transaction->transaction_id = rand(1000, 9999) . '-' . Str::random(5) . '-' . time();
                        $transaction->save();

                        $seller_wallet_action_history = new SellerWalletActionHistory;

                        $seller_wallet_action_history->seller_wallet_id = $wallet->id;
                        $seller_wallet_action_history->current_pending_withdraw = $wallet->pending_withdraw;
                        $seller_wallet_action_history->current_total_earning = $wallet->total_earning;
                        $seller_wallet_action_history->current_withdrawn = $wallet->withdrawn;

                        $seller_wallet_action_history->withdrawn = $amount;

                        $seller_wallet_action_history->current_suspended_amount = $wallet?->walletActions
                        ->where('is_suspended', 1)
                        ->pluck('pending_withdraw')
                        ->sum() ?? 0;

                        $seller_wallet_action_history->save();
            
                        $seller_prefered_language = $wallet->seller->prefered_language ?? 'en';

                        session(['seller_prefered_language'=> $seller_prefered_language]);
                        
                        Mail::to($wallet->seller->email)
                        ->send(new \App\Mail\BalanceResponseStatusMail($wallet->seller->id));
        
                        session()->forget('seller_prefered_language');

                    }
                }

                $last_automatic_balance_sending->value = now();
                $last_automatic_balance_sending->save();

                Log::debug('balance sending with success at :'.now());    
            }
            
            
        }


        



    }
}

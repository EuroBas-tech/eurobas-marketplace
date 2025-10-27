<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Model\Seller;
use App\Model\AdminWallet;
use App\Model\SellerWallet;
use Illuminate\Console\Command;
use App\Model\SellerWalletAction;
use App\Model\SellerPayoutHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Model\SellerBalanceTransaction;
use App\Model\SellerWalletActionHistory;
use App\Model\SellerBalanceReceivedHistory;

class ReleasePendingEarnings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'earnings:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update sellers earnings';

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
        $minimumWithdrawDuration=\App\Model\BusinessSetting::where('type','minimum_withdraw_duration')->first();

        $sellerWallets = SellerWallet::with(['WalletActions' => function ($query) {
            $query->where('is_released', '!=', 1);
        }])->get();

        $admin_wallet = AdminWallet::where('admin_id', 1)->first();

        foreach($sellerWallets as $wallet) {
            if($wallet->WalletActions->count() > 0) {
                foreach($wallet->WalletActions as $walletAction) {

                    if($walletAction->is_suspended == 1 && 
                    $walletAction->delivery_charge_earned == 0) {
                        continue;
                    }

                    $pendingAmountDate = Carbon::parse($walletAction->created_at);
                    
                    if ($pendingAmountDate->diffInDays(now()) > $minimumWithdrawDuration->value) {

                        $seller_earning = $walletAction->is_suspended == 1 ? $walletAction->delivery_charge_earned : $walletAction->pending_withdraw;

                        $seller_payout_history = new SellerPayoutHistory;
                        
                        $seller_payout_history->old_pending_withdraw = $wallet->pending_withdraw;
                        $seller_payout_history->old_total_earning = $wallet->total_earning;
                        $seller_payout_history->old_withdrawn = $wallet->withdrawn;
        
                        $wallet->total_earning += $seller_earning;
                        $wallet->pending_withdraw -= $seller_earning;
                        
                        $admin_wallet->total_earning += $seller_earning;
                        $admin_wallet->pending_amount -= $seller_earning;
                        
                        $walletAction->is_released = 1;
                                                    
                        $seller_payout_history->amount = $walletAction->pending_withdraw;
                        $seller_payout_history->seller_id = $wallet->seller->id;
                        $seller_payout_history->new_pending_withdraw = $wallet->pending_withdraw;
                        $seller_payout_history->new_withdrawn = $wallet->withdrawn;
                        $seller_payout_history->new_total_earning = $wallet->total_earning;

                        $wallet->save();
                        $walletAction->save();
                        $admin_wallet->save();
                        $seller_payout_history->save();

                        $seller_wallet_action_history = new SellerWalletActionHistory;

                        $seller_wallet_action_history->seller_wallet_id = $wallet->id;
                        $seller_wallet_action_history->current_pending_withdraw = $wallet->pending_withdraw;
                        $seller_wallet_action_history->current_total_earning = $wallet->total_earning;
                        $seller_wallet_action_history->current_withdrawn = $wallet->withdrawn;
                        
                        $seller_wallet_action_history->total_earning = $seller_earning;

                        $seller_wallet_action_history->current_suspended_amount = $wallet?->walletActions
                        ->where('is_suspended', 1)
                        ->pluck('pending_withdraw')
                        ->sum() ?? 0;
                
                        $seller_wallet_action_history->save();
                
                        Log::debug('pending withdraw moved to total earnings successfully');
                    }
                }

                $seller_prefered_language = $wallet->seller->prefered_language ?? 'en';

                session(['seller_prefered_language'=> $seller_prefered_language]);
    
                Mail::to($wallet->seller->email)
                ->send(new \App\Mail\BalanceResponseStatusMail($wallet->seller->id));

                session()->forget('seller_prefered_language');
            
            }

        }

    }
 




    }

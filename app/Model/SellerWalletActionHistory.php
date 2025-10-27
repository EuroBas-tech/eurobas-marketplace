<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerWalletActionHistory extends Model
{
    use HasFactory;

    public $table = 'seller_wallet_actions_histories';

    public function sellerWallet() {
        return $this->belongsTo(SellerWallet::class);
    }
}

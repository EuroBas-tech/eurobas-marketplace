<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SellerWallet extends Model
{
    protected $casts = [
        'total_earning' => 'float',
        'withdrawn' => 'float',
        'commission_given' => 'float',
        'pending_withdraw' => 'float',
        'delivery_charge_earned' => 'float',
        'collected_cash' => 'float',
        'total_tax_collected' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function WalletActions()
    {
        return $this->hasMany(SellerWalletAction::class);
    }

    public function sellerWalletActionHistories() {
        return $this->hasMany(SellerWalletActionHistory::class, 'seller_wallet_id');
    }

}

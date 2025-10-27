<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerWalletAction extends Model
{
    use HasFactory;

    protected $guarded = [];

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
    
    public function sellerWallet()
    {
        return $this->belongsTo(SellerWallet::class);
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    

}

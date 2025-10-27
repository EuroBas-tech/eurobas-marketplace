<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPayoutHistory extends Model
{
    use HasFactory;

    public $table = 'sellers_payout_histories';

    public function seller(){
        return $this->belongsTo(Seller::class);
    }
    
    public function paymentMethod() {
        return $this->belongsTo(WithdrawalMethod::class, 'payment_method');
    }


}

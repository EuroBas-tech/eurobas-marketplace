<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{

    protected $casts = [
        'ad_id'  => 'integer',
        'customer_id' => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    public function wishlistAd()
    {
        return $this->belongsTo(Ad::class, 'ad_id')->active();
    }
    public function vehicle()
    {
        return $this->belongsTo(Ad::class, 'ad_id')->select(['id','slug']);
    }

    public function product_full_info()
    {
        return $this->belongsTo(Product::class, 'ad_id');
    }
}

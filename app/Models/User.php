<?php

namespace App\Models;

use App\Model\Ad;
use App\Model\Order;
use App\Model\AdReport;
use App\Model\Chatting;
use App\Model\Wishlist;
use App\Model\AdAuction;
use App\Model\PaidBanner;
use App\Model\AdAskingPrice;
use App\Model\ProductCompare;
use App\Model\ShippingAddress;
use App\Model\UserCategoryInterest;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'image', 'login_medium','is_active','social_id','is_phone_verified','temporary_token','referral_code','referred_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'integer',
        'is_phone_verified'=>'integer',
        'is_email_verified' => 'integer',
        'wallet_balance'=>'float',
        'loyalty_point'=>'float',
        'referred_by'=>'integer',
    ];
    
    public function ads()
    {
        return $this->hasMany(Ad::class, 'user_id');
    }
    
    public function wish_list()
    {
        return $this->hasMany(Wishlist::class, 'customer_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function shipping()
    {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address');
    }
    public function compare_list()
    {
        return $this->hasMany(ProductCompare::class, 'user_id');
    }
    
    public function auctions() {
        return $this->hasMany(AdAuction::class, 'user_id');
    }
    
    public function askingPrice() {
        return $this->hasMany(AdAskingPrice::class, 'user_id');
    }

    public function reports()
    {
        return $this->hasMany(AdReport::class, 'user_id');
    }

    public function paid_banners()
    {
        return $this->hasMany(PaidBanner::class, 'user_id');
    }

    public function chatsAsSender()
    {
        return $this->hasMany(Chatting::class, 'receiver_id');
    }

    public function chatsAsReceiver()
    {
        return $this->hasMany(Chatting::class, 'sender_id');
    }

    public function category_interests()
    {
        return $this->hasMany(UserCategoryInterest::class, 'user_id');
    }



}

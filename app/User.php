<?php

namespace App;

use App\Model\Ad;
use App\Model\Order;
use App\Model\Chatting;
use App\Model\Wishlist;
use App\Model\ProductCompare;
use App\Model\ShippingAddress;
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
        'f_name',
        'l_name',
        'name',
        'email',
        'password',
        'phone',
        'image',
        'cover',
        'login_medium',
        'is_active',
        'social_id',
        'is_phone_verified',
        'temporary_token',
        'referral_code',
        'referred_by',
        'street_address',
        'country',
        'city',
        'postal_code',
        'latitude',
        'longitude',
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

    public function wish_list()
    {
        return $this->hasMany(Wishlist::class, 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
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

    public function chatsAsSender()
    {
        return $this->hasMany(Chatting::class, 'receiver_id');
    }

    public function chatsAsReceiver()
    {
        return $this->hasMany(Chatting::class, 'sender_id');
    }

    public function ads()
    {
        return $this->hasMany(Ad::class, 'user_id');
    }


}

<?php

namespace App;

use App\Model\Ad;
use App\Model\Order;
use App\Model\AdReport;
use App\Model\AdView;
use App\Model\Review;
use App\Model\Chatting;
use App\Model\Wishlist;
use App\Model\AdAuction;
use App\Model\PaidBanner;
use App\Model\SponsoredAd;
use App\Model\ShopFollower;
use App\Model\SupportTicket;
use App\Model\AdAskingPrice;
use App\Model\ProductCompare;
use App\Model\ShippingAddress;
use App\Model\EmergencyContact;
use App\Model\SupportTicketConv;
use App\Model\WalletTransaction;
use App\Model\UserCategoryInterest;
use App\Model\LoyaltyPointTransaction;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
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
        'name', 'email', 'password', 'phone', 'image', 'login_medium', 'is_active',
        'social_id', 'is_phone_verified', 'temporary_token', 'referral_code', 'referred_by',
        'account_type', 'bio', 'phone_code', 'show_phone_number', 'show_email_address',
        'native_language', 'street_address_type', 'latitude', 'longitude', 'country',
        'city', 'postal_code', 'street_address', 'show_location_data', 'cover_image',
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

    protected static function booted()
    {
        static::deleting(function ($user) {
            DB::transaction(function () use ($user) {
                // Cascade delete children of ads owned by the user. Mass deletes
                // do not fire model events, so child rows must be removed first
                // to avoid orphans (which cause server errors on related pages).
                $adIds = $user->ads()->pluck('id');
                if ($adIds->isNotEmpty()) {
                    AdAuction::whereIn('ad_id', $adIds)->delete();
                    AdAskingPrice::whereIn('ad_id', $adIds)->delete();
                    AdReport::whereIn('ad_id', $adIds)->delete();
                    Wishlist::whereIn('ad_id', $adIds)->delete();
                    AdView::whereIn('ad_id', $adIds)->delete();
                    SponsoredAd::whereIn('ad_id', $adIds)->delete();
                    Review::whereIn('ad_id', $adIds)->delete();
                }
                $user->ads()->delete();

                // Activity the user performed on other listings.
                $user->wish_list()->delete();
                $user->compare_list()->delete();
                $user->auctions()->delete();
                $user->askingPrice()->delete();
                $user->reports()->delete();
                $user->paid_banners()->delete();
                $user->category_interests()->delete();
                $user->chatsAsSender()->delete();
                $user->chatsAsReceiver()->delete();

                // Profile-adjacent tables not represented as relationships.
                ShippingAddress::where('customer_id', $user->id)->delete();
                WalletTransaction::where('user_id', $user->id)->delete();
                LoyaltyPointTransaction::where('user_id', $user->id)->delete();
                EmergencyContact::where('user_id', $user->id)->delete();
                ShopFollower::where('user_id', $user->id)->delete();
                Review::where('customer_id', $user->id)->delete();

                // Tables whose Eloquent models are empty placeholders or unused.
                DB::table('billing_addresses')->where('customer_id', $user->id)->delete();
                DB::table('carts')->where('customer_id', $user->id)->delete();
                DB::table('customer_wallets')->where('customer_id', $user->id)->delete();
                DB::table('customer_wallet_histories')->where('customer_id', $user->id)->delete();
                DB::table('notification_seens')->where('user_id', $user->id)->delete();

                $ticketIds = SupportTicket::where('customer_id', $user->id)->pluck('id');
                if ($ticketIds->isNotEmpty()) {
                    SupportTicketConv::whereIn('support_ticket_id', $ticketIds)->delete();
                    SupportTicket::whereIn('id', $ticketIds)->delete();
                }

                // Revoke any active OAuth/Passport tokens for the deleted account.
                DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();
            });
        });
    }

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

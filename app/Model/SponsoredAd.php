<?php

namespace App\Model;

use App\Model\SponsoredAdType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SponsoredAd extends Model
{
    use HasFactory;

    public $table = 'sponsored_ads';

    protected $fillable = [
        'ad_id',
        'type',
        'price',
        'duration_in_days',
        'status',
        'is_paid',
        'package_id',
        'payment_transaction_id',
        'expiration_date',
        'video_id',
    ];

    public function type()
    {
        return $this->belongsTo(SponsoredAdType::class);
    }

    public function ad() {
        return $this->belongsTo(Ad::class, 'ad_id');
    }

    public function package() {
        return $this->belongsTo(SubscriptionPackage::class, 'package_id');
    }

    public function video() {
        return $this->belongsTo(SponsorVideo::class, 'video_id');
    }

}

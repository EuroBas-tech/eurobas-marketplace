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
        'package_id',
        'video_url',
        'playback_id',
        'status',
        'is_paid',
        'payment_transaction_id',
        'is_video_deleted',
        'is_video_suspended',
        'expiration_date',
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

}

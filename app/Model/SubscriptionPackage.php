<?php

namespace App\Model;

use App\Model\SponsoredAdType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPackage extends Model
{
    use HasFactory;

    public function sponsor() {
        return $this->hasMany(SponsoredAd::class, 'package_id');
    }

    public function type() {
        return $this->belongsTo(SponsoredAdType::class);
    }

    public function paid_banners()
    {
        return $this->hasMany(PaidBanner::class, 'package_id');
    }

    public function features()
    {
        return $this->belongsToMany(
            SubscriptionPackageFeature::class,
            'package_feature',
            'package_id',                     
            'feature_id'
        );
    }

}

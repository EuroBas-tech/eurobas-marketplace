<?php

namespace App\Model;

use App\Model\SponsoredAd;
use App\Model\SubscriptionPackage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SponsoredAdType extends Model
{
    use HasFactory;

    public $table = 'sponsored_ad_types';

    public function sponsoredAds()
    {
        return $this->hasMany(SponsoredAd::class);
    }

    public function packages() {
        return $this->hasMany(SubscriptionPackage::class, 'type_id');
    }
    
    public function package_features() {
        return $this->hasMany(SubscriptionPackageFeature::class, 'type_id');
    }

}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPackageFeature extends Model
{
    use HasFactory;

    protected $table = 'subscription_package_features';

    // In SubscriptionPackageFeature.php
    public function packages()
    {
        return $this->belongsToMany(
            SubscriptionPackage::class,     
            'package_feature',   
            'feature_id',
            'package_id'
        );
    }

    public function type() {
        return $this->belongsTo(SponsoredAdType::class);
    }


}

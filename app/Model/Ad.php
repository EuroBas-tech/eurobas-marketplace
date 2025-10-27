<?php

namespace App\Model;

use App\CPU\Helpers;
use App\Models\User;
use App\Model\SponsoredAd;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory;

    protected $casts = [
        'options' => 'array',
        'latitude' => 'float',
        'longitude' => 'float'
    ];

    public function scopeWithinRadius(Builder $query, float $latitude, float $longitude, float $radius): Builder
    {
        // Haversine formula for distance calculation
        $haversine = "(6371 * acos(cos(radians(?)) 
                      * cos(radians(latitude)) 
                      * cos(radians(longitude) - radians(?)) 
                      + sin(radians(?)) 
                      * sin(radians(latitude))))";

        return $query
            ->select('*')
            ->selectRaw("{$haversine} AS distance", [
                $latitude,
                $longitude,
                $latitude
            ])
            ->having('distance', '<=', $radius)
            ->orderBy('distance');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function model() {
        return $this->belongsTo(VehicleModel::class);
    }

    public function wish_list()
    {
        return $this->hasMany(Wishlist::class, 'ad_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'ad_id');
    }

    public function scopeActive($query)
    {
        return $query->where(['status' => 1]);
    }
    
    public function auctions() {
        return $this->hasMany(AdAuction::class, 'ad_id');
    }
    
    public function askingPrice() {
        return $this->hasMany(AdAskingPrice::class, 'ad_id');
    }
    
    public function adViews() {
        return $this->hasMany(AdView::class, 'ad_id');
    }

    public function scopeCountry($query, $country)
    {
        return $query->where('country', $country);
    }

    public function reports()
    {
        return $this->hasMany(AdReport::class, 'ad_id');
    }

    public function sponsor() {
        return $this->hasMany(SponsoredAd::class);
    }


}

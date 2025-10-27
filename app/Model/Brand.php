<?php

namespace App\Model;

use App\CPU\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Brand extends Model
{

    protected $guarded = [];

    protected $casts = [
        'status' => 'integer',
        'brand_products_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeActive(){
        return $this->where('status',1);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'brand_category');
    }

    public function brandAds()
    {
        return $this->hasMany(Ad::class)->active();
    }

    public function brandAllAds(){
        return $this->hasMany(Ad::class);
    }

    public function getNameAttribute($name)
    {
        if (strpos(url()->current(), '/admin') || strpos(url()->current(), '/seller')) {
            return $name;
        }

        return $this->translations[0]->value??$name;
    }

    public function getDefaultNameAttribute()
    {
        return $this->translations[0]->value ?? $this->name;
    }

    public function ads() {
        return $this->belongsTo(Ad::class, 'brand_id');
    }
 
    public function VehicleModels() {
        return $this->hasMany(vehicleModel::class, 'brand_id');
    }

}

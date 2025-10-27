<?php

namespace App\Model;

use App\CPU\Helpers;
use App\Model\CategoryType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    protected $guarded = [];
    protected $casts = [
        'category_type' => 'string',
        'position' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'home_status' => 'integer',
        'priority' => 'integer'
    ];

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_category');
    }

    public function models() 
    { 
        return $this->belongsToMany(VehicleModel::class, 'model_category', 'category_id', 'model_id'); 
    }

    public function translations()
    {
        return $this->morphMany('App\Model\Translation', 'translationable');
    }

    public function getNameAttribute($name)
    {
        if (strpos(url()->current(), '/admin') || strpos(url()->current(), '/seller')) {
            return $name;
        }

        return $this->translations[0]->value ?? $name;
    }

    public function getDefaultNameAttribute()
    {
        return $this->translations[0]->value ?? $this->name;
    }

    public function scopePriority($query)
    {
        return $query->orderBy('priority', 'asc');
    }

    public function scopeHomeEnabled($query)
    {
        return $query->where('home_status', 1);
    }


    public function VehicleModels() {
        return $this->hasMany(vehicleModel::class);
    }

    public function ads() {
        return $this->hasMany(Ad::class, 'category_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('translate', function (Builder $builder) {
            $builder->with(['translations' => function ($query) {
                if (strpos(url()->current(), '/api')) {
                    return $query->where('locale', App::getLocale());
                } else {
                    return $query->where('locale', Helpers::default_lang());
                }
            }]);
        });
    }
}

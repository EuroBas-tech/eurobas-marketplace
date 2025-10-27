<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    protected $table = 'models';

    use HasFactory;

    public function categories() 
    { 
        return $this->belongsToMany(Category::class, 'model_category', 'model_id', 'category_id'); 
    }


    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function ads() {
        return $this->belongsTo(Ad::class, 'model_id');
    }


}












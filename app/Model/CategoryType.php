<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => 'integer',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class, 'category_type');
    }
}

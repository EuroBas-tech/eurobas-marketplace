<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListAttribute extends Model
{
    use HasFactory;

    public $table = 'lists_attributes';

    public function values()
    {
        return $this->hasMany(ListValue::class);
    }

}

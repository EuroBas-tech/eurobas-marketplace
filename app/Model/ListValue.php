<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListValue extends Model
{
    use HasFactory;

    public $table = 'lists_values';

    protected $fillable = [
        'list_attribute_id',
        'value',
        'priority',
    ];

    public function list()
    {
        return $this->belongsTo(ListAttribute::class, 'list_attribute_id');
    }

}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdView extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $table = 'ads_views';

    public function ad() {
        return $this->belongsTo(Ad::class);
    }
}

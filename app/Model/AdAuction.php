<?php

namespace App\Model;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdAuction extends Model
{
    use HasFactory;



    public function ad() {
        return $this->belongsTo(Ad::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}

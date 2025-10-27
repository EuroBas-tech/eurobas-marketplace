<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminWalletAction extends Model
{
    use HasFactory;

    public function adminWallet() {
        return $this->belongsTo(AdminWallet::class);
    }
}

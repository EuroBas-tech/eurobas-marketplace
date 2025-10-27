<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Model\Ad;

class AdReport extends Model
{
    use HasFactory;

    protected $table = 'ad_reports';

    protected $fillable = [
        'ad_id',
        'message',
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

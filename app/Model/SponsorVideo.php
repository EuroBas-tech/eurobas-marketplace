<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorVideo extends Model
{
    use HasFactory;

    protected $table = 'sponsor_videos';

    protected $guarded = [];

    public function sponsor() {
        return $this->hasOne(SponsoredAd::class, 'video_id');
    }


}

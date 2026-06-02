<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Milestone 2 — Report User.
 */
class UserReport extends Model
{
    protected $guarded = [];

    protected $casts = [
        'reporter_id' => 'integer',
        'reported_id' => 'integer',
        'chatting_id' => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reported()
    {
        return $this->belongsTo(User::class, 'reported_id');
    }

    public function chatting()
    {
        return $this->belongsTo(Chatting::class, 'chatting_id');
    }
}

<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Chatting extends Model
{
    protected $casts = [
        'sender_id' => 'integer',
        'status' => 'integer',
        'receiver_id' => 'integer',
        'seen_by_customer' => 'integer',
        'deleted_by_sender' => 'integer',
        'deleted_by_receiver' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'delivered_at' => 'datetime',
        'seen_at' => 'datetime',
    ];

    protected $guarded=[];

    /**
     * Milestone 2: hide messages the given user has soft-deleted for themselves.
     * The other party still sees them.
     */
    public function scopeVisibleTo($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where(function ($q2) use ($userId) {
                $q2->where('sender_id', $userId)->where('deleted_by_sender', 0);
            })->orWhere(function ($q2) use ($userId) {
                $q2->where('receiver_id', $userId)->where('deleted_by_receiver', 0);
            });
        });
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function admin(){
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}

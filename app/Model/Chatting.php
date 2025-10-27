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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $guarded=[];

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

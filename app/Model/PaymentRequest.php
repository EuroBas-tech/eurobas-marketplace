<?php

namespace App\Model;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    use HasUuid;
    use HasFactory;

    protected $table = 'payment_requests';
    
    protected $guarded = [];

    // In your PaymentRequest model
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $casts = [
        'id' => 'string',
        'additional_data' => 'array',
        'is_paid' => 'boolean'
    ];


}

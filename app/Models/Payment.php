<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'appointment_id',
        'amount',
        'currency',
        'payment_method',
        'transaction_id',
        'status',
        'commission',
        'payment_details'
    ];

    protected $casts = [
        'payment_details' => 'array',
        'amount' => 'decimal:2',
        'commission' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
} 
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounterOffer extends Model
{
    protected $fillable = [
        'offer_id',
        'psychologist_id',
        'price',
        'duration',
        'message',
        'status'
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function psychologist()
    {
        return $this->belongsTo(User::class, 'psychologist_id');
    }
} 
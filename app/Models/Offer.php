<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'user_id',
        'price',
        'duration',
        'description',
        'location',
        'status',
        'location_coordinates'
    ];

    protected $casts = [
        'location_coordinates' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function counterOffers()
    {
        return $this->hasMany(CounterOffer::class);
    }
} 
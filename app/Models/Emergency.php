<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emergency extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'description',
        'location',
        'attended_at'
    ];

    protected $casts = [
        'location' => 'array',
        'attended_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 
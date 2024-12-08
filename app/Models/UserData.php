<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    protected $fillable = [
        'user_id',
        'data_type',
        'value',
        'timestamp',
        'session_id',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'timestamp' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'notifications_enabled',
        'email_notifications',
        'sms_notifications',
        'language',
        'timezone'
    ];

    protected $casts = [
        'notifications_enabled' => 'boolean',
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'psychologist_id',
        'status',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function psychologist()
    {
        return $this->belongsTo(User::class, 'psychologist_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
} 
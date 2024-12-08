<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'psychologist_id',
        'date',
        'time',
        'duration',
        'type',
        'status',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function psychologist()
    {
        return $this->belongsTo(User::class, 'psychologist_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psychologist extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'especialidad',
        // otros campos que necesites
    ];

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'psychologist_id');
    }

    // Otras relaciones y métodos que necesites
} 
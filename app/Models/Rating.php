<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'user_id',
        'psychologist_id',
        'rating',
        'comment',
    ];

    public function psychologist()
    {
        return $this->belongsTo(User::class, 'psychologist_id');
    }
}
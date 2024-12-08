<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationDocument extends Model
{
    protected $fillable = [
        'user_id',
        'document_type',
        'document_path',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 
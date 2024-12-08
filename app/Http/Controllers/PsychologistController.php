<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PsychologistController extends Controller
{
    public function index()
    {
        $psychologists = User::where('rol', 'psicólogo')
            ->orderBy('nombre')
            ->get();
            
        return view('psychologists.index', compact('psychologists'));
    }
} 
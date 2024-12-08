<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPsychologistRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'psicólogo') {
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
} 
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::user() || !Auth::user()->hasRole($role)) {
            return redirect('/home'); // Redirige si no tiene el rol
        }

        return $next($request);
    }
} 
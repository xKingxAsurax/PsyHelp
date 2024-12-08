<?php

namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        if (!$user || $user->rol !== 'psicólogo') {
            return redirect()->route('login');
        }
        
        return view('profile.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'telefono' => 'nullable|string|max:20',
            'biografia' => 'required|string|max:500',
            'especialidad' => 'required|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }
} 
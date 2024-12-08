<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        if (!$user) {
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
            'biografia' => $user->rol === 'psicólogo' ? 'nullable|string|max:500' : 'nullable',
            'especialidad' => $user->rol === 'psicólogo' ? 'required|string|max:255' : 'nullable',
        ]);

        $user->update($validated);

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }
}

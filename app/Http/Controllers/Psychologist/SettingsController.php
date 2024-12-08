<?php

namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        if (!$user || $user->rol !== 'psicólogo') {
            return redirect()->route('login');
        }
        
        return view('psychologist.settings.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'notifications_enabled' => 'boolean',
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'language' => 'required|string|in:es,en',
            'timezone' => 'required|string',
            'appointment_duration' => 'required|integer|min:30|max:120',
            'break_time' => 'required|integer|min:0|max:60',
            'online_status' => 'boolean',
        ]);

        $user->settings()->update($validated);

        return redirect()->route('psychologist.settings.edit')->with('status', 'settings-updated');
    }
} 
<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        if (!$user || $user->rol !== 'cliente') {
            return redirect()->route('login');
        }
        
        if (!$user->settings) {
            $user->settings()->create([
                'notifications_enabled' => true,
                'email_notifications' => true,
                'sms_notifications' => true,
                'language' => 'es',
                'timezone' => 'America/Bogota',
            ]);
        }

        return view('client.settings.edit', [
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
        ]);

        if (!$user->settings) {
            $user->settings()->create($validated);
        } else {
            $user->settings->update($validated);
        }

        return redirect()->route('client.settings.edit')->with('status', 'settings-updated');
    }
} 
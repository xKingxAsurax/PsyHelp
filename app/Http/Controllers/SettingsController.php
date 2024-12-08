<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'email_notifications' => $request->has('email_notifications'),
            'sms_notifications' => $request->has('sms_notifications')
        ]);

        return redirect()->route('settings.index')
            ->with('status', 'configuracion-actualizada');
    }

    public function updatePrivacy(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'profile_visible' => $request->has('profile_visible')
        ]);

        return redirect()->route('settings.index')
            ->with('status', 'privacidad-actualizada');
    }
} 
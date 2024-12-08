<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function updateLocation(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $user = Auth::user();
        $user->update([
            'last_location' => [
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'updated_at' => now()
            ]
        ]);

        return response()->json(['message' => 'Ubicación actualizada']);
    }

    public function getNearbyPsychologists(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric|min:1|max:50' // Radio en kilómetros
        ]);

        $psychologists = User::where('role', 'psicólogo')
            ->where('status', 'active')
            ->get()
            ->filter(function($psychologist) use ($validated) {
                if (!isset($psychologist->last_location)) {
                    return false;
                }

                $distance = $this->calculateDistance(
                    $validated['latitude'],
                    $validated['longitude'],
                    $psychologist->last_location['latitude'],
                    $psychologist->last_location['longitude']
                );

                return $distance <= $validated['radius'];
            })
            ->values();

        return response()->json($psychologists);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $r = 6371; // Radio de la Tierra en kilómetros
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
             sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $r * $c;
    }
} 
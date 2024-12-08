<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'psychologist_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        // Verifica los datos validados
        dd($validated);

        // Verifica si ya existe una calificación para este usuario y psicólogo
        $existingRating = Rating::where('user_id', auth()->id())
            ->where('psychologist_id', $validated['psychologist_id'])
            ->first();

        if ($existingRating) {
            // Actualiza la calificación existente
            $existingRating->update([
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null
            ]);
        } else {
            // Crea una nueva calificación
            Rating::create([
                'user_id' => auth()->id(),
                'psychologist_id' => $validated['psychologist_id'],
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null
            ]);
        }

        return back()->with('success', 'Calificación enviada correctamente');
    }
} 
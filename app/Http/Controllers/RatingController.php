<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Asegúrate de que el usuario esté autenticado
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'psychologist_id' => 'required|exists:users,id', // Asegúrate de que el psicólogo exista
            'rating' => 'required|integer|min:1|max:5', // Calificación entre 1 y 5
            'comment' => 'nullable|string|max:500' // Comentario opcional
        ]);

        // Verificar si ya existe una calificación para este usuario y psicólogo
        $existingRating = Rating::where('user_id', Auth::id())
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
                'user_id' => Auth::id(), // ID del usuario autenticado
                'psychologist_id' => $validated['psychologist_id'], // ID del psicólogo
                'rating' => $validated['rating'], // Calificación
                'comment' => $validated['comment'] ?? null // Comentario (puede ser nulo)
            ]);
        }

        // Redirigir de vuelta con un mensaje de éxito
        return back()->with('success', 'Calificación enviada correctamente');
    }

    public function index()
    {
        // Obtener todas las calificaciones de los psicólogos
        $ratings = Rating::with('psychologist')->where('user_id', Auth::id())->get();

        return view('ratings.index', compact('ratings'));
    }
}
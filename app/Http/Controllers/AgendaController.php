<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('psychologist_id', auth()->id())
            ->whereBetween('date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->with(['patient'])
            ->get()
            ->map(function($appointment) {
                $appointment->date = Carbon::parse($appointment->date);
                return $appointment;
            })
            ->groupBy(function($appointment) {
                return Carbon::parse($appointment->date)->format('Y-m-d');
            });

        return view('agenda.index', compact('appointments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'duration' => 'required|integer|min:30|max:120',
            'type' => 'required|in:primera_vez,seguimiento,emergencia'
        ]);

        $appointment = Appointment::create([
            'psychologist_id' => Auth::id(),
            'patient_id' => $validated['patient_id'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'duration' => $validated['duration'],
            'type' => $validated['type'],
            'status' => 'programada'
        ]);

        return response()->json($appointment);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'date' => 'sometimes|date|after:today',
            'time' => 'sometimes',
            'status' => 'sometimes|in:programada,completada,cancelada'
        ]);

        $appointment->update($validated);

        return response()->json($appointment);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json(['message' => 'Cita eliminada correctamente']);
    }
} 
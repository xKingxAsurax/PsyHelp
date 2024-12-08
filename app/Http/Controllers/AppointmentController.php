<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $appointments = Appointment::where('patient_id', Auth::id())
            ->orderBy('date', 'asc')
            ->get();
            
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $psychologists = User::where('rol', 'psicólogo')->get();
        $types = [
            ['id' => 'primera_vez', 'nombre' => 'Primera Consulta'],
            ['id' => 'seguimiento', 'nombre' => 'Seguimiento'],
            ['id' => 'emergencia', 'nombre' => 'Emergencia']
        ];
        
        return view('appointments.create', compact('psychologists', 'types'));
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Datos recibidos:', $request->all());

            $validated = $request->validate([
                'psychologist_id' => 'required|exists:users,id',
                'date' => 'required|date|after:today',
                'time' => 'required',
                'duration' => 'required|integer|min:30|max:120',
                'type' => 'required|in:primera_vez,seguimiento,emergencia',
                'notes' => 'nullable|string|max:500'
            ]);

            $appointment = Appointment::create([
                'patient_id' => Auth::id(),
                'psychologist_id' => $validated['psychologist_id'],
                'date' => $validated['date'],
                'time' => $validated['time'],
                'duration' => $validated['duration'],
                'type' => $validated['type'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'programada'
            ]);

            \Log::info('Cita creada:', $appointment->toArray());

            return redirect()
                ->route('appointments.show', $appointment)
                ->with('success', 'Cita programada exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error al crear cita: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Error al programar la cita: ' . $e->getMessage()]);
        }
    }

    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    public function myAppointments()
    {
        $appointments = Appointment::where('patient_id', Auth::id())
            ->orderBy('date', 'asc')
            ->get();
            
        return view('appointments.my', compact('appointments'));
    }

    public function destroy(Appointment $appointment)
    {
        // Verificar que el usuario actual sea el dueño de la cita
        if ($appointment->patient_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        // Actualizar el estado a cancelado en lugar de eliminar
        $appointment->update(['status' => 'cancelada']);

        return redirect()->route('appointments.index')
            ->with('success', 'Cita cancelada exitosamente');
    }
} 
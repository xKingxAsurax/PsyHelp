<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $activePatients = User::whereHas('patient', function($query) {
            $query->whereHas('appointments', function($query) {
                $query->where('status', 'programada');
            });
        })->with('patient')->get();

        return view('patients.index', compact('activePatients'));
    }

    public function createAppointment(Request $request)
    {
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

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Cita programada exitosamente');
    }

    public function myAppointments()
    {
        $appointments = Appointment::where('patient_id', Auth::id())
            ->orderBy('date', 'asc')
            ->get();

        $psychologist = User::where('rol', 'psicólogo')->first();

        return view('appointments.my', compact('appointments', 'psychologist'));
    }
}
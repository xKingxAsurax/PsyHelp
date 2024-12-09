<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Rating;
use App\Models\Psychologist;
use Carbon\Carbon;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->rol === 'psicólogo') {
            return $this->psychologistDashboard($user);
        } elseif ($user->rol === 'cliente') {
            return $this->clientDashboard($user);
        }

        return redirect()->route('login')->with('error', 'Acceso no autorizado.');
    }

    private function clientDashboard($user)
    {
        $nextAppointment = Appointment::where('patient_id', $user->id)
            ->where('date', '>=', today())
            ->orderBy('date')
            ->orderBy('time')
            ->first();

        $therapyHours = Appointment::where('patient_id', $user->id)
            ->where('status', 'completada')
            ->sum('duration');

        // Obtener un psicólogo específico (puedes ajustar esta lógica según tus necesidades)
        $psychologist = User::where('rol', 'psicólogo')->first(); // O cualquier lógica que necesites

        return view('dashboard.client', compact('user', 'nextAppointment', 'therapyHours', 'psychologist'));
    }

    private function psychologistDashboard($user)
    {
        // Citas para hoy
        $appointmentsToday = Appointment::where('psychologist_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->count();

        // Pacientes activos
        $activePatients = Patient::whereHas('appointments', function($query) use ($user) {
            $query->where('psychologist_id', $user->id)
                ->where('status', 'programada');
        })->with('user')->get();

        // Calificación promedio
        $rating = Rating::where('psychologist_id', $user->id)
            ->avg('rating') ?? 0;

        // Próximas citas
        $upcomingAppointments = Appointment::where('psychologist_id', $user->id)
            ->where('date', '>=', Carbon::today())
            ->where('status', 'programada')
            ->with('patient')
            ->orderBy('date')
            ->orderBy('time')
            ->take(5)
            ->get();

        return view('dashboard.psychologist', compact(
            'user',
            'appointmentsToday',
            'activePatients',
            'rating',
            'upcomingAppointments'
        ));
    }

    public function psychologist()
    {
        $upcomingAppointments = Appointment::where('psychologist_id', auth()->id())
            ->where('date', '>=', now())
            ->with(['patient.user'])
            ->orderBy('date')
            ->orderBy('time')
            ->take(5)
            ->get();

        return view('dashboard.psychologist', compact('upcomingAppointments'));
    }
}
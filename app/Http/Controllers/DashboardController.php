<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Rating;
use App\Models\Psychologist;
use Carbon\Carbon;

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

        // Obtener los psicólogos con las mejores calificaciones desde la tabla ratings
        $topPsychologists = Rating::select('psychologist_id')
            ->selectRaw('AVG(rating) as avg_rating')
            ->groupBy('psychologist_id')
            ->orderByDesc('avg_rating')
            ->take(3)
            ->with('psychologist') // Asegúrate de que la relación esté definida en el modelo Rating
            ->get();

        // Pasar datos adicionales a la vista
        $nextAppointment = $user->appointments()->where('date', '>=', today())->first();
        $therapyHours = $user->appointments()->where('status', 'completada')->sum('duration');

        return view('dashboard.client', compact('user', 'topPsychologists', 'nextAppointment', 'therapyHours'));
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

        return view('dashboard.client', compact('user', 'nextAppointment', 'therapyHours'));
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
        })->count();

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
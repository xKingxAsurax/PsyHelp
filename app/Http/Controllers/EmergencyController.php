<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emergency;
use App\Events\EmergencyActivated;
use App\Models\Appointment;
use App\Models\User;

class EmergencyController extends Controller
{
    public function show()
    {
        return view('emergency');
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Iniciando proceso de emergencia', [
                'user_id' => auth()->id(),
                'request_data' => $request->all()
            ]);

            // Crear la emergencia
            $emergency = Emergency::create([
                'user_id' => auth()->id(),
                'status' => 'pending',
                'description' => $request->description ?? 'Solicitud de emergencia',
                'location' => null, // Temporalmente removido para pruebas
                'created_at' => now()
            ]);

            \Log::info('Emergencia creada', ['emergency_id' => $emergency->id]);

            // Crear una cita de emergencia
            $appointment = Appointment::create([
                'patient_id' => auth()->id(),
                'psychologist_id' => 1, // Temporalmente hardcodeado para pruebas
                'date' => now()->format('Y-m-d'),
                'time' => now()->format('H:i:s'),
                'duration' => 60,
                'type' => 'emergencia',
                'status' => 'programada',
                'notes' => 'Cita de emergencia #' . $emergency->id
            ]);

            \Log::info('Cita creada', ['appointment_id' => $appointment->id]);

            return response()->json([
                'success' => true,
                'message' => 'Emergencia registrada correctamente',
                'emergency_id' => $emergency->id,
                'appointment_id' => $appointment->id
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en emergencia: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la emergencia: ' . $e->getMessage()
            ], 500);
        }
    }

    public function contacts()
    {
        $emergencyContacts = [
            [
                'name' => 'Línea de Emergencia Nacional',
                'phone' => '911'
            ],
            [
                'name' => 'Línea de Crisis',
                'phone' => '1-800-273-8255'
            ],
            // Agrega más contactos según necesites
        ];

        return view('emergency.contacts', compact('emergencyContacts'));
    }
} 
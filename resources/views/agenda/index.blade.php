<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Agenda - PsyHelp</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/agenda.css') }}">
</head>
<body>
    <div class="agenda-container">
        <header class="agenda-header">
            <h1><i class="fas fa-calendar-alt"></i> Mi Agenda de Consultas</h1>
            <div class="header-actions">
                <button id="prevWeek" class="btn btn-outline">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span id="currentWeek" class="current-week"></span>
                <button id="nextWeek" class="btn btn-outline">
                    <i class="fas fa-chevron-right"></i>
                </button>
                <a href="{{ route('dashboard') }}" class="btn-back">
                    <i class="fas fa-arrow-left">< 
                    /i>
                    Volver al Panel
                </a>
            </div>
        </header>

        <div class="calendar-grid">
            <div class="time-column">
                @for($hour = 8; $hour <= 20; $hour++)
                    <div class="time-slot">{{ sprintf('%02d:00', $hour) }}</div>
                @endfor
            </div>
            
            @for($day = 0; $day < 7; $day++)
                @php
                    $currentDate = now()->addDays($day)->format('Y-m-d');
                    $dayAppointments = $appointments[$currentDate] ?? collect();
                @endphp
                <div class="day-column" data-date="{{ $currentDate }}">
                    <div class="day-header">
                        {{ now()->addDays($day)->format('D d M') }}
                    </div>
                    @for($hour = 8; $hour <= 20; $hour++)
                        @php
                            $timeSlot = sprintf('%02d:00', $hour);
                            $appointment = $dayAppointments->first(function($apt) use ($timeSlot) {
                                return $apt->time->format('H:i') === $timeSlot;
                            });
                        @endphp
                        <div class="time-slot {{ $appointment ? 'has-appointment' : '' }}">
                            @if($appointment)
                                <div class="appointment-card" onclick="showAppointmentDetails({{ $appointment->id }})">
                                    <div class="appointment-time">
                                        {{ \Carbon\Carbon::parse($appointment->time)->format('H:i A') }}
                                    </div>
                                    <div class="appointment-info">
                                        <div class="patient-name">
                                            @if($appointment->patient)
                                                {{ $appointment->patient->nombre }} 
                                                {{ $appointment->patient->apellido }}
                                            @else
                                                <span class="text-warning">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    Verificar datos del paciente
                                                </span>
                                            @endif
                                        </div>
                                        <div class="appointment-type {{ $appointment->type }}">
                                            @switch($appointment->type)
                                                @case('primera_vez')
                                                    Primera Consulta
                                                    @break
                                                @case('seguimiento')
                                                    Seguimiento
                                                    @break
                                                @case('emergencia')
                                                    Emergencia
                                                    @break
                                            @endswitch
                                        </div>
                                        @if($appointment->notes)
                                            <div class="appointment-notes">
                                                {{ Str::limit($appointment->notes, 50) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>
            @endfor
        </div>
    </div>

    <!-- Modal para detalles de la cita -->
    <div id="appointmentModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Detalles de la Consulta</h2>
            <div id="appointmentDetails"></div>
        </div>
    </div>
</body>
</html>     
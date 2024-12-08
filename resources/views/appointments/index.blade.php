<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Citas - PsyHelp</title>
    <link rel="stylesheet" href="{{ asset('css/appointments.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="appointments-container">
        <main class="main-content">
            <div class="page-header">
                <h1><i class="fas fa-calendar"></i> Gestión de Citas</h1>
                <div class="header-buttons">
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nueva Cita
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Volver al Panel
                    </a>
                </div>
            </div>

            @if($appointments->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>No hay citas registradas.</p>
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                        Programar primera cita
                    </a>
                </div>
            @else
                <div class="appointments-grid">
                    @foreach($appointments as $appointment)
                        <div class="appointment-card">
                            <div class="appointment-header">
                                <div class="date-badge">
                                    <span class="day">{{ \Carbon\Carbon::parse($appointment->date)->format('d') }}</span>
                                    <span class="month">{{ \Carbon\Carbon::parse($appointment->date)->format('M') }}</span>
                                </div>
                                <div class="time-info">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $appointment->time }}</span>
                                </div>
                            </div>
                            
                            <div class="appointment-body">
                                <div class="status-badge {{ $appointment->status }}">
                                    <i class="fas fa-circle"></i>
                                    {{ ucfirst($appointment->status) }}
                                </div>
                                
                                @if($appointment->notes)
                                    <div class="notes">
                                        <i class="fas fa-sticky-note"></i>
                                        <p>{{ $appointment->notes }}</p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="appointment-footer">
                                <a href="{{ route('appointments.show', $appointment) }}" 
                                   class="btn btn-outline">
                                    <i class="fas fa-eye"></i> Ver Detalles
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
</body>
</html>

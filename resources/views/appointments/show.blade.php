<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Cita - PsyHelp</title>
    <link rel="stylesheet" href="{{ asset('css/appointments.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="appointments-container">
        <main class="main-content">
            <div class="page-header">
                <h1><i class="fas fa-calendar-check"></i> Detalles de la Cita</h1>
                <a href="{{ route('dashboard') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Volver al Panel
                </a>
            </div>

            <div class="appointment-details">
                <div class="detail-card">
                    <div class="detail-header">
                        <div class="date-badge">
                            <span class="day">{{ \Carbon\Carbon::parse($appointment->date)->format('d') }}</span>
                            <span class="month">{{ \Carbon\Carbon::parse($appointment->date)->format('M') }}</span>
                        </div>
                        <div class="status-badge {{ $appointment->status }}">
                            {{ ucfirst($appointment->status) }}
                        </div>
                    </div>

                    <div class="detail-body">
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <span>Hora: {{ \Carbon\Carbon::parse($appointment->time)->format('H:i A') }}</span>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-user-md"></i>
                            <span>Psicólogo: Dr. {{ $appointment->psychologist->nombre }} {{ $appointment->psychologist->apellido }}</span>
                        </div>

                        @if($appointment->notes)
                            <div class="detail-item">
                                <i class="fas fa-sticky-note"></i>
                                <span>Notas: {{ $appointment->notes }}</span>
                            </div>
                        @endif
                    </div>

                    @if($appointment->status === 'programada')
                        <div class="detail-footer">
                            <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de cancelar esta cita?')">
                                    <i class="fas fa-times"></i> Cancelar Cita
                                </button>
                            </form>
                        </div>
                    @endif

                    @if($appointment->status === 'completada' && !$appointment->rating && 
                        Carbon::parse($appointment->date . ' ' . $appointment->time)->addMinutes(60)->lt(now()))
                        <div class="rating-form">
                            <h4>Valora tu experiencia</h4>
                            <form action="{{ route('appointments.rate', $appointment) }}" method="POST">
                                @csrf
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}">
                                        <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                    @endfor
                                </div>
                                <textarea name="comment" placeholder="Deja un comentario (opcional)"></textarea>
                                <button type="submit" class="btn btn-primary">Enviar valoración</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html> 
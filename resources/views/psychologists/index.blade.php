<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Psicólogo - PsyHelp</title>
    <link rel="stylesheet" href="{{ asset('css/appointments.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <main class="main-content">
            <div class="page-header">
                <h1><i class="fas fa-user-md"></i> Buscar Psicólogo</h1>
                <a href="{{ route('dashboard') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Volver al Panel
                </a>
            </div>

            <div class="psychologists-grid">
                @forelse($psychologists as $psychologist)
                    <div class="psychologist-card">
                        <div class="psychologist-header">
                            <img src="https://ui-avatars.com/api/?name={{ $psychologist->nombre }}&background=random" alt="Psychologist">
                        </div>
                        <div class="psychologist-info">
                            <h3>Dr. {{ $psychologist->nombre }} {{ $psychologist->apellido }}</h3>
                            <p class="specialty">Psicología Clínica</p>
                            <div class="psychologist-actions">
                                <a href="{{ route('appointments.create', ['psychologist' => $psychologist->id]) }}" class="btn btn-primary">
                                    <i class="fas fa-calendar-plus"></i> Agendar Cita
                                </a>
                            </div>
                            <form action="{{ route('submit.rating') }}" method="POST" class="rating-form">
                                @csrf
                                <input type="hidden" name="psychologist_id" value="{{ $psychologist->id }}">
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                                        <label for="star{{ $i }}">
                                            <i class="fas fa-star"></i>
                                        </label>
                                    @endfor
                                </div>
                                <button type="submit" class="btn btn-secondary">Calificar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-user-md"></i>
                        <p>No hay psicólogos disponibles en este momento.</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</body>
</html>

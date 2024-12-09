<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Cita - PsyHelp</title>
    <link rel="stylesheet" href="{{ asset('css/appointments.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="appointments-container">
        <main class="main-content">
            <div class="page-header">
                <h1><i class="fas fa-calendar-plus"></i> Nueva Cita</h1>
                <div class="header-buttons">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Volver al Panel
                    </a>
                </div>
            </div>

            <div class="appointment-form-container">
                <form class="appointment-form" action="{{ route('appointments.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="psychologist_id">Psicólogo:</label>
                        <select name="psychologist_id" class="form-control" required>
                            <option value="">Seleccione un psicólogo</option>
                            @foreach($psychologists as $psychologist)
                                <option value="{{ $psychologist->id }}">{{ $psychologist->nombre }} {{ $psychologist->apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="date">Fecha:</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="time">Hora:</label>
                        <input type="time" name="time" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="duration">Duración (minutos):</label>
                        <input type="number" name="duration" class="form-control" min="30" max="120" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="type">Tipo de cita:</label>
                        <select name="type" class="form-control" required>
                            <option value="primera_vez">Primera vez</option>
                            <option value="seguimiento">Seguimiento</option>
                            <option value="emergencia">Emergencia</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="notes">Notas:</label>
                        <textarea name="notes" class="form-control" rows="4"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Programar Cita</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html> 
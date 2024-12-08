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
                    <input type="hidden" name="duration" value="60">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="psychologist_id">
                            <i class="fas fa-user-md"></i> Seleccionar Psicólogo
                        </label>
                        <select name="psychologist_id" id="psychologist_id" required>
                            <option value="">Seleccione un psicólogo</option>
                            @foreach($psychologists as $psychologist)
                                <option value="{{ $psychologist->id }}">
                                    Dr(a). {{ $psychologist->nombre }} {{ $psychologist->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="date">
                                <i class="fas fa-calendar"></i> Fecha
                            </label>
                            <input type="date" id="date" name="date" required>
                        </div>

                        <div class="form-group">
                            <label for="time">
                                <i class="fas fa-clock"></i> Hora
                            </label>
                            <input type="time" id="time" name="time" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="type">
                            <i class="fas fa-tag"></i> Tipo de Consulta
                        </label>
                        <select name="type" id="type" required>
                            <option value="primera_vez">Primera Vez</option>
                            <option value="seguimiento">Seguimiento</option>
                            <option value="emergencia">Emergencia</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="notes">
                            <i class="fas fa-comment-medical"></i> Notas Adicionales
                        </label>
                        <textarea name="notes" id="notes" rows="4" placeholder="Describe brevemente el motivo de tu consulta..."></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Confirmar Cita
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html> 
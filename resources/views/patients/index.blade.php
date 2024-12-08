<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pacientes - PsyHelp</title>
    <link rel="stylesheet" href="{{ asset('css/appointments.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content">
            <div class="page-header">
                <h1><i class="fas fa-users"></i> Mis Pacientes</h1>
                <a href="{{ route('dashboard') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Volver al Panel
                </a>
            </div>

            @if($patients->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-user-friends"></i>
                    <p>No tienes pacientes registrados.</p>
                </div>
            @else
                <div class="patients-grid">
                    @foreach($patients as $patient)
                        <div class="patient-card">
                            <div class="patient-info">
                                <h3>{{ $patient->user->nombre }} {{ $patient->user->apellido }}</h3>
                                <p class="status {{ $patient->status }}">{{ ucfirst($patient->status) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
</body>
</html>

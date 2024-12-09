<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Cliente - PsyHelp</title>
    <!-- Fuentes de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="brand">
                <i class="fas fa-brain"></i>
                <span>PsyHelp</span>
            </div>

            <div class="profile-card">
                <div class="profile-image">
                    <img src="https://ui-avatars.com/api/?name={{ $user->nombre }}&background=random" alt="Profile">
                </div>
                <div class="profile-info">
                    <h3>{{ $user->nombre }}</h3>
                    <span>Cliente</span>
                </div>
            </div>

            <nav class="nav-menu">
                <a href="{{ route('dashboard') }}" class="nav-link active">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
                <a href="{{ route('appointments.my') }}" class="nav-link">
                    <i class="fas fa-calendar"></i>
                    <span>Mis Citas</span>
                </a>
                <a href="{{ route('psychologists.index') }}" class="nav-link">
                    <i class="fas fa-user-md"></i>
                    <span>Buscar Psicólogo</span>
                </a>
                <a href="{{ isset($psychologist) ? route('appointments.create', ['psychologistId' => $psychologist->id]) : '#' }}" class="btn btn-new" {{ !isset($psychologist) ? 'disabled' : '' }}>
                    <i class="fas fa-plus-circle"></i>
                    Agendar Nueva Cita
                </a>
            </nav>

            <div class="emergency-button">
                <a href="{{ route('emergency') }}" class="btn btn-emergency">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Ayuda de Emergencia</span>
                </a>
            </div>
        </aside>

        <!-- Contenido Principal -->
        <main class="main-content">
            <header class="top-bar">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Buscar psicólogo...">
                </div>

                <div class="top-bar-actions">
                    <div class="notification-wrapper">
                        <button class="notification-btn">
                            <i class="fas fa-bell"></i>
                            <span class="badge">0</span>
                        </button>
                        <div class="notification-dropdown">
                            <!-- Las notificaciones se cargarán aquí dinámicamente -->
                        </div>
                    </div>
                    
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ $user->nombre }}&background=random" alt="User">
                        <div class="user-menu-dropdown">
                            <a href="{{ route('client.profile.edit') }}" class="btn btn-outline">
                                <i class="fas fa-user"></i> Mi Perfil
                            </a>
                            <a href="{{ route('client.settings.edit') }}" class="btn btn-outline">
                                <i class="fas fa-cog"></i> Configuración
                            </a>
                            <hr>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <div class="dashboard-grid">
                <!-- Tarjetas de Estadísticas -->
                <div class="stats-container">
                    <div class="stat-card primary">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-details">
                            <h3>Próxima Cita</h3>
                            @if($nextAppointment)
                                <p>
                                    {{ \Carbon\Carbon::parse($nextAppointment->date)->format('d M') }} 
                                    a las {{ \Carbon\Carbon::parse($nextAppointment->time)->format('H:i A') }}
                                    <br>
                                    con Dr. {{ $nextAppointment->psychologist->nombre }}
                                </p>
                            @else
                                <p>No hay citas programadas</p>
                            @endif
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-details">
                            <h3>Horas de Terapia</h3>
                            <p>{{ $therapyHours ?? 0 }} horas</p>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="quick-actions">
                    <a href="{{ isset($psychologist) ? route('appointments.create', ['psychologistId' => $psychologist->id]) : '#' }}" class="btn btn-new" {{ !isset($psychologist) ? 'disabled' : '' }}>
                        <i class="fas fa-plus-circle"></i>
                        Agendar Nueva Cita
                    </a>
                    <a href="{{ route('emergency') }}" class="btn btn-emergency">
                        <i class="fas fa-exclamation-circle"></i>
                        Ayuda de Emergencia
                    </a>
                </div>

                <!-- Sección de Psicólogos Recomendados -->
                <section class="psychologists-section">
                    <div class="section-header">
                        <h2>Psicólogos Recomendados</h2>
                        <a href="{{ route('psychologists.index') }}" class="btn btn-outline">Ver todos</a>
                    </div>

                    <div class="psychologists-grid">
                        <!-- Aquí irían los psicólogos recomendados -->
                        <p class="empty-state">No hay recomendaciones disponibles en este momento</p>
                    </div>
                </section>
            </div>
        </main>
    </div>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/dashboard-emergency.js') }}"></script>
</body>
</html>
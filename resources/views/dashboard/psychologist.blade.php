<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Psicólogo - PsyHelp</title>
    <!-- Fuentes de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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
                    <h3>Dr. {{ $user->nombre }}</h3>
                    <span>Psicólogo Profesional</span>
                </div>
            </div>

            <nav class="nav-menu">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
                <a href="{{ route('agenda.index') }}" class="nav-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Agenda</span>
                </a>
                <a href="{{ route('patients.index') }}" class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Pacientes</span>
                </a>
                <a href="{{ route('psychologist.profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i>
                    <span>Mi Perfil</span>
                </a>
            </nav>
        </aside>

        <!-- Contenido Principal -->
        <main class="main-content">
            <header class="top-bar">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Buscar paciente...">
                </div>

                <div class="top-bar-actions">
                    <div class="notifications-dropdown">
                        <button class="notifications-toggle">
                            <i class="fas fa-bell"></i>
                        </button>
                        <div class="notifications-menu" style="display: none;">
                            <div class="notifications-header">
                                <h3>Notificaciones</h3>
                            </div>
                            <div class="notifications-list">
                                <!-- Se llenará via JavaScript -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ $user->nombre }}&background=random" alt="User">
                        <div class="user-menu-dropdown">
                            <a href="{{ route('psychologist.profile.edit') }}" class="btn btn-outline">
                                <i class="fas fa-user"></i> Mi Perfil
                            </a>
                            <a href="{{ route('psychologist.settings.edit') }}" class="btn btn-outline">
                                <i class="fas fa-cog"></i> Configuración
                            </a>
                            <hr>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Contenido del Dashboard -->
            <div class="dashboard-grid">
                <!-- Estadísticas -->
                <div class="stats-container">
                    <div class="stat-card primary">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-details">
                            <h3>Citas Hoy</h3>
                            <p>{{ $appointmentsToday ?? 0 }} pendientes</p>
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-details">
                            <h3>Pacientes Activos</h3>
                            <p>{{ $activePatients ?? 0 }} pacientes</p>
                        </div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-details">
                            <h3>Valoración</h3>
                            <p>{{ number_format($rating ?? 0, 1) }}/5.0</p>
                        </div>
                    </div>
                </div>

                <!-- Próximas Citas -->
                <section class="appointments-section">
                    <div class="section-header">
                        <h2>Próximas Citas</h2>
                        <a href="{{ route('agenda.index') }}" class="btn btn-outline">Ver todas</a>
                    </div>

                    <div class="appointments-list">
                        @forelse($upcomingAppointments ?? [] as $appointment)
                            <div class="appointment-item">
                                <div class="appointment-time">
                                    <span class="date">{{ \Carbon\Carbon::parse($appointment->date)->format('d M') }}</span>
                                    <span class="time">{{ \Carbon\Carbon::parse($appointment->time)->format('H:i A') }}</span>
                                </div>
                                <div class="appointment-info">
                                    <h4>
                                        @if($appointment->patient && $appointment->patient->user)
                                            {{ $appointment->patient->user->nombre }}
                                        @else
                                            Paciente sin datos
                                        @endif
                                    </h4>
                                    <p>{{ $appointment->type }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-calendar-day"></i>
                                <p>No hay citas programadas</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PsyHelp</title>
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
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nombre }}&background=random" alt="Profile">
                </div>
                <div class="profile-info">
                    <h3>{{ Auth::user()->nombre }}</h3>
                    <span>{{ Auth::user()->rol }}</span>
                </div>
            </div>

            <nav class="nav-menu">
                <a href="#" class="nav-link active">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-calendar"></i>
                    <span>Citas</span>
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-comments"></i>
                    <span>Mensajes</span>
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-user-md"></i>
                    <span>Psicólogos</span>
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>Configuración</span>
                </a>
            </nav>

            <div class="emergency-button">
                <a href="#" class="emergency-link">
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
                    <input type="text" placeholder="Buscar...">
                </div>

                <div class="top-bar-actions">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </button>
                    
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nombre }}&background=random" alt="User">
                        <div class="user-menu-dropdown">
                            <a href="#"><i class="fas fa-user"></i> Perfil</a>
                            <a href="#"><i class="fas fa-cog"></i> Configuración</a>
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

            <div class="dashboard-grid">
                <!-- Tarjetas de Estadísticas -->
                <div class="stats-container">
                    <div class="stat-card primary">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-details">
                            <h3>Próxima Cita</h3>
                            <p>Mañana, 10:00 AM</p>
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-details">
                            <h3>Sesiones Completadas</h3>
                            <p>24 sesiones</p>
                        </div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-details">
                            <h3>Valoración</h3>
                            <p>4.8/5.0</p>
                        </div>
                    </div>
                </div>

                <!-- Sección de Psicólogos -->
                <section class="psychologists-section">
                    <div class="section-header">
                        <h2>Psicólogos Destacados</h2>
                        <button class="view-all-btn">Ver todos</button>
                    </div>

                    <div class="psychologists-grid">
                        @for ($i = 0; $i < 4; $i++)
                        <div class="psychologist-card">
                            <div class="psychologist-header">
                                <img src="https://ui-avatars.com/api/?name=Doctor&background=random" alt="Psychologist">
                                <span class="status-badge online"></span>
                            </div>
                            <div class="psychologist-info">
                                <h3>Dr. Nombre Apellido</h3>
                                <p class="specialty">Psicología Clínica</p>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span>4.8</span>
                                </div>
                                <div class="tags">
                                    <span class="tag">Ansiedad</span>
                                    <span class="tag">Depresión</span>
                                </div>
                            </div>
                            <div class="psychologist-actions">
                                <button class="btn btn-primary">
                                    <i class="fas fa-calendar-plus"></i>
                                    Agendar Cita
                                </button>
                                <button class="btn btn-secondary">
                                    <i class="fas fa-user"></i>
                                    Ver Perfil
                                </button>
                            </div>
                        </div>
                        @endfor
                    </div>
                </section>

                <!-- Calendario de Citas -->
                <section class="appointments-calendar">
                    <div class="section-header">
                        <h2>Próximas Citas</h2>
                        <button class="calendar-btn">
                            <i class="fas fa-calendar-alt"></i>
                            Ver Calendario
                        </button>
                    </div>

                    <div class="appointments-list">
                        <div class="appointment-item">
                            <div class="appointment-time">
                                <span class="date">Mar 15</span>
                                <span class="time">10:00 AM</span>
                            </div>
                            <div class="appointment-info">
                                <h4>Dra. María García</h4>
                                <p>Sesión de Terapia</p>
                            </div>
                            <div class="appointment-actions">
                                <button class="btn btn-outline">
                                    <i class="fas fa-clock"></i>
                                    Reprogramar
                                </button>
                                <button class="btn btn-link">
                                    <i class="fas fa-times"></i>
                                    Cancelar
                                </button>
                            </div>
                        </div>
                        <!-- Más citas aquí -->
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PsyHelp - Plataforma de apoyo psicológico y bienestar mental">
    <title>PsyHelp - Página Principal</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <header class="main-header">
        <nav class="nav-container">
            <div class="logo">PsyHelp</div>
            <div class="nav-buttons">
                <a href="{{ route('login') }}" class="nav-btn">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="nav-btn nav-btn-primary">Registrarse</a>
            </div>
        </nav>
        <div class="hero-section">
            <h1>Bienvenido a PsyHelp</h1>
            <p class="hero-text">Ofrecemos apoyo psicológico profesional y recursos para mejorar tu bienestar mental.</p>
        </div>
    </header>

    <main>
        <section class="services-section">
            <h2 class="section-title">Nuestros Servicios</h2>
            <div class="services-grid">
                <div class="service-card">
                    <i class="fas fa-user-md"></i>
                    <h3>Consultas Personalizadas</h3>
                    <p>Con Psicólogos Certificados</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-book"></i>
                    <h3>Recursos y Guías de Autoayuda</h3>
                    <p>Para tu autoconocimiento</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-video"></i>
                    <h3>Terapias en Línea Confidenciales</h3>
                    <p>Seguras y privadas</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-ambulance"></i>
                    <h3>Atención de Emergencias 24/7</h3>
                    <p>Para situaciones urgentes</p>
                </div>
            </div>
        </section>
        
        <section class="auth-options">
            <div class="auth-card register">
                <h2>¿Eres Nuevo?</h2>
                <p>Únete a nuestra comunidad y comienza tu camino hacia el bienestar mental.</p>
                <a href="{{ route('register') }}" class="btn btn-primary">Regístrate aquí</a>
            </div>
            
            <div class="auth-card login">
                <h2>¿Ya Tienes una Cuenta?</h2>
                <p>Accede a todos nuestros servicios.</p>
                <a href="{{ route('login') }}" class="btn btn-secondary">Iniciar sesión</a>
            </div>
        </section>
    </main>

    <footer class="main-footer">
        <div class="emergency-container">
            <p>En caso de emergencia, contacta nuestra línea de ayuda inmediata</p>
            <a href="{{ route('emergency') }}" class="btn btn-emergency">Ayuda de Emergencia</a>
        </div>
    </footer>
</body>
</html>
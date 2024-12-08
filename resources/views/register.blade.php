<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Registro en PsyHelp - Plataforma de apoyo psicológico">
    <title>Registro - PsyHelp</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header class="main-header">
        <nav class="nav-container">
            <div class="logo"><i class="fas fa-brain"></i> PsyHelp</div>
            <div class="nav-buttons">
                <a href="{{ route('login') }}" class="nav-btn"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</a>
                <a href="{{ route('dashboard') }}" class="nav-btn nav-btn-primary"><i class="fas fa-home"></i> Dashboard</a>
            </div>
        </nav>
    </header>

    <main class="auth-container">
        <div class="auth-card">
            <form action="{{ route('register') }}" method="POST" class="registration-form">
                @csrf
                <div class="form-header">
                    <i class="fas fa-user-plus"></i>
                    <h2>Crear una cuenta nueva</h2>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre"><i class="fas fa-user"></i> Nombre</label>
                        <input type="text" id="nombre" name="nombre" required placeholder="Tu nombre">
                    </div>

                    <div class="form-group">
                        <label for="apellido"><i class="fas fa-user"></i> Apellido</label>
                        <input type="text" id="apellido" name="apellido" required placeholder="Tu apellido">
                    </div>
                </div>

                <div class="form-group">
                    <label for="correo"><i class="fas fa-envelope"></i> Correo Electrónico</label>
                    <input type="email" id="correo" name="correo" required placeholder="ejemplo@correo.com">
                </div>

                <div class="form-group">
                    <label for="contraseña"><i class="fas fa-lock"></i> Contraseña</label>
                    <div class="password-input">
                        <input type="password" id="contraseña" name="contraseña" required placeholder="Tu contraseña">
                        <i class="fas fa-eye toggle-password"></i>
                    </div>
                    <small><i class="fas fa-info-circle"></i> La contraseña debe tener al menos 8 caracteres</small>
                </div>

                <div class="form-group">
                    <label for="rol"><i class="fas fa-user-tag"></i> Tipo de cuenta</label>
                    <select id="rol" name="rol" required>
                        <option value="">Selecciona un tipo de cuenta</option>
                        <option value="cliente">👤 Busco ayuda psicológica</option>
                        <option value="psicólogo">👨‍⚕️ Soy profesional de la salud mental</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Crear cuenta
                </button>

                <p class="form-footer">
                    ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a>
                </p>
            </form>
        </div>
    </main>

    <footer class="main-footer">
        <div class="emergency-container">
            <p><i class="fas fa-exclamation-triangle"></i> En caso de emergencia, contacta nuestra línea de ayuda inmediata</p>
            <a href="{{ route('emergency') }}" class="btn btn-emergency">
                <i class="fas fa-phone"></i> Ayuda de Emergencia
            </a>
        </div>
    </footer>
</body>
</html>
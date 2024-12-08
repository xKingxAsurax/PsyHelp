<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - PsyHelp Home</title>
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-header">
                    <h2>Iniciar Sesión</h2>
                </div>
                <input type="email" name="correo" placeholder="Correo Electrónico" required>
                <input type="password" name="contraseña" placeholder="Contraseña" required>
                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                <p class="form-footer">
                    ¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - PsyHelp Home</title>
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
</head>
<body>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <h2>Iniciar Sesión</h2>
        <input type="email" name="correo" placeholder="Correo Electrónico" required>
        <input type="password" name="contraseña" placeholder="Contraseña" required>
        <button type="submit">Iniciar Sesión</button>
        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
    </form>
</body>
</html>
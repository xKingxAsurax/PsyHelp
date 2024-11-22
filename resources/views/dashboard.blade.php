<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - PsyHelp Home</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <header>
        <h1>Bienvenido, {{ Auth::user()->nombre }}</h1>
        <nav>
            <a href="{{ route('profile') }}">Perfil</a>
            <a href="{{ route('logout') }}">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <h2>Psicólogos Disponibles</h2>
        <div id="psicologos-list">
            <!-- Aquí se mostrarán los psicólogos disponibles -->
        </div>
    </main>
</body>
</html>
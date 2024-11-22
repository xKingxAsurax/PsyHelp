<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil - PsyHelp Home</title>
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
</head>
<body>
    <h2>Perfil de Usuario</h2>
    <p>Nombre: {{ Auth::user()->nombre }}</p>
    <p>Correo: {{ Auth::user()->correo }}</p>
    <a href="{{ route('profile.edit') }}" class="btn">Editar Información</a>
</body>
</html>
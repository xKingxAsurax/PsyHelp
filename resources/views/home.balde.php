<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - PsyHelp Home</title>
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
</head>
<body>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <h2>Registro</h2>
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <input type="email" name="correo" placeholder="Correo Electrónico" required>
        <input type="password" name="contraseña" placeholder="Contraseña" required>
        <select name="rol" required>
            <option value="cliente">Cliente</option>
            <option value="psicólogo">Psicólogo</option>
        </select>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>
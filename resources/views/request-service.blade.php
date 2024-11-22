<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitar Servicio - PsyHelp Home</title>
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
</head>
<body>
    <form action="{{ route('request.service') }}" method="POST">
        @csrf
        <h2>Solicitar Servicio</h2>
        <input type="text" name="duracion" placeholder="Duración del Servicio" required>
        <input type="number" name="precio" placeholder="Precio Ofrecido" required>
        <div id="map"></div> <!-- Mapa para geolocalización -->
        <button type="submit">Enviar Solicitud</button>
    </form>
</body>
</html>
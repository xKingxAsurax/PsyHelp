<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calificaciones - PsyHelp Home</title>
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
</head>
<body>
    <h2>Calificar Servicio</h2>
    <form action ```blade
="{{ route('submit.rating') }}" method="POST">
        @csrf
        <input type="hidden" name="cita_id" value="{{ $cita->id }}">
        <label for="calificacion">Calificación (1-5):</label>
        <input type="number" name="calificacion" min="1" max="5" required>
        <textarea name="comentario" placeholder="Comentario"></textarea>
        <button type="submit">Enviar Calificación</button>
    </form>
</body>
</html>
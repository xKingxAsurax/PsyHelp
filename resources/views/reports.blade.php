<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes - PsyHelp Home</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <h2>Reportes</h2>
    <form action="{{ route('generate.report') }}" method="POST">
        @csrf
        <label for="fecha-inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha-inicio" required>
        <label for="fecha-fin">Fecha de Fin:</label>
        <input type="date" name="fecha-fin" required>
        <button type="submit">Generar Reporte</button>
    </form>
    <div id="report-results">
        <!-- Resultados del reporte se mostrarán aquí -->
    </div>
</body>
</html>
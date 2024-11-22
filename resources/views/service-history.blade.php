<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Servicios - PsyHelp Home</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <h2>Historial de Servicios</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Psicólogo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historial as $servicio)
            <tr>
                <td>{{ $servicio->fecha }}</td>
                <td>{{ $servicio->psicologo }}</td>
                <td>{{ $servicio->estado }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
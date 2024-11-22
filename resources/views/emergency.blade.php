<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Emergencia - PsyHelp Home</title>
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
</head>
<body>
    <h2>Emergencia</h2>
    <p>Si estás en una situación crítica, presiona el botón a continuación.</p>
    <button id="emergency-button" onclick="activateEmergency()">Activar Emergencia</button>
    <script>
        function activateEmergency() {
            // Lógica para activar la emergencia
            alert('Emergencia activada');
        }
    </script>
</body>
</html>
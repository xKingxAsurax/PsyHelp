<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Emergencia - PsyHelp Home</title>
    <link rel="stylesheet" href="{{ asset('css/emergency.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="emergency-container">
        <h2><i class="fas fa-exclamation-circle"></i> Emergencia</h2>
        <p>Si estás en una situación crítica, presiona el botón a continuación.</p>
        <button id="emergency-button" class="btn-emergency">
            <i class="fas fa-phone-alt"></i> Activar Emergencia
        </button>
        
        <div class="emergency-info">
            <p><strong>Nota:</strong> Al activar la emergencia, se compartirá tu ubicación con nuestro equipo de profesionales.</p>
        </div>
    </div>

    <script src="{{ asset('js/emergency.js') }}"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos de Emergencia - PsyHelp</title>
    <link rel="stylesheet" href="{{ asset('css/emergency.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="emergency-container">
        <h1><i class="fas fa-phone-alt"></i> Contactos de Emergencia</h1>
        
        <div class="contacts-list">
            @foreach($emergencyContacts as $contact)
                <div class="contact-card">
                    <h3>{{ $contact['name'] }}</h3>
                    <p class="phone">{{ $contact['phone'] }}</p>
                    <a href="tel:{{ $contact['phone'] }}" class="btn btn-emergency">
                        <i class="fas fa-phone"></i> Llamar ahora
                    </a>
                </div>
            @endforeach
        </div>

        <div class="back-button">
            <a href="{{ route('emergency') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</body>
</html> 
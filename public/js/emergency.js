document.addEventListener('DOMContentLoaded', function() {
    const emergencyButton = document.getElementById('emergency-button');
    
    if (emergencyButton) {
        console.log('Botón de emergencia encontrado');
        
        emergencyButton.addEventListener('click', async function(e) {
            e.preventDefault();
            console.log('Botón de emergencia clickeado');
            
            try {
                const response = await fetch('/emergency', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        description: 'Solicitud de ayuda de emergencia desde dashboard'
                    })
                });

                console.log('Respuesta recibida:', response);
                const data = await response.json();
                console.log('Datos:', data);

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Emergencia Registrada!',
                        text: 'Un profesional se pondrá en contacto contigo inmediatamente.',
                        confirmButtonText: 'Entendido'
                    });
                } else {
                    throw new Error(data.message || 'Error al procesar la emergencia');
                }

            } catch (error) {
                console.error('Error completo:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al procesar tu solicitud de emergencia. Por favor, intenta nuevamente.',
                    confirmButtonText: 'Cerrar'
                });
            }
        });
    } else {
        console.error('No se encontró el botón de emergencia');
    }
});

function getCurrentPosition() {
    return new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(resolve, reject);
    });
} 
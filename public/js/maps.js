function initMap() {
    // Inicialización del mapa para geolocalización
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: { lat: -34.397, lng: 150.644 }
    });

    // Obtener ubicación actual
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            map.setCenter(pos);
        });
    }
} 
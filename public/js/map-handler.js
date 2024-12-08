class MapHandler {
    constructor() {
        this.map = null;
        this.markers = [];
        this.currentRadius = 5;
        this.init();
    }

    async init() {
        try {
            const position = await this.getCurrentPosition();
            this.initMap(position);
            this.setupControls();
        } catch (error) {
            console.error('Error initializing map:', error);
        }
    }

    initMap(position) {
        this.map = L.map('map').setView([position.latitude, position.longitude], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(this.map);

        // Marcador de ubicación actual
        L.marker([position.latitude, position.longitude])
            .addTo(this.map)
            .bindPopup('Tu ubicación actual')
            .openPopup();
    }

    getCurrentPosition() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                reject(new Error('Geolocalización no soportada'));
            }

            navigator.geolocation.getCurrentPosition(
                position => {
                    resolve({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    });
                },
                error => {
                    reject(error);
                }
            );
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new MapHandler();
}); 
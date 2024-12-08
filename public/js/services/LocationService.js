class LocationService {
    constructor() {
        this.watchId = null;
        this.currentPosition = null;
    }

    async getCurrentPosition() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                reject(new Error('Geolocalización no soportada en este navegador'));
            }

            navigator.geolocation.getCurrentPosition(
                position => {
                    this.currentPosition = {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    };
                    resolve(this.currentPosition);
                },
                error => {
                    reject(error);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                }
            );
        });
    }

    startTracking(callback) {
        if (!navigator.geolocation) {
            throw new Error('Geolocalización no soportada');
        }

        this.watchId = navigator.geolocation.watchPosition(
            position => {
                const location = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                };
                this.currentPosition = location;
                callback(location);
            },
            error => {
                console.error('Error tracking location:', error);
            },
            {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            }
        );
    }

    stopTracking() {
        if (this.watchId) {
            navigator.geolocation.clearWatch(this.watchId);
            this.watchId = null;
        }
    }

    calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radio de la Tierra en km
        const dLat = this.toRad(lat2 - lat1);
        const dLon = this.toRad(lon2 - lon1);
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(this.toRad(lat1)) * Math.cos(this.toRad(lat2)) * 
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    toRad(value) {
        return value * Math.PI / 180;
    }
} 
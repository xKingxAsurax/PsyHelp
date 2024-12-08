class Dashboard {
    constructor() {
        this.userRole = document.body.dataset.role; // 'psicologo' o 'cliente'
        this.initializeElements();
        this.init();
    }

    initializeElements() {
        // Elementos comunes
        this.searchInput = document.querySelector('.search-bar input');
        this.userMenu = document.querySelector('.user-menu');
        this.notificationBtn = document.querySelector('.notification-btn');
        this.notificationBadge = document.querySelector('.badge');
        this.notificationDropdown = document.querySelector('.notification-dropdown');

        // Elementos específicos del psicólogo
        if (this.userRole === 'psicologo') {
            this.patientsList = document.querySelector('.patients-list');
            this.appointmentRequests = document.querySelector('.appointment-requests');
            this.emergencyAlerts = document.querySelector('.emergency-alerts');
        }
    }

    init() {
        this.initSearch();
        this.initUserMenu();
        this.initNotifications();
        
        if (this.userRole === 'psicologo') {
            this.initPsychologistFeatures();
        } else {
            this.initClientFeatures();
        }
    }

    initSearch() {
        if (this.searchInput) {
            let timeout = null;
            
            this.searchInput.addEventListener('input', (e) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    this.performSearch(e.target.value);
                }, 500);
            });
        }
    }

    async performSearch(query) {
        if (query.length < 2) return;

        const searchEndpoint = this.userRole === 'psicologo' 
            ? '/api/search/patients'
            : '/api/search/psychologists';

        try {
            const response = await fetch(`${searchEndpoint}?q=${encodeURIComponent(query)}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const data = await response.json();
            this.updateSearchResults(data);
        } catch (error) {
            console.error('Error en búsqueda:', error);
        }
    }

    updateSearchResults(results) {
        const resultsContainer = document.querySelector('.search-results');
        if (!resultsContainer) return;

        const template = this.userRole === 'psicologo' 
            ? this.getPsychologistSearchTemplate()
            : this.getClientSearchTemplate();

        resultsContainer.innerHTML = results.map(result => template(result)).join('');
    }

    getPsychologistSearchTemplate() {
        return (result) => `
            <div class="search-result-item">
                <img src="${result.avatar}" alt="${result.name}">
                <div class="result-info">
                    <h4>${result.name}</h4>
                    <p>Última cita: ${result.last_appointment || 'Sin citas previas'}</p>
                </div>
                <a href="/patients/${result.id}" class="btn btn-outline">Ver historial</a>
            </div>
        `;
    }

    getClientSearchTemplate() {
        return (result) => `
            <div class="search-result-item">
                <img src="${result.avatar}" alt="${result.name}">
                <div class="result-info">
                    <h4>${result.name}</h4>
                    <p>${result.specialty}</p>
                    <div class="rating">
                        ${this.getStarRating(result.rating)}
                    </div>
                </div>
                <a href="/appointments/create/${result.id}" class="btn btn-primary">Agendar cita</a>
            </div>
        `;
    }

    getStarRating(rating) {
        return '★'.repeat(Math.floor(rating)) + '☆'.repeat(5 - Math.floor(rating));
    }

    initPsychologistFeatures() {
        this.loadPatientsList();
        this.loadAppointmentRequests();
        this.initEmergencyAlerts();
    }

    async loadPatientsList() {
        if (!this.patientsList) return;

        try {
            const response = await fetch('/api/psychologist/patients');
            const data = await response.json();
            
            this.patientsList.innerHTML = data.map(patient => `
                <div class="patient-card">
                    <img src="${patient.avatar}" alt="${patient.name}">
                    <div class="patient-info">
                        <h4>${patient.name}</h4>
                        <p>Próxima cita: ${patient.next_appointment || 'Sin citas programadas'}</p>
                    </div>
                    <div class="patient-actions">
                        <a href="/patients/${patient.id}" class="btn btn-outline">Ver perfil</a>
                        <a href="/chat/${patient.id}" class="btn btn-primary">Chatear</a>
                    </div>
                </div>
            `).join('');
        } catch (error) {
            console.error('Error cargando lista de pacientes:', error);
        }
    }

    async loadAppointmentRequests() {
        if (!this.appointmentRequests) return;

        try {
            const response = await fetch('/api/psychologist/appointment-requests');
            const data = await response.json();
            
            this.appointmentRequests.innerHTML = data.map(request => `
                <div class="appointment-request">
                    <div class="request-info">
                        <h4>${request.patient_name}</h4>
                        <p>Fecha solicitada: ${request.requested_date}</p>
                    </div>
                    <div class="request-actions">
                        <button onclick="dashboard.handleAppointment(${request.id}, 'accept')" 
                                class="btn btn-success">Aceptar</button>
                        <button onclick="dashboard.handleAppointment(${request.id}, 'reject')" 
                                class="btn btn-danger">Rechazar</button>
                    </div>
                </div>
            `).join('');
        } catch (error) {
            console.error('Error cargando solicitudes de citas:', error);
        }
    }

    initEmergencyAlerts() {
        // Inicializar conexión WebSocket para alertas de emergencia
        Echo.private('emergency-alerts')
            .listen('EmergencyActivated', (e) => {
                this.showEmergencyAlert(e.emergency);
            });
    }

    showEmergencyAlert(emergency) {
        const alert = `
            <div class="emergency-alert" data-id="${emergency.id}">
                <div class="alert-header">
                    <i class="fas fa-exclamation-circle"></i>
                    <h4>¡Emergencia!</h4>
                </div>
                <p>Paciente: ${emergency.patient_name}</p>
                <p>Ubicación: ${emergency.location}</p>
                <div class="alert-actions">
                    <button onclick="dashboard.handleEmergency(${emergency.id}, 'accept')" 
                            class="btn btn-success">Atender</button>
                    <button onclick="dashboard.handleEmergency(${emergency.id}, 'reject')" 
                            class="btn btn-danger">No disponible</button>
                </div>
            </div>
        `;

        if (this.emergencyAlerts) {
            this.emergencyAlerts.insertAdjacentHTML('afterbegin', alert);
        }
    }

    async handleEmergency(emergencyId, action) {
        try {
            const response = await fetch(`/api/emergency/${emergencyId}/${action}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (response.ok) {
                document.querySelector(`[data-id="${emergencyId}"]`).remove();
            }
        } catch (error) {
            console.error('Error manejando emergencia:', error);
        }
    }

    initUserMenu() {
        if (this.userMenu) {
            this.userMenu.addEventListener('click', (e) => {
                e.stopPropagation();
                this.userMenu.querySelector('.user-menu-dropdown').classList.toggle('active');
            });

            // Cerrar al hacer clic fuera
            document.addEventListener('click', (e) => {
                if (!this.userMenu.contains(e.target)) {
                    this.userMenu.querySelector('.user-menu-dropdown').classList.remove('active');
                }
            });
        }
    }

    initNotifications() {
        if (this.notificationBtn) {
            this.notificationBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleNotifications();
            });

            // Actualizar notificaciones cada minuto
            setInterval(() => this.loadNotifications(), 60000);
        }
    }

    async loadNotifications() {
        try {
            const response = await fetch('/api/notifications', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const data = await response.json();
            this.updateNotificationBadge(data.unread);
            this.updateNotificationDropdown(data.notifications);
        } catch (error) {
            console.error('Error cargando notificaciones:', error);
        }
    }

    updateNotificationBadge(count) {
        if (this.notificationBadge) {
            this.notificationBadge.textContent = count;
            this.notificationBadge.style.display = count > 0 ? 'block' : 'none';
        }
    }

    updateNotificationDropdown(notifications) {
        if (this.notificationDropdown) {
            this.notificationDropdown.innerHTML = notifications.length ? notifications.map(notif => `
                <div class="notification-item ${notif.read ? '' : 'unread'}">
                    <i class="${this.getNotificationIcon(notif.type)}"></i>
                    <div class="notification-content">
                        <p>${notif.message}</p>
                        <small>${this.formatDate(notif.created_at)}</small>
                    </div>
                    ${!notif.read ? `
                        <button onclick="dashboard.markAsRead('${notif.id}')" class="btn-mark-read">
                            <i class="fas fa-check"></i>
                        </button>
                    ` : ''}
                </div>
            `).join('') : '<div class="no-notifications">No hay notificaciones</div>';
        }
    }

    toggleNotifications() {
        if (this.notificationDropdown) {
            this.notificationDropdown.classList.toggle('active');
        }
    }

    async markAsRead(notificationId) {
        try {
            await fetch(`/api/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            this.loadNotifications();
        } catch (error) {
            console.error('Error marcando notificación como leída:', error);
        }
    }

    getNotificationIcon(type) {
        const icons = {
            'appointment': 'fas fa-calendar',
            'message': 'fas fa-envelope',
            'emergency': 'fas fa-exclamation-circle',
            'default': 'fas fa-bell'
        };
        return icons[type] || icons.default;
    }

    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('es-ES', {
            day: 'numeric',
            month: 'short',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
}

// Inicializar el dashboard
const dashboard = new Dashboard();
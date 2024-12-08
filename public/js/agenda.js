document.addEventListener('DOMContentLoaded', function() {
    const calendar = {
        init() {
            this.bindEvents();
            this.loadAppointments();
            this.updateWeekDisplay();
        },

        bindEvents() {
            document.getElementById('prevWeek').addEventListener('click', () => this.changeWeek(-1));
            document.getElementById('nextWeek').addEventListener('click', () => this.changeWeek(1));
            
            // Agregar eventos para crear citas
            document.querySelectorAll('.time-slot').forEach(slot => {
                slot.addEventListener('click', (e) => this.handleTimeSlotClick(e));
            });
        },

        async loadAppointments() {
            try {
                const response = await fetch('/agenda/citas');
                const appointments = await response.json();
                this.renderAppointments(appointments);
            } catch (error) {
                console.error('Error cargando citas:', error);
            }
        },

        renderAppointments(appointments) {
            // Lógica para renderizar las citas en el calendario
        },

        updateWeekDisplay() {
            // Actualizar el texto que muestra la semana actual
        },

        changeWeek(offset) {
            // Lógica para cambiar la semana mostrada
        },

        handleTimeSlotClick(event) {
            // Lógica para manejar el click en un slot de tiempo
        }
    };

    calendar.init();
}); 
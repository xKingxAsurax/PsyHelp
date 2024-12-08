document.addEventListener('DOMContentLoaded', function() {
    const makeOfferBtns = document.querySelectorAll('.make-offer-btn');
    const modal = document.getElementById('counterOfferModal');
    const closeBtn = document.querySelector('.close');

    makeOfferBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const offerId = this.getAttribute('data-offer-id');
            openModal(offerId);
        });
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    function openModal(offerId) {
        modal.style.display = 'block';
        // Aquí puedes cargar dinámicamente el contenido del modal
        // basado en el ID de la oferta
        modal.querySelector('.modal-content').innerHTML = `
            <span class="close">&times;</span>
            <h2>Hacer Contraoferta</h2>
            <form id="counterOfferForm">
                <input type="hidden" name="offer_id" value="${offerId}">
                <div class="form-group">
                    <label for="price">Precio:</label>
                    <input type="number" id="price" name="price" required min="0" step="0.01">
                </div>
                <div class="form-group">
                    <label for="duration">Duración (minutos):</label>
                    <input type="number" id="duration" name="duration" required min="30" max="180">
                </div>
                <div class="form-group">
                    <label for="message">Mensaje (opcional):</label>
                    <textarea id="message" name="message" maxlength="500"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar Contraoferta</button>
            </form>
        `;

        // Agregar evento de envío al formulario
        const form = document.getElementById('counterOfferForm');
        form.addEventListener('submit', submitCounterOffer);
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    async function submitCounterOffer(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        const offerId = formData.get('offer_id');

        try {
            const response = await fetch(`/offers/${offerId}/counter-offer`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (response.ok) {
                closeModal();
                // Recargar la página o actualizar la lista de ofertas
                location.reload();
            } else {
                const errorData = await response.json();
                alert('Error al enviar la contraoferta: ' + errorData.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Ocurrió un error al enviar la contraoferta');
        }
    }
}); 
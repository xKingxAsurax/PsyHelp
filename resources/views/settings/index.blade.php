<x-app-layout>
    <div class="settings-container">
        <h2><i class="fas fa-cog"></i> Configuración</h2>
        
        <div class="settings-grid">
            <div class="settings-card">
                <h3>Notificaciones</h3>
                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="email_notifications" value="1">
                            Recibir notificaciones por email
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="sms_notifications" value="1">
                            Recibir notificaciones por SMS
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </form>
            </div>

            <div class="settings-card">
                <h3>Privacidad</h3>
                <form action="{{ route('settings.privacy') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="profile_visible" value="1">
                            Perfil visible para otros usuarios
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar privacidad</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 
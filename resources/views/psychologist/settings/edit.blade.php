@extends('layouts.app')

@section('content')
<div class="settings-container">
    <div class="settings-header">
        <h2><i class="fas fa-cog"></i> Configuración</h2>
    </div>
    
    @if (session('status') === 'settings-updated')
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> Configuración actualizada correctamente
        </div>
    @endif

    <form action="{{ route('psychologist.settings.update') }}" method="POST" class="settings-form">
        @csrf
        @method('PATCH')
        
        <div class="settings-section">
            <h3>Notificaciones</h3>
            <div class="form-group">
                <label class="switch">
                    <input type="checkbox" name="notifications_enabled" {{ old('notifications_enabled', $user->settings->notifications_enabled ?? false) ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
                <span>Activar notificaciones</span>
            </div>

            <div class="form-group">
                <label class="switch">
                    <input type="checkbox" name="email_notifications" {{ old('email_notifications', $user->settings->email_notifications ?? false) ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
                <span>Notificaciones por email</span>
            </div>

            <div class="form-group">
                <label class="switch">
                    <input type="checkbox" name="sms_notifications" {{ old('sms_notifications', $user->settings->sms_notifications ?? false) ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
                <span>Notificaciones por SMS</span>
            </div>
        </div>

        <div class="settings-section">
            <h3>Preferencias de Consulta</h3>
            <div class="form-group">
                <label for="appointment_duration">Duración de consulta (minutos)</label>
                <select name="appointment_duration" id="appointment_duration" class="form-select">
                    <option value="30" {{ old('appointment_duration', $user->settings->appointment_duration ?? 60) == 30 ? 'selected' : '' }}>30 minutos</option>
                    <option value="45" {{ old('appointment_duration', $user->settings->appointment_duration ?? 60) == 45 ? 'selected' : '' }}>45 minutos</option>
                    <option value="60" {{ old('appointment_duration', $user->settings->appointment_duration ?? 60) == 60 ? 'selected' : '' }}>1 hora</option>
                    <option value="90" {{ old('appointment_duration', $user->settings->appointment_duration ?? 60) == 90 ? 'selected' : '' }}>1 hora 30 minutos</option>
                </select>
            </div>

            <div class="form-group">
                <label for="break_time">Tiempo entre consultas (minutos)</label>
                <select name="break_time" id="break_time" class="form-select">
                    <option value="0" {{ old('break_time', $user->settings->break_time ?? 15) == 0 ? 'selected' : '' }}>Sin descanso</option>
                    <option value="15" {{ old('break_time', $user->settings->break_time ?? 15) == 15 ? 'selected' : '' }}>15 minutos</option>
                    <option value="30" {{ old('break_time', $user->settings->break_time ?? 15) == 30 ? 'selected' : '' }}>30 minutos</option>
                </select>
            </div>

            <div class="form-group">
                <label class="switch">
                    <input type="checkbox" name="online_status" {{ old('online_status', $user->settings->online_status ?? true) ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
                <span>Mostrar como disponible para consultas en línea</span>
            </div>
        </div>

        <div class="settings-section">
            <h3>Preferencias Generales</h3>
            <div class="form-group">
                <label for="language">Idioma</label>
                <select name="language" id="language" class="form-select">
                    <option value="es" {{ old('language', $user->settings->language ?? 'es') === 'es' ? 'selected' : '' }}>Español</option>
                    <option value="en" {{ old('language', $user->settings->language ?? 'es') === 'en' ? 'selected' : '' }}>English</option>
                </select>
            </div>

            <div class="form-group">
                <label for="timezone">Zona Horaria</label>
                <select name="timezone" id="timezone" class="form-select">
                    <option value="America/Bogota" {{ old('timezone', $user->settings->timezone ?? 'America/Bogota') === 'America/Bogota' ? 'selected' : '' }}>Bogotá</option>
                    <option value="America/Mexico_City" {{ old('timezone', $user->settings->timezone ?? 'America/Bogota') === 'America/Mexico_City' ? 'selected' : '' }}>Ciudad de México</option>
                </select>
            </div>
        </div>

        <div class="settings-actions">
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection 
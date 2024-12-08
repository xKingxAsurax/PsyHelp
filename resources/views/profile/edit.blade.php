@extends('layouts.app')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h2><i class="fas fa-user-circle"></i> Mi Perfil</h2>
    </div>
    
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> Perfil actualizado correctamente
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
        @csrf
        @method('PATCH')
        
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $user->nombre) }}" required>
            @error('nombre')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="tel" id="telefono" name="telefono" value="{{ old('telefono', $user->telefono) }}">
            @error('telefono')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        @if($user->rol === 'psicólogo')
            <div class="form-group">
                <label for="especialidad">Especialidad</label>
                <input type="text" id="especialidad" name="especialidad" value="{{ old('especialidad', $user->especialidad) }}" required>
                @error('especialidad')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="biografia">Biografía Profesional</label>
                <textarea id="biografia" name="biografia" rows="4">{{ old('biografia', $user->biografia) }}</textarea>
                @error('biografia')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        @endif

        <div class="profile-actions">
            <a href="{{ route('dashboard') }}" class="btn-cancel">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection

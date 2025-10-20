<<<<<<< HEAD
@extends('layouts.tabler')

@section('title', 'Editar Usuario - ' . $user->full_name)
@section('page-title', 'Editar Usuario')
@section('page-description', 'Modificar información del usuario: ' . $user->full_name)

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-edit me-2"></i>
                        Editar Usuario: {{ $user->full_name }}
                    </h3>
                    <div class="card-actions">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary custom">
                            <i class="fas fa-arrow-left me-1"></i>
                            Volver a Usuarios
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 9v2m0 4v.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <strong>Por favor, corrige los siguientes errores:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    @endif

=======
@extends('layouts.app')

@section('title', 'Editar Usuario - ' . $user->full_name)

@section('content')
<div class="container-fluid">
    <!-- Navegación -->
    <x-head-admin />

    <!-- Fin Navegación -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Editar Usuario: {{ $user->full_name }}</h3>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver a Usuarios
                    </a>
                </div>
                
                <div class="card-body">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Información Básica -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Información Básica</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
<<<<<<< HEAD
                                                <div class="mb-3">
                                                    <label class="form-label" for="first_name" class="required">Nombre</label>
=======
                                                <div class="form-group">
                                                    <label for="first_name" class="required">Nombre</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                    <input type="text" 
                                                           class="form-control @error('first_name') is-invalid @enderror" 
                                                           id="first_name" 
                                                           name="first_name" 
                                                           value="{{ old('first_name', $user->first_name) }}" 
                                                           required>
                                                    @error('first_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
<<<<<<< HEAD
                                                <div class="mb-3">
                                                    <label class="form-label" for="last_name" class="required">Apellido</label>
=======
                                                <div class="form-group">
                                                    <label for="last_name" class="required">Apellido</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                    <input type="text" 
                                                           class="form-control @error('last_name') is-invalid @enderror" 
                                                           id="last_name" 
                                                           name="last_name" 
                                                           value="{{ old('last_name', $user->last_name) }}" 
                                                           required>
                                                    @error('last_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
<<<<<<< HEAD
                                        <div class="mb-3">
                                            <label class="form-label" for="email" class="required">Correo Electrónico</label>
=======
                                        <div class="form-group">
                                            <label for="email" class="required">Correo Electrónico</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $user->email) }}" 
                                                   required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
<<<<<<< HEAD
                                        <div class="mb-3">
                                            <label class="form-label" for="phone">Teléfono</label>
=======
                                        <div class="form-group">
                                            <label for="phone">Teléfono</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                            <input type="text" 
                                                   class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" 
                                                   name="phone" 
                                                   value="{{ old('phone', $user->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
<<<<<<< HEAD
                                                <div class="mb-3">
                                                    <label class="form-label" for="password" class="form-label">Nueva Contraseña</label>
=======
                                                <div class="form-group">
                                                    <label for="password">Nueva Contraseña</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                    <input type="password" 
                                                           class="form-control @error('password') is-invalid @enderror" 
                                                           id="password" 
                                                           name="password">
<<<<<<< HEAD
                                                    <div class="form-text">Déjalo en blanco para mantener la contraseña actual</div>
=======
                                                    <small class="form-text text-muted">Déjalo en blanco para mantener la contraseña actual</small>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
<<<<<<< HEAD
                                                <div class="mb-3">
                                                    <label class="form-label" for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                                                    <input type="password" 
                                                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                                                           id="password_confirmation" 
                                                           name="password_confirmation">
                                                    @error('password_confirmation')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
=======
                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                                                    <input type="password" 
                                                           class="form-control" 
                                                           id="password_confirmation" 
                                                           name="password_confirmation">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input type="checkbox" 
                                                           class="form-check-input" 
                                                           id="is_active" 
                                                           name="is_active" 
                                                           value="1" 
                                                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
<<<<<<< HEAD
                                                    <label class="form-label" class="form-check-label" for="is_active">
=======
                                                    <label class="form-check-label" for="is_active">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                        Usuario Activo
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input type="checkbox" 
                                                           class="form-check-input" 
                                                           id="is_verified" 
                                                           name="is_verified" 
                                                           value="1" 
                                                           {{ old('is_verified', $user->is_verified) ? 'checked' : '' }}>
<<<<<<< HEAD
                                                    <label class="form-label" class="form-check-label" for="is_verified">
=======
                                                    <label class="form-check-label" for="is_verified">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                        Usuario Verificado
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Información del Perfil -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Información del Perfil</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
<<<<<<< HEAD
                                                <div class="mb-3">
                                                    <label class="form-label" for="date_of_birth">Fecha de Nacimiento</label>
=======
                                                <div class="form-group">
                                                    <label for="date_of_birth">Fecha de Nacimiento</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                    <input type="date" 
                                                           class="form-control @error('date_of_birth') is-invalid @enderror" 
                                                           id="date_of_birth" 
                                                           name="date_of_birth" 
                                                           value="{{ old('date_of_birth', $user->profile?->date_of_birth?->format('Y-m-d')) }}">
                                                    @error('date_of_birth')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
<<<<<<< HEAD
                                                <div class="mb-3">
                                                    <label class="form-label" for="gender">Género</label>
=======
                                                <div class="form-group">
                                                    <label for="gender">Género</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                    <select class="form-control @error('gender') is-invalid @enderror" 
                                                            id="gender" 
                                                            name="gender">
                                                        <option value="">Seleccionar Género</option>
                                                        <option value="male" {{ old('gender', $user->profile?->gender) == 'male' ? 'selected' : '' }}>Masculino</option>
                                                        <option value="female" {{ old('gender', $user->profile?->gender) == 'female' ? 'selected' : '' }}>Femenino</option>
                                                        <option value="other" {{ old('gender', $user->profile?->gender) == 'other' ? 'selected' : '' }}>Otro</option>
                                                        <option value="prefer_not_to_say" {{ old('gender', $user->profile?->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefiero no decirlo</option>
                                                    </select>
                                                    @error('gender')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
<<<<<<< HEAD
                                        <div class="mb-3">
                                            <label class="form-label" for="bio">Biografía</label>
=======
                                        <div class="form-group">
                                            <label for="bio">Biografía</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                                      id="bio" 
                                                      name="bio" 
                                                      rows="3" 
                                                      placeholder="Cuéntanos sobre ti...">{{ old('bio', $user->profile?->bio) }}</textarea>
                                            @error('bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
<<<<<<< HEAD
                                        <div class="mb-3">
                                            <label class="form-label" for="address">Dirección</label>
=======
                                        <div class="form-group">
                                            <label for="address">Dirección</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                            <input type="text" 
                                                   class="form-control @error('address') is-invalid @enderror" 
                                                   id="address" 
                                                   name="address" 
                                                   value="{{ old('address', $user->profile?->address) }}" 
                                                   placeholder="Dirección exacta">
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
<<<<<<< HEAD
                                                <div class="mb-3">
                                                    <label class="form-label" for="city">Ciudad</label>
=======
                                                <div class="form-group">
                                                    <label for="city">Ciudad</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                    <input type="text" 
                                                           class="form-control @error('city') is-invalid @enderror" 
                                                           id="city" 
                                                           name="city" 
                                                           value="{{ old('city', $user->profile?->city) }}">
                                                    @error('city')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
<<<<<<< HEAD
                                                <div class="mb-3">
                                                    <label class="form-label" for="state">Estado / Provincia</label>
=======
                                                <div class="form-group">
                                                    <label for="state">Estado / Provincia</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                    <input type="text" 
                                                           class="form-control @error('state') is-invalid @enderror" 
                                                           id="state" 
                                                           name="state" 
                                                           value="{{ old('state', $user->profile?->state) }}">
                                                    @error('state')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
<<<<<<< HEAD
                                                <div class="mb-3">
                                                    <label class="form-label" for="postal_code">Código Postal</label>
=======
                                                <div class="form-group">
                                                    <label for="postal_code">Código Postal</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                    <input type="text" 
                                                           class="form-control @error('postal_code') is-invalid @enderror" 
                                                           id="postal_code" 
                                                           name="postal_code" 
                                                           value="{{ old('postal_code', $user->profile?->postal_code) }}">
                                                    @error('postal_code')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
<<<<<<< HEAD
                                        <div class="mb-3">
                                            <label class="form-label" for="country">País</label>
=======
                                        <div class="form-group">
                                            <label for="country">País</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                            <input type="text" 
                                                   class="form-control @error('country') is-invalid @enderror" 
                                                   id="country" 
                                                   name="country" 
                                                   value="{{ old('country', $user->profile?->country) }}">
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contacto de Emergencia -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Contacto de Emergencia</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
<<<<<<< HEAD
                                                <div class="mb-3">
                                                    <label class="form-label" for="emergency_contact_name">Nombre del Contacto</label>
=======
                                                <div class="form-group">
                                                    <label for="emergency_contact_name">Nombre del Contacto</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                    <input type="text" 
                                                           class="form-control @error('emergency_contact_name') is-invalid @enderror" 
                                                           id="emergency_contact_name" 
                                                           name="emergency_contact_name" 
                                                           value="{{ old('emergency_contact_name', $user->profile?->emergency_contact_name) }}">
                                                    @error('emergency_contact_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
<<<<<<< HEAD
                                                <div class="mb-3">
                                                    <label class="form-label" for="emergency_contact_phone">Teléfono del Contacto</label>
=======
                                                <div class="form-group">
                                                    <label for="emergency_contact_phone">Teléfono del Contacto</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                    <input type="text" 
                                                           class="form-control @error('emergency_contact_phone') is-invalid @enderror" 
                                                           id="emergency_contact_phone" 
                                                           name="emergency_contact_phone" 
                                                           value="{{ old('emergency_contact_phone', $user->profile?->emergency_contact_phone) }}">
                                                    @error('emergency_contact_phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
<<<<<<< HEAD
                                                <div class="mb-3">
                                                    <label class="form-label" for="emergency_contact_relationship">Relación</label>
=======
                                                <div class="form-group">
                                                    <label for="emergency_contact_relationship">Relación</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                    <input type="text" 
                                                           class="form-control @error('emergency_contact_relationship') is-invalid @enderror" 
                                                           id="emergency_contact_relationship" 
                                                           name="emergency_contact_relationship" 
                                                           value="{{ old('emergency_contact_relationship', $user->profile?->emergency_contact_relationship) }}">
                                                    @error('emergency_contact_relationship')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Roles -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Roles del Usuario</h5>
                                    </div>
                                    <div class="card-body">
<<<<<<< HEAD
                                        <div class="mb-3">
                                            <label class="form-label" class="required">Asignar Roles</label>
=======
                                        <div class="form-group">
                                            <label class="required">Asignar Roles</label>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                            <div class="row">
                                                @foreach($roles as $role)
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input type="checkbox" 
                                                                   class="form-check-input @error('roles') is-invalid @enderror" 
                                                                   id="role_{{ $role->id }}" 
                                                                   name="roles[]" 
                                                                   value="{{ $role->id }}"
                                                                   {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
<<<<<<< HEAD
                                                            <label class="form-label" class="form-check-label" for="role_{{ $role->id }}">
=======
                                                            <label class="form-check-label" for="role_{{ $role->id }}">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                                <strong>{{ $role->name }}</strong>
                                                                @if($role->description)
                                                                    <br><small class="text-muted">{{ $role->description }}</small>
                                                                @endif
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('roles')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones -->
<<<<<<< HEAD
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary me-2 custom">
                                    <i class="fas fa-times me-1"></i>
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary custom">
                                    <i class="fas fa-save me-1"></i>
                                    Actualizar Usuario
                                </button>
=======
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Actualizar Usuario
                                    </button>
                                </div>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .required::after {
        content: " *";
        color: red;
    }
    .card {
        margin-bottom: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    .form-check {
        margin-bottom: 0.75rem;
    }
    .btn {
        border-radius: 0.3rem;
    }
</style>
@endpush

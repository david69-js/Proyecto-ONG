@extends('layouts.tabler')

@section('title', 'Crear Nuevo Usuario')
@section('page-title', 'Crear Nuevo Usuario')
@section('page-description', 'Registrar un nuevo usuario en el sistema')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Crear Nuevo Usuario</h3>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver a Usuarios
                    </a>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
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
                                                <div class="form-group">
                                                    <label for="first_name" class="required">Nombre</label>
                                                    <input type="text" 
                                                           class="form-control @error('first_name') is-invalid @enderror" 
                                                           id="first_name" 
                                                           name="first_name" 
                                                           value="{{ old('first_name') }}" 
                                                           required>
                                                    @error('first_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last_name" class="required">Apellido</label>
                                                    <input type="text" 
                                                           class="form-control @error('last_name') is-invalid @enderror" 
                                                           id="last_name" 
                                                           name="last_name" 
                                                           value="{{ old('last_name') }}" 
                                                           required>
                                                    @error('last_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="avatar">Foto de Perfil</label>
                                            <input type="file" 
                                                   class="form-control @error('avatar') is-invalid @enderror" 
                                                   id="avatar" 
                                                   name="avatar" 
                                                   accept="image/*">
                                            @error('avatar')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Formatos permitidos: JPEG, PNG, JPG, GIF, WEBP. Máximo 2MB.
                                            </small>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="email" class="required">Correo Electrónico</label>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email') }}" 
                                                   required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="phone">Número de Teléfono</label>
                                            <input type="text" 
                                                   class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" 
                                                   name="phone" 
                                                   value="{{ old('phone') }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password" class="required">Contraseña</label>
                                                    <input type="password" 
                                                           class="form-control @error('password') is-invalid @enderror" 
                                                           id="password" 
                                                           name="password" 
                                                           required>
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password_confirmation" class="required">Confirmar Contraseña</label>
                                                    <input type="password" 
                                                           class="form-control" 
                                                           id="password_confirmation" 
                                                           name="password_confirmation" 
                                                           required>
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
                                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active">
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
                                                           {{ old('is_verified') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_verified">
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
                                                <div class="form-group">
                                                    <label for="date_of_birth">Fecha de Nacimiento</label>
                                                    <input type="date" 
                                                           class="form-control @error('date_of_birth') is-invalid @enderror" 
                                                           id="date_of_birth" 
                                                           name="date_of_birth" 
                                                           value="{{ old('date_of_birth') }}">
                                                    @error('date_of_birth')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="gender">Género</label>
                                                    <select class="form-control @error('gender') is-invalid @enderror" 
                                                            id="gender" 
                                                            name="gender">
                                                        <option value="">Seleccionar Género</option>
                                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Masculino</option>
                                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femenino</option>
                                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Otro</option>
                                                        <option value="prefer_not_to_say" {{ old('gender') == 'prefer_not_to_say' ? 'selected' : '' }}>Prefiero no decirlo</option>
                                                    </select>
                                                    @error('gender')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="bio">Biografía</label>
                                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                                      id="bio" 
                                                      name="bio" 
                                                      rows="3" 
                                                      placeholder="Cuéntanos algo sobre ti...">{{ old('bio') }}</textarea>
                                            @error('bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="address">Dirección</label>
                                            <input type="text" 
                                                   class="form-control @error('address') is-invalid @enderror" 
                                                   id="address" 
                                                   name="address" 
                                                   value="{{ old('address') }}" 
                                                   placeholder="Dirección de calle">
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="city">Ciudad</label>
                                                    <input type="text" 
                                                           class="form-control @error('city') is-invalid @enderror" 
                                                           id="city" 
                                                           name="city" 
                                                           value="{{ old('city') }}">
                                                    @error('city')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="state">Estado / Provincia</label>
                                                    <input type="text" 
                                                           class="form-control @error('state') is-invalid @enderror" 
                                                           id="state" 
                                                           name="state" 
                                                           value="{{ old('state') }}">
                                                    @error('state')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="postal_code">Código Postal</label>
                                                    <input type="text" 
                                                           class="form-control @error('postal_code') is-invalid @enderror" 
                                                           id="postal_code" 
                                                           name="postal_code" 
                                                           value="{{ old('postal_code') }}">
                                                    @error('postal_code')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="country">País</label>
                                            <input type="text" 
                                                   class="form-control @error('country') is-invalid @enderror" 
                                                   id="country" 
                                                   name="country" 
                                                   value="{{ old('country') }}">
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
                                                <div class="form-group">
                                                    <label for="emergency_contact_name">Nombre del Contacto</label>
                                                    <input type="text" 
                                                           class="form-control @error('emergency_contact_name') is-invalid @enderror" 
                                                           id="emergency_contact_name" 
                                                           name="emergency_contact_name" 
                                                           value="{{ old('emergency_contact_name') }}">
                                                    @error('emergency_contact_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="emergency_contact_phone">Teléfono del Contacto</label>
                                                    <input type="text" 
                                                           class="form-control @error('emergency_contact_phone') is-invalid @enderror" 
                                                           id="emergency_contact_phone" 
                                                           name="emergency_contact_phone" 
                                                           value="{{ old('emergency_contact_phone') }}">
                                                    @error('emergency_contact_phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="emergency_contact_relationship">Relación</label>
                                                    <input type="text" 
                                                           class="form-control @error('emergency_contact_relationship') is-invalid @enderror" 
                                                           id="emergency_contact_relationship" 
                                                           name="emergency_contact_relationship" 
                                                           value="{{ old('emergency_contact_relationship') }}">
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
                                        <div class="form-group">
                                            <label class="required">Asignar Roles</label>
                                            <div class="row">
                                                @foreach($roles as $role)
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input type="checkbox" 
                                                                   class="form-check-input @error('roles') is-invalid @enderror" 
                                                                   id="role_{{ $role->id }}" 
                                                                   name="roles[]" 
                                                                   value="{{ $role->id }}"
                                                                   {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="role_{{ $role->id }}">
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
                        
                        <!-- Botones de Envío -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Crear Usuario
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

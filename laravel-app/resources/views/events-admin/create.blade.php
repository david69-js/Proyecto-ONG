@extends('layouts.tabler')

@section('title', 'Crear Evento')
@section('page-title', 'Crear Evento')
@section('page-description', 'Registra un nuevo evento en el sistema')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-plus me-2"></i>
                        Información del Evento
                    </h3>
                    <div class="card-actions">
                        <a href="{{ route('admin.events-admin.index') }}" class="btn btn-outline-secondary custom">
                            <i class="fas fa-arrow-left me-1"></i>
                            Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.events-admin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Alertas de Errores -->
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

                        <div class="row">
                            <!-- Información Básica -->
                            <div class="col-12 col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <i class="fas fa-info-circle"></i>
                                            Información Básica
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label required">
                                                        <i class="fas fa-heading me-1"></i>
                                                        Título del Evento
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control @error('title') is-invalid @enderror" 
                                                           id="title" 
                                                           name="title" 
                                                           value="{{ old('title') }}" 
                                                           required>
                                                    @error('title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="description">
                                                        <i class="fas fa-align-left"></i>
                                                        Descripción
                                                    </label>
                                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                                              id="description" 
                                                              name="description" 
                                                              rows="4">{{ old('description') }}</textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6">
                                                <div class="mb-3">
                                                    <label for="event_type">
                                                        <i class="fas fa-tags"></i>
                                                        Tipo de Evento 
                                                        <span class="text-danger font-weight-bold">*</span>
                                                    </label>
                                                    <select class="form-control @error('event_type') is-invalid @enderror" 
                                                            id="event_type" 
                                                            name="event_type" 
                                                            required>
                                                        <option value="">Seleccionar tipo</option>
                                                        @foreach($eventTypes as $key => $value)
                                                            <option value="{{ $key }}" {{ old('event_type') == $key ? 'selected' : '' }}>
                                                                {{ $value }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('event_type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6">
                                                <div class="mb-3">
                                                    <label for="status">
                                                        <i class="fas fa-flag"></i>
                                                        Estado 
                                                        <span class="text-danger font-weight-bold">*</span>
                                                    </label>
                                                    <select class="form-control @error('status') is-invalid @enderror" 
                                                            id="status" 
                                                            name="status" 
                                                            required>
                                                        @foreach($eventStatuses as $key => $value)
                                                            <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
                                                                {{ $value }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('status')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Fechas y Ubicación -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <i class="fas fa-calendar-alt"></i>
                                            Fechas y Ubicación
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="mb-3">
                                                    <label for="start_date">
                                                        <i class="fas fa-play"></i>
                                                        Fecha de Inicio 
                                                        <span class="text-danger font-weight-bold">*</span>
                                                    </label>
                                                    <input type="datetime-local" 
                                                           class="form-control @error('start_date') is-invalid @enderror" 
                                                           id="start_date" 
                                                           name="start_date" 
                                                           value="{{ old('start_date') }}" 
                                                           required>
                                                    @error('start_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6">
                                                <div class="mb-3">
                                                    <label for="end_date">
                                                        <i class="fas fa-stop"></i>
                                                        Fecha de Fin
                                                    </label>
                                                    <input type="datetime-local" 
                                                           class="form-control @error('end_date') is-invalid @enderror" 
                                                           id="end_date" 
                                                           name="end_date" 
                                                           value="{{ old('end_date') }}">
                                                    @error('end_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6">
                                                <div class="mb-3">
                                                    <label for="location">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        Ubicación
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control @error('location') is-invalid @enderror" 
                                                           id="location" 
                                                           name="location" 
                                                           value="{{ old('location') }}" 
                                                           placeholder="Ej: Centro Comunitario">
                                                    @error('location')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6">
                                                <div class="mb-3">
                                                    <label for="cost">
                                                        <i class="fas fa-coins"></i>
                                                        Costo (Q)
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Q</span>
                                                        </div>
                                                        <input type="number" 
                                                               class="form-control @error('cost') is-invalid @enderror" 
                                                               id="cost" 
                                                               name="cost" 
                                                               value="{{ old('cost', 0) }}" 
                                                               step="0.01" 
                                                               min="0">
                                                    </div>
                                                    @error('cost')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="address">
                                                        <i class="fas fa-map"></i>
                                                        Dirección Completa
                                                    </label>
                                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                                              id="address" 
                                                              name="address" 
                                                              rows="2" 
                                                              placeholder="Dirección completa del evento">{{ old('address') }}</textarea>
                                                    @error('address')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Panel Lateral -->
                            <div class="col-12 col-lg-4">
                                <!-- Participantes -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <i class="fas fa-users"></i>
                                            Participantes
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="max_participants">
                                                <i class="fas fa-user-plus"></i>
                                                Máximo de Participantes
                                            </label>
                                            <input type="number" 
                                                   class="form-control @error('max_participants') is-invalid @enderror" 
                                                   id="max_participants" 
                                                   name="max_participants" 
                                                   value="{{ old('max_participants') }}" 
                                                   min="1">
                                            @error('max_participants')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       id="registration_required" 
                                                       name="registration_required" 
                                                       value="1" 
                                                       {{ old('registration_required') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="registration_required">
                                                    Requiere Registro
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3" id="registration_deadline_group" style="display: none;">
                                            <label for="registration_deadline">
                                                <i class="fas fa-clock"></i>
                                                Fecha Límite de Registro
                                            </label>
                                            <input type="datetime-local" 
                                                   class="form-control @error('registration_deadline') is-invalid @enderror" 
                                                   id="registration_deadline" 
                                                   name="registration_deadline" 
                                                   value="{{ old('registration_deadline') }}">
                                            @error('registration_deadline')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Proyecto Asociado -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <i class="fas fa-project-diagram"></i>
                                            Proyecto Asociado
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="project_id">
                                                <i class="fas fa-folder"></i>
                                                Proyecto
                                            </label>
                                            <select class="form-control @error('project_id') is-invalid @enderror" 
                                                    id="project_id" 
                                                    name="project_id">
                                                <option value="">Sin proyecto asociado</option>
                                                @foreach($projects as $project)
                                                    <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                        {{ $project->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('project_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Configuración Adicional -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <i class="fas fa-cog"></i>
                                            Configuración
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       id="featured" 
                                                       name="featured" 
                                                       value="1" 
                                                       {{ old('featured') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="featured">
                                                    Evento Destacado
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="image">
                                                <i class="fas fa-image"></i>
                                                Imagen del Evento
                                            </label>
                                            <input type="file" 
                                                   class="form-control-file @error('image') is-invalid @enderror" 
                                                   id="image" 
                                                   name="image" 
                                                   accept="image/*">
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Formatos: JPG, PNG, GIF, SVG. Máximo 2MB.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información de Contacto -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <i class="fas fa-phone"></i>
                                            Información de Contacto
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="mb-3">
                                                    <label for="contact_email">
                                                        <i class="fas fa-envelope"></i>
                                                        Email de Contacto
                                                    </label>
                                                    <input type="email" 
                                                           class="form-control @error('contact_email') is-invalid @enderror" 
                                                           id="contact_email" 
                                                           name="contact_email" 
                                                           value="{{ old('contact_email') }}" 
                                                           placeholder="contacto@ong.com">
                                                    @error('contact_email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6">
                                                <div class="mb-3">
                                                    <label for="contact_phone">
                                                        <i class="fas fa-phone"></i>
                                                        Teléfono de Contacto
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control @error('contact_phone') is-invalid @enderror" 
                                                           id="contact_phone" 
                                                           name="contact_phone" 
                                                           value="{{ old('contact_phone') }}" 
                                                           placeholder="+502 1234-5678">
                                                    @error('contact_phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="requirements">
                                                        <i class="fas fa-list-check"></i>
                                                        Requisitos
                                                    </label>
                                                    <textarea class="form-control @error('requirements') is-invalid @enderror" 
                                                              id="requirements" 
                                                              name="requirements" 
                                                              rows="3" 
                                                              placeholder="Requisitos para participar en el evento">{{ old('requirements') }}</textarea>
                                                    @error('requirements')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información sobre Campos Requeridos -->
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info alert-dismissible" role="alert">
                                    <div class="d-flex">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 9v2m0 4v.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h6><i class="fas fa-info-circle me-1"></i> Información Importante:</h6>
                                            <ul class="mb-0">
                                                <li>Los campos marcados con <span class="text-danger fw-bold">*</span> son obligatorios</li>
                                                <li>Si hay errores de validación, se mostrará una alerta con los detalles</li>
                                                <li>La fecha de fin debe ser posterior a la fecha de inicio</li>
                                                <li>La fecha límite de registro debe ser anterior a la fecha de inicio del evento</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <a href="{{ route('admin.events-admin.index') }}" class="btn btn-outline-secondary me-2 custom">
                                            <i class="fas fa-arrow-left me-1"></i>
                                            Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary custom">
                                            <i class="fas fa-save me-1"></i>
                                            Crear Evento
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Las alertas de errores se muestran automáticamente
    
    // Manejar campo de registro requerido
    const registrationRequired = document.getElementById('registration_required');
    const registrationDeadlineGroup = document.getElementById('registration_deadline_group');
    
    registrationRequired.addEventListener('change', function() {
        if (this.checked) {
            registrationDeadlineGroup.style.display = 'block';
        } else {
            registrationDeadlineGroup.style.display = 'none';
        }
    });
    
    // Mostrar el campo si ya está marcado
    if (registrationRequired.checked) {
        registrationDeadlineGroup.style.display = 'block';
    }
    
    // Validación en tiempo real para fechas
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const registrationDeadlineInput = document.getElementById('registration_deadline');
    
    function validateDates() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        const registrationDeadline = new Date(registrationDeadlineInput.value);
        
        // Validar fecha de fin
        if (endDateInput.value && endDate <= startDate) {
            endDateInput.setCustomValidity('La fecha de fin debe ser posterior a la fecha de inicio');
        } else {
            endDateInput.setCustomValidity('');
        }
        
        // Validar fecha límite de registro
        if (registrationDeadlineInput.value && registrationDeadline >= startDate) {
            registrationDeadlineInput.setCustomValidity('La fecha límite de registro debe ser anterior a la fecha de inicio');
        } else {
            registrationDeadlineInput.setCustomValidity('');
        }
    }
    
    startDateInput.addEventListener('change', validateDates);
    endDateInput.addEventListener('change', validateDates);
    registrationDeadlineInput.addEventListener('change', validateDates);
});
</script>
@endsection

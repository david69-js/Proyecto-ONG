@extends('layouts.app')

@section('title', 'Editar Evento')

@section('header', 'Editar Evento')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Editar Evento: {{ $event->title }}
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Modal de Errores -->
                        @if($errors->any())
                            <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="errorModalLabel">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                Errores de Validación
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-danger">
                                                <h6><i class="fas fa-info-circle"></i> Por favor corrige los siguientes errores:</h6>
                                                <ul class="mb-0">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                <i class="fas fa-times"></i>
                                                Cerrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
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
                                                <div class="form-group">
                                                    <label for="title">
                                                        <i class="fas fa-heading"></i>
                                                        Título del Evento 
                                                        <span class="text-danger font-weight-bold">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control @error('title') is-invalid @enderror" 
                                                           id="title" 
                                                           name="title" 
                                                           value="{{ old('title', $event->title) }}" 
                                                           required>
                                                    @error('title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="description">
                                                        <i class="fas fa-align-left"></i>
                                                        Descripción
                                                    </label>
                                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                                              id="description" 
                                                              name="description" 
                                                              rows="4">{{ old('description', $event->description) }}</textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
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
                                                            <option value="{{ $key }}" {{ old('event_type', $event->event_type) == $key ? 'selected' : '' }}>
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
                                                <div class="form-group">
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
                                                            <option value="{{ $key }}" {{ old('status', $event->status) == $key ? 'selected' : '' }}>
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
                                                <div class="form-group">
                                                    <label for="start_date">
                                                        <i class="fas fa-play"></i>
                                                        Fecha de Inicio 
                                                        <span class="text-danger font-weight-bold">*</span>
                                                    </label>
                                                    <input type="datetime-local" 
                                                           class="form-control @error('start_date') is-invalid @enderror" 
                                                           id="start_date" 
                                                           name="start_date" 
                                                           value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" 
                                                           required>
                                                    @error('start_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="end_date">
                                                        <i class="fas fa-stop"></i>
                                                        Fecha de Fin
                                                    </label>
                                                    <input type="datetime-local" 
                                                           class="form-control @error('end_date') is-invalid @enderror" 
                                                           id="end_date" 
                                                           name="end_date" 
                                                           value="{{ old('end_date', $event->end_date ? $event->end_date->format('Y-m-d\TH:i') : '') }}">
                                                    @error('end_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="location">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        Ubicación
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control @error('location') is-invalid @enderror" 
                                                           id="location" 
                                                           name="location" 
                                                           value="{{ old('location', $event->location) }}" 
                                                           placeholder="Ej: Centro Comunitario">
                                                    @error('location')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
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
                                                               value="{{ old('cost', $event->cost) }}" 
                                                               step="0.01" 
                                                               min="0">
                                                    </div>
                                                    @error('cost')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="address">
                                                        <i class="fas fa-map"></i>
                                                        Dirección Completa
                                                    </label>
                                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                                              id="address" 
                                                              name="address" 
                                                              rows="2" 
                                                              placeholder="Dirección completa del evento">{{ old('address', $event->address) }}</textarea>
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
                                        <div class="form-group">
                                            <label for="max_participants">
                                                <i class="fas fa-user-plus"></i>
                                                Máximo de Participantes
                                            </label>
                                            <input type="number" 
                                                   class="form-control @error('max_participants') is-invalid @enderror" 
                                                   id="max_participants" 
                                                   name="max_participants" 
                                                   value="{{ old('max_participants', $event->max_participants) }}" 
                                                   min="1">
                                            @error('max_participants')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       id="registration_required" 
                                                       name="registration_required" 
                                                       value="1" 
                                                       {{ old('registration_required', $event->registration_required) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="registration_required">
                                                    Requiere Registro
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" id="registration_deadline_group" style="display: {{ old('registration_required', $event->registration_required) ? 'block' : 'none' }};">
                                            <label for="registration_deadline">
                                                <i class="fas fa-clock"></i>
                                                Fecha Límite de Registro
                                            </label>
                                            <input type="datetime-local" 
                                                   class="form-control @error('registration_deadline') is-invalid @enderror" 
                                                   id="registration_deadline" 
                                                   name="registration_deadline" 
                                                   value="{{ old('registration_deadline', $event->registration_deadline ? $event->registration_deadline->format('Y-m-d\TH:i') : '') }}">
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
                                        <div class="form-group">
                                            <label for="project_id">
                                                <i class="fas fa-folder"></i>
                                                Proyecto
                                            </label>
                                            <select class="form-control @error('project_id') is-invalid @enderror" 
                                                    id="project_id" 
                                                    name="project_id">
                                                <option value="">Sin proyecto asociado</option>
                                                @foreach($projects as $project)
                                                    <option value="{{ $project->id }}" {{ old('project_id', $event->project_id) == $project->id ? 'selected' : '' }}>
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
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       id="featured" 
                                                       name="featured" 
                                                       value="1" 
                                                       {{ old('featured', $event->featured) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="featured">
                                                    Evento Destacado
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="image">
                                                <i class="fas fa-image"></i>
                                                Imagen del Evento
                                            </label>
                                            @if($event->image_path)
                                                <div class="mb-2">
                                                    <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="img-fluid rounded" style="max-height: 100px;">
                                                    <small class="text-muted d-block">Imagen actual</small>
                                                </div>
                                            @endif
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
                                                <div class="form-group">
                                                    <label for="contact_email">
                                                        <i class="fas fa-envelope"></i>
                                                        Email de Contacto
                                                    </label>
                                                    <input type="email" 
                                                           class="form-control @error('contact_email') is-invalid @enderror" 
                                                           id="contact_email" 
                                                           name="contact_email" 
                                                           value="{{ old('contact_email', $event->contact_email) }}" 
                                                           placeholder="contacto@ong.com">
                                                    @error('contact_email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="contact_phone">
                                                        <i class="fas fa-phone"></i>
                                                        Teléfono de Contacto
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control @error('contact_phone') is-invalid @enderror" 
                                                           id="contact_phone" 
                                                           name="contact_phone" 
                                                           value="{{ old('contact_phone', $event->contact_phone) }}" 
                                                           placeholder="+502 1234-5678">
                                                    @error('contact_phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="requirements">
                                                        <i class="fas fa-list-check"></i>
                                                        Requisitos
                                                    </label>
                                                    <textarea class="form-control @error('requirements') is-invalid @enderror" 
                                                              id="requirements" 
                                                              name="requirements" 
                                                              rows="3" 
                                                              placeholder="Requisitos para participar en el evento">{{ old('requirements', $event->requirements) }}</textarea>
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
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle"></i> Información Importante:</h6>
                                    <ul class="mb-0">
                                        <li>Los campos marcados con <span class="text-danger font-weight-bold">*</span> son obligatorios</li>
                                        <li>Si hay errores de validación, se mostrará un modal con los detalles</li>
                                        <li>La fecha de fin debe ser posterior a la fecha de inicio</li>
                                        <li>La fecha límite de registro debe ser anterior a la fecha de inicio del evento</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <a href="{{ route('events.show', $event) }}" class="btn btn-secondary mr-2">
                                            <i class="fas fa-eye"></i>
                                            Ver Evento
                                        </a>
                                        <a href="{{ route('events.index') }}" class="btn btn-outline-secondary mr-2">
                                            <i class="fas fa-arrow-left"></i>
                                            Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i>
                                            Actualizar Evento
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
    // Mostrar modal de errores automáticamente si hay errores
    const errorModal = document.getElementById('errorModal');
    if (errorModal) {
        $(errorModal).modal('show');
    }
    
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

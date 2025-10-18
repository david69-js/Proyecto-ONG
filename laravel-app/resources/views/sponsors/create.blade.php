@extends('layouts.app')

@section('title', 'Crear Patrocinador')

@section('header', 'Crear Patrocinador')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-plus"></i> Crear Nuevo Patrocinador
                </h3>
                <div class="card-tools">
                    <a href="{{ route('sponsors.index') }}" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Corrige los siguientes errores:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form action="{{ route('sponsors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- Información Básica -->
                    <div class="col-12 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user"></i> Información Básica
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">
                                                <i class="fas fa-user"></i> Nombre *
                                            </label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="company_name">
                                                <i class="fas fa-building"></i> Empresa
                                            </label>
                                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                                   id="company_name" name="company_name" value="{{ old('company_name') }}">
                                            @error('company_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="contact_person">
                                                <i class="fas fa-user-tie"></i> Persona de Contacto
                                            </label>
                                            <input type="text" class="form-control @error('contact_person') is-invalid @enderror" 
                                                   id="contact_person" name="contact_person" value="{{ old('contact_person') }}">
                                            @error('contact_person')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="email">
                                                <i class="fas fa-envelope"></i> Email *
                                            </label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="phone">
                                                <i class="fas fa-phone"></i> Teléfono
                                            </label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" name="phone" value="{{ old('phone') }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="website">
                                                <i class="fas fa-globe"></i> Sitio Web
                                            </label>
                                            <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                                   id="website" name="website" value="{{ old('website') }}">
                                            @error('website')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address">
                                        <i class="fas fa-map-marker-alt"></i> Dirección
                                    </label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              id="address" name="address" rows="3" placeholder="Dirección completa...">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Información de Patrocinio -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-handshake"></i> Información de Patrocinio
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="sponsor_type">
                                                <i class="fas fa-tag"></i> Tipo de Patrocinador *
                                            </label>
                                            <select class="form-control @error('sponsor_type') is-invalid @enderror" 
                                                    id="sponsor_type" name="sponsor_type" required>
                                                <option value="">Seleccionar tipo</option>
                                                <option value="individual" {{ old('sponsor_type') == 'individual' ? 'selected' : '' }}>Individual</option>
                                                <option value="corporate" {{ old('sponsor_type') == 'corporate' ? 'selected' : '' }}>Corporativo</option>
                                                <option value="foundation" {{ old('sponsor_type') == 'foundation' ? 'selected' : '' }}>Fundación</option>
                                                <option value="ngo" {{ old('sponsor_type') == 'ngo' ? 'selected' : '' }}>ONG</option>
                                                <option value="government" {{ old('sponsor_type') == 'government' ? 'selected' : '' }}>Gobierno</option>
                                                <option value="international" {{ old('sponsor_type') == 'international' ? 'selected' : '' }}>Internacional</option>
                                            </select>
                                            @error('sponsor_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="contribution_type">
                                                <i class="fas fa-gift"></i> Tipo de Contribución *
                                            </label>
                                            <select class="form-control @error('contribution_type') is-invalid @enderror" 
                                                    id="contribution_type" name="contribution_type" required>
                                                <option value="">Seleccionar tipo</option>
                                                <option value="monetary" {{ old('contribution_type') == 'monetary' ? 'selected' : '' }}>Monetaria</option>
                                                <option value="materials" {{ old('contribution_type') == 'materials' ? 'selected' : '' }}>Materiales</option>
                                                <option value="services" {{ old('contribution_type') == 'services' ? 'selected' : '' }}>Servicios</option>
                                                <option value="volunteer" {{ old('contribution_type') == 'volunteer' ? 'selected' : '' }}>Voluntariado</option>
                                                <option value="mixed" {{ old('contribution_type') == 'mixed' ? 'selected' : '' }}>Mixta</option>
                                            </select>
                                            @error('contribution_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="contribution_amount">
                                                <i class="fas fa-coins"></i> Monto de Contribución
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Q</span>
                                                </div>
                                                <input type="number" step="0.01" class="form-control @error('contribution_amount') is-invalid @enderror" 
                                                       id="contribution_amount" name="contribution_amount" value="{{ old('contribution_amount') }}"
                                                       placeholder="0.00">
                                            </div>
                                            @error('contribution_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="priority_level">
                                                <i class="fas fa-star"></i> Nivel de Prioridad *
                                            </label>
                                            <select class="form-control @error('priority_level') is-invalid @enderror" 
                                                    id="priority_level" name="priority_level" required>
                                                @for($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}" {{ old('priority_level', 5) == $i ? 'selected' : '' }}>
                                                        {{ $i }} {{ $i == 10 ? '(Máxima)' : ($i == 1 ? '(Mínima)' : '') }}
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('priority_level')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="contribution_description">
                                        <i class="fas fa-align-left"></i> Descripción de la Contribución
                                    </label>
                                    <textarea class="form-control @error('contribution_description') is-invalid @enderror" 
                                              id="contribution_description" name="contribution_description" rows="3"
                                              placeholder="Describe los detalles de la contribución...">{{ old('contribution_description') }}</textarea>
                                    @error('contribution_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Proyectos Asociados -->
                        @if($projects->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-project-diagram"></i> Proyectos Asociados
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-check-square"></i> Seleccionar Proyectos
                                    </label>
                                    <div class="row">
                                        @foreach($projects as $project)
                                        <div class="col-12 col-md-6 mb-3">
                                            <div class="card border">
                                                <div class="card-body p-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input project-checkbox" type="checkbox" 
                                                               name="projects[]" value="{{ $project->id }}" 
                                                               id="project_{{ $project->id }}"
                                                               {{ in_array($project->id, old('projects', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label w-100" for="project_{{ $project->id }}">
                                                            <div class="d-flex align-items-start">
                                                                <div class="flex-grow-1">
                                                                    <strong class="d-block">{{ $project->nombre }}</strong>
                                                                    <small class="text-muted">{{ Str::limit($project->descripcion, 100) }}</small>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    
                                                    <div class="project-details mt-3" style="display: none;">
                                                        <hr class="my-2">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-6 mb-2">
                                                                <label class="small text-muted">Monto específico</label>
                                                                <input type="number" step="0.01" class="form-control form-control-sm" 
                                                                       name="project_amount_{{ $project->id }}" 
                                                                       placeholder="0.00">
                                                            </div>
                                                            <div class="col-12 col-sm-6 mb-2">
                                                                <label class="small text-muted">Tipo de contribución</label>
                                                                <select class="form-control form-control-sm" 
                                                                        name="project_contribution_type_{{ $project->id }}">
                                                                    <option value="monetary">Monetaria</option>
                                                                    <option value="materials">Materiales</option>
                                                                    <option value="services">Servicios</option>
                                                                    <option value="volunteer">Voluntariado</option>
                                                                    <option value="mixed">Mixta</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Panel Lateral -->
                    <div class="col-12 col-lg-4">
                        <!-- Logo -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-image"></i> Logo
                                </h3>
                            </div>
                            <div class="card-body text-center">
                                <div class="form-group">
                                    <label for="logo">
                                        <i class="fas fa-upload"></i> Subir Logo
                                    </label>
                                    <input type="file" class="form-control-file @error('logo') is-invalid @enderror" 
                                           id="logo" name="logo" accept="image/*">
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> Formatos: JPG, PNG, GIF, SVG. Máximo 2MB.
                                    </small>
                                </div>
                                <div id="logo-preview" class="mt-3" style="display: none;">
                                    <img id="preview-img" src="" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                                </div>
                            </div>
                        </div>

                        <!-- Estado y Configuración -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-cog"></i> Estado y Configuración
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="status">
                                        <i class="fas fa-toggle-on"></i> Estado *
                                    </label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspendido</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                               value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            <i class="fas fa-star"></i> Patrocinador Destacado
                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="partnership_start_date">
                                                <i class="fas fa-calendar-plus"></i> Fecha de Inicio
                                            </label>
                                            <input type="date" class="form-control @error('partnership_start_date') is-invalid @enderror" 
                                                   id="partnership_start_date" name="partnership_start_date" 
                                                   value="{{ old('partnership_start_date') }}">
                                            @error('partnership_start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="partnership_end_date">
                                                <i class="fas fa-calendar-minus"></i> Fecha de Fin
                                            </label>
                                            <input type="date" class="form-control @error('partnership_end_date') is-invalid @enderror" 
                                                   id="partnership_end_date" name="partnership_end_date" 
                                                   value="{{ old('partnership_end_date') }}">
                                            @error('partnership_end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Descripción y Notas -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-sticky-note"></i> Descripción y Notas
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="description">
                                        <i class="fas fa-align-left"></i> Descripción
                                    </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4" 
                                              placeholder="Descripción del patrocinador...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="notes">
                                        <i class="fas fa-clipboard"></i> Notas Internas
                                    </label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="3" 
                                              placeholder="Notas internas sobre el patrocinador...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-6 mb-2 mb-sm-0">
                                        <a href="{{ route('sponsors.index') }}" class="btn btn-secondary btn-block">
                                            <i class="fas fa-arrow-left"></i> 
                                            <span class="d-none d-sm-inline">Cancelar</span>
                                        </a>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-save"></i> 
                                            <span class="d-none d-sm-inline">Crear Patrocinador</span>
                                            <span class="d-sm-none">Crear</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview de logo
    const logoInput = document.getElementById('logo');
    const logoPreview = document.getElementById('logo-preview');
    const previewImg = document.getElementById('preview-img');

    logoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                logoPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            logoPreview.style.display = 'none';
        }
    });

    // Mostrar/ocultar detalles de proyectos
    const projectCheckboxes = document.querySelectorAll('.project-checkbox');
    projectCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const projectDetails = this.closest('.col-md-6').querySelector('.project-details');
            if (this.checked) {
                projectDetails.style.display = 'block';
            } else {
                projectDetails.style.display = 'none';
            }
        });
    });
});
</script>
@endpush
@endsection

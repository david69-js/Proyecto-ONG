@extends('layouts.app')

@section('title', 'Editar Patrocinador')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar Patrocinador</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sponsors.index') }}">Patrocinadores</a></li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
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
            <form action="{{ route('sponsors.update', $sponsor) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Información Básica -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Información Básica</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nombre *</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $sponsor->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_name">Empresa</label>
                                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                                   id="company_name" name="company_name" value="{{ old('company_name', $sponsor->company_name) }}">
                                            @error('company_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_person">Persona de Contacto</label>
                                            <input type="text" class="form-control @error('contact_person') is-invalid @enderror" 
                                                   id="contact_person" name="contact_person" value="{{ old('contact_person', $sponsor->contact_person) }}">
                                            @error('contact_person')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email *</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email', $sponsor->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Teléfono</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" name="phone" value="{{ old('phone', $sponsor->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="website">Sitio Web</label>
                                            <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                                   id="website" name="website" value="{{ old('website', $sponsor->website) }}">
                                            @error('website')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address">Dirección</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              id="address" name="address" rows="3">{{ old('address', $sponsor->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Información de Patrocinio -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Información de Patrocinio</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sponsor_type">Tipo de Patrocinador *</label>
                                            <select class="form-control @error('sponsor_type') is-invalid @enderror" 
                                                    id="sponsor_type" name="sponsor_type" required>
                                                <option value="">Seleccionar tipo</option>
                                                <option value="individual" {{ old('sponsor_type', $sponsor->sponsor_type) == 'individual' ? 'selected' : '' }}>Individual</option>
                                                <option value="corporate" {{ old('sponsor_type', $sponsor->sponsor_type) == 'corporate' ? 'selected' : '' }}>Corporativo</option>
                                                <option value="foundation" {{ old('sponsor_type', $sponsor->sponsor_type) == 'foundation' ? 'selected' : '' }}>Fundación</option>
                                                <option value="ngo" {{ old('sponsor_type', $sponsor->sponsor_type) == 'ngo' ? 'selected' : '' }}>ONG</option>
                                                <option value="government" {{ old('sponsor_type', $sponsor->sponsor_type) == 'government' ? 'selected' : '' }}>Gobierno</option>
                                                <option value="international" {{ old('sponsor_type', $sponsor->sponsor_type) == 'international' ? 'selected' : '' }}>Internacional</option>
                                            </select>
                                            @error('sponsor_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contribution_type">Tipo de Contribución *</label>
                                            <select class="form-control @error('contribution_type') is-invalid @enderror" 
                                                    id="contribution_type" name="contribution_type" required>
                                                <option value="">Seleccionar tipo</option>
                                                <option value="monetary" {{ old('contribution_type', $sponsor->contribution_type) == 'monetary' ? 'selected' : '' }}>Monetaria</option>
                                                <option value="materials" {{ old('contribution_type', $sponsor->contribution_type) == 'materials' ? 'selected' : '' }}>Materiales</option>
                                                <option value="services" {{ old('contribution_type', $sponsor->contribution_type) == 'services' ? 'selected' : '' }}>Servicios</option>
                                                <option value="volunteer" {{ old('contribution_type', $sponsor->contribution_type) == 'volunteer' ? 'selected' : '' }}>Voluntariado</option>
                                                <option value="mixed" {{ old('contribution_type', $sponsor->contribution_type) == 'mixed' ? 'selected' : '' }}>Mixta</option>
                                            </select>
                                            @error('contribution_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contribution_amount">Monto de Contribución</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Q</span>
                                                </div>
                                                <input type="number" step="0.01" class="form-control @error('contribution_amount') is-invalid @enderror" 
                                                       id="contribution_amount" name="contribution_amount" value="{{ old('contribution_amount', $sponsor->contribution_amount) }}">
                                            </div>
                                            @error('contribution_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="priority_level">Nivel de Prioridad *</label>
                                            <select class="form-control @error('priority_level') is-invalid @enderror" 
                                                    id="priority_level" name="priority_level" required>
                                                @for($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}" {{ old('priority_level', $sponsor->priority_level) == $i ? 'selected' : '' }}>
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
                                    <label for="contribution_description">Descripción de la Contribución</label>
                                    <textarea class="form-control @error('contribution_description') is-invalid @enderror" 
                                              id="contribution_description" name="contribution_description" rows="3">{{ old('contribution_description', $sponsor->contribution_description) }}</textarea>
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
                                <h3 class="card-title">Proyectos Asociados</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Seleccionar Proyectos</label>
                                    <div class="row">
                                        @foreach($projects as $project)
                                        @php
                                            $isSelected = in_array($project->id, old('projects', $sponsor->projects->pluck('id')->toArray()));
                                            $projectPivot = $sponsor->projects->where('id', $project->id)->first();
                                        @endphp
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input project-checkbox" type="checkbox" 
                                                       name="projects[]" value="{{ $project->id }}" 
                                                       id="project_{{ $project->id }}"
                                                       {{ $isSelected ? 'checked' : '' }}>
                                                <label class="form-check-label" for="project_{{ $project->id }}">
                                                    <strong>{{ $project->nombre }}</strong>
                                                    <br><small class="text-muted">{{ $project->descripcion }}</small>
                                                </label>
                                            </div>
                                            
                                            <div class="project-details mt-2" style="{{ $isSelected ? 'display: block;' : 'display: none;' }}">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="number" step="0.01" class="form-control form-control-sm" 
                                                               name="project_amount_{{ $project->id }}" 
                                                               value="{{ old("project_amount_{$project->id}", $projectPivot ? $projectPivot->pivot->contribution_amount : '') }}"
                                                               placeholder="Monto específico">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-control form-control-sm" 
                                                                name="project_contribution_type_{{ $project->id }}">
                                                            <option value="monetary" {{ old("project_contribution_type_{$project->id}", $projectPivot ? $projectPivot->pivot->contribution_type : 'monetary') == 'monetary' ? 'selected' : '' }}>Monetaria</option>
                                                            <option value="materials" {{ old("project_contribution_type_{$project->id}", $projectPivot ? $projectPivot->pivot->contribution_type : '') == 'materials' ? 'selected' : '' }}>Materiales</option>
                                                            <option value="services" {{ old("project_contribution_type_{$project->id}", $projectPivot ? $projectPivot->pivot->contribution_type : '') == 'services' ? 'selected' : '' }}>Servicios</option>
                                                            <option value="volunteer" {{ old("project_contribution_type_{$project->id}", $projectPivot ? $projectPivot->pivot->contribution_type : '') == 'volunteer' ? 'selected' : '' }}>Voluntariado</option>
                                                            <option value="mixed" {{ old("project_contribution_type_{$project->id}", $projectPivot ? $projectPivot->pivot->contribution_type : '') == 'mixed' ? 'selected' : '' }}>Mixta</option>
                                                        </select>
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
                    <div class="col-md-4">
                        <!-- Logo -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Logo</h3>
                            </div>
                            <div class="card-body text-center">
                                @if($sponsor->logo_path)
                                <div class="mb-3">
                                    <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }}" 
                                         class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                                @endif
                                
                                <div class="form-group">
                                    <label for="logo">Cambiar Logo</label>
                                    <input type="file" class="form-control-file @error('logo') is-invalid @enderror" 
                                           id="logo" name="logo" accept="image/*">
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Formatos: JPG, PNG, GIF, SVG. Máximo 2MB.
                                    </small>
                                </div>
                                <div id="logo-preview" class="mt-3" style="display: none;">
                                    <img id="preview-img" src="" alt="Preview" class="img-fluid" style="max-height: 150px;">
                                </div>
                            </div>
                        </div>

                        <!-- Estado y Configuración -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Estado y Configuración</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="status">Estado *</label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="active" {{ old('status', $sponsor->status) == 'active' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactive" {{ old('status', $sponsor->status) == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                        <option value="pending" {{ old('status', $sponsor->status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="suspended" {{ old('status', $sponsor->status) == 'suspended' ? 'selected' : '' }}>Suspendido</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                               value="1" {{ old('is_featured', $sponsor->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Patrocinador Destacado
                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="partnership_start_date">Fecha de Inicio</label>
                                            <input type="date" class="form-control @error('partnership_start_date') is-invalid @enderror" 
                                                   id="partnership_start_date" name="partnership_start_date" 
                                                   value="{{ old('partnership_start_date', $sponsor->partnership_start_date ? $sponsor->partnership_start_date->format('Y-m-d') : '') }}">
                                            @error('partnership_start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="partnership_end_date">Fecha de Fin</label>
                                            <input type="date" class="form-control @error('partnership_end_date') is-invalid @enderror" 
                                                   id="partnership_end_date" name="partnership_end_date" 
                                                   value="{{ old('partnership_end_date', $sponsor->partnership_end_date ? $sponsor->partnership_end_date->format('Y-m-d') : '') }}">
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
                                <h3 class="card-title">Descripción y Notas</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="description">Descripción</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4">{{ old('description', $sponsor->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="notes">Notas Internas</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="3">{{ old('notes', $sponsor->notes) }}</textarea>
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
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('sponsors.show', $sponsor) }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Actualizar Patrocinador
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
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

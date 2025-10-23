@extends('layouts.tabler')

@section('page-title', 'Editar Beneficiario')
@section('page-description', 'Modificar información del beneficiario')

@section('title', 'Editar Beneficiario')
@section('header', 'Editar Beneficiario')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Card principal -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-edit mr-2"></i>
                        Editar Beneficiario: {{ $beneficiary->name }}
                    </h3>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <h5><i class="icon fas fa-ban"></i> ¡Error!</h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('beneficiaries.update', $beneficiary) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="row">
                            <!-- Información Personal -->
                            <div class="col-12 col-lg-8">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-user mr-2"></i>
                                            Información Personal
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">
                                                        <i class="fas fa-user text-primary mr-1"></i>
                                                        Nombre Completo *
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control @error('name') is-invalid @enderror" 
                                                           name="name" 
                                                           id="name"
                                                           value="{{ old('name', $beneficiary->name) }}" 
                                                           required
                                                           placeholder="Ingrese el nombre completo">
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="birth_date">
                                                        <i class="fas fa-calendar text-primary mr-1"></i>
                                                        Fecha de Nacimiento
                                                    </label>
                                                    <input type="date" 
                                                           class="form-control @error('birth_date') is-invalid @enderror" 
                                                           name="birth_date" 
                                                           id="birth_date"
                                                           value="{{ old('birth_date', $beneficiary->birth_date) }}">
                                                    @error('birth_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="gender">
                                                        <i class="fas fa-venus-mars text-primary mr-1"></i>
                                                        Género
                                                    </label>
                                                    <select name="gender" 
                                                            class="form-control @error('gender') is-invalid @enderror" 
                                                            id="gender">
                                                        <option value="">Seleccione un género</option>
                                                        <option value="Male" {{ old('gender', $beneficiary->gender) == 'Male' ? 'selected' : '' }}>Masculino</option>
                                                        <option value="Female" {{ old('gender', $beneficiary->gender) == 'Female' ? 'selected' : '' }}>Femenino</option>
                                                        <option value="Other" {{ old('gender', $beneficiary->gender) == 'Other' ? 'selected' : '' }}>Otro</option>
                                                    </select>
                                                    @error('gender')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="beneficiary_type">
                                                        <i class="fas fa-users text-primary mr-1"></i>
                                                        Tipo de Beneficiario *
                                                    </label>
                                                    <select name="beneficiary_type" 
                                                            class="form-control @error('beneficiary_type') is-invalid @enderror" 
                                                            id="beneficiary_type" 
                                                            required>
                                                        <option value="">Seleccione un tipo</option>
                                                        <option value="Person" {{ old('beneficiary_type', $beneficiary->beneficiary_type) == 'Person' ? 'selected' : '' }}>Persona</option>
                                                        <option value="Family" {{ old('beneficiary_type', $beneficiary->beneficiary_type) == 'Family' ? 'selected' : '' }}>Familia</option>
                                                        <option value="Community" {{ old('beneficiary_type', $beneficiary->beneficiary_type) == 'Community' ? 'selected' : '' }}>Comunidad</option>
                                                    </select>
                                                    @error('beneficiary_type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información de Contacto -->
                                <div class="card card-info card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-address-book mr-2"></i>
                                            Información de Contacto
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="address">
                                                        <i class="fas fa-map-marker-alt text-info mr-1"></i>
                                                        Dirección
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control @error('address') is-invalid @enderror" 
                                                           name="address" 
                                                           id="address"
                                                           value="{{ old('address', $beneficiary->address) }}"
                                                           placeholder="Ingrese la dirección completa">
                                                    @error('address')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="phone">
                                                        <i class="fas fa-phone text-info mr-1"></i>
                                                        Teléfono
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control @error('phone') is-invalid @enderror" 
                                                           name="phone" 
                                                           id="phone"
                                                           value="{{ old('phone', $beneficiary->phone) }}"
                                                           placeholder="Número de teléfono">
                                                    @error('phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="email">
                                                        <i class="fas fa-envelope text-info mr-1"></i>
                                                        Correo Electrónico
                                                    </label>
                                                    <input type="email" 
                                                           class="form-control @error('email') is-invalid @enderror" 
                                                           name="email" 
                                                           id="email"
                                                           value="{{ old('email', $beneficiary->email) }}"
                                                           placeholder="correo@ejemplo.com">
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="col-12 col-lg-4">
                                <!-- Estado y Asignación -->
                                <div class="card card-warning card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-cog mr-2"></i>
                                            Estado y Asignación
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="status">
                                                <i class="fas fa-toggle-on text-warning mr-1"></i>
                                                Estado *
                                            </label>
                                            <select name="status" 
                                                    class="form-control @error('status') is-invalid @enderror" 
                                                    id="status" 
                                                    required>
                                                <option value="">Seleccione un estado</option>
                                                <option value="Active" {{ old('status', $beneficiary->status) == 'Active' ? 'selected' : '' }}>Activo</option>
                                                <option value="Inactive" {{ old('status', $beneficiary->status) == 'Inactive' ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="project_id">
                                                <i class="fas fa-project-diagram text-warning mr-1"></i>
                                                Proyecto Asignado
                                            </label>
                                            <select name="project_id" 
                                                    class="form-control @error('project_id') is-invalid @enderror" 
                                                    id="project_id">
                                                <option value="">Sin proyecto asignado</option>
                                                @foreach($projects as $project)
                                                    <option value="{{ $project->id }}" 
                                                            {{ old('project_id', $beneficiary->project_id) == $project->id ? 'selected' : '' }}>
                                                        {{ $project->nombre }}
                                                        @if($project->estado)
                                                            <small class="text-muted">({{ ucfirst($project->estado) }})</small>
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('project_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Notas -->
                                <div class="card card-secondary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-sticky-note mr-2"></i>
                                            Notas Adicionales
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="notes">
                                                <i class="fas fa-comment text-secondary mr-1"></i>
                                                Observaciones
                                            </label>
                                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                      name="notes" 
                                                      id="notes" 
                                                      rows="4"
                                                      placeholder="Información adicional sobre el beneficiario...">{{ old('notes', $beneficiary->notes) }}</textarea>
                                            @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <button type="submit" class="btn btn-success btn-lg btn-block">
                                    <i class="fas fa-save mr-2"></i>
                                    Actualizar Beneficiario
                                </button>
                            </div>
                            <div class="col-12 col-md-6 mt-2 mt-md-0">
                                <a href="{{ route('beneficiaries.index') }}" class="btn btn-secondary btn-lg btn-block">
                                    <i class="fas fa-times mr-2"></i>
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Validación del formulario
    $('form').on('submit', function(e) {
        var isValid = true;
        
        // Validar campos requeridos
        $('input[required], select[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos requeridos.');
        }
    });
    
    // Limpiar validación al escribir
    $('input, select, textarea').on('input change', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@endpush
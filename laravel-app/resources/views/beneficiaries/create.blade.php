@extends('layouts.app')

@section('title', 'Crear Beneficiario')
@section('header', 'Crear Nuevo Beneficiario')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-plus"></i> Información del Beneficiario
                </h3>
                <div class="card-tools">
                    <a href="{{ route('beneficiaries.index') }}" class="btn btn-tool">
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

    <form action="{{ route('beneficiaries.store') }}" method="POST">
        @csrf
                    
                    <div class="row">
                        <!-- Información Personal -->
                        <div class="col-12 col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-user"></i> Información Personal
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">
                                                    <i class="fas fa-user"></i> Nombre Completo *
                                                </label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                       id="name" name="name" value="{{ old('name') }}" required
                                                       placeholder="Nombre completo del beneficiario">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="birth_date">
                                                    <i class="fas fa-calendar"></i> Fecha de Nacimiento
                                                </label>
                                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                                       id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                                                @error('birth_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="gender">
                                                    <i class="fas fa-venus-mars"></i> Género
                                                </label>
                                                <select class="form-control @error('gender') is-invalid @enderror" 
                                                        id="gender" name="gender">
                                                    <option value="">Seleccionar género</option>
                                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Masculino</option>
                                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Femenino</option>
                                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Otro</option>
                                                </select>
                                                @error('gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="beneficiary_type">
                                                    <i class="fas fa-tag"></i> Tipo de Beneficiario *
                                                </label>
                                                <select class="form-control @error('beneficiary_type') is-invalid @enderror" 
                                                        id="beneficiary_type" name="beneficiary_type" required>
                                                    <option value="">Seleccionar tipo</option>
                                                    <option value="Person" {{ old('beneficiary_type') == 'Person' ? 'selected' : '' }}>Persona</option>
                                                    <option value="Family" {{ old('beneficiary_type') == 'Family' ? 'selected' : '' }}>Familia</option>
                                                    <option value="Community" {{ old('beneficiary_type') == 'Community' ? 'selected' : '' }}>Comunidad</option>
                                                </select>
                                                @error('beneficiary_type')
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
                                                  id="address" name="address" rows="3" 
                                                  placeholder="Dirección completa del beneficiario">{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Información de Contacto -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-phone"></i> Información de Contacto
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="phone">
                                                    <i class="fas fa-phone"></i> Teléfono
                                                </label>
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                       id="phone" name="phone" value="{{ old('phone') }}"
                                                       placeholder="Número de teléfono">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="email">
                                                    <i class="fas fa-envelope"></i> Email
                                                </label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                       id="email" name="email" value="{{ old('email') }}"
                                                       placeholder="Correo electrónico">
                                                @error('email')
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
                            <!-- Estado y Proyecto -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-cog"></i> Estado y Asignación
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="status">
                                            <i class="fas fa-toggle-on"></i> Estado *
                                        </label>
                                        <select class="form-control @error('status') is-invalid @enderror" 
                                                id="status" name="status" required>
                                            <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Activo</option>
                                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactivo</option>
            </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
        </div>

                                    <div class="form-group">
                                        <label for="project_id">
                                            <i class="fas fa-project-diagram"></i> Proyecto Asignado
                                        </label>
                                        <select class="form-control @error('project_id') is-invalid @enderror" 
                                                id="project_id" name="project_id">
                                            <option value="">Sin asignar</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                    {{ $project->nombre }}
                                                </option>
                                            @endforeach
            </select>
                                        @error('project_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Selecciona el proyecto al que pertenece este beneficiario
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Notas -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-sticky-note"></i> Notas Adicionales
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="notes">
                                            <i class="fas fa-clipboard"></i> Notas
                                        </label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                  id="notes" name="notes" rows="4" 
                                                  placeholder="Información adicional sobre el beneficiario...">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>

                    <!-- Botones de Acción -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-2 mb-sm-0">
                                            <a href="{{ route('beneficiaries.index') }}" class="btn btn-secondary btn-block">
                                                <i class="fas fa-arrow-left"></i> 
                                                <span class="d-none d-sm-inline">Cancelar</span>
                                            </a>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <i class="fas fa-save"></i> 
                                                <span class="d-none d-sm-inline">Crear Beneficiario</span>
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
@endsection


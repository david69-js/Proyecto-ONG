@extends('layouts.tabler')

@section('title', 'Prueba Tabler')
@section('page-title', 'Prueba de Tabler')
@section('page-description', 'Página de prueba para verificar el funcionamiento del nuevo diseño')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">¡Tabler Implementado Correctamente!</h3>
                <div class="card-actions">
                    <span class="badge bg-success">Funcionando</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Características Implementadas:</h4>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Layout responsive</li>
                            <li><i class="fas fa-check text-success me-2"></i>Sidebar colapsible</li>
                            <li><i class="fas fa-check text-success me-2"></i>Navegación por roles</li>
                            <li><i class="fas fa-check text-success me-2"></i>Componentes modernos</li>
                            <li><i class="fas fa-check text-success me-2"></i>Alertas mejoradas</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4>Información del Usuario:</h4>
                        <div class="mb-3">
                            <strong>Nombre:</strong> {{ auth()->user()->full_name }}
                        </div>
                        <div class="mb-3">
                            <strong>Email:</strong> {{ auth()->user()->email }}
                        </div>
                        <div class="mb-3">
                            <strong>Roles:</strong>
                            @foreach(auth()->user()->roles as $role)
                                <span class="badge bg-primary me-1">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12">
                        <h4>Botones de Prueba:</h4>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Crear
                            </button>
                            <button type="button" class="btn btn-success">
                                <i class="fas fa-check me-1"></i>Confirmar
                            </button>
                            <button type="button" class="btn btn-warning">
                                <i class="fas fa-edit me-1"></i>Editar
                            </button>
                            <button type="button" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i>Eliminar
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12">
                        <h4>Alertas de Prueba:</h4>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>Esta es una alerta de éxito
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Esta es una alerta informativa
                        </div>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>Esta es una alerta de advertencia
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

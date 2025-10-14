@extends('layouts.app')

@section('title', 'Detalles del Beneficiario')
@section('header', 'Detalles del Beneficiario')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Card principal -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user mr-2"></i>
                        {{ $beneficiary->name }}
                    </h3>
                    <div class="card-tools">
                        @can('update', $beneficiary)
                        <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="btn btn-tool" data-toggle="tooltip" title="Editar beneficiario">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        <a href="{{ route('beneficiaries.index') }}" class="btn btn-tool" data-toggle="tooltip" title="Volver a la lista">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Información Principal -->
                        <div class="col-12 col-lg-8">
                            <!-- Información Personal -->
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
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="text-muted"><strong>Nombre Completo:</strong></td>
                                                    <td>{{ $beneficiary->name }}</td>
                                                </tr>
                                                @if($beneficiary->birth_date)
                                                <tr>
                                                    <td class="text-muted"><strong>Fecha de Nacimiento:</strong></td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($beneficiary->birth_date)->format('d/m/Y') }}
                                                        <small class="text-muted">
                                                            ({{ \Carbon\Carbon::parse($beneficiary->birth_date)->age }} años)
                                                        </small>
                                                    </td>
                                                </tr>
                                                @endif
                                                @if($beneficiary->gender)
                                                <tr>
                                                    <td class="text-muted"><strong>Género:</strong></td>
                                                    <td>{{ $beneficiary->gender_formatted }}</td>
                                                </tr>
                                                @endif
                                            </table>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="text-muted"><strong>Tipo:</strong></td>
                                                    <td>
                                                        <span class="badge badge-info">
                                                            {{ $beneficiary->beneficiary_type_formatted }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted"><strong>Estado:</strong></td>
                                                    <td>
                                                        <span class="badge badge-{{ $beneficiary->status === 'Active' ? 'success' : 'secondary' }}">
                                                            {{ $beneficiary->status_formatted }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @if($beneficiary->project)
                                                <tr>
                                                    <td class="text-muted"><strong>Proyecto Asignado:</strong></td>
                                                    <td>
                                                        <span class="badge badge-primary">
                                                            {{ $beneficiary->project->nombre }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información de Contacto -->
                            @if($beneficiary->address || $beneficiary->phone || $beneficiary->email)
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-address-book mr-2"></i>
                                        Información de Contacto
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if($beneficiary->address)
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <strong class="text-info">
                                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                                    Dirección:
                                                </strong>
                                                <p class="text-muted mb-0">{{ $beneficiary->address }}</p>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="col-12 col-md-6">
                                            @if($beneficiary->phone)
                                            <div class="mb-3">
                                                <strong class="text-info">
                                                    <i class="fas fa-phone mr-1"></i>
                                                    Teléfono:
                                                </strong>
                                                <p class="mb-0">
                                                    <a href="tel:{{ $beneficiary->phone }}" class="text-decoration-none">
                                                        {{ $beneficiary->phone }}
                                                    </a>
                                                </p>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="col-12 col-md-6">
                                            @if($beneficiary->email)
                                            <div class="mb-3">
                                                <strong class="text-info">
                                                    <i class="fas fa-envelope mr-1"></i>
                                                    Correo Electrónico:
                                                </strong>
                                                <p class="mb-0">
                                                    <a href="mailto:{{ $beneficiary->email }}" class="text-decoration-none">
                                                        {{ $beneficiary->email }}
                                                    </a>
                                                </p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Notas -->
                            @if($beneficiary->notes)
                            <div class="card card-secondary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-sticky-note mr-2"></i>
                                        Notas Adicionales
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-0">{{ $beneficiary->notes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Sidebar -->
                        <div class="col-12 col-lg-4">
                            <!-- Avatar/Información Visual -->
                            <div class="card card-warning card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-id-card mr-2"></i>
                                        Información Visual
                                    </h3>
                                </div>
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <div class="avatar-placeholder bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                                             style="width: 100px; height: 100px; font-size: 2rem;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-1">{{ $beneficiary->name }}</h5>
                                    <p class="text-muted mb-2">{{ $beneficiary->beneficiary_type_formatted }}</p>
                                    
                                    <div class="mb-2">
                                        <span class="badge badge-{{ $beneficiary->status === 'Active' ? 'success' : 'secondary' }} badge-lg">
                                            {{ $beneficiary->status_formatted }}
                                        </span>
                                    </div>

                                    @if($beneficiary->project)
                                    <div class="mb-2">
                                        <span class="badge badge-primary badge-lg">
                                            <i class="fas fa-project-diagram mr-1"></i>
                                            {{ $beneficiary->project->nombre }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Acciones Rápidas -->
                            <div class="card card-success card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-tools mr-2"></i>
                                        Acciones Rápidas
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        @can('update', $beneficiary)
                                        <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="btn btn-warning btn-lg">
                                            <i class="fas fa-edit mr-2"></i>
                                            Editar Beneficiario
                                        </a>
                                        @endcan

                                        @can('delete', $beneficiary)
                                        <form method="POST" action="{{ route('beneficiaries.destroy', $beneficiary) }}" 
                                              class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este beneficiario?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-lg w-100">
                                                <i class="fas fa-trash mr-2"></i>
                                                Eliminar Beneficiario
                                            </button>
                                        </form>
                                        @endcan

                                        <a href="{{ route('beneficiaries.index') }}" class="btn btn-secondary btn-lg">
                                            <i class="fas fa-arrow-left mr-2"></i>
                                            Volver a la Lista
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Información del Sistema -->
                            <div class="card card-dark card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Información del Sistema
                                    </h3>
                                </div>
        <div class="card-body">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-muted"><strong>ID:</strong></td>
                                            <td><code>{{ $beneficiary->id }}</code></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted"><strong>Creado:</strong></td>
                                            <td>{{ $beneficiary->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted"><strong>Actualizado:</strong></td>
                                            <td>{{ $beneficiary->updated_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        @if($beneficiary->user)
                                        <tr>
                                            <td class="text-muted"><strong>Usuario:</strong></td>
                                            <td>{{ $beneficiary->user->name ?? 'N/A' }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-placeholder {
    background: linear-gradient(45deg, #007bff, #0056b3);
}

.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
}

.card-outline {
    border-top: 3px solid;
}

.card-outline.card-primary {
    border-top-color: #007bff;
}

.card-outline.card-info {
    border-top-color: #17a2b8;
}

.card-outline.card-secondary {
    border-top-color: #6c757d;
}

.card-outline.card-warning {
    border-top-color: #ffc107;
}

.card-outline.card-success {
    border-top-color: #28a745;
}

.card-outline.card-dark {
    border-top-color: #343a40;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush
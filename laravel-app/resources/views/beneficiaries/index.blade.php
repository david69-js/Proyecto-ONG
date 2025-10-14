@extends('layouts.app')

@section('title', 'Beneficiarios')
@section('header', 'Gestión de Beneficiarios')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- Filtros y búsqueda -->
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-filter"></i> Filtros de Búsqueda
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('beneficiaries.index') }}">
            <div class="row">
                <!-- Búsqueda general -->
                <div class="col-12 col-md-4 mb-3">
                    <label for="search">
                        <i class="fas fa-search"></i> Buscar
                    </label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Nombre, email, teléfono...">
                </div>
                
                <!-- Tipo de beneficiario -->
                <div class="col-6 col-md-2 mb-3">
                    <label for="beneficiary_type">Tipo</label>
                    <select class="form-control" id="beneficiary_type" name="beneficiary_type">
                        <option value="">Todos</option>
                        <option value="Person" {{ request('beneficiary_type') == 'Person' ? 'selected' : '' }}>Persona</option>
                        <option value="Family" {{ request('beneficiary_type') == 'Family' ? 'selected' : '' }}>Familia</option>
                        <option value="Community" {{ request('beneficiary_type') == 'Community' ? 'selected' : '' }}>Comunidad</option>
                    </select>
                </div>
                
                <!-- Estado -->
                <div class="col-6 col-md-2 mb-3">
                    <label for="status">Estado</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">Todos</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Activo</option>
                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                
                <!-- Proyecto -->
                <div class="col-6 col-md-2 mb-3">
                    <label for="project_id">Proyecto</label>
                    <select class="form-control" id="project_id" name="project_id">
                        <option value="">Todos</option>
                        @foreach(\App\Models\Project::all() as $project)
                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Botones de acción -->
                <div class="col-6 col-md-2 mb-3">
                    <label class="d-block">&nbsp;</label>
                    <div class="btn-group w-100" role="group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search d-md-none"></i>
                            <span class="d-none d-md-inline">Buscar</span>
                        </button>
                        <a href="{{ route('beneficiaries.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times d-md-none"></i>
                            <span class="d-none d-md-inline">Limpiar</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Lista de beneficiarios -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-users"></i> Lista de Beneficiarios
        </h3>
        <div class="card-tools">
            @can('create', App\Models\Beneficiary::class)
            <a href="{{ route('beneficiaries.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nuevo Beneficiario
            </a>
            @endcan
        </div>
    </div>
    <div class="card-body p-0">
        @if($beneficiaries->count() > 0)
            <!-- Vista de tabla para pantallas grandes -->
            <div class="table-responsive d-none d-lg-block">
                <table class="table table-striped table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 50px;">Avatar</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Proyecto</th>
                            <th>Contacto</th>
                            <th style="width: 200px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($beneficiaries as $beneficiary)
                        <tr>
                            <td>
                                <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $beneficiary->name }}</strong>
                                    @if($beneficiary->birth_date)
                                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($beneficiary->birth_date)->age }} años</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $beneficiary->beneficiary_type_formatted ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $beneficiary->status === 'Active' ? 'success' : 'secondary' }}">
                                    {{ $beneficiary->status_formatted ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                @if($beneficiary->project)
                                    <span class="badge badge-primary">{{ $beneficiary->project->nombre }}</span>
                                @else
                                    <span class="text-muted">Sin asignar</span>
                                @endif
                            </td>
                            <td>
                                <div>
                                    @if($beneficiary->email)
                                        <small class="text-muted">{{ $beneficiary->email }}</small><br>
                                    @endif
                                    @if($beneficiary->phone)
                                        <small class="text-muted">{{ $beneficiary->phone }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('beneficiaries.show', $beneficiary) }}" class="btn btn-info btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @can('update', $beneficiary)
                                    <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('delete', $beneficiary)
                                    <form method="POST" action="{{ route('beneficiaries.destroy', $beneficiary) }}" class="d-inline"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este beneficiario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Vista de tarjetas para pantallas pequeñas -->
            <div class="d-lg-none">
                @foreach($beneficiaries as $beneficiary)
                <div class="card mb-3 mx-2">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <!-- Avatar y nombre -->
                            <div class="col-3 col-sm-2">
                                <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-user fa-2x text-white"></i>
                                </div>
                            </div>
                            <div class="col-9 col-sm-10">
                                <h6 class="card-title mb-1">
                                    <strong>{{ $beneficiary->name }}</strong>
                                </h6>
                                @if($beneficiary->birth_date)
                                    <p class="card-text text-muted small mb-2">{{ \Carbon\Carbon::parse($beneficiary->birth_date)->age }} años</p>
                                @endif
                                
                                <!-- Badges de información -->
                                <div class="mb-2">
                                    <span class="badge badge-info mr-1">{{ $beneficiary->beneficiary_type_formatted ?? 'N/A' }}</span>
                                    <span class="badge badge-{{ $beneficiary->status === 'Active' ? 'success' : 'secondary' }}">
                                        {{ $beneficiary->status_formatted ?? 'N/A' }}
                                    </span>
                                    @if($beneficiary->project)
                                        <span class="badge badge-primary">Proyecto: {{ $beneficiary->project->nombre }}</span>
                                    @endif
                                </div>
                                
                                @if($beneficiary->email || $beneficiary->phone)
                                    <p class="card-text small text-muted mb-2">
                                        @if($beneficiary->email)
                                            <i class="fas fa-envelope"></i> {{ $beneficiary->email }}<br>
                                        @endif
                                        @if($beneficiary->phone)
                                            <i class="fas fa-phone"></i> {{ $beneficiary->phone }}
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="btn-group w-100" role="group">
                                    <a href="{{ route('beneficiaries.show', $beneficiary) }}" class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    @can('update', $beneficiary)
                                    <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    @endcan
                                    @can('delete', $beneficiary)
                                    <form method="POST" action="{{ route('beneficiaries.destroy', $beneficiary) }}" class="d-inline"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este beneficiario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No se encontraron beneficiarios</h5>
                <p class="text-muted">No hay beneficiarios que coincidan con los filtros aplicados.</p>
                @can('create', App\Models\Beneficiary::class)
                <a href="{{ route('beneficiaries.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Crear Primer Beneficiario
                </a>
                @endcan
            </div>
        @endif
    </div>
</div>
@endsection

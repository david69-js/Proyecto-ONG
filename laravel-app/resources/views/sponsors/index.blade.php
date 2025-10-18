@extends('layouts.tabler')

@section('page-title', 'Gestión de Patrocinadores')
@section('page-description', 'Administrar patrocinadores del sistema')

@section('title', 'Patrocinadores y Colaboradores')

@section('header', 'Patrocinadores y Colaboradores')

@section('content')
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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

            <!-- Filtros y búsqueda -->
            <div class="card">
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
                    <form method="GET" action="{{ route('sponsors.index') }}">
                        <div class="row">
                            <!-- Búsqueda general -->
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <label for="search">
                                    <i class="fas fa-search"></i> Buscar
                                </label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="{{ request('search') }}" placeholder="Nombre, empresa, email...">
                            </div>
                            
                            <!-- Tipo de patrocinador -->
                            <div class="col-6 col-md-3 col-lg-2 mb-3">
                                <label for="sponsor_type">Tipo</label>
                                <select class="form-control" id="sponsor_type" name="sponsor_type">
                                    <option value="">Todos</option>
                                    <option value="individual" {{ request('sponsor_type') == 'individual' ? 'selected' : '' }}>Individual</option>
                                    <option value="corporate" {{ request('sponsor_type') == 'corporate' ? 'selected' : '' }}>Corporativo</option>
                                    <option value="foundation" {{ request('sponsor_type') == 'foundation' ? 'selected' : '' }}>Fundación</option>
                                    <option value="ngo" {{ request('sponsor_type') == 'ngo' ? 'selected' : '' }}>ONG</option>
                                    <option value="government" {{ request('sponsor_type') == 'government' ? 'selected' : '' }}>Gobierno</option>
                                    <option value="international" {{ request('sponsor_type') == 'international' ? 'selected' : '' }}>Internacional</option>
                                </select>
                            </div>
                            
                            <!-- Tipo de contribución -->
                            <div class="col-6 col-md-3 col-lg-2 mb-3">
                                <label for="contribution_type">Contribución</label>
                                <select class="form-control" id="contribution_type" name="contribution_type">
                                    <option value="">Todas</option>
                                    <option value="monetary" {{ request('contribution_type') == 'monetary' ? 'selected' : '' }}>Monetaria</option>
                                    <option value="materials" {{ request('contribution_type') == 'materials' ? 'selected' : '' }}>Materiales</option>
                                    <option value="services" {{ request('contribution_type') == 'services' ? 'selected' : '' }}>Servicios</option>
                                    <option value="volunteer" {{ request('contribution_type') == 'volunteer' ? 'selected' : '' }}>Voluntariado</option>
                                    <option value="mixed" {{ request('contribution_type') == 'mixed' ? 'selected' : '' }}>Mixta</option>
                                </select>
                            </div>
                            
                            <!-- Estado -->
                            <div class="col-6 col-md-3 col-lg-2 mb-3">
                                <label for="status">Estado</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">Todos</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspendido</option>
                                </select>
                            </div>
                            
                            <!-- Destacados -->
                            <div class="col-6 col-md-3 col-lg-2 mb-3">
                                <label for="featured">Destacados</label>
                                <select class="form-control" id="featured" name="featured">
                                    <option value="">Todos</option>
                                    <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Sí</option>
                                    <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            
                            <!-- Botones de acción -->
                            <div class="col-12 col-lg-2 mb-3">
                                <label class="d-block">&nbsp;</label>
                                <div class="btn-group w-100" role="group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search d-md-none"></i>
                                        <span class="d-none d-md-inline">Buscar</span>
                                    </button>
                                    <a href="{{ route('sponsors.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times d-md-none"></i>
                                        <span class="d-none d-md-inline">Limpiar</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de patrocinadores -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Patrocinadores</h3>
                    <div class="card-tools">
                        @permission('sponsors.create')
                        <a href="{{ route('sponsors.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Nuevo Patrocinador
                        </a>
                        @endpermission
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($sponsors->count() > 0)
                        <!-- Vista de tabla para pantallas grandes -->
                        <div class="table-responsive d-none d-lg-block">
                            <table class="table table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 50px;">Logo</th>
                                        <th>Nombre / Empresa</th>
                                        <th>Tipo</th>
                                        <th>Contribución</th>
                                        <th>Estado</th>
                                        <th>Prioridad</th>
                                        <th>Destacado</th>
                                        <th style="width: 200px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sponsors as $sponsor)
                                    <tr>
                                        <td>
                                            <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }}" 
                                                 class="img-circle elevation-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $sponsor->name }}</strong>
                                                @if($sponsor->company_name)
                                                    <br><small class="text-muted">{{ $sponsor->company_name }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $sponsor->sponsor_type_formatted }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="badge badge-success">{{ $sponsor->contribution_type_formatted }}</span>
                                                @if($sponsor->contribution_amount)
                                                    <br><small class="text-muted">Q{{ number_format($sponsor->contribution_amount, 2) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $statusClasses = [
                                                    'active' => 'badge-success',
                                                    'inactive' => 'badge-secondary',
                                                    'pending' => 'badge-warning',
                                                    'suspended' => 'badge-danger'
                                                ];
                                            @endphp
                                            <span class="badge {{ $statusClasses[$sponsor->status] ?? 'badge-secondary' }}">
                                                {{ $sponsor->status_formatted }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ $sponsor->priority_level }}</span>
                                        </td>
                                        <td>
                                            @if($sponsor->is_featured)
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-star"></i> Destacado
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('sponsors.show', $sponsor) }}" class="btn btn-info btn-sm" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @permission('sponsors.edit')
                                                <a href="{{ route('sponsors.edit', $sponsor) }}" class="btn btn-warning btn-sm" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('sponsors.toggle-featured', $sponsor) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $sponsor->is_featured ? 'btn-outline-warning' : 'btn-warning' }}" 
                                                            title="{{ $sponsor->is_featured ? 'Quitar destacado' : 'Marcar destacado' }}">
                                                        <i class="fas fa-star"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('sponsors.toggle-status', $sponsor) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $sponsor->status === 'active' ? 'btn-outline-success' : 'btn-success' }}" 
                                                            title="{{ $sponsor->status === 'active' ? 'Desactivar' : 'Activar' }}">
                                                        <i class="fas fa-power-off"></i>
                                                    </button>
                                                </form>
                                                @endpermission
                                                @permission('sponsors.delete')
                                                <form method="POST" action="{{ route('sponsors.destroy', $sponsor) }}" class="d-inline"
                                                      onsubmit="return confirm('¿Estás seguro de eliminar este patrocinador?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endpermission
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Vista de tarjetas para pantallas pequeñas -->
                        <div class="d-lg-none">
                            @foreach($sponsors as $sponsor)
                            <div class="card mb-3 mx-2">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <!-- Logo y nombre -->
                                        <div class="col-3 col-sm-2">
                                            <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }}" 
                                                 class="img-circle elevation-2 w-100" style="max-width: 60px; height: 60px; object-fit: cover;">
                                        </div>
                                        <div class="col-9 col-sm-10">
                                            <h6 class="card-title mb-1">
                                                <strong>{{ $sponsor->name }}</strong>
                                                @if($sponsor->is_featured)
                                                    <span class="badge badge-warning ml-1">
                                                        <i class="fas fa-star"></i>
                                                    </span>
                                                @endif
                                            </h6>
                                            @if($sponsor->company_name)
                                                <p class="card-text text-muted small mb-2">{{ $sponsor->company_name }}</p>
                                            @endif
                                            
                                            <!-- Badges de información -->
                                            <div class="mb-2">
                                                <span class="badge badge-info mr-1">{{ $sponsor->sponsor_type_formatted }}</span>
                                                <span class="badge badge-success mr-1">{{ $sponsor->contribution_type_formatted }}</span>
                                                @php
                                                    $statusClasses = [
                                                        'active' => 'badge-success',
                                                        'inactive' => 'badge-secondary',
                                                        'pending' => 'badge-warning',
                                                        'suspended' => 'badge-danger'
                                                    ];
                                                @endphp
                                                <span class="badge {{ $statusClasses[$sponsor->status] ?? 'badge-secondary' }}">
                                                    {{ $sponsor->status_formatted }}
                                                </span>
                                                <span class="badge badge-primary">Prioridad: {{ $sponsor->priority_level }}</span>
                                            </div>
                                            
                                            @if($sponsor->contribution_amount)
                                                <p class="card-text small text-success mb-2">
                                                    <i class="fas fa-coins"></i> Q{{ number_format($sponsor->contribution_amount, 2) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Botones de acción -->
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="btn-group w-100" role="group">
                                                <a href="{{ route('sponsors.show', $sponsor) }}" class="btn btn-outline-info btn-sm">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                                @permission('sponsors.edit')
                                                <a href="{{ route('sponsors.edit', $sponsor) }}" class="btn btn-outline-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <form method="POST" action="{{ route('sponsors.toggle-featured', $sponsor) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $sponsor->is_featured ? 'btn-warning' : 'btn-outline-warning' }}" 
                                                            title="{{ $sponsor->is_featured ? 'Quitar destacado' : 'Marcar destacado' }}">
                                                        <i class="fas fa-star"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('sponsors.toggle-status', $sponsor) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $sponsor->status === 'active' ? 'btn-outline-success' : 'btn-success' }}" 
                                                            title="{{ $sponsor->status === 'active' ? 'Desactivar' : 'Activar' }}">
                                                        <i class="fas fa-power-off"></i>
                                                    </button>
                                                </form>
                                                @endpermission
                                                @permission('sponsors.delete')
                                                <form method="POST" action="{{ route('sponsors.destroy', $sponsor) }}" class="d-inline"
                                                      onsubmit="return confirm('¿Estás seguro de eliminar este patrocinador?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endpermission
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-handshake fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No se encontraron patrocinadores</h5>
                            <p class="text-muted">No hay patrocinadores que coincidan con los filtros aplicados.</p>
                            @permission('sponsors.create')
                            <a href="{{ route('sponsors.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Crear Primer Patrocinador
                            </a>
                            @endpermission
                        </div>
                    @endif
                </div>
                @if($sponsors->hasPages())
                <div class="card-footer">
                    {{ $sponsors->links() }}
                </div>
                @endif
            </div>
        </div>
@endsection

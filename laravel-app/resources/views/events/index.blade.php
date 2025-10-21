@extends('layouts.tabler')

@section('page-title', 'Gestión de Eventos')
@section('page-description', 'Administrar eventos del sistema')

@section('title', 'Eventos')
@section('header', 'Gestión de Eventos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12" style="margin-left: -15px; margin-right: -30px; padding-left: 0; padding-right: 0;">
            <!-- Card principal -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Lista de Eventos
                    </h3>
                    <div class="card-tools d-flex align-items-center">
                        <button type="submit" form="filterForm" class="btn btn-primary btn-sm mr-2">
                            <i class="fas fa-search"></i>
                            <span class="d-none d-sm-inline ml-1">Buscar</span>
                        </button>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-sm mr-2">
                            <i class="fas fa-times"></i>
                            <span class="d-none d-sm-inline ml-1">Limpiar</span>
                        </a>
                        @permission('events.create')
                        <a href="{{ route('admin.events.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus mr-1"></i>
                            Nuevo Evento
                        </a>
                        @endpermission
                    </div>
                </div>

                <!-- Filtros -->
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.events.index') }}" id="filterForm" class="mb-4">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label for="search">
                                        <i class="fas fa-search text-primary mr-1"></i>
                                        Buscar
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="search" 
                                           id="search"
                                           value="{{ request('search') }}"
                                           placeholder="Título, descripción, ubicación...">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <div class="form-group">
                                    <label for="event_type">
                                        <i class="fas fa-tag text-primary mr-1"></i>
                                        Tipo
                                    </label>
                                    <select name="event_type" class="form-control" id="event_type">
                                        <option value="">Todos los tipos</option>
                                        <option value="fundraising" {{ request('event_type') == 'fundraising' ? 'selected' : '' }}>Recaudación de Fondos</option>
                                        <option value="volunteer" {{ request('event_type') == 'volunteer' ? 'selected' : '' }}>Voluntariado</option>
                                        <option value="awareness" {{ request('event_type') == 'awareness' ? 'selected' : '' }}>Concientización</option>
                                        <option value="community" {{ request('event_type') == 'community' ? 'selected' : '' }}>Comunitario</option>
                                        <option value="training" {{ request('event_type') == 'training' ? 'selected' : '' }}>Capacitación</option>
                                        <option value="other" {{ request('event_type') == 'other' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <div class="form-group">
                                    <label for="status">
                                        <i class="fas fa-toggle-on text-primary mr-1"></i>
                                        Estado
                                    </label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="">Todos los estados</option>
                                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Borrador</option>
                                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Publicado</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <div class="form-group">
                                    <label for="date_filter">
                                        <i class="fas fa-calendar text-primary mr-1"></i>
                                        Fecha
                                    </label>
                                    <select name="date_filter" class="form-control" id="date_filter">
                                        <option value="">Todas las fechas</option>
                                        <option value="upcoming" {{ request('date_filter') == 'upcoming' ? 'selected' : '' }}>Próximos</option>
                                        <option value="past" {{ request('date_filter') == 'past' ? 'selected' : '' }}>Pasados</option>
                                        <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>Este mes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label for="project_id">
                                        <i class="fas fa-project-diagram text-primary mr-1"></i>
                                        Proyecto
                                    </label>
                                    <select name="project_id" class="form-control" id="project_id">
                                        <option value="">Todos los proyectos</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Vista de escritorio -->
                    <div class="d-none d-lg-block">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="30%">Evento</th>
                                        <th width="10%">Tipo</th>
                                        <th width="15%">Fecha</th>
                                        <th width="15%">Ubicación</th>
                                        <th width="10%">Participantes</th>
                                        <th width="8%">Estado</th>
                                        <th width="12%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($events as $event)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $event->image_url }}" 
                                                     alt="{{ $event->title }}" 
                                                     class="img-thumbnail mr-2" 
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 text-truncate" style="max-width: 200px;">{{ $event->title }}</h6>
                                                    <small class="text-muted d-block" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                        {{ Str::limit($event->description, 40) }}
                                                    </small>
                                                    @if($event->featured)
                                                        <span class="badge badge-warning badge-sm">
                                                            <i class="fas fa-star"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $event->event_type_color }}">
                                                {{ $event->event_type_formatted }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $event->start_date->format('d/m/Y') }}</strong>
                                                <br><small class="text-muted">{{ $event->start_date->format('H:i') }}</small>
                                                @if($event->end_date)
                                                    <br><small class="text-info">Hasta: {{ $event->end_date->format('d/m/Y H:i') }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($event->location)
                                                <i class="fas fa-map-marker-alt text-muted mr-1"></i>
                                                {{ $event->location }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($event->max_participants)
                                                <div class="progress mb-1" style="height: 6px;">
                                                    <div class="progress-bar" 
                                                         role="progressbar" 
                                                         style="width: {{ ($event->current_participants / $event->max_participants) * 100 }}%">
                                                    </div>
                                                </div>
                                                <small class="text-muted">
                                                    {{ $event->current_participants }}/{{ $event->max_participants }}
                                                </small>
                                            @else
                                                <span class="text-muted">{{ $event->current_participants }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $event->status_color }}">
                                                {{ $event->status_formatted }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.events.show', $event) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   data-toggle="tooltip" title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @permission('events.edit')
                                                <a href="{{ route('admin.events.edit', $event) }}" 
                                                   class="btn btn-sm btn-outline-warning" 
                                                   data-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endpermission
                                                @permission('events.delete')
                                                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" 
                                                      class="d-inline" 
                                                      onsubmit="return confirm('¿Estás seguro de eliminar este evento?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            data-toggle="tooltip" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endpermission
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No se encontraron eventos</h5>
                                            <p class="text-muted">Intenta ajustar los filtros de búsqueda.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Vista móvil mejorada -->
                    <div class="d-lg-none">
                        @forelse($events as $event)
                        <div class="card mb-3 shadow-sm">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-1 text-truncate">{{ $event->title }}</h6>
                                        <div class="d-flex flex-wrap gap-1">
                                            <span class="badge badge-{{ $event->event_type_color }} badge-sm">
                                                {{ $event->event_type_formatted }}
                                            </span>
                                            <span class="badge badge-{{ $event->status_color }} badge-sm">
                                                {{ $event->status_formatted }}
                                            </span>
                                            @if($event->featured)
                                                <span class="badge badge-warning badge-sm">
                                                    <i class="fas fa-star"></i> Destacado
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" 
                                                data-toggle="dropdown" 
                                                aria-haspopup="true" 
                                                aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('admin.events.show', $event) }}">
                                                <i class="fas fa-eye mr-2"></i>Ver detalles
                                            </a>
                                            @permission('events.edit')
                                            <a class="dropdown-item" href="{{ route('admin.events.edit', $event) }}">
                                                <i class="fas fa-edit mr-2"></i>Editar
                                            </a>
                                            @endpermission
                                            @permission('events.delete')
                                            <div class="dropdown-divider"></div>
                                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" 
                                                  onsubmit="return confirm('¿Eliminar evento?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash mr-2"></i>Eliminar
                                                </button>
                                            </form>
                                            @endpermission
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($event->image_path)
                                <div class="text-center mb-3">
                                    <img src="{{ $event->image_url }}" 
                                         alt="{{ $event->title }}" 
                                         class="img-fluid rounded" 
                                         style="max-height: 150px; width: 100%; object-fit: cover;">
                                </div>
                                @endif
                                
                                @if($event->description)
                                <p class="card-text text-muted small mb-3">
                                    {{ Str::limit($event->description, 120) }}
                                </p>
                                @endif

                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border-right">
                                            <i class="fas fa-calendar text-primary"></i>
                                            <div class="small text-muted">Fecha</div>
                                            <div class="font-weight-bold">{{ $event->start_date->format('d/m/Y') }}</div>
                                            <div class="small text-muted">{{ $event->start_date->format('H:i') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <i class="fas fa-users text-success"></i>
                                        <div class="small text-muted">Participantes</div>
                                        <div class="font-weight-bold">
                                            {{ $event->current_participants }}
                                            @if($event->max_participants)
                                                /{{ $event->max_participants }}
                                            @endif
                                        </div>
                                        @if($event->max_participants)
                                        <div class="progress mt-1" style="height: 4px;">
                                            <div class="progress-bar" 
                                                 role="progressbar" 
                                                 style="width: {{ ($event->current_participants / $event->max_participants) * 100 }}%">
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                @if($event->location)
                                <div class="mt-3 text-center">
                                    <i class="fas fa-map-marker-alt text-muted mr-1"></i>
                                    <span class="small text-muted">{{ $event->location }}</span>
                                </div>
                                @endif

                                @if($event->cost > 0)
                                <div class="mt-2 text-center">
                                    <i class="fas fa-coins text-warning mr-1"></i>
                                    <span class="small font-weight-bold text-success">{{ $event->cost_formatted }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No se encontraron eventos</h5>
                            <p class="text-muted">Intenta ajustar los filtros de búsqueda.</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Paginación -->
                    @if($events->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $events->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos adicionales para mejorar la apariencia */
.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.9rem;
}

.table td {
    vertical-align: middle;
    font-size: 0.9rem;
}

.badge-sm {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

.card.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.gap-1 > * + * {
    margin-left: 0.25rem;
}

/* Extender hacia ambos lados para más espacio */
.col-12[style*="margin-left"] {
    margin-left: -30px !important;
    margin-right: -45px !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
}

/* Asegurar que la card use todo el espacio disponible */
.card {
    margin-left: 0 !important;
    margin-right: 0 !important;
}

/* Ajustar para móviles */
@media (max-width: 576px) {
    .col-12[style*="margin-left"] {
        margin-left: -15px !important;
        margin-right: -20px !important;
    }
}

/* Ajustar botones de acción para que no se salgan */
.btn-group .btn {
    padding: 0.2rem 0.3rem !important;
    font-size: 0.7rem !important;
    min-width: 28px !important;
    height: 28px !important;
    text-align: center !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.btn-group {
    flex-wrap: nowrap !important;
}

/* Asegurar que la tabla use todo el ancho disponible */
.table {
    table-layout: fixed !important;
    width: 100% !important;
}

/* Ajustar contenido de celdas para que no se desborde */
.table td {
    word-wrap: break-word !important;
    overflow: hidden !important;
}

/* Centrar texto en botones del header */
.card-tools .btn {
    text-align: center !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

@media (max-width: 576px) {
    .col-12[style*="margin-right"] {
        margin-right: -15px !important;
    }
    
    .card-header .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .card-header .dropdown {
        margin-top: 0.5rem;
        align-self: flex-end;
    }
    
    .table-responsive {
        font-size: 0.8rem;
    }
    
    .btn-group .btn {
        padding: 0.2rem 0.3rem;
        font-size: 0.7rem;
        min-width: 28px;
        height: 28px;
    }
}
</style>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Inicializar dropdowns
    $('.dropdown-toggle').dropdown();
    
    // Auto-submit del formulario de filtros en móvil
    $('#event_type, #status, #date_filter, #project_id').on('change', function() {
        if ($(window).width() < 768) {
            $(this).closest('form').submit();
        }
    });
});
</script>
@endpush
@extends('layouts.tabler')

@section('title', 'Reportes de Eventos')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <i class="fas fa-chart-bar me-2"></i>Reportes de Eventos
                </h2>
                <div class="text-muted mt-1">Estadísticas y análisis de eventos</div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('admin.events-admin.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Volver a Eventos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Filtros</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.events-admin.reports') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Fecha desde</label>
                            <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha hasta</label>
                            <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tipo de evento</label>
                            <select class="form-select" name="event_type">
                                <option value="">Todos los tipos</option>
                                @foreach($eventTypes as $key => $label)
                                    <option value="{{ $key }}" {{ request('event_type') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="status">
                                <option value="">Todos los estados</option>
                                @foreach($eventStatuses as $key => $label)
                                    @if($key !== 'all')
                                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i>Filtrar
                            </button>
                            <a href="{{ route('admin.events-admin.reports') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Estadísticas generales -->
        <div class="row row-deck row-cards mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Total de Eventos</div>
                        </div>
                        <div class="h1 mb-3">{{ $totalEvents }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Publicados</div>
                        </div>
                        <div class="h1 mb-3 text-success">{{ $publishedEvents }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Borradores</div>
                        </div>
                        <div class="h1 mb-3 text-warning">{{ $draftEvents }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Total Registros</div>
                        </div>
                        <div class="h1 mb-3 text-info">{{ $totalRegistrations }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row row-deck row-cards mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Eventos por Tipo</h3>
                    </div>
                    <div class="card-body">
                        @if($eventsByType->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Cantidad</th>
                                            <th>Porcentaje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($eventsByType as $type => $count)
                                            <tr>
                                                <td>{{ $eventTypes[$type] ?? $type }}</td>
                                                <td>{{ $count }}</td>
                                                <td>{{ $totalEvents > 0 ? round(($count / $totalEvents) * 100, 1) : 0 }}%</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center text-muted">
                                <i class="fas fa-chart-pie fa-3x mb-3"></i>
                                <p>No hay datos para mostrar</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Eventos por Estado</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Estado</th>
                                        <th>Cantidad</th>
                                        <th>Porcentaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Publicados</td>
                                        <td>{{ $publishedEvents }}</td>
                                        <td>{{ $totalEvents > 0 ? round(($publishedEvents / $totalEvents) * 100, 1) : 0 }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Borradores</td>
                                        <td>{{ $draftEvents }}</td>
                                        <td>{{ $totalEvents > 0 ? round(($draftEvents / $totalEvents) * 100, 1) : 0 }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Cancelados</td>
                                        <td>{{ $cancelledEvents }}</td>
                                        <td>{{ $totalEvents > 0 ? round(($cancelledEvents / $totalEvents) * 100, 1) : 0 }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Completados</td>
                                        <td>{{ $completedEvents }}</td>
                                        <td>{{ $totalEvents > 0 ? round(($completedEvents / $totalEvents) * 100, 1) : 0 }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de eventos -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de Eventos</h3>
            </div>
            <div class="card-body">
                @if($events->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Registros</th>
                                    <th>Proyecto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $event)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-bold">{{ $event->title }}</div>
                                                    <div class="text-muted">{{ Str::limit($event->description, 50) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-blue-lt">
                                                {{ $eventTypes[$event->event_type] ?? $event->event_type }}
                                            </span>
                                        </td>
                                        <td>
                                            @switch($event->status)
                                                @case('published')
                                                    <span class="badge bg-success">Publicado</span>
                                                    @break
                                                @case('draft')
                                                    <span class="badge bg-warning">Borrador</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-danger">Cancelado</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge bg-info">Completado</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">{{ $event->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <div>{{ $event->start_date->format('d/m/Y') }}</div>
                                            <div class="text-muted">{{ $event->start_date->format('H:i') }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $event->registrations->count() }}</span>
                                        </td>
                                        <td>
                                            @if($event->project)
                                                <span class="text-muted">{{ $event->project->nombre }}</span>
                                            @else
                                                <span class="text-muted">Sin proyecto</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-calendar-times fa-3x mb-3"></i>
                        <p>No se encontraron eventos con los filtros aplicados</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

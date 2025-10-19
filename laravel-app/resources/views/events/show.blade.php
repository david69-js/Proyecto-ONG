@extends('layouts.tabler')

@section('title', 'Detalles del Evento')
@section('page-title', 'Detalles del Evento')
@section('page-description', 'Información completa del evento: ' . $event->title)

@section('content')
<div class="row">
    <!-- Contenido Principal -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt me-2"></i>
                        {{ $event->title }}
                    </h3>
                        <div>
                            @if($event->featured)
                                <span class="badge bg-warning text-white">
                                    <i class="fas fa-star me-1"></i>
                                    Destacado
                                </span>
                            @endif
                            <span class="badge bg-{{ $event->status === 'published' ? 'success' : ($event->status === 'draft' ? 'secondary' : ($event->status === 'cancelled' ? 'danger' : 'info')) }} text-white">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($event->description)
                        <div class="mb-4">
                            <h5><i class="fas fa-align-left"></i> Descripción</h5>
                            <p class="text-muted">{{ $event->description }}</p>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-info-circle"></i> Información del Evento</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Tipo:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $event->event_type === 'fundraising' ? 'success' : ($event->event_type === 'volunteer' ? 'info' : ($event->event_type === 'awareness' ? 'warning' : 'primary')) }} text-white">
                                            {{ ucfirst(str_replace('_', ' ', $event->event_type)) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha de Inicio:</strong></td>
                                    <td>{{ $event->start_date->format('d/m/Y H:i') }}</td>
                                </tr>
                                @if($event->end_date)
                                    <tr>
                                        <td><strong>Fecha de Fin:</strong></td>
                                        <td>{{ $event->end_date->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endif
                                @if($event->location)
                                    <tr>
                                        <td><strong>Ubicación:</strong></td>
                                        <td>{{ $event->location }}</td>
                                    </tr>
                                @endif
                                @if($event->address)
                                    <tr>
                                        <td><strong>Dirección:</strong></td>
                                        <td>{{ $event->address }}</td>
                                    </tr>
                                @endif
                                @if($event->cost > 0)
                                    <tr>
                                        <td><strong>Costo:</strong></td>
                                        <td class="text-success font-weight-bold">{{ $event->cost_formatted }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5><i class="fas fa-users"></i> Participantes</h5>
                            <table class="table table-sm">
                                @if($event->max_participants)
                                    <tr>
                                        <td><strong>Máximo:</strong></td>
                                        <td>{{ $event->max_participants }} participantes</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><strong>Registrados:</strong></td>
                                    <td>{{ $event->current_participants }} participantes</td>
                                </tr>
                                @if($event->registration_required)
                                    <tr>
                                        <td><strong>Requiere Registro:</strong></td>
                                        <td>
                                            <span class="badge bg-info text-white">Sí</span>
                                            @if($event->registration_deadline)
                                                <br><small class="text-muted">
                                                    Límite: {{ $event->registration_deadline->format('d/m/Y H:i') }}
                                                </small>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    
                    @if($event->requirements)
                        <div class="mb-4">
                            <h5><i class="fas fa-list-check"></i> Requisitos</h5>
                            <p class="text-muted">{{ $event->requirements }}</p>
                        </div>
                    @endif
                    
                    @if($event->contact_email || $event->contact_phone)
                        <div class="mb-4">
                            <h5><i class="fas fa-phone"></i> Información de Contacto</h5>
                            <div class="row">
                                @if($event->contact_email)
                                    <div class="col-md-6">
                                        <strong>Email:</strong> 
                                        <a href="mailto:{{ $event->contact_email }}">{{ $event->contact_email }}</a>
                                    </div>
                                @endif
                                @if($event->contact_phone)
                                    <div class="col-md-6">
                                        <strong>Teléfono:</strong> 
                                        <a href="tel:{{ $event->contact_phone }}">{{ $event->contact_phone }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
        
        <!-- Panel Lateral -->
        <div class="col-md-4">
            <!-- Imagen del Evento -->
            @if($event->image_path)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-image"></i>
                            Imagen del Evento
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="img-fluid rounded">
                    </div>
                </div>
            @endif
            
            <!-- Proyecto Asociado -->
            @if($event->project)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-project-diagram"></i>
                            Proyecto Asociado
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6>{{ $event->project->nombre }}</h6>
                        <p class="text-muted small">{{ $event->project->descripcion }}</p>
                        <a href="{{ route('projects.show', $event->project) }}" class="btn btn-sm btn-outline-primary">
                            Ver Proyecto
                        </a>
                    </div>
                </div>
            @endif
            
            <!-- Información del Sistema -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-info"></i>
                        Información del Sistema
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Creado por:</strong></td>
                            <td>{{ $event->creator->first_name ?? 'Sistema' }} {{ $event->creator->last_name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha de Creación:</strong></td>
                            <td>{{ $event->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Última Actualización:</strong></td>
                            <td>{{ $event->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Acciones -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-cogs"></i>
                        Acciones
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @can('update', $event)
                            <a href="{{ route('events.edit', $event) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i>
                                Editar Evento
                            </a>
                        @endcan
                        
                        @can('update', $event)
                            <form method="POST" action="{{ route('events.toggle-featured', $event) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-{{ $event->featured ? 'warning' : 'outline-warning' }} w-100">
                                    <i class="fas fa-star"></i>
                                    {{ $event->featured ? 'Quitar Destacado' : 'Marcar como Destacado' }}
                                </button>
                            </form>
                        @endcan
                        
                        @can('update', $event)
                            <div class="btn-group w-100">
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-flag"></i>
                                    Cambiar Estado
                                </button>
                                <div class="dropdown-menu">
                                    <form method="POST" action="{{ route('events.change-status', $event) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="draft">
                                        <button type="submit" class="dropdown-item">Borrador</button>
                                    </form>
                                    <form method="POST" action="{{ route('events.change-status', $event) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="published">
                                        <button type="submit" class="dropdown-item">Publicado</button>
                                    </form>
                                    <form method="POST" action="{{ route('events.change-status', $event) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="dropdown-item">Cancelado</button>
                                    </form>
                                    <form method="POST" action="{{ route('events.change-status', $event) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="dropdown-item">Completado</button>
                                    </form>
                                </div>
                            </div>
                        @endcan
                        
                        <a href="{{ route('events.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Volver a la Lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tabla de Registros - Ancho Completo -->
    @if($event->registrations->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-check"></i>
                            Registros ({{ $event->registrations->count() }})
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Estado</th>
                                        <th>Fecha de Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($event->registrations as $registration)
                                        <tr>
                                            <td>{{ $registration->name }}</td>
                                            <td>{{ $registration->email }}</td>
                                            <td>{{ $registration->phone ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $registration->status === 'confirmed' ? 'success' : ($registration->status === 'pending' ? 'warning' : 'secondary') }} text-white">
                                                    {{ ucfirst($registration->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $registration->registered_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @can('update', $event)
                                                    <div class="btn-group btn-group-sm">
                                                        <form method="POST" action="{{ route('events.registration.status', $registration) }}" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                                                <option value="pending" {{ $registration->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                                                <option value="confirmed" {{ $registration->status == 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                                                                <option value="cancelled" {{ $registration->status == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                                            </select>
                                                        </form>
                                                        <form method="POST" action="{{ route('events.registration.delete', $registration) }}" class="d-inline" onsubmit="return confirm('¿Eliminar este registro?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection


@extends('layouts.tabler')

@section('page-title', 'Gestión de Donaciones')
@section('page-description', 'Administrar donaciones del sistema')

@section('title', 'Gestión de Donaciones')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-heart text-danger"></i>
                        Gestión de Donaciones
                    </h3>
                    @permission('donations.create')
                    <a href="{{ route('donations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nueva Donación
                    </a>
                    @endpermission
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <form method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="search" class="form-label">Buscar</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="{{ request('search') }}" placeholder="Código, donante, descripción...">
                            </div>
                            <div class="col-md-2">
                                <label for="status" class="form-label">Estado</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Todos</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmada</option>
                                    <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Procesada</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rechazada</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="donation_type" class="form-label">Tipo</label>
                                <select class="form-select" id="donation_type" name="donation_type">
                                    <option value="">Todos</option>
                                    <option value="monetary" {{ request('donation_type') == 'monetary' ? 'selected' : '' }}>Monetaria</option>
                                    <option value="materials" {{ request('donation_type') == 'materials' ? 'selected' : '' }}>Materiales</option>
                                    <option value="services" {{ request('donation_type') == 'services' ? 'selected' : '' }}>Servicios</option>
                                    <option value="volunteer" {{ request('donation_type') == 'volunteer' ? 'selected' : '' }}>Voluntariado</option>
                                    <option value="mixed" {{ request('donation_type') == 'mixed' ? 'selected' : '' }}>Mixta</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="project_id" class="form-label">Proyecto</label>
                                <select class="form-select" id="project_id" name="project_id">
                                    <option value="">Todos</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                            {{ $project->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="donor_type" class="form-label">Tipo Donante</label>
                                <select class="form-select" id="donor_type" name="donor_type">
                                    <option value="">Todos</option>
                                    <option value="individual" {{ request('donor_type') == 'individual' ? 'selected' : '' }}>Individual</option>
                                    <option value="corporate" {{ request('donor_type') == 'corporate' ? 'selected' : '' }}>Corporativo</option>
                                    <option value="foundation" {{ request('donor_type') == 'foundation' ? 'selected' : '' }}>Fundación</option>
                                    <option value="ngo" {{ request('donor_type') == 'ngo' ? 'selected' : '' }}>ONG</option>
                                    <option value="government" {{ request('donor_type') == 'government' ? 'selected' : '' }}>Gobierno</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla de donaciones -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Código</th>
                                    <th>Tipo</th>
                                    <th>Donante</th>
                                    <th>Monto</th>
                                    <th>Proyecto</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($donations as $donation)
                                <tr>
                                    <td>
                                        <code>{{ $donation->donation_code }}</code>
                                    </td>
                                    <td>
                                        <span class="badge bg-info custom-badge">{{ $donation->donation_type_formatted }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $donation->donor_display_name }}</strong>
                                            @if($donation->is_anonymous)
                                                <i class="fas fa-user-secret text-muted" title="Donación anónima"></i>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ $donation->donor_type_formatted }}</small>
                                    </td>
                                    <td>
                                        @if($donation->isMonetary())
                                            <strong class="text-success">{{ $donation->formatted_amount }}</strong>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($donation->project)
                                            <a href="{{ route('projects.show', $donation->project) }}" class="text-decoration-none">
                                                {{ Str::limit($donation->project->nombre, 30) }}
                                            </a>
                                        @else
                                            <span class="text-muted">Sin proyecto</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'pending' => 'warning',
                                                'confirmed' => 'info',
                                                'processed' => 'success',
                                                'rejected' => 'danger',
                                                'cancelled' => 'secondary'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusClasses[$donation->status] ?? 'secondary' }}">
                                            {{ $donation->status_formatted }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>{{ $donation->created_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $donation->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('donations.show', $donation) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @permission('donations.edit')
                                            <a href="{{ route('donations.edit', $donation) }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endpermission

                                            @permission('donations.confirm')
                                            @if($donation->status === 'pending')
                                            <form method="POST" action="{{ route('donations.confirm', $donation) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success" 
                                                        onclick="return confirm('¿Confirmar esta donación?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            @endif
                                            @endpermission

                                            @permission('donations.process')
                                            @if($donation->status === 'confirmed')
                                            <form method="POST" action="{{ route('donations.process', $donation) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-info" 
                                                        onclick="return confirm('¿Procesar esta donación?')">
                                                    <i class="fas fa-cogs"></i>
                                                </button>
                                            </form>
                                            @endif
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No se encontraron donaciones</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            @permission('donations.reports')
                            <a href="{{ route('donations.reports') }}" class="btn btn-outline-info">
                                <i class="fas fa-chart-bar"></i> Reportes
                            </a>
                            @endpermission

                            @permission('donations.export')
                            <a href="{{ route('donations.export', request()->query()) }}" class="btn btn-outline-success">
                                <i class="fas fa-download"></i> Exportar
                            </a>
                            @endpermission
                        </div>
                        
                        <div>
                            {{ $donations->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

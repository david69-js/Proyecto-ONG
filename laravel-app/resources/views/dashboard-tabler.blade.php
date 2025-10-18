@extends('layouts.tabler')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Panel de administración del sistema de ONG')

@section('content')
<div class="row row-deck row-cards">
    <!-- Estadísticas principales -->
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Usuarios</div>
                    <div class="ms-auto lh-1">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Últimos 7 días</a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item active" href="#">Últimos 7 días</a>
                                <a class="dropdown-item" href="#">Últimos 30 días</a>
                                <a class="dropdown-item" href="#">Últimos 3 meses</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h1 mb-3">{{ \App\Models\User::count() }}</div>
                <div class="d-flex mb-2">
                    <div>Total de usuarios registrados</div>
                    <div class="ms-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                            <i class="fas fa-arrow-up me-1"></i>
                            5.2%
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Proyectos</div>
                    <div class="ms-auto lh-1">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Activos</a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item active" href="#">Activos</a>
                                <a class="dropdown-item" href="#">Todos</a>
                                <a class="dropdown-item" href="#">Completados</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h1 mb-3">{{ \App\Models\Project::count() }}</div>
                <div class="d-flex mb-2">
                    <div>Proyectos en ejecución</div>
                    <div class="ms-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                            <i class="fas fa-arrow-up me-1"></i>
                            12.5%
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Beneficiarios</div>
                    <div class="ms-auto lh-1">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Activos</a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item active" href="#">Activos</a>
                                <a class="dropdown-item" href="#">Todos</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h1 mb-3">{{ \App\Models\Beneficiary::count() }}</div>
                <div class="d-flex mb-2">
                    <div>Beneficiarios atendidos</div>
                    <div class="ms-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                            <i class="fas fa-arrow-up me-1"></i>
                            8.1%
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Donaciones</div>
                    <div class="ms-auto lh-1">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Este mes</a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item active" href="#">Este mes</a>
                                <a class="dropdown-item" href="#">Últimos 3 meses</a>
                                <a class="dropdown-item" href="#">Este año</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h1 mb-3">Q {{ number_format(\App\Models\Donation::sum('amount'), 2) }}</div>
                <div class="d-flex mb-2">
                    <div>Total recaudado</div>
                    <div class="ms-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                            <i class="fas fa-arrow-up me-1"></i>
                            15.3%
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row row-deck row-cards mt-4">
    <!-- Proyectos recientes -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Proyectos Recientes</h3>
                <div class="card-actions">
                    <a href="{{ route('projects.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>Ver Todos
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Proyecto</th>
                                <th>Estado</th>
                                <th>Beneficiarios</th>
                                <th>Fecha Inicio</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Project::latest()->take(5)->get() as $project)
                            <tr>
                                <td>
                                    <div class="d-flex py-1 align-items-center">
                                        <div class="flex-fill">
                                            <div class="font-weight-medium">{{ $project->name }}</div>
                                            <div class="text-muted">{{ Str::limit($project->description, 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $project->status === 'active' ? 'success' : ($project->status === 'completed' ? 'primary' : 'warning') }}">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                </td>
                                <td class="text-muted">
                                    {{ $project->beneficiaries->count() }}
                                </td>
                                <td class="text-muted">
                                    {{ $project->start_date ? $project->start_date->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td>
                                    <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    <i class="fas fa-inbox me-2"></i>No hay proyectos registrados
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row row-deck row-cards mt-4">
    <!-- Donaciones recientes -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Donaciones Recientes</h3>
                <div class="card-actions">
                    <a href="{{ route('donations.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>Ver Todas
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Donante</th>
                                <th>Monto</th>
                                <th>Proyecto</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Donation::with(['user', 'project'])->latest()->take(5)->get() as $donation)
                            <tr>
                                <td>
                                    <div class="d-flex py-1 align-items-center">
                                        <span class="avatar me-2" style="background-image: url({{ asset('assets/img/default-avatar.png') }})"></span>
                                        <div class="flex-fill">
                                            <div class="font-weight-medium">
                                                @if($donation->is_anonymous)
                                                    Donante Anónimo
                                                @elseif($donation->user)
                                                    {{ $donation->user->full_name }}
                                                @else
                                                    {{ $donation->donor_name ?: 'Donante' }}
                                                @endif
                                            </div>
                                            <div class="text-muted">
                                                @if($donation->is_anonymous)
                                                    Anónimo
                                                @elseif($donation->user)
                                                    {{ $donation->user->email }}
                                                @else
                                                    {{ $donation->donor_email ?: 'N/A' }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted">
                                    <strong>{{ $donation->formatted_amount }}</strong>
                                </td>
                                <td class="text-muted">
                                    {{ $donation->project ? $donation->project->name : 'General' }}
                                </td>
                                <td class="text-muted">
                                    {{ $donation->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $donation->status === 'confirmed' ? 'success' : ($donation->status === 'pending' ? 'warning' : ($donation->status === 'processed' ? 'primary' : 'danger')) }}">
                                        {{ $donation->status_formatted }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('donations.show', $donation) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    <i class="fas fa-inbox me-2"></i>No hay donaciones registradas
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Reportes de Donaciones')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar text-primary"></i>
                        Reportes de Donaciones
                    </h3>
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <form method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="project_id" class="form-label">Proyecto</label>
                                <select class="form-select" id="project_id" name="project_id">
                                    <option value="">Todos los proyectos</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                            {{ $project->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="date_from" class="form-label">Fecha Desde</label>
                                <input type="date" class="form-control" id="date_from" name="date_from" 
                                       value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="date_to" class="form-label">Fecha Hasta</label>
                                <input type="date" class="form-control" id="date_to" name="date_to" 
                                       value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter"></i> Aplicar Filtros
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Estadísticas Generales -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">{{ number_format($statistics['total_donations']) }}</h4>
                                            <p class="mb-0">Total Donaciones</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-heart fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">${{ number_format($statistics['total_amount'], 2) }}</h4>
                                            <p class="mb-0">Monto Total</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-dollar-sign fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">{{ number_format($statistics['confirmed_donations']) }}</h4>
                                            <p class="mb-0">Confirmadas</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">{{ number_format($statistics['pending_donations']) }}</h4>
                                            <p class="mb-0">Pendientes</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-clock fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Gráfico por Tipo de Donación -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-chart-pie"></i> Donaciones por Tipo
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="donationsByTypeChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfico por Estado -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-chart-doughnut"></i> Donaciones por Estado
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="donationsByStatusChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <!-- Gráfico de Tendencias Mensuales -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-chart-line"></i> Tendencias Mensuales (Monto)
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="monthlyDonationsChart" width="800" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Resumen -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-table"></i> Resumen Detallado
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Métrica</th>
                                                    <th class="text-end">Cantidad</th>
                                                    <th class="text-end">Porcentaje</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Total de Donaciones</td>
                                                    <td class="text-end">{{ number_format($statistics['total_donations']) }}</td>
                                                    <td class="text-end">100%</td>
                                                </tr>
                                                <tr>
                                                    <td>Donaciones Confirmadas</td>
                                                    <td class="text-end">{{ number_format($statistics['confirmed_donations']) }}</td>
                                                    <td class="text-end">{{ $statistics['total_donations'] > 0 ? number_format(($statistics['confirmed_donations'] / $statistics['total_donations']) * 100, 1) : 0 }}%</td>
                                                </tr>
                                                <tr>
                                                    <td>Donaciones Procesadas</td>
                                                    <td class="text-end">{{ number_format($statistics['processed_donations']) }}</td>
                                                    <td class="text-end">{{ $statistics['total_donations'] > 0 ? number_format(($statistics['processed_donations'] / $statistics['total_donations']) * 100, 1) : 0 }}%</td>
                                                </tr>
                                                <tr>
                                                    <td>Donaciones Pendientes</td>
                                                    <td class="text-end">{{ number_format($statistics['pending_donations']) }}</td>
                                                    <td class="text-end">{{ $statistics['total_donations'] > 0 ? number_format(($statistics['pending_donations'] / $statistics['total_donations']) * 100, 1) : 0 }}%</td>
                                                </tr>
                                                <tr class="table-success">
                                                    <td><strong>Monto Total Recaudado</strong></td>
                                                    <td class="text-end"><strong>${{ number_format($statistics['total_amount'], 2) }}</strong></td>
                                                    <td class="text-end">-</td>
                                                </tr>
                                            </tbody>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos para los gráficos
    const donationsByTypeData = @json($donationsByType);
    const donationsByStatusData = @json($donationsByStatus);
    const monthlyDonationsData = @json($monthlyDonations);

    // Configuración de colores
    const colors = {
        primary: '#007bff',
        success: '#28a745',
        info: '#17a2b8',
        warning: '#ffc107',
        danger: '#dc3545',
        secondary: '#6c757d'
    };

    // Gráfico de Donaciones por Tipo
    const typeCtx = document.getElementById('donationsByTypeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'pie',
        data: {
            labels: donationsByTypeData.map(item => {
                const types = {
                    'monetary': 'Monetaria',
                    'materials': 'Materiales',
                    'services': 'Servicios',
                    'volunteer': 'Voluntariado',
                    'mixed': 'Mixta'
                };
                return types[item.donation_type] || item.donation_type;
            }),
            datasets: [{
                data: donationsByTypeData.map(item => item.count),
                backgroundColor: [
                    colors.primary,
                    colors.success,
                    colors.info,
                    colors.warning,
                    colors.danger
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Gráfico de Donaciones por Estado
    const statusCtx = document.getElementById('donationsByStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: donationsByStatusData.map(item => {
                const statuses = {
                    'pending': 'Pendiente',
                    'confirmed': 'Confirmada',
                    'processed': 'Procesada',
                    'rejected': 'Rechazada',
                    'cancelled': 'Cancelada'
                };
                return statuses[item.status] || item.status;
            }),
            datasets: [{
                data: donationsByStatusData.map(item => item.count),
                backgroundColor: [
                    colors.warning,
                    colors.info,
                    colors.success,
                    colors.danger,
                    colors.secondary
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Gráfico de Tendencias Mensuales
    const monthlyCtx = document.getElementById('monthlyDonationsChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyDonationsData.map(item => {
                const date = new Date(item.month + '-01');
                return date.toLocaleDateString('es-ES', { year: 'numeric', month: 'short' });
            }),
            datasets: [{
                label: 'Monto Recaudado ($)',
                data: monthlyDonationsData.map(item => parseFloat(item.total)),
                borderColor: colors.primary,
                backgroundColor: colors.primary + '20',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endsection

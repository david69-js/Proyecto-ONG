@extends('layouts.app')

@section('title', 'Estadísticas de Productos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar text-primary"></i>
                            Estadísticas de Productos
                        </h3>
                        <div class="d-flex gap-2">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left"></i> Volver a Productos
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Tarjetas de estadísticas -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">{{ number_format($statistics['total_products']) }}</h4>
                                            <p class="mb-0">Total de Productos</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-box fa-2x"></i>
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
                                            <h4 class="mb-0">{{ number_format($statistics['active_products']) }}</h4>
                                            <p class="mb-0">Productos Activos</p>
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
                                            <h4 class="mb-0">{{ number_format($statistics['featured_products']) }}</h4>
                                            <p class="mb-0">Productos Destacados</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-star fa-2x"></i>
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
                                            <h4 class="mb-0">{{ number_format($statistics['in_stock_products']) }}</h4>
                                            <p class="mb-0">En Stock</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-warehouse fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gráficos -->
                    <div class="row">
                        <!-- Gráfico de categorías -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-chart-pie"></i>
                                        Productos por Categoría
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="categoryChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfico de condiciones -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-chart-doughnut"></i>
                                        Productos por Condición
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="conditionChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tablas de estadísticas -->
                    <div class="row mt-4">
                        <!-- Tabla de categorías -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-list"></i>
                                        Distribución por Categoría
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Categoría</th>
                                                    <th class="text-end">Cantidad</th>
                                                    <th class="text-end">Porcentaje</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($categoryStats as $stat)
                                                <tr>
                                                    <td>{{ $stat->category }}</td>
                                                    <td class="text-end">{{ number_format($stat->count) }}</td>
                                                    <td class="text-end">
                                                        {{ $statistics['total_products'] > 0 ? number_format(($stat->count / $statistics['total_products']) * 100, 1) : 0 }}%
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de condiciones -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-list"></i>
                                        Distribución por Condición
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Condición</th>
                                                    <th class="text-end">Cantidad</th>
                                                    <th class="text-end">Porcentaje</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($conditionStats as $stat)
                                                <tr>
                                                    <td>
                                                        @switch($stat->condition)
                                                            @case('new')
                                                                <span class="badge bg-success">Nuevo</span>
                                                                @break
                                                            @case('like_new')
                                                                <span class="badge bg-primary">Como Nuevo</span>
                                                                @break
                                                            @case('good')
                                                                <span class="badge bg-info">Bueno</span>
                                                                @break
                                                            @case('fair')
                                                                <span class="badge bg-warning">Regular</span>
                                                                @break
                                                            @case('poor')
                                                                <span class="badge bg-secondary">Malo</span>
                                                                @break
                                                            @default
                                                                {{ $stat->condition }}
                                                        @endswitch
                                                    </td>
                                                    <td class="text-end">{{ number_format($stat->count) }}</td>
                                                    <td class="text-end">
                                                        {{ $statistics['total_products'] > 0 ? number_format(($stat->count / $statistics['total_products']) * 100, 1) : 0 }}%
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

                    <!-- Resumen adicional -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-info-circle"></i>
                                        Resumen General
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-primary">{{ number_format($statistics['digital_products']) }}</h4>
                                                <p class="text-muted">Productos Digitales</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-success">{{ number_format($statistics['physical_products']) }}</h4>
                                                <p class="text-muted">Productos Físicos</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-warning">{{ number_format($statistics['out_of_stock_products']) }}</h4>
                                                <p class="text-muted">Sin Stock</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-info">{{ number_format($statistics['total_products'] - $statistics['active_products']) }}</h4>
                                                <p class="text-muted">Inactivos</p>
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
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfico de categorías
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
const categoryChart = new Chart(categoryCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($categoryStats->pluck('category')) !!},
        datasets: [{
            data: {!! json_encode($categoryStats->pluck('count')) !!},
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF',
                '#FF9F40',
                '#FF6384',
                '#C9CBCF'
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

// Gráfico de condiciones
const conditionCtx = document.getElementById('conditionChart').getContext('2d');
const conditionChart = new Chart(conditionCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($conditionStats->pluck('condition')->map(function($condition) {
            $conditions = [
                'new' => 'Nuevo',
                'like_new' => 'Como Nuevo',
                'good' => 'Bueno',
                'fair' => 'Regular',
                'poor' => 'Malo'
            ];
            return $conditions[$condition] ?? $condition;
        })) !!},
        datasets: [{
            data: {!! json_encode($conditionStats->pluck('count')) !!},
            backgroundColor: [
                '#28a745', // Nuevo - Verde
                '#007bff', // Como Nuevo - Azul
                '#17a2b8', // Bueno - Info
                '#ffc107', // Regular - Amarillo
                '#6c757d'  // Malo - Gris
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
</script>
@endsection

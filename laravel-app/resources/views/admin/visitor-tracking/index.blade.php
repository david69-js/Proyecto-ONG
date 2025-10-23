@extends('layouts.app')

@section('title', 'Visitor Tracking - Estadísticas de Visitantes')

@section('header', 'Visitor Tracking')

@section('content')
<div class="row">
    <!-- Estadísticas Generales -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title" id="total-visitors">-</h4>
                        <p class="card-text">Visitantes Únicos</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title" id="total-page-views">-</h4>
                        <p class="card-text">Páginas Vistas</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-eye fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title" id="active-visitors">-</h4>
                        <p class="card-text">Visitantes Activos</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title" id="avg-time-spent">-</h4>
                        <p class="card-text">Tiempo Promedio</p>
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
    <!-- Gráfico de Visitantes por Día -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Visitantes por Día (Últimos 7 días)</h5>
            </div>
            <div class="card-body">
                <canvas id="visitorsChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Visitantes Activos en Tiempo Real -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Visitantes Activos</h5>
                <span class="badge bg-success" id="active-count">0</span>
            </div>
            <div class="card-body">
                <div id="active-visitors-list" style="max-height: 300px; overflow-y: auto;">
                    <div class="text-center text-muted">
                        <i class="fas fa-spinner fa-spin"></i> Cargando...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Páginas Más Visitadas -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Páginas Más Visitadas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Página</th>
                                <th>Visitas</th>
                                <th>Tiempo Prom.</th>
                            </tr>
                        </thead>
                        <tbody id="top-pages-table">
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    <i class="fas fa-spinner fa-spin"></i> Cargando...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas de Dispositivos -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Dispositivos y Navegadores</h5>
            </div>
            <div class="card-body">
                <canvas id="deviceChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Estadísticas Geográficas -->
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Estadísticas Geográficas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>País</th>
                                <th>Ciudad</th>
                                <th>Visitantes</th>
                                <th>Páginas Vistas</th>
                            </tr>
                        </thead>
                        <tbody id="geographic-table">
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    <i class="fas fa-spinner fa-spin"></i> Cargando...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Filtros</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="days-filter" class="form-label">Período (días)</label>
                        <select class="form-select" id="days-filter">
                            <option value="1">Último día</option>
                            <option value="7" selected>Últimos 7 días</option>
                            <option value="30">Últimos 30 días</option>
                            <option value="90">Últimos 90 días</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="active-minutes-filter" class="form-label">Visitantes activos (minutos)</label>
                        <select class="form-select" id="active-minutes-filter">
                            <option value="1">Último minuto</option>
                            <option value="5" selected>Últimos 5 minutos</option>
                            <option value="15">Últimos 15 minutos</option>
                            <option value="30">Últimos 30 minutos</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary" onclick="refreshData()">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="auto-refresh" checked>
                            <label class="form-check-label" for="auto-refresh">
                                Auto-actualizar
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
let visitorsChart, deviceChart;
let autoRefreshInterval;

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    loadInitialData();
    setupAutoRefresh();
});

// Cargar datos iniciales
async function loadInitialData() {
    await Promise.all([
        loadStats(),
        loadActiveVisitors(),
        loadTopPages(),
        loadGeographicStats(),
        loadDeviceStats()
    ]);
}

// Cargar estadísticas generales
async function loadStats() {
    try {
        const days = document.getElementById('days-filter').value;
        const response = await fetch(`/api/visitor-tracking/stats?days=${days}`);
        const data = await response.json();
        
        if (data.success) {
            updateStatsCards(data.data);
            updateVisitorsChart(data.data);
        }
    } catch (error) {
        console.error('Error cargando estadísticas:', error);
    }
}

// Actualizar tarjetas de estadísticas
function updateStatsCards(stats) {
    const totalVisitors = stats.reduce((sum, day) => sum + day.unique_visitors, 0);
    const totalPageViews = stats.reduce((sum, day) => sum + day.total_page_views, 0);
    const avgTimeSpent = stats.reduce((sum, day) => sum + day.avg_time_spent, 0) / stats.length;
    
    document.getElementById('total-visitors').textContent = totalVisitors.toLocaleString();
    document.getElementById('total-page-views').textContent = totalPageViews.toLocaleString();
    document.getElementById('avg-time-spent').textContent = formatTime(Math.round(avgTimeSpent));
}

// Cargar visitantes activos
async function loadActiveVisitors() {
    try {
        const minutes = document.getElementById('active-minutes-filter').value;
        const response = await fetch(`/api/visitor-tracking/active-visitors?minutes=${minutes}`);
        const data = await response.json();
        
        if (data.success) {
            updateActiveVisitors(data.data, data.count);
        }
    } catch (error) {
        console.error('Error cargando visitantes activos:', error);
    }
}

// Actualizar lista de visitantes activos
function updateActiveVisitors(visitors, count) {
    document.getElementById('active-count').textContent = count;
    
    const container = document.getElementById('active-visitors-list');
    
    if (count === 0) {
        container.innerHTML = '<div class="text-center text-muted">No hay visitantes activos</div>';
        return;
    }
    
    let html = '';
    Object.values(visitors).forEach(session => {
        const visit = session[0]; // Tomar la primera visita de la sesión
        const timeSpent = visit.time_spent || 0;
        
        html += `
            <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                <div>
                    <small class="text-muted">${visit.ip_address}</small><br>
                    <small>${visit.page_title || visit.page_url}</small>
                </div>
                <div class="text-end">
                    <small class="text-success">${formatTime(timeSpent)}</small><br>
                    <small class="text-muted">${formatDevice(visit.device_type)}</small>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

// Cargar páginas más visitadas
async function loadTopPages() {
    try {
        const response = await fetch('/api/visitor-tracking/top-pages?limit=10');
        const data = await response.json();
        
        if (data.success) {
            updateTopPagesTable(data.data);
        }
    } catch (error) {
        console.error('Error cargando páginas top:', error);
    }
}

// Actualizar tabla de páginas más visitadas
function updateTopPagesTable(pages) {
    const tbody = document.getElementById('top-pages-table');
    
    if (pages.length === 0) {
        tbody.innerHTML = '<tr><td colspan="3" class="text-center text-muted">No hay datos</td></tr>';
        return;
    }
    
    let html = '';
    pages.forEach(page => {
        html += `
            <tr>
                <td>
                    <small>${page.page_title || page.page_url}</small>
                </td>
                <td>
                    <span class="badge bg-primary">${page.visits}</span>
                </td>
                <td>
                    <small>${formatTime(Math.round(page.avg_time_spent))}</small>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

// Cargar estadísticas geográficas
async function loadGeographicStats() {
    try {
        const response = await fetch('/api/visitor-tracking/geographic-stats');
        const data = await response.json();
        
        if (data.success) {
            updateGeographicTable(data.data);
        }
    } catch (error) {
        console.error('Error cargando estadísticas geográficas:', error);
    }
}

// Actualizar tabla geográfica
function updateGeographicTable(stats) {
    const tbody = document.getElementById('geographic-table');
    
    if (stats.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">No hay datos geográficos</td></tr>';
        return;
    }
    
    let html = '';
    stats.forEach(stat => {
        html += `
            <tr>
                <td>${stat.country || 'Desconocido'}</td>
                <td>${stat.city || 'Desconocido'}</td>
                <td>${stat.visitors}</td>
                <td>${stat.page_views}</td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

// Cargar estadísticas de dispositivos
async function loadDeviceStats() {
    try {
        const response = await fetch('/api/visitor-tracking/device-stats');
        const data = await response.json();
        
        if (data.success) {
            updateDeviceChart(data.data);
        }
    } catch (error) {
        console.error('Error cargando estadísticas de dispositivos:', error);
    }
}

// Actualizar gráfico de dispositivos
function updateDeviceChart(stats) {
    const ctx = document.getElementById('deviceChart').getContext('2d');
    
    if (deviceChart) {
        deviceChart.destroy();
    }
    
    const deviceData = {};
    const browserData = {};
    
    stats.forEach(stat => {
        deviceData[stat.device_type] = (deviceData[stat.device_type] || 0) + stat.visitors;
        browserData[stat.browser] = (browserData[stat.browser] || 0) + stat.visitors;
    });
    
    deviceChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(deviceData),
            datasets: [{
                data: Object.values(deviceData),
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Distribución de Dispositivos'
                }
            }
        }
    });
}

// Actualizar gráfico de visitantes
function updateVisitorsChart(stats) {
    const ctx = document.getElementById('visitorsChart').getContext('2d');
    
    if (visitorsChart) {
        visitorsChart.destroy();
    }
    
    const labels = stats.map(stat => {
        const date = new Date(stat.date);
        return date.toLocaleDateString('es-ES', { month: 'short', day: 'numeric' });
    });
    
    const visitors = stats.map(stat => stat.unique_visitors);
    const pageViews = stats.map(stat => stat.total_page_views);
    
    visitorsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Visitantes Únicos',
                data: visitors,
                borderColor: '#36A2EB',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.4
            }, {
                label: 'Páginas Vistas',
                data: pageViews,
                borderColor: '#FF6384',
                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                tension: 0.4,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });
}

// Configurar auto-actualización
function setupAutoRefresh() {
    const autoRefreshCheckbox = document.getElementById('auto-refresh');
    
    autoRefreshCheckbox.addEventListener('change', function() {
        if (this.checked) {
            startAutoRefresh();
        } else {
            stopAutoRefresh();
        }
    });
    
    if (autoRefreshCheckbox.checked) {
        startAutoRefresh();
    }
}

// Iniciar auto-actualización
function startAutoRefresh() {
    stopAutoRefresh(); // Limpiar intervalo anterior
    autoRefreshInterval = setInterval(() => {
        loadActiveVisitors(); // Solo actualizar visitantes activos
    }, 30000); // Cada 30 segundos
}

// Detener auto-actualización
function stopAutoRefresh() {
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
        autoRefreshInterval = null;
    }
}

// Actualizar datos manualmente
function refreshData() {
    loadInitialData();
}

// Funciones de utilidad
function formatTime(seconds) {
    if (seconds < 60) {
        return `${seconds}s`;
    } else if (seconds < 3600) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${minutes}m ${remainingSeconds}s`;
    } else {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        return `${hours}h ${minutes}m`;
    }
}

function formatDevice(deviceType) {
    const devices = {
        'desktop': '🖥️ Desktop',
        'mobile': '📱 Móvil',
        'tablet': '📱 Tablet'
    };
    return devices[deviceType] || '❓ Desconocido';
}

// Event listeners para filtros
document.getElementById('days-filter').addEventListener('change', loadStats);
document.getElementById('active-minutes-filter').addEventListener('change', loadActiveVisitors);
</script>
@endpush

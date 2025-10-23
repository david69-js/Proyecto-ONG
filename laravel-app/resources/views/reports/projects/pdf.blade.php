<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Proyectos - {{ now()->format('d/m/Y') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
        }
        
        .logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 15px;
        }
        
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin: 10px 0;
        }
        
        .subtitle {
            font-size: 16px;
            color: #666;
            margin: 5px 0;
        }
        
        .date {
            font-size: 14px;
            color: #888;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .stats-row {
            display: table-row;
        }
        
        .stats-cell {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }
        
        .stats-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        
        .stats-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .table th,
        .table td {
            padding: 8px 12px;
            text-align: left;
            border: 1px solid #dee2e6;
        }
        
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }
        
        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 3px;
        }
        
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        
        .badge-primary {
            background-color: #007bff;
            color: white;
        }
        
        .badge-info {
            background-color: #17a2b8;
            color: white;
        }
        
        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }
        
        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="{{ public_path('assets/img/logo_habitat.jpeg') }}" alt="Logo" class="logo">
        <div class="title">Reporte de Proyectos</div>
        <div class="subtitle">Sistema de Gestión de ONG</div>
        <div class="date">Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="section">
        <div class="section-title">Estadísticas Generales</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">
                    <div class="stats-number">{{ $totalProjects }}</div>
                    <div class="stats-label">Total Proyectos</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-number">{{ $activeProjects }}</div>
                    <div class="stats-label">Proyectos Activos</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-number">{{ $completedProjects }}</div>
                    <div class="stats-label">Completados</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-number">Q{{ number_format($totalBudget, 2) }}</div>
                    <div class="stats-label">Presupuesto Total</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Financiera -->
    <div class="section">
        <div class="section-title">Información Financiera</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">
                    <div class="stats-number">Q{{ number_format($totalBudget, 2) }}</div>
                    <div class="stats-label">Presupuesto Total</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-number">Q{{ number_format($totalAssigned, 2) }}</div>
                    <div class="stats-label">Fondos Asignados</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-number">Q{{ number_format($totalExecuted, 2) }}</div>
                    <div class="stats-label">Fondos Ejecutados</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-number">{{ $totalBudget > 0 ? round(($totalExecuted / $totalBudget) * 100, 1) : 0 }}%</div>
                    <div class="stats-label">% Ejecutado</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Proyectos -->
    <div class="section">
        <div class="section-title">Lista de Proyectos</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Proyecto</th>
                    <th>Estado</th>
                    <th>Fase</th>
                    <th>Presupuesto</th>
                    <th>Fondos Asignados</th>
                    <th>Fondos Ejecutados</th>
                    <th>Fecha Inicio</th>
                    <th>Responsable</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>
                        <strong>{{ $project->nombre }}</strong><br>
                        <small>{{ Str::limit($project->descripcion, 50) }}</small>
                    </td>
                    <td>
                        <span class="badge badge-{{ $project->estado === 'en_progreso' ? 'success' : ($project->estado === 'finalizado' ? 'primary' : ($project->estado === 'planificado' ? 'info' : 'warning')) }}">
                            {{ ucfirst(str_replace('_', ' ', $project->estado)) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-secondary">
                            {{ ucfirst(str_replace('_', ' ', $project->fase)) }}
                        </span>
                    </td>
                    <td class="text-right">Q{{ number_format($project->presupuesto_total, 2) }}</td>
                    <td class="text-right">Q{{ number_format($project->fondos_asignados, 2) }}</td>
                    <td class="text-right">Q{{ number_format($project->fondos_ejecutados, 2) }}</td>
                    <td>{{ $project->fecha_inicio ? \Carbon\Carbon::parse($project->fecha_inicio)->format('d/m/Y') : 'N/A' }}</td>
                    <td>{{ $project->responsable ? $project->responsable->full_name : 'No asignado' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Resumen por Estado -->
    <div class="section">
        <div class="section-title">Resumen por Estado</div>
        @php
            $statusCounts = $projects->groupBy('estado')->map->count();
        @endphp
        <table class="table">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                    <th>Presupuesto Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statusCounts as $status => $count)
                <tr>
                    <td>
                        <span class="badge badge-{{ $status === 'en_progreso' ? 'success' : ($status === 'finalizado' ? 'primary' : ($status === 'planificado' ? 'info' : 'warning')) }}">
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </span>
                    </td>
                    <td class="text-center">{{ $count }}</td>
                    <td class="text-center">{{ $totalProjects > 0 ? round(($count / $totalProjects) * 100, 1) : 0 }}%</td>
                    <td class="text-right">Q{{ number_format($projects->where('estado', $status)->sum('presupuesto_total'), 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Resumen por Fase -->
    <div class="section">
        <div class="section-title">Resumen por Fase</div>
        @php
            $phaseCounts = $projects->groupBy('fase')->map->count();
        @endphp
        <table class="table">
            <thead>
                <tr>
                    <th>Fase</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                    <th>Presupuesto Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($phaseCounts as $phase => $count)
                <tr>
                    <td>
                        <span class="badge badge-secondary">
                            {{ ucfirst(str_replace('_', ' ', $phase)) }}
                        </span>
                    </td>
                    <td class="text-center">{{ $count }}</td>
                    <td class="text-center">{{ $totalProjects > 0 ? round(($count / $totalProjects) * 100, 1) : 0 }}%</td>
                    <td class="text-right">Q{{ number_format($projects->where('fase', $phase)->sum('presupuesto_total'), 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Este reporte fue generado automáticamente por el Sistema de Gestión de ONG</p>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>

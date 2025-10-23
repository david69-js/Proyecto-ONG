<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Proyecto - {{ $project->nombre }}</title>
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
        
        .project-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .project-title {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        
        .project-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            line-height: 1.6;
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
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-cell {
            display: table-cell;
            width: 50%;
            padding: 15px;
            vertical-align: top;
            border: 1px solid #dee2e6;
        }
        
        .info-label {
            font-weight: bold;
            color: #495057;
            margin-bottom: 5px;
        }
        
        .info-value {
            color: #666;
            margin-bottom: 10px;
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
        
        .progress-bar {
            background-color: #007bff;
            height: 20px;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
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
        <div class="title">Reporte de Proyecto</div>
        <div class="subtitle">{{ $project->nombre }}</div>
        <div class="date">Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <!-- Información del Proyecto -->
    <div class="section">
        <div class="project-info">
            <div class="project-title">{{ $project->nombre }}</div>
            <div class="project-description">{{ $project->descripcion }}</div>
            
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Objetivo:</div>
                        <div class="info-value">{{ $project->objetivo }}</div>
                        
                        <div class="info-label">Resultados Esperados:</div>
                        <div class="info-value">{{ $project->resultados_esperados }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Estado:</div>
                        <div class="info-value">
                            <span class="badge badge-{{ $project->estado === 'en_progreso' ? 'success' : ($project->estado === 'finalizado' ? 'primary' : ($project->estado === 'planificado' ? 'info' : 'warning')) }}">
                                {{ ucfirst(str_replace('_', ' ', $project->estado)) }}
                            </span>
                        </div>
                        
                        <div class="info-label">Fase Actual:</div>
                        <div class="info-value">
                            <span class="badge badge-secondary">
                                {{ ucfirst(str_replace('_', ' ', $project->fase)) }}
                            </span>
                        </div>
                        
                        <div class="info-label">Progreso:</div>
                        <div class="info-value">
                            <div class="progress-bar" style="width: {{ $progress }}%;">
                                {{ $progress }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas del Proyecto -->
    <div class="section">
        <div class="section-title">Estadísticas del Proyecto</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">
                    <div class="stats-number">{{ $beneficiariesCount }}</div>
                    <div class="stats-label">Beneficiarios</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-number">{{ $donationsCount }}</div>
                    <div class="stats-label">Donaciones</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-number">Q{{ number_format($donationsAmount, 2) }}</div>
                    <div class="stats-label">Monto Donado</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-number">{{ $progress }}%</div>
                    <div class="stats-label">Progreso</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Financiera -->
    <div class="section">
        <div class="section-title">Información Financiera</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell">
                    <div class="info-label">Presupuesto Total:</div>
                    <div class="info-value">Q{{ number_format($project->presupuesto_total, 2) }}</div>
                    
                    <div class="info-label">Fondos Asignados:</div>
                    <div class="info-value">Q{{ number_format($project->fondos_asignados, 2) }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Fondos Ejecutados:</div>
                    <div class="info-value">Q{{ number_format($project->fondos_ejecutados, 2) }}</div>
                    
                    <div class="info-label">% de Ejecución:</div>
                    <div class="info-value">
                        @if($project->presupuesto_total > 0)
                            {{ round(($project->fondos_ejecutados / $project->presupuesto_total) * 100, 1) }}%
                        @else
                            N/A
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información de Fechas y Ubicación -->
    <div class="section">
        <div class="section-title">Información de Fechas y Ubicación</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell">
                    <div class="info-label">Fecha de Inicio:</div>
                    <div class="info-value">
                        @if($startDate)
                            {{ $startDate->format('d/m/Y') }}
                        @else
                            No definida
                        @endif
                    </div>
                    
                    <div class="info-label">Fecha de Fin:</div>
                    <div class="info-value">
                        @if($endDate)
                            {{ $endDate->format('d/m/Y') }}
                        @else
                            No definida
                        @endif
                    </div>
                    
                    @if($duration)
                    <div class="info-label">Duración:</div>
                    <div class="info-value">{{ $duration }} días</div>
                    @endif
                </div>
                <div class="info-cell">
                    <div class="info-label">Ubicación:</div>
                    <div class="info-value">
                        @if($project->ubicacion)
                            {{ $project->ubicacion }}
                        @else
                            No especificada
                        @endif
                    </div>
                    
                    <div class="info-label">Responsable:</div>
                    <div class="info-value">
                        @if($project->responsable)
                            {{ $project->responsable->full_name }}
                        @else
                            No asignado
                        @endif
                    </div>
                    
                    <div class="info-label">Fecha de Creación:</div>
                    <div class="info-value">{{ $project->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>

    @if($project->resultados_obtenidos)
    <!-- Resultados Obtenidos -->
    <div class="section">
        <div class="section-title">Resultados Obtenidos</div>
        <div class="info-value">{{ $project->resultados_obtenidos }}</div>
    </div>
    @endif

    @if($beneficiariesCount > 0)
    <!-- Beneficiarios del Proyecto -->
    <div class="section page-break">
        <div class="section-title">Beneficiarios del Proyecto ({{ $beneficiariesCount }})</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Género</th>
                    <th>Estado</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach($project->beneficiaries as $beneficiary)
                <tr>
                    <td>
                        <strong>{{ $beneficiary->first_name }} {{ $beneficiary->last_name }}</strong><br>
                        <small>{{ $beneficiary->email ?? 'Sin email' }}</small>
                    </td>
                    <td class="text-center">{{ $beneficiary->age ?? 'N/A' }} años</td>
                    <td class="text-center">
                        <span class="badge badge-{{ $beneficiary->gender === 'male' ? 'primary' : 'info' }}">
                            {{ $beneficiary->gender === 'male' ? 'Masculino' : 'Femenino' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-{{ $beneficiary->is_active ? 'success' : 'secondary' }}">
                            {{ $beneficiary->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="text-center">{{ $beneficiary->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Este reporte fue generado automáticamente por el Sistema de Gestión de ONG</p>
        <p>Proyecto: {{ $project->nombre }} | Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>

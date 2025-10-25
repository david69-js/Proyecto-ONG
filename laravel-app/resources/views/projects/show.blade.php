@extends('layouts.tabler')

@section('page-title', 'Detalles del Proyecto')
@section('page-description', 'Información completa del proyecto')

@section('content')
<div class="container-fluid">
    <h3>Detalles del Proyecto</h3>

    <div class="card">
        <div class="card-body">
            <h4>{{ $project->nombre }}</h4>
            <p>{{ $project->descripcion ?? 'Sin descripción' }}</p>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Estado:</strong> 
                        <span class="badge bg-primary">{{ ucfirst($project->estado) }}</span>
                    </p>
                    <p><strong>Fase Actual:</strong> 
                        @if($project->fase)
                            <span class="badge bg-success">{{ \App\Models\Project::PHASES[$project->fase]['name'] ?? ucfirst($project->fase) }}</span>
                        @else
                            <span class="text-muted">Sin fase definida</span>
                        @endif
                    </p>
                    <p><strong>Progreso:</strong> 
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: {{ $project->porcentaje ?? 0 }}%"
                                 aria-valuenow="{{ $project->porcentaje ?? 0 }}" 
                                 aria-valuemin="0" aria-valuemax="100">
                                {{ $project->porcentaje ?? 0 }}%
                            </div>
                        </div>
                    </p>
                    <p><strong>Responsable:</strong> 
                        {{ $project->responsable?->first_name }} {{ $project->responsable?->last_name ?? '' }}
                    </p>
                    <p><strong>Ubicación:</strong> {{ $project->ubicacion ?? 'No definida' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Fecha Inicio:</strong> {{ $project->fecha_inicio }}</p>
                    <p><strong>Fecha Fin:</strong> {{ $project->fecha_fin ?? 'No definida' }}</p>
                    <p><strong>Presupuesto:</strong> 
                        Q.{{ $project->presupuesto_total ? number_format($project->presupuesto_total, 2) : '0.00' }}
                    </p>
                </div>
            </div>

            @if($project->phaseImages->count() > 0)
            <div class="mt-4">
                <h5>Imágenes por Fase</h5>
                
                <!-- Selector de fase para ver imágenes -->
                <div class="mb-3">
                    <label for="view-phase-select" class="form-label">Seleccionar Fase para Ver Imágenes</label>
                    <select class="form-select" id="view-phase-select">
                        <option value="">-- Todas las fases --</option>
                        @foreach(\App\Models\Project::PHASES as $key => $phase)
                            <option value="{{ $key }}">
                                {{ $phase['name'] }} ({{ $phase['percentage'] }}%)
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Contenedor de imágenes -->
                <div id="images-container">
                    <div class="row" id="all-images">
                        @foreach($project->phaseImages as $image)
                            <div class="col-md-3 mb-3 phase-image" data-phase="{{ $image->fase }}">
                                <div class="card">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             class="card-img-top" 
                                             style="height: 200px; object-fit: cover; image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;"
                                             alt="{{ $image->original_name }}"
                                             loading="lazy">
                                        @can('update', $project)
                                        <button type="button" 
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 delete-image-btn"
                                                data-image-id="{{ $image->id }}"
                                                data-image-name="{{ $image->original_name }}"
                                                title="Eliminar imagen">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @endcan
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $image->original_name }}</h6>
                                        <span class="badge bg-primary mb-2">
                                            {{ \App\Models\Project::PHASES[$image->fase]['name'] ?? ucfirst($image->fase) }}
                                        </span>
                                        @if($image->description)
                                            <p class="card-text">{{ $image->description }}</p>
                                        @endif
                                        <small class="text-muted">
                                            {{ $image->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const phaseSelect = document.getElementById('view-phase-select');
                const allImages = document.querySelectorAll('.phase-image');
                
                phaseSelect.addEventListener('change', function() {
                    const selectedPhase = this.value;
                    
                    allImages.forEach(function(imageDiv) {
                        if (selectedPhase === '' || imageDiv.getAttribute('data-phase') === selectedPhase) {
                            imageDiv.style.display = 'block';
                        } else {
                            imageDiv.style.display = 'none';
                        }
                    });
                });

                // Manejar eliminación de imágenes
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.delete-image-btn')) {
                        const button = e.target.closest('.delete-image-btn');
                        const imageId = button.getAttribute('data-image-id');
                        const imageName = button.getAttribute('data-image-name');
                        
                        if (confirm(`¿Estás seguro de que quieres eliminar la imagen "${imageName}"?`)) {
                            fetch(`/projects/phase-images/${imageId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json',
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Eliminar el elemento de la vista
                                    const imageContainer = button.closest('.phase-image');
                                    imageContainer.remove();
                                    
                                    // Mostrar mensaje de éxito
                                    const alert = document.createElement('div');
                                    alert.className = 'alert alert-success alert-dismissible fade show';
                                    alert.innerHTML = `
                                        ${data.message}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    `;
                                    document.querySelector('.card-body').insertBefore(alert, document.querySelector('.card-body').firstChild);
                                    
                                    // Auto-ocultar después de 3 segundos
                                    setTimeout(() => {
                                        alert.remove();
                                    }, 3000);
                                } else {
                                    alert('Error al eliminar la imagen');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Error al eliminar la imagen');
                            });
                        }
                    }
                });
            });
            </script>

            <style>
            .card-img-top {
                image-rendering: -webkit-optimize-contrast;
                image-rendering: crisp-edges;
                image-rendering: pixelated;
                -ms-interpolation-mode: nearest-neighbor;
                transition: transform 0.3s ease;
            }
            
            .card-img-top:hover {
                transform: scale(1.05);
                z-index: 10;
                position: relative;
            }
            
            .card {
                overflow: hidden;
            }
            
            .phase-image .card {
                transition: box-shadow 0.3s ease;
            }
            
            .phase-image .card:hover {
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            }
            </style>

            <div class="mt-3">
                <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection

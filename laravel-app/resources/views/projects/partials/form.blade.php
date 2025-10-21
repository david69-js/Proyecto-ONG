<div class="row">
    <div class="col-md-6">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" 
               value="{{ old('nombre', $project->nombre ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="estado" class="form-label">Estado</label>
        <select name="estado" class="form-select">
            @foreach(['planificado','en_progreso','pausado','finalizado','cancelado'] as $estado)
                <option value="{{ $estado }}" 
                        {{ old('estado', $project->estado ?? '') == $estado ? 'selected' : '' }}>
                    {{ ucfirst($estado) }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea name="descripcion" class="form-control">{{ old('descripcion', $project->descripcion ?? '') }}</textarea>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
        <input type="date" name="fecha_inicio" class="form-control" 
               value="{{ old('fecha_inicio', $project->fecha_inicio ?? '') }}">
    </div>
    <div class="col-md-6">
        <label for="fecha_fin" class="form-label">Fecha Fin</label>
        <input type="date" name="fecha_fin" class="form-control" 
               value="{{ old('fecha_fin', $project->fecha_fin ?? '') }}">
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <label for="presupuesto_total" class="form-label">Presupuesto Total</label>
        <input type="number" step="0.01" name="presupuesto_total" class="form-control" 
               value="{{ old('presupuesto_total', $project->presupuesto_total ?? '') }}">
    </div>
    <div class="col-md-6">
        <label for="responsable_id" class="form-label">Responsable</label>
        <select name="responsable_id" class="form-select">
            <option value="">-- Seleccione --</option>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}" 
                        {{ old('responsable_id', $project->responsable_id ?? '') == $usuario->id ? 'selected' : '' }}>
                    {{ $usuario->first_name }} {{ $usuario->last_name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <label for="fase" class="form-label">Fase del Proyecto</label>
        <select name="fase" class="form-select" id="fase-select" required>
            <option value="">-- Seleccione una fase --</option>
            @foreach(\App\Models\Project::PHASES as $key => $phase)
                <option value="{{ $key }}" 
                        data-percentage="{{ $phase['percentage'] }}"
                        {{ old('fase', $project->fase ?? '') == $key ? 'selected' : '' }}>
                    {{ $phase['name'] }} ({{ $phase['percentage'] }}%)
                </option>
            @endforeach
        </select>
        <small class="form-text text-muted">El porcentaje de avance se actualiza automáticamente según la fase seleccionada</small>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <label class="form-label">Imágenes por Fase</label>
        
        <!-- Contenedor para múltiples fases -->
        <div id="phases-container">
            <div class="phase-upload-group mb-4" data-phase-index="0">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Fase 1</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-phase-btn" style="display: none;">
                            <i class="fas fa-times"></i> Eliminar Fase
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Seleccionar Fase</label>
                                <select name="phase_images_data[0][phase]" class="form-select phase-select" required>
                                    <option value="">-- Seleccione una fase --</option>
                                    @foreach(\App\Models\Project::PHASES as $key => $phase)
                                        <option value="{{ $key }}">
                                            {{ $phase['name'] }} ({{ $phase['percentage'] }}%)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Imágenes</label>
                                <input type="file" name="phase_images_data[0][images][]" class="form-control phase-images-input" multiple 
                                       accept="image/*">
                            </div>
                        </div>
                        <div class="phase-preview-container mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mb-3">
            <button type="button" class="btn btn-outline-primary" id="add-phase-btn">
                <i class="fas fa-plus"></i> Agregar Otra Fase
            </button>
            <small class="form-text text-muted d-block mt-2">
                Puedes subir imágenes para múltiples fases. Cada fase puede tener múltiples imágenes (máximo 2MB cada una).
            </small>
        </div>
        
        <div id="image-preview-container" class="row">
            <!-- Las imágenes se mostrarán aquí -->
            @if(isset($project) && $project->phaseImages->count() > 0)
                @foreach($project->phaseImages as $image)
                    <div class="col-md-3 mb-3 existing-image" data-image-id="{{ $image->id }}">
                        <div class="card">
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     class="card-img-top" 
                                     style="height: 150px; object-fit: cover;"
                                     alt="{{ $image->original_name }}">
                                <button type="button" 
                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 delete-image-btn"
                                        data-image-id="{{ $image->id }}"
                                        data-image-name="{{ $image->original_name }}"
                                        title="Eliminar imagen">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title">{{ $image->original_name }}</h6>
                                <span class="badge bg-primary mb-2">
                                    {{ \App\Models\Project::PHASES[$image->fase]['name'] ?? ucfirst($image->fase) }}
                                </span>
                                @if($image->description)
                                    <p class="card-text small">{{ $image->description }}</p>
                                @endif
                                <small class="text-muted">{{ $image->created_at->format('d/m/Y') }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
        <div id="image-descriptions" style="display: none;">
            <!-- Los campos de descripción se generarán dinámicamente -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const phasesContainer = document.getElementById('phases-container');
    const addPhaseBtn = document.getElementById('add-phase-btn');
    let phaseIndex = 0;

    // Agregar nueva fase
    addPhaseBtn.addEventListener('click', function() {
        phaseIndex++;
        const newPhaseHtml = createPhaseHtml(phaseIndex);
        phasesContainer.insertAdjacentHTML('beforeend', newPhaseHtml);
        updatePhaseNumbers();
        updateRemoveButtons();
    });

    // Eliminar fase
    phasesContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-phase-btn')) {
            const phaseGroup = e.target.closest('.phase-upload-group');
            phaseGroup.remove();
            updatePhaseNumbers();
            updateRemoveButtons();
        }
    });

    // Manejar preview de imágenes para cada fase
    phasesContainer.addEventListener('change', function(e) {
        if (e.target.classList.contains('phase-images-input')) {
            const files = Array.from(e.target.files);
            const phaseSelect = e.target.closest('.phase-upload-group').querySelector('.phase-select');
            const previewContainer = e.target.closest('.phase-upload-group').querySelector('.phase-preview-container');
            const phaseValue = phaseSelect.value;
            
            if (!phaseValue) {
                alert('Por favor selecciona una fase para subir las imágenes');
                return;
            }
            
            previewContainer.innerHTML = '';

            files.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 mb-3';
                        
                        col.innerHTML = `
                            <div class="card">
                                <img src="${e.target.result}" class="card-img-top" style="height: 120px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <small class="text-muted">${file.name}</small>
                                    <div class="badge bg-primary mb-2">${phaseValue}</div>
                                    <textarea name="phase_images_data[${phaseSelect.closest('.phase-upload-group').dataset.phaseIndex}][descriptions][]" 
                                              class="form-control form-control-sm mt-2" 
                                              placeholder="Descripción de la imagen" rows="2"></textarea>
                                </div>
                            </div>
                        `;
                        
                        previewContainer.appendChild(col);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    // Manejar eliminación de imágenes existentes
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
                        const imageContainer = button.closest('.existing-image');
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

    // Funciones auxiliares
    function createPhaseHtml(index) {
        return `
            <div class="phase-upload-group mb-4" data-phase-index="${index}">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Fase ${index + 1}</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-phase-btn">
                            <i class="fas fa-times"></i> Eliminar Fase
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Seleccionar Fase</label>
                                <select name="phase_images_data[${index}][phase]" class="form-select phase-select" required>
                                    <option value="">-- Seleccione una fase --</option>
                                    @foreach(\App\Models\Project::PHASES as $key => $phase)
                                        <option value="{{ $key }}">
                                            {{ $phase['name'] }} ({{ $phase['percentage'] }}%)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Imágenes</label>
                                <input type="file" name="phase_images_data[${index}][images][]" class="form-control phase-images-input" multiple 
                                       accept="image/*">
                            </div>
                        </div>
                        <div class="phase-preview-container mt-3"></div>
                    </div>
                </div>
            </div>
        `;
    }

    function updatePhaseNumbers() {
        const phaseGroups = document.querySelectorAll('.phase-upload-group');
        phaseGroups.forEach((group, index) => {
            group.querySelector('.card-header h6').textContent = `Fase ${index + 1}`;
            group.dataset.phaseIndex = index;
            
            // Actualizar nombres de campos
            const phaseSelect = group.querySelector('.phase-select');
            const imagesInput = group.querySelector('.phase-images-input');
            
            phaseSelect.name = `phase_images_data[${index}][phase]`;
            imagesInput.name = `phase_images_data[${index}][images][]`;
        });
    }

    function updateRemoveButtons() {
        const phaseGroups = document.querySelectorAll('.phase-upload-group');
        phaseGroups.forEach((group, index) => {
            const removeBtn = group.querySelector('.remove-phase-btn');
            if (phaseGroups.length === 1) {
                removeBtn.style.display = 'none';
            } else {
                removeBtn.style.display = 'inline-block';
            }
        });
    }

    // Inicializar
    updateRemoveButtons();
});
</script>

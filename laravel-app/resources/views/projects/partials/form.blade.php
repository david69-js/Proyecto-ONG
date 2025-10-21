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

<!-- Fases del Proyecto -->
<div class="row mt-4">
    <div class="col-12">
        <h5 class="text-primary">Fases del Proyecto</h5>
        <hr>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <label for="fase_actual" class="form-label">Fase Actual</label>
        <select name="fase_actual" class="form-select">
            @foreach(['diagnostico' => 'Diagnóstico', 'formulacion' => 'Formulación', 'financiacion' => 'Financiación', 'ejecucion' => 'Ejecución', 'evaluacion' => 'Evaluación', 'cierre' => 'Cierre'] as $key => $nombre)
                <option value="{{ $key }}" 
                        {{ old('fase_actual', $project->fase_actual ?? 'diagnostico') == $key ? 'selected' : '' }}>
                    {{ $nombre }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-4">
        <label for="porcentaje_diagnostico" class="form-label">Diagnóstico (%)</label>
        <input type="number" name="porcentaje_diagnostico" class="form-control" 
               min="0" max="100" value="{{ old('porcentaje_diagnostico', $project->porcentaje_diagnostico ?? 0) }}">
    </div>
    <div class="col-md-4">
        <label for="porcentaje_formulacion" class="form-label">Formulación (%)</label>
        <input type="number" name="porcentaje_formulacion" class="form-control" 
               min="0" max="100" value="{{ old('porcentaje_formulacion', $project->porcentaje_formulacion ?? 0) }}">
    </div>
    <div class="col-md-4">
        <label for="porcentaje_financiacion" class="form-label">Financiación (%)</label>
        <input type="number" name="porcentaje_financiacion" class="form-control" 
               min="0" max="100" value="{{ old('porcentaje_financiacion', $project->porcentaje_financiacion ?? 0) }}">
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-4">
        <label for="porcentaje_ejecucion" class="form-label">Ejecución (%)</label>
        <input type="number" name="porcentaje_ejecucion" class="form-control" 
               min="0" max="100" value="{{ old('porcentaje_ejecucion', $project->porcentaje_ejecucion ?? 0) }}">
    </div>
    <div class="col-md-4">
        <label for="porcentaje_evaluacion" class="form-label">Evaluación (%)</label>
        <input type="number" name="porcentaje_evaluacion" class="form-control" 
               min="0" max="100" value="{{ old('porcentaje_evaluacion', $project->porcentaje_evaluacion ?? 0) }}">
    </div>
    <div class="col-md-4">
        <label for="porcentaje_cierre" class="form-label">Cierre (%)</label>
        <input type="number" name="porcentaje_cierre" class="form-control" 
               min="0" max="100" value="{{ old('porcentaje_cierre', $project->porcentaje_cierre ?? 0) }}">
    </div>
</div>

<!-- Texto de prueba para verificar que el formulario se renderiza completo -->
<div class="row mt-3">
    <div class="col-12">
        <div class="alert alert-success">
            <strong>¡Formulario completo!</strong> Si ves este mensaje, el formulario se está renderizando correctamente.
        </div>
    </div>
</div>

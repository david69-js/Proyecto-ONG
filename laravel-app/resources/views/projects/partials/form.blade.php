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

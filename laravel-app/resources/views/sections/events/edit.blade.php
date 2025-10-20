@extends('layouts.tabler')

@section('title', 'Editar Evento')
@section('page-title', 'Editar Evento')

@section('content')
<div class="row">
  <div class="col-12 col-lg-10 mx-auto">
    <form class="card" method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-edit me-2"></i> Editar: {{ $event->title }}
        </h3>
      </div>

      <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-danger">
            <strong>Revisa los errores:</strong>
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="row g-3">
          <div class="col-md-8">
            <div class="mb-3">
              <label class="form-label">Título *</label>
              <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                     value="{{ old('title', $event->title) }}" maxlength="255" required>
              @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Descripción</label>
              <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $event->description) }}</textarea>
              @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Tipo *</label>
                <select name="event_type" class="form-select @error('event_type') is-invalid @enderror" required>
                  @php $types = ['fundraising'=>'Recaudación de Fondos','volunteer'=>'Voluntariado','awareness'=>'Concientización','community'=>'Comunitario','training'=>'Capacitación','other'=>'Otro']; @endphp
                  @foreach($types as $val=>$label)
                    <option value="{{ $val }}" @selected(old('event_type', $event->event_type)==$val)>{{ $label }}</option>
                  @endforeach
                </select>
                @error('event_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label">Proyecto</label>
                <select name="project_id" class="form-select @error('project_id') is-invalid @enderror">
                  <option value="">— Sin proyecto —</option>
                  @foreach($projects as $p)
                    <option value="{{ $p->id }}" @selected(old('project_id', $event->project_id)==$p->id)>{{ $p->nombre }}</option>
                  @endforeach
                </select>
                @error('project_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label">Fecha/Hora de inicio *</label>
                <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
                       value="{{ old('start_date', optional($event->start_date)->format('Y-m-d\TH:i')) }}" required>
                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label">Fecha/Hora de fin</label>
                <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
                       value="{{ old('end_date', optional($event->end_date)->format('Y-m-d\TH:i')) }}">
                @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label">Ubicación</label>
                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                       value="{{ old('location', $event->location) }}">
                @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label">Dirección</label>
                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                       value="{{ old('address', $event->address) }}">
                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-4">
                <label class="form-label">Costo</label>
                <input type="number" step="0.01" name="cost" class="form-control @error('cost') is-invalid @enderror"
                       value="{{ old('cost', $event->cost) }}">
                @error('cost') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-4">
                <label class="form-label">Cupo máximo</label>
                <input type="number" name="max_participants" class="form-control @error('max_participants') is-invalid @enderror"
                       value="{{ old('max_participants', $event->max_participants) }}">
                @error('max_participants') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-4">
                <label class="form-label">Estado</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                  @foreach(['draft'=>'Borrador','published'=>'Publicado','cancelled'=>'Cancelado','completed'=>'Completado'] as $val=>$label)
                    <option value="{{ $val }}" @selected(old('status', $event->status)==$val)>{{ $label }}</option>
                  @endforeach
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label">Correo de contacto</label>
                <input type="email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror"
                       value="{{ old('contact_email', $event->contact_email) }}">
                @error('contact_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label">Teléfono de contacto</label>
                <input type="text" name="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror"
                       value="{{ old('contact_phone', $event->contact_phone) }}">
                @error('contact_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-12">
                <label class="form-label">Requisitos</label>
                <textarea name="requirements" rows="3" class="form-control @error('requirements') is-invalid @enderror">{{ old('requirements', $event->requirements) }}</textarea>
                @error('requirements') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="mb-3 form-check">
              <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1"
                     @checked(old('featured', $event->featured))>
              <label class="form-check-label" for="featured">
                Marcar como destacado
              </label>
            </div>

            <div class="mb-3 form-check">
              <input class="form-check-input" type="checkbox" id="registration_required" name="registration_required" value="1"
                     @checked(old('registration_required', $event->registration_required))>
              <label class="form-check-label" for="registration_required">
                Requiere registro
              </label>
            </div>

            <div id="deadlineWrap" class="mb-3" style="{{ old('registration_required', $event->registration_required) ? '' : 'display:none' }}">
              <label class="form-label">Fecha límite de registro</label>
              <input type="datetime-local" name="registration_deadline"
                     class="form-control @error('registration_deadline') is-invalid @enderror"
                     value="{{ old('registration_deadline', optional($event->registration_deadline)->format('Y-m-d\TH:i')) }}">
              @error('registration_deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Imagen</label>
              @if($event->image_path)
                <div class="mb-2">
                  <img src="{{ $event->image_url ?? asset('storage/'.$event->image_path) }}" class="img-fluid rounded" alt="imagen actual">
                </div>
              @endif
              <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
              @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>
        </div>
      </div>

      <div class="card-footer d-flex gap-2">
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Cancelar
        </a>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Guardar cambios
        </button>
      </div>
    </form>
  </div>
</div>

{{-- Toggle visual de deadline --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const chk = document.getElementById('registration_required');
  const wrap = document.getElementById('deadlineWrap');
  if (chk && wrap) {
    chk.addEventListener('change', () => {
      wrap.style.display = chk.checked ? '' : 'none';
    });
  }
});
</script>
@endpush
@endsection

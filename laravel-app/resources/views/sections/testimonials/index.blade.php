@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Testimonios de Beneficiarios</h1>
  </div>

  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Ups:</strong> {{ $errors->first() }}
    </div>
  @endif

  {{-- CREAR NUEVO --}}
  <div class="card mb-4">
    <div class="card-header">Crear nuevo testimonio</div>
    <div class="card-body">
      <form action="{{ route('admin.testimonials.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Beneficiario</label>
            <select name="beneficiary_id" class="form-select" required>
              <option value="">-- Selecciona --</option>
              @foreach($beneficiaries as $b)
                <option value="{{ $b->id }}" @selected(old('beneficiary_id')==$b->id)>{{ $b->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Autor (opcional)</label>
            <input name="author_name" class="form-control" value="{{ old('author_name') }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">Título (opcional)</label>
            <input name="title" class="form-control" value="{{ old('title') }}">
          </div>

          <div class="col-md-12">
            <label class="form-label">Comentario</label>
            <textarea name="body" rows="3" class="form-control" required>{{ old('body') }}</textarea>
          </div>

          <div class="col-md-3">
            <label class="form-label">Rol</label>
            <input name="role" class="form-control" value="{{ old('role') }}" placeholder="Ej: Madre de Familia">
          </div>
          <div class="col-md-3">
            <label class="form-label">Comunidad / Empresa</label>
            <input name="company" class="form-control" value="{{ old('company') }}">
          </div>
          <div class="col-md-2">
            <label class="form-label">Rating (1-5)</label>
            <input type="number" min="1" max="5" name="rating" class="form-control" value="{{ old('rating',5) }}" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Avatar (opcional)</label>
            <input type="file" name="avatar" class="form-control">
          </div>
        </div>

        <div class="mt-3 text-end">
          <button class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>

  {{-- BUSCADOR --}}
  <form method="get" class="mb-3">
    <div class="input-group">
      <input name="search" class="form-control" placeholder="Buscar por texto, autor, comunidad o beneficiario..." value="{{ request('search') }}">
      <button class="btn btn-outline-secondary">Buscar</button>
    </div>
  </form>

  {{-- LISTADO --}}
  <div class="card">
    <div class="card-header">Listado</div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
          <thead>
            <tr>
              <th style="width:60px">ID</th>
              <th>Beneficiario</th>
              <th>Autor</th>
              <th>Rating</th>
              <th>Publicado</th>
              <th>Fecha Pub.</th>
              <th style="width:260px">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($testimonials as $t)
            <tr>
              <td>{{ $t->id }}</td>
              <td>{{ $t->beneficiary?->name }}</td>
              <td>{{ $t->author_name ?? $t->beneficiary?->name }}</td>
              <td>{{ $t->rating }} ⭐</td>
              <td>
                @if($t->is_published)
                  <span class="badge bg-success">Sí</span>
                @else
                  <span class="badge bg-secondary">No</span>
                @endif
              </td>
              <td>{{ $t->published_at?->format('d/m/Y H:i') }}</td>
              <td class="text-end">
                {{-- Publicar / Despublicar --}}
                <form action="{{ route('admin.testimonials.toggle-publish',$t) }}" method="post" class="d-inline">
                  @csrf
                  <button class="btn btn-sm {{ $t->is_published?'btn-warning':'btn-success' }}">
                    {{ $t->is_published ? 'Despublicar' : 'Publicar' }}
                  </button>
                </form>

                {{-- Editar (modal) --}}
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $t->id }}">Editar</button>

                {{-- Eliminar --}}
                <form action="{{ route('admin.testimonials.destroy',$t) }}" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar testimonio #{{ $t->id }}?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                </form>
              </td>
            </tr>

            {{-- MODAL DE EDICIÓN --}}
            <div class="modal fade" id="editModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Editar Testimonio #{{ $t->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                  </div>
                  <form action="{{ route('admin.testimonials.update',$t) }}" method="post" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="modal-body">
                      <div class="row g-3">
                        <div class="col-md-4">
                          <label class="form-label">Beneficiario</label>
                          <select name="beneficiary_id" class="form-select" required>
                            @foreach($beneficiaries as $b)
                              <option value="{{ $b->id }}" @selected(old('beneficiary_id',$t->beneficiary_id)==$b->id)>{{ $b->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Autor (opcional)</label>
                          <input name="author_name" class="form-control" value="{{ old('author_name',$t->author_name) }}">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Título (opcional)</label>
                          <input name="title" class="form-control" value="{{ old('title',$t->title) }}">
                        </div>

                        <div class="col-md-12">
                          <label class="form-label">Comentario</label>
                          <textarea name="body" rows="4" class="form-control" required>{{ old('body',$t->body) }}</textarea>
                        </div>

                        <div class="col-md-3">
                          <label class="form-label">Rol</label>
                          <input name="role" class="form-control" value="{{ old('role',$t->role) }}">
                        </div>
                        <div class="col-md-3">
                          <label class="form-label">Comunidad / Empresa</label>
                          <input name="company" class="form-control" value="{{ old('company',$t->company) }}">
                        </div>
                        <div class="col-md-2">
                          <label class="form-label">Rating (1-5)</label>
                          <input type="number" min="1" max="5" name="rating" class="form-control" value="{{ old('rating',$t->rating) }}" required>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Avatar (opcional)</label>
                          <input type="file" name="avatar" class="form-control">
                          @if($t->avatar_path)
                            <div class="mt-2">
                              <img src="{{ asset('storage/'.$t->avatar_path) }}" alt="avatar" height="60">
                            </div>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <button class="btn btn-primary">Guardar cambios</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            @empty
            <tr>
              <td colspan="7" class="text-center py-4">No hay testimonios.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer">
      {{ $testimonials->links() }}
    </div>
  </div>
</div>
@endsection

@extends('layouts.tabler')

@section('content')
<div class="container-fluid">

  <h1 class="h4 mb-3">Vitrina de Patrocinadores</h1>

  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
  @if($errors->any()) <div class="alert alert-danger">{{ $errors->first() }}</div> @endif

  <div class="card mb-4">
    <div class="card-header">Agregar a vitrina</div>
    <div class="card-body">
      <form action="{{ route('admin.sponsors.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Patrocinador</label>
            <select name="sponsor_id" class="form-select" required>
              <option value="">-- Selecciona --</option>
              @foreach($sponsors as $s)
                <option value="{{ $s->id }}">{{ $s->name ?? ('Sponsor #'.$s->id) }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Título (opcional)</label>
            <input name="title" class="form-control" value="{{ old('title') }}" placeholder="Empresa A">
          </div>
          <div class="col-md-4">
            <label class="form-label">Categoría (opcional)</label>
            <input name="category" class="form-control" value="{{ old('category') }}" placeholder="Gestión de Calidad">
          </div>
          <div class="col-md-12">
            <label class="form-label">Descripción (opcional)</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
          </div>
          <div class="col-md-4">
            <label class="form-label">Logo/Badge (opcional)</label>
            <input type="file" name="logo" class="form-control">
          </div>
          <div class="col-md-2">
            <label class="form-label">Destacado</label>
            <div class="form-check mt-2">
              <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="featured_new">
              <label for="featured_new" class="form-check-label">Mostrar en bloque destacado</label>
            </div>
          </div>
          <div class="col-md-2">
            <label class="form-label">Orden</label>
            <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', 0) }}">
          </div>
        </div>
        <div class="mt-3 text-end">
          <button class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>

  <form method="get" class="mb-3">
    <div class="input-group">
      <input name="search" class="form-control" placeholder="Buscar por título, categoría, descripción o nombre del sponsor..." value="{{ request('search') }}">
      <button class="btn btn-outline-secondary">Buscar</button>
    </div>
  </form>

  <div class="card">
    <div class="card-header">Listado</div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Sponsor</th>
              <th>Título</th>
              <th>Categoría</th>
              <th>Destacado</th>
              <th>Publicado</th>
              <th>Orden</th>
              <th style="width:280px">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($items as $it)
            <tr>
              <td>{{ $it->id }}</td>
              <td>{{ $it->sponsor?->name ?? ('#'.$it->sponsor_id) }}</td>
              <td>{{ $it->title }}</td>
              <td>{{ $it->category }}</td>
              <td>{!! $it->is_featured ? '<span class="badge bg-info">Sí</span>' : '<span class="badge bg-secondary">No</span>' !!}</td>
              <td>{!! $it->is_published ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-secondary">No</span>' !!}</td>
              <td>{{ $it->sort_order }}</td>
              <td class="text-end">
                <form action="{{ route('admin.sponsors.toggle-publish',$it) }}" class="d-inline" method="post">
                  @csrf
                  <button class="btn btn-sm {{ $it->is_published?'btn-warning':'btn-success' }}">
                    {{ $it->is_published ? 'Despublicar' : 'Publicar' }}
                  </button>
                </form>

                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editSponsor{{ $it->id }}">Editar</button>

                <form action="{{ route('admin.sponsors.destroy',$it) }}" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar #{{ $it->id }}?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                </form>
              </td>
            </tr>

            {{-- Modal edición --}}
            <div class="modal fade" id="editSponsor{{ $it->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Editar #{{ $it->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <form action="{{ route('admin.sponsors.update',$it) }}" method="post" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="modal-body">
                      <div class="row g-3">
                        <div class="col-md-4">
                          <label class="form-label">Patrocinador</label>
                          <select name="sponsor_id" class="form-select" required>
                            @foreach($sponsors as $s)
                              <option value="{{ $s->id }}" @selected(old('sponsor_id',$it->sponsor_id)==$s->id)>{{ $s->name ?? ('Sponsor #'.$s->id) }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Título</label>
                          <input name="title" class="form-control" value="{{ old('title',$it->title) }}">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Categoría</label>
                          <input name="category" class="form-control" value="{{ old('category',$it->category) }}">
                        </div>
                        <div class="col-md-12">
                          <label class="form-label">Descripción</label>
                          <textarea name="description" rows="3" class="form-control">{{ old('description',$it->description) }}</textarea>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Logo/Badge</label>
                          <input type="file" name="logo" class="form-control">
                          @if($it->logo_path)
                            <div class="mt-2">
                              <img src="{{ asset('storage/'.$it->logo_path) }}" alt="logo" height="60">
                            </div>
                          @endif
                        </div>
                        <div class="col-md-2">
                          <label class="form-label">Destacado</label>
                          <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="featured_{{ $it->id }}" @checked($it->is_featured)>
                            <label for="featured_{{ $it->id }}" class="form-check-label">Sí</label>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <label class="form-label">Orden</label>
                          <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order',$it->sort_order) }}">
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-primary">Guardar cambios</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            @empty
            <tr>
              <td colspan="8" class="text-center p-4">No hay elementos en la vitrina.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer">
      {{ $items->links() }}
    </div>
  </div>

</div>
@endsection

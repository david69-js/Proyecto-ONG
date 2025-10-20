@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="h4 mb-3">Vitrina de Donadores</h1>

  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
  @if($errors->any()) <div class="alert alert-danger">{{ $errors->first() }}</div> @endif

  {{-- Crear --}}
  <div class="card mb-4">
    <div class="card-header">Agregar a vitrina</div>
    <div class="card-body">
      <form action="{{ route('admin.donors.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Nombre</label>
            <input name="name" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Posición/Cargo</label>
            <input name="position" class="form-control" placeholder="Donador Principal">
          </div>
          <div class="col-md-4">
            <label class="form-label">Badge (ej. 15+ Años Apoyando)</label>
            <input name="badge_text" class="form-control">
          </div>

          <div class="col-md-4">
            <label class="form-label">Email</label>
            <input name="email" type="email" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Teléfono</label>
            <input name="phone" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Avatar</label>
            <input type="file" name="avatar" class="form-control">
          </div>

          <div class="col-md-12">
            <label class="form-label">Bio</label>
            <textarea name="bio" rows="3" class="form-control"></textarea>
          </div>

          <div class="col-md-6">
            <label class="form-label">Skills (coma separadas)</label>
            <input name="skills" class="form-control" placeholder="Educación,Salud">
          </div>
          <div class="col-md-2">
            <label class="form-label">Destacado</label>
            <div class="form-check mt-2">
              <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="featured_new">
              <label for="featured_new" class="form-check-label">Sí</label>
            </div>
          </div>
          <div class="col-md-2">
            <label class="form-label">Orden</label>
            <input type="number" name="sort_order" min="0" class="form-control" value="0">
          </div>

          {{-- Vinculación opcional --}}
          <div class="col-md-4">
            <label class="form-label">Donation (opcional)</label>
            <select name="donation_id" class="form-select">
              <option value="">-- Selecciona --</option>
              @foreach($donations as $d)
                <option value="{{ $d->id }}">#{{ $d->id }} — {{ $d->donation_code ?? $d->id }} ({{ $d->donor_name }})</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Sponsor (opcional)</label>
            <select name="sponsor_id" class="form-select">
              <option value="">-- Selecciona --</option>
              @foreach($sponsors as $s)
                <option value="{{ $s->id }}">{{ $s->name ?? ('#'.$s->id) }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="mt-3 text-end">
          <button class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Buscador --}}
  <form method="get" class="mb-3">
    <div class="input-group">
      <input name="search" class="form-control" placeholder="Buscar por nombre, cargo, bio o skills..." value="{{ request('search') }}">
      <button class="btn btn-outline-secondary">Buscar</button>
    </div>
  </form>

  {{-- Listado --}}
  <div class="card">
    <div class="card-header">Listado</div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Cargo</th>
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
              <td>{{ $it->name }}</td>
              <td>{{ $it->position }}</td>
              <td>{!! $it->is_featured ? '<span class="badge bg-info">Sí</span>' : '<span class="badge bg-secondary">No</span>' !!}</td>
              <td>{!! $it->is_published ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-secondary">No</span>' !!}</td>
              <td>{{ $it->sort_order }}</td>
              <td class="text-end">
                <form action="{{ route('admin.donors.toggle-publish',$it) }}" method="post" class="d-inline">
                  @csrf
                  <button class="btn btn-sm {{ $it->is_published?'btn-warning':'btn-success' }}">
                    {{ $it->is_published ? 'Despublicar' : 'Publicar' }}
                  </button>
                </form>

                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editDonor{{ $it->id }}">Editar</button>

                <form action="{{ route('admin.donors.destroy',$it) }}" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar #{{ $it->id }}?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                </form>
              </td>
            </tr>

            {{-- Modal edición --}}
            <div class="modal fade" id="editDonor{{ $it->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Editar #{{ $it->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <form action="{{ route('admin.donors.update',$it) }}" method="post" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="modal-body">
                      <div class="row g-3">
                        <div class="col-md-4">
                          <label class="form-label">Nombre</label>
                          <input name="name" class="form-control" value="{{ old('name',$it->name) }}" required>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Cargo</label>
                          <input name="position" class="form-control" value="{{ old('position',$it->position) }}">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Badge</label>
                          <input name="badge_text" class="form-control" value="{{ old('badge_text',$it->badge_text) }}">
                        </div>

                        <div class="col-md-4">
                          <label class="form-label">Email</label>
                          <input name="email" type="email" class="form-control" value="{{ old('email',$it->email) }}">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Teléfono</label>
                          <input name="phone" class="form-control" value="{{ old('phone',$it->phone) }}">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Avatar</label>
                          <input type="file" name="avatar" class="form-control">
                          @if($it->avatar_path)
                            <div class="mt-2"><img src="{{ asset('storage/'.$it->avatar_path) }}" height="60"></div>
                          @endif
                        </div>

                        <div class="col-md-12">
                          <label class="form-label">Bio</label>
                          <textarea name="bio" rows="3" class="form-control">{{ old('bio',$it->bio) }}</textarea>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">Skills (csv)</label>
                          <input name="skills" class="form-control" value="{{ old('skills',$it->skills) }}">
                        </div>
                        <div class="col-md-2">
                          <label class="form-label">Destacado</label>
                          <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" @checked($it->is_featured)>
                            <label class="form-check-label">Sí</label>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <label class="form-label">Orden</label>
                          <input type="number" name="sort_order" min="0" class="form-control" value="{{ old('sort_order',$it->sort_order) }}">
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">LinkedIn</label>
                          <input name="linkedin_url" class="form-control" value="{{ old('linkedin_url',$it->linkedin_url) }}">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Twitter</label>
                          <input name="twitter_url" class="form-control" value="{{ old('twitter_url',$it->twitter_url) }}">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Facebook</label>
                          <input name="facebook_url" class="form-control" value="{{ old('facebook_url',$it->facebook_url) }}">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Instagram</label>
                          <input name="instagram_url" class="form-control" value="{{ old('instagram_url',$it->instagram_url) }}">
                        </div>
                        <div class="col-md-12">
                          <label class="form-label">Website</label>
                          <input name="website_url" class="form-control" value="{{ old('website_url',$it->website_url) }}">
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">Donation (opcional)</label>
                          <select name="donation_id" class="form-select">
                            <option value="">-- Selecciona --</option>
                            @foreach($donations as $d)
                              <option value="{{ $d->id }}" @selected(old('donation_id',$it->donation_id)==$d->id)>
                                #{{ $d->id }} — {{ $d->donation_code ?? $d->id }} ({{ $d->donor_name }})
                              </option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Sponsor (opcional)</label>
                          <select name="sponsor_id" class="form-select">
                            <option value="">-- Selecciona --</option>
                            @foreach($sponsors as $s)
                              <option value="{{ $s->id }}" @selected(old('sponsor_id',$it->sponsor_id)==$s->id)>{{ $s->name ?? ('#'.$s->id) }}</option>
                            @endforeach
                          </select>
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
            <tr><td colspan="7" class="text-center p-4">No hay donadores en la vitrina.</td></tr>
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

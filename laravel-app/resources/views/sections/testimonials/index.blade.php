@extends('layouts.tabler')

@section('title', 'Administrar Testimonios de Beneficiarios')
@section('page-title', 'Administrar Testimonios de Beneficiarios')
@section('page-description', 'Gestiona los testimonios y experiencias de los beneficiarios del programa.')

@section('content')
<div class="container-xl">

    {{-- Mensajes globales --}}
    @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('ok') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Ups:</strong> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Crear nuevo testimonio --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title">Crear nuevo testimonio</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
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
                        <input type="text" name="author_name" class="form-control" value="{{ old('author_name') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Título (opcional)</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                    </div>

                    <div class="col-12">
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
                        <input type="number" min="1" max="5" name="rating" class="form-control" value="{{ old('rating', 5) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Avatar (opcional)</label>
                        <input type="file" name="avatar" class="form-control">
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-primary">
                        <i class="bi bi-save"></i> Guardar Testimonio
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Buscador --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por texto, autor, comunidad o beneficiario..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2 text-end">
                    <button class="btn btn-outline-primary w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Listado --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Listado de Testimonios</h3>
        </div>

        <div class="table-responsive">
            <table class="table table-vcenter table-striped table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">ID</th>
                        <th>Beneficiario</th>
                        <th>Autor</th>
                        <th>Rating</th>
                        <th>Publicado</th>
                        <th>Fecha Pub.</th>
                        <th class="text-end" style="width:240px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $t)
                        <tr>
                            <td class="fw-semibold">{{ $t->id }}</td>
                            <td>{{ $t->beneficiary?->name ?? '—' }}</td>
                            <td>{{ $t->author_name ?? $t->beneficiary?->name }}</td>
                            <td>{{ $t->rating }} ⭐</td>
                            <td>
                                @if($t->is_published)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>{{ $t->published_at?->format('d/m/Y H:i') ?? '—' }}</td>
                            <td class="text-end">
                                {{-- Publicar / Despublicar --}}
                                <form action="{{ route('admin.testimonials.toggle-publish', $t) }}" method="post" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm {{ $t->is_published ? 'btn-warning' : 'btn-success' }}">
                                        <i class="bi {{ $t->is_published ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                                        {{ $t->is_published ? 'Despublicar' : 'Publicar' }}
                                    </button>
                                </form>

                                {{-- Editar --}}
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $t->id }}">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </button>

                                {{-- Eliminar --}}
                                <form action="{{ route('admin.testimonials.destroy', $t) }}" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar testimonio #{{ $t->id }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No hay testimonios registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer">
                {{ $testimonials->links() }}
            </div>
        </div>

    </div>
@endsection
@forelse($testimonials as $t)
{{-- Modal de edición --}}
<div class="modal fade" id="editModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Testimonio #{{ $t->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form action="{{ route('admin.testimonials.update', $t) }}" method="post" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Beneficiario</label>
                            <select name="beneficiary_id" class="form-select" required>
                                @foreach($beneficiaries as $b)
                                    <option value="{{ $b->id }}" @selected(old('beneficiary_id', $t->beneficiary_id) == $b->id)>{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Autor (opcional)</label>
                            <input name="author_name" class="form-control" value="{{ old('author_name', $t->author_name) }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Título (opcional)</label>
                            <input name="title" class="form-control" value="{{ old('title', $t->title) }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Comentario</label>
                            <textarea name="body" rows="4" class="form-control" required>{{ old('body', $t->body) }}</textarea>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Rol</label>
                            <input name="role" class="form-control" value="{{ old('role', $t->role) }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Comunidad / Empresa</label>
                            <input name="company" class="form-control" value="{{ old('company', $t->company) }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Rating (1-5)</label>
                            <input type="number" min="1" max="5" name="rating" class="form-control" value="{{ old('rating', $t->rating) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Avatar (opcional)</label>
                            <input type="file" name="avatar" class="form-control">
                            @if($t->avatar_path)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$t->avatar_path) }}" alt="avatar" class="rounded border" height="60">
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
    <td colspan="7" class="text-center py-4 text-muted">No hay testimonios registrados.</td>
</tr>
@endforelse
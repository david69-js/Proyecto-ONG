@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Beneficiario</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('beneficiaries.update', $beneficiary) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $beneficiary->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="beneficiary_type" class="form-label">Tipo</label>
            <select name="beneficiary_type" class="form-select">
                <option value="Person" {{ $beneficiary->beneficiary_type == 'Person' ? 'selected' : '' }}>Persona</option>
                <option value="Family" {{ $beneficiary->beneficiary_type == 'Family' ? 'selected' : '' }}>Familia</option>
                <option value="Community" {{ $beneficiary->beneficiary_type == 'Community' ? 'selected' : '' }}>Comunidad</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select name="status" class="form-select">
                <option value="Active" {{ $beneficiary->status == 'Active' ? 'selected' : '' }}>Activo</option>
                <option value="Inactive" {{ $beneficiary->status == 'Inactive' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="project_id" class="form-label">Proyecto</label>
            <input type="number" name="project_id" class="form-control" value="{{ old('project_id', $beneficiary->project_id) }}">
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('beneficiaries.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

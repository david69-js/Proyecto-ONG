@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Beneficiarios</h1>
    <a href="{{ route('beneficiaries.create') }}" class="btn btn-primary mb-3">Agregar nuevo beneficiario</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Proyecto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($beneficiaries as $beneficiary)
                <tr>
                    <td>{{ $beneficiary->name }}</td>
                    <td>{{ $beneficiary->beneficiary_type }}</td>
                    <td>{{ $beneficiary->status }}</td>
                    <td>{{ $beneficiary->project?->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('beneficiaries.show', $beneficiary) }}" class="btn btn-info btn-sm">Vizualizar</a>
                        <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('beneficiaries.destroy', $beneficiary) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

<x-head-admin />

<div class="container mt-4">
    <h2 class="fw-bold mb-3">Lista de Beneficiarios (Sin BD)</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
            </tr>
        </thead>
        <tbody>
            @foreach($beneficiarios as $b)
            <tr>
                <td>{{ $b['id'] }}</td>
                <td>{{ $b['nombre'] }}</td>
                <td>{{ $b['apellido'] }}</td>
                <td>{{ $b['email'] }}</td>
                <td>{{ $b['telefono'] }}</td>
                <td>{{ $b['direccion'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-footer-admin />

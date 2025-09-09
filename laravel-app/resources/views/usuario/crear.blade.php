<x-head-admin />

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold mb-3">Registrar Nuevo Usuario</h2>

    <form action="" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Apellido</label>
                <input type="text" name="apellido" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Teléfono</label>
                <input type="text" name="telefono" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Dirección</label>
                <input type="text" name="direccion" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Rol</label>
                <select name="rol" class="form-select" required>
                    <option value="voluntario">Voluntario</option>
                    <option value="coordinador">Coordinador</option>
                    <option value="administrador">Administrador</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>
        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('usuario.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

<x-footer-admin />
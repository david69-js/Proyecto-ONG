<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
      </li>
    </ul>

   <!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <!-- Nombre del usuario -->
    <li class="nav-item">
        @if(auth()->check())
            <span class="nav-link">{{ auth()->user()->full_name }}</span>
        @else
            <span class="nav-link">Invitado</span>
        @endif
    </li>

    <!-- Botón de Logout -->
    @if(auth()->check())
    <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="nav-link btn btn-link" style="border: none; background: none;">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </button>
        </form>
    </li>
    @endif
</ul>

<!-- Usar el componente de navegación protegido -->
<x-admin-navigation />

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') - ONG</title>

  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.min.css">
  @stack('styles')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

      <!-- Usuario -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"></a>
        <div class="dropdown-menu dropdown-menu-right">
          <a  class="dropdown-item"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Cerrar sesión
          </a>
          <form id="logout-form"  method="POST" style="display: none;">@csrf</form>
        </div>
      </li>
    </ul>
  </nav>

<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="" class="brand-link">
    <span class="brand-text font-weight-light">ONG</span>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <li class="nav-item">
          <a href="" class="nav-link ">
            <i class="nav-icon fas fa-home"></i><p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Opciones de Usuario<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">            
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i><p>Crear Usuario</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i><p>Editar Usuario</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i><p>Listar Usuarios</p>
              </a>
            </li>

          </ul>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Ubicaciones<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">            
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i><p>Crear Ubicacion</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i><p>Editar Ubicacion</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i><p>Listar Ubicaciones</p>
              </a>
            </li>
          </ul>

    </nav>
  </div>
</aside>



  <!-- Contenido -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid"><h4 class="m-0">@yield('header', 'Inicio')</h4></div>
    </div>
    <section class="content">
      <div class="container-fluid">@yield('content')</div>
    </section>
  </div>

  <footer class="main-footer text-center"><strong>©️ {{ date('Y') }} Motorepuestos Mota</strong></footer>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.min.js"></script>


@stack('scripts')
</body>
</html>
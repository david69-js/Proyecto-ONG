  <x-head-admin />
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
        <!-- 
          Opciones para el administrador
         -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Administrador<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">            
            <li class="nav-item">
              <a href="/usuario/create" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i><p>Crear Usuario</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i><p>Editar Usuario</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="/usuario/" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i><p>Listar Usuarios</p>
              </a>
            </li>

          </ul>

        <!-- 
          Opciones para el las ubicaciones
         -->
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

        <!-- 
       Modulo de proyectos
         -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Proyectos<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">            
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i><p>Crear Proyecto</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i><p>Editar Proyecto</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i><p>Listar Proyectos</p>
              </a>
            </li>
          </ul>

        <!-- 
          Opciones para el beneficiarios
         -->
          <li class="nav-item has-treeview">
          <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Beneficiarios<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">            
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i><p>Crear Beneficiario</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i><p>Editar Beneficiario</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i><p>Listar Beneficiarios</p>
              </a>
            </li>
          </ul>

    </nav>
  </div>
</aside>
  <x-footer-admin />

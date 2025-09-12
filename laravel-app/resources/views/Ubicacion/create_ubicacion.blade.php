<style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 220px;
            background-color: #343a40;
            min-height: 100vh;
            color: white;
            position: fixed;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 240px;
            padding: 20px;
        }
        #map {
            width: 100%;
            height: 400px;
            border: 1px solid #ccc;
        }
    </style>
<x-head-admin />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

    <title>Nueva Ubicación</title>

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
<div class="content">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Nueva Ubicación</h3>
                </div>
                <div class="card-body">
                    <!-- Formulario solo de diseño -->
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del lugar</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" name="direccion" id="direccion" class="form-control">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ciudad" class="form-label">Ciudad</label>
                                <input type="text" name="ciudad" id="ciudad" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="pais" class="form-label">País</label>
                                <input type="text" name="pais" id="pais" class="form-control">
                            </div>
                        </div>

                        <!-- Campos ocultos para lat/lng -->
                        <input type="hidden" id="latitud" name="latitud">
                        <input type="hidden" id="longitud" name="longitud">

                        <div id="map" class="mb-3"></div>

                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
              <a href="/Ubicacion/create" class="nav-link">
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
<!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var map = L.map('map').setView([14.6349, -90.5069], 13); // Guatemala por defecto
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker;
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            if (marker) { map.removeLayer(marker); }
            marker = L.marker([lat, lng]).addTo(map);

            document.getElementById("latitud").value = lat;
            document.getElementById("longitud").value = lng;
        });
    </script>
  <x-footer-admin />

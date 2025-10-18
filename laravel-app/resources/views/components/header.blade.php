 <header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center dark-background">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">contact@example.com</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 5589 55488 55</span></i>
        </div>
        <div class="social-links d-none d-md-flex align-items-center">
          <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div><!-- End Top Bar -->
<header id="header" class="header fixed-top">
  <div class="branding d-flex align-items-center">

    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Logo de Habitat Guatemala -->
        <img src="assets/img/habitat-logo.webp" alt="Habitat Guatemala" style="height:50px;">
        <h1 class="sitename ms-2">Habitat Guatemala</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html" class="active">Inicio</a></li>
          <li><a href="about.html">Quiénes Somos</a></li>
          <li><a href="programs.html">Programas</a></li>
          <li><a href="projects.html">Proyectos</a></li>
          <li><a href="team.html">Equipo</a></li>
          @auth
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-user"></i> {{ auth()->user()->first_name }}
                <i class="bi bi-chevron-down toggle-dropdown"></i>
              </a>
              <ul class="dropdown-menu">
                <li><a href="/users" class="dropdown-item"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item">
                      <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                  </form>
                </li>
              </ul>
            </li>
          @else
            <li><a href="{{ route('login') }}">Ingresar</a></li>
            <li><a href="{{ route('register') }}">Registrarse</a></li>
          @endauth 
          <li class="dropdown"><a href="#"><span>Más Páginas</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="service-details.html">Detalles del Programa</a></li>
              <li><a href="project-details.html">Detalles del Proyecto</a></li>
              <li><a href="quote.html">Formulario de Donación</a></li>
              <li><a href="terms.html">Términos</a></li>
              <li><a href="privacy.html">Privacidad</a></li>
              <li><a href="404.html">404</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Participa</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Voluntariado</a></li>
              <li class="dropdown"><a href="#"><span>Campañas</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Campaña 1</a></li>
                  <li><a href="#">Campaña 2</a></li>
                  <li><a href="#">Campaña 3</a></li>
                  <li><a href="#">Campaña 4</a></li>
                  <li><a href="#">Campaña 5</a></li>
                </ul>
              </li>
              <li><a href="#">Donaciones</a></li>
              <li><a href="#">Eventos</a></li>
              <li><a href="#">Alianzas</a></li>
            </ul>
          </li>
          <li><a href="contact.html">Contacto</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>

  </div>
</header>

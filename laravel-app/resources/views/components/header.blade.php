<header id="header" class="header fixed-top">
    <div id="topbar" class="topbar d-flex align-items-center dark-background" style="transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">contact@example.com</a></i>
        </div>
          <div class="social-links d-none d-md-flex align-items-center">
            <a href="https://x.com/" target="_blank" rel="noopener noreferrer" class="twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="linkedin"><i class="bi bi-linkedin"></i></a>
          </div>
      </div>
    </div><!-- End Top Bar -->
  <div class="branding d-flex align-items-center">

    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="{{ route('home') }}" class="logo d-flex align-items-center">
        <!-- Logo de Habitat Guatemala -->
        <img src="{{ asset('assets/img/logo_habitat.jpeg') }}" alt="Habitat Guatemala" class="logo-img me-2" style="height: 50px; width: auto;">
        <h1 class="sitename ms-2">Habitat Guatemala</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('home') }}" class="active">Inicio</a></li>
          <li><a href="#about">Quiénes Somos</a></li>
          <li><a href="#services">Programas</a></li>
          <li><a href="#projects">Proyectos</a></li>
          <li><a href="#donadores">Equipo</a></li>
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
          @endauth 
          <li><a href="#call-to-action">Contacto</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>

  </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const topbar = document.getElementById('topbar');
  let lastScrollTop = 0;
  let ticking = false;
  let isHidden = false;

  function updateTopbar() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const scrollDelta = scrollTop - lastScrollTop;
    
    // Solo cambiar si hay un cambio significativo en el scroll
    if (Math.abs(scrollDelta) > 5) {
      if (scrollDelta > 0 && scrollTop > 100 && !isHidden) {
        // Scrolling down - hide topbar gradually
        topbar.style.transform = 'translateY(-100%)';
        isHidden = true;
      } else if (scrollDelta < 0 && isHidden) {
        // Scrolling up - show topbar gradually
        topbar.style.transform = 'translateY(0)';
        isHidden = false;
      }
    }
    
    lastScrollTop = scrollTop;
    ticking = false;
  }

  function requestTick() {
    if (!ticking) {
      requestAnimationFrame(updateTopbar);
      ticking = true;
    }
  }

  window.addEventListener('scroll', requestTick, { passive: true });
});
</script>

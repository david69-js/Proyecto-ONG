<header id="header" class="header fixed-top">
    <div id="topbar" class="topbar d-flex align-items-center dark-background" style="transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="https://mail.google.com/mail/?view=cm&fs=1&to=ongumg@gmail.com&su=Consulta%20desde%20sitio%20web%20Habitat%20Guatemala&body=Hola,%20me%20interesa%20obtener%20más%20información%20sobre%20sus%20servicios%20y%20cómo%20puedo%20ayudar." target="_blank">ongumg@gmail.com</a></i>
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
          <li><a href="{{ route('home') }}#about">Quiénes Somos</a></li>
          <li><a href="{{ route('home') }}#projects">Proyectos</a></li>
          <li><a href="{{ route('home') }}#services">Eventos</a></li>
          <li><a href="{{ route('locations.public.index') }}">Ubicaciones</a></li>
          <li><a href="{{ route('contact') }}">Contáctanos</a></li>
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
            <li><a href="{{ route('login') }}" target="_blank">Ingresar</a></li>
          @endauth 
          <li><a href="{{ route('products.public.index') }}">Productos</a></li>
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

// Fix dropdown hover behavior
document.addEventListener('DOMContentLoaded', function() {
  const dropdown = document.querySelector('.navmenu .dropdown');
  const dropdownToggle = document.querySelector('.navmenu .dropdown-toggle');
  const dropdownMenu = document.querySelector('.navmenu .dropdown-menu');
  
  if (dropdown && dropdownToggle && dropdownMenu) {
    let hoverTimeout;
    
    // Show dropdown on hover
    dropdown.addEventListener('mouseenter', function() {
      clearTimeout(hoverTimeout);
      dropdownMenu.style.display = 'block';
      dropdownMenu.style.opacity = '1';
      dropdownMenu.style.visibility = 'visible';
    });
    
    // Hide dropdown with delay to allow mouse movement
    dropdown.addEventListener('mouseleave', function() {
      hoverTimeout = setTimeout(function() {
        dropdownMenu.style.display = 'none';
        dropdownMenu.style.opacity = '0';
        dropdownMenu.style.visibility = 'hidden';
      }, 150); // Small delay to prevent flickering
    });
    
    // Keep dropdown open when hovering over the menu itself
    dropdownMenu.addEventListener('mouseenter', function() {
      clearTimeout(hoverTimeout);
    });
    
    dropdownMenu.addEventListener('mouseleave', function() {
      hoverTimeout = setTimeout(function() {
        dropdownMenu.style.display = 'none';
        dropdownMenu.style.opacity = '0';
        dropdownMenu.style.visibility = 'hidden';
      }, 150);
    });
  }
});
</script>

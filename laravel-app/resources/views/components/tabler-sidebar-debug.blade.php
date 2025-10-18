<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('assets/img/habitat-logo.webp') }}" width="32" height="32" alt="ONG" class="navbar-brand-image">
                ONG Sistema
            </a>
        </h1>
        
        <div class="navbar-nav">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background-image: url({{ asset('assets/img/default-avatar.png') }})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ auth()->user()->full_name ?? 'Usuario' }}</div>
                        <div class="mt-1 small text-muted">
                            @foreach(auth()->user()->roles as $role)
                                {{ $role->name }}
                                @if(!$loop->last), @endif
                            @endforeach
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="{{ route('users.show', auth()->id()) }}" class="dropdown-item">Mi Perfil</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="collapse navbar-collapse show" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-tachometer-alt"></i>
                        </span>
                        <span class="nav-link-title">Dashboard</span>
                    </a>
                </li>

                <!-- Usuarios -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-users" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-users"></i>
                        </span>
                        <span class="nav-link-title">Usuarios</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('users.index') }}">
                            <i class="fas fa-list me-2"></i>Listar Usuarios
                        </a>
                        <a class="dropdown-item" href="{{ route('users.create') }}">
                            <i class="fas fa-plus me-2"></i>Crear Usuario
                        </a>
                    </div>
                </li>

                <!-- Proyectos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-projects" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-project-diagram"></i>
                        </span>
                        <span class="nav-link-title">Proyectos</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('projects.index') }}">
                            <i class="fas fa-list me-2"></i>Listar Proyectos
                        </a>
                        <a class="dropdown-item" href="{{ route('projects.create') }}">
                            <i class="fas fa-plus me-2"></i>Crear Proyecto
                        </a>
                    </div>
                </li>

                <!-- Beneficiarios -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-beneficiaries" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-heart"></i>
                        </span>
                        <span class="nav-link-title">Beneficiarios</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('beneficiaries.index') }}">
                            <i class="fas fa-list me-2"></i>Listar Beneficiarios
                        </a>
                        <a class="dropdown-item" href="{{ route('beneficiaries.create') }}">
                            <i class="fas fa-plus me-2"></i>Crear Beneficiario
                        </a>
                    </div>
                </li>

                <!-- Ubicaciones -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-locations" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        <span class="nav-link-title">Ubicaciones</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('locations.index') }}">
                            <i class="fas fa-list me-2"></i>Listar Ubicaciones
                        </a>
                        <a class="dropdown-item" href="{{ route('locations.create') }}">
                            <i class="fas fa-plus me-2"></i>Crear Ubicación
                        </a>
                    </div>
                </li>

                <!-- Patrocinadores -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-sponsors" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-handshake"></i>
                        </span>
                        <span class="nav-link-title">Patrocinadores</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('sponsors.index') }}">
                            <i class="fas fa-list me-2"></i>Listar Patrocinadores
                        </a>
                        <a class="dropdown-item" href="{{ route('sponsors.create') }}">
                            <i class="fas fa-plus me-2"></i>Crear Patrocinador
                        </a>
                    </div>
                </li>

                <!-- Eventos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-events" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                        <span class="nav-link-title">Eventos</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('events.index') }}">
                            <i class="fas fa-list me-2"></i>Listar Eventos
                        </a>
                        <a class="dropdown-item" href="{{ route('events.create') }}">
                            <i class="fas fa-plus me-2"></i>Crear Evento
                        </a>
                    </div>
                </li>

                <!-- Donaciones -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-donations" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-hand-holding-usd"></i>
                        </span>
                        <span class="nav-link-title">Donaciones</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('donations.index') }}">
                            <i class="fas fa-list me-2"></i>Listar Donaciones
                        </a>
                        <a class="dropdown-item" href="{{ route('donations.create') }}">
                            <i class="fas fa-plus me-2"></i>Registrar Donación
                        </a>
                        <a class="dropdown-item" href="{{ route('donations.reports') }}">
                            <i class="fas fa-chart-bar me-2"></i>Reportes de Donaciones
                        </a>
                    </div>
                </li>

                <!-- Productos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-products" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-box"></i>
                        </span>
                        <span class="nav-link-title">Productos</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('products.index') }}">
                            <i class="fas fa-list me-2"></i>Listar Productos
                        </a>
                        <a class="dropdown-item" href="{{ route('products.create') }}">
                            <i class="fas fa-plus me-2"></i>Crear Producto
                        </a>
                        <a class="dropdown-item" href="{{ route('products.catalog') }}">
                            <i class="fas fa-store me-2"></i>Catálogo Público
                        </a>
                        <a class="dropdown-item" href="{{ route('products.statistics') }}">
                            <i class="fas fa-chart-line me-2"></i>Estadísticas
                        </a>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</aside>

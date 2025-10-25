    <!-- Botón hamburguesa para móvil -->
    <button class="btn btn-primary d-lg-none mobile-menu-btn" type="button" data-bs-toggle="modal" data-bs-target="#mobileSidebarModal" style="position: fixed; top: 15px; right: 15px; z-index: 1050;">
        <i class="fas fa-bars"></i>
    </button>

    <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark d-none custom-sidebar">
    <div class="container-fluid">
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('assets/img/logo_habitat.jpeg') }}" width="32" height="32" alt="ONG" class="navbar-brand-image">
                ONG Sistema
            </a>
        </h1>
        
        <div class="navbar-nav">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    @if(auth()->user()->avatar)
                        <span class="avatar avatar-sm" style="background-image: url({{ asset('storage/' . auth()->user()->avatar) }})"></span>
                    @else
                        <span class="avatar avatar-sm bg-primary text-white d-flex align-items-center justify-content-center">
                            {{ substr(auth()->user()->first_name, 0, 1) }}{{ substr(auth()->user()->last_name, 0, 1) }}
                        </span>
                    @endif
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                        <div class="mt-1 small text-success">
                            @foreach(auth()->user()->roles as $role)
                                {{ $role->name }}
                                @if(!$loop->last), @endif
                            @endforeach
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="background: white; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); min-width: 200px;">
                    <a href="{{ route('users.show', auth()->id()) }}" class="dropdown-item d-flex align-items-center" style="padding: 0.75rem 1rem; color: #374151; text-decoration: none; border-bottom: 1px solid #f3f4f6;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                            <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/>
                            <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"/>
                        </svg>
                        Mi Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center w-100" style="padding: 0.75rem 1rem; color: #dc2626; text-decoration: none; background: none; border: none; text-align: left;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"/>
                                <path d="M7 12h14l-3 -3m0 6l3 -3"/>
                            </svg>
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="collapse navbar-collapse show d-flex flex-column" id="sidebar-menu" style="height: calc(100vh - 80px);">
            <ul class="navbar-nav pt-lg-3 flex-grow-1">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-tachometer-alt"></i>
                        </span>
                        <span class="nav-link-title">Dashboard</span>
                    </a>
                </li>

                {{-- ========================================== --}}
                {{-- MENÚ PARA BENEFICIARIOS --}}
                {{-- ========================================== --}}
                @role('beneficiary')
                    <!-- Mi Perfil -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.show', auth()->id()) }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fas fa-user"></i>
                            </span>
                            <span class="nav-link-title">Mi Perfil</span>
                        </a>
                    </li>

                    <!-- Mi Proyecto -->
                    @if(auth()->user()->beneficiary && auth()->user()->beneficiary->project)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('projects.show', auth()->user()->beneficiary->project_id) }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fas fa-project-diagram"></i>
                            </span>
                            <span class="nav-link-title">Mi Proyecto</span>
                        </a>
                    </li>
                    @endif

                    <!-- Mis Beneficios -->
                    @if(auth()->user()->beneficiary)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('beneficiaries.show', auth()->user()->beneficiary->id) }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fas fa-gift"></i>
                            </span>
                            <span class="nav-link-title">Mis Beneficios</span>
                        </a>
                    </li>
                    @endif
                @endrole

                {{-- ========================================== --}}
                {{-- MENÚ PARA DONANTES --}}
                {{-- ========================================== --}}
                @role('donor')
                    <!-- Mis Donaciones -->
                    @permission('donations.view.own')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.donations.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fas fa-hand-holding-usd"></i>
                            </span>
                            <span class="nav-link-title">Mis Donaciones</span>
                        </a>
                    </li>
                    @endpermission
                    
                    <!-- Registrar Donación -->
                    @permission('donations.create')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.donations.create') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fas fa-plus-circle"></i>
                            </span>
                            <span class="nav-link-title">Registrar Donación</span>
                        </a>
                    </li>
                    @endpermission
                @endrole

                {{-- ========================================== --}}
                {{-- MENÚ PARA ROLES ADMINISTRATIVOS --}}
                {{-- ========================================== --}}
                @hasanyrole('super-admin', 'admin')
                
                    <!-- ========================================== -->
                    <!-- MENÚ DE SECCIONES -->
                    <!-- ========================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-sections" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fas fa-th-large"></i>
                            </span>
                            <span class="nav-link-title">Secciones</span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.hero.index') }}">
                                <i class="fas fa-star me-2"></i>Hero
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.about.index') }}">
                                <i class="fas fa-info-circle me-2"></i>Sobre Nosotros
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.events.index') }}">
                                <i class="fas fa-calendar-alt me-2"></i>Eventos
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.testimonials.index') }}">
                                <i class="fas fa-star me-2"></i>Beneficiarios
                            </a>
<a class="dropdown-item" href="{{ route('admin.sections.projects.index') }}">
    <i class="fas fa-briefcase me-2"></i>Proyectos
</a>


                            <a class="dropdown-item" href="{{ route('admin.sponsors.index') }}">
                                <i class="fas fa-handshake me-2"></i>Patrocinadores
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.donations.index') }}">
                                <i class="fas fa-donate me-2"></i>Donadores
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.contact-messages.index') }}">
                                <i class="fas fa-envelope me-2"></i>Mensajes de Contacto
                            </a>
<a class="dropdown-item" href="{{ route('admin.public.index-selector') }}">
    <i class="fas fa-globe me-2"></i> Página pública predeterminada
</a>

                        </div>
                    </li>

                    <!-- Gestión de Usuarios -->
                    @permission('users.view')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-users" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fas fa-users"></i>
                            </span>
                            <span class="nav-link-title">Usuarios</span>
                        </a>
                        <div class="dropdown-menu">
                            @permission('users.view')
                            <a class="dropdown-item" href="{{ route('users.index') }}">
                                <i class="fas fa-list me-2"></i>Listar Usuarios
                            </a>
                            @endpermission
                            @permission('users.create')
                            <a class="dropdown-item" href="{{ route('users.create') }}">
                                <i class="fas fa-plus me-2"></i>Crear Usuario
                            </a>
                            @endpermission
                        </div>
                    </li>
                    @endpermission

                    <!-- Gestión de Proyectos -->
                    @permission('projects.view')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-projects" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fas fa-project-diagram"></i>
                            </span>
                            <span class="nav-link-title">Proyectos</span>
                        </a>
                        <div class="dropdown-menu">
                            @permission('projects.view')
                            <a class="dropdown-item" href="{{ route('projects.index') }}">
                                <i class="fas fa-list me-2"></i>Listar Proyectos
                            </a>
                            @endpermission
                            @permission('projects.create')
                            <a class="dropdown-item" href="{{ route('projects.create') }}">
                                <i class="fas fa-plus me-2"></i>Crear Proyecto
                            </a>
                            @endpermission
                        </div>
                    </li>
                    @endpermission

                    <!-- Gestión de Beneficiarios -->
                    @permission('beneficiaries.view')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-beneficiarios" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fas fa-heart"></i>
                            </span>
                            <span class="nav-link-title">Beneficiarios</span>
                        </a>
                        <div class="dropdown-menu">
                            @permission('beneficiaries.view')
                            <a class="dropdown-item" href="{{ route('beneficiaries.index') }}">
                                <i class="fas fa-list me-2"></i>Listar Beneficiarios
                            </a>
                            @endpermission
                            @permission('beneficiaries.create')
                            <a class="dropdown-item" href="{{ route('beneficiaries.create') }}">
                                <i class="fas fa-plus me-2"></i>Crear Beneficiario
                            </a>
                            @endpermission
                        </div>
                    </li>
                    @endpermission

                    <!-- Gestión de Ubicaciones -->
                    @permission('locations.view')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-locations" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <span class="nav-link-title">Ubicaciones</span>
                        </a>
                        <div class="dropdown-menu">
                            @permission('locations.view')
                            <a class="dropdown-item" href="{{ route('locations.index') }}">
                                <i class="fas fa-list me-2"></i>Listar Ubicaciones
                            </a>
                            @endpermission
                            @permission('locations.create')
                            <a class="dropdown-item" href="{{ route('locations.create') }}">
                                <i class="fas fa-plus me-2"></i>Crear Ubicación
                            </a>
                            @endpermission
                        </div>
                    </li>
                    @endpermission

                    <!-- Gestión de Patrocinadores -->
                    @permission('sponsors.view')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-sponsors" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fas fa-handshake"></i>
                            </span>
                            <span class="nav-link-title">Patrocinadores</span>
                        </a>
                        <div class="dropdown-menu">
                            @permission('sponsors.view')
                            <a class="dropdown-item" href="{{ route('sponsors.index') }}">
                                <i class="fas fa-list me-2"></i>Listar Patrocinadores
                            </a>
                            @endpermission
                            @permission('sponsors.create')
                            <a class="dropdown-item" href="{{ route('sponsors.create') }}">
                                <i class="fas fa-plus me-2"></i>Crear Patrocinador
                            </a>
                            @endpermission
                        </div>
                    </li>
                    @endpermission
<!-- Gestión de Eventos -->
@php
    $eventsIndex  = Route::has('admin.events-admin.index')  ? 'admin.events-admin.index'  : (Route::has('admin.events.index')  ? 'admin.events.index'  : (Route::has('events.index')  ? 'events.index'  : null));
    $eventsCreate = Route::has('admin.events-admin.create') ? 'admin.events-admin.create' : (Route::has('admin.events.create') ? 'admin.events.create' : (Route::has('events.create') ? 'events.create' : null));
@endphp

@permission('events.view')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#navbar-events" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="fas fa-calendar-alt"></i>
        </span>
        <span class="nav-link-title">Eventos</span>
    </a>

    <div class="dropdown-menu">

        @permission('events.view')
            @if($eventsIndex)
            <a class="dropdown-item" href="{{ route($eventsIndex) }}">
                <i class="fas fa-list me-2"></i> Listar Eventos
            </a>
            @endif
        @endpermission

        @permission('events.create')
            @if($eventsCreate)
            <a class="dropdown-item" href="{{ route($eventsCreate) }}">
                <i class="fas fa-plus me-2"></i> Crear Evento
            </a>
            @endif
        @endpermission

        @permission('events.reports')
            @if(Route::has('admin.events-admin.reports'))
            <a class="dropdown-item" href="{{ route('admin.events-admin.reports') }}">
                <i class="fas fa-chart-bar me-2"></i> Reportes de Eventos
            </a>
            @elseif(Route::has('admin.events.reports'))
            <a class="dropdown-item" href="{{ route('admin.events.reports') }}">
                <i class="fas fa-chart-bar me-2"></i> Reportes de Eventos
            </a>
            @endif
        @endpermission

    </div>
</li>
@endpermission



                    <!-- Gestión de Donaciones -->
                    @permission('donations.view')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-donations" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fas fa-hand-holding-usd"></i>
                            </span>
                            <span class="nav-link-title">Donaciones</span>
                        </a>
                        <div class="dropdown-menu">
                            @permission('donations.view')
                            @if(Route::has('admin.donations-admin.index'))
                            <a class="dropdown-item" href="{{ route('admin.donations-admin.index') }}">
                                <i class="fas fa-list me-2"></i> Listar Donaciones
                            </a>
                            @elseif(Route::has('admin.donations.index'))
                            <a class="dropdown-item" href="{{ route('admin.donations.index') }}">
                                <i class="fas fa-list me-2"></i> Listar Donaciones
                            </a>
                            @endif
                            @endpermission

                            @permission('donations.create')
                            @if(Route::has('admin.donations-admin.create'))
                            <a class="dropdown-item" href="{{ route('admin.donations-admin.create') }}">
                                <i class="fas fa-plus me-2"></i> Registrar Donación
                            </a>
                            @elseif(Route::has('admin.donations.create'))
                            <a class="dropdown-item" href="{{ route('admin.donations.create') }}">
                                <i class="fas fa-plus me-2"></i> Registrar Donación
                            </a>
                            @endif
                            @endpermission

                            @permission('donations.reports')
                            @if(Route::has('admin.donations-admin.reports'))
                            <a class="dropdown-item" href="{{ route('admin.donations-admin.reports') }}">
                                <i class="fas fa-chart-bar me-2"></i> Reportes de Donaciones
                            </a>
                            @elseif(Route::has('admin.donations.reports'))
                            <a class="dropdown-item" href="{{ route('admin.donations.reports') }}">
                                <i class="fas fa-chart-bar me-2"></i> Reportes de Donaciones
                            </a>
                            @endif
                            @endpermission
                        </div>
                    </li>
                    @endpermission

                    <!-- Gestión de Productos -->
                    @permission('products.view')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-products" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fas fa-box"></i>
                            </span>
                            <span class="nav-link-title">Productos</span>
                        </a>
                        <div class="dropdown-menu">
                            @permission('products.view')
                            <a class="dropdown-item" href="{{ route('products.index') }}">
                                <i class="fas fa-list me-2"></i>Listar Productos
                            </a>
                            @endpermission
                            @permission('products.create')
                            <a class="dropdown-item" href="{{ route('products.create') }}">
                                <i class="fas fa-plus me-2"></i>Crear Producto
                            </a>
                            @endpermission
                            @permission('products.catalog')
                            <a class="dropdown-item" href="{{ route('products.catalog') }}">
                                <i class="fas fa-store me-2"></i>Catálogo Público
                            </a>
                            @endpermission
                            @permission('products.statistics')
                            <a class="dropdown-item" href="{{ route('products.statistics') }}">
                                <i class="fas fa-chart-line me-2"></i>Estadísticas
                            </a>
                            @endpermission
                        </div>
                    </li>
                    @endpermission

                    <!-- Reportes -->
                    @permission('reports.view')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-reports" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="fas fa-chart-bar"></i>
                            </span>
                            <span class="nav-link-title">Reportes</span>
                        </a>
                        <div class="dropdown-menu">
                            @permission('reports.view')
                            <a class="dropdown-item" href="{{ route('admin.reports.projects.index') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard de Reportes
                            </a>
                            @endpermission
                            @permission('reports.impact-statistics')
                            <a class="dropdown-item" href="{{ route('admin.reports.projects.index') }}">
                                <i class="fas fa-chart-pie me-2"></i>Estadísticas de Impacto
                            </a>
                            @endpermission
                            @permission('reports.export')
                            <a class="dropdown-item" href="{{ url('/admin/reports/projects/export/pdf') }}">
                                <i class="fas fa-download me-2"></i>Exportar Informes
                            </a>
                            @endpermission
                        </div>
                    </li>
                    @endpermission

                @endhasanyrole

            </ul>
            
            <!-- Botón de Cerrar Sesión -->
            <div class="mt-auto p-3">
                <form method="POST" action="{{ route('logout') }}" class="w-100">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>

<!-- Modal para sidebar móvil -->
<div class="modal fade" id="mobileSidebarModal" tabindex="-1" aria-labelledby="mobileSidebarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="mobileSidebarModalLabel">
                    <img src="{{ asset('assets/img/logo-pestañas.ico') }}" width="24" height="24" alt="ONG" class="me-2">
                    ONG Sistema
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Contenido del sidebar para móvil -->
                <div class="mobile-sidebar-content">
                    <!-- Información del usuario -->
                    <div class="p-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                                    @if(auth()->user()->avatar)
                                        <span class="avatar avatar-md me-3" style="background-image: url({{ asset('storage/' . auth()->user()->avatar) }})"></span>
                                    @else
                                        <span class="avatar avatar-md bg-primary text-white d-flex align-items-center justify-content-center me-3">
                                            {{ substr(auth()->user()->first_name, 0, 1) }}{{ substr(auth()->user()->last_name, 0, 1) }}
                                        </span>
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow user-dropdown">
                                    <a href="{{ route('users.show', auth()->id()) }}" class="dropdown-item d-flex align-items-center user-dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                                            <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/>
                                            <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"/>
                                        </svg>
                                        Mi Perfil
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item d-flex align-items-center w-100 logout-button">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"/>
                                                <path d="M7 12h14l-3 -3m0 6l3 -3"/>
                                            </svg>
                                            Cerrar Sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div>
                                <div class="fw-bold">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                                <div class="text-muted small">
                                    @foreach(auth()->user()->roles as $role)
                                        {{ $role->name }}
                                        @if(!$loop->last), @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Menú de navegación móvil -->
                    <div class="mobile-menu-items">
                        <!-- Aquí irá el contenido del menú -->
                        <div class="list-group list-group-flush">
                            <!-- Dashboard -->
                            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="fas fa-tachometer-alt me-3"></i>
                                Dashboard
                            </a>

                            {{-- ========================================== --}}
                            {{-- MENÚ PARA BENEFICIARIOS --}}
                            {{-- ========================================== --}}
                            @role('beneficiary')
                                <!-- Mi Perfil -->
                                <a href="{{ route('users.show', auth()->id()) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-user me-3"></i>
                                    Mi Perfil
                                </a>

                                <!-- Mi Proyecto -->
                                @if(auth()->user()->beneficiary && auth()->user()->beneficiary->project)
                                <a href="{{ route('projects.show', auth()->user()->beneficiary->project_id) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-project-diagram me-3"></i>
                                    Mi Proyecto
                                </a>
                                @endif

                                <!-- Mis Beneficios -->
                                @if(auth()->user()->beneficiary)
                                <a href="{{ route('beneficiaries.show', auth()->user()->beneficiary->id) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-gift me-3"></i>
                                    Mis Beneficios
                                </a>
                                @endif
                            @endrole

                            {{-- ========================================== --}}
                            {{-- MENÚ PARA DONANTES --}}
                            {{-- ========================================== --}}
                            @role('donor')
                                <!-- Mis Donaciones -->
                                @permission('donations.view.own')
                                <a href="{{ route('admin.donations.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-hand-holding-usd me-3"></i>
                                    Mis Donaciones
                                </a>
                                @endpermission
                                
                                <!-- Registrar Donación -->
                                @permission('donations.create')
                                <a href="{{ route('admin.donations.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-plus-circle me-3"></i>
                                    Registrar Donación
                                </a>
                                @endpermission
                            @endrole

                            {{-- ========================================== --}}
                            {{-- MENÚ PARA ROLES ADMINISTRATIVOS --}}
                            {{-- ========================================== --}}
                            @hasanyrole('super-admin', 'admin', 'project-coordinator', 'beneficiary-coordinator', 'volunteer', 'consultant')
                                <!-- Secciones -->
                                <div class="list-group-item">
                                    <div class="fw-bold text-muted mb-2">Secciones</div>
                                </div>
                                <a href="{{ route('admin.hero.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-star me-3"></i>
                                    Hero
                                </a>
                                <a href="{{ route('admin.about.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-info-circle me-3"></i>
                                    Sobre Nosotros
                                </a>
                                <a href="{{ route('admin.events.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-calendar-alt me-3"></i>
                                    Eventos
                                </a>
  <a href="{{ route('projects.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
    <i class="fas fa-briefcase me-3"></i>
    Proyectos
</a>
                                <a href="{{ route('admin.sponsors.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-handshake me-3"></i>
                                    Patrocinadores
                                </a>
                                <a href="{{ route('admin.donations.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-donate me-3"></i>
                                    Donadores
                                </a>
                                <a href="{{ route('admin.contact-messages.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-envelope me-3"></i>
                                    Mensajes de Contacto
                                </a>
                                <a href="{{ route('admin.public.index-selector') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-globe me-3"></i>
                                    Página pública predeterminada
                                </a>

                                <!-- Gestión de Usuarios -->
                                @permission('users.view')
                                <div class="list-group-item">
                                    <div class="fw-bold text-muted mb-2">Usuarios</div>
                                </div>
                                <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-list me-3"></i>
                                    Listar Usuarios
                                </a>
                                @permission('users.create')
                                <a href="{{ route('users.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-plus me-3"></i>
                                    Crear Usuario
                                </a>
                                @endpermission
                                @endpermission

                                <!-- Gestión de Proyectos -->
                                @permission('projects.view')
                                <div class="list-group-item">
                                    <div class="fw-bold text-muted mb-2">Proyectos</div>
                                </div>
                                <a href="{{ route('projects.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-list me-3"></i>
                                    Listar Proyectos
                                </a>
                                @permission('projects.create')
                                <a href="{{ route('projects.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-plus me-3"></i>
                                    Crear Proyecto
                                </a>
                                @endpermission
                                @endpermission

                                <!-- Gestión de Beneficiarios -->
                                @permission('beneficiaries.view')
                                <div class="list-group-item">
                                    <div class="fw-bold text-muted mb-2">Beneficiarios</div>
                                </div>
                                <a href="{{ route('beneficiaries.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-list me-3"></i>
                                    Listar Beneficiarios
                                </a>
                                @permission('beneficiaries.create')
                                <a href="{{ route('beneficiaries.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-plus me-3"></i>
                                    Crear Beneficiario
                                </a>
                                @endpermission
                                @endpermission

                                <!-- Gestión de Ubicaciones -->
                                @permission('locations.view')
                                <div class="list-group-item">
                                    <div class="fw-bold text-muted mb-2">Ubicaciones</div>
                                </div>
                                <a href="{{ route('locations.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-list me-3"></i>
                                    Listar Ubicaciones
                                </a>
                                @permission('locations.create')
                                <a href="{{ route('locations.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-plus me-3"></i>
                                    Crear Ubicación
                                </a>
                                @endpermission
                                @endpermission

                                <!-- Gestión de Patrocinadores -->
                                @permission('sponsors.view')
                                <div class="list-group-item">
                                    <div class="fw-bold text-muted mb-2">Patrocinadores</div>
                                </div>
                                <a href="{{ route('sponsors.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-list me-3"></i>
                                    Listar Patrocinadores
                                </a>
                                @permission('sponsors.create')
                                <a href="{{ route('sponsors.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-plus me-3"></i>
                                    Crear Patrocinador
                                </a>
                                @endpermission
                                @endpermission

                                <!-- Gestión de Eventos -->
                                @permission('events.view')
                                <div class="list-group-item">
                                    <div class="fw-bold text-muted mb-2">Eventos</div>
                                </div>
                                @php
                                    $eventsIndex  = Route::has('admin.events-admin.index')  ? 'admin.events-admin.index'  : (Route::has('admin.events.index')  ? 'admin.events.index'  : (Route::has('events.index')  ? 'events.index'  : null));
                                    $eventsCreate = Route::has('admin.events-admin.create') ? 'admin.events-admin.create' : (Route::has('admin.events.create') ? 'admin.events.create' : (Route::has('events.create') ? 'events.create' : null));
                                @endphp
                                @if($eventsIndex)
                                <a href="{{ route($eventsIndex) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-list me-3"></i>
                                    Listar Eventos
                                </a>
                                @endif
                                @permission('events.create')
                                @if($eventsCreate)
                                <a href="{{ route($eventsCreate) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-plus me-3"></i>
                                    Crear Evento
                                </a>
                                @endif
                                @endpermission
                                @endpermission

                                <!-- Gestión de Donaciones -->
                                @permission('donations.view')
                                <div class="list-group-item">
                                    <div class="fw-bold text-muted mb-2">Donaciones</div>
                                </div>
                                @if(Route::has('admin.donations-admin.index'))
                                <a href="{{ route('admin.donations-admin.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-list me-3"></i>
                                    Listar Donaciones
                                </a>
                                @elseif(Route::has('admin.donations.index'))
                                <a href="{{ route('admin.donations.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-list me-3"></i>
                                    Listar Donaciones
                                </a>
                                @endif
                                @permission('donations.create')
                                @if(Route::has('admin.donations-admin.create'))
                                <a href="{{ route('admin.donations-admin.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-plus me-3"></i>
                                    Registrar Donación
                                </a>
                                @elseif(Route::has('admin.donations.create'))
                                <a href="{{ route('admin.donations.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-plus me-3"></i>
                                    Registrar Donación
                                </a>
                                @endif
                                @endpermission
                                @endpermission

                                <!-- Gestión de Productos -->
                                @permission('products.view')
                                <div class="list-group-item">
                                    <div class="fw-bold text-muted mb-2">Productos</div>
                                </div>
                                <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-list me-3"></i>
                                    Listar Productos
                                </a>
                                @permission('products.create')
                                <a href="{{ route('products.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-plus me-3"></i>
                                    Crear Producto
                                </a>
                                @endpermission
                                @permission('products.catalog')
                                <a href="{{ route('products.catalog') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-store me-3"></i>
                                    Catálogo Público
                                </a>
                                @endpermission
                                @permission('products.statistics')
                                <a href="{{ route('products.statistics') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-chart-line me-3"></i>
                                    Estadísticas
                                </a>
                                @endpermission
                                @endpermission

                                <!-- Reportes -->
                                @permission('reports.view')
                                <div class="list-group-item">
                                    <div class="fw-bold text-muted mb-2">Reportes</div>
                                </div>
                                @permission('reports.impact-statistics')
                                <a href="{{ route('admin.reports.projects.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-chart-pie me-3"></i>
                                    Estadísticas de Impacto
                                </a>
                                @endpermission
                                @permission('reports.export')
                                <a href="{{ url('/admin/reports/projects/export/pdf') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="fas fa-download me-3"></i>
                                    Exportar Informes
                                </a>
                                @endpermission
                                @endpermission

                                <!-- Reportes Adicionales -->
                                @permission('reports.view')
                                <div class="list-group-item">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle text-decoration-none d-flex align-items-center" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-file-alt me-3"></i>
                                            <span>Reportes Adicionales</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            @permission('reports.export')
                                            <a class="dropdown-item" href="{{ url('/admin/reports/projects/export/pdf') }}">
                                                <i class="fas fa-download me-2"></i>
                                                Exportar PDF Completo
                                            </a>
                                            @endpermission
                                            @permission('reports.impact-statistics')
                                            <a class="dropdown-item" href="{{ route('admin.reports.projects.index') }}">
                                                <i class="fas fa-chart-line me-2"></i>
                                                Análisis de Proyectos
                                            </a>
                                            @endpermission
                                            <div class="dropdown-divider"></div>
                                            <h6 class="dropdown-header">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Próximamente
                                            </h6>
                                            <span class="dropdown-item-text text-muted small">
                                                Reportes de donaciones, beneficiarios y eventos
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endpermission
                            @endhasanyrole
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('logout') }}" class="w-100">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos para el dropdown del usuario */
.dropdown-menu {
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s ease-in-out;
}

.dropdown-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-item {
    transition: background-color 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f8fafc !important;
    color: #1f2937 !important;
}

.dropdown-item:focus {
    background-color: #f1f5f9 !important;
    color: #1f2937 !important;
    outline: none;
}

/* Estilo específico para el botón de cerrar sesión */
.dropdown-item button:hover {
    background-color: #fef2f2 !important;
    color: #b91c1c !important;
}

.dropdown-item button:focus {
    background-color: #fef2f2 !important;
    color: #b91c1c !important;
    outline: none;
}

/* Estilos para el botón de cerrar sesión */
.btn-outline-danger {
    border-color: #dc3545;
    color: #dc3545;
    transition: all 0.3s ease;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
}

.btn-outline-danger:focus {
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

/* Asegurar que el botón esté en la parte inferior */
.mt-auto {
    margin-top: auto !important;
}
</style>

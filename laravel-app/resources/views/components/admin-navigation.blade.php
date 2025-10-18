<nav class="main-sidebar sidebar-dark-primary elevation-4" style="position: fixed;">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('assets/img/habitat-logo.webp') }}" alt="Habitat Guatemala" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ONG Sistema</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/img/default-avatar.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</a>
                <small class="text-muted">
                    @foreach(auth()->user()->roles as $role)
                        {{ $role->name }}
                        @if(!$loop->last), @endif
                    @endforeach
                </small>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- ========================================== --}}
                {{-- MENÚ PARA BENEFICIARIOS (simple y directo) --}}
                {{-- ========================================== --}}
                @role('beneficiary')
                    <!-- Mi Perfil -->
                    <li class="nav-item">
                        <a href="{{ route('users.show', auth()->id()) }}" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Mi Perfil</p>
                        </a>
                    </li>

                    <!-- Mi Proyecto -->
                    @if(auth()->user()->beneficiary && auth()->user()->beneficiary->project)
                    <li class="nav-item">
                        <a href="{{ route('projects.show', auth()->user()->beneficiary->project_id) }}" class="nav-link">
                            <i class="nav-icon fas fa-project-diagram"></i>
                            <p>Mi Proyecto</p>
                        </a>
                    </li>
                    @endif

                    <!-- Mis Beneficios -->
                    @if(auth()->user()->beneficiary)
                    <li class="nav-item">
                        <a href="{{ route('beneficiaries.show', auth()->user()->beneficiary->id) }}" class="nav-link">
                            <i class="nav-icon fas fa-gift"></i>
                            <p>Mis Beneficios</p>
                        </a>
                    </li>
                    @endif
                @endrole

                {{-- ========================================== --}}
                {{-- MENÚ PARA DONANTES (acceso limitado) --}}
                {{-- ========================================== --}}
                @role('donor')
                    <!-- Mis Donaciones -->
                    @permission('donations.view.own')
                    <li class="nav-item">
                        <a href="{{ route('donations.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>Mis Donaciones</p>
                        </a>
                    </li>
                    @endpermission
                    
                    <!-- Registrar Donación -->
                    @permission('donations.create')
                    <li class="nav-item">
                        <a href="{{ route('donations.create') }}" class="nav-link">
                            <i class="nav-icon fas fa-plus-circle"></i>
                            <p>Registrar Donación</p>
                        </a>
                    </li>
                    @endpermission
                @endrole

                {{-- ========================================== --}}
                {{-- MENÚ PARA ROLES ADMINISTRATIVOS --}}
                {{-- ========================================== --}}
                @hasanyrole('super-admin', 'admin', 'project-coordinator', 'beneficiary-coordinator', 'volunteer', 'consultant')
                
                    <!-- Gestión de Usuarios (SOLO roles administrativos) -->
                    @permission('users.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Usuarios
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @permission('users.view')
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Usuarios</p>
                                </a>
                            </li>
                            @endpermission
                            @permission('users.create')
                            <li class="nav-item">
                                <a href="{{ route('users.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Crear Usuario</p>
                                </a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission

                    <!-- Gestión de Proyectos (SOLO roles administrativos) -->
                    @permission('projects.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-project-diagram"></i>
                            <p>
                                Proyectos
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @permission('projects.view')
                            <li class="nav-item">
                                <a href="{{ route('projects.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Proyectos</p>
                                </a>
                            </li>
                            @endpermission
                            @permission('projects.create')
                            <li class="nav-item">
                                <a href="{{ route('projects.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Crear Proyecto</p>
                                </a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission

                    <!-- Gestión de Beneficiarios (SOLO roles administrativos) -->
                    @permission('beneficiaries.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-heart"></i>
                            <p>
                                Beneficiarios
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @permission('beneficiaries.view')
                            <li class="nav-item">
                                <a href="{{ route('beneficiaries.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Beneficiarios</p>
                                </a>
                            </li>
                            @endpermission
                            @permission('beneficiaries.create')
                            <li class="nav-item">
                                <a href="{{ route('beneficiaries.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Crear Beneficiario</p>
                                </a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission

                    <!-- Gestión de Ubicaciones -->
                    @permission('locations.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-map-marker-alt"></i>
                            <p>
                                Ubicaciones
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @permission('locations.view')
                            <li class="nav-item">
                                <a href="{{ route('locations.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Ubicaciones</p>
                                </a>
                            </li>
                            @endpermission
                            @permission('locations.create')
                            <li class="nav-item">
                                <a href="{{ route('locations.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Crear Ubicación</p>
                                </a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission

                    <!-- Gestión de Patrocinadores -->
                    @permission('sponsors.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>
                                Patrocinadores
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @permission('sponsors.view')
                            <li class="nav-item">
                                <a href="{{ route('sponsors.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Patrocinadores</p>
                                </a>
                            </li>
                            @endpermission
                            @permission('sponsors.create')
                            <li class="nav-item">
                                <a href="{{ route('sponsors.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Crear Patrocinador</p>
                                </a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission

                    <!-- Gestión de Eventos -->
                    @permission('events.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>
                                Eventos
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @permission('events.view')
                            <li class="nav-item">
                                <a href="{{ route('events.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Eventos</p>
                                </a>
                            </li>
                            @endpermission
                            @permission('events.create')
                            <li class="nav-item">
                                <a href="{{ route('events.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Crear Evento</p>
                                </a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission

                    <!-- Gestión de Donaciones -->
                    @permission('donations.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>
                                Donaciones
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @permission('donations.view')
                            <li class="nav-item">
                                <a href="{{ route('donations.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Donaciones</p>
                                </a>
                            </li>
                            @endpermission
                            @permission('donations.create')
                            <li class="nav-item">
                                <a href="{{ route('donations.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Registrar Donación</p>
                                </a>
                            </li>
                            @endpermission
                            @permission('donations.reports')
                            <li class="nav-item">
                                <a href="{{ route('donations.reports') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Reportes de Donaciones</p>
                                </a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission

                    <!-- Gestión de Productos -->
                    @permission('products.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-box"></i>
                            <p>
                                Productos
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @permission('products.view')
                            <li class="nav-item">
                                <a href="{{ route('products.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Productos</p>
                                </a>
                            </li>
                            @endpermission
                            @permission('products.create')
                            <li class="nav-item">
                                <a href="{{ route('products.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Crear Producto</p>
                                </a>
                            </li>
                            @endpermission
                            @permission('products.catalog')
                            <li class="nav-item">
                                <a href="{{ route('products.catalog') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Catálogo Público</p>
                                </a>
                            </li>
                            @endpermission
                            @permission('products.statistics')
                            <li class="nav-item">
                                <a href="{{ route('products.statistics') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Estadísticas</p>
                                </a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission

                    <!-- Reportes -->
                    @permission('reports.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>
                                Reportes
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @permission('reports.impact-statistics')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Estadísticas de Impacto</p>
                                </a>
                            </li>
                            @endpermission
                            @permission('reports.export')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Exportar Informes</p>
                                </a>
                            </li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission

                @endhasanyrole

                <!-- Logout (para todos) -->
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-left w-100" style="border: none; background: none;">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Cerrar Sesión</p>
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</nav>

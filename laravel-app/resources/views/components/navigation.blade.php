<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 fixed">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <i class="fas fa-hands-helping brand-image"></i>
        <span class="brand-text font-weight-light">Sistema ONG</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                         class="img-circle elevation-2" 
                         alt="User Image">
                @else
                    <div class="img-circle elevation-2 bg-primary d-flex align-items-center justify-content-center" 
                         style="width: 2.1rem; height: 2.1rem;">
                        <i class="fas fa-user text-white"></i>
                    </div>
                @endif
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->full_name }}</a>
                <small class="text-muted">
                    @foreach(auth()->user()->roles as $role)
                        {{ $role->name }}@if(!$loop->last), @endif
                    @endforeach
                </small>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Administración del Sistema -->
                @anypermission(['users.view', 'users.create', 'users.edit', 'roles.manage', 'permissions.manage', 'settings.manage'])
                <li class="nav-item has-treeview {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Administración
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @permission('users.view')
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('users.create')
                        <li class="nav-item">
                            <a href="{{ route('users.create') }}" class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                <i class="fas fa-user-plus nav-icon"></i>
                                <p>Crear Usuario</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('roles.manage')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-user-tag nav-icon"></i>
                                <p>Gestionar Roles</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('permissions.manage')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-key nav-icon"></i>
                                <p>Gestionar Permisos</p>
                            </a>
                        </li>
                        @endpermission
                    </ul>
                </li>
                @endanypermission

                <!-- Gestión de Proyectos -->
                @anypermission(['projects.view', 'projects.create', 'projects.edit'])
                <li class="nav-item has-treeview {{ request()->routeIs('projects.*') ? 'menu-open' : '' }}">
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
                            <a href="{{ route('projects.index') }}" class="nav-link {{ request()->routeIs('projects.index') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Listar Proyectos</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('projects.create')
                        <li class="nav-item">
                            <a href="{{ route('projects.create') }}" class="nav-link {{ request()->routeIs('projects.create') ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Crear Proyecto</p>
                            </a>
                        </li>
                        @endpermission
                    </ul>
                </li>
                @endanypermission

                <!-- Gestión de Beneficiarios -->
                @anypermission(['beneficiaries.view', 'beneficiaries.create', 'beneficiaries.edit'])
                <li class="nav-item has-treeview {{ request()->routeIs('beneficiaries.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Beneficiarios
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @permission('beneficiaries.view')
                        <li class="nav-item">
                            <a href="{{ route('beneficiaries.index') }}" class="nav-link {{ request()->routeIs('beneficiaries.index') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Listar Beneficiarios</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('beneficiaries.create')
                        <li class="nav-item">
                            <a href="{{ route('beneficiaries.create') }}" class="nav-link {{ request()->routeIs('beneficiaries.create') ? 'active' : '' }}">
                                <i class="fas fa-user-plus nav-icon"></i>
                                <p>Registrar Beneficiario</p>
                            </a>
                        </li>
                        @endpermission
                    </ul>
                </li>
                @endanypermission

                <!-- Gestión de Donaciones -->
                @anypermission(['donations.view', 'donations.create', 'donations.edit'])
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-hand-holding-heart"></i>
                        <p>
                            Donaciones
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @permission('donations.view')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Listar Donaciones</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('donations.create')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Registrar Donación</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('donations.reports')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-chart-line nav-icon"></i>
                                <p>Reportes de Donaciones</p>
                            </a>
                        </li>
                        @endpermission
                    </ul>
                </li>
                @endanypermission

                <!-- Gestión de Productos/Recursos -->
                @anypermission(['products.view', 'products.register-stock', 'products.control-inventory'])
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>
                            Inventario
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @permission('products.view')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Ver Inventario</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('products.register-stock')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Registrar Stock</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('products.control-inventory')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-clipboard-check nav-icon"></i>
                                <p>Control de Inventario</p>
                            </a>
                        </li>
                        @endpermission
                    </ul>
                </li>
                @endanypermission

                <!-- Ubicaciones -->
                @anypermission(['locations.view', 'locations.create', 'locations.edit'])
                <li class="nav-item has-treeview {{ request()->routeIs('locations.*') ? 'menu-open' : '' }}">
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
                            <a href="{{ route('locations.index') }}" class="nav-link {{ request()->routeIs('locations.index') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Listar Ubicaciones</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('locations.create')
                        <li class="nav-item">
                            <a href="{{ route('locations.create') }}" class="nav-link {{ request()->routeIs('locations.create') ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Crear Ubicación</p>
                            </a>
                        </li>
                        @endpermission
                    </ul>
                </li>
                @endanypermission

                <!-- Actividades -->
                @anypermission(['activities.view', 'activities.register-attendance', 'activities.register-deliveries'])
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Actividades
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @permission('activities.view')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Ver Actividades</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('activities.register-attendance')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-clipboard-check nav-icon"></i>
                                <p>Registrar Asistencia</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('activities.register-deliveries')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-truck nav-icon"></i>
                                <p>Registrar Entregas</p>
                            </a>
                        </li>
                        @endpermission
                    </ul>
                </li>
                @endanypermission

                <!-- Reportes -->
                @anypermission(['reports.view', 'reports.impact-statistics', 'reports.export'])
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Reportes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @permission('reports.view')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-chart-line nav-icon"></i>
                                <p>Ver Reportes</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('reports.impact-statistics')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-chart-pie nav-icon"></i>
                                <p>Estadísticas de Impacto</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('reports.export')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-download nav-icon"></i>
                                <p>Exportar Informes</p>
                            </a>
                        </li>
                        @endpermission
                    </ul>
                </li>
                @endanypermission


                <!-- Auditoría -->
                @anypermission(['audit.view-history', 'audit.view-logs'])
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-history"></i>
                        <p>
                            Auditoría
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @permission('audit.view-history')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-history nav-icon"></i>
                                <p>Historial de Cambios</p>
                            </a>
                        </li>
                        @endpermission

                        @permission('audit.view-logs')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Logs del Sistema</p>
                            </a>
                        </li>
                        @endpermission
                    </ul>
                </li>
                @endanypermission

                <!-- Configuración -->
                @permission('settings.manage')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Configuración</p>
                    </a>
                </li>
                @endpermission

            </ul>
        </nav>
    </div>
</aside>

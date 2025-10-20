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
                        {{ $role->name }}@if(!$loop->last), @endif
                    @endforeach
                </small>
            </div>
        </div>

        @php
            // Resolver rutas de Events
            $evIndex  = Route::has('admin.events.index') ? 'admin.events.index' : (Route::has('events.index') ? 'events.index' : null);
            $evCreate = Route::has('admin.events.create') ? 'admin.events.create' : (Route::has('events.create') ? 'events.create' : null);

            // Resolver rutas de Donations
            $donIndex = Route::has('admin.donations.index') ? 'admin.donations.index' : (Route::has('donations.index') ? 'donations.index' : null);
            $donCreate= Route::has('admin.donations.create') ? 'admin.donations.create' : (Route::has('donations.create') ? 'donations.create' : null);
            $donRpt   = Route::has('admin.donations.reports') ? 'admin.donations.reports' : (Route::has('donations.reports') ? 'donations.reports' : null);

            // Proyectos admin
            $projAdminIndex = Route::has('admin.projects.index') ? 'admin.projects.index' : (Route::has('projects.index') ? 'projects.index' : null);
        @endphp

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

                {{-- ====================== --}}
                {{-- MENÚ: BENEFICIARIOS   --}}
                {{-- ====================== --}}
                @role('beneficiary')
                    <li class="nav-item">
                        <a href="{{ route('users.show', auth()->id()) }}" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Mi Perfil</p>
                        </a>
                    </li>

                    @if(auth()->user()->beneficiary && auth()->user()->beneficiary->project)
                    <li class="nav-item">
                        <a href="{{ route('projects.show', auth()->user()->beneficiary->project_id) }}" class="nav-link">
                            <i class="nav-icon fas fa-project-diagram"></i>
                            <p>Mi Proyecto</p>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->beneficiary)
                    <li class="nav-item">
                        <a href="{{ route('beneficiaries.show', auth()->user()->beneficiary->id) }}" class="nav-link">
                            <i class="nav-icon fas fa-gift"></i>
                            <p>Mis Beneficios</p>
                        </a>
                    </li>
                    @endif
                @endrole

                {{-- ====================== --}}
                {{-- MENÚ: DONANTES        --}}
                {{-- ====================== --}}
                @role('donor')
                    @permission('donations.view.own')
                    @if($donIndex)
                    <li class="nav-item">
                        <a href="{{ route($donIndex) }}" class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>Mis Donaciones</p>
                        </a>
                    </li>
                    @endif
                    @endpermission

                    @permission('donations.create')
                    @if($donCreate)
                    <li class="nav-item">
                        <a href="{{ route($donCreate) }}" class="nav-link">
                            <i class="nav-icon fas fa-plus-circle"></i>
                            <p>Registrar Donación</p>
                        </a>
                    </li>
                    @endif
                    @endpermission
                @endrole

                {{-- =============================== --}}
                {{-- MENÚ: ROLES ADMINISTRATIVOS     --}}
                {{-- =============================== --}}
                @hasanyrole('super-admin|admin|project-coordinator|beneficiary-coordinator|volunteer|consultant')

                    <!-- Usuarios -->
                    @permission('users.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Usuarios <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Usuarios</p>
                                </a>
                            </li>
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

                    <!-- Proyectos -->
                    @permission('projects.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-project-diagram"></i>
                            <p>Proyectos <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('projects.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Proyectos</p>
                                </a>
                            </li>
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

                    <!-- Beneficiarios -->
                    @permission('beneficiaries.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-heart"></i>
                            <p>Beneficiarios <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('beneficiaries.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Beneficiarios</p>
                                </a>
                            </li>
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

                    <!-- Ubicaciones -->
                    @permission('locations.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-map-marker-alt"></i>
                            <p>Ubicaciones <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('locations.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Ubicaciones</p>
                                </a>
                            </li>
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

                    <!-- Patrocinadores -->
                    @permission('sponsors.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>Patrocinadores <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('sponsors.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Patrocinadores</p>
                                </a>
                            </li>
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

                    <!-- Eventos (con lógica segura) -->
                    @permission('events.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>Eventos <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if($evIndex)
                            <li class="nav-item">
                                <a href="{{ route($evIndex) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Eventos</p>
                                </a>
                            </li>
                            @endif
                            @permission('events.create')
                            @if($evCreate)
                            <li class="nav-item">
                                <a href="{{ route($evCreate) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Crear Evento</p>
                                </a>
                            </li>
                            @endif
                            @endpermission
                        </ul>
                    </li>
                    @endpermission

                    <!-- Donaciones (con lógica segura) -->
                    @permission('donations.view')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>Donaciones <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if($donIndex)
                            <li class="nav-item">
                                <a href="{{ route($donIndex) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Donaciones</p>
                                </a>
                            </li>
                            @endif
                            @permission('donations.create')
                            @if($donCreate)
                            <li class="nav-item">
                                <a href="{{ route($donCreate) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Registrar Donación</p>
                                </a>
                            </li>
                            @endif
                            @endpermission
                            @permission('donations.reports')
                            @if($donRpt)
                            <li class="nav-item">
                                <a href="{{ route($donRpt) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Reportes de Donaciones</p>
                                </a>
                            </li>
                            @endif
                            @endpermission
                        </ul>
                    </li>
                    @endpermission

                    <!-- Secciones -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-th-large nav-icon"></i>
                            <p>Secciones <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.hero.index') }}" class="nav-link {{ request()->routeIs('admin.hero.*') ? 'active' : '' }}">
                                    <i class="fas fa-star nav-icon"></i>
                                    <p>Hero</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.about.index') }}" class="nav-link">
                                    <i class="fas fa-info-circle nav-icon"></i>
                                    <p>Sobre Nosotros</p>
                                </a>
                            </li>
                            @if($evIndex)
                            <li class="nav-item">
                                <a href="{{ route($evIndex) }}" class="nav-link">
                                    <i class="fas fa-calendar-alt nav-icon"></i>
                                    <p>Eventos</p>
                                </a>
                            </li>
                            @endif
                            @if($projAdminIndex)
                            <li class="nav-item">
                                <a href="{{ route($projAdminIndex) }}" class="nav-link">
                                    <i class="fas fa-briefcase nav-icon"></i>
                                    <p>Proyectos</p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>

                @endhasanyrole

                <!-- Logout -->
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

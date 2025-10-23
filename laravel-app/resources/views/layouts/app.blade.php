<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ONG Management System')</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo-pestañas.ico') }}" rel="icon" type="image/x-icon">
    <link href="{{ asset('assets/img/logo-pestañas.ico') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    {{-- FIX visual: empujar contenido cuando el sidebar/header son fixed --}}
    <style>
      :root { --sidebar-w: 250px; --header-h: 56px; }

      /* Sidebar fijo */
      .main-sidebar { position: fixed !important; top: 0; left: 0; width: var(--sidebar-w); height: 100vh; overflow-y: auto; }

      /* Header fijo (si tu <x-header-admin/> genera un topbar en .main-header o <nav> superior) */
      .main-header { position: fixed; top: 0; left: var(--sidebar-w); right: 0; z-index: 1030; }

      /* Empujar contenido y footer */
      .content-wrapper, .main-footer { margin-left: var(--sidebar-w); }

      /* Evitar que el contenido quede debajo del header */
      .content-wrapper { padding-top: var(--header-h); min-height: calc(100vh - var(--header-h)); }

      /* Alto coherente del logo del sidebar */
      .brand-link { height: 57px; display: flex; align-items: center; }

      /* Evitar wraps feos en el menú */
      [data-widget="treeview"] .nav-link { white-space: nowrap; }
    </style>

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div id="app" class="wrapper">

    {{-- TOP BAR / HEADERS --}}
    <x-head-admin />
    <x-header-admin /> {{-- asegúrate que este contenedor use clase .main-header si es un nav fijo --}}

    {{-- SIDEBAR (tu componente/blade con el <nav class="main-sidebar ...">) --}}
    {{-- Usa el que tengas: <x-admin-navigation /> o @include('components.admin-navigation') --}}
    @hasSection('sidebar')
        @yield('sidebar')
    @else
        @includeIf('components.admin-navigation')
    @endif

    {{-- CONTENT --}}
    <div class="content-wrapper">
        {{-- Encabezado de página (opcional) --}}
        <div class="content-header">
            <div class="container-fluid">
                <h4 class="m-0">@yield('header', 'Inicio')</h4>
            </div>
        </div>

        {{-- Contenido principal --}}
        <section class="content">
            <div class="container-fluid">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle"></i> {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </section>
    </div>

    {{-- FOOTER --}}
    <x-footer-admin />

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Visitor Tracking JS -->
<script src="{{ asset('assets/js/visitor-tracking.js') }}"></script>

@stack('scripts')
</body>
</html>

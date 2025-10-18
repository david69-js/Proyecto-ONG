<!DOCTYPE html>
<html>
<head>
    <title>Test Sidebar Debug</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/tabler-custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="page">
        <!-- Sidebar Debug -->
        <x-tabler-sidebar-debug />
        
        <!-- Wrapper -->
        <div class="page-wrapper">
            <div class="container-xl">
                <h1>Test Sidebar Debug</h1>
                <p>Si ves el sidebar con todos los módulos (Usuarios, Proyectos, etc.), está funcionando correctamente.</p>
                
                <div class="alert alert-info">
                    <h4>Información del Usuario:</h4>
                    <p><strong>Nombre:</strong> {{ auth()->user()->full_name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ auth()->user()->email ?? 'N/A' }}</p>
                    <p><strong>Roles:</strong> 
                        @foreach(auth()->user()->roles as $role)
                            {{ $role->name }}
                            @if(!$loop->last), @endif
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
    <script src="{{ asset('assets/js/tabler-custom.js') }}"></script>
</body>
</html>

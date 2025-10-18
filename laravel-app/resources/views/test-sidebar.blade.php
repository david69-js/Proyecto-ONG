<!DOCTYPE html>
<html>
<head>
    <title>Test Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/tabler-custom.css') }}" rel="stylesheet">
</head>
<body>
    <div class="page">
        <!-- Sidebar -->
        <x-tabler-sidebar />
        
        <!-- Wrapper -->
        <div class="page-wrapper">
            <h1>Test Sidebar</h1>
            <p>Si ves el sidebar con borde rojo, está funcionando.</p>
        </div>
    </div>
</body>
</html>

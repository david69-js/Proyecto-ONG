@echo off
echo ========================================
echo    INSTALACION DEL MODULO DE DONACIONES
echo ========================================
echo.

echo [1/4] Ejecutando migraciones...
php artisan migrate
if %errorlevel% neq 0 (
    echo ERROR: Fallo al ejecutar migraciones
    pause
    exit /b 1
)

echo.
echo [2/4] Ejecutando seeders de permisos...
php artisan db:seed --class=PermissionSeeder
if %errorlevel% neq 0 (
    echo ERROR: Fallo al ejecutar seeder de permisos
    pause
    exit /b 1
)

echo.
echo [3/4] Ejecutando seeder de donaciones...
php artisan db:seed --class=DonationSeeder
if %errorlevel% neq 0 (
    echo ERROR: Fallo al ejecutar seeder de donaciones
    pause
    exit /b 1
)

echo.
echo [4/4] Limpiando cache...
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo.
echo ========================================
echo    INSTALACION COMPLETADA EXITOSAMENTE
echo ========================================
echo.
echo El modulo de donaciones ha sido instalado correctamente.
echo.
echo Caracteristicas disponibles:
echo - Gestion completa de donaciones
echo - Tipos: Monetaria, Materiales, Servicios, Voluntariado, Mixta
echo - Estados: Pendiente, Confirmada, Procesada, Rechazada, Cancelada
echo - Reportes y estadisticas
echo - Exportacion de datos
echo - Control de permisos granular
echo.
echo Rutas principales:
echo - /donations - Lista de donaciones
echo - /donations/create - Crear donacion
echo - /donations/reports - Reportes y estadisticas
echo.
pause

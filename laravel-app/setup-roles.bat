@echo off
echo ==================================================
echo   Configuracion del Sistema de Roles y Permisos
echo ==================================================
echo.

echo Paso 1: Ejecutando migraciones...
php artisan migrate --force

if %errorlevel% neq 0 (
    echo Error al ejecutar migraciones
    exit /b 1
)
echo Migraciones ejecutadas correctamente
echo.

echo Paso 2: Ejecutando seeders...

echo   - RoleSeeder...
php artisan db:seed --class=RoleSeeder --force

if %errorlevel% neq 0 (
    echo Error al crear roles
    exit /b 1
)
echo   Roles creados

echo   - PermissionSeeder...
php artisan db:seed --class=PermissionSeeder --force

if %errorlevel% neq 0 (
    echo Error al crear permisos
    exit /b 1
)
echo   Permisos creados

echo   - RolePermissionSeeder...
php artisan db:seed --class=RolePermissionSeeder --force

if %errorlevel% neq 0 (
    echo Error al asignar permisos
    exit /b 1
)
echo   Permisos asignados a roles

echo.
echo Paso 3: Limpiando cache...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo.
echo ==================================================
echo   Configuracion completada exitosamente!
echo ==================================================
echo.
echo Resumen de roles creados:
echo   1. Super Administrador (super-admin)
echo   2. Administrador (admin)
echo   3. Coordinador de Proyectos (project-coordinator)
echo   4. Coordinador de Beneficiarios (beneficiary-coordinator)
echo   5. Voluntario (volunteer)
echo   6. Consultor (consultant)
echo   7. Donante (donor)
echo   8. Beneficiario (beneficiary) NUEVO
echo.
echo Documentacion disponible:
echo   - RESUMEN_IMPLEMENTACION_ROLES.md
echo   - SETUP_ROLES_PERMISSIONS.md
echo   - BLADE_DIRECTIVES_GUIDE.md
echo.
echo Para verificar, ejecuta:
echo   php artisan tinker
echo   \App\Models\Role::all(['name', 'slug']);
echo.
pause


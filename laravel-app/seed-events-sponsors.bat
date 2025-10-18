@echo off
echo ========================================
echo    SEEDERS DE EVENTOS Y PATROCINADORES
echo ========================================
echo.

echo Ejecutando seeder de patrocinadores...
docker-compose exec app php artisan db:seed --class=SponsorSeeder
if %errorlevel% neq 0 (
    echo ERROR: No se pudo ejecutar el seeder de patrocinadores
    pause
    exit /b 1
)

echo.
echo Ejecutando seeder de eventos...
docker-compose exec app php artisan db:seed --class=EventSeeder
if %errorlevel% neq 0 (
    echo ERROR: No se pudo ejecutar el seeder de eventos
    pause
    exit /b 1
)

echo.
echo Ejecutando seeder de inscripciones de eventos...
docker-compose exec app php artisan db:seed --class=EventRegistrationSeeder
if %errorlevel% neq 0 (
    echo ERROR: No se pudo ejecutar el seeder de inscripciones
    pause
    exit /b 1
)

echo.
echo ========================================
echo    SEEDERS COMPLETADOS EXITOSAMENTE
echo ========================================
echo.
echo Los siguientes datos han sido creados:
echo - Patrocinadores con asociaciones a proyectos
echo - Eventos de diferentes tipos
echo - Inscripciones de eventos
echo.
pause

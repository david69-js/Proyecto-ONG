#!/bin/bash

echo "=================================================="
echo "  Configuración del Sistema de Roles y Permisos"
echo "=================================================="
echo ""

echo "📦 Paso 1: Ejecutando migraciones..."
php artisan migrate --force

if [ $? -eq 0 ]; then
    echo "✅ Migraciones ejecutadas correctamente"
else
    echo "❌ Error al ejecutar migraciones"
    exit 1
fi

echo ""
echo "🌱 Paso 2: Ejecutando seeders..."

echo "  - RoleSeeder..."
php artisan db:seed --class=RoleSeeder --force

if [ $? -eq 0 ]; then
    echo "  ✅ Roles creados"
else
    echo "  ❌ Error al crear roles"
    exit 1
fi

echo "  - PermissionSeeder..."
php artisan db:seed --class=PermissionSeeder --force

if [ $? -eq 0 ]; then
    echo "  ✅ Permisos creados"
else
    echo "  ❌ Error al crear permisos"
    exit 1
fi

echo "  - RolePermissionSeeder..."
php artisan db:seed --class=RolePermissionSeeder --force

if [ $? -eq 0 ]; then
    echo "  ✅ Permisos asignados a roles"
else
    echo "  ❌ Error al asignar permisos"
    exit 1
fi

echo ""
echo "🧹 Paso 3: Limpiando caché..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo ""
echo "=================================================="
echo "  ✅ Configuración completada exitosamente!"
echo "=================================================="
echo ""
echo "📋 Resumen de roles creados:"
echo "  1. Super Administrador (super-admin)"
echo "  2. Administrador (admin)"
echo "  3. Coordinador de Proyectos (project-coordinator)"
echo "  4. Coordinador de Beneficiarios (beneficiary-coordinator)"
echo "  5. Voluntario (volunteer)"
echo "  6. Consultor (consultant)"
echo "  7. Donante (donor)"
echo "  8. Beneficiario (beneficiary) ⭐ NUEVO"
echo ""
echo "📖 Documentación disponible:"
echo "  - RESUMEN_IMPLEMENTACION_ROLES.md"
echo "  - SETUP_ROLES_PERMISSIONS.md"
echo "  - BLADE_DIRECTIVES_GUIDE.md"
echo ""
echo "🧪 Para verificar, ejecuta:"
echo "  php artisan tinker"
echo "  \App\Models\Role::all(['name', 'slug']);"
echo ""


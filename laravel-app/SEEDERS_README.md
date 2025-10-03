# Seeders de la Aplicación ONG

Este documento describe los seeders creados para poblar la base de datos con información por defecto.

## Seeders Disponibles

### 1. RoleSeeder
Crea los roles del sistema:
- **Super Administrador**: Acceso completo al sistema
- **Administrador**: Administrador con permisos amplios
- **Coordinador de Proyectos**: Coordina y supervisa proyectos
- **Coordinador de Beneficiarios**: Gestiona información de beneficiarios
- **Voluntario**: Acceso limitado al sistema
- **Consultor**: Acceso de solo lectura
- **Donante**: Acceso limitado a reportes

### 2. PermissionSeeder
Crea los permisos del sistema organizados por módulos:
- **Usuarios**: Ver, crear, editar, eliminar, gestionar permisos
- **Proyectos**: Ver, crear, editar, eliminar
- **Beneficiarios**: Ver, crear, editar, eliminar
- **Ubicaciones**: Ver, crear, editar, eliminar
- **Roles**: Gestionar roles y permisos
- **Reportes**: Ver reportes, exportar datos
- **Configuración**: Gestionar configuración del sistema

### 3. RolePermissionSeeder
Asigna permisos a los roles según su nivel de acceso:
- **Super Administrador**: Todos los permisos
- **Administrador**: Todos excepto gestión de roles y configuración
- **Coordinador de Proyectos**: Permisos relacionados con proyectos y usuarios
- **Coordinador de Beneficiarios**: Permisos relacionados con beneficiarios
- **Voluntario**: Solo lectura básica
- **Consultor**: Solo lectura con acceso a reportes
- **Donante**: Solo visualización de proyectos y reportes

### 4. UserSeeder
Crea usuarios de ejemplo con perfiles completos:
- **admin@ong.com** - Super Administrador (password: password123)
- **coordinador@ong.com** - Administrador (password: password123)
- **proyectos@ong.com** - Coordinador de Proyectos (password: password123)
- **beneficiarios@ong.com** - Coordinador de Beneficiarios (password: password123)
- **voluntario@ong.com** - Voluntario (password: password123)
- **consultor@ong.com** - Consultor (password: password123)

### 5. LocationSeeder
Crea 15 ubicaciones de ejemplo en diferentes estados de México:
- Centros comunitarios
- Escuelas rurales
- Centros de salud
- Centros de capacitación
- Comunidades rurales
- Reservas naturales

### 6. ProjectSeeder
Crea 7 proyectos de ejemplo:
- **Educación Comunitaria Rural**: Mejora del acceso a la educación
- **Salud Preventiva Infantil**: Programas de vacunación y nutrición
- **Desarrollo Empresarial Femenino**: Capacitación para mujeres emprendedoras
- **Agua Potable y Saneamiento**: Sistemas de purificación de agua
- **Apoyo a Adultos Mayores**: Atención integral a adultos mayores
- **Capacitación Técnica Juvenil**: Formación técnica para jóvenes
- **Conservación Ambiental Comunitaria**: Reforestación y educación ambiental

### 7. BeneficiarySeeder
Crea 16 beneficiarios de ejemplo:
- Personas individuales
- Familias
- Comunidades
- Asignados a diferentes proyectos
- Con información completa de contacto

## Cómo Ejecutar los Seeders

### Ejecutar todos los seeders:
```bash
php artisan db:seed
```

### Ejecutar un seeder específico:
```bash
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=UserSeeder
# etc.
```

### Refrescar la base de datos y ejecutar seeders:
```bash
php artisan migrate:refresh --seed
```

## Datos de Acceso

Después de ejecutar los seeders, puedes acceder al sistema con cualquiera de estos usuarios:

| Email | Contraseña | Rol |
|-------|------------|-----|
| admin@ong.com | password123 | Super Administrador |
| coordinador@ong.com | password123 | Administrador |
| proyectos@ong.com | password123 | Coordinador de Proyectos |
| beneficiarios@ong.com | password123 | Coordinador de Beneficiarios |
| voluntario@ong.com | password123 | Voluntario |
| consultor@ong.com | password123 | Consultor |

## Estructura de Datos Creada

- **7 roles** con diferentes niveles de acceso
- **22 permisos** organizados por módulos
- **6 usuarios** con perfiles completos y roles asignados
- **15 ubicaciones** en diferentes estados de México
- **7 proyectos** con información detallada y responsables asignados
- **16 beneficiarios** asignados a diferentes proyectos

## Notas Importantes

1. Los seeders usan `updateOrCreate()` para evitar duplicados
2. Los usuarios tienen contraseñas hasheadas con `Hash::make()`
3. Los proyectos están asignados a coordinadores existentes
4. Los beneficiarios están vinculados a proyectos específicos
5. Todos los datos son realistas y representativos de una ONG real

## Personalización

Para personalizar los datos, edita los archivos de seeder correspondientes en `database/seeders/` y ejecuta:
```bash
php artisan db:seed --class=NombreDelSeeder
```

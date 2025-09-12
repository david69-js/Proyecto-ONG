# Sistema de Jerarquía de Base de Datos

Este documento describe el sistema de jerarquía implementado para todas las tablas de la base de datos del sistema ONG.

## Principios de la Jerarquía

### Sistema de Prefijos Numéricos
Cada tabla tiene un prefijo numérico que indica su nivel en la jerarquía del sistema:

- **00_** - Tablas base del sistema (core system tables)
- **10_** - Tablas de configuración y metadatos (configuration tables)
- **20_** - Tablas de perfiles y datos extendidos (profile and extended data)
- **30_** - Tablas de relaciones many-to-many (relationship tables)
- **40_** - Tablas de contenido principal (main content tables)
- **50_** - Tablas de contenido secundario (secondary content tables)
- **60_** - Tablas de logs y auditoría (logging and audit tables)

### Sistema de Prefijos de Categoría
Además del número, cada tabla tiene un prefijo de categoría:

- **sys_** - Tablas del sistema (system tables)
- **cfg_** - Tablas de configuración (configuration tables)
- **usr_** - Tablas de usuarios (user tables)
- **rel_** - Tablas de relaciones (relationship tables)
- **cnt_** - Tablas de contenido (content tables)
- **log_** - Tablas de logs (logging tables)

## Estructura de Tablas Implementada

### 00_ - Tablas Base del Sistema

| Migración | Tabla | Descripción | Dependencias |
|-----------|-------|-------------|--------------|
| `00_01_system_users` | `sys_users` | Usuarios principales del sistema | Ninguna |
| `00_02_system_sessions` | `sys_sessions` | Sesiones de usuario | `sys_users` |
| `00_03_system_cache` | `sys_cache` | Cache del sistema | Ninguna |
| `00_04_system_jobs` | `sys_jobs` | Cola de trabajos | Ninguna |

### 10_ - Tablas de Configuración

| Migración | Tabla | Descripción | Dependencias |
|-----------|-------|-------------|--------------|
| `10_01_config_roles` | `cfg_roles` | Roles del sistema | Ninguna |
| `10_02_config_permissions` | `cfg_permissions` | Permisos del sistema | Ninguna |

### 20_ - Tablas de Perfiles

| Migración | Tabla | Descripción | Dependencias |
|-----------|-------|-------------|--------------|
| `20_01_user_profiles` | `usr_profiles` | Perfiles extendidos de usuarios | `sys_users` |

### 30_ - Tablas de Relaciones

| Migración | Tabla | Descripción | Dependencias |
|-----------|-------|-------------|--------------|
| `30_01_rel_user_roles` | `rel_user_roles` | Relación usuarios-roles | `sys_users`, `cfg_roles` |
| `30_02_rel_role_permissions` | `rel_role_permissions` | Relación roles-permisos | `cfg_roles`, `cfg_permissions` |
| `30_03_rel_user_permissions` | `rel_user_permissions` | Relación usuarios-permisos | `sys_users`, `cfg_permissions` |

## Orden de Ejecución de Migraciones

Las migraciones se ejecutan en el siguiente orden para respetar las dependencias:

1. **Sistema Base (00_)**
   - `00_01_system_users` - Tabla principal de usuarios
   - `00_02_system_sessions` - Sesiones (depende de sys_users)
   - `00_03_system_cache` - Cache del sistema
   - `00_04_system_jobs` - Cola de trabajos

2. **Configuración (10_)**
   - `10_01_config_roles` - Roles del sistema
   - `10_02_config_permissions` - Permisos del sistema

3. **Perfiles (20_)**
   - `20_01_user_profiles` - Perfiles de usuario (depende de sys_users)

4. **Relaciones (30_)**
   - `30_01_rel_user_roles` - Relación usuarios-roles
   - `30_02_rel_role_permissions` - Relación roles-permisos
   - `30_03_rel_user_permissions` - Relación usuarios-permisos

## Convenciones de Nomenclatura

### Nombres de Tablas
- Formato: `{categoria}_{nombre_descriptivo}`
- Ejemplos:
  - `sys_users` - Usuarios del sistema
  - `cfg_roles` - Roles de configuración
  - `usr_profiles` - Perfiles de usuario
  - `rel_user_roles` - Relación usuarios-roles

### Nombres de Migraciones
- Formato: `{año}_{mes}_{dia}_{hora}_{categoria}_{numero}_{descripcion}`
- Ejemplos:
  - `2025_09_12_010256_00_01_system_users`
  - `2025_09_12_010316_10_01_config_roles`

### Claves Foráneas
- Formato: `{tabla_referenciada}_id`
- Ejemplos:
  - `user_id` - Referencia a sys_users
  - `role_id` - Referencia a cfg_roles
  - `permission_id` - Referencia a cfg_permissions

## Beneficios del Sistema

1. **Claridad**: Es fácil identificar el tipo y propósito de cada tabla
2. **Orden**: Las migraciones se ejecutan en el orden correcto automáticamente
3. **Mantenibilidad**: Fácil agregar nuevas tablas siguiendo la jerarquía
4. **Escalabilidad**: El sistema puede crecer manteniendo la organización
5. **Documentación**: La estructura es auto-documentada

## Ejemplos de Uso

### Agregar una Nueva Tabla de Contenido
```php
// Migración: 40_01_content_activities
Schema::create('cnt_activities', function (Blueprint $table) {
    $table->id();
    $table->foreignId('created_by')->constrained('sys_users');
    $table->string('title');
    $table->text('description');
    $table->timestamps();
});
```

### Agregar una Nueva Tabla de Relación
```php
// Migración: 30_04_rel_user_activities
Schema::create('rel_user_activities', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('sys_users');
    $table->foreignId('activity_id')->constrained('cnt_activities');
    $table->timestamps();
});
```

## Migración de Datos Existentes

Si necesitas migrar datos de tablas antiguas a las nuevas:

1. Crear migración de datos: `php artisan make:migration migrate_data_to_new_structure`
2. Copiar datos de tablas antiguas a nuevas
3. Verificar integridad de datos
4. Eliminar tablas antiguas

## Notas Importantes

- Todas las tablas tienen `timestamps` (created_at, updated_at)
- Las claves foráneas tienen restricciones de integridad referencial
- Los índices están optimizados para consultas frecuentes
- Las tablas de relaciones tienen restricciones UNIQUE para evitar duplicados

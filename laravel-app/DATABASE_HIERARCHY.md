Buenísimo 🚀
Ya que renombraste las migraciones y tablas con los prefijos `SYS_`, `CFG_`, `PFL_`, `REL_`, aquí te dejo la **versión actualizada del documento**, ajustada a tus nombres.

---

# Sistema de Jerarquía de Base de Datos

Este documento describe el sistema de jerarquía implementado para todas las tablas de la base de datos del sistema ONG.

---

## Principios de la Jerarquía

### Sistema de Prefijos Numéricos

Cada tabla tiene un prefijo numérico que indica su nivel en la jerarquía del sistema:

* **00\_** - Tablas base del sistema (core system tables)
* **10\_** - Tablas de configuración y metadatos (configuration tables)
* **20\_** - Tablas de perfiles y datos extendidos (profile and extended data)
* **30\_** - Tablas de relaciones many-to-many (relationship tables)
* **40\_** - Tablas de contenido principal (main content tables)
* **50\_** - Tablas de contenido secundario (secondary content tables)
* **60\_** - Tablas de logs y auditoría (logging and audit tables)

### Sistema de Prefijos de Categoría

Además del número, cada tabla tiene un prefijo de categoría:

* **sys\_** - Tablas del sistema (system tables)
* **cfg\_** - Tablas de configuración (configuration tables)
* **usr\_ / pfl\_** - Tablas de usuarios y perfiles (user/profile tables)
* **rel\_** - Tablas de relaciones (relationship tables)
* **cnt\_** - Tablas de contenido (content tables)
* **log\_** - Tablas de logs (logging tables)

---

## Estructura de Tablas Implementada

### 00\_ - Tablas Base del Sistema

| Migración                      | Tabla          | Descripción                      | Dependencias |
| ------------------------------ | -------------- | -------------------------------- | ------------ |
| `SYS_01_create_users_table`    | `sys_users`    | Usuarios principales del sistema | Ninguna      |
| `SYS_02_create_sessions_table` | `sys_sessions` | Sesiones de usuario              | `sys_users`  |
| `SYS_03_create_cache_table`    | `sys_cache`    | Cache del sistema                | Ninguna      |
| `SYS_04_create_jobs_table`     | `sys_jobs`     | Cola de trabajos                 | Ninguna      |

---

### 10\_ - Tablas de Configuración

| Migración                         | Tabla             | Descripción          | Dependencias |
| --------------------------------- | ----------------- | -------------------- | ------------ |
| `CFG_01_create_roles_table`       | `cfg_roles`       | Roles del sistema    | Ninguna      |
| `CFG_02_create_permissions_table` | `cfg_permissions` | Permisos del sistema | Ninguna      |

---

### 20\_ - Tablas de Perfiles

| Migración                           | Tabla          | Descripción                     | Dependencias |
| ----------------------------------- | -------------- | ------------------------------- | ------------ |
| `PFL_01_create_user_profiles_table` | `usr_profiles` | Perfiles extendidos de usuarios | `sys_users`  |

---

### 30\_ - Tablas de Relaciones

| Migración                             | Tabla                  | Descripción                | Dependencias                   |
| ------------------------------------- | ---------------------- | -------------------------- | ------------------------------ |
| `REL_01_create_role_user_table`       | `rel_user_roles`       | Relación usuarios-roles    | `sys_users`, `cfg_roles`       |
| `REL_02_create_permission_user_table` | `rel_user_permissions` | Relación usuarios-permisos | `sys_users`, `cfg_permissions` |
| `REL_03_create_permission_role_table` | `rel_role_permissions` | Relación roles-permisos    | `cfg_roles`, `cfg_permissions` |

---

## Orden de Ejecución de Migraciones

1. **Sistema Base (00\_)**

   * `SYS_01_create_users_table`
   * `SYS_02_create_sessions_table`
   * `SYS_03_create_cache_table`
   * `SYS_04_create_jobs_table`

2. **Configuración (10\_)**

   * `CFG_01_create_roles_table`
   * `CFG_02_create_permissions_table`

3. **Perfiles (20\_)**

   * `PFL_01_create_user_profiles_table`

4. **Relaciones (30\_)**

   * `REL_01_create_role_user_table`
   * `REL_02_create_permission_user_table`
   * `REL_03_create_permission_role_table`

---

## Convenciones de Nomenclatura

### Nombres de Tablas

* Formato: `{categoria}_{nombre_descriptivo}`
* Ejemplos:

  * `sys_users` - Usuarios del sistema
  * `cfg_roles` - Roles de configuración
  * `usr_profiles` - Perfiles de usuario
  * `rel_user_roles` - Relación usuarios-roles

### Claves Foráneas

* Formato: `{tabla_referenciada}_id`
* Ejemplos:

  * `user_id` → `sys_users`
  * `role_id` → `cfg_roles`
  * `permission_id` → `cfg_permissions`

---

## Beneficios del Sistema

1. **Claridad** en la estructura.
2. **Orden** en la ejecución de migraciones.
3. **Mantenibilidad** en el crecimiento.
4. **Escalabilidad** asegurada.
5. **Documentación** autoexplicativa.

---
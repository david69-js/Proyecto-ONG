# 🎁 Módulo de Donaciones - Sistema ONG

## 📋 Descripción General

El módulo de donaciones es un sistema completo para gestionar todas las contribuciones recibidas por la ONG, incluyendo donaciones monetarias, materiales, servicios, voluntariado y donaciones mixtas. El sistema está integrado con el sistema de roles y permisos existente.

## ✨ Características Principales

### 🎯 Tipos de Donación
- **Monetaria**: Donaciones en efectivo, transferencias, cheques
- **Materiales**: Bienes físicos, suministros, equipos
- **Servicios**: Consultoría, servicios profesionales, capacitación
- **Voluntariado**: Tiempo y esfuerzo de voluntarios
- **Mixta**: Combinación de tipos anteriores

### 📊 Estados de Donación
- **Pendiente**: Recién recibida, esperando confirmación
- **Confirmada**: Verificada y aprobada por el personal
- **Procesada**: Completamente procesada y registrada
- **Rechazada**: Rechazada por algún motivo específico
- **Cancelada**: Cancelada por el donante o la ONG

### 💳 Métodos de Pago
- Transferencia bancaria
- Efectivo
- Cheque
- En especie
- Otros métodos

### 👥 Tipos de Donantes
- Individual
- Corporativo
- Fundación
- ONG
- Gobierno

## 🚀 Instalación

### Windows
```bash
cd laravel-app
setup-donations.bat
```

### Linux/Mac
```bash
cd laravel-app
chmod +x setup-donations.sh
./setup-donations.sh
```

### Instalación Manual
```bash
# 1. Ejecutar migraciones
php artisan migrate

# 2. Ejecutar seeders
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=DonationSeeder

# 3. Limpiar cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

## 🔐 Permisos del Sistema

### Permisos de Donaciones
- `donations.view` - Ver todas las donaciones
- `donations.view.own` - Ver solo propias donaciones
- `donations.create` - Crear donaciones
- `donations.edit` - Editar donaciones
- `donations.delete` - Eliminar donaciones
- `donations.confirm` - Confirmar donaciones
- `donations.process` - Procesar donaciones
- `donations.reports` - Ver reportes
- `donations.export` - Exportar datos

### Asignación por Rol
- **Super Admin**: Todos los permisos
- **Coordinador de Proyecto**: Gestión completa de donaciones
- **Voluntario/Staff**: Ver donaciones, crear donaciones básicas
- **Donante**: Ver y crear sus propias donaciones
- **Beneficiario**: Sin acceso al módulo de donaciones

## 📁 Estructura de Archivos

```
app/
├── Http/Controllers/
│   └── DonationController.php          # Controlador principal
├── Models/
│   └── Donation.php                    # Modelo de donaciones
├── Policies/
│   └── DonationPolicy.php              # Política de autorización
database/
├── migrations/
│   └── 020_create_donations_table.php # Migración de la tabla
└── seeders/
    └── DonationSeeder.php              # Datos de prueba
resources/views/donations/
├── index.blade.php                     # Lista de donaciones
├── create.blade.php                    # Formulario de creación
├── show.blade.php                      # Detalle de donación
└── reports.blade.php                   # Reportes y estadísticas
```

## 🛠️ Funcionalidades

### 1. Gestión de Donaciones
- **Crear**: Formulario completo con validaciones
- **Ver**: Detalle completo con historial
- **Editar**: Modificar información (solo donaciones pendientes)
- **Eliminar**: Eliminar donaciones pendientes
- **Confirmar**: Cambiar estado a confirmada
- **Procesar**: Cambiar estado a procesada
- **Rechazar**: Rechazar con motivo
- **Cancelar**: Cancelar donación

### 2. Filtros y Búsqueda
- Por estado de donación
- Por tipo de donación
- Por proyecto
- Por tipo de donante
- Por rango de fechas
- Búsqueda por texto (código, donante, descripción)

### 3. Reportes y Estadísticas
- Total de donaciones
- Monto total recaudado
- Donaciones por tipo (gráfico circular)
- Donaciones por estado (gráfico de dona)
- Tendencias mensuales (gráfico de líneas)
- Resumen detallado en tabla

### 4. Exportación de Datos
- Exportar a CSV con filtros aplicados
- Incluye todos los campos relevantes
- Formato compatible con Excel

## 🔗 Rutas Principales

```php
// Gestión básica
GET    /donations              # Lista de donaciones
GET    /donations/create       # Formulario de creación
POST   /donations              # Crear donación
GET    /donations/{id}         # Ver detalle
GET    /donations/{id}/edit    # Formulario de edición
PUT    /donations/{id}         # Actualizar donación
DELETE /donations/{id}         # Eliminar donación

// Acciones específicas
PATCH  /donations/{id}/confirm # Confirmar donación
PATCH  /donations/{id}/process # Procesar donación
PATCH  /donations/{id}/reject  # Rechazar donación
PATCH  /donations/{id}/cancel  # Cancelar donación

// Reportes y exportación
GET    /donations/reports      # Reportes y estadísticas
GET    /donations/export       # Exportar datos
```

## 📊 Campos de la Base de Datos

### Información Básica
- `donation_code` - Código único de donación
- `donation_type` - Tipo de donación
- `amount` - Monto (para donaciones monetarias)
- `currency` - Moneda
- `description` - Descripción de la donación

### Información del Donante
- `donor_name` - Nombre del donante
- `donor_email` - Email del donante
- `donor_phone` - Teléfono del donante
- `donor_address` - Dirección del donante
- `donor_type` - Tipo de donante
- `is_anonymous` - Donación anónima

### Vinculaciones
- `user_id` - Usuario registrado (opcional)
- `project_id` - Proyecto específico (opcional)
- `sponsor_id` - Patrocinador relacionado (opcional)

### Información de Pago
- `payment_method` - Método de pago
- `payment_reference` - Referencia de pago
- `payment_notes` - Notas del pago

### Estado y Seguimiento
- `status` - Estado actual
- `status_notes` - Notas del estado
- `confirmed_at` - Fecha de confirmación
- `processed_at` - Fecha de procesamiento
- `confirmed_by` - Usuario que confirmó
- `processed_by` - Usuario que procesó

### Documentos
- `receipt_path` - Ruta del comprobante
- `tax_receipt_path` - Ruta del recibo fiscal
- `tax_receipt_number` - Número de recibo fiscal

## 🎨 Interfaz de Usuario

### Lista de Donaciones
- Tabla responsive con paginación
- Filtros avanzados en la parte superior
- Acciones rápidas por fila
- Indicadores visuales de estado
- Búsqueda en tiempo real

### Formulario de Creación
- Formulario dividido en secciones lógicas
- Validaciones en tiempo real
- Campos condicionales según el tipo
- Subida de archivos con validación
- Interfaz intuitiva y responsive

### Detalle de Donación
- Vista completa de toda la información
- Panel lateral con acciones disponibles
- Historial de cambios con timeline
- Enlaces a documentos adjuntos
- Modales para acciones específicas

### Reportes
- Dashboard con métricas principales
- Gráficos interactivos con Chart.js
- Filtros por fecha y proyecto
- Tabla de resumen detallado
- Exportación de datos

## 🔧 Configuración Avanzada

### Personalización de Estados
Los estados de donación se pueden personalizar modificando el enum en la migración y actualizando las vistas correspondientes.

### Integración con Proyectos
Las donaciones se pueden vincular a proyectos específicos para un mejor seguimiento del impacto.

### Notificaciones
El sistema está preparado para integrar notificaciones por email cuando cambie el estado de una donación.

### Auditoría
Todas las acciones quedan registradas con el usuario que las realizó y la fecha/hora.

## 🚨 Consideraciones de Seguridad

- Validación de archivos subidos
- Sanitización de datos de entrada
- Control de acceso granular por permisos
- Protección contra ataques CSRF
- Validación de tipos de archivo permitidos

## 📈 Métricas y KPIs

El sistema permite generar métricas importantes para la ONG:
- Total de donaciones recibidas
- Monto total recaudado
- Tasa de conversión (pendientes → confirmadas)
- Tiempo promedio de procesamiento
- Distribución por tipo de donante
- Tendencias temporales

## 🔄 Flujo de Trabajo Típico

1. **Recepción**: Donación creada con estado "Pendiente"
2. **Verificación**: Personal verifica la información
3. **Confirmación**: Donación marcada como "Confirmada"
4. **Procesamiento**: Donación procesada y marcada como "Procesada"
5. **Seguimiento**: Generación de reportes y análisis

## 🆘 Soporte y Mantenimiento

Para reportar problemas o solicitar nuevas funcionalidades, contactar al equipo de desarrollo.

---

**Versión**: 1.0.0  
**Última actualización**: {{ date('Y-m-d') }}  
**Compatibilidad**: Laravel 10+, PHP 8.1+

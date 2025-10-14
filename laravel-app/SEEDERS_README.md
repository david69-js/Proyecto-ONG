# 📊 Seeders de Eventos y Patrocinadores

Este documento explica cómo usar los seeders para poblar la base de datos con datos de prueba para eventos y patrocinadores.

## 🎯 Seeders Disponibles

### 1. **SponsorSeeder**
- **Archivo**: `database/seeders/SponsorSeeder.php`
- **Función**: Crea patrocinadores con datos realistas
- **Datos incluidos**:
  - 8 patrocinadores de diferentes tipos (individual, corporativo, fundación, ONG, gobierno)
  - Información completa de contacto
  - Asociaciones automáticas con proyectos existentes
  - Montos de contribución variados (Q5,000 - Q100,000)

### 2. **EventSeeder**
- **Archivo**: `database/seeders/EventSeeder.php`
- **Función**: Crea eventos de diferentes tipos
- **Datos incluidos**:
  - 8 eventos variados (carrera solidaria, talleres, feria de voluntariado, etc.)
  - Diferentes tipos: fundraising, training, volunteer, awareness, community, other
  - Fechas futuras realistas
  - Información completa de contacto y requisitos

### 3. **EventRegistrationSeeder**
- **Archivo**: `database/seeders/EventRegistrationSeeder.php`
- **Función**: Crea inscripciones de eventos
- **Datos incluidos**:
  - 10 inscripciones de muestra
  - Diferentes estados: confirmed, pending
  - Asociadas a eventos que requieren registro

## 🚀 Cómo Ejecutar los Seeders

### Opción 1: Scripts Automatizados (Recomendado)

#### En Windows:
```bash
# Ejecutar desde la carpeta laravel-app
seed-events-sponsors.bat
```

#### En Linux/Mac:
```bash
# Ejecutar desde la carpeta laravel-app
./seed-events-sponsors.sh
```

### Opción 2: Comandos Individuales

```bash
# Patrocinadores
docker-compose exec app php artisan db:seed --class=SponsorSeeder

# Eventos
docker-compose exec app php artisan db:seed --class=EventSeeder

# Inscripciones de eventos
docker-compose exec app php artisan db:seed --class=EventRegistrationSeeder
```

### Opción 3: Todos los Seeders

```bash
# Ejecutar todos los seeders (incluye usuarios, proyectos, etc.)
docker-compose exec app php artisan db:seed
```

## 📋 Datos Creados

### Patrocinadores (8 registros)
- **Fundación Carlos Slim** - Q50,000 (Fundación)
- **Constructora Nacional S.A.** - Q25,000 (Corporativo)
- **Dr. Ana Patricia López** - Q10,000 (Individual)
- **USAID Guatemala** - Q100,000 (Gobierno)
- **Habitat for Humanity** - Q75,000 (ONG)
- **Voluntarios Sin Fronteras** - Q5,000 (ONG)
- **Cementos Progreso** - Q15,000 (Corporativo)
- **Fundación Tigo** - Q30,000 (Corporativo)

### Eventos (8 registros)
1. **Carrera Solidaria 2024** - Fundraising (Q50)
2. **Taller de Construcción Sostenible** - Training (Gratis)
3. **Feria de Voluntariado** - Volunteer (Gratis)
4. **Campaña de Concientización** - Awareness (Gratis)
5. **Construcción Comunitaria** - Community (Gratis)
6. **Reunión de Evaluación** - Other (Gratis)
7. **Cena de Gala Anual** - Fundraising (Q200)
8. **Taller de Liderazgo** - Training (Q25)

### Inscripciones (Variable)
- Entre 3-8 inscripciones por evento que requiere registro
- Estados: confirmed, pending
- Datos de contacto realistas

## ⚠️ Consideraciones Importantes

1. **Dependencias**: Los seeders requieren que existan:
   - Proyectos (ProjectSeeder)
   - Usuarios (UserSeeder)

2. **Orden de Ejecución**: Los seeders están configurados en el orden correcto en `DatabaseSeeder.php`

3. **Datos Únicos**: Los seeders usan `updateOrCreate()` para evitar duplicados

4. **Relaciones**: Los patrocinadores se asocian automáticamente con proyectos aleatorios

## 🔄 Re-ejecutar Seeders

Si necesitas re-ejecutar los seeders:

```bash
# Limpiar y recrear la base de datos
docker-compose exec app php artisan migrate:fresh --seed

# O solo ejecutar seeders específicos
docker-compose exec app php artisan db:seed --class=SponsorSeeder
```

## 📊 Verificar Datos

Puedes verificar que los datos se crearon correctamente visitando:
- **Patrocinadores**: `/sponsors`
- **Eventos**: `/events`
- **Dashboard**: `/dashboard` (estadísticas)

## 🛠️ Personalizar Datos

Para modificar los datos de los seeders, edita los archivos correspondientes en `database/seeders/` y vuelve a ejecutar los comandos.
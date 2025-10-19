# 🎨 Clases CSS Personalizadas para Botones

Este archivo contiene clases CSS personalizadas para controlar el tamaño de fuente y apariencia de los botones en el sistema.

## 📁 Archivo CSS
- **Ubicación**: `public/assets/css/button-custom.css`
- **Incluido en**: `layouts/tabler.blade.php`

## 🎯 Clases Principales

### 1. **Botones con Texto Pequeño**
```html
<!-- Texto más pequeño (14px) -->
<button class="btn btn-primary btn-text-sm">Botón Pequeño</button>

<!-- Con botón grande -->
<button class="btn btn-primary btn-lg btn-text-sm">Botón Grande con Texto Pequeño</button>

<!-- Con botón pequeño -->
<button class="btn btn-primary btn-sm btn-text-sm">Botón Pequeño con Texto Pequeño</button>
```

### 2. **Botones Extra Pequeños**
```html
<!-- Texto extra pequeño (12px) -->
<button class="btn btn-primary btn-text-xs">Botón Extra Pequeño</button>
```

### 3. **Botones Compactos**
```html
<!-- Texto compacto con mejor espaciado -->
<button class="btn btn-primary btn-compact">Botón Compacto</button>
```

### 4. **Botones Solo con Iconos**
```html
<!-- Solo icono, sin texto -->
<button class="btn btn-primary btn-icon-only">
    <i class="fas fa-edit"></i>
</button>

<!-- Solo icono pequeño -->
<button class="btn btn-primary btn-sm btn-icon-only">
    <i class="fas fa-edit"></i>
</button>
```

### 5. **Botones con Icono y Texto**
```html
<!-- Icono y texto con espaciado automático -->
<button class="btn btn-primary btn-icon-text">
    <i class="fas fa-save"></i>
    Guardar
</button>
```

## 🔧 Clases de Utilidad

### **Tamaños de Fuente**
```html
<span class="text-tiny">Texto muy pequeño (10px)</span>
<span class="text-extra-small">Texto extra pequeño (12px)</span>
<span class="text-small">Texto pequeño (14px)</span>
<span class="text-normal">Texto normal (16px)</span>
<span class="text-large">Texto grande (18px)</span>
```

### **Padding Personalizado**
```html
<button class="btn btn-primary p-sm">Padding pequeño</button>
<button class="btn btn-primary p-md">Padding mediano</button>
<button class="btn btn-primary p-lg">Padding grande</button>
```

## 🎨 Clases Específicas

### **Botones de Acción**
```html
<button class="btn btn-warning btn-action">Editar</button>
<button class="btn btn-danger btn-action btn-sm">Eliminar</button>
```

### **Botones de Navegación**
```html
<a href="#" class="btn btn-secondary btn-nav">Volver</a>
```

### **Botones de Formulario**
```html
<button type="submit" class="btn btn-success btn-form">Enviar Formulario</button>
```

## 📱 Responsive

Todas las clases se adaptan automáticamente a pantallas móviles:
- **Desktop**: Tamaños normales
- **Tablet/Mobile**: Tamaños reducidos automáticamente

## 🌙 Modo Oscuro

Las clases incluyen soporte para modo oscuro con opacidad ajustada.

## 💡 Ejemplos de Uso

### **En Vistas de Detalles**
```html
<div class="card-actions">
    <a href="{{ route('items.edit', $item) }}" class="btn btn-warning btn-text-sm">
        <i class="fas fa-edit me-1"></i>
        Editar
    </a>
    <a href="{{ route('items.index') }}" class="btn btn-secondary btn-text-sm">
        <i class="fas fa-arrow-left me-1"></i>
        Volver
    </a>
</div>
```

### **En Tablas**
```html
<div class="btn-group">
    <button class="btn btn-outline-info btn-sm btn-icon-only" title="Ver">
        <i class="fas fa-eye"></i>
    </button>
    <button class="btn btn-outline-warning btn-sm btn-icon-only" title="Editar">
        <i class="fas fa-edit"></i>
    </button>
    <button class="btn btn-outline-danger btn-sm btn-icon-only" title="Eliminar">
        <i class="fas fa-trash"></i>
    </button>
</div>
```

### **En Formularios**
```html
<div class="d-flex gap-2">
    <button type="submit" class="btn btn-success btn-compact">
        <i class="fas fa-save me-1"></i>
        Guardar
    </button>
    <a href="{{ route('items.index') }}" class="btn btn-secondary btn-compact">
        <i class="fas fa-times me-1"></i>
        Cancelar
    </a>
</div>
```

## 🔄 Aplicar a Vistas Existentes

Para aplicar estas clases a las vistas existentes, simplemente agrega la clase deseada:

```html
<!-- ANTES -->
<button class="btn btn-primary btn-lg">Botón Grande</button>

<!-- DESPUÉS -->
<button class="btn btn-primary btn-lg btn-text-sm">Botón Grande con Texto Pequeño</button>
```

## 📝 Notas

- Las clases son **aditivas**, puedes combinar múltiples clases
- **Responsive**: Se adaptan automáticamente a diferentes pantallas
- **Consistentes**: Mantienen la apariencia de Tabler
- **Flexibles**: Puedes ajustar fácilmente los tamaños modificando el CSS

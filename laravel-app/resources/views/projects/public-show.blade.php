<x-head>
  <title>{{ $project->nombre }} - Proyecto | Habitat Guatemala</title>
  <meta name="description" content="{{ Str::limit($project->descripcion ?? 'Conoce más sobre este proyecto de Habitat Guatemala', 160) }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <style>
    /* Estilos específicos para la página de proyecto */
    .project-page {
      background-color: var(--background-color);
    }
    
    .project-quick-info .info-item {
      background: rgba(255,255,255,0.1);
      padding: 0.5rem 1rem;
      border-radius: 25px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.2);
    }
    
    .project-quick-info .info-item i {
      color: rgba(255,255,255,0.8);
    }
    
    .text-white-75 {
      color: rgba(255,255,255,0.75) !important;
    }
    
    .service-details .detail-item {
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid #eee;
    }
    
    .service-details .detail-item:last-child {
      border-bottom: none;
      margin-bottom: 0;
    }
    
    .service-details .detail-item h5 {
      color: var(--heading-color);
      font-size: 1.1rem;
      margin-bottom: 0.5rem;
    }
    
    .service-details .detail-item p {
      color: var(--default-color);
      margin-bottom: 0;
    }
    
    .cta-buttons .btn {
      margin-bottom: 0.5rem;
    }
    
    @media (max-width: 768px) {
      .cta-buttons .btn {
        display: block;
        width: 100%;
        margin-bottom: 1rem;
      }
      
           .cta-buttons .btn:last-child {
             margin-bottom: 0;
           }
         }
         
         /* Estilos para controles del carousel más oscuros */
         .carousel-control-prev-icon,
         .carousel-control-next-icon {
           background-color: #000 !important;
           border: 2px solid #fff !important;
           border-radius: 50% !important;
           padding: 20px !important;
           width: 50px !important;
           height: 50px !important;
           opacity: 0.9 !important;
         }
         
         .carousel-control-prev-icon:hover,
         .carousel-control-next-icon:hover {
           background-color: #333 !important;
           opacity: 1 !important;
         }
         
         .carousel-control-prev,
         .carousel-control-next {
           background: linear-gradient(90deg, rgba(0,0,0,0.7), transparent) !important;
           width: 80px !important;
           opacity: 1 !important;
         }
         
         .carousel-control-prev {
           background: linear-gradient(90deg, rgba(0,0,0,0.7), transparent) !important;
         }
         
         .carousel-control-next {
           background: linear-gradient(270deg, rgba(0,0,0,0.7), transparent) !important;
         }
         
         /* Estilos para el filtro de fases */
         .phase-filter {
           background: rgba(255,255,255,0.05);
           border-radius: 15px;
           padding: 1rem;
           backdrop-filter: blur(10px);
           border: 1px solid rgba(255,255,255,0.1);
         }
         
         .phase-filter-btn {
           transition: all 0.3s ease;
           border-radius: 25px !important;
           font-weight: 500;
         }
         
         .phase-filter-btn:hover {
           transform: translateY(-2px);
           box-shadow: 0 4px 8px rgba(0,0,0,0.2);
         }
         
         .phase-filter-btn.active {
           background: var(--accent-color) !important;
           border-color: var(--accent-color) !important;
           color: white !important;
         }
         
         /* Indicadores cíclicos del carousel */
         .carousel-indicators-custom {
           position: relative;
           z-index: 10;
         }
         
         .carousel-indicator-dot {
           width: 12px;
           height: 12px;
           border-radius: 50%;
           background: rgba(255, 255, 255, 0.5);
           border: 2px solid rgba(255, 255, 255, 0.8);
           cursor: pointer;
           transition: all 0.3s ease;
         }
         
         .carousel-indicator-dot.active {
           background: var(--accent-color);
           border-color: var(--accent-color);
           transform: scale(1.2);
         }
         
         .carousel-indicator-dot:hover {
           background: rgba(255, 255, 255, 0.8);
           transform: scale(1.1);
         }
       </style>
</x-head>

<body class="project-page d-flex flex-column min-vh-100">
<x-header />

<main class="main flex-grow-1">
  <!-- Hero Section del Proyecto -->
  <section id="project-hero" class="hero section" style="background: linear-gradient(135deg, var(--accent-color) 0%, color-mix(in srgb, var(--accent-color), transparent 20%) 100%); padding: 200px 0 100px;">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <div class="hero-content text-white" data-aos="fade-right" data-aos-delay="200">
            <!-- Badge de estado -->
            <span class="subtitle d-inline-block mb-3 px-3 py-1 rounded-pill" 
                  style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
              <i class="bi bi-building me-2"></i>
              @php
                $statusTranslations = [
                  'planning' => 'Planificación',
                  'en progreso' => 'En Progreso',
                  'completado' => 'Completado',
                  'pausado' => 'Pausado',
                  'cancelado' => 'Cancelado'
                ];
                $statusText = $statusTranslations[$project->estado] ?? 'Activo';
              @endphp
              {{ $statusText }}
            </span>

            <!-- Título principal -->
            <h1 class="text-white mb-3">{{ $project->nombre }}</h1>
            
            <!-- Descripción -->
            <p class="text-white mb-4">{{ $project->descripcion ?? 'Proyecto organizado por Habitat Guatemala' }}</p>

            <!-- Información rápida -->
            <div class="project-quick-info d-flex flex-wrap gap-4 mb-4">
              @if($project->ubicacion)
                <div class="info-item d-flex align-items-center">
                  <i class="bi bi-geo-alt me-2"></i>
                  <span>{{ $project->ubicacion }}</span>
                </div>
              @endif
              @if($project->duracion_meses)
                <div class="info-item d-flex align-items-center">
                  <i class="bi bi-calendar-check me-2"></i>
                  <span>{{ $project->duracion_meses }} meses</span>
                </div>
              @endif
              @if($project->presupuesto_total)
                <div class="info-item d-flex align-items-center">
                  <i class="bi bi-currency-dollar me-2"></i>
                  <span>Q{{ number_format($project->presupuesto_total, 2) }}</span>
                </div>
              @endif
              @if($project->viviendas)
                <div class="info-item d-flex align-items-center">
                  <i class="bi bi-house me-2"></i>
                  <span>{{ $project->viviendas }} viviendas</span>
                </div>
              @endif
              @if($project->porcentaje)
                <div class="info-item d-flex align-items-center">
                  <i class="bi bi-graph-up me-2"></i>
                  <span>{{ $project->porcentaje }}% completado</span>
                </div>
              @endif
            </div>
          </div>
    </div>

        <div class="col-lg-4" data-aos="fade-left" data-aos-delay="300">
          <div class="project-visual text-center">
            <!-- Imagen del proyecto si existe -->
            @if($project->imagen)
              <div class="project-image mb-4">
                <img src="{{ asset('storage/' . $project->imagen) }}" alt="{{ $project->nombre }}" class="img-fluid rounded shadow" style="max-height: 300px; object-fit: cover;">
              </div>
            @else
              <!-- Icono por defecto si no hay imagen -->
              <div class="project-icon-wrapper mb-4">
                <i class="bi bi-building" style="font-size: 4rem; color: rgba(255,255,255,0.3);"></i>
              </div>
            @endif
            
            @if($project->categoria)
              <div class="project-category-badge">
                <span class="badge bg-white text-dark px-3 py-2 rounded-pill">
                  {{ ucfirst($project->categoria) }}
                </span>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Línea divisoria -->
  <div class="container">
    <hr class="my-5" style="border-color: var(--accent-color); opacity: 0.3;">
  </div>

  <!-- Detalles del Proyecto -->
  <section id="project-details" class="section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <!-- Título de sección -->
      <div class="section-title">
        <h2>Detalles del Proyecto</h2>
        <p>Información completa sobre este proyecto organizado por Habitat Guatemala</p>
      </div>

      <!-- Imagen del proyecto si existe -->
      @if($project->imagen)
        <div class="row mb-4">
          <div class="col-12" data-aos="fade-up" data-aos-delay="100">
            <div class="project-main-image text-center">
              <img src="{{ asset('storage/' . $project->imagen) }}" alt="{{ $project->nombre }}" class="img-fluid rounded shadow" style="max-height: 400px; object-fit: cover;">
            </div>
          </div>
        </div>
      @endif

      <!-- Carrusel de imágenes de fases -->
    @if($project->phaseImages->count() > 0)
        <div class="row mb-4">
          <div class="col-12" data-aos="fade-up" data-aos-delay="200">
            <h4 class="text-center mb-3">Fases del Proyecto</h4>
            
            <!-- Filtro de fases -->
            <div class="phase-filter mb-4">
              <div class="d-flex flex-wrap gap-2 justify-content-center">
                <button class="btn btn-outline-primary btn-sm phase-filter-btn active" data-phase="all">
                  <i class="bi bi-grid me-1"></i>Todas las Fases
                </button>
                @php
                  $availablePhases = $project->phaseImages->pluck('fase')->unique();
                  $phaseOrder = ['diagnostico', 'formulacion', 'financiacion', 'ejecucion', 'evaluacion', 'cierre'];
                  $phaseNames = [
                    'diagnostico' => 'Diagnóstico',
                    'formulacion' => 'Formulación', 
                    'financiacion' => 'Financiación',
                    'ejecucion' => 'Ejecución',
                    'evaluacion' => 'Evaluación',
                    'cierre' => 'Cierre'
                  ];
                @endphp
                @foreach($phaseOrder as $phase)
                  @if($availablePhases->contains($phase))
                    <button class="btn btn-outline-secondary btn-sm phase-filter-btn" data-phase="{{ $phase }}">
                      <i class="bi bi-circle-fill me-1"></i>{{ $phaseNames[$phase] }}
                    </button>
                  @endif
                @endforeach
              </div>
            </div>
            
            <div id="carouselProject{{ $project->id }}" class="carousel slide shadow" data-bs-ride="false" data-bs-interval="false">
        <div class="carousel-inner rounded">
          @foreach($project->phaseImages as $index => $image)
                  <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-phase="{{ $image->fase }}">
              <img src="{{ asset('storage/' . $image->image_path) }}"
                   class="d-block w-100"
                   alt="{{ $image->description ?? $project->nombre }}"
                   style="object-fit: cover; height: 400px;">
              <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded px-3 py-1">
                <small class="text-white">
                        Fase: {{ $phaseNames[$image->fase] ?? ucfirst($image->fase) }}
                  @if($image->description)
                    — {{ $image->description }}
                  @endif
                </small>
              </div>
            </div>
          @endforeach
        </div>

        @if($project->phaseImages->count() > 1)
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselProject{{ $project->id }}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselProject{{ $project->id }}" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
                
                <!-- Indicadores cíclicos -->
                <div class="carousel-indicators-custom">
                  <div id="carouselIndicators{{ $project->id }}" class="d-flex justify-content-center gap-2 mt-3">
                    <!-- Los indicadores se generarán dinámicamente con JavaScript -->
                  </div>
                </div>
        @endif
            </div>
          </div>
      </div>
    @endif

    <div class="row gy-4">
        <!-- Información principal -->
        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
          <div class="service-card h-100">
            <div class="service-icon">
              
            </div>
            <h3>Información General</h3>
            <div class="service-features">
              @if($project->ubicacion)
                <div class="feature-item mb-2">
                  <i class="bi bi-geo-alt"></i> <strong>Ubicación:</strong><br>
                  <span class="ms-3">{{ $project->ubicacion }}</span>
                </div>
              @endif
              @if($project->responsable)
                <div class="feature-item mb-2">
                  <i class="bi bi-person-badge"></i> <strong>Responsable:</strong><br>
                  <span class="ms-3">{{ $project->responsable->first_name }} {{ $project->responsable->last_name }}</span>
                </div>
              @endif
              @if($project->presupuesto_total)
                <div class="feature-item mb-2">
                  <i class="bi bi-currency-dollar"></i> <strong>Presupuesto:</strong><br>
                  <span class="ms-3">Q{{ number_format($project->presupuesto_total, 2) }}</span>
                </div>
              @endif
              @if($project->duracion_meses)
                <div class="feature-item mb-2">
                  <i class="bi bi-calendar-check"></i> <strong>Duración:</strong><br>
                  <span class="ms-3">{{ $project->duracion_meses }} meses</span>
                </div>
              @endif
              @if($project->fecha_inicio)
                <div class="feature-item mb-2">
                  <i class="bi bi-calendar-event"></i> <strong>Fecha Inicio:</strong><br>
                  <span class="ms-3">{{ \Carbon\Carbon::parse($project->fecha_inicio)->format('d/m/Y') }}</span>
                </div>
              @endif
              @if($project->fecha_fin)
                <div class="feature-item mb-2">
                  <i class="bi bi-calendar-x"></i> <strong>Fecha Fin:</strong><br>
                  <span class="ms-3">{{ \Carbon\Carbon::parse($project->fecha_fin)->format('d/m/Y') }}</span>
                </div>
              @endif
              @if($project->viviendas)
                <div class="feature-item mb-2">
                  <i class="bi bi-house"></i> <strong>Viviendas:</strong><br>
                  <span class="ms-3">{{ $project->viviendas }}</span>
                </div>
              @endif
              @if($project->beneficiarios)
                <div class="feature-item mb-2">
                  <i class="bi bi-people"></i> <strong>Beneficiarios:</strong><br>
                  <span class="ms-3">{{ $project->beneficiarios }}</span>
                </div>
              @endif
            </div>
          </div>
      </div>

        <!-- Información adicional -->
        <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
          <div class="service-card h-100">
            <div class="service-icon">
              
            </div>
            <h3>Progreso y Fases</h3>
            <div class="service-details">
              @if($project->porcentaje)
                <div class="detail-item">
                  <h5><i class="bi bi-graph-up me-2"></i><strong>Progreso del Proyecto:</strong></h5>
                  <div class="ms-4">
                    <div class="progress mb-2" style="height: 25px;">
                      <div class="progress-bar bg-success" role="progressbar" 
                           style="width: {{ $project->porcentaje }}%"
                           aria-valuenow="{{ $project->porcentaje }}" 
                           aria-valuemin="0" aria-valuemax="100">
                        {{ $project->porcentaje }}%
                      </div>
                    </div>
                    <small class="text-muted">Proyecto completado al {{ $project->porcentaje }}%</small>
                  </div>
                </div>
              @endif
              @if($project->fase)
                <div class="detail-item">
                  <h5><i class="bi bi-list-check me-2"></i><strong>Fase Actual:</strong></h5>
                  <p class="ms-4">
                    <span class="badge bg-success">
                      {{ \App\Models\Project::PHASES[$project->fase]['name'] ?? ucfirst($project->fase) }}
                    </span>
                  </p>
                </div>
              @endif
              @if($project->resultados_esperados)
                <div class="detail-item">
                  <h5><i class="bi bi-bullseye me-2"></i><strong>Resultados Esperados:</strong></h5>
                  <p class="ms-4">{{ $project->resultados_esperados }}</p>
                </div>
              @endif
              @if($project->resultados_obtenidos)
                <div class="detail-item">
                  <h5><i class="bi bi-trophy me-2"></i><strong>Resultados Obtenidos:</strong></h5>
                  <p class="ms-4">{{ $project->resultados_obtenidos }}</p>
                </div>
              @endif
              @if($project->categoria)
                <div class="detail-item">
                  <h5><i class="bi bi-tag me-2"></i><strong>Categoría:</strong></h5>
                  <p class="ms-4">{{ ucfirst($project->categoria) }}</p>
                </div>
              @endif
              @if($project->area_km)
                <div class="detail-item">
                  <h5><i class="bi bi-rulers me-2"></i><strong>Área:</strong></h5>
                  <p class="ms-4">{{ $project->area_km }} km²</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Línea divisoria -->
  <div class="container">
    <hr class="my-5" style="border-color: var(--accent-color); opacity: 0.3;">
    </div>

  <!-- Call to Action -->
  <section id="project-cta" class="call-to-action section light-background">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <div class="cta-content">
            <h3>¿Te interesa apoyar este proyecto?</h3>
            <p>Únete a nosotros y forma parte de la transformación de comunidades en Guatemala. Cada proyecto es una oportunidad para hacer la diferencia.</p>
          </div>
        </div>
        <div class="col-lg-4 text-center text-lg-end">
          
        </div>
      </div>
    </div>
  </section>

  </main>

<x-footer />

  <script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtro de fases del carousel
    const filterButtons = document.querySelectorAll('.phase-filter-btn');
    const carouselItems = document.querySelectorAll('.carousel-item');
    const carousel = document.querySelector('#carouselProject{{ $project->id }}');
    let currentFilter = 'all';
    let visibleItems = [];
    
    // Función para actualizar elementos visibles
    function updateVisibleItems() {
        visibleItems = Array.from(carouselItems).filter(item => {
            const itemPhase = item.getAttribute('data-phase');
            const shouldShow = currentFilter === 'all' || itemPhase === currentFilter;
            return shouldShow;
        });
    }
    
    // Función para ir al siguiente elemento visible (cíclico)
    function goToNextVisible() {
        updateVisibleItems();
        if (visibleItems.length === 0) return;
        
        const currentActive = document.querySelector('.carousel-item.active');
        const currentIndex = visibleItems.indexOf(currentActive);
        
        // Navegación cíclica: si está en la última, va a la primera
        let nextIndex = (currentIndex + 1) % visibleItems.length;
        
        // Remover active de todos
        carouselItems.forEach(item => {
            item.classList.remove('active');
            item.style.display = 'none';
        });
        
        // Activar el siguiente (cíclico)
        if (visibleItems[nextIndex]) {
            visibleItems[nextIndex].classList.add('active');
            visibleItems[nextIndex].style.display = 'block';
        }
        
        // Actualizar indicadores
        updateActiveIndicator();
    }
    
    // Función para ir al elemento visible anterior (cíclico)
    function goToPrevVisible() {
        updateVisibleItems();
        if (visibleItems.length === 0) return;
        
        const currentActive = document.querySelector('.carousel-item.active');
        const currentIndex = visibleItems.indexOf(currentActive);
        
        // Navegación cíclica: si está en la primera, va a la última
        let prevIndex = currentIndex - 1;
        if (prevIndex < 0) prevIndex = visibleItems.length - 1;
        
        // Remover active de todos
        carouselItems.forEach(item => {
            item.classList.remove('active');
            item.style.display = 'none';
        });
        
        // Activar el anterior (cíclico)
        if (visibleItems[prevIndex]) {
            visibleItems[prevIndex].classList.add('active');
            visibleItems[prevIndex].style.display = 'block';
        }
        
        // Actualizar indicadores
        updateActiveIndicator();
    }
    
    // Event listeners para filtros
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentFilter = this.getAttribute('data-phase');
            
            // Actualizar botones activos
            filterButtons.forEach(btn => {
                btn.classList.remove('active', 'btn-primary');
                btn.classList.add('btn-outline-secondary');
            });
            this.classList.add('active', 'btn-primary');
            this.classList.remove('btn-outline-secondary');
            
            // Filtrar elementos del carousel
            carouselItems.forEach((item, index) => {
                const itemPhase = item.getAttribute('data-phase');
                const shouldShow = currentFilter === 'all' || itemPhase === currentFilter;
                
                if (shouldShow) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                    item.classList.remove('active');
                }
            });
            
            // Activar el primer elemento visible
            updateVisibleItems();
            if (visibleItems.length > 0) {
                // Remover active de todos primero
                carouselItems.forEach(item => item.classList.remove('active'));
                // Activar el primero
                visibleItems[0].classList.add('active');
            }
            
            // Actualizar indicadores cíclicos
            updateIndicators();
        });
    });
    
    // Interceptar clicks en controles del carousel
    const prevButton = carousel?.querySelector('.carousel-control-prev');
    const nextButton = carousel?.querySelector('.carousel-control-next');
    
    if (prevButton) {
        prevButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            goToPrevVisible();
            return false;
        });
    }
    
    if (nextButton) {
        nextButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            goToNextVisible();
            return false;
        });
    }
    
    // Deshabilitar completamente el carousel de Bootstrap
    if (carousel) {
        carousel.setAttribute('data-bs-ride', 'false');
        carousel.setAttribute('data-bs-interval', 'false');
        carousel.setAttribute('data-bs-pause', 'true');
    }
    
    // Función para actualizar indicadores cíclicos
    function updateIndicators() {
        const indicatorsContainer = document.getElementById('carouselIndicators{{ $project->id }}');
        if (!indicatorsContainer) return;
        
        updateVisibleItems();
        
        // Limpiar indicadores existentes
        indicatorsContainer.innerHTML = '';
        
        // Crear indicadores para elementos visibles
        visibleItems.forEach((item, index) => {
            const dot = document.createElement('div');
            dot.className = 'carousel-indicator-dot';
            dot.setAttribute('data-index', index);
            
            // Click en indicador
            dot.addEventListener('click', function() {
                goToSlide(index);
            });
            
            indicatorsContainer.appendChild(dot);
        });
        
        // Activar el indicador correspondiente
        updateActiveIndicator();
    }
    
    // Función para ir a una slide específica
    function goToSlide(index) {
        updateVisibleItems();
        if (visibleItems.length === 0) return;
        
        // Remover active de todos
        carouselItems.forEach(item => {
            item.classList.remove('active');
            item.style.display = 'none';
        });
        
        // Activar la slide seleccionada
        if (visibleItems[index]) {
            visibleItems[index].classList.add('active');
            visibleItems[index].style.display = 'block';
        }
        
        updateActiveIndicator();
    }
    
    // Función para actualizar indicador activo
    function updateActiveIndicator() {
        const indicators = document.querySelectorAll('.carousel-indicator-dot');
        const currentActive = document.querySelector('.carousel-item.active');
        const currentIndex = visibleItems.indexOf(currentActive);
        
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentIndex);
        });
    }
    
    // Interceptar eventos de teclado
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            goToPrevVisible();
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            goToNextVisible();
        }
    });
    
    // Inicializar indicadores al cargar la página
    updateIndicators();
});
  </script>

<x-head>
  <title>{{ $event->title }} - Evento | Habitat Guatemala</title>
  <meta name="description" content="{{ Str::limit($event->description ?? 'Conoce más sobre este evento de Habitat Guatemala', 160) }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  
  <style>
    /* Estilos específicos para la página de evento */
    .event-page {
      background-color: var(--background-color);
    }
    
    .event-quick-info .info-item {
      background: rgba(255,255,255,0.1);
      padding: 0.5rem 1rem;
      border-radius: 25px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.2);
    }
    
    .event-quick-info .info-item i {
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
  </style>
</x-head>

<body class="event-page d-flex flex-column min-vh-100">
<x-header />


<main class="main flex-grow-1">
  <!-- Hero Section del Evento -->
  <section id="event-hero" class="hero section" style="background: linear-gradient(135deg, var(--accent-color) 0%, color-mix(in srgb, var(--accent-color), transparent 20%) 100%); padding: 200px 0 100px;">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <div class="hero-content text-white" data-aos="fade-right" data-aos-delay="200">
            <!-- Badge de estado -->
            <span class="subtitle d-inline-block mb-3 px-3 py-1 rounded-pill" 
                  style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
              <i class="bi bi-calendar-event me-2"></i>
              @php
                $statusTranslations = [
                  'draft' => 'Borrador',
                  'published' => 'Publicado',
                  'cancelled' => 'Cancelado',
                  'completed' => 'Completado'
                ];
                $statusText = $statusTranslations[$event->status] ?? 'Activo';
              @endphp
              {{ $statusText }}
            </span>

            <!-- Título principal -->
            <h1 class="text-white mb-3">{{ $event->title }}</h1>
            
            <!-- Subtítulo -->
            @if($event->subtitle)
              <p class="lead text-white-50 mb-4">{{ $event->subtitle }}</p>
            @endif

            <!-- Descripción -->
            <p class="text-white mb-4">{{ $event->description ?? 'Evento organizado por Habitat Guatemala' }}</p>

            <!-- Información rápida -->
            <div class="event-quick-info d-flex flex-wrap gap-4 mb-4">
              @if($event->start_date)
                <div class="info-item d-flex align-items-center">
                  <i class="bi bi-calendar-check me-2"></i>
                  <span>{{ $event->start_date->format('d/m/Y') }}</span>
                </div>
              @endif
              @if($event->location)
                <div class="info-item d-flex align-items-center">
                  <i class="bi bi-geo-alt me-2"></i>
                  <span>{{ $event->location }}</span>
                </div>
              @endif
              @if($event->start_time)
                <div class="info-item d-flex align-items-center">
                  <i class="bi bi-clock me-2"></i>
                  <span>{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span>
                </div>
              @endif
              @if($event->cost > 0)
                <div class="info-item d-flex align-items-center">
                  <i class="bi bi-currency-dollar me-2"></i>
                  <span>Q{{ number_format($event->cost, 2) }}</span>
                </div>
              @endif
              @if($event->max_participants)
                <div class="info-item d-flex align-items-center">
                  <i class="bi bi-people me-2"></i>
                  <span>{{ $event->current_participants }}/{{ $event->max_participants }} participantes</span>
                </div>
              @endif
            </div>
          </div>
        </div>
        
        <div class="col-lg-4" data-aos="fade-left" data-aos-delay="300">
          <div class="event-visual text-center">
            <!-- Imagen del evento si existe -->
            @if($event->image_url)
              <div class="event-image mb-4">
                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="img-fluid rounded shadow" style="max-height: 300px; object-fit: cover;">
              </div>
            @else
              <!-- Icono por defecto si no hay imagen -->
              <div class="event-icon-wrapper mb-4">
                <i class="bi bi-calendar-event" style="font-size: 4rem; color: rgba(255,255,255,0.3);"></i>
              </div>
            @endif
            
            @if($event->event_type)
              <div class="event-type-badge">
                <span class="badge bg-white text-dark px-3 py-2 rounded-pill">
                  @php
                    $eventTypeTranslations = [
                      'fundraising' => 'Recaudación de Fondos',
                      'volunteer' => 'Voluntariado',
                      'awareness' => 'Concientización',
                      'community' => 'Comunitario',
                      'training' => 'Capacitación',
                      'other' => 'Otro'
                    ];
                    $eventTypeText = $eventTypeTranslations[$event->event_type] ?? ucfirst($event->event_type);
                  @endphp
                  {{ $eventTypeText }}
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

  <!-- Detalles del Evento -->
  <section id="event-details" class="section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <!-- Título de sección -->
      <div class="section-title">
        <h2>Detalles del Evento</h2>
        <p>Información completa sobre este evento organizado por Habitat Guatemala</p>
      </div>

      <!-- Imagen del evento si existe -->
      @if($event->image_url)
        <div class="row mb-4">
          <div class="col-12" data-aos="fade-up" data-aos-delay="100">
            <div class="event-main-image text-center">
              <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="img-fluid rounded shadow" style="max-height: 400px; object-fit: cover;">
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
              @if($event->location)
                <div class="feature-item mb-2">
                  <i class="bi bi-geo-alt"></i> <strong>Ubicación:</strong><br>
                  <span class="ms-3">{{ $event->location }}</span>
                </div>
              @endif
              @if($event->start_date)
                <div class="feature-item mb-2">
                  <i class="bi bi-calendar-check"></i> <strong>Inicio:</strong><br>
                  <span class="ms-3">{{ $event->start_date->format('d/m/Y') }}</span>
                </div>
              @endif
              @if($event->end_date)
                <div class="feature-item mb-2">
                  <i class="bi bi-calendar-x"></i> <strong>Fin:</strong><br>
                  <span class="ms-3">{{ $event->end_date->format('d/m/Y') }}</span>
                </div>
              @endif
              @if($event->start_time)
                <div class="feature-item mb-2">
                  <i class="bi bi-clock"></i> <strong>Hora:</strong><br>
                  <span class="ms-3">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span>
                </div>
              @endif
              @if($event->event_type)
                <div class="feature-item mb-2">
                  <i class="bi bi-tag"></i> <strong>Tipo:</strong><br>
                  <span class="ms-3">
                    @php
                      $eventTypeTranslations = [
                        'fundraising' => 'Recaudación de Fondos',
                        'volunteer' => 'Voluntariado',
                        'awareness' => 'Concientización',
                        'community' => 'Comunitario',
                        'training' => 'Capacitación',
                        'other' => 'Otro'
                      ];
                      $eventTypeText = $eventTypeTranslations[$event->event_type] ?? ucfirst($event->event_type);
                    @endphp
                    {{ $eventTypeText }}
                  </span>
                </div>
              @endif
              @if($event->cost > 0)
                <div class="feature-item mb-2">
                  <i class="bi bi-currency-dollar"></i> <strong>Costo:</strong><br>
                  <span class="ms-3">Q{{ number_format($event->cost, 2) }}</span>
                </div>
              @endif
              @if($event->max_participants)
                <div class="feature-item mb-2">
                  <i class="bi bi-people"></i> <strong>Cupos:</strong><br>
                  <span class="ms-3">{{ $event->current_participants }}/{{ $event->max_participants }}</span>
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
            <h3>Detalles Adicionales</h3>
            <div class="service-details">
              @if($event->requirements)
                <div class="detail-item">
                  <h5><i class="bi bi-list-check me-2"></i><strong>Requisitos:</strong></h5>
                  <p class="ms-4">{{ $event->requirements }}</p>
                </div>
              @endif
              @if($event->address)
                <div class="detail-item">
                  <h5><i class="bi bi-geo-alt-fill me-2"></i><strong>Dirección:</strong></h5>
                  <p class="ms-4">{{ $event->address }}</p>
                </div>
              @endif
              @if($event->contact_email)
                <div class="detail-item">
                  <h5><i class="bi bi-envelope me-2"></i><strong>Contacto:</strong></h5>
                  <p class="ms-4">
                    <a href="mailto:{{ $event->contact_email }}">{{ $event->contact_email }}</a>
                    @if($event->contact_phone)
                      <br><a href="tel:{{ $event->contact_phone }}">{{ $event->contact_phone }}</a>
                    @endif
                  </p>
                </div>
        @endif
              @if($event->registration_required)
                <div class="detail-item">
                  <h5><i class="bi bi-person-plus me-2"></i><strong>Registro:</strong></h5>
                  <p class="ms-4">Registro requerido</p>
                  @if($event->registration_deadline)
                    <small class="text-muted ms-4">Fecha límite: {{ $event->registration_deadline->format('d/m/Y H:i') }}</small>
        @endif
                </div>
        @endif
            </div>
          </div>
        </div>
      </div>

      <!-- Línea divisoria -->
      @if($event->project)
        <div class="row mt-5">
          <div class="col-12">
            <hr class="my-4" style="border-color: var(--accent-color); opacity: 0.2;">
          </div>
        </div>
      @endif

      <!-- Información del Proyecto Asociado -->
      @if($event->project)
        <div class="row mt-4">
          <div class="col-12" data-aos="fade-up" data-aos-delay="400">
            <div class="service-card">
              <div class="service-icon">
                <i class="bi bi-building"></i>
              </div>
              <h3>Proyecto Asociado</h3>
              <div class="service-features">
                <div class="feature-item mb-2">
                  <i class="bi bi-tag"></i> <strong>Proyecto:</strong><br>
                  <span class="ms-3">{{ $event->project->nombre }}</span>
                </div>
                @if($event->project->categoria)
                  <div class="feature-item mb-2">
                    <i class="bi bi-folder"></i> <strong>Categoría:</strong><br>
                    <span class="ms-3">{{ $event->project->categoria }}</span>
                  </div>
                @endif
                @if($event->project->ubicacion)
                  <div class="feature-item mb-2">
                    <i class="bi bi-geo-alt"></i> <strong>Ubicación:</strong><br>
                    <span class="ms-3">{{ $event->project->ubicacion }}</span>
                  </div>
                @endif
                @if($event->project->estado)
                  <div class="feature-item mb-2">
                    <i class="bi bi-check-circle"></i> <strong>Estado:</strong><br>
                    <span class="ms-3">{{ ucfirst($event->project->estado) }}</span>
                  </div>
                @endif
              </div>
              @if($event->project->descripcion)
                <p class="mt-3">{{ Str::limit($event->project->descripcion, 200) }}</p>
              @endif
              <a href="{{ route('projects.public.show', $event->project) }}" class="btn btn-outline-primary mt-2">
                Ver Proyecto <i class="bi bi-arrow-right ms-1"></i>
              </a>
            </div>
          </div>
        </div>
      @endif
    </div>
  </section>

  <!-- Línea divisoria -->
  <div class="container">
    <hr class="my-5" style="border-color: var(--accent-color); opacity: 0.3;">
  </div>

  <!-- Call to Action -->
  <section id="event-cta" class="call-to-action section light-background">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <div class="cta-content">
            <h3>¿Te interesa participar en este evento?</h3>
            <p>Únete a nosotros y forma parte de la transformación de comunidades en Guatemala. Cada evento es una oportunidad para hacer la diferencia.</p>
            
            @if($event->registration_required)
              <div class="alert alert-info mt-3">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Registro requerido:</strong> 
                @if($event->registration_deadline)
                  Debes registrarte antes del {{ $event->registration_deadline->format('d/m/Y H:i') }}.
                @else
                  Este evento requiere registro previo.
                @endif
                @if($event->contact_email)
                  <br>Contacta a: <a href="mailto:{{ $event->contact_email }}">{{ $event->contact_email }}</a>
                @endif
              </div>
            @endif

            @if($event->max_participants && $event->current_participants >= $event->max_participants)
              <div class="alert alert-warning mt-3">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Cupos completos:</strong> Este evento ya no tiene cupos disponibles.
              </div>
            @endif
          </div>
        </div>
        <div class="col-lg-4 text-center text-lg-end">
          <div class="cta-buttons">
            <a href="{{ route('home') }}#events" class="btn btn-outline-primary">
              <i class="bi bi-arrow-left me-2"></i>Ver Más Eventos
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  </main>

<x-footer />
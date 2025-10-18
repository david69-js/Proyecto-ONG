<x-head>
  <link rel="stylesheet" href="assets/css/donadores.css">
</x-head>
<body class="index-page">
<x-header />
<main class="main">
  @php
    use App\Models\AboutSection;
    $about = AboutSection::first();
@endphp
  @php
    use App\Models\HeroSection;
    $hero = HeroSection::first();
@endphp 
 @php
    use App\Models\Project; // 
    $projects = Project::all(); 
@endphp

   <!-- Sección Hero -->
<section id="hero" class="hero section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="hero-content" data-aos="fade-right" data-aos-delay="200">

          <!-- Subtítulo -->
          <span class="subtitle">{{ optional($hero)->subtitle ?? 'Construyendo esperanza' }}</span>

          <!-- Título principal -->
          <h1>{{ optional($hero)->title ?? 'Juntos construimos hogares, comunidades y futuro' }}</h1>

          <!-- Descripción -->
          <p>{{ optional($hero)->description ?? 'Trabajamos cada día para mejorar la calidad de vida...' }}</p>

          <!-- Botones -->
          <div class="hero-buttons">
            <a href="{{ optional($hero)->button_primary_link ?? '#' }}" class="btn-primary">
              {{ optional($hero)->button_primary_text ?? 'Haz tu donación' }}
            </a>
            <a href="{{ optional($hero)->button_secondary_link ?? '#' }}" class="btn-secondary">
              {{ optional($hero)->button_secondary_text ?? 'Conoce nuestros proyectos' }}
            </a>
          </div>

          <!-- Logros numéricos -->
          <div class="trust-badges">
            <div class="badge-item">
              <i class="bi bi-people"></i>
              <div class="badge-text">
                <span class="count">{{ optional($hero)->anios_servicio ?? '25+' }}</span>
                <span class="label">Años de servicio</span>
              </div>
            </div>
            <div class="badge-item">
              <i class="bi bi-house-heart"></i>
              <div class="badge-text">
                <span class="count">{{ optional($hero)->viviendas_construidas ?? '500+' }}</span>
                <span class="label">Viviendas construidas</span>
              </div>
            </div>
            <div class="badge-item">
              <i class="bi bi-person-hearts"></i>
              <div class="badge-text">
                <span class="count">{{ optional($hero)->familias_beneficiadas ?? '300+' }}</span>
                <span class="label">Familias beneficiadas</span>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
        <div class="hero-image">
          <!-- Imagen principal -->
          <img
            src="{{ optional($hero)->image_main ? asset('storage/'.optional($hero)->image_main) : asset('assets/img/construction/showcase-3.webp') }}"
            alt="Voluntarios construyendo" class="img-fluid">

          <!-- Badge de la imagen -->
          <div class="image-badge">
            <span>{{ optional($hero)->image_badge_text ?? 'Organización sin fines de lucro' }}</span>
            <p>{{ optional($hero)->image_badge_subtext ?? 'Comprometidos con Guatemala' }}</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section><!-- /Sección Hero -->


 <!-- Sección Sobre Nosotros -->
<section id="about" class="about section">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row align-items-center g-5">

      <!-- Contenido de texto -->
      <div class="col-lg-6">
        <div class="about-content" data-aos="fade-right" data-aos-delay="200">

          <h2>{{ $about->titulo ?? 'Construyendo esperanza desde 1995' }}</h2>

          <p class="lead">
            {{ $about->descripcion_principal ?? 'Desde nuestros inicios hemos trabajado para que las familias guatemaltecas tengan acceso a una vivienda segura y un entorno digno.' }}
          </p>

          <p>
            {{ $about->descripcion_secundaria ?? 'Gracias al apoyo de donantes, voluntarios y aliados, hemos construido y mejorado cientos de hogares.' }}
          </p>

          <!-- Logros con imágenes -->
          @php
            $logros = [
              'anios_servicio' => 'Años de servicio',
              'hogares_construidos' => 'Hogares construidos',
              'compromiso_social' => 'Compromiso social',
              'colaboradores_activos' => 'Colaboradores activos',
            ];
          @endphp
          <div class="achievement-boxes row g-4 mt-4">
            @foreach($logros as $field => $label)
            @php $imgField = 'imagen_'.$field; @endphp
            <div class="col-6 col-md-3 text-center" data-aos="fade-up">
                @if(!empty($about->$imgField))
                    <img src="{{ asset('storage/'.$about->$imgField) }}" alt="{{ $label }}" class="img-fluid mb-2" width="50">
                @endif
                <h3>{{ $about->$field ?? '' }}</h3>
                <p>{{ $label }}</p>
            </div>
            @endforeach
          </div>
          <!-- Certificaciones -->
<div class="certifications mt-5" data-aos="fade-up" data-aos-delay="700">
    <h5>Alianzas y Reconocimientos</h5>
    <div class="row g-3 align-items-center">
        @foreach(['badge_1', 'badge_2', 'badge_3'] as $badge)
            <div class="col-4 col-md-3">
                @if(!empty($about->$badge))
                    <img src="{{ asset('storage/'.$about->$badge) }}" alt="Certificación" class="img-fluid">
                @else
                    <!-- Imagen por defecto si no hay badge -->
                    <img src="{{ asset('assets/img/construction/default-badge.webp') }}" alt="Certificación" class="img-fluid">
                @endif
            </div>
        @endforeach
    </div>
</div>
          <!-- Botón -->
          <div class="cta-container mt-5" data-aos="fade-up" data-aos-delay="800">
            <a href="{{ $about->link_conoce_mas ?? '#' }}" class="btn btn-primary">Conoce más sobre nosotros</a>
          </div>
        </div>
      </div>

      <!-- Imágenes principales -->
      <div class="col-lg-6">
        <div class="about-image position-relative" data-aos="fade-left" data-aos-delay="200">

          @if(!empty($about->imagen_principal))
            <img src="{{ asset('storage/'.$about->imagen_principal) }}" alt="Equipo de voluntarios" class="img-fluid main-image rounded">
          @else
            <img src="{{ asset('assets/img/construction/project-3.webp') }}" alt="Equipo de voluntarios" class="img-fluid main-image rounded">
          @endif

          <div class="image-overlay">
            @if(!empty($about->imagen_secundaria))
              <img src="{{ asset('storage/'.$about->imagen_secundaria) }}" alt="Familia beneficiada" class="img-fluid rounded">
            @else
              <img src="{{ asset('assets/img/construction/project-7.webp') }}" alt="Familia beneficiada" class="img-fluid rounded">
            @endif
          </div>

          <div class="experience-badge" data-aos="zoom-in" data-aos-delay="500">
            <span>{{ $about->anios_servicio ?? '25+' }}</span>
            <p>Años de experiencia</p>
          </div>

        </div>
      </div>

    </div>
  </div>

</section>
<!-- /Sección Sobre Nosotros -->

   <!-- Sección de Eventos/Publicados -->
<section id="services" class="services section">

  <!-- Título de sección -->
  <div class="container section-title">
    <h2>Eventos</h2>
    <p>Conoce los eventos que tenemos disponibles y participa activamente en nuestras actividades</p>
  </div><!-- Fin Título -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4">
      @forelse(\App\Models\Event::published()->get() as $event)
        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ 200 + $loop->index * 100 }}">
          <div class="service-card {{ $event->featured ? 'featured' : '' }}">
            @if($event->featured)
              <div class="service-badge">Destacado</div>
            @endif
            <div class="service-icon">
              <i class="bi bi-calendar-event"></i>
            </div>
            <h3>{{ $event->title }}</h3>
            <p>{{ Str::limit($event->description, 100) }}</p>
            <div class="service-features">
              <span><i class="bi bi-geo-alt"></i> {{ $event->location ?? 'Sin ubicación' }}</span>
              @if($event->start_date)
                <span><i class="bi bi-clock"></i> {{ $event->start_date->format('d/m/Y H:i') }}</span>
              @endif
              @if($event->end_date)
                <span><i class="bi bi-clock-history"></i> {{ $event->end_date->format('d/m/Y H:i') }}</span>
              @endif
            </div>
            <a href="{{ route('events.show', $event) }}" class="service-link">
              Ver más <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>
      @empty
        <p class="text-muted">No hay eventos publicados actualmente.</p>
      @endforelse
    </div>

  </div>
</section><!-- /Sección de Eventos -->

  </main>
</body>

<!-- /APARTADO1 -->
</section><!-- /Servicios Section -->


<!-- Sección de Proyectos -->
<section id="projects" class="projects section">
  <div class="container section-title">
    <h2>Proyectos</h2>
    <p>Transformamos vidas a través de la construcción de viviendas seguras y comunidades sostenibles.</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="projects-grid">
      @forelse($projects as $project)
        <div class="project-item" data-aos="zoom-in" data-aos-delay="{{ $loop->iteration * 100 }}">
          <div class="project-content">
            <div class="project-header">
              <span class="project-category">{{ $project->categoria ?? 'Sin categoría' }}</span>
              <span class="project-status {{ $project->estado == 'completado' ? 'completed' : ($project->estado == 'en progreso' ? 'in-progress' : 'planning') }}">
                {{ ucfirst($project->estado) }}
              </span>
            </div>

            <h3 class="project-title">{{ $project->nombre }}</h3>

            <div class="project-details">
              <div class="project-info">
                <p>{{ $project->descripcion ?? 'Sin descripción' }}</p>
                <div class="project-specs">
                  @if($project->viviendas)
                    <span class="spec-item">
                      <i class="bi bi-house"></i>
                      {{ $project->viviendas }} Viviendas
                    </span>
                  @endif
                  @if($project->duracion_meses)
                    <span class="spec-item">
                      <i class="bi bi-calendar-check"></i>
                      {{ $project->duracion_meses }} Meses
                    </span>
                  @endif
                  @if($project->area_km)
                    <span class="spec-item">
                      <i class="bi bi-rulers"></i>
                      {{ $project->area_km }} km²
                    </span>
                  @endif
                </div>
              </div>

              <div class="project-location">
                <i class="bi bi-geo-alt-fill"></i>
                <span>{{ $project->ubicacion ?? 'Ubicación no definida' }}</span>
              </div>
            </div>

            <a href="{{ route('projects.show', $project) }}" class="project-link">
              <span>Ver Proyecto</span>
              <i class="bi bi-arrow-right"></i>
            </a>
          </div>

          <div class="project-visual">
            <img src="{{ $project->imagen ?? asset('assets/img/construction/default.webp') }}" 
                 alt="{{ $project->nombre }}" 
                 class="img-fluid">
          </div>
        </div>
      @empty
        <p class="text-center">No hay proyectos publicados por el momento.</p>
      @endforelse
    </div>
  </div>
</section>


 <style>
/* ---------------- Beneficiarios ---------------- */
.beneficiario-slide .author-avatar {
  width: 60px;       /* Tamaño reducido */
  height: 60px;
  object-fit: cover;
  border-radius: 50%;
}

/* ---------------- Patrocinadores ---------------- */
.patro-card .patro-icon img {
  width: 80px;       /* Tamaño reducido */
  height: 80px;
  object-fit: contain;
}
</style>

<!-- Beneficiarios Section -->
<section id="beneficiarios" class="beneficiarios section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="beneficiarios-slider swiper init-swiper">
      <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 600,
          "autoplay": {"delay": 5000},
          "slidesPerView": 1,
          "spaceBetween": 30,
          "pagination": {"el": ".swiper-pagination","type": "bullets","clickable": true},
          "navigation": {"nextEl": ".swiper-button-next","prevEl": ".swiper-button-prev"}
        }
      </script>
      <div class="swiper-wrapper">

        <div class="swiper-slide">
          <div class="beneficiario-slide" data-aos="fade-up" data-aos-delay="200">
            <div class="beneficiario-header">
              <div class="stars-rating">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
              </div>
              <div class="quote-icon"><i class="bi bi-quote"></i></div>
            </div>
            <div class="beneficiario-body">
              <p>"Gracias a la ayuda recibida, ahora nuestra familia cuenta con un hogar seguro y digno. Este apoyo ha transformado nuestra vida y la de nuestros hijos."</p>
            </div>
            <div class="beneficiario-footer">
              <div class="author-info">
                <img src="assets/img/person/person-f-12.webp" alt="Beneficiario" class="author-avatar">
                <div class="author-details">
                  <h4>María González</h4>
                  <span class="role">Madre de Familia</span>
                  <span class="company">Comunidad Villa Esperanza</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="beneficiario-slide" data-aos="fade-up" data-aos-delay="300">
            <div class="beneficiario-header">
              <div class="stars-rating">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
              </div>
              <div class="quote-icon"><i class="bi bi-quote"></i></div>
            </div>
            <div class="beneficiario-body">
              <p>"El apoyo recibido nos permitió acceder a servicios básicos y educación para nuestros hijos, mejorando significativamente nuestra calidad de vida."</p>
            </div>
            <div class="beneficiario-footer">
              <div class="author-info">
                <img src="assets/img/person/person-m-14.webp" alt="Beneficiario" class="author-avatar">
                <div class="author-details">
                  <h4>Carlos Méndez</h4>
                  <span class="role">Padre de Familia</span>
                  <span class="company">Comunidad Los Pinos</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="beneficiario-slide" data-aos="fade-up" data-aos-delay="400">
            <div class="beneficiario-header">
              <div class="stars-rating">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
              </div>
              <div class="quote-icon"><i class="bi bi-quote"></i></div>
            </div>
            <div class="beneficiario-body">
              <p>"Recibir esta ayuda nos ha dado la oportunidad de reconstruir nuestro hogar después del desastre. Estamos profundamente agradecidos con la organización."</p>
            </div>
            <div class="beneficiario-footer">
              <div class="author-info">
                <img src="assets/img/person/person-f-11.webp" alt="Beneficiario" class="author-avatar">
                <div class="author-details">
                  <h4>Juana López</h4>
                  <span class="role">Madre Soltera</span>
                  <span class="company">Barrio San Juan</span>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="swiper-navigation-wrapper">
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
      </div>

    </div>
  </div>
</section>

<!-- Patrocinadores Section -->
<section id="patrocinadores" class="patrocinadores section">
  <div class="container section-title">
    <h2>Patrocinadores &amp; Colaboradores</h2>
    <p>Empresas y organizaciones que apoyan nuestra misión y contribuyen al bienestar de la comunidad</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row align-items-center mb-5 content">
      <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
        <h2>Excelencia y Reconocimiento</h2>
        <p>Nuestros patrocinadores son reconocidos por su compromiso con la responsabilidad social, calidad y apoyo a proyectos comunitarios que transforman vidas.</p>
      </div>
      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
        <div class="badge-highlight">
          <img src="assets/img/construction/badge-5.webp" alt="Sello de Excelencia" class="img-fluid">
          <div class="badge-content">
            <h4>Patrocinador Destacado</h4>
            <p>Reconocido por su apoyo constante y contribución a proyectos comunitarios</p>
          </div>
        </div>
      </div>
    </div>

    <div class="patrocinador-grid" data-aos="fade-up" data-aos-delay="400">
      <div class="patro-card" data-aos="flip-left" data-aos-delay="100">
        <div class="patro-icon">
          <img src="assets/img/construction/badge-1.webp" alt="ISO 9001" class="img-fluid">
        </div>
        <div class="patro-details">
          <h5>Empresa A</h5>
          <span class="patro-category">Gestión de Calidad</span>
          <p>Contribuye activamente a proyectos de vivienda y desarrollo comunitario.</p>
        </div>
      </div>
      <div class="patro-card" data-aos="flip-left" data-aos-delay="200">
        <div class="patro-icon">
          <img src="assets/img/construction/badge-2.webp" alt="OSHA" class="img-fluid">
        </div>
        <div class="patro-details">
          <h5>Empresa B</h5>
          <span class="patro-category">Seguridad y Salud</span>
          <p>Apoya programas de seguridad en la construcción y formación de voluntarios.</p>
        </div>
      </div>
      <div class="patro-card" data-aos="flip-left" data-aos-delay="300">
        <div class="patro-icon">
          <img src="assets/img/construction/badge-3.webp" alt="Licensed" class="img-fluid">
        </div>
        <div class="patro-details">
          <h5>Empresa C</h5>
          <span class="patro-category">Cumplimiento Legal</span>
          <p>Garantiza la legalidad y transparencia en todas sus contribuciones y proyectos.</p>
        </div>
      </div>
      <div class="patro-card" data-aos="flip-left" data-aos-delay="400">
        <div class="patro-icon">
          <img src="assets/img/construction/badge-4.webp" alt="Green Building" class="img-fluid">
        </div>
        <div class="patro-details">
          <h5>Empresa D</h5>
          <span class="patro-category">Construcción Sostenible</span>
          <p>Promueve prácticas sostenibles y respetuosas con el medio ambiente en todos los proyectos.</p>
        </div>
      </div>
      <div class="patro-card" data-aos="flip-left" data-aos-delay="500">
        <div class="patro-icon">
          <img src="assets/img/construction/badge-6.webp" alt="Insurance" class="img-fluid">
        </div>
        <div class="patro-details">
          <h5>Empresa E</h5>
          <span class="patro-category">Gestión de Riesgos</span>
          <p>Proporciona seguros y cobertura para los proyectos que apoyan a la comunidad.</p>
        </div>
      </div>
      <div class="patro-card" data-aos="flip-left" data-aos-delay="600">
        <div class="patro-icon">
          <img src="assets/img/construction/badge-7.webp" alt="Training" class="img-fluid">
        </div>
        <div class="patro-details">
          <h5>Empresa F</h5>
          <span class="patro-category">Capacitación Profesional</span>
          <p>Imparte formación y habilidades técnicas para voluntarios y beneficiarios.</p>
        </div>
      </div>
    </div>

    <div class="achievements-banner" data-aos="zoom-in" data-aos-delay="700">
      <div class="row text-center">
        <div class="col-lg-3 col-sm-6">
          <div class="achievement-item">
            <i class="bi bi-award"></i>
            <h3>15+</h3>
            <p>Premios y Reconocimientos</p>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="achievement-item">
            <i class="bi bi-shield-check"></i>
            <h3>Cero</h3>
            <p>Incidentes de Seguridad</p>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="achievement-item">
            <i class="bi bi-clock-history"></i>
            <h3>18</h3>
            <p>Años de Experiencia</p>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="achievement-item">
            <i class="bi bi-people"></i>
            <h3>350+</h3>
            <p>Beneficiarios Apoyados</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>


<!-- Donadores Section -->
<section id="donadores" class="donadores section">

  <!-- Estilos internos -->
  <style>
    /* Contenedor y título */
    .donadores .section-title h2 {
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
      text-align: center;
    }
    .donadores .section-title p {
      text-align: center;
      color: #666;
      margin-bottom: 2rem;
    }

    /* Tarjetas Destacadas */
    .donador-card.featured {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .donador-card.featured:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 25px rgba(0,0,0,0.2);
    }
    .donador-header {
      display: flex;
      align-items: center;
      padding: 1rem;
      gap: 1rem;
    }
    .donador-image {
      position: relative;
      flex-shrink: 0;
    }
    .donador-image img {
      border-radius: 12px;
      width: 150px;
      height: 150px;
      object-fit: cover;
    }
    .experience-badge {
      position: absolute;
      bottom: 0;
      left: 0;
      background: #f39c12;
      color: #fff;
      font-weight: bold;
      padding: 0.3rem 0.6rem;
      border-radius: 0 12px 12px 0;
      font-size: 0.8rem;
    }
    .donador-info h4 {
      margin: 0;
      font-size: 1.2rem;
    }
    .donador-info .position {
      font-size: 0.9rem;
      color: #888;
    }
    .contact-info a {
      display: block;
      font-size: 0.85rem;
      color: #555;
      text-decoration: none;
      margin-top: 0.2rem;
    }
    .donador-details {
      padding: 1rem;
      border-top: 1px solid #eee;
    }
    .credentials {
      display: flex;
      gap: 1rem;
      margin-top: 0.5rem;
    }
    .cred-item {
      display: flex;
      align-items: center;
      gap: 0.3rem;
      font-size: 0.85rem;
      color: #555;
    }
    .social-links a {
      display: inline-block;
      margin-right: 0.5rem;
      color: #555;
      font-size: 1rem;
      transition: color 0.3s;
    }
    .social-links a:hover {
      color: #f39c12;
    }

    /* Tarjetas Compactas */
    .donador-card.compact {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s, box-shadow 0.3s;
      cursor: pointer;
    }
    .donador-card.compact:hover {
      transform: translateY(-5px) scale(1.03);
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    .member-photo {
      position: relative;
      overflow: hidden;
    }
    .member-photo img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: transform 0.3s;
    }
    .donador-card.compact:hover .member-photo img {
      transform: scale(1.05);
    }
    .hover-overlay {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.6);
      color: #fff;
      opacity: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      transition: opacity 0.3s;
      flex-direction: column;
      padding: 1rem;
      border-radius: 0 0 12px 12px;
    }
    .donador-card.compact:hover .hover-overlay {
      opacity: 1;
    }
    .member-summary {
      padding: 0.8rem;
      text-align: center;
    }
    .member-summary h5 {
      margin: 0;
      font-size: 1rem;
    }
    .member-summary span {
      font-size: 0.85rem;
      color: #888;
      display: block;
      margin-bottom: 0.5rem;
    }
    .skills {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 0.3rem;
    }
    .skill-tag {
      background: #f39c12;
      color: #fff;
      font-size: 0.75rem;
      padding: 0.2rem 0.5rem;
      border-radius: 8px;
    }
  </style>

  <!-- Contenido de Donadores -->
  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4">

      <!-- Donador Destacado 1 -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
        <div class="donador-card featured">
          <div class="donador-header">
            <div class="donador-image">
              <img src="assets/img/construction/team-1.webp" class="img-fluid" alt="">
              <div class="experience-badge">15+ Años Apoyando</div>
            </div>
            <div class="donador-info">
              <h4>Marcus Thompson</h4>
              <span class="position">Donador Principal</span>
              <div class="contact-info">
                <a href="mailto:marcus@example.com"><i class="bi bi-envelope"></i> marcus@example.com</a>
                <a href="tel:+1555123456"><i class="bi bi-telephone"></i> +1 (555) 123-456</a>
              </div>
            </div>
          </div>
          <div class="donador-details">
            <p>Marcus ha contribuido generosamente a proyectos de vivienda y educación, impactando positivamente la vida de muchas familias.</p>
            <div class="credentials">
              <div class="cred-item">
                <i class="bi bi-award"></i>
                <span>Reconocido por su compromiso social</span>
              </div>
              <div class="cred-item">
                <i class="bi bi-shield-check"></i>
                <span>Donador de Largo Plazo</span>
              </div>
            </div>
            <div class="social-links">
              <a href="#"><i class="bi bi-linkedin"></i></a>
              <a href="#"><i class="bi bi-twitter-x"></i></a>
              <a href="#"><i class="bi bi-facebook"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Donador Destacado 2 -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
        <div class="donador-card featured">
          <div class="donador-header">
            <div class="donador-image">
              <img src="assets/img/construction/team-2.webp" class="img-fluid" alt="">
              <div class="experience-badge">12+ Años Apoyando</div>
            </div>
            <div class="donador-info">
              <h4>Sarah Rodriguez</h4>
              <span class="position">Donadora Principal</span>
              <div class="contact-info">
                <a href="mailto:sarah@example.com"><i class="bi bi-envelope"></i> sarah@example.com</a>
                <a href="tel:+1555123457"><i class="bi bi-telephone"></i> +1 (555) 123-457</a>
              </div>
            </div>
          </div>
          <div class="donador-details">
            <p>Sarah ha apoyado iniciativas de educación y salud, mejorando la calidad de vida de muchas familias en la comunidad.</p>
            <div class="credentials">
              <div class="cred-item">
                <i class="bi bi-person-badge"></i>
                <span>Donadora Reconocida</span>
              </div>
              <div class="cred-item">
                <i class="bi bi-tools"></i>
                <span>Apoyo a Proyectos Comunitarios</span>
              </div>
            </div>
            <div class="social-links">
              <a href="#"><i class="bi bi-linkedin"></i></a>
              <a href="#"><i class="bi bi-twitter-x"></i></a>
              <a href="#"><i class="bi bi-instagram"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Donadores Compactos -->
      <!-- Repite según necesites -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="donador-card compact hover-animate">
          <div class="member-photo">
            <img src="assets/img/construction/team-3.webp" class="img-fluid" alt="">
            <div class="hover-overlay">
              <div class="overlay-content">
                <h5>David Chen</h5>
                <span>Donador Activo</span>
                <div class="quick-contact">
                  <a href="#"><i class="bi bi-envelope"></i></a>
                  <a href="#"><i class="bi bi-telephone"></i></a>
                  <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="member-summary">
            <h5>David Chen</h5>
            <span>Donador Activo</span>
            <div class="skills">
              <span class="skill-tag">Educación</span>
              <span class="skill-tag">Salud</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Repite para más donadores compactos -->
    </div>
  </div>
</section>
<!-- Sección de Llamado a la Acción / Donaciones -->
<section id="call-to-action" class="call-to-action section light-background">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row g-5 align-items-center">

      <!-- Lado izquierdo: Mensaje inspirador -->
      <div class="col-lg-6">
        <div class="cta-hero-content" data-aos="fade-right" data-aos-delay="200">
          <div class="badge-wrapper">
            <span class="cta-badge">
              <i class="bi bi-heart-fill"></i>
              Contribuyendo al Hogar y la Comunidad
            </span>
          </div>

          <h2>Ayuda a Construir un Hogar para Familias Necesitadas</h2>
          <p>Tu apoyo permite que familias en Guatemala tengan acceso a viviendas seguras y dignas, mejorando su calidad de vida y fortaleciendo la comunidad.</p>

          <div class="feature-highlights">
            <div class="highlight-item">
              <i class="bi bi-check-circle-fill"></i>
              <span>Proyectos de vivienda sostenibles y seguros</span>
            </div>
            <div class="highlight-item">
              <i class="bi bi-check-circle-fill"></i>
              <span>Programas de educación y fortalecimiento comunitario</span>
            </div>
            <div class="highlight-item">
              <i class="bi bi-check-circle-fill"></i>
              <span>Impacto directo en familias con necesidad</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Lado derecho: Formulario de donación / contacto -->
      <div class="col-lg-6">
        <div class="cta-form-section" data-aos="fade-left" data-aos-delay="300">
          <div class="form-container">
            <div class="form-header">
              <h3>Haz tu Donación o Contáctanos</h3>
              <p>Con tu apoyo, podemos cambiar vidas. Completa el formulario y únete a nuestra causa.</p>
            </div>

            <form action="forms/donacion.php" method="post" class="php-email-form">
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Tu Nombre" required="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Tu Correo Electrónico" required="">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <input type="tel" name="phone" class="form-control" placeholder="Número de Teléfono" required="">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <select name="donation_type" class="form-control" required="">
                      <option value="">Tipo de Apoyo</option>
                      <option value="donacion-monetaria">Donación Monetaria</option>
                      <option value="voluntariado">Voluntariado</option>
                      <option value="apoyo-material">Apoyo con Materiales</option>
                      <option value="otro">Otro</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <textarea name="message" class="form-control" rows="4" placeholder="Mensaje / Comentarios" required=""></textarea>
                  </div>
                </div>
              </div>

              <div class="loading">Cargando</div>
              <div class="error-message"></div>
              <div class="sent-message">¡Gracias! Tu solicitud ha sido enviada y recibida correctamente.</div>

              <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-heart"></i>
                  Enviar Apoyo
                </button>

                <div class="contact-alternative">
                  <span>O contáctanos directamente:</span>
                  <a href="tel:+50212345678" class="phone-link">
                    <i class="bi bi-telephone-fill"></i>
                    +502 1234-5678
                  </a>
                </div>
              </div>
            </form>
          </div>

          <div class="trust-indicators" data-aos="fade-up" data-aos-delay="400">
            <div class="row g-3">
              <div class="col-4">
                <div class="trust-item">
                  <div class="trust-icon">
                    <i class="bi bi-clock"></i>
                  </div>
                  <div class="trust-content">
                    <span class="trust-number">24h</span>
                    <span class="trust-label">Tiempo de Respuesta</span>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="trust-item">
                  <div class="trust-icon">
                    <i class="bi bi-people-fill"></i>
                  </div>
                  <div class="trust-content">
                    <span class="trust-number">500+</span>
                    <span class="trust-label">Familias Apoyadas</span>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="trust-item">
                  <div class="trust-icon">
                    <i class="bi bi-house-fill"></i>
                  </div>
                  <div class="trust-content">
                    <span class="trust-number">120+</span>
                    <span class="trust-label">Viviendas Construidas</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>

  </div>

</section>
  </main>

  <x-footer />
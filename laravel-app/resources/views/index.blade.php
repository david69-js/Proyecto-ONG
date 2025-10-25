<x-head>
  <link rel="stylesheet" href="assets/css/donadores.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">

</x-head>
<body class="index-page d-flex flex-column min-vh-100">
<x-header />
<main class="main flex-grow-1">
  @php
    use App\Models\AboutSection;
    $about = AboutSection::first();
@endphp
  @php
    use App\Models\HeroSection;
    $hero = HeroSection::first();
@endphp 
@php
    use App\Models\SponsorHighlight;
    $sponsors = SponsorHighlight::first();
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
            <a href="#call-to-action" class="btn-primary">
              {{ optional($hero)->button_primary_text ?? 'Haz tu donación' }}
            </a>
            <a href="#projects" class="btn-secondary">
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

<!-- Sección Misión y Visión -->
<section id="mission-vision" class="mission-vision section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row">
      <div class="col-lg-12 text-center mb-5">
        <h2>Nuestra Misión y Visión</h2>
        <p>Los principios que guían nuestro trabajo en Habitat Guatemala</p>
      </div>
    </div>
    
    <div class="row g-5">
      <!-- Misión -->
      <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
        <div class="mission-card">
          <div class="card-icon">
            <i class="bi bi-heart-fill"></i>
          </div>
          <h3>Nuestra Misión</h3>
          <p>Construir viviendas seguras y dignas para familias guatemaltecas de escasos recursos, promoviendo el desarrollo comunitario sostenible y fortaleciendo los lazos sociales a través del trabajo voluntario y la solidaridad.</p>
          <div class="mission-features">
            <div class="feature-item">
              <i class="bi bi-check-circle"></i>
              <span>Viviendas seguras y dignas</span>
            </div>
            <div class="feature-item">
              <i class="bi bi-check-circle"></i>
              <span>Desarrollo comunitario sostenible</span>
            </div>
            <div class="feature-item">
              <i class="bi bi-check-circle"></i>
              <span>Trabajo voluntario y solidaridad</span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Visión -->
      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
        <div class="vision-card">
          <div class="card-icon">
            <i class="bi bi-eye-fill"></i>
          </div>
          <h3>Nuestra Visión</h3>
          <p>Ser la organización líder en Guatemala en la construcción de viviendas sociales, creando comunidades prósperas donde cada familia tenga un hogar digno y las oportunidades necesarias para su desarrollo integral.</p>
          <div class="vision-features">
            <div class="feature-item">
              <i class="bi bi-star"></i>
              <span>Organización líder en vivienda social</span>
            </div>
            <div class="feature-item">
              <i class="bi bi-star"></i>
              <span>Comunidades prósperas y sostenibles</span>
            </div>
            <div class="feature-item">
              <i class="bi bi-star"></i>
              <span>Desarrollo integral de las familias</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Valores -->
    <div class="row mt-5">
      <div class="col-12" data-aos="fade-up" data-aos-delay="400">
        <div class="values-section">
          <h3 class="text-center mb-4">Nuestros Valores</h3>
          <div class="row g-4">
            <div class="col-md-3 col-sm-6">
              <div class="value-item text-center">
                <div class="value-icon">
                  <i class="bi bi-people-fill"></i>
                </div>
                <h5>Solidaridad</h5>
                <p>Apoyo mutuo y trabajo en equipo</p>
              </div>
            </div>
            <div class="col-md-3 col-sm-6">
              <div class="value-item text-center">
                <div class="value-icon">
                  <i class="bi bi-shield-check"></i>
                </div>
                <h5>Transparencia</h5>
                <p>Honestidad en todas nuestras acciones</p>
              </div>
            </div>
            <div class="col-md-3 col-sm-6">
              <div class="value-item text-center">
                <div class="value-icon">
                  <i class="bi bi-award-fill"></i>
                </div>
                <h5>Excelencia</h5>
                <p>Calidad en cada proyecto</p>
              </div>
            </div>
            <div class="col-md-3 col-sm-6">
              <div class="value-item text-center">
                <div class="value-icon">
                  <i class="bi bi-heart-pulse"></i>
                </div>
                <h5>Compasión</h5>
                <p>Empatía hacia las familias necesitadas</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
.mission-vision {
  padding: 80px 0;
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.mission-card, .vision-card {
  background: #fff;
  padding: 40px 30px;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  height: 100%;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.mission-card:hover, .vision-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.card-icon {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, #007bff, #0056b3);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 25px;
  color: #fff;
  font-size: 2rem;
}

.mission-card h3, .vision-card h3 {
  color: #333;
  font-size: 1.8rem;
  font-weight: 700;
  margin-bottom: 20px;
  text-align: center;
}

.mission-card p, .vision-card p {
  color: #666;
  font-size: 1.1rem;
  line-height: 1.6;
  margin-bottom: 25px;
  text-align: center;
}

.mission-features, .vision-features {
  margin-top: 25px;
}

.feature-item {
  display: flex;
  align-items: center;
  margin-bottom: 15px;
  padding: 10px;
  background: #f8f9fa;
  border-radius: 8px;
  transition: background 0.3s ease;
}

.feature-item:hover {
  background: #e9ecef;
}

.feature-item i {
  color: #007bff;
  font-size: 1.2rem;
  margin-right: 12px;
  width: 20px;
}

.feature-item span {
  color: #333;
  font-weight: 500;
}

.values-section {
  background: #fff;
  padding: 40px 30px;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.values-section h3 {
  color: #333;
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 30px;
}

.value-item {
  padding: 20px 15px;
  transition: transform 0.3s ease;
}

.value-item:hover {
  transform: translateY(-5px);
}

.value-icon {
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg, #28a745, #20c997);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 15px;
  color: #fff;
  font-size: 1.5rem;
}

.value-item h5 {
  color: #333;
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 10px;
}

.value-item p {
  color: #666;
  font-size: 0.9rem;
  margin: 0;
}

@media (max-width: 768px) {
  .mission-card, .vision-card {
    padding: 30px 20px;
    margin-bottom: 30px;
  }
  
  .values-section {
    padding: 30px 20px;
  }
}
</style>

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
    <a href="{{ route('events.public.show', $event) }}" class="btn btn-outline-primary mt-auto">
  Ver más <i class="bi bi-arrow-right ms-1"></i>
</a>



          </div>
        </div>
      @empty
        <p class="text-muted">No hay eventos publicados actualmente.</p>
      @endforelse
    </div>

  </div>
</section><!-- /Sección de Eventos -->

<!-- /APARTADO1 -->
<!-- /Servicios Section -->


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

          {{-- Contenido principal --}}
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
                      <i class="bi bi-house"></i> {{ $project->viviendas }} Viviendas
                    </span>
                  @endif
                  @if($project->duracion_meses)
                    <span class="spec-item">
                      <i class="bi bi-calendar-check"></i> {{ $project->duracion_meses }} Meses
                    </span>
                  @endif
                  @if($project->area_km)
                    <span class="spec-item">
                      <i class="bi bi-rulers"></i> {{ $project->area_km }} km²
                    </span>
                  @endif
                </div>
              </div>

              <div class="project-location">
                <i class="bi bi-geo-alt-fill"></i>
                <span>{{ $project->ubicacion ?? 'Ubicación no definida' }}</span>
              </div>
            </div>

<a href="{{ route('projects.public.show', $project) }}" class="project-link">
              <span>Ver Proyecto</span>
              <i class="bi bi-arrow-right"></i>
            </a>
          </div>

          {{-- Carrusel de imágenes de fases --}}
          <div id="carouselProject{{ $project->id }}" class="carousel slide project-visual" data-bs-ride="carousel">
            <div class="carousel-inner rounded shadow-sm">

              @forelse($project->phaseImages as $index => $image)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                  <img src="{{ asset('storage/' . $image->image_path) }}"
                       class="d-block w-100 img-fluid"
                       alt="{{ $image->description ?? $project->nombre }}"
                       style="object-fit: cover; height: 280px;">
                  @if($image->description)
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
                      <p class="small text-white mb-0">{{ $image->description }}</p>
                    </div>
                  @endif
                </div>
              @empty
                <div class="carousel-item active">
                  <img src="{{ $project->imagen ?? asset('assets/img/construction/default.webp') }}"
                       class="d-block w-100 img-fluid"
                       alt="{{ $project->nombre }}"
                       style="object-fit: cover; height: 280px;">
                </div>
              @endforelse

            </div>

            {{-- Controles del carrusel --}}
            @if($project->phaseImages->count() > 1)
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselProject{{ $project->id }}" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselProject{{ $project->id }}" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
              </button>
            @endif
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
<!-- Sección de Beneficiarios -->
 <section id="projects" class="projects section">
  <div class="container section-title">
    <h2>Beneficiarios</h2>
    <p>Transformamos vidas a través de la construcción de viviendas seguras y comunidades sostenibles.</p>
  </div>
{{-- Beneficiarios Section --}}
@if(($testimonials ?? collect())->count())
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
  @forelse($testimonials as $t)
    <div class="swiper-slide">
      <div class="beneficiario-slide" data-aos="fade-up" data-aos-delay="200">
        <div class="beneficiario-header">
          <div class="stars-rating">
            @for($i=1; $i<=5; $i++)
              <i class="bi {{ $i <= ($t->rating ?? 5) ? 'bi-star-fill' : 'bi-star' }}"></i>
            @endfor
          </div>
          <div class="quote-icon"><i class="bi bi-quote"></i></div>
        </div>
        <div class="beneficiario-body">
          <p>{{ $t->body }}</p>
        </div>
        <div class="beneficiario-footer">
          <div class="author-info">
            @php
              $avatar = $t->avatar_path ? asset('storage/'.$t->avatar_path) : asset('assets/img/person/person-f-12.webp');
            @endphp
            <img src="{{ $avatar }}" alt="Beneficiario" class="author-avatar">
            <div class="author-details">
              <h4>{{ $t->author_name ?? optional($t->beneficiary)->name }}</h4>
              @if($t->role)<span class="role">{{ $t->role }}</span>@endif
              @if($t->company)<span class="company">{{ $t->company }}</span>@endif
            </div>
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="swiper-slide">
      <div class="beneficiario-slide">
        <div class="beneficiario-body">
          <p>Aún no hay testimonios publicados.</p>
        </div>
      </div>
    </div>
  @endforelse
</div>

      <div class="swiper-navigation-wrapper">
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
      </div>
    </div>
  </div>
</section>
@endif
<!-- fin Sección de Beneficiarios -->


<!-- Sección de Patroninadores -->
<section id="patrocinadores" class="patrocinadores section">
  <div class="container section-title">
    <h2>Patrocinadores &amp; Colaboradores</h2>
    <p>Empresas y organizaciones que apoyan nuestra misión y contribuyen al bienestar de la comunidad</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    {{-- Bloque destacado (toma el primero con is_featured) --}}
    @php
      $featured = ($sponsors ?? collect())->firstWhere('is_featured', true);
    @endphp

    @if($featured)
      <div class="row align-items-center mb-5 content">
        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
          <h2>{{ $featured->title ?? ($featured->sponsor?->name ?? 'Patrocinador Destacado') }}</h2>
          <p>{{ $featured->description ?? 'Patrocinador con apoyo constante a proyectos comunitarios.' }}</p>
        </div>
        <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
          <div class="badge-highlight">
            <img src="{{ $featured->logo_path ? asset('storage/'.$featured->logo_path) : asset('assets/img/construction/badge-5.webp') }}"
                 alt="Sello" class="img-fluid">
            <div class="badge-content">
              <h4>{{ $featured->category ?? 'Patrocinador Destacado' }}</h4>
              <p>{{ $featured->sponsor?->name }}</p>
            </div>
          </div>
        </div>
      </div>
    @endif

    {{-- Grid de tarjetas (todos los publicados; omite el destacado si quieres) --}}
    <div class="patrocinador-grid" data-aos="fade-up" data-aos-delay="400">
      @php
  $validSponsors = $sponsors instanceof \Illuminate\Support\Collection ? $sponsors : collect();
@endphp

@forelse($validSponsors as $sp)

        <div class="patro-card" data-aos="flip-left" data-aos-delay="{{ 100 + ($loop->index % 6)*100 }}">
          <div class="patro-icon">
            <img src="{{ $sp->logo_path ? asset('storage/'.$sp->logo_path) : asset('assets/img/construction/badge-1.webp') }}"
                 alt="{{ $sp->title ?? $sp->sponsor?->name }}" class="img-fluid">
          </div>
          <div class="patro-details">
            <h5>{{ $sp->title ?? $sp->sponsor?->name }}</h5>
            @if($sp->category)<span class="patro-category">{{ $sp->category }}</span>@endif
            @if($sp->description)<p>{{ $sp->description }}</p>@endif
          </div>
        </div>
      @empty
        <p class="text-center w-100">Nuestros Patrocinadores.</p>
      @endforelse
    </div>


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
   <section id="projects" class="projects section">
  <div class="container section-title">
    <h2>Donadores</h2>
    <p>Transforma vidas a través de la construcción de viviendas seguras y comunidades sostenibles.</p>
  </div>
<div class="container" data-aos="fade-up" data-aos-delay="100">
  <div class="row gy-4">

    {{-- Donadores Destacados (tarjetas grandes) --}}
    @foreach(($donors ?? collect())->where('is_featured', true) as $d)
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index*100) }}">
        <div class="donador-card featured">
          <div class="donador-header">
            <div class="donador-image">
              <img src="{{ $d->avatar_path ? asset('storage/'.$d->avatar_path) : asset('assets/img/construction/team-1.webp') }}" class="img-fluid" alt="">
              @if($d->badge_text)
                <div class="experience-badge">{{ $d->badge_text }}</div>
              @endif
            </div>
            <div class="donador-info">
              <h4>{{ $d->name }}</h4>
              @if($d->position)<span class="position">{{ $d->position }}</span>@endif
              <div class="contact-info">
                @if($d->email)<a href="mailto:{{ $d->email }}"><i class="bi bi-envelope"></i> {{ $d->email }}</a>@endif
                @if($d->phone)<a href="tel:{{ $d->phone }}"><i class="bi bi-telephone"></i> {{ $d->phone }}</a>@endif
              </div>
            </div>
          </div>
          <div class="donador-details">
            @if($d->bio)<p>{{ $d->bio }}</p>@endif
            <div class="credentials">
              @foreach($d->skills_array as $skill)
                <div class="cred-item">
                  <i class="bi bi-award"></i>
                  <span>{{ $skill }}</span>
                </div>
              @endforeach
            </div>
            <div class="social-links">
              @if($d->linkedin_url)<a href="{{ $d->linkedin_url }}"><i class="bi bi-linkedin"></i></a>@endif
              @if($d->twitter_url)<a href="{{ $d->twitter_url }}"><i class="bi bi-twitter-x"></i></a>@endif
              @if($d->facebook_url)<a href="{{ $d->facebook_url }}"><i class="bi bi-facebook"></i></a>@endif
              @if($d->instagram_url)<a href="{{ $d->instagram_url }}"><i class="bi bi-instagram"></i></a>@endif
              @if($d->website_url)<a href="{{ $d->website_url }}"><i class="bi bi-globe2"></i></a>@endif
            </div>
          </div>
        </div>
      </div>
    @endforeach

    {{-- Donadores “compactos” (tarjetas pequeñas) --}}
    @foreach(($donors ?? collect())->where('is_featured', false) as $d)
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 300 + ($loop->index%6)*100 }}">
        <div class="donador-card compact hover-animate">
          <div class="member-photo">
            <img src="{{ $d->avatar_path ? asset('storage/'.$d->avatar_path) : asset('assets/img/construction/team-3.webp') }}" class="img-fluid" alt="">
            <div class="hover-overlay">
              <div class="overlay-content">
                <h5>{{ $d->name }}</h5>
                @if($d->position)<span>{{ $d->position }}</span>@endif
                <div class="quick-contact">
                  @if($d->email)<a href="mailto:{{ $d->email }}"><i class="bi bi-envelope"></i></a>@endif
                  @if($d->phone)<a href="tel:{{ $d->phone }}"><i class="bi bi-telephone"></i></a>@endif
                  @if($d->linkedin_url)<a href="{{ $d->linkedin_url }}"><i class="bi bi-linkedin"></i></a>@endif
                </div>
              </div>
            </div>
          </div>
          <div class="member-summary">
            <h5>{{ $d->name }}</h5>
            @if($d->position)<span>{{ $d->position }}</span>@endif
            @if($d->skills_array)
              <div class="skills">
                @foreach($d->skills_array as $skill)
                  <span class="skill-tag">{{ $skill }}</span>
                @endforeach
              </div>
            @endif
          </div>
        </div>
      </div>
    @endforeach

  </div>
</div>
  <!-- FIN Contenido de Donadores -->
@php
  // Lee credenciales desde config/services.php o .env
  $paypalClientId = config('services.paypal.client_id', env('PAYPAL_CLIENT_ID'));
  $paypalCurrency = config('services.paypal.currency', env('PAYPAL_CURRENCY', 'USD'));
@endphp

@php
  use Illuminate\Support\Facades\Route as R;

  $paypalCreateUrl = R::has('donations.paypal.create')
      ? route('donations.paypal.create')
      : (R::has('admin.donations.paypal.create')
          ? route('admin.donations.paypal.create')
          : url('/donations/paypal/create-order'));

  $paypalCaptureUrl = R::has('donations.paypal.capture')
      ? route('donations.paypal.capture')
      : (R::has('admin.donations.paypal.capture')
          ? route('admin.donations.paypal.capture')
          : url('/donations/paypal/capture-order'));
@endphp

<!-- SDK de PayPal (cargar SOLO una vez en toda la página) -->
<script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency={{ $paypalCurrency }}&intent=capture"></script>
{{-- DEBUG PayPal: client-id inicia con: {{ substr($paypalClientId ?? '', 0, 8) ?: 'VACÍO' }} / currency: {{ $paypalCurrency ?? 'VACÍA' }} --}}

<script>
  // Comprobación defensiva en consola si el SDK no cargó
  if (!window.paypal || typeof window.paypal.Buttons !== 'function') {
    console.warn('PayPal SDK: cargando… (si no aparece en 5s, revisa client-id/adblock/HTTP 400)');
  }
</script>

<section id="call-to-action" class="call-to-action section light-background">
  <div class="container-fluid px-0" data-aos="fade-up" data-aos-delay="100">
    <div class="row g-5 align-items-center mx-0">

      <!-- Lado izquierdo -->
      <div class="col-lg-6">
        <div class="cta-hero-content" data-aos="fade-right" data-aos-delay="200">
          <div class="badge-wrapper">
            <span class="cta-badge"><i class="bi bi-heart-fill"></i> Contribuyendo al Hogar y la Comunidad</span>
          </div>
          <h2>Ayuda a Construir un Hogar para Familias Necesitadas</h2>
          <p>Tu apoyo permite que familias en Guatemala tengan acceso a viviendas seguras y dignas, mejorando su calidad de vida y fortaleciendo la comunidad.</p>
          <div class="feature-highlights">
            <div class="highlight-item"><i class="bi bi-check-circle-fill"></i> <span>Proyectos de vivienda sostenibles y seguros</span></div>
            <div class="highlight-item"><i class="bi bi-check-circle-fill"></i> <span>Programas de educación y fortalecimiento comunitario</span></div>
            <div class="highlight-item"><i class="bi bi-check-circle-fill"></i> <span>Impacto directo en familias con necesidad</span></div>
          </div>
        </div>
      </div>

      <!-- Lado derecho -->
      <div class="col-lg-6">
        <div class="cta-form-section" data-aos="fade-left" data-aos-delay="300">
          <div class="form-container">
            <div class="form-header">
              <h3>Haz tu Donación</h3>
              <p>Completa tus datos y realiza tu aporte seguro con PayPal.</p>
            </div>

            <form id="donation-form" class="php-email-form" onsubmit="return false;">
              @csrf
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" name="donor_name" class="form-control" placeholder="Tu Nombre" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <input type="email" name="donor_email" class="form-control" placeholder="Tu Correo (opcional)">
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <input type="tel" name="donor_phone" class="form-control" placeholder="Número de Teléfono (opcional)">
                  </div>
                </div>

                <!-- Monto + botones rápidos -->
                <div class="col-12">
                  <label class="form-label mb-1">Selecciona un monto rápido o escribe el tuyo</label>
                  <div class="d-flex flex-wrap gap-2 mb-2">
                    <button type="button" class="btn btn-outline-primary btn-sm quick-amt" data-amount="100">100 {{ $paypalCurrency }}</button>
                    <button type="button" class="btn btn-outline-primary btn-sm quick-amt" data-amount="200">200 {{ $paypalCurrency }}</button>
                    <button type="button" class="btn btn-outline-primary btn-sm quick-amt" data-amount="500">500 {{ $paypalCurrency }}</button>
                    <button type="button" class="btn btn-outline-primary btn-sm quick-amt" data-amount="1000">1000 {{ $paypalCurrency }}</button>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <input type="number" min="1" step="0.01" name="amount" class="form-control" placeholder="Monto ({{ $paypalCurrency }})" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <select name="currency" class="form-control" required>
                      <option value="{{ $paypalCurrency }}" selected>{{ $paypalCurrency }}</option>
                    </select>
                  </div>
                </div>

                {{-- Proyecto (opcional) --}}
                @isset($projects)
                <div class="col-12">
                  <div class="form-group">
                    <select name="project_id" class="form-control">
                      <option value="">Apoyar a la ONG (sin proyecto)</option>
                      @foreach($projects as $p)
                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @endisset

                <div class="col-12">
                  <div class="form-group">
                    <input type="text" name="notes" class="form-control" placeholder="Motivo / Programa (opcional)">
                  </div>
                </div>
              </div>

              <div class="loading" style="display:none">Cargando…</div>
              <div class="error-message alert alert-danger py-2 px-3 my-2" style="display:none"></div>
              <div class="sent-message alert alert-success py-2 px-3 my-2" style="display:none">¡Gracias! Tu donación fue procesada.</div>

              <!-- Botón de PayPal -->
              <div id="paypal-button-wrapper" class="mt-2">
                <div id="paypal-button-container"></div>
              </div>

              <div class="form-actions mt-3">
                <div class="contact-alternative">
                  <span>O contáctanos directamente:</span>
                  <a href="tel:+50212345678" class="phone-link"><i class="bi bi-telephone-fill"></i> +502 1234-5678</a>
                </div>
              </div>
            </form>
          </div>

          <div class="trust-indicators" data-aos="fade-up" data-aos-delay="400">
            <div class="row g-3">
              <div class="col-4">
                <div class="trust-item"><div class="trust-icon"><i class="bi bi-clock"></i></div><div class="trust-content"><span class="trust-number">24h</span><span class="trust-label">Tiempo de Respuesta</span></div></div>
              </div>
              <div class="col-4">
                <div class="trust-item"><div class="trust-icon"><i class="bi bi-people-fill"></i></div><div class="trust-content"><span class="trust-number">500+</span><span class="trust-label">Familias Apoyadas</span></div></div>
              </div>
              <div class="col-4">
                <div class="trust-item"><div class="trust-icon"><i class="bi bi-house-fill"></i></div><div class="trust-content"><span class="trust-number">120+</span><span class="trust-label">Viviendas Construidas</span></div></div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('donation-form');
  const loadingEl = form.querySelector('.loading');
  const errorEl = form.querySelector('.error-message');
  const okEl = form.querySelector('.sent-message');
  const paypalWrapper = document.getElementById('paypal-button-wrapper');
  const amountInput = form.amount;

  function showLoading(show) { loadingEl.style.display = show ? '' : 'none'; }
  function showError(msg) { errorEl.textContent = msg || ''; errorEl.style.display = msg ? '' : 'none'; }
  function showOk() { okEl.style.display = ''; }
  function validAmount() {
    const val = parseFloat(amountInput.value);
    return !isNaN(val) && val >= 1;
  }

  // Botones de monto rápido
  document.querySelectorAll('.quick-amt').forEach(btn => {
    btn.addEventListener('click', () => {
      amountInput.value = parseFloat(btn.dataset.amount).toFixed(2);
      togglePaypalVisibility();
    });
  });

  // Espera hasta 5s a que el SDK esté disponible antes de renderizar el botón
  function waitForPaypalReady(cb) {
    if (window.paypal && typeof window.paypal.Buttons === 'function') {
      cb();
      return;
    }
    const started = Date.now();
    const int = setInterval(() => {
      if (window.paypal && typeof window.paypal.Buttons === 'function') {
        clearInterval(int);
        cb();
      } else if (Date.now() - started > 5000) {
        clearInterval(int);
        console.warn('PayPal SDK no se cargó en 5s (¿client-id vacío / adblock / error 400?).');
        showError('No se pudo cargar el SDK de PayPal. Revisa tu conexión o desactiva bloqueadores.');
      }
    }, 200);
  }

  // Mostrar contenedor y renderizar cuando el SDK esté listo
  let paypalRendered = false;
  function togglePaypalVisibility() {
    paypalWrapper.style.display = '';     // siempre visible
    waitForPaypalReady(renderPaypal);     // render cuando el SDK esté listo
  }

  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
               form.querySelector('input[name="_token"]')?.value;

  function renderPaypal() {
    if (paypalRendered) return;
    if (!window.paypal || typeof window.paypal.Buttons !== 'function') return;

    paypalRendered = true;
    paypal.Buttons({
      style: { layout: 'horizontal', label: 'donate', shape: 'pill' },

      createOrder: async () => {
        showError('');
        if (!validAmount()) throw new Error('Monto inválido');
        showLoading(true);

        const payload = {
          amount: form.amount.value,
          donor_name: form.donor_name.value,
          donor_email: form.donor_email.value || null,
          project_id: form.project_id ? (form.project_id.value || null) : null,
          notes: form.notes.value || null,
          currency: form.currency.value
        };

        const res = await fetch('{{ $paypalCreateUrl }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json'
          },
          body: JSON.stringify(payload)
        });

        showLoading(false);

        if (!res.ok) {
          let msg = 'No se pudo iniciar la orden con PayPal.';
          try {
            const err = await res.json();
            if (err.errors) msg += ' ' + Object.values(err.errors).flat().join(' ');
            else if (err.message) msg += ' ' + err.message;
          } catch (_) {}
          showError(msg);
          throw new Error('paypal_create_error');
        }

        const data = await res.json();
        form.dataset.donationId = data.donation_id;
        return data.id; // orderID
      },

      onApprove: async (data) => {
        showError('');
        showLoading(true);

        const res = await fetch('{{ $paypalCaptureUrl }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            orderID: data.orderID,
            donation_id: form.dataset.donationId || null
          })
        });

        showLoading(false);

        if (!res.ok) {
          let msg = 'No se pudo capturar el pago en PayPal.';
          try {
            const err = await res.json();
            if (err.message) msg += ' ' + err.message;
          } catch (_) {}
          showError(msg);
          return;
        }

        await res.json();
        showOk();
        form.reset();
        paypalRendered = false; // permite donar de nuevo sin recargar
        togglePaypalVisibility();
      },

      onError: (err) => {
        showError('Ocurrió un error con PayPal. Inténtalo nuevamente.');
        console.error(err);
      }
    }).render('#paypal-button-container');
  }

  // Inicial: mostrar y renderizar
  togglePaypalVisibility();
});
</script>


  </main>
  <x-footer />
  
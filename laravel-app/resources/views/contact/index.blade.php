<x-head>
  <link rel="stylesheet" href="assets/css/donadores.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</x-head>

<body class="index-page d-flex flex-column min-vh-100">
<x-header />
<main class="main flex-grow-1">

<!-- Hero Section -->
<section id="hero" class="hero section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row align-items-center">
      <div class="col-lg-12 text-center">
        <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
          <span class="subtitle">Estamos aquí para ayudarte</span>
          <h1>Contáctanos</h1>
          <p>¿Tienes alguna pregunta, sugerencia o necesitas más información sobre nuestros programas? No dudes en contactarnos.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Formulario de Contacto -->
<section id="contact-form" class="contact-form section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row">
      <div class="col-lg-8 mx-auto">
        <div class="card shadow-lg">
          <div class="card-body p-5">
            <div class="text-center mb-4">
              <h2>Envíanos un Mensaje</h2>
              <p class="text-muted">Completa el formulario y nos pondremos en contacto contigo lo antes posible.</p>
            </div>

            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST" class="needs-validation" novalidate>
              @csrf
              
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="name" class="form-label">
                    <i class="bi bi-person me-1"></i> Nombre Completo *
                  </label>
                  <input type="text" 
                         class="form-control @error('name') is-invalid @enderror" 
                         id="name" 
                         name="name" 
                         value="{{ old('name') }}" 
                         required>
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label for="email" class="form-label">
                    <i class="bi bi-envelope me-1"></i> Correo Electrónico *
                  </label>
                  <input type="email" 
                         class="form-control @error('email') is-invalid @enderror" 
                         id="email" 
                         name="email" 
                         value="{{ old('email') }}" 
                         required>
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label for="phone" class="form-label">
                    <i class="bi bi-telephone me-1"></i> Teléfono
                  </label>
                  <input type="tel" 
                         class="form-control @error('phone') is-invalid @enderror" 
                         id="phone" 
                         name="phone" 
                         value="{{ old('phone') }}">
                  @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label for="subject" class="form-label">
                    <i class="bi bi-tag me-1"></i> Asunto *
                  </label>
                  <select class="form-select @error('subject') is-invalid @enderror" 
                          id="subject" 
                          name="subject" 
                          required>
                    <option value="">Selecciona un asunto</option>
                    <option value="Información general" {{ old('subject') == 'Información general' ? 'selected' : '' }}>Información general</option>
                    <option value="Voluntariado" {{ old('subject') == 'Voluntariado' ? 'selected' : '' }}>Voluntariado</option>
                    <option value="Donaciones" {{ old('subject') == 'Donaciones' ? 'selected' : '' }}>Donaciones</option>
                    <option value="Proyectos" {{ old('subject') == 'Proyectos' ? 'selected' : '' }}>Proyectos</option>
                    <option value="Productos" {{ old('subject') == 'Productos' ? 'selected' : '' }}>Productos</option>
                    <option value="Otro" {{ old('subject') == 'Otro' ? 'selected' : '' }}>Otro</option>
                  </select>
                  @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-12">
                  <label for="message" class="form-label">
                    <i class="bi bi-chat-dots me-1"></i> Mensaje *
                  </label>
                  <textarea class="form-control @error('message') is-invalid @enderror" 
                            id="message" 
                            name="message" 
                            rows="6" 
                            placeholder="Escribe tu mensaje aquí..." 
                            required>{{ old('message') }}</textarea>
                  <div class="form-text">Máximo 2000 caracteres</div>
                  @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-12">
                  <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           id="privacy" 
                           required>
                    <label class="form-check-label" for="privacy">
                      Acepto que mis datos sean utilizados para responder a mi consulta según la 
                      <a href="#" class="text-primary">política de privacidad</a> *
                    </label>
                  </div>
                </div>

                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-primary btn-lg px-5">
                    <i class="bi bi-send me-2"></i> Enviar Mensaje
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



</main>

<style>
.contact-form {
  padding: 80px 0;
}

.contact-form .card {
  border: none;
  border-radius: 15px;
}

.contact-form .form-label {
  font-weight: 600;
  color: #333;
  margin-bottom: 8px;
}

.contact-form .form-control,
.contact-form .form-select {
  border: 2px solid #e9ecef;
  border-radius: 10px;
  padding: 12px 15px;
  transition: all 0.3s ease;
}

.contact-form .form-control:focus,
.contact-form .form-select:focus {
  border-color: #007bff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.contact-form .btn-primary {
  background: linear-gradient(135deg, #007bff, #0056b3);
  border: none;
  border-radius: 10px;
  padding: 12px 30px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.contact-form .btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
}

.contact-info {
  padding: 80px 0;
}

.contact-item {
  padding: 30px 20px;
  background: #fff;
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
  transition: transform 0.3s ease;
  height: 100%;
}

.contact-item:hover {
  transform: translateY(-5px);
}

.contact-icon {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, #007bff, #0056b3);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
  color: #fff;
  font-size: 2rem;
}

.contact-item h4 {
  color: #333;
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 15px;
}

.contact-item p {
  color: #666;
  font-size: 1.1rem;
  margin-bottom: 20px;
}

.contact-item .btn {
  border-radius: 25px;
  padding: 8px 20px;
  font-weight: 500;
}

@media (max-width: 768px) {
  .contact-form {
    padding: 40px 0;
  }
  
  .contact-form .card-body {
    padding: 30px 20px;
  }
  
  .contact-info {
    padding: 40px 0;
  }
}
</style>

<x-footer />

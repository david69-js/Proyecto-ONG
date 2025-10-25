@php
  $paypalClientId = config('services.paypal.client_id', env('PAYPAL_CLIENT_ID'));
  $paypalCurrency = config('services.paypal.currency', env('PAYPAL_CURRENCY', 'USD'));
@endphp

<!-- SDK de PayPal -->
<script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency={{ $paypalCurrency }}&intent=capture"></script>

<!-- Sección de Llamado a la Acción / Donaciones -->
<section id="call-to-action" class="call-to-action section light-background">

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row g-5 align-items-center">

      <!-- Lado izquierdo -->
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

      <!-- Lado derecho: Formulario + PayPal -->
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

                <!-- Monto y Moneda -->
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="number" min="1" step="0.01" name="amount" class="form-control" placeholder="Monto ({{ $paypalCurrency }})" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <select name="currency" class="form-control" required>
                      <option value="{{ $paypalCurrency }}" selected>{{ $paypalCurrency }}</option>
                      {{-- Si deseas permitir otras monedas habilitadas en tu cuenta, agrégalas aquí --}}
                    </select>
                  </div>
                </div>

                <!-- Proyecto (opcional) -->
                @isset($projects)
                  <div class="col-12">
                    <div class="form-group">
                      <select name="project_id" class="form-control">
                        <option value="">Apoyar a la ONG (sin proyecto específico)</option>
                        @foreach($projects as $p)
                          <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                @endisset

                <div class="col-12">
                  <div class="form-group">
                    <textarea name="notes" class="form-control" rows="3" placeholder="Mensaje / Comentarios (opcional)"></textarea>
                  </div>
                </div>
              </div>

              <div class="loading" style="display:none">Cargando…</div>
              <div class="error-message" style="display:none"></div>
              <div class="sent-message" style="display:none">¡Gracias! Tu donación fue procesada.</div>

              <!-- Contenedor del botón PayPal -->
              <div id="paypal-button-container" class="mt-3"></div>

              <div class="mt-3 contact-alternative">
                <span>O contáctanos directamente:</span>
                <a href="tel:+50235957273" class="phone-link">
                  <i class="bi bi-telephone-fill"></i>
                  +502 3595-7272
                </a>
              </div>
            </form>
          </div>

          <div class="trust-indicators" data-aos="fade-up" data-aos-delay="400">
            <div class="row g-3">
              <div class="col-4">
                <div class="trust-item">
                  <div class="trust-icon"><i class="bi bi-clock"></i></div>
                  <div class="trust-content">
                    <span class="trust-number">24h</span>
                    <span class="trust-label">Tiempo de Respuesta</span>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="trust-item">
                  <div class="trust-icon"><i class="bi bi-people-fill"></i></div>
                  <div class="trust-content">
                    <span class="trust-number">500+</span>
                    <span class="trust-label">Familias Apoyadas</span>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="trust-item">
                  <div class="trust-icon"><i class="bi bi-house-fill"></i></div>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('donation-form');
  const loadingEl = form.querySelector('.loading');
  const errorEl = form.querySelector('.error-message');
  const okEl = form.querySelector('.sent-message');

  function showLoading(show) { loadingEl.style.display = show ? '' : 'none'; }
  function showError(msg) { errorEl.textContent = msg; errorEl.style.display = msg ? '' : 'none'; }
  function showOk() { okEl.style.display = ''; }

  // CSRF token
  const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                form.querySelector('input[name="_token"]')?.value;

  paypal.Buttons({
    style: { layout: 'horizontal', label: 'donate', shape: 'pill' },

    createOrder: async () => {
      showError(''); showLoading(true);

      const payload = {
        amount: form.amount.value,
        donor_name: form.donor_name.value,
        donor_email: form.donor_email.value || null,
        project_id: form.project_id ? form.project_id.value || null : null,
        notes: form.notes.value || null,
        currency: form.currency.value
      };

      const res = await fetch('{{ route('donations.paypal.create') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token,
          'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
      });

      showLoading(false);

      if (!res.ok) {
        const err = await res.json().catch(() => ({}));
        showError('No se pudo iniciar la orden con PayPal.');
        throw new Error(err.error || 'paypal_create_error');
      }

      const data = await res.json();
      // Puedes guardar data.donation_id en dataset si lo quieres usar luego
      form.dataset.donationId = data.donation_id;
      return data.id; // orderID
    },

    onApprove: async (data) => {
      showError(''); showLoading(true);

      const res = await fetch('{{ route('donations.paypal.capture') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token,
          'Accept': 'application/json'
        },
        body: JSON.stringify({
          orderID: data.orderID,
          donation_id: form.dataset.donationId || null
        })
      });

      showLoading(false);

      if (!res.ok) {
        const err = await res.json().catch(() => ({}));
        showError('No se pudo capturar el pago en PayPal.');
        return;
      }

      const capture = await res.json();
      // Aquí podrías redirigir a una página de gracias o mostrar mensaje
      showOk();
      form.reset();
    },

    onError: (err) => {
      showError('Ocurrió un error con PayPal. Inténtalo nuevamente.');
      console.error(err);
    }
  }).render('#paypal-button-container');
});
</script>

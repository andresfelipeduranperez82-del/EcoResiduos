<?php if (in_array(($layout ?? ''), ['ciudadano', 'admin'])): ?>
      </div>
    </section>
  <?php endif; ?>
  </main>

  <!-- Modal de Login Administrativo -->
  <div class="modal-backdrop" id="admin-modal" <?= isset($_SESSION['login_error']) ? '' : 'hidden' ?>>
    <section class="login-modal" role="dialog" aria-modal="true" aria-labelledby="login-title">
      <button class="modal-close" type="button" onclick="document.getElementById('admin-modal').hidden = true" aria-label="Cerrar">×</button>
      <img class="login-logo" src="<?= BASE_URL ?>Public/assets/logo-emblema.png" alt="" width="66" height="64">
      <div class="eyebrow">ACCESO RESTRINGIDO</div>
      <h2 id="login-title">Hola de nuevo.</h2>
      <p>Ingresa tus credenciales para gestionar la plataforma.</p>
      
      <form action="<?= BASE_URL ?>Auth/login" method="POST">
        <label class="field-label" for="admin-user">Usuario</label>
        <input class="text-input" id="admin-user" name="usuario" autocomplete="username" placeholder="Usuario administrador" required>
        <label class="field-label" for="admin-password">Contraseña</label>
        <input class="text-input" id="admin-password" name="password" type="password" autocomplete="current-password" placeholder="••••••••" required>
        
        <?php if (isset($_SESSION['login_error'])): ?>
          <p class="login-error" role="alert"><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
        <?php endif; ?>
        
        <button class="button button-primary submit-button" type="submit">Iniciar sesión <span>→</span></button>
      </form>
      <div class="demo-hint">DEMO · Usuario: <strong>admin</strong> &nbsp; Contraseña: <strong>eco2026</strong></div>
    </section>
  </div>

  <?php if (isset($_SESSION['toast'])): ?>
    <div class="toast is-visible"><?= $_SESSION['toast']; unset($_SESSION['toast']); ?></div>
  <?php endif; ?>

  <footer class="site-footer">
    <span class="footer-brand">
      <img class="footer-logo" src="<?= BASE_URL ?>Public/assets/logo-texto.png" alt="EcoResiduos" width="136" height="20">
      <span class="footer-copyright">© 2026 · Una iniciativa ciudadana</span>
    </span>
    <span>HECHO CON <span class="footer-heart">♥</span> POR NUESTRA CIUDAD</span>
  </footer>

  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
  <script>const BASE_URL = "<?= BASE_URL ?>";</script>
  <script src="<?= BASE_URL ?>Public/js/app.js"></script>

  <script>
    (function () {
      const html = document.documentElement;
      const toggleBtn = document.getElementById('theme-toggle');
      const savedTheme = localStorage.getItem('ecoresiduos_theme');

      if (savedTheme === 'dark') {
        html.setAttribute('data-theme', 'dark');
        if (toggleBtn) toggleBtn.textContent = '☀ Claro';
      }

      if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
          const isDark = html.getAttribute('data-theme') === 'dark';
          if (isDark) {
            html.removeAttribute('data-theme');
            localStorage.setItem('ecoresiduos_theme', 'light');
            toggleBtn.textContent = '☾ Oscuro';
          } else {
            html.setAttribute('data-theme', 'dark');
            localStorage.setItem('ecoresiduos_theme', 'dark');
            toggleBtn.textContent = '☀ Claro';
          }
        });
      }
    })();
  </script>
  <!-- Asistente ciudadano EcoResiduos -->
  <button class="ecobot-toggle" id="ecobot-toggle" type="button" aria-label="Abrir asistente de ayuda">
    <span aria-hidden="true">💬</span>
    <span class="ecobot-label">Ayuda</span>
  </button>

  <aside class="ecobot-panel" id="ecobot-panel" hidden aria-label="Asistente virtual EcoResiduos">
    <div class="ecobot-header">
      <div>
        <strong>Asistente EcoResiduos</strong>
        <small>Guía rápida ciudadana</small>
      </div>
      <button class="ecobot-close" id="ecobot-close" type="button" aria-label="Cerrar asistente">×</button>
    </div>

    <div class="ecobot-messages" id="ecobot-messages">
      <div class="ecobot-msg bot">
        ¡Hola! Soy el asistente de <strong>EcoResiduos</strong>. Pregúntame cómo reportar puntos críticos, leer el mapa de Barrancabermeja o enviar una PQR.
      </div>
    </div>

    <div class="ecobot-chips" id="ecobot-chips">
      <button class="ecobot-chip" type="button" data-q="¿Cómo hago un reporte?">¿Cómo reportar?</button>
      <button class="ecobot-chip" type="button" data-q="¿Qué fotos puedo subir?">Fotos permitidas</button>
      <button class="ecobot-chip" type="button" data-q="¿Qué significan los colores del mapa?">Colores del mapa</button>
      <button class="ecobot-chip" type="button" data-q="¿Cómo contacto soporte o PQR?">Soporte / PQR</button>
    </div>

    <form class="ecobot-form" id="ecobot-form">
      <input type="text" id="ecobot-input" placeholder="Escribe tu duda..." autocomplete="off" required>
      <button type="submit">Enviar</button>
    </form>
  </aside>

  <script>
    (function () {
      const toggle = document.getElementById('ecobot-toggle');
      const panel = document.getElementById('ecobot-panel');
      const closeBtn = document.getElementById('ecobot-close');
      const form = document.getElementById('ecobot-form');
      const input = document.getElementById('ecobot-input');
      const messages = document.getElementById('ecobot-messages');
      const chips = document.getElementById('ecobot-chips');

      const respuestas = [
        {
          claves: ['report', 'denunci', 'basura', 'residuo', 'punto'],
          texto: 'Pulsa <strong>"Quiero participar"</strong>, describe la situación (mínimo 10 caracteres), elige el tamaño y la ubicación en Barrancabermeja, y presiona enviar.'
        },
        {
          claves: ['foto', 'imagen', 'archivo', 'subir', 'peso', 'mb'],
          texto: 'La fotografía es opcional. Se aceptan imágenes en formato <strong>JPG, PNG o WEBP</strong> con un peso máximo de <strong>5 MB</strong>.'
        },
        {
          claves: ['mapa', 'color', 'rojo', 'verde', 'amarillo', 'zona'],
          texto: 'En el <strong>Mapa ambiental</strong>: <strong>Rojo</strong> marca una zona crítica prioritaria, <strong>Verde</strong> una zona limpia o recuperada, y <strong>Amarillo</strong> los reportes ciudadanos activos.'
        },
        {
          claves: ['pqr', 'soporte', 'queja', 'contacto', 'ayuda'],
          texto: 'En el botón <strong>"Soporte"</strong> de la barra superior puedes revisar preguntas frecuentes o radicar una solicitud PQR formal.'
        },
        {
          claves: ['recicla', 'separa', 'aprende', 'educa'],
          texto: 'Entra a la pestaña <strong>Aprender</strong> dentro del panel ciudadano para consultar guías prácticas de separación en la fuente y reducción de residuos.'
        },
        {
          claves: ['admin', 'administrador', 'clave', 'iniciar', 'sesion'],
          texto: 'El acceso administrativo es exclusivo para personal autorizado desde el botón <strong>"Soy administrador"</strong> en la portada.'
        }
      ];

      function agregarMensaje(texto, tipo) {
        const div = document.createElement('div');
        div.className = 'ecobot-msg ' + tipo;
        div.innerHTML = texto;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
      }

      function responder(pregunta) {
        const normalizada = pregunta.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        const match = respuestas.find(r => r.claves.some(c => normalizada.includes(c)));
        const salida = match
          ? match.texto
          : 'No tengo ese dato exacto todavía, pero puedes usar los botones rápidos de abajo o escribirnos desde la sección <strong>Soporte</strong>.';
        setTimeout(() => agregarMensaje(salida, 'bot'), 220);
      }

      if (toggle && panel) {
        toggle.addEventListener('click', () => {
          panel.hidden = !panel.hidden;
          if (!panel.hidden) input.focus();
        });
      }

      if (closeBtn) {
        closeBtn.addEventListener('click', () => { panel.hidden = true; });
      }

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && panel && !panel.hidden) {
          panel.hidden = true;
        }
      });

      if (chips) {
        chips.addEventListener('click', (e) => {
          const btn = e.target.closest('.ecobot-chip');
          if (!btn) return;
          const q = btn.dataset.q;
          agregarMensaje(q, 'user');
          responder(q);
        });
      }

      if (form) {
        form.addEventListener('submit', (e) => {
          e.preventDefault();
          const q = input.value.trim();
          if (!q) return;
          agregarMensaje(q, 'user');
          input.value = '';
          responder(q);
        });
      }
    })();
  </script>
  <script>
    (function () {
      const inputFoto = document.getElementById('report-image');
      const preview = document.getElementById('image-preview');
      const titulo = document.getElementById('upload-title');
      const descripcion = document.getElementById('upload-description');

      if (!inputFoto || !preview) return;

      const LIMITE_BYTES = 5 * 1024 * 1024; // 5 MB
      const TIPOS_PERMITIDOS = ['image/jpeg', 'image/png', 'image/webp'];
      const tituloOriginal = titulo ? titulo.textContent : 'Adjunta una imagen';
      const descOriginal = descripcion ? descripcion.textContent : 'JPG, JPEG, PNG o WEBP · Máx. 5 MB';
      let urlActual = null;

      function resetearFoto() {
        inputFoto.value = '';
        if (urlActual) {
          URL.revokeObjectURL(urlActual);
          urlActual = null;
        }
        preview.removeAttribute('src');
        preview.hidden = true;
        if (titulo) titulo.textContent = tituloOriginal;
        if (descripcion) descripcion.textContent = descOriginal;
      }

      inputFoto.addEventListener('change', function () {
        const archivo = inputFoto.files[0];
        if (!archivo) {
          resetearFoto();
          return;
        }

         if (!TIPOS_PERMITIDOS.includes(archivo.type)) {
          alert('Formato no permitido. Selecciona una imagen JPG, PNG o WEBP.');
          resetearFoto();
          return;
        }

         if (archivo.size > LIMITE_BYTES) {
          const pesoMB = (archivo.size / (1024 * 1024)).toFixed(1);
          alert('La imagen pesa ' + pesoMB + ' MB y supera el límite máximo de 5 MB.');
          resetearFoto();
          return;
        }

         if (urlActual) URL.revokeObjectURL(urlActual);
        urlActual = URL.createObjectURL(archivo);
        preview.src = urlActual;
        preview.hidden = false;

        const pesoFinal = (archivo.size / (1024 * 1024)).toFixed(2);
        if (titulo) titulo.textContent = archivo.name;
        if (descripcion) descripcion.textContent = 'Listo para enviar · ' + pesoFinal + ' MB';
      });
    })();
  </script>
  <script>
    (function () {
      const inputFoto = document.getElementById('report-image');
      const preview = document.getElementById('image-preview');
      const titulo = document.getElementById('upload-title');
      const descripcion = document.getElementById('upload-description');
      const btnQuitar = document.getElementById('btn-remove-image');

      if (!inputFoto || !preview) return;

      const LIMITE_BYTES = 5 * 1024 * 1024; // 5 MB
      const TIPOS_PERMITIDOS = ['image/jpeg', 'image/png', 'image/webp'];
      const tituloOriginal = titulo ? titulo.textContent : 'Adjunta una imagen';
      const descOriginal = descripcion ? descripcion.textContent : 'JPG, JPEG, PNG o WEBP · Máx. 5 MB';
      let urlActual = null;

      function resetearFoto() {
        inputFoto.value = '';
        if (urlActual) {
          URL.revokeObjectURL(urlActual);
          urlActual = null;
        }
        preview.removeAttribute('src');
        preview.hidden = true;
        if (btnQuitar) btnQuitar.hidden = true;
        if (titulo) titulo.textContent = tituloOriginal;
        if (descripcion) descripcion.textContent = descOriginal;
      }

      inputFoto.addEventListener('change', function () {
        const archivo = inputFoto.files[0];
        if (!archivo) {
          resetearFoto();
          return;
        }

        if (!TIPOS_PERMITIDOS.includes(archivo.type)) {
          alert('Formato no permitido. Selecciona una imagen JPG, PNG o WEBP.');
          resetearFoto();
          return;
        }

        if (archivo.size > LIMITE_BYTES) {
          const pesoMB = (archivo.size / (1024 * 1024)).toFixed(1);
          alert('La imagen pesa ' + pesoMB + ' MB y supera el límite máximo de 5 MB.');
          resetearFoto();
          return;
        }

        if (urlActual) URL.revokeObjectURL(urlActual);
        urlActual = URL.createObjectURL(archivo);
        preview.src = urlActual;
        preview.hidden = false;
        if (btnQuitar) btnQuitar.hidden = false;

        const pesoFinal = (archivo.size / (1024 * 1024)).toFixed(2);
        if (titulo) titulo.textContent = archivo.name;
        if (descripcion) descripcion.textContent = 'Listo para enviar · ' + pesoFinal + ' MB';
      });

      if (btnQuitar) {
        btnQuitar.addEventListener('click', function () {
          resetearFoto();
        });
      }
    })();
    </script>
    <script>
    (function () {
      const contenedor = document.getElementById('city-map');
      if (!contenedor || typeof L === 'undefined') return;

      // 1. Inicializar mapa centrado en Barrancabermeja
      const mapa = L.map('city-map').setView([7.0653, -73.8547], 13);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
      }).addTo(mapa);

      // 2. Dibujar los puntos enviados desde PHP (window.MAPA_PUNTOS)
      const puntos = Array.isArray(window.MAPA_PUNTOS) ? window.MAPA_PUNTOS : [];
      const marcadores = [];

      puntos.forEach(function (p) {
        if (!p.lat || !p.lng) return;

        const esRecuperada = p.categoria === 'recuperada';
        const color = esRecuperada ? '#1f8f2e' : '#eab308';

        const marcador = L.circleMarker([p.lat, p.lng], {
          radius: 9,
          fillColor: color,
          color: '#ffffff',
          weight: 2,
          opacity: 1,
          fillOpacity: 0.92
        }).addTo(mapa);

        const estadoTexto = esRecuperada ? 'Atendido / Recuperado' : 'Reportado (Pendiente)';
        marcador.bindPopup(
          '<div style="min-width:180px;">' +
            '<strong style="display:block;margin-bottom:4px;">' + (p.titulo || 'Punto reportado') + '</strong>' +
            '<span style="font-size:11px;font-weight:700;color:' + color + ';">● ' + estadoTexto + '</span>' +
            '<p style="margin:6px 0 0;font-size:12px;">' + (p.detalle || '') + '</p>' +
          '</div>'
        );

        marcadores.push(marcador);
      });

      // 3. Ajustar encuadre si hay reportes registrados
      if (marcadores.length > 0) {
        const grupo = L.featureGroup(marcadores);
        mapa.fitBounds(grupo.getBounds().pad(0.25), { maxZoom: 15 });
      }

      setTimeout(function () { mapa.invalidateSize(); }, 150);
    })();
  </script>
</body>
</html>
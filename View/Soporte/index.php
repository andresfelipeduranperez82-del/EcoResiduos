<section class="view support-view" aria-labelledby="support-title">
  <div class="support-content">
    <div class="page-heading">
      <div>
        <div class="eyebrow">CENTRO DE AYUDA</div>
        <h2 id="support-title" tabindex="-1">Soporte técnico</h2>
        <p>Encuentra una solución rápida o comunícate con nuestro equipo.</p>
      </div>
      <span class="heading-icon" aria-hidden="true">?</span>
    </div>

    <section class="support-contact card" aria-labelledby="contact-title">
      <div>
        <div class="section-kicker">ATENCIÓN DIRECTA</div>
        <h3 id="contact-title">¿Necesitas ayuda con EcoResiduos?</h3>
        <p>Escríbenos por WhatsApp e incluye una breve descripción del problema.</p>
      </div>
      <a class="button button-primary support-contact-button" href="https://wa.me/573234568194?text=Hola%2C%20necesito%20soporte%20t%C3%A9cnico%20para%20EcoResiduos" target="_blank" rel="noopener noreferrer" aria-label="Abrir WhatsApp para escribir al soporte técnico, número 323 456 8194">
        Contactar por WhatsApp <span aria-hidden="true">↗</span>
      </a>
      <span class="support-phone">323 456 8194</span>
    </section>

    <section class="pqr-card card" aria-labelledby="pqr-title">
      <div class="section-kicker">PETICIONES · QUEJAS · RECLAMOS</div>
      <h3 id="pqr-title">Envíanos una PQR</h3>
      <p class="pqr-intro">Cuéntanos cómo podemos ayudarte. Los campos marcados son obligatorios.</p>
      
      <form id="pqr-form">
        <label class="field-label" for="pqr-type">Tipo de solicitud <span aria-hidden="true">*</span></label>
        <select class="text-input" id="pqr-type" name="type" required>
          <option value="">Selecciona el tipo de PQR</option>
          <option>Petición</option>
          <option>Queja</option>
          <option>Reclamo</option>
        </select>

        <div class="pqr-form-row">
          <div>
            <label class="field-label" for="pqr-name">Nombre <span class="optional-label">OPCIONAL</span></label>
            <input class="text-input" id="pqr-name" name="name" autocomplete="name" maxlength="80" placeholder="Tu nombre">
          </div>
          <div>
            <label class="field-label" for="pqr-contact">Correo o teléfono <span class="optional-label">OPCIONAL</span></label>
            <input class="text-input" id="pqr-contact" name="contact" maxlength="120" placeholder="¿Cómo podemos responderte?">
          </div>
        </div>

        <label class="field-label" for="pqr-message">Describe tu solicitud <span aria-hidden="true">*</span></label>
        <textarea class="text-input textarea pqr-message" id="pqr-message" name="message" minlength="10" maxlength="1000" placeholder="Incluye los detalles necesarios para entender tu caso." aria-describedby="pqr-privacy" required></textarea>
        <p class="pqr-privacy" id="pqr-privacy">Se preparará un mensaje directo en WhatsApp; revísalo y pulsa Enviar allí. Comparte solo la información necesaria.</p>
        <button class="button button-primary pqr-submit" type="submit">Preparar mensaje de PQR <span aria-hidden="true">→</span></button>
        <div class="pqr-result" id="pqr-result" role="status" aria-live="polite" tabindex="-1" hidden></div>
      </form>
    </section>

    <section class="support-faq" aria-labelledby="faq-title">
      <h3 id="faq-title">Soluciones rápidas</h3>
      <details class="support-question">
        <summary>El mapa no carga o aparece vacío</summary>
        <p>Verifica que tengas conexión a internet y vuelve a cargar la página. El mapa y sus mosaicos dependen de servicios externos.</p>
      </details>
      <details class="support-question">
        <summary>¿Dónde se guardan mis reportes?</summary>
        <p>Todos los reportes enviados se almacenan en la base de datos de EcoResiduos y aparecen de inmediato en el panel comunitario y en el mapa ambiental de Barrancabermeja.</p>
      </details>
      <details class="support-question">
        <summary>No puedo adjuntar una fotografía</summary>
        <p>Selecciona un archivo de imagen JPG, JPEG, PNG o WEBP de hasta 5 MB. Si sigue fallando, intenta con una imagen más pequeña o vuelve a cargar la página.</p>
      </details>
    </section>

    <aside class="usability-note" aria-labelledby="usability-title">
      <div class="section-kicker">REFERENCIA DE USABILIDAD</div>
      <h3 id="usability-title">Diseño orientado a ISO 9241-11:2018</h3>
      <p>La interfaz organiza tareas y ayuda según el contexto de uso, con el objetivo de facilitar que las personas alcancen sus objetivos con eficacia, eficiencia y satisfacción. Esta referencia no constituye una certificación ni sustituye una evaluación con personas usuarias.</p>
      <a href="https://www.iso.org/standard/63500.html" target="_blank" rel="noopener noreferrer">Consultar información oficial de ISO 9241-11:2018 <span aria-hidden="true">↗</span></a>
    </aside>

    <a class="text-button support-back" href="<?= BASE_URL ?>">Volver al inicio <span aria-hidden="true">→</span></a>
  </div>
</section>
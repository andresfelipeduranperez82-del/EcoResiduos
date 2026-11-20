<div class="page-heading">
  <div>
    <div class="eyebrow">PARTICIPA POR TU CIUDAD</div>
    <h2>Reporta un punto crítico</h2>
    <p>Marca la ubicación en el mapa, selecciona la zona y describe el residuo.</p>
  </div>
  <span class="heading-icon">↗</span>
</div>

<div class="report-layout">
  <form class="card report-form" action="<?= BASE_URL ?>Reporte/guardar" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
  <input type="hidden" id="latitud" name="latitud" value="7.0653000" required>
  <input type="hidden" id="longitud" name="longitud" value="-73.8547000" required>

  <div class="section-kicker">NUEVO REPORTE <span>01</span></div>

 
   <label class="field-label" for="ubicacion">Ubicación o barrio</label>
  <input class="text-input" type="text" id="ubicacion" name="ubicacion" required>

 <button type="button" id="btn-gps" class="button button-quiet button-small" style="margin-top: 10px;">
  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    <circle cx="12" cy="12" r="3"></circle>
    <path d="M12 2v3m0 14v3M2 12h3m14 0h3"></path>
    <circle cx="12" cy="12" r="8"></circle>
  </svg>
  <span id="gps-text">Usar mi ubicación actual</span>
</button>
    <div class="section-kicker">NUEVO REPORTE <span>01</span></div>

    <div class="form-row">
      <div class="form-field">
        <label class="field-label" for="id_zona">Zona territorial</label>
        <select class="text-input" id="id_zona" name="id_zona" required>
          <option value="">Selecciona una zona</option>
          <?php foreach ($zonas as $zona): ?>
            <option value="<?= (int) $zona['id_zona'] ?>">
              <?= htmlspecialchars($zona['nombre']) ?> (<?= htmlspecialchars($zona['tipo_zona']) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-field">
        <label class="field-label" for="tamano">Volumen estimado del residuo</label>
        <select class="text-input" id="tamano" name="tamano" required>
          <option value="">Selecciona el volumen</option>
          <option value="pequeno">Pequeño (0.5 m³)</option>
          <option value="mediano">Mediano (2.0 m³)</option>
          <option value="grande">Grande (6.0 m³)</option>
        </select>
      </div>
    </div>

    <label class="field-label">Ubicación exacta en Barrancabermeja <span class="optional-label" id="coords-label">7.0653, -73.8547</span></label>
    <div id="picker-map" style="height: 220px; border-radius: 12px; border: 1.5px solid var(--line); margin-bottom: 8px;"></div>
    <button type="button" id="btn-geolocate" class="button button-quiet button-small">⌖ Usar mi ubicación actual</button>

    <label class="field-label" for="report-description">Descripción de la incidencia</label>
    <textarea class="text-input textarea" id="report-description" name="descripcion" minlength="10" maxlength="500" placeholder="Describe el estado del lugar y el tipo de residuos (mínimo 10 caracteres)..." required></textarea>

    <label class="field-label">Fotografía del lugar <span class="optional-label">OPCIONAL</span></label>
    <label class="upload-box" for="report-image">
      <input id="report-image" name="ruta_foto" type="file" accept="image/jpeg,image/png,image/webp">
      <span class="upload-symbol">↑</span>
      <span><strong id="upload-title">Adjunta una imagen</strong><small id="upload-description">JPG, JPEG, PNG o WEBP · Máximo 5 MB</small></span>
      <img id="image-preview" alt="Vista previa de la fotografía" hidden>
    </label>
<button type="button" id="btn-remove-image" class="button button-quiet button-small" hidden style="margin-top: 8px;">
    × Quitar fotografía
  </button>
    <button class="button button-primary submit-button" type="submit">Enviar reporte <span aria-hidden="true">→</span></button>
    <p class="privacy-note">Tus reportes ayudan a priorizar la recuperación de nuestros espacios.</p>
  </form>

  <aside class="report-aside">
    <div class="card impact-card">
      <div class="impact-icon">♻</div>
      <div class="section-kicker">ASÍ SUMAS</div>
      <h3>Pequeñas acciones,<br>grandes cambios.</h3>
      <p>La información de la comunidad ayuda a identificar dónde actuar primero.</p>
      <div class="impact-stat">
        <strong><?= count($reportes) ?></strong>
        <span>reportes ciudadanos<br>en esta comunidad</span>
      </div>
    </div>

    <div class="my-reports-card">
      <div class="mini-heading">REPORTES DE LA COMUNIDAD <span><?= str_pad(count($reportes), 2, '0', STR_PAD_LEFT) ?></span></div>
      <div class="recent-reports">
        <?php if (empty($reportes)): ?>
          <p class="empty-state">Aún no hay reportes registrados.</p>
        <?php else: ?>
          <?php foreach (array_slice($reportes, 0, 8) as $rep): ?>
            <div class="recent-item">
              <span class="recent-dot"></span>
              <div>
                <strong><?= htmlspecialchars($rep['nombre_zona']) ?> · <?= htmlspecialchars($rep['volumen_texto']) ?></strong>
                <small><?= htmlspecialchars($rep['descripcion']) ?></small>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </aside>
</div>
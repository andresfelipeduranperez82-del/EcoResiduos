<div class="page-heading">
  <div>
    <div class="eyebrow">FORMACIÓN AMBIENTAL</div>
    <h2>Contenidos educativos</h2>
    <p>Publica recomendaciones para la sección "Aprende y actúa".</p>
  </div>
</div>

<div class="zone-admin-layout">
  <form class="card zone-form" action="<?= BASE_URL ?>Admin/guardarContenido" method="POST">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
    <div class="section-kicker">NUEVO ARTÍCULO <span>＋</span></div>

    <label class="field-label" for="edu-titulo">Título</label>
    <input class="text-input" id="edu-titulo" name="titulo" placeholder="Ej. Manejo de aceites usados" maxlength="120" required>

    <label class="field-label" for="edu-categoria">Etiqueta / Categoría</label>
    <input class="text-input" id="edu-categoria" name="categoria" placeholder="Ej. CADA GOTA CUENTA" maxlength="60" required>

    <label class="field-label" for="edu-contenido">Contenido</label>
    <textarea class="text-input textarea" id="edu-contenido" name="contenido" placeholder="Redacta el consejo ambiental..." required></textarea>

    <button class="button button-primary submit-button" type="submit">Publicar artículo <span>→</span></button>
  </form>

  <div class="card zones-card">
    <div class="table-heading">
      <div><strong>Artículos publicados</strong><span>Contenidos registrados en la plataforma</span></div>
      <span class="table-total"><?= count($contenidos) ?> ARTÍCULOS</span>
    </div>
    <div class="admin-zone-list">
      <?php foreach ($contenidos as $c): ?>
        <div class="admin-zone">
          <div class="zone-marker" style="background:var(--green-soft); color:var(--green);">✳</div>
          <div class="zone-copy">
            <strong><?= htmlspecialchars($c['titulo']) ?></strong>
            <small><?= htmlspecialchars($c['categoria']) ?> · Por: <?= htmlspecialchars($c['autor']) ?></small>
          </div>
          <span class="priority low"><?= $c['visible'] ? 'Visible' : 'Oculto' ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
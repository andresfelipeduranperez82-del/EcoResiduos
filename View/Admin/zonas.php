<div class="page-heading">
  <div>
    <div class="eyebrow">DIVISIÓN TERRITORIAL</div>
    <h2>Gestionar zonas autorizadas</h2>
    <p>Administra las comunas, barrios y sectores donde la ciudadanía puede reportar.</p>
  </div>
</div>

<div class="zone-admin-layout">
  <form class="card zone-form" action="<?= BASE_URL ?>Admin/crearZona" method="POST">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
    <div class="section-kicker">AGREGAR ZONA <span>＋</span></div>

    <label class="field-label" for="zone-name">Nombre de la zona</label>
    <input class="text-input" id="zone-name" name="nombre" placeholder="Ej. Comuna 4 - Las Penínsulas" maxlength="100" required>

    <label class="field-label" for="zone-type">Tipo de zona</label>
    <select class="text-input" id="zone-type" name="tipo_zona" required>
      <option value="Comuna">Comuna</option>
      <option value="Barrio">Barrio</option>
      <option value="Corregimiento">Corregimiento</option>
      <option value="Sector Especial">Sector Especial</option>
    </select>

    <button class="button button-primary submit-button" type="submit">Agregar zona <span>→</span></button>
  </form>

  <div class="card zones-card">
    <div class="table-heading">
      <div><strong>Zonas registradas</strong><span>Clasificación geográfica activa</span></div>
      <span class="table-total"><?= count($zonas) ?> ZONAS</span>
    </div>
    <div class="admin-zone-list">
      <?php foreach ($zonas as $z): ?>
        <div class="admin-zone">
          <div class="zone-marker">⌖</div>
          <div class="zone-copy">
            <strong><?= htmlspecialchars($z['nombre']) ?></strong>
            <small><?= htmlspecialchars($z['tipo_zona']) ?></small>
          </div>
          <a class="delete-zone" style="display:grid; place-items:center; text-decoration:none;" href="<?= BASE_URL ?>Admin/eliminarZona/<?= (int) $z['id_zona'] ?>" onclick="return confirm('¿Eliminar esta zona?');" title="Eliminar zona">×</a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
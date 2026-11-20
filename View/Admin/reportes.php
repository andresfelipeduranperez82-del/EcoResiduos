<div class="page-heading">
  <div>
    <div class="eyebrow">GESTIÓN CIUDADANA</div>
    <h2>Reportes recibidos</h2>
    <p>Revisa la información y actualiza el estado de cada reporte.</p>
  </div>
  <a class="button button-outline refresh-button" href="<?= BASE_URL ?>Admin/reportes">↻ Actualizar</a>
</div>

<div class="stats-grid">
  <div class="stat-card"><span>Total recibidos</span><strong><?= (int) ($stats['total'] ?? 0) ?></strong></div>
  <div class="stat-card"><span>Pendientes (Reportado)</span><strong><?= (int) ($stats['reportados'] ?? 0) ?></strong></div>
  <div class="stat-card"><span>Atendidos</span><strong class="stat-accent"><?= (int) ($stats['atendidos'] ?? 0) ?></strong></div>
  <div class="stat-card"><span>Descartados</span><strong><?= (int) ($stats['descartados'] ?? 0) ?></strong></div>
</div>

<div class="card table-card">
  <div class="table-heading">
    <div>
      <strong>Actividad de la comunidad</strong>
      <span>Reportes ambientales enviados por ciudadanos</span>
    </div>
    <span class="table-total"><?= count($reportes) ?> REPORTES</span>
  </div>

  <div class="admin-report-list">
    <?php foreach ($reportes as $rep): ?>
      <div class="admin-report">
        <?php if (!empty($rep['ruta_foto'])): ?>
          <a href="<?= BASE_URL . htmlspecialchars($rep['ruta_foto']) ?>" target="_blank" title="Ver fotografía">
            <img class="report-thumb" src="<?= BASE_URL . htmlspecialchars($rep['ruta_foto']) ?>" alt="Evidencia">
          </a>
        <?php else: ?>
          <div class="report-thumb">⌖</div>
        <?php endif; ?>

        <div class="report-detail">
          <strong><?= htmlspecialchars($rep['nombre_zona']) ?> · <?= htmlspecialchars($rep['volumen_texto']) ?></strong>
          <small><?= htmlspecialchars($rep['descripcion']) ?></small>
          <?php if ($rep['estado'] === 'descartado' && !empty($rep['motivo_descarte'])): ?>
            <small style="color: var(--red);">Motivo descarte: <?= htmlspecialchars($rep['motivo_descarte']) ?></small>
          <?php endif; ?>
        </div>

        <span class="report-type"><?= htmlspecialchars($rep['tipo_zona']) ?></span>
        <span class="report-date"><?= date('d/m/Y', strtotime($rep['fecha'])) ?></span>

        <form action="<?= BASE_URL ?>Admin/cambiarEstadoReporte" method="POST" style="display:flex; flex-direction:column; gap:6px;">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
          <input type="hidden" name="id_reporte" value="<?= (int) $rep['id_reporte'] ?>">
          
          <select class="status-select" name="estado" onchange="this.nextElementSibling.hidden = (this.value !== 'descartado')">
            <option value="reportado"  <?= $rep['estado'] === 'reportado'  ? 'selected' : '' ?>>Reportado</option>
            <option value="atendido"   <?= $rep['estado'] === 'atendido'   ? 'selected' : '' ?>>Atendido</option>
            <option value="descartado" <?= $rep['estado'] === 'descartado' ? 'selected' : '' ?>>Descartado</option>
          </select>

          <input class="text-input" type="text" name="motivo_descarte" placeholder="Motivo del descarte..." style="padding:6px 10px; font-size:12px;" <?= $rep['estado'] === 'descartado' ? '' : 'hidden' ?>>
          <button class="button button-quiet button-small" type="submit">Guardar</button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>
</div>
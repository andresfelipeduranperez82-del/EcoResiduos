<div class="page-heading">
  <div>
    <div class="eyebrow">INFORMACIÓN EN TIEMPO REAL</div>
    <h2>Mapa ambiental</h2>
    <p>Explora los reportes y las zonas atendidas en Barrancabermeja.</p>
  </div>
  <span class="heading-icon">⌖</span>
</div>

<div class="map-toolbar">
  <div class="map-legend">
    <span><i class="legend-dot report"></i> Reportado (Pendiente)</span>
    <span><i class="legend-dot clean"></i> Atendido / Recuperado</span>
  </div>
  <span class="map-location">⌖ Barrancabermeja, Santander</span>
</div>

<div class="map-frame">
  <div id="city-map" role="application" aria-label="Mapa interactivo de Barrancabermeja"></div>
  <div class="map-footnote">Los marcadores representan reportes ciudadanos verificados.</div>
</div>

<div class="map-summary">
  <div class="summary-tile">
    <strong><?= (int) ($stats['total'] ?? 0) ?></strong>
    <span>Total de reportes</span>
  </div>
  <div class="summary-tile">
    <strong><?= (int) ($stats['reportados'] ?? 0) ?></strong>
    <span>Puntos activos por atender</span>
  </div>
  <div class="summary-tile">
    <strong><?= (int) ($stats['atendidos'] ?? 0) ?></strong>
    <span>Espacios recuperados</span>
  </div>
</div>

<script>
  window.MAPA_PUNTOS = <?= json_encode(array_map(function($p) {
      return [
          'lat'       => (float) $p['latitud'],
          'lng'       => (float) $p['longitud'],
          'titulo'    => $p['nombre_zona'],
          'barrio'    => strtoupper($p['estado']),
          'detalle'   => $p['descripcion'],
          'categoria' => ($p['estado'] === 'atendido') ? 'recuperada' : 'reporte'
      ];
  }, $puntos), JSON_UNESCAPED_UNICODE) ?>;
</script>
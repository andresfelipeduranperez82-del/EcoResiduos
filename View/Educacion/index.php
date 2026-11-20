<div class="page-heading">
  <div>
    <div class="eyebrow">CONOCER PARA CUIDAR</div>
    <h2>Aprende y actúa</h2>
    <p>Ideas sencillas para proteger el entorno que compartimos.</p>
  </div>
  <span class="heading-icon">✳</span>
</div>

<div class="learn-intro">
  <span class="learn-sun">✳</span>
  <div>
    <strong>El ambiente también es nuestro hogar.</strong>
    <p>Lo que hacemos con nuestros residuos tiene un impacto directo en los ríos, los barrios y la vida de nuestra ciudad.</p>
  </div>
</div>

<div class="learn-grid">
  <?php
  $estilos = [
      ['clase' => 'green',  'icono' => '♻', 'tag' => ''],
      ['clase' => 'blue',   'icono' => '≈', 'tag' => 'blue-tag'],
      ['clase' => 'yellow', 'icono' => '✦', 'tag' => 'yellow-tag'],
  ];
  $guiasExtra = [
      [
          'Usa bolsa blanca para aprovechables limpios y secos: plástico, cartón, papel, vidrio y metales.',
          'Usa bolsa negra para residuos no aprovechables como servilletas usadas o envolturas con comida.',
          'Usa bolsa verde para restos de alimentos y desechos orgánicos.',
          'Aplasta botellas y cajas antes de sacarlas para reducir volumen en los puntos de acopio.'
      ],
      [
          'Nunca viertas aceite de cocina usado en el lavaplatos; guárdalo en una botella plástica cerrada.',
          'Evita arrojar basura en rejillas, alcantarillas o rondas de caños y ciénagas de Barrancabermeja.',
          'Si ves acumulación de residuos cerca de un cuerpo de agua, repórtalo de inmediato en la plataforma.'
      ],
      [
          'Saca las bolsas únicamente en los días y horarios establecidos por el vehículo recolector de tu comuna.',
          'Documenta con fotografía y ubicación GPS los botaderos satélites para priorizar su atención.',
          'Consulta el Mapa ambiental para verificar qué puntos de tu sector ya fueron recuperados.'
      ]
  ];

  foreach ($articulos as $i => $art):
      $estilo = $estilos[$i % 3];
      $numero = str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) . ' / EDUCA';
      $tips   = $guiasExtra[$i % 3];
  ?>
    <article
      class="card learn-card"
      role="button"
      tabindex="0"
      style="cursor: pointer;"
      data-numero="<?= htmlspecialchars($numero) ?>"
      data-titulo="<?= htmlspecialchars($art['titulo']) ?>"
      data-categoria="<?= htmlspecialchars($art['categoria']) ?>"
      data-contenido="<?= htmlspecialchars($art['contenido']) ?>"
      data-tips="<?= htmlspecialchars(json_encode($tips, JSON_UNESCAPED_UNICODE)) ?>"
    >
      <span class="learn-number"><?= $numero ?></span>
      <div class="learn-illustration <?= $estilo['clase'] ?>"><?= $estilo['icono'] ?></div>
      <h3><?= htmlspecialchars($art['titulo']) ?></h3>
      <p><?= htmlspecialchars($art['contenido']) ?></p>
      <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-top:auto;">
        <span class="learn-tag <?= $estilo['tag'] ?>"><?= htmlspecialchars($art['categoria']) ?></span>
        <small style="font-size:12px;font-weight:600;color:var(--green);">Ver guía →</small>
      </div>
    </article>
  <?php endforeach; ?>
</div>

<div class="learn-callout">
  <span>¿Ves un espacio que necesita atención?</span>
  <a class="text-button" href="<?= BASE_URL ?>Reporte">Haz un reporte <span>→</span></a>
</div>

<div id="edu-modal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.65);backdrop-filter:blur(3px);align-items:center;justify-content:center;padding:16px;z-index:1100;">
  <div id="edu-modal-box" style="background:var(--card, var(--surface, #ffffff));color:var(--ink, #111827);border:1px solid var(--line, #e2e8f0);border-radius:22px;max-width:480px;width:100%;padding:24px;box-shadow:0 20px 50px rgba(0,0,0,.35);">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:10px;">
      <span id="edu-modal-tag" style="font-size:11px;font-weight:700;letter-spacing:.08em;color:var(--green, #15803d);"></span>
      <button type="button" id="edu-modal-close" class="button button-quiet button-small">Cerrar</button>
    </div>
    <h3 id="edu-modal-title" style="margin:0 0 8px;font-size:21px;"></h3>
    <p id="edu-modal-desc" style="margin:0 0 14px;font-size:14px;line-height:1.55;opacity:.85;"></p>
    <strong style="display:block;font-size:12px;letter-spacing:.05em;text-transform:uppercase;margin-bottom:8px;">Acciones prácticas:</strong>
    <ul id="edu-modal-list" style="margin:0 0 20px;padding-left:18px;line-height:1.6;opacity:.9;font-size:14px;"></ul>
    <div style="display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap;">
      <a href="<?= BASE_URL ?>Mapa" class="button button-quiet button-small">Ver mapa ambiental</a>
      <a href="<?= BASE_URL ?>Reporte" class="button button-primary button-small">Reportar un punto crítico →</a>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const tarjetas = document.querySelectorAll('.learn-card[data-titulo]');
    const modal = document.getElementById('edu-modal');
    const modalBox = document.getElementById('edu-modal-box');
    if (!tarjetas.length || !modal || !modalBox) return;

    const elTag = document.getElementById('edu-modal-tag');
    const elTitulo = document.getElementById('edu-modal-title');
    const elDesc = document.getElementById('edu-modal-desc');
    const elLista = document.getElementById('edu-modal-list');
    const btnCerrar = document.getElementById('edu-modal-close');

    function sincronizarTemaModal() {
      const esOscuro = document.documentElement.getAttribute('data-theme') === 'dark' ||
                       document.body.classList.contains('dark') ||
                       document.documentElement.classList.contains('dark');
      modalBox.style.backgroundColor = esOscuro ? '#141f18' : '#ffffff';
      modalBox.style.color = esOscuro ? '#eef4f0' : '#111827';
      modalBox.style.borderColor = esOscuro ? 'rgba(255,255,255,.12)' : '#e2e8f0';
    }

    function abrirGuia(card) {
      sincronizarTemaModal();
      elTag.textContent = card.dataset.numero + ' · ' + card.dataset.categoria;
      elTitulo.textContent = card.dataset.titulo;
      elDesc.textContent = card.dataset.contenido;

      let tips = [];
      try {
        tips = JSON.parse(card.dataset.tips || '[]');
      } catch (e) {
        tips = [];
      }

      elLista.innerHTML = tips.map(function (txt) {
        return '<li style="margin-bottom:6px;">' + txt + '</li>';
      }).join('');

      modal.style.display = 'flex';
    }

    function cerrarGuia() {
      modal.style.display = 'none';
    }

    tarjetas.forEach(function (card) {
      card.addEventListener('click', function () {
        abrirGuia(card);
      });
      card.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          abrirGuia(card);
        }
      });
    });

    btnCerrar.addEventListener('click', cerrarGuia);

    modal.addEventListener('click', function (e) {
      if (e.target === modal) cerrarGuia();
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && modal.style.display === 'flex') cerrarGuia();
    });
  });
</script>
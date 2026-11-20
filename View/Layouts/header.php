<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoResiduos · Barrancabermeja</title>
  <link rel="icon" type="image/png" href="<?= BASE_URL ?>Public/assets/logo-emblema.png">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
  <script>if(localStorage.getItem('ecoresiduos_theme')==='dark')document.documentElement.setAttribute('data-theme','dark');</script>
  <link rel="stylesheet" href="<?= BASE_URL ?>Public/css/estilos.css?v=4">
  <link rel="stylesheet" href="<?= BASE_URL ?>Public/css/soporte.css">
</head>
<body>
  <a class="skip-link" href="#main-content">Saltar al contenido principal</a>
<header class="site-header">
    <a class="brand" href="<?= BASE_URL ?>" aria-label="EcoResiduos, inicio">
      <img class="brand-logo" src="<?= BASE_URL ?>Public/assets/logo-texto.png" alt="EcoResiduos" width="200" height="29">
    </a>
    <div class="header-right">
      <span class="header-location"><span class="location-dot"></span> Barrancabermeja, Santander</span>
      <button class="button button-quiet button-small" id="theme-toggle" type="button" aria-label="Cambiar tema">☾ Oscuro</button>
      <a class="button button-quiet button-small" href="<?= BASE_URL ?>Soporte">Soporte</a>
      <?php if (isset($_SESSION['id_administrador'])): ?>
        <a class="button button-quiet button-small" href="<?= BASE_URL ?>Auth/logout">Salir</a>
      <?php elseif (($layout ?? '') === 'ciudadano'): ?>
        <a class="button button-quiet button-small" href="<?= BASE_URL ?>">Salir</a>
      <?php endif; ?>
    </div>
  </header>

  <main id="main-content" tabindex="-1">
  <?php if (($layout ?? '') === 'ciudadano'): ?>
    <section class="view workspace-view">
      <aside class="sidebar">
        <div class="sidebar-label">ESPACIO CIUDADANO</div>
        <a class="side-link <?= ($tab === 'reporte') ? 'is-selected' : '' ?>" href="<?= BASE_URL ?>Reporte"><span>＋</span> Nuevo reporte</a>
        <a class="side-link <?= ($tab === 'mapa') ? 'is-selected' : '' ?>" href="<?= BASE_URL ?>Mapa"><span>⌖</span> Mapa ambiental</a>
        <a class="side-link <?= ($tab === 'educacion') ? 'is-selected' : '' ?>" href="<?= BASE_URL ?>Educacion"><span>✳</span> Aprende y actúa</a>
        <div class="sidebar-tip"><span>✦</span><strong>Tu voz importa</strong><p>Reportar un punto crítico es el primer paso para recuperarlo.</p></div>
      </aside>
      <div class="workspace-content">

  <?php elseif (($layout ?? '') === 'admin'): ?>
    <section class="view workspace-view admin-workspace">
      <aside class="sidebar">
        <div class="sidebar-label">PANEL DE GESTIÓN</div>
        <a class="side-link <?= ($tab === 'reportes') ? 'is-selected' : '' ?>" href="<?= BASE_URL ?>Admin/reportes"><span>▤</span> Reportes <b><?= $pendientes ?? 0 ?></b></a>
        <a class="side-link <?= ($tab === 'zonas') ? 'is-selected' : '' ?>" href="<?= BASE_URL ?>Admin/zonas"><span>⌖</span> Zonas críticas</a>
        <a class="side-link <?= ($tab === 'educacion') ? 'is-selected' : '' ?>" href="<?= BASE_URL ?>Admin/educacion"><span>✳</span> Educación</a>
        <div class="sidebar-tip admin-tip"><span>◈</span><strong>Panel administrador</strong><p>Modera los reportes y mantén actualizada la información ambiental.</p></div>
      </aside>
      <div class="workspace-content">
  <?php endif; ?>
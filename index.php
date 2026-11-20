<?php
declare(strict_types=1);

// Configuración segura de cookies de sesión
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

require_once 'Config/Config.php';

// Obtener y limpiar la ruta solicitada
$urlRaw = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
$segmentos = $urlRaw !== '' ? explode('/', filter_var($urlRaw, FILTER_SANITIZE_URL)) : [];

// Controlador y método por defecto: IndexController::index()
$controladorSlug = !empty($segmentos[0]) ? preg_replace('/[^a-zA-Z0-9]/', '', $segmentos[0]) : 'Index';
$controllerName  = ucfirst(strtolower($controladorSlug)) . 'Controller';
$methodName      = !empty($segmentos[1]) ? preg_replace('/[^a-zA-Z0-9_]/', '', $segmentos[1]) : 'index';
$params          = array_slice($segmentos, 2);

$controllerFile = 'Controller/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (class_exists($controllerName)) {
        $controller = new $controllerName();

        if (method_exists($controller, $methodName)) {
            call_user_func_array([$controller, $methodName], $params);
            exit;
        }
    }
}

// Respuesta 404 si la ruta no existe
http_response_code(404);
echo "<h1>404 - Página no encontrada</h1><p>La ruta solicitada no existe en EcoResiduos.</p><a href='" . BASE_URL . "'>Volver al inicio</a>";
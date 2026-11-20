<?php
require_once 'Model/ReporteModel.php';
require_once 'Core/Validator.php';

class MapaController {
    public function index() {
        $layout = 'ciudadano';
        $tab = 'mapa';
        $csrf_token = Validator::generarTokenCsrf();

        $reporteModel = new ReporteModel();
        $puntos = $reporteModel->listarParaMapa();
        $stats  = $reporteModel->obtenerEstadisticas();

        require_once 'View/Layouts/header.php';
        require_once 'View/Mapa/index.php';
        require_once 'View/Layouts/footer.php';
    }
}
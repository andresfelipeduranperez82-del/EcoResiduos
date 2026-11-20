<?php
require_once 'Model/ContenidoEducativoModel.php';
require_once 'Core/Validator.php';

class EducacionController {
    public function index() {
        $layout = 'ciudadano';
        $tab = 'educacion';
        $csrf_token = Validator::generarTokenCsrf();

        $contenidoModel = new ContenidoEducativoModel();
        $articulos = $contenidoModel->listarVisibles();

        require_once 'View/Layouts/header.php';
        require_once 'View/Educacion/index.php';
        require_once 'View/Layouts/footer.php';
    }
}
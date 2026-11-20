<?php
require_once 'Core/Validator.php';

class IndexController {
    public function index() {
        $csrf_token = Validator::generarTokenCsrf();
        require_once 'View/Layouts/header.php';
        require_once 'View/Index/index.php';
        require_once 'View/Layouts/footer.php';
    }
}
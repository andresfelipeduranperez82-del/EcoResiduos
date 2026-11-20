<?php
require_once 'Model/AdministradorModel.php';
require_once 'Core/Validator.php';

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL);
            exit;
        }

        $usuario  = $_POST['usuario'] ?? '';
        $password = $_POST['password'] ?? '';

        $adminModel = new AdministradorModel();
        $admin = $adminModel->buscarPorUsuario($usuario);

        if ($admin && password_verify($password, $admin['contrasena_hash'])) {
            session_regenerate_id(true);
            $_SESSION['id_administrador'] = (int) $admin['id_administrador'];
            $_SESSION['admin_usuario']    = $admin['usuario'];
            header('Location: ' . BASE_URL . 'Admin/reportes');
            exit;
        }

        $_SESSION['login_error'] = 'Usuario o contraseña incorrectos.';
        header('Location: ' . BASE_URL);
        exit;
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();
        header('Location: ' . BASE_URL);
        exit;
    }
}
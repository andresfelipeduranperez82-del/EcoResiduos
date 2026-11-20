<?php
require_once 'Model/ReporteModel.php';
require_once 'Model/ZonaModel.php';
require_once 'Model/ContenidoEducativoModel.php';
require_once 'Core/Validator.php';

class AdminController {
    private ReporteModel $reporteModel;
    private ZonaModel $zonaModel;
    private ContenidoEducativoModel $contenidoModel;

    public function __construct() {
        // Filtro de control de sesión administrativa
        if (!isset($_SESSION['id_administrador'])) {
            $_SESSION['login_error'] = 'Debes iniciar sesión como administrador.';
            header('Location: ' . BASE_URL);
            exit;
        }
        $this->reporteModel   = new ReporteModel();
        $this->zonaModel      = new ZonaModel();
        $this->contenidoModel = new ContenidoEducativoModel();
    }

    public function index() {
        $this->reportes();
    }

    public function reportes() {
        $layout     = 'admin';
        $tab        = 'reportes';
        $csrf_token = Validator::generarTokenCsrf();
        $stats      = $this->reporteModel->obtenerEstadisticas();
        $pendientes = (int) ($stats['reportados'] ?? 0);
        $reportes   = $this->reporteModel->listarTodosConZona();

        require_once 'View/Layouts/header.php';
        require_once 'View/Admin/reportes.php';
        require_once 'View/Layouts/footer.php';
    }

    public function cambiarEstadoReporte() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Validator::verificarTokenCsrf($_POST['csrf_token'] ?? null)) {
            header('Location: ' . BASE_URL . 'Admin/reportes');
            exit;
        }

        $idReporte = (int) ($_POST['id_reporte'] ?? 0);
        $estado    = $_POST['estado'] ?? '';
        $motivo    = trim($_POST['motivo_descarte'] ?? '');

        if ($idReporte <= 0 || !Validator::validarEstadoReporte($estado)) {
            $_SESSION['toast'] = 'Estado no válido.';
            header('Location: ' . BASE_URL . 'Admin/reportes');
            exit;
        }

        if ($estado === 'descartado' && mb_strlen($motivo, 'UTF-8') < 5) {
            $_SESSION['toast'] = 'Debes indicar una justificación válida para descartar el reporte.';
            header('Location: ' . BASE_URL . 'Admin/reportes');
            exit;
        }

        if ($this->reporteModel->actualizarEstado($idReporte, $estado, $motivo)) {
            $_SESSION['toast'] = 'Estado del reporte actualizado.';
        } else {
            $_SESSION['toast'] = 'No se pudo actualizar el reporte.';
        }

        header('Location: ' . BASE_URL . 'Admin/reportes');
        exit;
    }

    public function zonas() {
        $layout     = 'admin';
        $tab        = 'zonas';
        $csrf_token = Validator::generarTokenCsrf();
        $stats      = $this->reporteModel->obtenerEstadisticas();
        $pendientes = (int) ($stats['reportados'] ?? 0);
        $zonas      = $this->zonaModel->listarTodas();

        require_once 'View/Layouts/header.php';
        require_once 'View/Admin/zonas.php';
        require_once 'View/Layouts/footer.php';
    }

    public function crearZona() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && Validator::verificarTokenCsrf($_POST['csrf_token'] ?? null)) {
            $nombre   = trim($_POST['nombre'] ?? '');
            $tipoZona = $_POST['tipo_zona'] ?? 'Barrio';
            if ($nombre !== '') {
                $this->zonaModel->crear($nombre, $tipoZona);
                $_SESSION['toast'] = 'Zona territorial agregada.';
            }
        }
        header('Location: ' . BASE_URL . 'Admin/zonas');
        exit;
    }

    public function eliminarZona($id = 0) {
        $idZona = (int) $id;
        if ($idZona > 0) {
            try {
                $this->zonaModel->eliminar($idZona);
                $_SESSION['toast'] = 'Zona eliminada.';
            } catch (PDOException $e) {
                $_SESSION['toast'] = 'No se puede eliminar la zona porque tiene reportes asociados.';
            }
        }
        header('Location: ' . BASE_URL . 'Admin/zonas');
        exit;
    }

    public function educacion() {
        $layout     = 'admin';
        $tab        = 'educacion';
        $csrf_token = Validator::generarTokenCsrf();
        $stats      = $this->reporteModel->obtenerEstadisticas();
        $pendientes = (int) ($stats['reportados'] ?? 0);
        $contenidos = $this->contenidoModel->listarTodos();

        require_once 'View/Layouts/header.php';
        require_once 'View/Admin/educacion.php';
        require_once 'View/Layouts/footer.php';
    }

    public function guardarContenido() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && Validator::verificarTokenCsrf($_POST['csrf_token'] ?? null)) {
            $titulo    = trim($_POST['titulo'] ?? '');
            $categoria = trim($_POST['categoria'] ?? '');
            $contenido = trim($_POST['contenido'] ?? '');
            $idAdmin   = (int) $_SESSION['id_administrador'];

            if ($titulo !== '' && $contenido !== '') {
                $this->contenidoModel->guardar($titulo, $contenido, $categoria, $idAdmin);
                $_SESSION['toast'] = 'Contenido educativo publicado.';
            }
        }
        header('Location: ' . BASE_URL . 'Admin/educacion');
        exit;
    }
}
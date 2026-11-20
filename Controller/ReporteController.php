<?php
require_once 'Model/ReporteModel.php';
require_once 'Model/ZonaModel.php';
require_once 'Entities/Reporte.php';
require_once 'Core/Validator.php';
require_once 'Core/UploadService.php';

class ReporteController {
    private ReporteModel $reporteModel;
    private ZonaModel $zonaModel;

    public function __construct() {
        $this->reporteModel = new ReporteModel();
        $this->zonaModel = new ZonaModel();
    }

    public function index() {
        $layout = 'ciudadano';
        $tab = 'reporte';
        $csrf_token = Validator::generarTokenCsrf();
        $zonas = $this->zonaModel->listarTodas();
        $reportes = $this->reporteModel->listarTodosConZona();

        require_once 'View/Layouts/header.php';
        require_once 'View/Reporte/index.php';
        require_once 'View/Layouts/footer.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'Reporte');
            exit;
        }

        if (!Validator::verificarTokenCsrf($_POST['csrf_token'] ?? null)) {
            $_SESSION['toast'] = 'Sesión de formulario inválida. Intenta nuevamente.';
            header('Location: ' . BASE_URL . 'Reporte');
            exit;
        }

        $latitud     = $_POST['latitud'] ?? '';
        $longitud    = $_POST['longitud'] ?? '';
        $idZona      = (int) ($_POST['id_zona'] ?? 0);
        $tamano      = $_POST['tamano'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';

        if (!Validator::validarCoordenadas($latitud, $longitud)) {
            $_SESSION['toast'] = 'Selecciona una ubicación válida en el mapa de Barrancabermeja.';
            header('Location: ' . BASE_URL . 'Reporte');
            exit;
        }

        if ($idZona <= 0 || !Validator::validarTamano($tamano) || !Validator::validarDescripcion($descripcion, 10)) {
            $_SESSION['toast'] = 'Verifica la zona, el volumen y que la descripción tenga al menos 10 caracteres.';
            header('Location: ' . BASE_URL . 'Reporte');
            exit;
        }

        $resultadoFoto = ['ok' => true, 'ruta' => null];
        if (isset($_FILES['ruta_foto'])) {
            $resultadoFoto = UploadService::guardarFotografia($_FILES['ruta_foto']);
            if (!$resultadoFoto['ok']) {
                $_SESSION['toast'] = $resultadoFoto['error'];
                header('Location: ' . BASE_URL . 'Reporte');
                exit;
            }
        }

        $reporte = new Reporte();
        $reporte->setLatitud((float) $latitud);
        $reporte->setLongitud((float) $longitud);
        $reporte->setIdZona($idZona);
        $reporte->setTamano($tamano);
        $reporte->setDescripcion(trim($descripcion));
        $reporte->setRutaFoto($resultadoFoto['ruta']);

        if ($this->reporteModel->registrar($reporte)) {
            $_SESSION['toast'] = 'Reporte registrado correctamente. Gracias por aportar a tu ciudad.';
        } else {
            $_SESSION['toast'] = 'Ocurrió un error al guardar el reporte.';
        }

        header('Location: ' . BASE_URL . 'Reporte');
        exit;
    }
}
<?php
class Validator {
    public static function validarCoordenadas($latitud, $longitud): bool {
        if (!is_numeric($latitud) || !is_numeric($longitud)) {
            return false;
        }
        $lat = (float) $latitud;
        $lng = (float) $longitud;
        return ($lat >= -90.0 && $lat <= 90.0) && ($lng >= -180.0 && $lng <= 180.0);
    }

    public static function validarDescripcion(string $descripcion, int $min = 10): bool {
        return mb_strlen(trim($descripcion), 'UTF-8') >= $min;
    }

    public static function validarTamano(string $tamano): bool {
        return in_array($tamano, ['pequeno', 'mediano', 'grande'], true);
    }

    public static function validarEstadoReporte(string $estado): bool {
        return in_array($estado, ['reportado', 'atendido', 'descartado'], true);
    }

    public static function generarTokenCsrf(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verificarTokenCsrf(?string $token): bool {
        return isset($_SESSION['csrf_token']) && is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
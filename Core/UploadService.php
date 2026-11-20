<?php
class UploadService {
    private const MAX_BYTES = 5 * 1024 * 1024; // 5 MB exactos
    private const ALLOWED_MIMES = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp'
    ];

    public static function guardarFotografia(array $file, string $directorioDestino = 'Public/assets/uploads/'): array {
        if ($file['error'] === UPLOAD_ERR_NO_FILE) {
            return ['ok' => true, 'ruta' => null];
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['ok' => false, 'error' => 'Error al subir la fotografía al servidor.'];
        }

        if ($file['size'] > self::MAX_BYTES) {
            return ['ok' => false, 'error' => 'La fotografía supera el tamaño máximo permitido de 5 MB.'];
        }

        // Verificar el MIME type real del archivo usando finfo
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeReal = $finfo->file($file['tmp_name']);

        if (!array_key_exists($mimeReal, self::ALLOWED_MIMES)) {
            return ['ok' => false, 'error' => 'Formato no válido. Solo se permiten imágenes JPG, JPEG, PNG o WEBP.'];
        }

        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0755, true);
            // Crear .htaccess interno para impedir ejecución de scripts en uploads
            file_put_contents($directorioDestino . '.htaccess', "php_flag engine off\nOptions -ExecCGI\n");
        }

        $extension = self::ALLOWED_MIMES[$mimeReal];
        $nombreSeguro = 'rep_' . bin2hex(random_bytes(12)) . '.' . $extension;
        $rutaCompleta = rtrim($directorioDestino, '/') . '/' . $nombreSeguro;

        if (!move_uploaded_file($file['tmp_name'], $rutaCompleta)) {
            return ['ok' => false, 'error' => 'No se pudo almacenar el archivo en el servidor.'];
        }

        return ['ok' => true, 'ruta' => $rutaCompleta];
    }
}
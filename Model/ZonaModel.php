<?php
require_once 'Model/Modelo.php';

class ZonaModel extends Modelo {

    public function listarTodas(): array {
        $sql = "SELECT id_zona, nombre, tipo_zona FROM zona ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear(string $nombre, string $tipoZona): bool {
        $sql = "INSERT INTO zona (nombre, tipo_zona) VALUES (:nombre, :tipo_zona)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre'    => trim($nombre),
            ':tipo_zona' => $tipoZona
        ]);
    }

    public function eliminar(int $idZona): bool {
        // Si tiene reportes asociados, la FK (ON DELETE RESTRICT) lanzará excepción que capturaremos en el controlador
        $sql = "DELETE FROM zona WHERE id_zona = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $idZona]);
    }
}
<?php
require_once 'Model/Modelo.php';
require_once 'Entities/Reporte.php';

class ReporteModel extends Modelo {

    public function registrar(Reporte $reporte): bool {
        $sql = "INSERT INTO reporte (latitud, longitud, id_zona, tamano, descripcion, ruta_foto, estado) 
                VALUES (:latitud, :longitud, :id_zona, :tamano, :descripcion, :ruta_foto, 'reportado')";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':latitud'     => $reporte->getLatitud(),
            ':longitud'    => $reporte->getLongitud(),
            ':id_zona'     => $reporte->getIdZona(),
            ':tamano'      => $reporte->getTamano(),
            ':descripcion' => $reporte->getDescripcion(),
            ':ruta_foto'   => $reporte->getRutaFoto()
        ]);
    }

    public function listarTodosConZona(): array {
        $sql = "SELECT r.*, z.nombre AS nombre_zona, z.tipo_zona,
                CASE r.tamano
                    WHEN 'pequeno' THEN 'Pequeño (0.5 m³)'
                    WHEN 'mediano' THEN 'Mediano (2.0 m³)'
                    WHEN 'grande'  THEN 'Grande (6.0 m³)'
                END AS volumen_texto
                FROM reporte r
                INNER JOIN zona z ON r.id_zona = z.id_zona
                ORDER BY r.fecha DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarParaMapa(): array {
        $sql = "SELECT r.id_reporte, r.latitud, r.longitud, r.tamano, r.descripcion, r.estado, r.fecha, z.nombre AS nombre_zona
                FROM reporte r
                INNER JOIN zona z ON r.id_zona = z.id_zona
                WHERE r.estado IN ('reportado', 'atendido')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarEstado(int $idReporte, string $nuevoEstado, ?string $motivoDescarte = null): bool {
        $sql = "UPDATE reporte 
                SET estado = :estado, 
                    fecha_cambio_estado = NOW(), 
                    motivo_descarte = :motivo
                WHERE id_reporte = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':estado' => $nuevoEstado,
            ':motivo' => ($nuevoEstado === 'descartado') ? trim($motivoDescarte) : null,
            ':id'     => $idReporte
        ]);
    }

    public function obtenerEstadisticas(): array {
        $sql = "SELECT 
                    COUNT(*) AS total,
                    SUM(estado = 'reportado') AS reportados,
                    SUM(estado = 'atendido') AS atendidos,
                    SUM(estado = 'descartado') AS descartados
                FROM reporte";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
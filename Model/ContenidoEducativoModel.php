<?php
require_once 'Model/Modelo.php';

class ContenidoEducativoModel extends Modelo {
    public function listarVisibles(): array {
        $sql = "SELECT id_contenido, titulo, contenido, categoria, fecha_actualizacion 
                FROM contenido_educativo 
                WHERE visible = 1 
                ORDER BY id_contenido ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTodos(): array {
        $sql = "SELECT c.*, a.usuario AS autor 
                FROM contenido_educativo c
                INNER JOIN administrador a ON c.id_administrador = a.id_administrador
                ORDER BY c.fecha_actualizacion DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guardar(string $titulo, string $contenido, string $categoria, int $idAdmin): bool {
        $sql = "INSERT INTO contenido_educativo (titulo, contenido, categoria, visible, id_administrador) 
                VALUES (:titulo, :contenido, :categoria, 1, :id_admin)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':titulo'    => trim($titulo),
            ':contenido' => trim($contenido),
            ':categoria' => trim($categoria),
            ':id_admin'  => $idAdmin
        ]);
    }

    public function cambiarVisibilidad(int $idContenido, int $visible): bool {
        $sql = "UPDATE contenido_educativo SET visible = :visible WHERE id_contenido = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':visible' => $visible, ':id' => $idContenido]);
    }
}
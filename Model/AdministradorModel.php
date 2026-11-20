<?php
require_once 'Model/Modelo.php';

class AdministradorModel extends Modelo {
    public function buscarPorUsuario(string $usuario): ?array {
        $sql = "SELECT id_administrador, usuario, contrasena_hash FROM administrador WHERE usuario = :usuario LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':usuario' => trim($usuario)]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        return $admin ?: null;
    }
}
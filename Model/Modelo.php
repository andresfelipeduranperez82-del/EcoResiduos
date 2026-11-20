<?php
require_once 'Core/BaseDatos.php';

class Modelo {
    protected PDO $db;

    public function __construct() {
        $conexion = new BaseDatos();
        $this->db = $conexion->conectar();
    }
}
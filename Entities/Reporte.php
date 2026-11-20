<?php
class Reporte {
    private ?int $id_reporte = null;
    private float $latitud;
    private float $longitud;
    private int $id_zona;
    private string $tamano;
    private string $descripcion;
    private ?string $fecha = null;
    private ?string $ruta_foto = null;
    private string $estado = 'reportado';
    private ?string $fecha_cambio_estado = null;
    private ?string $motivo_descarte = null;

    public function getIdReporte(): ?int { return $this->id_reporte; }
    public function setIdReporte(?int $id): void { $this->id_reporte = $id; }

    public function getLatitud(): float { return $this->latitud; }
    public function setLatitud(float $latitud): void { $this->latitud = $latitud; }

    public function getLongitud(): float { return $this->longitud; }
    public function setLongitud(float $longitud): void { $this->longitud = $longitud; }

    public function getIdZona(): int { return $this->id_zona; }
    public function setIdZona(int $id_zona): void { $this->id_zona = $id_zona; }

    public function getTamano(): string { return $this->tamano; }
    public function setTamano(string $tamano): void { $this->tamano = $tamano; }

    public function getDescripcion(): string { return $this->descripcion; }
    public function setDescripcion(string $descripcion): void { $this->descripcion = $descripcion; }

    public function getFecha(): ?string { return $this->fecha; }
    public function setFecha(?string $fecha): void { $this->fecha = $fecha; }

    public function getRutaFoto(): ?string { return $this->ruta_foto; }
    public function setRutaFoto(?string $ruta_foto): void { $this->ruta_foto = $ruta_foto; }

    public function getEstado(): string { return $this->estado; }
    public function setEstado(string $estado): void { $this->estado = $estado; }

    public function getFechaCambioEstado(): ?string { return $this->fecha_cambio_estado; }
    public function setFechaCambioEstado(?string $fecha): void { $this->fecha_cambio_estado = $fecha; }

    public function getMotivoDescarte(): ?string { return $this->motivo_descarte; }
    public function setMotivoDescarte(?string $motivo): void { $this->motivo_descarte = $motivo; }
}
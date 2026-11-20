USE if0_43488844_ecoresiduos;


CREATE TABLE administrador (
    id_administrador INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    contrasena_hash VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

INSERT INTO administrador (usuario, contrasena_hash) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');


CREATE TABLE zona (
    id_zona INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    tipo_zona ENUM('Comuna', 'Corregimiento', 'Barrio', 'Sector Especial') NOT NULL DEFAULT 'Barrio'
) ENGINE=InnoDB;


INSERT INTO zona (nombre, tipo_zona) VALUES 
('Comuna 1 - Centro / Sector Comercial', 'Comuna'),
('Comuna 2 - El Recreo / La Floresta', 'Comuna'),
('Comuna 3 - La Libertad / El Poblado', 'Comuna'),
('Comuna 4 - Las Penínsulas / La Campana', 'Comuna'),
('Comuna 5 - Pozo Siete', 'Comuna'),
('Malecón / Ciénaga Miramar', 'Sector Especial');


CREATE TABLE reporte (
    id_reporte INT AUTO_INCREMENT PRIMARY KEY,
    latitud DECIMAL(10, 7) NOT NULL,
    longitud DECIMAL(10, 7) NOT NULL,
    id_zona INT NOT NULL,
    tamano ENUM('pequeno', 'mediano', 'grande') NOT NULL COMMENT 'pequeno: 0.5m3, mediano: 2.0m3, grande: 6.0m3',
    descripcion TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ruta_foto VARCHAR(255) NULL,
    estado ENUM('reportado', 'atendido', 'descartado') NOT NULL DEFAULT 'reportado',
    fecha_cambio_estado TIMESTAMP NULL DEFAULT NULL,
    motivo_descarte VARCHAR(255) NULL,
    CONSTRAINT fk_reporte_zona FOREIGN KEY (id_zona) REFERENCES zona(id_zona) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;


CREATE TABLE contenido_educativo (
    id_contenido INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(120) NOT NULL,
    contenido TEXT NOT NULL,
    categoria VARCHAR(60) NOT NULL,
    visible TINYINT(1) NOT NULL DEFAULT 1,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    id_administrador INT NOT NULL,
    CONSTRAINT fk_contenido_admin FOREIGN KEY (id_administrador) REFERENCES administrador(id_administrador) ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO contenido_educativo (titulo, contenido, categoria, visible, id_administrador) VALUES
('Separa desde casa', 'Los residuos aprovechables, como papel, cartón, plástico y metal limpios, pueden tener una nueva vida. Manténlos secos y entrégalos a un reciclador.', 'REDUCE · REUTILIZA · RECICLA', 1, 1),
('Cuida el agua', 'No arrojes aceites, pinturas o residuos a los desagües. Evitar que lleguen a las fuentes de agua es una tarea cotidiana de todos.', 'CADA GOTA CUENTA', 1, 1),
('Activa tu comunidad', 'Comparte las buenas prácticas con tus vecinos, respeta los horarios de recolección y reporta los puntos que necesiten atención.', 'JUNTOS SOMOS CAMBIO', 1, 1);
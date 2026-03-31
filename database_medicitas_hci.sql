CREATE DATABASE IF NOT EXISTS medicitas_hci CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE medicitas_hci;

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    correo VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('admin','recepcionista','medico','paciente') NOT NULL,
    estado ENUM('activo','inactivo') DEFAULT 'activo',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS pacientes (
    id_paciente INT AUTO_INCREMENT PRIMARY KEY,
    identidad VARCHAR(30) NOT NULL UNIQUE,
    fecha_nacimiento DATE NOT NULL,
    sexo ENUM('M','F','Otro') NOT NULL,
    telefono VARCHAR(30) NOT NULL,
    direccion VARCHAR(255),
    estado_civil VARCHAR(30)
);

CREATE TABLE IF NOT EXISTS especialidades (
    id_especialidad INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT
);

CREATE TABLE IF NOT EXISTS medicos (
    id_medico INT AUTO_INCREMENT PRIMARY KEY,
    id_especialidad INT NOT NULL,
    colegiado VARCHAR(50) NOT NULL,
    telefono VARCHAR(30),
    consultorio VARCHAR(50),
    estado ENUM('activo','inactivo') DEFAULT 'activo',
    FOREIGN KEY (id_especialidad) REFERENCES especialidades(id_especialidad)
);

CREATE TABLE IF NOT EXISTS citas (
    id_cita INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT NOT NULL,
    id_medico INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    motivo VARCHAR(255) NOT NULL,
    estado_cita ENUM('programada','confirmada','atendida','cancelada','reprogramada') DEFAULT 'programada',
    observaciones TEXT,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id_paciente),
    FOREIGN KEY (id_medico) REFERENCES medicos(id_medico)
);

CREATE TABLE IF NOT EXISTS historial_citas (
    id_historial INT AUTO_INCREMENT PRIMARY KEY,
    id_cita INT NOT NULL,
    accion VARCHAR(100) NOT NULL,
    usuario_responsable VARCHAR(150),
    fecha_accion DATETIME DEFAULT CURRENT_TIMESTAMP,
    detalle TEXT,
    FOREIGN KEY (id_cita) REFERENCES citas(id_cita)
);

INSERT INTO especialidades (nombre, descripcion) VALUES
('Cardiología', 'Atención del sistema cardiovascular'),
('Dermatología', 'Atención de piel y tejidos'),
('Pediatría', 'Atención médica infantil'),
('Neurología', 'Atención del sistema nervioso')
ON DUPLICATE KEY UPDATE descripcion = VALUES(descripcion);

-- Contraseña: admin123
INSERT INTO usuarios (nombre, correo, password_hash, rol, estado)
VALUES (
    'Administrador General',
    'admin@medicitas.com',
    '$2y$12$uu.plmvubESKuiAUQFQc6OkaP4YgwZq145t1UYdtcZ08b1MMuTn1u',
    'admin',
    'activo'
)
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);
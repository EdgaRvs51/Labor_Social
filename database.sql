-- Script SQL para MySQL / XAMPP
-- La columna password representa la contrasena encriptada requerida por el sistema.

CREATE DATABASE IF NOT EXISTS labor_social_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE labor_social_db;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    apellido VARCHAR(80) NOT NULL,
    cedula VARCHAR(20) NOT NULL,
    correo VARCHAR(120) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('estudiante', 'administrador') NOT NULL DEFAULT 'estudiante',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_usuarios_cedula (cedula),
    UNIQUE KEY uq_usuarios_correo (correo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS proyectos_labor_social (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    nombre_proyecto VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    area_servicio VARCHAR(120) NULL,
    institucion_beneficiada VARCHAR(150) NOT NULL,
    responsable_proyecto VARCHAR(120) NULL,
    fecha_inicio DATE NULL,
    fecha_fin_estimada DATE NULL,
    horas_requeridas INT UNSIGNED NOT NULL DEFAULT 120,
    estado ENUM('propuesto', 'en_progreso', 'culminado') NOT NULL DEFAULT 'propuesto',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_proyectos_labor_social_user_id (user_id),
    CONSTRAINT fk_proyectos_labor_social_usuario
        FOREIGN KEY (user_id) REFERENCES usuarios (id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS registros_horas_labor_social (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    proyecto_labor_social_id INT UNSIGNED NOT NULL,
    fecha DATE NOT NULL,
    horas DECIMAL(5,2) NOT NULL,
    actividad_realizada VARCHAR(180) NOT NULL,
    observaciones TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_registros_horas_proyecto (proyecto_labor_social_id),
    CONSTRAINT fk_registros_horas_proyecto
        FOREIGN KEY (proyecto_labor_social_id) REFERENCES proyectos_labor_social (id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuario administrador inicial
-- Correo: admin@labor.social
-- Contrasena: Admin12345
INSERT INTO usuarios (nombre, apellido, cedula, correo, password, rol)
VALUES (
    'Admin',
    'Sistema',
    '00000000',
    'admin@labor.social',
    '$2y$10$ujkDj4pktSJ.JfaCF1RcDOHT0aE1VIREaR3ao6Q9yfuWOx1r4/QhC',
    'administrador'
)
ON DUPLICATE KEY UPDATE
    nombre = VALUES(nombre),
    apellido = VALUES(apellido),
    password = VALUES(password),
    rol = VALUES(rol);

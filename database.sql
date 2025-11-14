-- ============================================
-- Script de Creación de Base de Datos
-- Sistema de Inscripción - HTECH
-- ============================================

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS phpmyadmin DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE phpmyadmin;

-- ============================================
-- Tabla: Datos del Inscriptor
-- ============================================
CREATE TABLE IF NOT EXISTS datos_inscriptor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    edad INT NOT NULL,
    sexo VARCHAR(20) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_inscriptor_nombre (nombre, apellido)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabla: Datos de País
-- ============================================
CREATE TABLE IF NOT EXISTS datos_pais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    inscriptor_id INT NOT NULL,
    pais_residencia VARCHAR(100) NOT NULL,
    nacionalidad VARCHAR(100) NOT NULL,
    FOREIGN KEY (inscriptor_id) REFERENCES datos_inscriptor(id) ON DELETE CASCADE,
    INDEX idx_pais_inscriptor (inscriptor_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabla: Datos de Áreas de Interés (Tecnologías)
-- ============================================
CREATE TABLE IF NOT EXISTS datos_areas_interes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    inscriptor_id INT NOT NULL,
    tecnologia VARCHAR(100) NOT NULL,
    observaciones TEXT,
    FOREIGN KEY (inscriptor_id) REFERENCES datos_inscriptor(id) ON DELETE CASCADE,
    INDEX idx_interes_inscriptor (inscriptor_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Datos de Ejemplo para Pruebas
-- ============================================
INSERT INTO datos_inscriptor (nombre, apellido, edad, sexo) VALUES
('Juan', 'Pérez', 25, 'Masculino'),
('María', 'González', 30, 'Femenino'),
('Carlos', 'Rodríguez', 28, 'Masculino');

INSERT INTO datos_pais (inscriptor_id, pais_residencia, nacionalidad) VALUES
(1, 'Panamá', 'Panameña'),
(2, 'Costa Rica', 'Costarricense'),
(3, 'Colombia', 'Colombiana');

INSERT INTO datos_areas_interes (inscriptor_id, tecnologia, observaciones) VALUES
(1, 'Correo Electrónico', 'Interesado en aprender Gmail'),
(1, 'Celular', 'Quiere aprender a usar smartphone'),
(2, 'Redes Sociales', 'Desea aprender Facebook e Instagram'),
(3, 'Computación Básica', 'Necesita aprender lo básico');

-- ============================================
-- Verificación de Tablas Creadas
-- ============================================
SHOW TABLES;

-- Fin del Script

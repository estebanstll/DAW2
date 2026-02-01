-- Script SQL para la API
-- Importar con: mysql -u root -p < apirest.sql

-- =========================
-- Eliminar y crear base de datos
-- =========================
DROP DATABASE IF EXISTS `apirest`;

CREATE DATABASE `apirest`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `apirest`;

-- =========================
-- Tabla usuarios
-- =========================
CREATE TABLE `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(255) NOT NULL,
  `correo` VARCHAR(255) NOT NULL UNIQUE,
  `contrasena` VARCHAR(255) NOT NULL
);

-- Datos de ejemplo usuarios
INSERT INTO `usuarios` (`nombre`, `correo`, `contrasena`) VALUES
('Admin', 'admin@local', SHA1(CONCAT('admin','foodhub_password_salt_2026'))),
('Usuario', 'user@local', SHA1(CONCAT('user','foodhub_password_salt_2026')));

-- =========================
-- Tabla medicos
-- =========================
CREATE TABLE `medicos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(255) NOT NULL,
  `correo` VARCHAR(255) NOT NULL UNIQUE,
  `especialidad` VARCHAR(255) NOT NULL
);

-- Datos de ejemplo medicos
INSERT INTO `medicos` (`nombre`, `correo`, `especialidad`) VALUES
('Dr. Juan Pérez', 'juan.perez@hospital.com', 'Cardiología'),
('Dra. Laura Gómez', 'laura.gomez@hospital.com', 'Pediatría'),
('Dr. Miguel Ruiz', 'miguel.ruiz@hospital.com', 'Traumatología');

-- =========================
-- Tabla pacientes
-- =========================
CREATE TABLE `pacientes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `medico_id` INT NOT NULL,
  `nombre` VARCHAR(255) NOT NULL,
  `motivo` TEXT NOT NULL,
  CONSTRAINT `fk_pacientes_medicos`
    FOREIGN KEY (`medico_id`)
    REFERENCES `medicos`(`id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

-- Datos de ejemplo pacientes
INSERT INTO `pacientes` (`medico_id`, `nombre`, `motivo`) VALUES
(1, 'Carlos Martínez', 'Dolor en el pecho'),
(1, 'Ana López', 'Revisión cardiaca'),
(2, 'Lucía Fernández', 'Fiebre persistente'),
(3, 'Pedro Sánchez', 'Dolor de rodilla');

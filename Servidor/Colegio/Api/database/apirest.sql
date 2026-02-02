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
-- Tabla profesores
-- =========================
CREATE TABLE `profesores` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(255) NOT NULL,
  `clase` VARCHAR(255) NOT NULL
);

-- Datos de ejemplo profesores
INSERT INTO `profesores` (`nombre`, `clase`) VALUES
('Antonio López', 'Matemáticas'),
('María Sánchez', 'Lengua'),
('Carlos Ruiz', 'Programación');

-- =========================
-- Tabla alumnos
-- =========================
CREATE TABLE `alumnos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `profesor_id` INT NOT NULL,
  `nombre` VARCHAR(255) NOT NULL,
  `apellidos` VARCHAR(255) NOT NULL,
  CONSTRAINT `fk_alumnos_profesores`
    FOREIGN KEY (`profesor_id`)
    REFERENCES `profesores`(`id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

-- Datos de ejemplo alumnos
INSERT INTO `alumnos` (`profesor_id`, `nombre`, `apellidos`) VALUES
(1, 'Juan', 'Pérez Gómez'),
(1, 'Laura', 'Martín Díaz'),
(2, 'Ana', 'López Ruiz'),
(3, 'Pedro', 'Sánchez Torres');

-- =========================
-- Tabla notas
-- =========================
CREATE TABLE `notas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `alumno_id` INT NOT NULL,
  `asignatura` VARCHAR(255) NOT NULL,
  `nota` DECIMAL(4,2) NOT NULL,
  CONSTRAINT `fk_notas_alumnos`
    FOREIGN KEY (`alumno_id`)
    REFERENCES `alumnos`(`id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

-- Datos de ejemplo notas
INSERT INTO `notas` (`alumno_id`, `asignatura`, `nota`) VALUES
(1, 'Matemáticas', 7.5),
(1, 'Matemáticas', 8.0),
(2, 'Matemáticas', 6.8),
(3, 'Lengua', 9.1),
(4, 'Programación', 8.7);

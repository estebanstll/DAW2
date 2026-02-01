-- Script SQL para crear la base de datos usada por la API
-- Importar con: mysql -u root -p < apirest.sql

CREATE DATABASE IF NOT EXISTS `apirest` 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_general_ci;

USE `apirest`;

-- =========================
-- Tabla usuarios
-- =========================
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(255) NOT NULL,
  `correo` VARCHAR(255) NOT NULL UNIQUE,
  `contrasena` VARCHAR(255) NOT NULL
);

-- Datos de ejemplo
INSERT INTO `usuarios` (`nombre`, `correo`, `contrasena`) VALUES
('Usuario Prueba', 'test@local', SHA1(CONCAT('secret','foodhub_password_salt_2026'))),
('Ejemplo', 'e@gmail.com', SHA1(CONCAT('1','foodhub_password_salt_2026')));

-- =========================
-- Tabla categorias
-- =========================
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(255) NOT NULL,
  `descripcion` TEXT
);

-- =========================
-- Tabla productos
-- =========================
CREATE TABLE IF NOT EXISTS `productos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `categoria_id` INT NOT NULL,
  `nombre` VARCHAR(255) NOT NULL,
  `stock` INT NOT NULL DEFAULT 0,
  CONSTRAINT `fk_productos_categorias`
    FOREIGN KEY (`categoria_id`)
    REFERENCES `categorias`(`id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);
-- =========================
-- Datos de ejemplo: categorias
-- =========================
INSERT INTO `categorias` (`nombre`, `descripcion`) VALUES
('Bebidas', 'Bebidas frías y calientes'),
('Comida Rápida', 'Hamburguesas, pizzas y similares'),
('Postres', 'Dulces y productos de repostería'),
('Snacks', 'Aperitivos y productos para picar');

-- =========================
-- Datos de ejemplo: productos
-- =========================
INSERT INTO `productos` (`categoria_id`, `nombre`, `stock`) VALUES
-- Bebidas
(1, 'Coca-Cola 500ml', 120),
(1, 'Agua Mineral 1L', 200),
(1, 'Café Espresso', 50),

-- Comida Rápida
(2, 'Hamburguesa Clásica', 40),
(2, 'Pizza Margarita', 25),
(2, 'Papas Fritas', 80),

-- Postres
(3, 'Tarta de Chocolate', 15),
(3, 'Helado de Vainilla', 60),

-- Snacks
(4, 'Papas Chips', 100),
(4, 'Maní Salado', 90);

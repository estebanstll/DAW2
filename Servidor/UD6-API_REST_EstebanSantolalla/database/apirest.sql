-- Script SQL para crear la base de datos usada por la API
-- Importar con: mysql -u root -p < apirest.sql

CREATE DATABASE IF NOT EXISTS `apirest` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `apirest`;

-- Tabla restaurantes (usuarios que pueden autenticarse)
CREATE TABLE IF NOT EXISTS `restaurantes` (
  `CodRes` INT AUTO_INCREMENT PRIMARY KEY,
  `Correo` VARCHAR(255) NOT NULL UNIQUE,
  `Clave` VARCHAR(255) NOT NULL,
  `Direccion` VARCHAR(255),
  `Pais` VARCHAR(100),
  `CP` VARCHAR(20),
  `Ciudad` VARCHAR(100)
);

-- Categorías
CREATE TABLE IF NOT EXISTS `categorias` (
  `CodCat` INT AUTO_INCREMENT PRIMARY KEY,
  `Nombre` VARCHAR(255) NOT NULL,
  `Descripcion` TEXT
);

-- Productos
CREATE TABLE IF NOT EXISTS `productos` (
  `CodProd` INT AUTO_INCREMENT PRIMARY KEY,
  `Nombre` VARCHAR(255) NOT NULL,
  `Descripcion` TEXT,
  `Peso` DECIMAL(8,3),
  `Stock` INT DEFAULT 0,
  `Categoria` INT,
  FOREIGN KEY (`Categoria`) REFERENCES `categorias`(`CodCat`) ON DELETE SET NULL
);

-- Pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `CodPed` INT AUTO_INCREMENT PRIMARY KEY,
  `Enviado` TINYINT(1) DEFAULT 0,
  `Restaurante` INT,
  `Fecha` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`Restaurante`) REFERENCES `restaurantes`(`CodRes`) ON DELETE CASCADE
);

-- Lineas de pedido (productos por pedido)
CREATE TABLE IF NOT EXISTS `pedidosproductos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `Pedido` INT,
  `Producto` INT,
  `Unidades` INT DEFAULT 1,
  FOREIGN KEY (`Pedido`) REFERENCES `pedidos`(`CodPed`) ON DELETE CASCADE,
  FOREIGN KEY (`Producto`) REFERENCES `productos`(`CodProd`) ON DELETE CASCADE
);

-- Datos de ejemplo
-- Un restaurante de prueba (clave hasheada usando SHA1(CONCAT('secret','foodhub_password_salt_2026')) )
INSERT INTO `restaurantes` (`Correo`, `Clave`, `Direccion`) VALUES
('test@local', SHA1(CONCAT('secret','foodhub_password_salt_2026')), 'Calle Falsa 123');

-- Usuario adicional pedido por el usuario: correo e@gmail.com, contraseña '1'
INSERT INTO `restaurantes` (`Correo`, `Clave`, `Direccion`) VALUES
('e@gmail.com', SHA1(CONCAT('1','foodhub_password_salt_2026')), 'Direccion Ejemplo');

-- Categorías de ejemplo
INSERT INTO `categorias` (`Nombre`, `Descripcion`) VALUES
('Pizzas', 'Pizzas artesanas'),
('Bebidas', 'Refrescos y zumos');

-- Productos de ejemplo
INSERT INTO `productos` (`Nombre`, `Descripcion`, `Peso`, `Stock`, `Categoria`) VALUES
('Margherita', 'Tomate, mozzarella, albahaca', 0.45, 10, 1),
('Pepperoni', 'Queso y pepperoni', 0.50, 8, 1),
('Coca-Cola', 'Refresco 330ml', 0.33, 50, 2);

-- Pedido de ejemplo para el restaurante 1
INSERT INTO `pedidos` (`Enviado`, `Restaurante`) VALUES (1, 1);

-- Obtener CodPed insertado (en cliente lo harías con LAST_INSERT_ID)
-- Aquí asumimos que el primer pedido tiene id 1
INSERT INTO `pedidosproductos` (`Pedido`, `Producto`, `Unidades`) VALUES
(1, 1, 2),
(1, 3, 1);

-- NOTAS:
-- 1) Actualiza `config/config.ini` para usar `apirest` como `dbname`.
-- 2) El usuario de ejemplo es 'test@local' y la contraseña para usar en el login es: 'secret'
--    (la fila guarda SHA1(CONCAT('secret', 'foodhub_password_salt_2026')) para compatibilidad con la lógica existente).
-- 3) Importa con: mysql -u <user> -p apirest < apirest.sql  (o desde cliente MySQL ejecutando el script)

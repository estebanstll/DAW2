-- Script SQL para crear la base de datos usada por la API
-- Importar con: mysql -u root -p < apirest.sql

CREATE DATABASE IF NOT EXISTS `apirest` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `apirest`;

-- Tabla usuarios (usuarios que pueden autenticarse)
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(255) NOT NULL,
  `correo` VARCHAR(255) NOT NULL UNIQUE,
  `contrasena` VARCHAR(255) NOT NULL
);

-- Datos de ejemplo
-- Usuario de prueba (clave hasheada usando SHA1(CONCAT('secret','foodhub_password_salt_2026')) )
INSERT INTO `usuarios` (`nombre`, `correo`, `contrasena`) VALUES
('Usuario Prueba', 'test@local', SHA1(CONCAT('secret','foodhub_password_salt_2026')));

-- Usuario adicional pedido por el usuario: correo e@gmail.com, contraseña '1'
INSERT INTO `usuarios` (`nombre`, `correo`, `contrasena`) VALUES
('Ejemplo', 'e@gmail.com', SHA1(CONCAT('1','foodhub_password_salt_2026')));

-- Tabla animales
CREATE TABLE IF NOT EXISTS `animales` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `animal` VARCHAR(255) NOT NULL,
  `raza` VARCHAR(255) NOT NULL,
  `nombre` VARCHAR(255) NOT NULL,
  `personaACargo` VARCHAR(255) NOT NULL
);

-- Datos de ejemplo para animales
INSERT INTO `animales` (`animal`, `raza`, `nombre`, `personaACargo`) VALUES
('Perro', 'Labrador Retriever', 'Max', 'Juan García');

INSERT INTO `animales` (`animal`, `raza`, `nombre`, `personaACargo`) VALUES
('Gato', 'Persa', 'Luna', 'María López');

INSERT INTO `animales` (`animal`, `raza`, `nombre`, `personaACargo`) VALUES
('Perro', 'Pastor Alemán', 'Rex', 'Carlos Martínez');

INSERT INTO `animales` (`animal`, `raza`, `nombre`, `personaACargo`) VALUES
('Gato', 'Siamés', 'Misu', 'Ana Rodríguez');

INSERT INTO `animales` (`animal`, `raza`, `nombre`, `personaACargo`) VALUES
('Conejo', 'Holandés', 'Conejito', 'Laura Sánchez');

INSERT INTO `animales` (`animal`, `raza`, `nombre`, `personaACargo`) VALUES
('Pájaro', 'Canario', 'Canario', 'Pedro González');

INSERT INTO `animales` (`animal`, `raza`, `nombre`, `personaACargo`) VALUES
('Hamster', 'Sirio', 'Pelusa', 'Sofia Fernández');

-- NOTAS:
-- 1) Actualiza `config/config.ini` para usar `apirest` como `dbname`.
-- 2) El usuario de ejemplo es 'test@local' y la contraseña para usar en el login es: 'secret'
--    (la fila guarda SHA1(CONCAT('secret', 'foodhub_password_salt_2026')) para compatibilidad con la lógica existente).
-- 3) Importa con: mysql -u <user> -p apirest < apirest.sql  (o desde cliente MySQL ejecutando el script)

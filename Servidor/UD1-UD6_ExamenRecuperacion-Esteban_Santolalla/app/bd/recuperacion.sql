-- phpMyAdmin SQL Dump - Corregido
-- Versión 5.2.1
-- Servidor: 127.0.0.1
-- Generado: 04-02-2026 14:01:05
-- Versión del servidor: 10.6.20-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Base de datos
-- --------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `recuperacion` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `recuperacion`;

-- --------------------------------------------------------
-- Estructura de tabla para `personas`
-- --------------------------------------------------------
CREATE TABLE `personas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para `personas`
INSERT INTO `personas` (`nombre`, `apellidos`, `telefono`, `email`) VALUES
('Juan', 'Pérez', '600111222', 'juan@test.com'),
('Ana', 'López', '600333444', 'ana@test.com'),
('Jose Luis', 'Martínez', '600333555', 'jl@test.com');

-- --------------------------------------------------------
-- Estructura de tabla para `mascotas`
-- --------------------------------------------------------
CREATE TABLE `mascotas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `tipo` varchar(30) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `foto_url` varchar(255) DEFAULT NULL,
  `id_persona` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mascotas_personas` (`id_persona`),
  CONSTRAINT `fk_mascotas_personas` FOREIGN KEY (`id_persona`) REFERENCES `personas`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para `mascotas`
INSERT INTO `mascotas` (`nombre`, `tipo`, `fecha_nacimiento`, `foto_url`, `id_persona`) VALUES
('Rallito', 'tortuga', '2015-09-21', '/public/img/tortuga.jpeg', 1),
('Torete', 'agaponi', '2019-01-15', '/public/img/agaponi.jpeg', 2),
('Carl', 'gato', '2013-05-07', '/public/img/gato.jpeg', 1);

-- --------------------------------------------------------
-- Estructura de tabla para `veterinarios`
-- --------------------------------------------------------
CREATE TABLE `veterinarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `clave` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para `veterinarios`
INSERT INTO `veterinarios` (`nombre`, `email`, `clave`) VALUES
('Dr. García', 'garcia@vet.com', '1234'),
('Dra. Ruiz', 'ruiz@vet.com', '1234');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

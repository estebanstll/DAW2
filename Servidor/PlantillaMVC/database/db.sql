-- ========================================
-- PLANTILLA MVC - Base de Datos
-- ========================================
-- INSTRUCCIONES:
-- 1. Cambia el nombre de la base de datos 'mi_proyecto' por el nombre de tu proyecto
-- 2. Modifica o elimina las tablas de ejemplo según tus necesidades
-- 3. Actualiza el archivo config/config.ini con el nombre de tu base de datos
-- ========================================

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Creación de la base de datos (CAMBIA 'mi_proyecto' por el nombre de tu proyecto)
CREATE DATABASE IF NOT EXISTS `mi_proyecto` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `mi_proyecto`;

-- ========================================
-- TABLA DE EJEMPLO: usuarios
-- Elimina o modifica esta tabla según tus necesidades
-- ========================================
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(90) COLLATE utf8mb4_general_ci NOT NULL,
    `password` VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    `nombre` VARCHAR(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- FIN DE LA PLANTILLA
-- Añade tus propias tablas aquí
-- ========================================

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

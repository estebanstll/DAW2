-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.44 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para pedidos_restaurante
CREATE DATABASE IF NOT EXISTS `pedidos_restaurante` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `pedidos_restaurante`;

-- Volcando estructura para tabla pedidos_restaurante.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
                                            `CodCat` int NOT NULL AUTO_INCREMENT,
                                            `Nombre` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
    `Descripcion` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
    PRIMARY KEY (`CodCat`),
    UNIQUE KEY `Nombre` (`Nombre`)
    ) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla pedidos_restaurante.categorias: ~0 rows (aproximadamente)
DELETE FROM `categorias`;
INSERT INTO `categorias` (`CodCat`, `Nombre`, `Descripcion`) VALUES
                                                                 (18, 'Bebidas con alcohol', 'Bebidas con alcohol'),
                                                                 (19, 'Bebidas sin alcohol', 'Bebidas sin alcohol'),
                                                                 (20, 'Comida', 'Comida');

-- Volcando estructura para tabla pedidos_restaurante.pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
                                         `CodPed` int NOT NULL AUTO_INCREMENT,
                                         `Fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                         `Enviado` int DEFAULT '0',
                                         `Restaurante` int DEFAULT NULL,
                                         PRIMARY KEY (`CodPed`),
    KEY `Restaurante` (`Restaurante`),
    CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`Restaurante`) REFERENCES `restaurantes` (`CodRes`)
    ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla pedidos_restaurante.pedidos: ~2 rows (aproximadamente)
DELETE FROM `pedidos`;
INSERT INTO `pedidos` (`CodPed`, `Fecha`, `Enviado`, `Restaurante`) VALUES
                                                                        (1, '2026-01-07 12:29:13', 0, 17),
                                                                        (2, '2026-01-07 12:29:58', 0, 17);

-- Volcando estructura para tabla pedidos_restaurante.pedidosproductos
CREATE TABLE IF NOT EXISTS `pedidosproductos` (
                                                  `CodPedProd` int NOT NULL AUTO_INCREMENT,
                                                  `Pedido` int DEFAULT NULL,
                                                  `Producto` int DEFAULT NULL,
                                                  `Unidades` int DEFAULT NULL,
                                                  PRIMARY KEY (`CodPedProd`),
    KEY `Pedido` (`Pedido`),
    KEY `Producto` (`Producto`),
    CONSTRAINT `pedidosproductos_ibfk_1` FOREIGN KEY (`Pedido`) REFERENCES `pedidos` (`CodPed`),
    CONSTRAINT `pedidosproductos_ibfk_2` FOREIGN KEY (`Producto`) REFERENCES `productos` (`CodProd`)
    ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla pedidos_restaurante.pedidosproductos: ~5 rows (aproximadamente)
DELETE FROM `pedidosproductos`;
INSERT INTO `pedidosproductos` (`CodPedProd`, `Pedido`, `Producto`, `Unidades`) VALUES
                                                                                    (1, 1, 31, 1),
                                                                                    (2, 1, 30, 1),
                                                                                    (3, 1, 32, 1),
                                                                                    (4, 2, 21, 3),
                                                                                    (5, 2, 22, 2);

-- Volcando estructura para tabla pedidos_restaurante.productos
CREATE TABLE IF NOT EXISTS `productos` (
                                           `CodProd` int NOT NULL AUTO_INCREMENT,
                                           `Nombre` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
    `Descripcion` varchar(90) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `Peso` double DEFAULT NULL,
    `Stock` int DEFAULT NULL,
    `Categoria` int DEFAULT NULL,
    PRIMARY KEY (`CodProd`),
    KEY `Categoria` (`Categoria`),
    CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`Categoria`) REFERENCES `categorias` (`CodCat`)
    ) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla pedidos_restaurante.productos: ~0 rows (aproximadamente)
DELETE FROM `productos`;
INSERT INTO `productos` (`CodProd`, `Nombre`, `Descripcion`, `Peso`, `Stock`, `Categoria`) VALUES
                                                                                               (21, 'Cerveza Alhambra Tercio', '24 botellas de 33cl', 10, 9, 18),
                                                                                               (22, 'Vino tinto Rioja 0.75', '6 botellas de 0.75', 5.5, 6, 18),
                                                                                               (23, 'Sal', '20 paquetes de 1kg cada uno', 20, 20, 20),
                                                                                               (24, 'Cerveza Lager 330ml', 'Caja con 24 botellas de 330ml', 10, 20, 18),
                                                                                               (25, 'Vino Tinto Reserva 750ml', 'Botella de vino tinto reserva', 5.5, 13, 18),
                                                                                               (26, 'Vino Blanco 750ml', 'Botella de vino blanco seco', 5.5, 12, 18),
                                                                                               (27, 'Whisky 700ml', 'Botella de whisky añejado', 7, 10, 18),
                                                                                               (28, 'Ron Dorado 750ml', 'Botella de ron dorado', 6.5, 14, 18),
                                                                                               (29, 'Agua Mineral 500ml', 'Pack de 24 botellas de 500ml', 12, 26, 19),
                                                                                               (30, 'Refresco Cola 600ml', 'Pack de 12 botellas de 600ml', 9, 24, 19),
                                                                                               (31, 'Jugo de Naranja 1L', 'Caja con 12 botellas de 1 litro', 13, 17, 19),
                                                                                               (32, 'Bebida Energética 473ml', 'Pack de 12 latas', 6, 19, 19),
                                                                                               (33, 'Té Helado 500ml', 'Pack de 12 botellas de té helado', 8, 22, 19),
                                                                                               (34, 'Arroz 1kg', 'Paquete de arroz blanco de 1kg', 20, 38, 20),
                                                                                               (35, 'Pasta Espagueti 500g', 'Caja con 20 paquetes de 500g', 10, 35, 20),
                                                                                               (36, 'Aceite Vegetal 1L', 'Botella de aceite vegetal', 18, 25, 20),
                                                                                               (37, 'Azúcar 1kg', 'Paquete de azúcar refinada', 20, 30, 20),
                                                                                               (38, 'Harina de Trigo 1kg', 'Paquete de harina de trigo', 20, 28, 20);

-- Volcando estructura para tabla pedidos_restaurante.restaurantes
CREATE TABLE IF NOT EXISTS `restaurantes` (
                                              `CodRes` int NOT NULL AUTO_INCREMENT,
                                              `Correo` varchar(90) COLLATE utf8mb4_general_ci NOT NULL,
    `Clave` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
    `Pais` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `CP` int DEFAULT NULL,
    `Ciudad` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `Direccion` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
    PRIMARY KEY (`CodRes`),
    UNIQUE KEY `Correo` (`Correo`)
    ) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla pedidos_restaurante.restaurantes: ~0 rows (aproximadamente)
DELETE FROM `restaurantes`;
INSERT INTO `restaurantes` (`CodRes`, `Correo`, `Clave`, `Pais`, `CP`, `Ciudad`, `Direccion`) VALUES
                                                                                                  (1, 'contacto@latoja.com', '1234', 'España', 28001, 'Madrid', 'Calle Gran Vía 12'),
                                                                                                  (2, 'info@sushimaster.com', '1234', 'España', 8005, 'Barcelona', 'Av. Diagonal 203'),
                                                                                                  (3, 'admin@elassador.com', '1234', 'Argentina', 1414, 'Buenos Aires', 'Calle Corrientes 500'),
                                                                                                  (4, 'pedidos@pizzeriaroma.com', '1234', 'Italia', 185, 'Roma', 'Via Roma 10'),
                                                                                                  (5, 'chef@lepetit.fr', '1234', 'Francia', 75001, 'París', 'Rue de Rivoli 5'),
                                                                                                  (6, 'gerencia@tacosmex.com', '1234', 'México', 6600, 'CDMX', 'Av. Reforma 222'),
                                                                                                  (7, 'compras@burgerkingkong.com', '1234', 'España', 46002, 'Valencia', 'Plaza del Ayuntamiento 3'),
                                                                                                  (8, 'veganlife@green.com', '1234', 'España', 41004, 'Sevilla', 'Calle Sierpes 8'),
                                                                                                  (9, 'curryhouse@spice.com', '1234', 'Reino Unido', 10012, 'Londres', 'Baker Street 221B'),
                                                                                                  (10, 'bistro@berlin.de', '1234', 'Alemania', 10115, 'Berlín', 'Alexanderplatz 1'),
                                                                                                  (11, 'mariscos@galicia.es', '1234', 'España', 15001, 'A Coruña', 'Paseo Marítimo 45'),
                                                                                                  (12, 'kebab@estambul.tr', '1234', 'Turquía', 34000, 'Estambul', 'Taksim Square 9'),
                                                                                                  (13, 'wok@china.cn', '1234', 'España', 29001, 'Málaga', 'Calle Larios 15'),
                                                                                                  (14, 'braserie@belgica.be', '1234', 'Bélgica', 1000, 'Bruselas', 'Grand Place 2'),
                                                                                                  (15, 'cafeteria@central.com', '1234', 'España', 50003, 'Zaragoza', 'Calle Alfonso I 10'),
                                                                                                  (16, 'tapasyvinos@madrid.es', '1234', 'España', 28013, 'Madrid', 'Calle Huertas 22'),
                                                                                                  (17, 'rtpfm19@gmail.com', '1234', 'España', 26006, 'La Rioja', 'Calle Hola 12');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

DROP DATABASE IF EXISTS remark_db;
CREATE DATABASE remark_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE remark_db;

-- =========================
-- TABLA: USUARIOS
-- =========================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    rol ENUM('comprador', 'vendedor', 'admin') DEFAULT 'comprador'
);

INSERT INTO usuarios (nombre_usuario, email, contrasena, rol) VALUES
('laura_g', 'laura@example.com', '1234', 'vendedor'),
('marcos_r', 'marcos@example.com', '1234', 'comprador'),
('ana_p', 'ana@example.com', '1234', 'comprador'),
('pedro_v', 'pedro@example.com', '1234', 'vendedor'),
('lucia_m', 'lucia@example.com', '1234', 'vendedor'),
('carlos_b', 'carlos@example.com', '1234', 'vendedor'),
('jorge_s', 'jorge@example.com', '1234', 'comprador'),
('marta_t', 'marta@example.com', '1234', 'comprador');

-- =========================
-- TABLA: PRODUCTOS
-- =========================
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    categoria VARCHAR(50),
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255),
    fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('disponible', 'vendido', 'pausado') DEFAULT 'disponible',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- =========================
-- TABLA: ETIQUETAS
-- =========================
CREATE TABLE etiquetas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

-- =========================
-- TABLA: PRODUCTO_ETIQUETA (Relación muchos a muchos)
-- =========================
CREATE TABLE producto_etiqueta (
    id_producto INT NOT NULL,
    id_etiqueta INT NOT NULL,
    PRIMARY KEY (id_producto, id_etiqueta),
    FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_etiqueta) REFERENCES etiquetas(id) ON DELETE CASCADE
);

-- =========================
-- TABLA: OPINIONES
-- =========================
CREATE TABLE opiniones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT NOT NULL,
    id_usuario INT,
    comentario TEXT NOT NULL,
    puntuacion INT CHECK (puntuacion BETWEEN 1 AND 5),
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_producto) REFERENCES productos(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- =========================
-- PRODUCTOS
-- =========================
INSERT INTO productos (id_usuario, nombre, categoria, descripcion, precio, imagen) VALUES
(1, 'iPhone 13', 'moviles', 'iPhone 13 en excelente estado, color negro. 128GB.', 750, 'https://via.placeholder.com/220'),
(1, 'Samsung Galaxy S22', 'moviles', 'Galaxy S22 prácticamente nuevo, color blanco.', 680, 'https://via.placeholder.com/220'),
(1, 'Xiaomi Redmi Note 12', 'moviles', 'Nuevo Redmi Note 12 con 128GB de almacenamiento.', 299, 'https://via.placeholder.com/220'),
(4, 'Portátil HP 15s', 'electronica', 'Laptop HP con 16GB RAM, SSD 512GB y pantalla de 15".', 800, 'https://via.placeholder.com/220'),
(4, 'Auriculares Sony WH-1000XM4', 'electronica', 'Auriculares con cancelación activa de ruido.', 220, 'https://via.placeholder.com/220'),
(5, 'Monitor LG UltraWide 29"', 'electronica', 'Pantalla UltraWide Full HD de 29 pulgadas.', 180, 'https://via.placeholder.com/220'),
(5, 'Teclado Mecánico Logitech G Pro', 'electronica', 'Teclado RGB mecánico para gaming.', 95, 'https://via.placeholder.com/220'),
(6, 'Camiseta Nike Dri-FIT', 'ropa', 'Camiseta deportiva Nike, talla M.', 25, 'https://via.placeholder.com/220'),
(6, 'Zapatillas Adidas Ultraboost 22', 'ropa', 'Zapatillas de running Adidas, talla 41.', 120, 'https://via.placeholder.com/220'),
(5, 'Silla Gamer Drift DR111', 'hogar', 'Silla ergonómica ajustable con cojín lumbar.', 130, 'https://via.placeholder.com/220'),
(5, 'Cafetera Nespresso Essenza Mini', 'hogar', 'Cafetera de cápsulas Nespresso compacta.', 89, 'https://via.placeholder.com/220'),
(6, 'Bicicleta Orbea MX 40', 'deportes', 'Bicicleta de montaña con frenos hidráulicos.', 540, 'https://via.placeholder.com/220'),
(6, 'Guantes de boxeo Everlast 12oz', 'deportes', 'Guantes de boxeo profesionales.', 40, 'https://via.placeholder.com/220'),
(1, 'The Legend of Zelda: Tears of the Kingdom', 'videojuegos', 'Juego de aventura para Nintendo Switch.', 59, 'https://via.placeholder.com/220'),
(4, 'Mando Xbox Series X', 'videojuegos', 'Mando inalámbrico original Xbox.', 55, 'https://via.placeholder.com/220'),
(5, 'Kindle Paperwhite 11ª Gen', 'libros', 'Lector de libros electrónicos con luz ajustable.', 110, 'https://via.placeholder.com/220'),
(5, 'El Señor de los Anillos - Trilogía', 'libros', 'Edición tapa dura con las tres partes de Tolkien.', 65, 'https://via.placeholder.com/220'),
(6, 'Reloj Casio G-Shock GA-2100', 'accesorios', 'Reloj resistente al agua, color azul.', 99, 'https://via.placeholder.com/220'),
(4, 'Mochila North Face Borealis', 'accesorios', 'Mochila 28L, resistente al agua, ideal para viajes.', 75, 'https://via.placeholder.com/220'),
(1, 'Tablet iPad Air 5 M1', 'electronica', 'iPad Air 5 con chip M1 y 64GB de almacenamiento.', 630, 'https://via.placeholder.com/220');

-- =========================
-- ETIQUETAS
-- =========================
INSERT INTO etiquetas (nombre) VALUES
('móvil'),
('apple'),
('ios'),
('android'),
('samsung'),
('smartphone'),
('xiaomi'),
('hp'),
('portátil'),
('electrónica'),
('auriculares'),
('sony'),
('monitor'),
('lg'),
('teclado'),
('gaming'),
('ropa'),
('nike'),
('adidas'),
('hogar'),
('cafetera'),
('deportes'),
('bicicleta'),
('boxeo'),
('videojuegos'),
('nintendo'),
('xbox'),
('libros'),
('tolkien'),
('accesorios'),
('reloj'),
('mochila'),
('tablet');

-- =========================
-- PRODUCTO_ETIQUETA (relaciones coherentes)
-- =========================
INSERT INTO producto_etiqueta (id_producto, id_etiqueta) VALUES
-- iPhone 13
(1, 1), (1, 2), (1, 3), (1, 6),
-- Samsung Galaxy S22
(2, 1), (2, 4), (2, 5), (2, 6),
-- Xiaomi Redmi Note 12
(3, 1), (3, 4), (3, 7), (3, 6),
-- Portátil HP 15s
(4, 8), (4, 9), (4, 10),
-- Auriculares Sony
(5, 11), (5, 12), (5, 10),
-- Monitor LG UltraWide
(6, 13), (6, 14), (6, 10),
-- Teclado Logitech
(7, 15), (7, 16), (7, 10),
-- Camiseta Nike
(8, 17), (8, 18),
-- Zapatillas Adidas
(9, 17), (9, 19),
-- Silla Gamer
(10, 20), (10, 16),
-- Cafetera Nespresso
(11, 20), (11, 21),
-- Bicicleta Orbea
(12, 22), (12, 23),
-- Guantes de boxeo
(13, 22), (13, 24),
-- Zelda
(14, 25), (14, 26),
-- Mando Xbox
(15, 25), (15, 27),
-- Kindle
(16, 28), (16, 10),
-- El Señor de los Anillos
(17, 28), (17, 29),
-- Reloj Casio
(18, 30), (18, 31),
-- Mochila North Face
(19, 30), (19, 32),
-- iPad Air
(20, 33), (20, 2), (20, 10);

-- =========================
-- OPINIONES
-- =========================
INSERT INTO opiniones (id_producto, id_usuario, comentario, puntuacion) VALUES
(1, 2, 'Excelente compra, el móvil llegó en perfecto estado.', 5),
(2, 3, 'Muy buen rendimiento y cámara.', 4),
(3, 7, 'Ideal para el día a día, muy rápido.', 5),
(4, 2, 'Perfecto para trabajar, muy fluido.', 5),
(5, 8, 'El sonido es increíble y la cancelación de ruido funciona genial.', 5),
(6, 7, 'Ideal para multitarea, buena calidad de imagen.', 4),
(9, 3, 'Muy cómodas y ligeras para correr.', 5),
(10, 2, 'Muy buena silla, se nota la calidad.', 4),
(11, 8, 'Hace un café delicioso y rápido.', 5),
(12, 3, 'Resistente y ligera, perfecta para rutas largas.', 5),
(14, 7, 'Una joya, uno de los mejores juegos de Switch.', 5),
(15, 8, 'Mando muy cómodo y con buena batería.', 4),
(16, 3, 'Ideal para leer antes de dormir, la luz ajustable es excelente.', 5),
(17, 2, 'Una edición preciosa y de gran calidad.', 5),
(18, 7, 'Muy resistente y bonito diseño.', 4),
(19, 8, 'Perfecta para viajes cortos, muy cómoda.', 5),
(20, 3, 'Rápida y ligera, el chip M1 se nota.', 5);

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS remark_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE remark_db;

-- =========================
-- TABLA: USUARIOS
-- =========================
CREATE TABLE IF NOT EXISTS usuarios (
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
('carlos_b', 'carlos@example.com', '1234', 'vendedor');

-- =========================
-- TABLA: PRODUCTOS
-- =========================
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    etiquetas VARCHAR(255),
    categoria VARCHAR(50),
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255),
    fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('disponible', 'vendido', 'pausado') DEFAULT 'disponible',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);


INSERT INTO productos (id_usuario, nombre, etiquetas, categoria, descripcion, precio, imagen) VALUES
(1, 'iPhone 13', 'móvil, apple, ios', 'moviles', 'iPhone 13 en excelente estado, color negro.', 750, 'https://via.placeholder.com/220'),
(1, 'Samsung Galaxy S22', 'android, samsung, smartphone', 'moviles', 'Galaxy S22 prácticamente nuevo, color blanco.', 680, 'https://via.placeholder.com/220'),
(1, 'Xiaomi Redmi Note 12', 'xiaomi, móvil, android', 'moviles', 'Nuevo Redmi Note 12 con 128GB de almacenamiento.', 299, 'https://via.placeholder.com/220'),
(2, 'Portátil HP 15s', 'portátil, hp, electrónica', 'electronica', 'Laptop HP de 15 pulgadas, 16GB RAM, SSD 512GB.', 800, 'https://via.placeholder.com/220'),
(2, 'Auriculares Sony WH-1000XM4', 'auriculares, sony, bluetooth', 'electronica', 'Auriculares inalámbricos con cancelación de ruido.', 220, 'https://via.placeholder.com/220'),
(3, 'Monitor LG UltraWide', 'monitor, lg, oficina', 'electronica', 'Monitor 29 pulgadas UltraWide Full HD.', 180, 'https://via.placeholder.com/220'),
(3, 'Teclado Mecánico Logitech', 'teclado, gaming, logitech', 'electronica', 'Teclado RGB mecánico con switches red.', 95, 'https://via.placeholder.com/220'),
(4, 'Camiseta Nike', 'ropa, deportiva, nike', 'ropa', 'Camiseta original Nike, talla M.', 25, 'https://via.placeholder.com/220'),
(4, 'Pantalón Levi’s 501', 'ropa, levi’s, vaquero', 'ropa', 'Clásico Levi’s 501 azul marino, talla 42.', 45, 'https://via.placeholder.com/220'),
(4, 'Zapatillas Adidas Ultraboost', 'adidas, running, deportiva', 'ropa', 'Zapatillas Adidas Ultraboost nuevas, talla 41.', 120, 'https://via.placeholder.com/220'),
(5, 'Silla Gamer Drift DR111', 'hogar, gaming, confort', 'hogar', 'Silla ergonómica ajustable para gaming.', 130, 'https://via.placeholder.com/220'),
(5, 'Lámpara de escritorio LED', 'hogar, iluminación, led', 'hogar', 'Lámpara con brazo flexible y ajuste de brillo.', 35, 'https://via.placeholder.com/220'),
(5, 'Cafetera Nespresso', 'cocina, café, electrodoméstico', 'hogar', 'Cafetera de cápsulas Nespresso con depósito de agua.', 89, 'https://via.placeholder.com/220'),
(6, 'Pelota de fútbol Adidas', 'deporte, fútbol, adidas', 'deportes', 'Balón oficial de entrenamiento, tamaño 5.', 29, 'https://via.placeholder.com/220'),
(6, 'Bicicleta de montaña Orbea', 'deporte, ciclismo, mtb', 'deportes', 'Bicicleta Orbea con suspensión delantera y frenos hidráulicos.', 540, 'https://via.placeholder.com/220'),
(6, 'Guantes de boxeo Everlast', 'deporte, boxeo, everlast', 'deportes', 'Guantes de 12 oz en perfecto estado.', 40, 'https://via.placeholder.com/220'),
(1, 'The Legend of Zelda: Tears of the Kingdom', 'videojuegos, nintendo, aventura', 'videojuegos', 'Juego para Nintendo Switch, edición física.', 59, 'https://via.placeholder.com/220'),
(2, 'Mando Xbox Series X', 'videojuegos, xbox, mando', 'videojuegos', 'Mando inalámbrico original Xbox color negro.', 55, 'https://via.placeholder.com/220'),
(3, 'Kindle Paperwhite', 'libros, ebook, amazon', 'libros', 'Lector de libros electrónicos con luz integrada.', 110, 'https://via.placeholder.com/220'),
(4, 'El señor de los anillos - Trilogía', 'libros, fantasía, tolkien', 'libros', 'Edición especial de tapa dura con las tres partes.', 65, 'https://via.placeholder.com/220'),
(5, 'Mochila North Face Borealis', 'accesorios, mochila, viaje', 'accesorios', 'Mochila resistente, 28L, color negro.', 75, 'https://via.placeholder.com/220'),
(6, 'Reloj Casio G-Shock', 'accesorios, reloj, casio', 'accesorios', 'Reloj G-Shock resistente al agua, color azul.', 99, 'https://via.placeholder.com/220'),
(2, 'Smartwatch Samsung Galaxy Watch 5', 'wearable, reloj, samsung', 'electronica', 'Smartwatch con sensor de ritmo cardíaco y GPS.', 230, 'https://via.placeholder.com/220'),
(3, 'Tablet iPad Air 5', 'apple, tablet, ios', 'electronica', 'iPad Air 5 con chip M1 y 64GB de almacenamiento.', 630, 'https://via.placeholder.com/220');

-- =========================
-- TABLA: OPINIONES
-- =========================
CREATE TABLE IF NOT EXISTS opiniones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT NOT NULL,
    id_usuario INT,
    nombre_autor VARCHAR(100),
    comentario TEXT NOT NULL,
    puntuacion INT CHECK (puntuacion BETWEEN 1 AND 5),
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_producto) REFERENCES productos(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);


INSERT INTO opiniones (id_producto, id_usuario, nombre_autor, comentario, puntuacion)
VALUES
(1, 2, 'Marcos R.', 'Vendí mi teléfono en menos de 2 días, el proceso fue súper fácil.', 5),
(2, 3, 'Ana P.', 'Excelente plataforma, encontré una bici usada en perfecto estado.', 4),
(3, NULL, 'Invitado', 'Muy buena calidad de producto.', 5),
(4, 1, 'Laura G.', 'El portátil funciona genial, todo correcto.', 5),
(10, 2, 'Marcos R.', 'Las zapatillas son muy cómodas, llegaron rápido.', 5),
(14, 3, 'Ana P.', 'La lámpara es perfecta para estudiar por la noche.', 4),
(17, NULL, 'Pedro V.', 'Juego increíble, totalmente recomendado.', 5),
(18, 1, 'Laura G.', 'El mando se siente muy sólido y responde bien.', 4),
(20, NULL, 'Lucía M.', 'Los libros venían bien embalados y en excelente estado.', 5),
(23, 3, 'Ana P.', 'El smartwatch es precioso y muy útil para entrenar.', 5);

-- =========================
-- RELACIONES ENTRE TABLAS
-- =========================
-- usuarios (1) ────< productos (n)
-- productos (1) ────< opiniones (n)
-- usuarios (1) ────< opiniones (n) [opcional]
opiniones
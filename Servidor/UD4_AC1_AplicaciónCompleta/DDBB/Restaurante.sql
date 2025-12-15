DROP DATABASE IF EXISTS tienda;
CREATE DATABASE tienda CHARACTER SET utf8mb4;
USE tienda;

-- TABLA RESTAURANTE
CREATE TABLE Restaurante (
    CodRes INT AUTO_INCREMENT PRIMARY KEY,
    Correo VARCHAR(100) NOT NULL UNIQUE,
    Clave VARCHAR(50) NOT NULL,  -- ahora clave simple
    CP VARCHAR(10) NOT NULL,
    Pais VARCHAR(50) NOT NULL,
    Ciudad VARCHAR(50) NOT NULL,
    Direccion VARCHAR(100) NOT NULL
);

-- TABLA CATEGORÍA
CREATE TABLE Categoria (
    idCategoria INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL UNIQUE,
    Descripcion VARCHAR(255) NULL
);

-- TABLA PRODUCTO (FK → Categoria)
CREATE TABLE Producto (
    CodProd INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion VARCHAR(255) NULL,
    Peso DECIMAL(6,2) NOT NULL,
    Stock INT NOT NULL,
    idCategoria INT NOT NULL,
    FOREIGN KEY (idCategoria) REFERENCES Categoria(idCategoria)
);

-- TABLA PEDIDO
CREATE TABLE Pedido (
    CodPed INT AUTO_INCREMENT PRIMARY KEY,
    Fecha DATETIME NOT NULL,
    Enviado TINYINT(1) NOT NULL DEFAULT 0,
    CodRes INT NOT NULL,
    FOREIGN KEY (CodRes) REFERENCES Restaurante(CodRes)
);

-- TABLA INTERMEDIA PedidoProducto
CREATE TABLE PedidoProducto (
    CodPedProd INT AUTO_INCREMENT PRIMARY KEY,
    CodPed INT NOT NULL,
    CodProd INT NOT NULL,
    Unidades INT NOT NULL,
    FOREIGN KEY (CodPed) REFERENCES Pedido(CodPed),
    FOREIGN KEY (CodProd) REFERENCES Producto(CodProd)
);

-- INSERTAR CATEGORÍAS
INSERT INTO Categoria (Nombre, Descripcion)
VALUES
('Comidas', 'Platos y alimentos'),
('Bebidas', 'Bebidas frías y calientes');

-- INSERTAR RESTAURANTES CON CLAVE NUMÉRICA SIN ENCRIPTAR
INSERT INTO Restaurante (Correo, Clave, CP, Pais, Ciudad, Direccion)
VALUES
('resto1@example.com', '1234', '28001', 'España', 'Madrid', 'Calle Mayor 10'),
('resto2@example.com', '1111', '08001', 'España', 'Barcelona', 'Diagonal 20');

-- INSERTAR PRODUCTOS
INSERT INTO Producto (Nombre, Descripcion, Peso, Stock, idCategoria)
VALUES
('Hamburguesa', 'Hamburguesa clásica', 0.50, 40, 1),
('Bocadillo de Jamón', 'Pan con jamón serrano', 0.40, 25, 1),
('Tarta de queso', 'Porción de tarta', 0.20, 15, 1),

('Coca-Cola', 'Lata 33cl', 0.33, 100, 2),
('Café', 'Café caliente', 0.25, 50, 2),
('Agua Mineral', 'Botella 50cl', 0.50, 80, 2);

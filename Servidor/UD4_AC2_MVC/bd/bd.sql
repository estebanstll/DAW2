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
('Comida', 'Platos y alimentos'),
('Bebidas sin alcohol', 'Refrescos y bebidas no alcohólicas'),
('Bebidas con alcohol', 'Bebidas alcohólicas');

-- INSERTAR RESTAURANTES CON CLAVE NUMÉRICA SIN ENCRIPTAR
INSERT INTO Restaurante (Correo, Clave, CP, Pais, Ciudad, Direccion)
VALUES
('resto1@example.com', '1234', '28001', 'España', 'Madrid', 'Calle Mayor 10'),
('resto2@example.com', '1111', '08001', 'España', 'Barcelona', 'Diagonal 20'),
('estebansantolallar@gmail.com', '1111', '26500', 'España', 'Barcelona', 'Diagonal 20');

-- INSERTAR PRODUCTOS
INSERT INTO Producto (Nombre, Descripcion, Peso, Stock, idCategoria)
VALUES
('Hamburguesa', 'Hamburguesa de carne con queso', 0.50, 40, 1),
('Pizza Margarita', 'Pizza clásica con tomate y queso', 0.80, 20, 1),
('Ensalada César', 'Lechuga, pollo y salsa césar', 0.45, 30, 1);

-- BEBIDAS SIN ALCOHOL (idCategoria = 2)
INSERT INTO Producto (Nombre, Descripcion, Peso, Stock, idCategoria)
VALUES
('Coca-Cola', 'Refresco de cola 33cl', 0.33, 100, 2),
('Agua Mineral', 'Botella de agua 50cl', 0.50, 80, 2),
('Zumo de Naranja', 'Zumo natural', 0.30, 60, 2);

-- BEBIDAS CON ALCOHOL (idCategoria = 3)
INSERT INTO Producto (Nombre, Descripcion, Peso, Stock, idCategoria)
VALUES
('Cerveza', 'Cerveza rubia 33cl', 0.33, 70, 3),
('Vino Tinto', 'Copa de vino tinto', 0.20, 50, 3),
('Whisky', 'Whisky escocés', 0.10, 25, 3);

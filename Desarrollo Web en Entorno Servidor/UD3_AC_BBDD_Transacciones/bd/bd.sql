-- crear base de datos
CREATE DATABASE IF NOT EXISTS hobbies CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE hobbies;

-- tabla usuarios para login
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  nombre VARCHAR(100),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- tabla lectura (ejemplo de hobby)
CREATE TABLE IF NOT EXISTS lectura (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo_libro VARCHAR(255) NOT NULL UNIQUE,
  autor VARCHAR(150) NOT NULL,
  paginas INT NOT NULL,
  terminado TINYINT(1) NOT NULL DEFAULT 0,
  fecha_lectura DATE NULL,
  comentario TEXT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO usuarios (username, password_hash, nombre)
VALUES ('admin', '1234', 'Administrador');


INSERT INTO lectura (titulo_libro, autor, paginas, terminado, fecha_lectura, comentario)
VALUES 
('El Hobbit', 'J.R.R. Tolkien', 310, 1, '2025-11-19', 'Una aventura fantástica muy entretenida'),
('Cien Años de Soledad', 'Gabriel García Márquez', 417, 0, NULL, 'Pendiente de lectura'),
('1984', 'George Orwell', 328, 1, '2025-10-15', 'Impactante y reflexivo sobre sociedades distópicas'),
('Don Quijote de la Mancha', 'Miguel de Cervantes', 863, 0, NULL, 'Clásico pendiente de leer'),
('La Sombra del Viento', 'Carlos Ruiz Zafón', 576, 1, '2025-09-30', 'Muy envolvente y misterioso'),
('Harry Potter y la Piedra Filosofal', 'J.K. Rowling', 223, 1, '2025-08-20', 'Inicio de la saga mágica'),
('El Principito', 'Antoine de Saint-Exupéry', 96, 1, '2025-07-10', 'Corto pero profundo'),
('Sapiens: De animales a dioses', 'Yuval Noah Harari', 498, 0, NULL, 'Lectura de divulgación histórica');

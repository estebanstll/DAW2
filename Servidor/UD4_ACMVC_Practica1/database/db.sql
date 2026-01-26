-- 1. Crear la base de datos y usarla
CREATE DATABASE IF NOT EXISTS hospital;
USE hospital;

-- 2. Crear la tabla usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    gmail VARCHAR(150) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    especialidad VARCHAR(100)
);

-- 3. Inserción de múltiples datos (20 registros de ejemplo)
INSERT INTO usuarios (nombre, gmail, contraseña, especialidad) VALUES
('Dr. Alberto Ruiz', 'alberto.ruiz@gmail.com', 'hash_pass_1', 'Cardiología'),
('Dra. Elena Beltrán', 'elena.b@gmail.com', 'hash_pass_2', 'Pediatría'),
('Dr. Carlos Méndez', 'carlos.m@gmail.com', 'hash_pass_3', 'Neurología'),
('Dra. Lucía Sanz', 'lucia.sanz@gmail.com', 'hash_pass_4', 'Dermatología'),
('Dr. Jorge Herrera', 'jorge.h@gmail.com', 'hash_pass_5', 'Ginecología'),
('Dra. Marta Gómez', 'marta.g@gmail.com', 'hash_pass_6', 'Oftalmología'),
('Dr. Ricardo Lugo', 'ricardo.l@gmail.com', 'hash_pass_7', 'Traumatología'),
('Dra. Sofía Vega', 'sofia.vega@gmail.com', 'hash_pass_8', 'Psiquiatría'),
('Dr. Miguel Ángel', 'miguel.a@gmail.com', 'hash_pass_9', 'Oncología'),
('Dra. Isabel Fer', 'isabel.fer@gmail.com', 'hash_pass_10', 'Endocrinología'),
('Dr. Fernando Paz', 'f.paz@gmail.com', 'hash_pass_11', 'Urología'),
('Dra. Carmen Soler', 'c.soler@gmail.com', 'hash_pass_12', 'Medicina Interna'),
('Dr. Sergio Ramos', 'sergio.r@gmail.com', 'hash_pass_13', 'Radiología'),
('Dra. Paula Ortiz', 'paula.o@gmail.com', 'hash_pass_14', 'Anestesiología'),
('Dr. Javier López', 'javier.l@gmail.com', 'hash_pass_15', 'Neumología'),
('Dra. Rosa Marín', 'rosa.marin@gmail.com', 'hash_pass_16', 'Hematología'),
('Dr. Pablo Duque', 'pablo.d@gmail.com', 'hash_pass_17', 'Otorrinolaringología'),
('Dra. Julia Nieto', 'julia.n@gmail.com', 'hash_pass_18', 'Nefrología'),
('Dr. Hugo Silva', 'hugo.silva@gmail.com', 'hash_pass_19', 'Cirugía General'),
('Dra. Beatriz Cano', 'b.cano@gmail.com', 'hash_pass_20', 'Infectología');
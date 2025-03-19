-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS wemakerssystem;

USE wemakerssystem;

-- Tabla para el superadministrador
CREATE TABLE superadmin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla para los roles (permite escalabilidad futura)
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255)
);

-- Tabla para los usuarios creados por el superadmin
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cedula VARCHAR(20) NOT NULL UNIQUE,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    ciudad VARCHAR(100) NOT NULL,
    pais VARCHAR(100) NOT NULL,
    genero ENUM('masculino', 'femenino', 'otro') NOT NULL,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    organizacion VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT NOT NULL, -- ID del superadmin que lo creó
    FOREIGN KEY (rol_id) REFERENCES roles(id),
    FOREIGN KEY (created_by) REFERENCES superadmin(id)
);
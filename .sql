-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS wemakerssystem;
USE wemakerssystem;

-- Tabla para el superadministrador
CREATE TABLE IF NOT EXISTS superadmin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla para los roles (permite escalabilidad futura)
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255)
);

-- Tabla para los usuarios creados por el superadmin
CREATE TABLE IF NOT EXISTS usuarios (
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

-- Tabla para los cursos
CREATE TABLE IF NOT EXISTS cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT NOT NULL,
    FOREIGN KEY (created_by) REFERENCES superadmin(id)
);

-- Tabla para los titulares (representantes)
CREATE TABLE IF NOT EXISTS titulares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cedula VARCHAR(20) NOT NULL UNIQUE,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    direccion TEXT NOT NULL,
    email VARCHAR(100),
    empresa VARCHAR(100),
    celular VARCHAR(20),
    telefono_casa VARCHAR(20),
    cargo VARCHAR(100),
    telefono_trabajo VARCHAR(20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT NOT NULL,
    FOREIGN KEY (created_by) REFERENCES usuarios(id)
);

-- Tabla para los estudiantes
CREATE TABLE IF NOT EXISTS estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cedula VARCHAR(20) NOT NULL UNIQUE,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    edad INT NOT NULL,
    curso_id INT NOT NULL,
    talla VARCHAR(10),
    titular_id INT NOT NULL,
    FOREIGN KEY (curso_id) REFERENCES cursos(id),
    FOREIGN KEY (titular_id) REFERENCES titulares(id)
);

-- Tabla para las referencias personales
CREATE TABLE IF NOT EXISTS referencias_personales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    direccion TEXT NOT NULL,
    email VARCHAR(100),
    celular VARCHAR(20),
    telefono_casa VARCHAR(20),
    empresa VARCHAR(100),
    cargo VARCHAR(100),
    telefono_trabajo VARCHAR(20),
    titular_id INT NOT NULL,
    FOREIGN KEY (titular_id) REFERENCES titulares(id)
);

-- Tabla para los contratos/pagos
CREATE TABLE IF NOT EXISTS contratos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_contrato VARCHAR(10) NOT NULL UNIQUE,
    fecha_emision DATE NOT NULL,
    mes_pagado VARCHAR(20) NOT NULL,
    forma_pago ENUM('efectivo', 'cheque', 'transferencia', 'tarjeta_credito') NOT NULL,
    banco VARCHAR(100),
    organizacion VARCHAR(100),
    cantidad_recibida DECIMAL(10,2) NOT NULL,
    verificado_por INT NOT NULL, -- ID del usuario que verifica
    ejecutivo INT NOT NULL, -- ID del usuario que ejecuta
    titular_id INT NOT NULL,
    estudiante_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (verificado_por) REFERENCES usuarios(id),
    FOREIGN KEY (ejecutivo) REFERENCES usuarios(id),
    FOREIGN KEY (titular_id) REFERENCES titulares(id),
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id)
);

-- Tabla para el control de consecutivos mensuales
CREATE TABLE IF NOT EXISTS consecutivos_mensuales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    mes VARCHAR(7) NOT NULL, -- Formato YYYY-MM
    consecutivo INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    UNIQUE KEY usuario_mes (usuario_id, mes)
);

-- Tabla para el control de consecutivos generales
CREATE TABLE IF NOT EXISTS consecutivos_generales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    consecutivo INT NOT NULL DEFAULT 1,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    UNIQUE KEY (usuario_id)
);

-- Tabla para los recibos
CREATE TABLE IF NOT EXISTS recibos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contrato_id INT NOT NULL,
    recibo_por VARCHAR(200) NOT NULL, -- Nombre y apellido del titular
    responsable_id INT NOT NULL, -- ID del usuario responsable
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contrato_id) REFERENCES contratos(id),
    FOREIGN KEY (responsable_id) REFERENCES usuarios(id)
);

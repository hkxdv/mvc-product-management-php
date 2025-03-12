-- Script para crear la base de datos en PostgreSQL
-- Debe ejecutarse como superusuario (postgres)

-- Crear base de datos si no existe
CREATE DATABASE mvc_inventario_productos
WITH
    ENCODING = 'UTF8' LC_COLLATE = 'es_ES.utf8' LC_CTYPE = 'es_ES.utf8' TEMPLATE = template0;

-- Conectarse a la base de datos creada
\c mvc_inventario_productos

-- Establecer búsqueda de esquemas
SET
    search_path TO public;

-- Crear el esquema si no existe
CREATE SCHEMA IF NOT EXISTS public;

-- Comentario sobre la base de datos
COMMENT ON DATABASE mvc_inventario_productos IS 'Base de datos para el sistema de inventario y demanda';

-- Mensaje para ejecutar el archivo de tablas
SELECT
    'Ejecuta el archivo scheme_postgresql.sql para crear las tablas y funciones';
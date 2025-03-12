<?php

/**
 * Producto.modelo.php
 * Modelo para gestionar las operaciones relacionadas con los productos
 * 
 * Este modelo solo mantiene la funcionalidad necesaria para la problemática original:
 * - Obtener todos los productos
 * - Obtener un producto por ID (utilizado en operaciones internas)
 */
class ProductoModelo extends Modelo
{
    /**
     * Obtiene todos los productos activos
     * 
     * @return array Lista de productos ordenados por nombre
     */
    static public function obtener_todos()
    {
        try {
            $stmt = Conexion::conectar()->prepare("
                SELECT * FROM productos 
                WHERE estado = 1 
                ORDER BY nombre
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener productos: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene un producto específico por su ID
     * 
     * @param integer $pk_productos ID del producto a buscar
     * @return array|null Datos del producto encontrado o null si no existe
     */
    static public function obtener_por_id($pk_productos)
    {
        try {
            $stmt = Conexion::conectar()->prepare("
                SELECT * FROM productos 
                WHERE pk_productos = :pk_productos AND estado = 1
            ");
            $stmt->bindParam(":pk_productos", $pk_productos, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener producto por ID: " . $e->getMessage());
            return null;
        }
    }
}

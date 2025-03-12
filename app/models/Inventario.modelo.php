<?php

/**
 * Inventario.modelo.php
 * Modelo para gestionar las operaciones relacionadas con el inventario de productos
 * 
 * Este modelo implementa los métodos necesarios para:
 * - Registrar/actualizar las cantidades en inventario
 * - Obtener información del inventario
 * - Verificar disponibilidad de productos
 */
class InventarioModelo extends Modelo
{
    /**
     * Registra o actualiza el inventario de un producto
     * Si el producto ya tiene inventario, lo actualiza; si no, crea un nuevo registro
     * 
     * @param integer $fk_producto ID del producto
     * @param integer $cantidad Nueva cantidad en inventario
     * @return string "ok" si la operación fue exitosa, "error" en caso contrario
     */
    static public function registrar($fk_producto, $cantidad)
    {
        try {
            $conexion = Conexion::conectar();
            
            // Verificar si ya existe un registro para este producto
            $stmt_verificar = $conexion->prepare("
                SELECT pk_inventario FROM inventario 
                WHERE fk_producto = :fk_producto AND estado = 1
            ");
            $stmt_verificar->bindParam(":fk_producto", $fk_producto, PDO::PARAM_INT);
            $stmt_verificar->execute();
            
            // Si ya existe un registro, actualizarlo
            if ($stmt_verificar->fetch(PDO::FETCH_ASSOC)) {
                return self::actualizar($fk_producto, $cantidad);
            }
            
            // Si no existe, crear uno nuevo
            $stmt = $conexion->prepare("
                INSERT INTO inventario (fk_producto, cantidad, hora, fecha, estado) 
                VALUES (:fk_producto, :cantidad, CURRENT_TIME, CURRENT_DATE, 1)
            ");

            $stmt->bindParam(":fk_producto", $fk_producto, PDO::PARAM_INT);
            $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }
        } catch (Exception $e) {
            error_log("Error al registrar inventario: " . $e->getMessage());
            return "error";
        }
    }

    /**
     * Obtiene todos los registros de inventario con información del producto
     * 
     * @return array Lista de registros de inventario con datos del producto asociado
     */
    static public function obtener_todos()
    {
        try {
            $stmt = Conexion::conectar()->prepare("
                SELECT i.*, p.nombre as nombre_producto 
                FROM inventario i
                JOIN productos p ON i.fk_producto = p.pk_productos
                WHERE i.estado = 1 AND p.estado = 1
                ORDER BY p.nombre
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al obtener inventario: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene el registro de inventario para un producto específico
     * 
     * @param integer $fk_producto ID del producto
     * @return array|null Datos del inventario o null si no existe
     */
    static public function obtener_por_producto($fk_producto)
    {
        try {
            $stmt = Conexion::conectar()->prepare("
                SELECT * FROM inventario 
                WHERE fk_producto = :fk_producto AND estado = 1
            ");
            $stmt->bindParam(":fk_producto", $fk_producto, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al obtener inventario por producto: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Actualiza la cantidad en inventario para un producto específico
     * 
     * @param integer $fk_producto ID del producto
     * @param integer $cantidad Nueva cantidad en inventario
     * @return string "ok" si la operación fue exitosa, "error" en caso contrario
     */
    static public function actualizar($fk_producto, $cantidad)
    {
        try {
            $stmt = Conexion::conectar()->prepare("
                UPDATE inventario 
                SET cantidad = :cantidad,
                    hora = CURRENT_TIME,
                    fecha = CURRENT_DATE
                WHERE fk_producto = :fk_producto AND estado = 1
            ");

            $stmt->bindParam(":fk_producto", $fk_producto, PDO::PARAM_INT);
            $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }
        } catch (Exception $e) {
            error_log("Error al actualizar inventario: " . $e->getMessage());
            return "error";
        }
    }
    
    /**
     * Verifica si hay suficiente cantidad en inventario para un producto
     * 
     * @param integer $fk_producto ID del producto
     * @param integer $cantidad_requerida Cantidad que se desea verificar
     * @return boolean true si hay cantidad suficiente, false en caso contrario
     */
    static public function verificar_disponibilidad($fk_producto, $cantidad_requerida)
    {
        try {
            $inventario = self::obtener_por_producto($fk_producto);
            
            if (!$inventario) {
                return false;
            }
            
            return $inventario['cantidad'] >= $cantidad_requerida;
        } catch (Exception $e) {
            error_log("Error al verificar disponibilidad: " . $e->getMessage());
            return false;
        }
    }
}

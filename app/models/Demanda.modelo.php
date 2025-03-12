<?php

/**
 * Demanda.modelo.php
 * Modelo para gestionar las operaciones relacionadas con la demanda de productos
 * 
 * Este modelo implementa los métodos necesarios para:
 * - Registrar/actualizar la demanda semanal
 * - Obtener información de demanda
 * - Calcular ingresos esperados
 */
class DemandaModelo extends Modelo
{
    /**
     * Registra o actualiza la demanda semanal de un producto
     * Si el producto ya tiene demanda registrada, la actualiza; si no, crea un nuevo registro
     * 
     * @param integer $fk_producto ID del producto
     * @param integer $cantidad Cantidad demandada
     * @return string "ok" si la operación fue exitosa, "error" en caso contrario
     */
    static public function registrar($fk_producto, $cantidad)
    {
        try {
            $conexion = Conexion::conectar();

            // Verificar si ya existe un registro para este producto
            $stmt_verificar = $conexion->prepare("
                SELECT pk_demanda FROM demanda 
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
                INSERT INTO demanda (fk_producto, cantidad, hora, fecha, estado) 
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
            error_log("Error al registrar demanda: " . $e->getMessage());
            return "error";
        }
    }

    /**
     * Obtiene todos los registros de demanda con información del producto
     * 
     * @return array Lista de registros de demanda con datos del producto asociado
     */
    static public function obtener_todos()
    {
        try {
            $stmt = Conexion::conectar()->prepare("
                SELECT d.*, p.nombre as nombre_producto, p.precio_venta 
                FROM demanda d
                JOIN productos p ON d.fk_producto = p.pk_productos
                WHERE d.estado = 1 AND p.estado = 1
                ORDER BY p.nombre
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al obtener demandas: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene el registro de demanda para un producto específico
     * 
     * @param integer $fk_producto ID del producto
     * @return array|null Datos de la demanda o null si no existe
     */
    static public function obtener_por_producto($fk_producto)
    {
        try {
            $stmt = Conexion::conectar()->prepare("
                SELECT * FROM demanda 
                WHERE fk_producto = :fk_producto AND estado = 1
            ");
            $stmt->bindParam(":fk_producto", $fk_producto, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al obtener demanda por producto: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Actualiza la cantidad demandada para un producto específico
     * 
     * @param integer $fk_producto ID del producto
     * @param integer $cantidad Nueva cantidad demandada
     * @return string "ok" si la operación fue exitosa, "error" en caso contrario
     */
    static public function actualizar($fk_producto, $cantidad)
    {
        try {
            $stmt = Conexion::conectar()->prepare("
                UPDATE demanda 
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
            error_log("Error al actualizar demanda: " . $e->getMessage());
            return "error";
        }
    }

    /**
     * Calcula el total de ingresos esperados basado en la demanda y precio de venta
     * Utiliza la función PL/pgSQL de PostgreSQL cuando está disponible
     * 
     * @return array Detalles de ingresos esperados por producto y total
     */
    static public function calcular_ingresos_esperados()
    {
        try {
            // Si está disponible PostgreSQL, usar sus funciones optimizadas
            if (class_exists('PostgreSQLModelo')) {
                $total = PostgreSQLModelo::calcular_ingresos_esperados();
                $detalles = self::obtener_detalles_ingresos();
                return [
                    'total' => $total,
                    'detalles' => $detalles
                ];
            }

            // Implementación en PHP sin usar función PostgreSQL
            $stmt = Conexion::conectar()->prepare("
                SELECT SUM(p.precio_venta * d.cantidad) as total
                FROM productos p
                JOIN demanda d ON p.pk_productos = d.fk_producto
                WHERE p.estado = 1 AND d.estado = 1
            ");
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Para mantener compatibilidad con el código anterior
            $detalles = self::obtener_detalles_ingresos();

            return [
                'total' => $resultado ? floatval($resultado['total']) : 0,
                'detalles' => $detalles
            ];
        } catch (Exception $e) {
            error_log("Error al calcular ingresos esperados: " . $e->getMessage());
            return [
                'total' => 0,
                'detalles' => []
            ];
        }
    }

    /**
     * Obtiene los detalles de ingresos esperados por producto
     * 
     * @return array Lista detallada de ingresos por producto
     */
    private static function obtener_detalles_ingresos()
    {
        try {
            $stmt = Conexion::conectar()->prepare("
                SELECT 
                    p.pk_productos,
                    p.nombre as producto,
                    d.cantidad as demanda,
                    p.precio_venta,
                    (p.precio_venta * d.cantidad) as ingreso_esperado
                FROM 
                    productos p
                JOIN 
                    demanda d ON p.pk_productos = d.fk_producto
                WHERE 
                    p.estado = 1 AND d.estado = 1
                ORDER BY 
                    p.nombre
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al obtener detalles de ingresos: " . $e->getMessage());
            return [];
        }
    }
}

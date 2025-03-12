<?php

/**
 * Fabrica.modelo.php
 * Modelo para gestionar las operaciones de fábrica relacionadas con inventario y producción
 * 
 * Este modelo implementa la lógica principal de la problemática:
 * - Verificar si el inventario es suficiente para cubrir la demanda
 * - Calcular la producción adicional necesaria
 */
class FabricaModelo extends Modelo
{
    /**
     * Verifica si el inventario es suficiente para cubrir la demanda
     * Utiliza la función PL/pgSQL de PostgreSQL cuando está disponible
     * 
     * @return array Resultados de la verificación con detalles para cada producto
     */
    static public function verificar_inventario()
    {
        try {
            // Usamos funciones optimizadas de PostgreSQL
            if (class_exists('PostgreSQLModelo')) {
                $resultados = PostgreSQLModelo::verificar_inventario_suficiente();
                
                // Formatear los resultados para la vista
                $resultado_formateado = [];
                foreach ($resultados as $resultado) {
                    $resultado_formateado[] = [
                        'pk_productos' => $resultado['producto_id'],
                        'producto' => $resultado['producto_nombre'],
                        'inventario' => $resultado['inventario_actual'],
                        'demanda' => $resultado['demanda_semanal'],
                        'suficiente' => $resultado['es_suficiente']
                    ];
                }
                
                return $resultado_formateado;
            }
            
            // Implementación alternativa si PostgreSQL no está disponible
            $productos = ProductoModelo::obtener_todos();
            $resultados = [];

            foreach ($productos as $producto) {
                $inventario = InventarioModelo::obtener_por_producto($producto['pk_productos']);
                $demanda = DemandaModelo::obtener_por_producto($producto['pk_productos']);

                if ($inventario && $demanda) {
                    $resultados[] = [
                        'pk_productos' => $producto['pk_productos'],
                        'producto' => $producto['nombre'],
                        'inventario' => $inventario['cantidad'],
                        'demanda' => $demanda['cantidad'],
                        'suficiente' => $inventario['cantidad'] >= $demanda['cantidad']
                    ];
                }
            }

            return $resultados;
        } catch (Exception $e) {
            error_log("Error al verificar inventario: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Calcula la cantidad adicional que debe producirse cuando el inventario es insuficiente
     * Utiliza la función PL/pgSQL de PostgreSQL cuando está disponible
     * 
     * @return array Resultados con la producción adicional necesaria para cada producto
     */
    static public function calcular_produccion_adicional()
    {
        try {
            // Usamos funciones optimizadas de PostgreSQL
            if (class_exists('PostgreSQLModelo')) {
                $resultados = PostgreSQLModelo::calcular_produccion_adicional();
                
                // Formatear los resultados para la vista
                $resultado_formateado = [];
                foreach ($resultados as $resultado) {
                    if ($resultado['produccion_necesaria'] > 0) {
                        $resultado_formateado[] = [
                            'pk_productos' => $resultado['producto_id'],
                            'producto' => $resultado['producto_nombre'],
                            'cantidad_adicional' => $resultado['produccion_necesaria'],
                            'costo_total' => $resultado['costo_produccion']
                        ];
                    }
                }
                
                return $resultado_formateado;
            }
            
            // Implementación alternativa si PostgreSQL no está disponible
            $productos = ProductoModelo::obtener_todos();
            $produccion_adicional = [];

            foreach ($productos as $producto) {
                $inventario = InventarioModelo::obtener_por_producto($producto['pk_productos']);
                $demanda = DemandaModelo::obtener_por_producto($producto['pk_productos']);

                if ($inventario && $demanda && $demanda['cantidad'] > $inventario['cantidad']) {
                    $cantidad_adicional = $demanda['cantidad'] - $inventario['cantidad'];
                    $costo_total = $producto['costo_produccion'] * $cantidad_adicional;
                    
                    $produccion_adicional[] = [
                        'pk_productos' => $producto['pk_productos'],
                        'producto' => $producto['nombre'],
                        'cantidad_adicional' => $cantidad_adicional,
                        'costo_total' => $costo_total
                    ];
                }
            }

            return $produccion_adicional;
        } catch (Exception $e) {
            error_log("Error al calcular producción adicional: " . $e->getMessage());
            return [];
        }
    }

    // Registrar producción adicional
    static public function registrar_produccion_adicional($fk_producto, $cantidad)
    {
        try {
            $conexion = Conexion::conectar();
            
            // Iniciar transacción
            $conexion->beginTransaction();
            
            $stmt = $conexion->prepare("
                INSERT INTO produccion_adicional (fk_producto, cantidad, hora, fecha, estado) 
                VALUES (:fk_producto, :cantidad, CURRENT_TIME, CURRENT_DATE, 1)
            ");

            $stmt->bindParam(":fk_producto", $fk_producto, PDO::PARAM_INT);
            $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Actualizar inventario
                $inventario = InventarioModelo::obtener_por_producto($fk_producto);

                if ($inventario) {
                    $nueva_cantidad = $inventario['cantidad'] + $cantidad;
                    $resultado = InventarioModelo::actualizar($fk_producto, $nueva_cantidad);
                    
                    if ($resultado === "ok") {
                        $conexion->commit();
                        return "ok";
                    } else {
                        $conexion->rollBack();
                        return "error";
                    }
                }
                
                $conexion->commit();
                return "ok";
            } else {
                $conexion->rollBack();
                return "error";
            }
        } catch (Exception $e) {
            if (isset($conexion)) {
                $conexion->rollBack();
            }
            error_log("Error al registrar producción adicional: " . $e->getMessage());
            return "error";
        }
    }

    // Ejecutar el proceso completo de verificación y producción adicional
    static public function ejecutar_proceso_completo()
    {
        // Si existe PostgreSQLModelo, usamos su método optimizado
        if (class_exists('PostgreSQLModelo')) {
            return PostgreSQLModelo::ejecutar_calculo_completo();
        }
        
        // De lo contrario, implementamos la lógica aquí
        try {
            $produccion_necesaria = self::calcular_produccion_adicional();
            
            if (empty($produccion_necesaria)) {
                return "no_necesario"; // No es necesaria producción adicional
            }
            
            $conexion = Conexion::conectar();
            $conexion->beginTransaction();
            
            foreach ($produccion_necesaria as $item) {
                $stmt = $conexion->prepare("
                    INSERT INTO produccion_adicional (fk_producto, cantidad, hora, fecha, estado) 
                    VALUES (:fk_producto, :cantidad, CURRENT_TIME, CURRENT_DATE, 1)
                ");
                
                $stmt->bindParam(":fk_producto", $item['pk_productos'], PDO::PARAM_INT);
                $stmt->bindParam(":cantidad", $item['produccion_necesaria'], PDO::PARAM_INT);
                $stmt->execute();
                
                // Actualizar inventario
                $inventario = InventarioModelo::obtener_por_producto($item['pk_productos']);
                
                if ($inventario) {
                    $nueva_cantidad = $inventario['cantidad'] + $item['produccion_necesaria'];
                    $stmt = $conexion->prepare("
                        UPDATE inventario 
                        SET cantidad = :cantidad,
                            hora = CURRENT_TIME,
                            fecha = CURRENT_DATE
                        WHERE fk_producto = :fk_producto AND estado = 1
                    ");
                    
                    $stmt->bindParam(":fk_producto", $item['pk_productos'], PDO::PARAM_INT);
                    $stmt->bindParam(":cantidad", $nueva_cantidad, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
            
            $conexion->commit();
            return "ok";
        } catch (Exception $e) {
            if (isset($conexion)) {
                $conexion->rollBack();
            }
            error_log("Error al ejecutar proceso completo: " . $e->getMessage());
            return "error: " . $e->getMessage();
        }
    }
}

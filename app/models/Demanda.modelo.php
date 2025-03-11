<?php

class DemandaModelo extends Modelo
{
    // Registrar demanda para un producto
    static public function registrar($id_producto, $cantidad)
    {
        // Primero verificamos si ya existe demanda para este producto
        $demanda = self::obtener_por_producto($id_producto);
        
        if ($demanda) {
            // Si existe, actualizamos la cantidad
            return self::actualizar($id_producto, $cantidad);
        } else {
            // Si no existe, creamos un nuevo registro
            $stmt = Conexion::conectar()->prepare("INSERT INTO demanda (fk_producto, cantidad) VALUES (:id_producto, :cantidad)");
            
            $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
            $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }
        }
    }
    
    // Actualizar demanda para un producto
    static public function actualizar($id_producto, $cantidad)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE demanda SET cantidad = :cantidad WHERE fk_producto = :id_producto");
        
        $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
        $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }
    
    // Obtener demanda por producto
    static public function obtener_por_producto($id_producto)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM demanda WHERE fk_producto = :id_producto");
        $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Obtener todas las demandas
    static public function obtener_todos()
    {
        $stmt = Conexion::conectar()->prepare("
            SELECT d.pk_demanda, p.nombre as producto, d.cantidad, p.pk_productos as id_producto
            FROM demanda d
            JOIN productos p ON d.fk_producto = p.pk_productos
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Calcular ingresos esperados
    static public function calcular_ingresos_esperados($productos = null)
    {
        if ($productos === null) {
            $productos = ProductoModelo::obtener_todos();
        }
        
        $ingresos_totales = 0;
        $detalles_ingresos = [];
        
        foreach ($productos as $producto) {
            $demanda = self::obtener_por_producto($producto['pk_productos']);
            
            if ($demanda) {
                
                // Fórmula: Ingreso Producto = Demanda * Precio de Venta
                $ingreso_producto = $demanda['cantidad'] * $producto['precio_venta'];
                $ingresos_totales += $ingreso_producto;
                
                $detalles_ingresos[] = [
                    'id_producto' => $producto['pk_productos'],
                    'producto' => $producto['nombre'],
                    'demanda' => $demanda['cantidad'],
                    'precio_venta' => $producto['precio_venta'],
                    'ingreso_esperado' => $ingreso_producto
                ];
            }
        }
        
        return [
            'total' => $ingresos_totales,
            'detalles' => $detalles_ingresos
        ];
    }
}
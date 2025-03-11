<?php

class InventarioModelo extends Modelo
{
    // Registrar inventario para un producto
    static public function registrar($id_producto, $cantidad)
    {
        // Primero verificamos si ya existe inventario para este producto
        $inventario = self::obtener_por_producto($id_producto);

        if ($inventario) {
            // Si existe, actualizamos la cantidad
            return self::actualizar($id_producto, $cantidad);
        } else {
            // Si no existe, creamos un nuevo registro
            $stmt = Conexion::conectar()->prepare("INSERT INTO inventario (fk_producto, cantidad) VALUES (:id_producto, :cantidad)");

            $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
            $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }
        }
    }

    // Actualizar inventario para un producto
    static public function actualizar($id_producto, $cantidad)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE inventario SET cantidad = :cantidad WHERE fk_producto = :id_producto");

        $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
        $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    // Obtener inventario por producto
    static public function obtener_por_producto($id_producto)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM inventario WHERE fk_producto = :id_producto");
        $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener todo el inventario
    static public function obtener_todos()
    {
        $stmt = Conexion::conectar()->prepare("
            SELECT i.pk_inventario, p.nombre as producto, i.cantidad, p.pk_productos as id_producto
            FROM inventario i
            JOIN productos p ON i.fk_producto = p.pk_productos
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verificar disponibilidad de un producto
    static public function verificar_disponibilidad($id_producto, $cantidad)
    {
        $inventario = self::obtener_por_producto($id_producto);

        if ($inventario && $inventario['cantidad'] >= $cantidad) {
            return true;
        } else {
            return false;
        }
    }
}

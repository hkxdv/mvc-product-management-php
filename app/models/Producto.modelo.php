<?php

class ProductoModelo extends Modelo
{
    // Registrar un nuevo producto
    static public function registrar($datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO productos (nombre, costo_produccion, precio_venta) VALUES (:nombre, :costo, :precio)");

        $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(":costo", $datos['costo_produccion'], PDO::PARAM_STR);
        $stmt->bindParam(":precio", $datos['precio_venta'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    // Obtener todos los productos
    static public function obtener_todos()
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM productos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un producto por ID
    static public function obtener_por_id($id)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM productos WHERE pk_productos = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar un producto
    static public function actualizar($id, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE productos SET nombre = :nombre, costo_produccion = :costo, precio_venta = :precio WHERE pk_productos = :id");

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(":costo", $datos['costo_produccion'], PDO::PARAM_STR);
        $stmt->bindParam(":precio", $datos['precio_venta'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    // Eliminar un producto
    static public function eliminar($id)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM productos WHERE pk_productos = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }
}

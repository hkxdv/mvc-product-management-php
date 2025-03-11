<?php

class Modelo extends Conexion
{
    // Método base para obtener todos los registros de una tabla
    static public function obtener_todos_modelo($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método base para obtener un registro específico
    static public function obtener_por_id_modelo($tabla, $columna, $valor)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $columna = :valor");
        $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método base para eliminar un registro
    static public function eliminar_modelo($tabla, $columna, $valor)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $columna = :valor");
        $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }
}
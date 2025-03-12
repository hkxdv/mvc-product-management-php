<?php

/**
 * Principal.modelo.php
 * Clase base para operaciones CRUD en la base de datos
 * 
 * Proporciona métodos genéricos para manipular datos en cualquier tabla
 * con funcionalidades básicas de lectura y eliminación de registros.
 */
class Modelo extends Conexion
{
    /**
     * Obtiene todos los registros de una tabla específica
     * 
     * @param string $tabla Nombre de la tabla en la base de datos
     * @return array Arreglo con todos los registros encontrados
     */
    static public function obtener_todos_modelo($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un registro específico basado en un criterio de búsqueda
     * 
     * @param string $tabla Nombre de la tabla en la base de datos
     * @param string $columna Nombre de la columna para la condición WHERE
     * @param mixed $valor Valor a buscar en la columna especificada
     * @return array|bool Datos del registro encontrado o false si no existe
     */
    static public function obtener_por_id_modelo($tabla, $columna, $valor)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $columna = :valor");
        $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Elimina un registro específico de una tabla
     * 
     * @param string $tabla Nombre de la tabla en la base de datos
     * @param string $columna Nombre de la columna para la condición WHERE
     * @param mixed $valor Valor a buscar en la columna especificada
     * @return string "ok" si la eliminación fue exitosa, "error" en caso contrario
     */
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
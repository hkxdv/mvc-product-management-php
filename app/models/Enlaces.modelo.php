<?php

class Paginas extends Conexion
{
    // Método estático para obtener la ruta de un módulo desde la base de datos
    static public function enlaces_paginas_modelo($enlace)
    {
        try {
            // Obtener la conexión a la base de datos
            $conexion = Conexion::conectar();
            
            // Preparar la consulta para obtener la ruta del módulo
            $stmt = $conexion->prepare("SELECT ruta FROM enlaces WHERE nombre = :nombre AND estado = 1");
            
            // Vinculamos el parámetro ":nombre" con el valor del enlace
            $stmt->bindParam(":nombre", $enlace, PDO::PARAM_STR);
            
            // Ejecutamos la consulta
            $stmt->execute();
            
            // Verificamos si se encontró un registro
            if ($renglon = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $modulo = $renglon["ruta"];
            } else {
                $modulo = "app/views/components/404_pagenotfound.php";
            }
            return $modulo;
        } catch (PDOException $e) {
            return "app/views/components/404_pagenotfound.php";
        }
    }
}
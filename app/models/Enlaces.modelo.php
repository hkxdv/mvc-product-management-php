<?php
/**
 * Enlaces.modelo.php
 * Modelo para gestionar los enlaces y rutas de la aplicaci?n
 * 
 * Esta clase proporciona m?todos para obtener las rutas de los m?dulos
 * desde la base de datos, facilitando la navegaci?n din?mica en la aplicaci?n.
 */
class Paginas extends Conexion
{
    /**
     * Obtiene la ruta de un m?dulo desde la base de datos
     * 
     * Busca en la tabla 'enlaces' la ruta correspondiente al nombre
     * del enlace proporcionado. Si no existe o hay un error, devuelve
     * la p?gina de error 404.
     * 
     * @param string $enlace Nombre del enlace a buscar
     * @return string Ruta del archivo del m?dulo
     */
    static public function enlaces_paginas_modelo($enlace)
    {
        try {
            // Obtener la conexi?n a la base de datos
            $conexion = Conexion::conectar();
            
            // Preparar la consulta para obtener la ruta del m?dulo
            $stmt = $conexion->prepare("SELECT ruta FROM enlaces WHERE nombre = :nombre AND estado = 1");
            
            // Vinculamos el par?metro ":nombre" con el valor del enlace
            $stmt->bindParam(":nombre", $enlace, PDO::PARAM_STR);
            
            // Ejecutamos la consulta
            $stmt->execute();
            
            // Verificamos si se encontr? un registro
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
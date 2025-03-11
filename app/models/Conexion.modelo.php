<?php

class Conexion
{
    static public function conectar()
    {
        try {
            $link = new PDO("mysql:host=localhost;dbname=mvc_inventario_productos;charset=utf8", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $link;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
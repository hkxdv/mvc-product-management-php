<?php

/**
 * index.php
 * Punto de entrada principal de la aplicación
 * 
 * Este archivo realiza la carga de todas las dependencias necesarias para
 * el funcionamiento de la aplicación MVC y ejecuta el controlador principal.
 */

// Configuración de alias
require_once("config/alias.config.php");

// Carga de modelos
require_once("app/models/Conexion.modelo.php");
require_once("app/models/Enlaces.modelo.php");
require_once("app/models/Principal.modelo.php");
require_once("app/models/Producto.modelo.php");
require_once("app/models/Inventario.modelo.php");
require_once("app/models/Demanda.modelo.php");
require_once("app/models/Fabrica.modelo.php");
require_once("app/models/PostgreSQL.modelo.php");

// Carga de controladores
require_once("app/controllers/Alertas.controlador.php");
require_once("app/controllers/Principal.controlador.php");

// Iniciar la aplicación
Controlador::pagina();

?>
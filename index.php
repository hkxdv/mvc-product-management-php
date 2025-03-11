<?php

require_once("config/alias.config.php");

require_once("app/models/Conexion.modelo.php");
require_once("app/models/Enlaces.modelo.php");
require_once("app/models/Principal.modelo.php");
require_once("app/models/Producto.modelo.php");
require_once("app/models/Inventario.modelo.php");
require_once("app/models/Demanda.modelo.php");
require_once("app/models/Fabrica.modelo.php");

require_once("app/controllers/Alertas.controlador.php");
require_once("app/controllers/Principal.controlador.php");

Controlador::pagina();

?>

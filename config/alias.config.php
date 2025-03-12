<?php

/**
 * Configuración de alias para rutas
 * Define constantes y rutas base para toda la aplicación
 */

// Definición de ruta base
define('URL_BASE', 'http://localhost/mvc_inventario_productos/');
define('PATH_BASE', __DIR__ . '/..');

/**
 * Definición de alias para rutas del sistema 
 * Facilita el acceso a diferentes secciones y recursos
 */
define('ALIASES', [


    // Rutas de recursos (URLs)
    '@img' => URL_BASE . 'assets/img',
    '@js' => URL_BASE . 'assets/js',
    '@css' => URL_BASE . 'assets/css',
    '@fonts' => URL_BASE . 'assets/fonts',

    // Rutas de archivos (filesystem paths)
    '@Componentes' => PATH_BASE . '/app/views/components/componentes.php',
    '@Menu' => PATH_BASE . '/app/views/components/menu.php',
    '@Pie_pagina' => PATH_BASE . '/app/views/components/pie_pagina.php'


]);

/**
 * Función helper para resolver rutas usando alias
 * 
 * @param string $ruta Ruta con alias a resolver
 * @return string Ruta completa resuelta
 */
function aliasPath($ruta)
{
    // Iterar sobre los alias definidos y resolver la ruta
    foreach (ALIASES as $alias => $valor) {

        // Verificar si la ruta comienza con el alias
        if (strpos($ruta, $alias) === 0) {

            // Reemplazar el alias con su valor correspondiente
            return str_replace($alias, $valor, $ruta);
        }
    }
    return $ruta;
}

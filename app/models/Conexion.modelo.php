<?php
/**
 * Conexion.modelo.php
 * Clase para gestionar la conexión a la base de datos PostgreSQL
 * 
 * Esta clase se encarga de establecer la conexión con la base de datos
 * utilizando variables de entorno para mayor seguridad y flexibilidad.
 */

// Cargar el autoloader de Composer
require_once __DIR__ . '/../../vendor/autoload.php';

// Cargar variables de entorno con phpdotenv
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

class Conexion
{
    /**
     * Establece y devuelve una conexión a la base de datos PostgreSQL
     * 
     * Utiliza las variables de entorno para configurar la conexión.
     * Incluye manejo de errores para capturar y reportar fallos en la conexión.
     * 
     * @return PDO|null Objeto PDO con la conexión o null en caso de error
     */
    static public function conectar()
    {
        try {
            // Obtener configuración desde variables de entorno
            $host = $_ENV['DB_HOST'];
            $dbname = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];
            $port = $_ENV['DB_PORT'] ?? '5432';

            // DSN para PostgreSQL
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

            // Conexión con PostgreSQL
            $link = new PDO($dsn, $user, $password);

            // Configuración de errores y de codificación UTF-8
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $link->exec("SET NAMES 'UTF8'");

            return $link;
        } catch (PDOException $e) {
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            echo "Error de conexión: " . $e->getMessage();
            return null;
        }
    }
}

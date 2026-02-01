<?php
namespace Tools;
use PDO;
use PDOException;

/**
 * Clase Conexion - Gestiona la conexión a la base de datos
 * 
 * Lee la configuración desde config/config.ini
 * Asegúrate de configurar correctamente los datos de conexión en ese archivo
 */
class Conexion
{
    private static $conexion = null;

    public static function getConexion()
    {
        if (self::$conexion === null) {
            // Lee la configuración desde config.ini
            $config = parse_ini_file(__DIR__ . '/../config/config.ini', true);
            if ($config === false || !isset($config['database'])) {
                throw new \RuntimeException('No se pudo leer el archivo de configuración config.ini');
            }
            $db = $config['database'];
            $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset={$db['charset']}";
            try {
                self::$conexion = new PDO($dsn, $db['user'], $db['password']);
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new \RuntimeException('Error de conexión: ' . $e->getMessage());
            }
        }
        return self::$conexion;
    }
}
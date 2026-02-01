<?php
namespace Tools;
use PDO;
use PDOException;

class Conexion
{
    private static $conexion = null;

    public static function getConexion()
    {
        if (self::$conexion === null) {
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
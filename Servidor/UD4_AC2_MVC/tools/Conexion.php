<?php
class Conexion
{
    private static ?PDO $pdo = null;

    public static function getConexion(): PDO
    {
        if (self::$pdo === null) {
            $config = parse_ini_file(__DIR__ . '/../config/config.ini');
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";

            try {
                self::$pdo = new PDO($dsn, $config['user'], $config['password']);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}

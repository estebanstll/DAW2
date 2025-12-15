<?php
// tools/Conexion.php

class Conexion
{
    public static function getConexion(): PDO
    {
        // Datos directos de conexión solicitados
        $driver = "mysql";
        $host = "localhost";
        $dbname = "dwes";
        $port = 3306;
        $user = "root";
        $pass = "mysql";

        // DSN con charset
        $dsn = "$driver:host=$host;dbname=$dbname;port=$port;charset=utf8mb4";

        try {
            $pdo = new PDO($dsn, $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;

        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}

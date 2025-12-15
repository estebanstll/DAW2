<?php
// conexion bbdd
class Conexion {
    // Datos de conexión
    private $host = "localhost";
    private $usr = "root";
    private $pswd = "mysql";
    private $baseDatos = "hobbies";
    private PDO $conexion;

    // Constr
    public function __construct() {
        try {
            $this->conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->baseDatos}",
                $this->usr,
                $this->pswd
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("No se ha conectado bn: " . $e->getMessage());
        }
    }

    // Metdo para obtener la conexion
    public function obtenerConexion(): PDO {
        return $this->conexion;
    }
}
?>

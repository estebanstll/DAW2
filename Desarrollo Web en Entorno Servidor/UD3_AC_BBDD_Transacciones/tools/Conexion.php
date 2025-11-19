<?php
class Conexion {
    private $servername = "localhost";
    private $username = "root";
    private $password = "mysql";
    private $dbname = "hobbies";
    private PDO $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->servername};dbname={$this->dbname}",
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function getPDO(): PDO {
        return $this->pdo;
    }
}
?>

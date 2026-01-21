<?php
namespace Acme\IntranetRestaurante\Model;

use Ol\Tools\Conexion;
use PDO;

class Categoria {
    private $CodCat;
    private $Nombre;
    private $Descripcion;

    public function getCodCat() { return $this->CodCat; }
    public function getNombre() { return $this->Nombre; }
    public function getDescripcion() { return $this->Descripcion; }

    public static function todas() {
        $pdo = Conexion::getConexion();
        $stmt = $pdo->query("SELECT * FROM categoria");
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function buscarPorId($codCat) {
        $pdo = Conexion::getConexion();
        $stmt = $pdo->prepare("SELECT * FROM categoria WHERE CodCat = :cod");
        $stmt->execute([':cod' => $codCat]);
        return $stmt->fetchObject(self::class);
    }
}
?>
<?php
namespace Acme\IntranetRestaurante\Model;

use Ol\Tools\Conexion;
use PDO;

class Producto {
    private $CodProd;
    private $Nombre;
    private $Descripcion;
    private $Peso;
    private $Stock;
    private $Categoria;

    public function getCodProd() { return $this->CodProd; }
    public function getNombre() { return $this->Nombre; }
    public function getDescripcion() { return $this->Descripcion; }
    public function getPeso() { return $this->Peso; }
    public function getStock() { return $this->Stock; }

    public static function productosDeCategoria($codCat) {
        $pdo = Conexion::getConexion();
        $stmt = $pdo->prepare("SELECT * FROM producto WHERE Categoria = :codCat");
        $stmt->execute([':codCat' => $codCat]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function buscarPorId($codProd) {
        $pdo = Conexion::getConexion();
        $stmt = $pdo->prepare("SELECT * FROM producto WHERE CodProd = :cod");
        $stmt->execute([':cod' => $codProd]);
        return $stmt->fetchObject(self::class);
    }
}
?>
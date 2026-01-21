<?php
namespace Acme\IntranetRestaurante\Model;

use PDO;

class LineaPedido {
    private $CodPed;
    private $CodProd;
    private $Unidades;

    public function __construct($codPed, $codProd, $unidades) {
        $this->CodPed = $codPed;
        $this->CodProd = $codProd;
        $this->Unidades = $unidades;
    }

    public function getCodProd() { return $this->CodProd; }
    public function getUnidades() { return $this->Unidades; }
    public function setCodPed($codPed) { $this->CodPed = $codPed; }

    public function guardar(PDO $pdo) {
        $sql = "INSERT INTO pedidosproductos (Pedido, Producto, Unidades) VALUES (:ped, :prod, :uni)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':ped' => $this->CodPed,
            ':prod' => $this->CodProd,
            ':uni' => $this->Unidades
        ]);
    }
}
?>
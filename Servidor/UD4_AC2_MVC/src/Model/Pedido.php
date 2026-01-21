<?php
namespace Acme\IntranetRestaurante\Model;

use Ol\Tools\Conexion;
use PDO;
use Exception;

class Pedido {
    private $Restaurante;
    private $Fecha;
    private $Enviado;
    private $lineas = [];

    public function __construct($codRes) {
        $this->Restaurante = $codRes;
        $this->Fecha = date("Y-m-d H:i:s");
        $this->Enviado = 0;
    }

    public function anadirLinea(LineaPedido $linea) {
        $this->lineas[] = $linea;
    }

    public function guardar() {
        $pdo = Conexion::getConexion();
        try {
            $pdo->beginTransaction();

            $sql = "INSERT INTO pedido (Fecha, Enviado, Restaurante) VALUES (:fecha, :env, :res)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':fecha' => $this->Fecha,
                ':env' => $this->Enviado,
                ':res' => $this->Restaurante
            ]);

            $idPedido = $pdo->lastInsertId();

            foreach ($this->lineas as $linea) {
                $sqlLinea = "INSERT INTO pedidosproductos (Pedido, Producto, Unidades) VALUES (:ped, :prod, :uni)";
                $stmtLinea = $pdo->prepare($sqlLinea);
                $stmtLinea->execute([
                    ':ped' => $idPedido,
                    ':prod' => $linea->getCodProd(),
                    ':uni' => $linea->getUnidades()
                ]);

                $sqlUpdate = "UPDATE producto SET Stock = Stock - :uni WHERE CodProd = :prod";
                $stmtUpdate = $pdo->prepare($sqlUpdate);
                $stmtUpdate->execute([
                    ':uni' => $linea->getUnidades(),
                    ':prod' => $linea->getCodProd()
                ]);
            }

            $pdo->commit();
            return $idPedido;

        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
?>
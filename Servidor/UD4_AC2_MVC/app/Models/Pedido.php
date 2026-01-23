<?php

namespace App\Models;

use Tools\Conexion;
use PDOException;

class Pedido
{
    private ?int $identificador = null;
    private ?string $marcaTiempo = null;
    private bool $remitido = false;
    private ?int $idRestaurante = null;
    private array $itemsPedido = [];

    public function __construct($remitido = false, $idRestaurante = null)
    {
        $this->remitido = $remitido;
        $this->idRestaurante = $idRestaurante;
    }

    public function obtenerId(): ?int
    {
        return $this->identificador;
    }

    public function asignarId($id): void
    {
        $this->identificador = $id;
    }

    public function obtenerRemitido(): bool
    {
        return $this->remitido;
    }

    public function asignarRemitido($remitido): void
    {
        $this->remitido = $remitido;
    }

    public function obtenerIdRestaurante(): ?int
    {
        return $this->idRestaurante;
    }

    public function asignarIdRestaurante($id): void
    {
        $this->idRestaurante = $id;
    }

    public function obtenerLineas(): array
    {
        return $this->itemsPedido;
    }

    public function insertarLinea($linea): void
    {
        $this->itemsPedido[] = $linea;
    }

    public function guardar(Pedido $pedido): int
    {
        $bd = Conexion::getConexion();
        $bd->beginTransaction();

        try {
            $consulta = "INSERT INTO pedidos (Enviado, Restaurante) VALUES (:remitido, :idRestaurante)";
            $stmt = $bd->prepare($consulta);
            $stmt->bindParam(":remitido", $pedido->obtenerRemitido());
            $stmt->bindParam(":idRestaurante", $pedido->obtenerIdRestaurante());
            $stmt->execute();

            $idPedido = $bd->lastInsertId();

            foreach ($pedido->obtenerLineas() as $linea) {
                $linea->asignarIdPedido($idPedido);
                
                $sql = "INSERT INTO pedidosproductos (Pedido, Producto, Unidades) VALUES (:idPedido, :idProducto, :cantidad)";
                $stmt2 = $bd->prepare($sql);
                $stmt2->bindParam(":idPedido", $idPedido);
                $stmt2->bindParam(":idProducto", $linea->obtenerCodigoProd());
                $stmt2->bindParam(":cantidad", $linea->obtenerUnidades());
                
                if (!$stmt2->execute()) {
                    throw new \Exception("Error al guardar línea");
                }
            }

            $bd->commit();
            return $idPedido;

        } catch (\Exception $e) {
            if ($bd->inTransaction()) {
                $bd->rollBack();
            }
            die("Error SQL: " . $e->getMessage());
        }
    }
}

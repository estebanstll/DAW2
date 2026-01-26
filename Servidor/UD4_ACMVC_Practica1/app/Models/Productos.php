<?php

namespace App\Models;

use JsonSerializable;
use Tools\Conexion;


class Productos implements JsonSerializable{

    private ?int $id;
    private string $nombre;
    private int $cantidad;

    public function __construct(?int $id, string $nombre, int $cantidad) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->cantidad = $cantidad;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $value): void {
        $this->id = $value;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $value): void {
        $this->nombre = $value;
    }

    public function getCantidad(): int {
        return $this->cantidad;
    }

    public function setCantidad(int $value): void {
        $this->cantidad = $value;
    }

    public static function getAll(): array {
        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM productos";
        $stmt = $bd->prepare($consulta);
        $stmt->execute();
        
        $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $productos = [];
        
        foreach ($resultados as $fila) {
            $productos[] = new self(
                (int)$fila['id'],
                $fila['nombre'],
                (int)$fila['cantidad']
            );
        }

        return $productos;
    }

    public static function getById(int $id): ?self {
        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM productos WHERE id = :id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();

        $fila = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$fila) {
            return null;
        }

        return new self((int)$fila['id'], $fila['nombre'], (int)$fila['cantidad']);
    }

    public static function create(self $producto): bool {
        $bd = Conexion::getConexion();
        $consulta = "INSERT INTO productos (nombre, cantidad) VALUES (:nombre, :cantidad)";
        $stmt = $bd->prepare($consulta);
        $stmt->bindValue(":nombre", $producto->getNombre());
        $stmt->bindValue(":cantidad", $producto->getCantidad(), \PDO::PARAM_INT);
        $ok = $stmt->execute();

        if ($ok) {
            $producto->setId((int)$bd->lastInsertId());
        }

        return $ok;
    }

    public static function update(self $producto): bool {
        if ($producto->getId() === null) {
            return false;
        }

        $bd = Conexion::getConexion();
        $consulta = "UPDATE productos SET nombre = :nombre, cantidad = :cantidad WHERE id = :id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindValue(":nombre", $producto->getNombre());
        $stmt->bindValue(":cantidad", $producto->getCantidad(), \PDO::PARAM_INT);
        $stmt->bindValue(":id", $producto->getId(), \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function delete(int $id): bool {
        $bd = Conexion::getConexion();
        $consulta = "DELETE FROM productos WHERE id = :id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'cantidad' => $this->cantidad
        ];
    }
}
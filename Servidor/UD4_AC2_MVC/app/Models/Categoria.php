<?php

namespace App\Models;

use Tools\Conexion;
use RuntimeException;

class Categoria
{
    private ?int $identificador;
    private ?string $titulo;
    private ?string $detalle;

    public function __construct(?string $titulo = null, ?string $detalle = null)
    {
        $this->identificador = null;
        $this->titulo = $titulo;
        $this->detalle = $detalle;
    }

    public function asignarId(int $id): void
    {
        $this->identificador = $id;
    }

    public function obtenerId(): ?int
    {
        return $this->identificador;
    }

    public function asignarTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    public function obtenerTitulo(): ?string
    {
        return $this->titulo;
    }

    public function asignarDetalle(string $detalle): void
    {
        $this->detalle = $detalle;
    }

    public function obtenerDetalle(): ?string
    {
        return $this->detalle;
    }

    public function __toString(): string
    {
        return (string) $this->titulo;
    }

    public static function obtenerTodas(): array
    {
        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM categorias";
        $stmt = $bd->prepare($consulta);
        $stmt->execute();

        $resultado = [];
        foreach ($stmt->fetchAll() as $row) {
            $cat = new self($row["Nombre"], $row["Descripcion"]);
            $cat->asignarId($row["CodCat"]);
            $resultado[] = $cat;
        }

        return $resultado;
    }

    public static function buscarPorIdentificador(int $id): Categoria
    {
        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM categorias WHERE CodCat = :id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch();

        if (!$row) {
            throw new RuntimeException("Categoría no encontrada");
        }

        $cat = new self($row["Nombre"], $row["Descripcion"]);
        $cat->asignarId($row["CodCat"]);

        return $cat;
    }
}

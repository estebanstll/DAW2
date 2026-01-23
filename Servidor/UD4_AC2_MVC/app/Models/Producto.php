<?php

namespace App\Models;

use Tools\Conexion;
use PDO;

class Producto
{
    private ?int $identificador;
    private ?string $titulo;
    private ?string $detalles;
    private ?float $masa;
    private ?int $existencias;
    private ?int $grupoCategoria;

    public function __construct(
        ?string $titulo = null,
        ?string $detalles = null,
        ?float $masa = null,
        ?int $existencias = null,
        ?int $grupoCategoria = null
    ) {
        $this->titulo = $titulo;
        $this->detalles = $detalles;
        $this->masa = $masa;
        $this->existencias = $existencias;
        $this->grupoCategoria = $grupoCategoria;
    }

    public function obtenerId(): ?int
    {
        return $this->identificador;
    }

    public function asignarId($id): void
    {
        $this->identificador = $id;
    }

    public function obtenerTitulo(): ?string
    {
        return $this->titulo;
    }

    public function asignarTitulo($titulo): void
    {
        $this->titulo = $titulo;
    }

    public function obtenerDetalles(): ?string
    {
        return $this->detalles;
    }

    public function asignarDetalles($detalles): void
    {
        $this->detalles = $detalles;
    }

    public function obtenerMasa(): ?float
    {
        return $this->masa;
    }

    public function asignarMasa($masa): void
    {
        $this->masa = $masa;
    }

    public function obtenerExistencias(): ?int
    {
        return $this->existencias;
    }

    public function asignarExistencias($existencias): void
    {
        $this->existencias = $existencias;
    }

    public function obtenerCategoria(): ?int
    {
        return $this->grupoCategoria;
    }

    public function asignarCategoria($categoria): void
    {
        $this->grupoCategoria = $categoria;
    }

    public function __toString(): string
    {
        return $this->titulo;
    }

    public function obtenerPorCategoria(int $grupoId): array
    {
        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM productos WHERE Categoria = :grupoId";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":grupoId", $grupoId);
        $stmt->execute();

        $resultado = [];
        foreach ($stmt->fetchAll() as $row) {
            $prod = new Producto($row["Nombre"], $row["Descripcion"], $row["Peso"], $row["Stock"], $row["Categoria"]);
            $prod->asignarId($row["CodProd"]);
            $resultado[] = $prod;
        }

        return $resultado;
    }

    public function buscarPorId(int $id): ?Producto
    {
        $consulta = "SELECT * FROM productos WHERE CodProd = :id";
        $stmt = Conexion::getConexion()->prepare($consulta);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $prod = new Producto($row["Nombre"], $row["Descripcion"], $row["Peso"], $row["Stock"], $row["Categoria"]);
        $prod->asignarId($row["CodProd"]);
        return $prod;
    }

    public function actualizarStock(int $id, int $cantidad): bool
    {
        $bd = Conexion::getConexion();
        $consulta = "UPDATE productos SET Stock = Stock - :cantidad WHERE CodProd = :id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":cantidad", $cantidad);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}

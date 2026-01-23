<?php

namespace App\Models;

use Tools\Conexion;
use RuntimeException;

class Categoria
{
    private ?int $codCat = null;
    private ?string $nombre = null;
    private ?string $descripcion = null;

    public function __construct(?string $nombre = null, ?string $descripcion = null){
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    public function getCodCat(): ?int {
        return $this->codCat;
    }

    public function setCodCat(int $codCat): void {
        $this->codCat = $codCat;
    }

    public function getNombre(): ?string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getDescripcion(): ?string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function __toString(): string {
        return (string) $this->nombre;
    }

    public static function todas(): array {
        $conexion = Conexion::getConexion();

        $sql = "SELECT * FROM categorias";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        $categorias = [];
        foreach ($stmt->fetchAll() as $fila) {
            $cat = new Categoria(
                $fila['Nombre'],
                $fila['Descripcion']
            );
            $cat->setCodCat($fila['CodCat']);
            $categorias[] = $cat;
        }

        return $categorias;
    }

    public static function buscarPorId(int $codCat): Categoria {
        $conexion = Conexion::getConexion();

        $sql = "SELECT * FROM categorias WHERE CodCat = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $codCat);
        $stmt->execute();

        $fila = $stmt->fetch();

        if (!$fila) {
            throw new RuntimeException("No existe la categoría con ID $codCat");
        }

        $cat = new Categoria(
            $fila['Nombre'],
            $fila['Descripcion']
        );
        $cat->setCodCat($fila['CodCat']);

        return $cat;
    }
}

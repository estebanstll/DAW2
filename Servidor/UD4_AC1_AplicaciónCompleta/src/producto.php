<?php

namespace Esteban\Ud4ac1;

class producto
{

    private string $nombre;

    private string $descripcion;

    private float $precio;

    private int $stock;

    private int $categoria_id;

    /**
     * @param string $descripcion
     * @param string $nombre
     * @param float $precio
     * @param int $stock
     */
    public function __construct(string $descripcion, string $nombre, float $precio, int $stock)
    {
        $this->descripcion = $descripcion;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->stock = $stock;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function __toString()
    {
            return "";
    }


}
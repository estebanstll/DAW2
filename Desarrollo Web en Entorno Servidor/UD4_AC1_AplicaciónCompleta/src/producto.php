<?php

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


}
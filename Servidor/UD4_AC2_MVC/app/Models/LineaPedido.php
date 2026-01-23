<?php

namespace App\Models;

class LineaPedido
{
    private ?int $identificadorLinea = null;
    private ?int $identificadorPedido = null;
    private int $codigoProducto;
    private int $cantidadItems;

    public function __construct(int $codigoProducto, int $cantidadItems)
    {
        $this->codigoProducto = $codigoProducto;
        $this->cantidadItems = $cantidadItems;
    }

    public function asignarIdLinea(?int $id): void
    {
        $this->identificadorLinea = $id;
    }

    public function obtenerId(): ?int
    {
        return $this->identificadorLinea;
    }

    public function asignarIdPedido(int $id): void
    {
        $this->identificadorPedido = $id;
    }

    public function obtenerIdPedido(): ?int
    {
        return $this->identificadorPedido;
    }

    public function obtenerCodigoProd(): int
    {
        return $this->codigoProducto;
    }

    public function asignarCodigoProd(int $codigo): void
    {
        $this->codigoProducto = $codigo;
    }

    public function obtenerUnidades(): int
    {
        return $this->cantidadItems;
    }

    public function incrementarCantidad(int $cantidad): void
    {
        $this->cantidadItems += $cantidad;
    }

    public function decrementarCantidad(int $cantidad): void
    {
        $this->cantidadItems -= $cantidad;
    }
}

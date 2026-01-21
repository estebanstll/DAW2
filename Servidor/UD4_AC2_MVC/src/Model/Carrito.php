<?php
namespace Acme\IntranetRestaurante\Model;

class Carrito
{
    /** @var CarritoItem[] */
    private array $items = [];

    public function addProducto(Producto $producto, int $unidades): void
    {
        $cod = $producto->getCodProd();
        if (!isset($this->items[$cod])) {
            $this->items[$cod] = new CarritoItem($producto, 0);
        }
        $this->items[$cod]->sumarUnidades($unidades);
        if ($this->items[$cod]->getUnidades() <= 0) {
            unset($this->items[$cod]);
        }
    }

    public function setUnidades(int $codProd, int $unidades): void
    {
        if (!isset($this->items[$codProd])) {
            return;
        }
        if ($unidades <= 0) {
            unset($this->items[$codProd]);
            return;
        }
        $this->items[$codProd]->setUnidades($unidades);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function estaVacio(): bool
    {
        return empty($this->items);
    }
}

class CarritoItem
{
    private Producto $producto;
    private int $unidades;

    public function __construct(Producto $producto, int $unidades)
    {
        $this->producto = $producto;
        $this->unidades = $unidades;
    }

    public function getProducto(): Producto
    {
        return $this->producto;
    }

    public function getUnidades(): int
    {
        return $this->unidades;
    }

    public function sumarUnidades(int $delta): void
    {
        $this->unidades += $delta;
    }

    public function setUnidades(int $unidades): void
    {
        $this->unidades = $unidades;
    }
}

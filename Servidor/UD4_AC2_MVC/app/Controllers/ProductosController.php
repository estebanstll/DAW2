<?php

namespace App\Controllers;

use App\Models\LineaPedido;
use Core\Controller;

class ProductosController extends Controller
{
    public function index($categoriaId): void
    {
        $productos = $this->modelo("Producto")->obtenerPorCategoria($categoriaId);
        $categoria = $this->modelo("Categoria")->buscarPorIdentificador($categoriaId);

        $this->vista("productos/index", [
            "listadoProductos" => $productos,
            "infoCategoria" => $categoria
        ]);
    }

    public function addToCart($productoId, $cantidad, $categoriaId): void
    {
        if (!isset($_SESSION["carrito"])) {
            $_SESSION["carrito"] = [];
        }

        $existe = false;
        foreach ($_SESSION["carrito"] as $item) {
            if ($item->obtenerCodigoProd() == $productoId) {
                $item->incrementarCantidad($cantidad);
                $existe = true;
                break;
            }
        }

        if (!$existe) {
            $_SESSION["carrito"][] = new LineaPedido($productoId, $cantidad);
        }

        header("Location: " . BASE_URL . "productos/index/" . $categoriaId);
        exit();
    }

    public function removeFromCart($productoId, $cantidad): void
    {
        foreach ($_SESSION["carrito"] as $pos => $item) {
            if ($item->obtenerCodigoProd() == $productoId) {
                $item->decrementarCantidad($cantidad);

                if ($item->obtenerUnidades() <= 0) {
                    unset($_SESSION["carrito"][$pos]);
                    $_SESSION["carrito"] = array_values($_SESSION["carrito"]);
                }
                break;
            }
        }
        header("Location: " . BASE_URL . "productos/mostrarCarrito");
        exit();
    }

    public function mostrarCarrito(): void
    {
        if (!isset($_SESSION["carrito"])) {
            $_SESSION["carrito"] = [];
        }

        $this->vista("carrito/index", ["articulos" => $_SESSION["carrito"]]);
    }
}

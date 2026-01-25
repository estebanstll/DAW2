<?php

namespace App\Controllers;

use App\Models\LineaPedido;
use Core\Controller;
use Tools\Hash;

class ProductosController extends Controller
{
    public function index($categoriaHash): void
    {
        // Decodificar el hash de la categoría
        $categoriaId = Hash::decodeFromDatabase($categoriaHash, 'categorias', 'CodCat');
        
        if ($categoriaId === null) {
            die('Error: Categoría no encontrada');
        }

        $productos = $this->modelo("Producto")->obtenerPorCategoria($categoriaId);
        $categoria = $this->modelo("Categoria")->buscarPorIdentificador($categoriaId);

        $this->vista("productos/index", [
            "listadoProductos" => $productos,
            "infoCategoria" => $categoria,
            "categoriaIdHash" => $categoriaHash
        ]);
    }

    public function addToCart($productoHash, $cantidad, $categoriaHash): void
    {
        // Decodificar los hashes
        $productoId = Hash::decodeFromDatabase($productoHash, 'productos', 'CodProd');
        $categoriaId = Hash::decodeFromDatabase($categoriaHash, 'categorias', 'CodCat');

        if ($productoId === null || $categoriaId === null) {
            die('Error: Producto o categoría no encontrado');
        }

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

        header("Location: " . BASE_URL . "productos/index/" . $categoriaHash);
        exit();
    }

    public function removeFromCart($productoHash, $cantidad): void
    {
        // Decodificar el hash
        $productoId = Hash::decodeFromDatabase($productoHash, 'productos', 'CodProd');

        if ($productoId === null) {
            die('Error: Producto no encontrado');
        }

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

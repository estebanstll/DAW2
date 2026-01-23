<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Pedido;
use App\Models\LineaPedido;

class PedidosController extends Controller
{
    public function procesarCompra(): void
    {
        if (!isset($_SESSION["carrito"]) || empty($_SESSION["carrito"])) {
            header("Location: " . BASE_URL . "productos/mostrarCarrito");
            exit;
        }

        $pedido = new Pedido(0, $this->modelo("Usuario")->obtenerIdUsuario($_SESSION["usuarioAutenticado"]));

        foreach ($_SESSION["carrito"] as $linea) {
            $pedido->insertarLinea($linea);
            $this->modelo("Producto")->actualizarStock($linea->obtenerCodigoProd(), $linea->obtenerUnidades());
        }

        $this->modelo("Pedido")->guardar($pedido);
        unset($_SESSION["carrito"]);

        header("Location: " . BASE_URL . "usuarios/logout");
        exit;
    }
}

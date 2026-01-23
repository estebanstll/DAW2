<?php

namespace App\Controllers;
use Core\Controller;
use App\Models\Pedido;
use App\Models\LineaPedido;

class PedidosController extends Controller
{

    public function index(){
        if (isset($_SESSION['carrito'])) {

            $modeloUsuario = $this->modelo("Usuario");
            $modeloPedido = $this->modelo("Pedido");
            $modeloProducto = $this->modelo("Producto");

            $pedido = new Pedido(0, $modeloUsuario->getIdUsuario($_SESSION["usuarioAutenticado"]));

            foreach ($_SESSION['carrito'] as $lineaPedido) {
                $pedido->addLinea($lineaPedido);
                $modeloProducto->cambiarStock($lineaPedido->getCodProd(), $lineaPedido->getUnidades());
            }


            if (sizeof($pedido->getLineas()) > 0) {
                $modeloPedido->guardar($pedido);

                unset($_SESSION['carrito']);

                header('Location: ' . BASE_URL . 'usuarios/index');
                exit;
            } else {
                header('Location: ' . BASE_URL . 'productos/mostrarCarrito');
                exit;
            }

        }
    }

}
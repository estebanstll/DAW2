<?php

namespace App\Controllers;

use App\Models\LineaPedido;
use Core\Controller;

class ProductosController extends Controller
{

    public function index($codCat){
        $modeloProducto = $this->modelo('Producto');
        $modeloCategoria = $this->modelo('Categoria');

        $productos = $modeloProducto->productosDeCategoria($codCat);
        $categoria = $modeloCategoria->buscarPorId($codCat);

        $this->vista('productos/index', [
            "productos" => $productos,
            "categoria" => $categoria
        ]);
    }

    public function agregarCarrito($codProd, $unidades, $codCat){

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        $encontrado = false;
        foreach ($_SESSION['carrito'] as $lineaPedido) {
            if ($lineaPedido->getCodProd() == $codProd) {
                $lineaPedido->sumarUnidades($unidades);
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {
            $_SESSION['carrito'][] = new LineaPedido($codProd, $unidades);
        }

        header('Location: ' . BASE_URL . 'productos/index/' . $codCat);
        exit();
    }

    public function eliminarCarrito($codProd, $unidades){
        foreach ($_SESSION['carrito'] as $index => $lineaPedido) {
            if ($lineaPedido->getCodProd() == $codProd) {

                $lineaPedido->restarUnidades($unidades);

                if ($lineaPedido->getUnidades() <= 0) {
                    unset($_SESSION['carrito'][$index]);

                    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                }
                break;
            }
        }
        header('Location: ' . BASE_URL . 'productos/mostrarCarrito');
        exit();
    }

    public function mostrarCarrito(){

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        $datosCarrito = [
            "productos" => $_SESSION['carrito'],
        ];

        $this->vista('carrito/index', $datosCarrito);
    }


}
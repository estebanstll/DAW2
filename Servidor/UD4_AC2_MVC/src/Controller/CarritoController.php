<?php
namespace Acme\IntranetRestaurante\Controller;

use Acme\IntranetRestaurante\Core\Controller;
use Acme\IntranetRestaurante\Model\Carrito;
use Acme\IntranetRestaurante\Model\Producto;

class CarritoController extends Controller
{
    public function listar(): void
    {
        $this->requireLogin();
        $carrito = $this->getCarrito();
        $items = $carrito->getItems();
        $this->render('carrito', compact('items'));
    }

    public function agregar(): void
    {
        $this->requireLogin();
        $codProd = (int)($_POST['pk'] ?? 0);
        $unidades = (int)($_POST['unidades'] ?? 0);

        $producto = Producto::buscarPorId($codProd);
        if ($producto && $unidades !== 0) {
            $carrito = $this->getCarrito();
            $carrito->addProducto($producto, $unidades);
            $_SESSION['carrito'] = $carrito;
        }

        header('Location: /Carrito/listar');
        exit;
    }

    public function actualizar(): void
    {
        $this->requireLogin();
        $codProd = (int)($_POST['pk'] ?? 0);
        $unidades = (int)($_POST['unidades'] ?? 0);
        $carrito = $this->getCarrito();
        $carrito->setUnidades($codProd, $unidades);
        $_SESSION['carrito'] = $carrito;

        header('Location: /Carrito/listar');
        exit;
    }

    private function getCarrito(): Carrito
    {
        if (!isset($_SESSION['carrito']) || !$_SESSION['carrito'] instanceof Carrito) {
            $_SESSION['carrito'] = new Carrito();
        }
        return $_SESSION['carrito'];
    }

    private function requireLogin(): void
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }
    }
}

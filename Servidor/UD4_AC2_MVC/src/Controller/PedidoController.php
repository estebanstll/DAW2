<?php
namespace Acme\IntranetRestaurante\Controller;

use Acme\IntranetRestaurante\Core\Controller;
use Acme\IntranetRestaurante\Model\Pedido;
use Acme\IntranetRestaurante\Model\LineaPedido;
use Acme\IntranetRestaurante\Model\Carrito;
use Ol\Tools\Mailer;
use Exception;

class PedidoController extends Controller
{
    public function crear(): void
    {
        $this->requireLogin();
        $carrito = $this->getCarrito();
        if ($carrito->estaVacio()) {
            header('Location: /Carrito/listar');
            exit;
        }

        $codRes = $_SESSION['usuario']['codRes'] ?? 0;
        $pedido = new Pedido($codRes);
        foreach ($carrito->getItems() as $item) {
            $linea = new LineaPedido(0, $item->getProducto()->getCodProd(), $item->getUnidades());
            $pedido->anadirLinea($linea);
        }

        try {
            $pedido->guardar();
            Mailer::enviarEmail($_SESSION['usuario']['nombre'], 'Pedido Confirmado', 'Su pedido ha sido registrado.');
            $_SESSION['carrito'] = new Carrito();
            $this->render('pedido_ok');
        } catch (Exception $e) {
            http_response_code(500);
            echo 'Error al crear el pedido: ' . $e->getMessage();
        }
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

<?php
namespace Acme\IntranetRestaurante\Controller;

use Acme\IntranetRestaurante\Core\Controller;
use Acme\IntranetRestaurante\Model\Categoria;
use Acme\IntranetRestaurante\Model\Producto;

class CategoriaController extends Controller
{
    public function categorias(): void
    {
        $this->requireLogin();
        $categorias = Categoria::todas();
        $this->render('categorias', compact('categorias'));
    }

    public function listar(int $codCat): void
    {
        $this->requireLogin();
        $productos = Producto::productosDeCategoria($codCat);
        $categoria = Categoria::buscarPorId($codCat);
        $this->render('productos', compact('productos', 'categoria'));
    }

    private function requireLogin(): void
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }
    }
}

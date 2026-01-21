<?php
namespace Acme\IntranetRestaurante\Core;

use Acme\IntranetRestaurante\Controller\RestauranteController;
use Acme\IntranetRestaurante\Controller\CategoriaController;
use Acme\IntranetRestaurante\Controller\CarritoController;
use Acme\IntranetRestaurante\Controller\PedidoController;

class Router
{
    public function dispatch(): void
    {
        $segments = $this->parseSegments();
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        // Routes
        if ($this->isLoginForm($segments, $method)) {
            (new RestauranteController())->loginForm();
            return;
        }

        if ($this->isLoginPost($segments, $method)) {
            (new RestauranteController())->login();
            return;
        }

        if ($this->matches($segments, ['Restaurante', 'logout'])) {
            (new RestauranteController())->logout();
            return;
        }

        if ($this->matches($segments, ['Categoria', 'categorias'])) {
            (new CategoriaController())->categorias();
            return;
        }

        if ($this->matches($segments, ['Categoria', 'listar']) && isset($segments[2])) {
            (new CategoriaController())->listar((int)$segments[2]);
            return;
        }

        if ($this->matches($segments, ['Carrito', 'listar'])) {
            (new CarritoController())->listar();
            return;
        }

        if ($this->matches($segments, ['Carrito', 'agregar']) && $method === 'POST') {
            (new CarritoController())->agregar();
            return;
        }

        if ($this->matches($segments, ['Carrito', 'actualizar']) && $method === 'POST') {
            (new CarritoController())->actualizar();
            return;
        }

        if ($this->matches($segments, ['Pedido', 'crear'])) {
            (new PedidoController())->crear();
            return;
        }

        http_response_code(404);
        echo 'Ruta no encontrada';
    }

    private function parseSegments(): array
    {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $path = trim($uri, '/');
        $segments = array_values(array_filter(explode('/', $path)));
        if (isset($segments[0]) && $segments[0] === 'index.php') {
            array_shift($segments);
        }
        return $segments;
    }

    private function matches(array $segments, array $expected): bool
    {
        foreach ($expected as $idx => $value) {
            if (($segments[$idx] ?? null) !== $value) {
                return false;
            }
        }
        return true;
    }

    private function isLoginForm(array $segments, string $method): bool
    {
        return ($segments === [] || $this->matches($segments, ['login'])) && $method === 'GET';
    }

    private function isLoginPost(array $segments, string $method): bool
    {
        return $this->matches($segments, ['Restaurante', 'login']) && $method === 'POST';
    }
}

<?php
namespace Acme\IntranetRestaurante\Controller;

use Acme\IntranetRestaurante\Core\Controller;
use Acme\IntranetRestaurante\Model\Restaurante;
use Acme\IntranetRestaurante\Model\Carrito;

class RestauranteController extends Controller
{
    public function loginForm(): void
    {
        $error = '';
        $this->render('login', compact('error'));
    }

    public function login(): void
    {
        $correo = $_POST['user'] ?? '';
        $clave = $_POST['password'] ?? '';

        $obj = Restaurante::login($correo, $clave);
        if ($obj) {
            $_SESSION['usuario'] = [
                'nombre' => $obj->getCorreo(),
                'codRes' => $obj->getCodRes()
            ];
            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = new Carrito();
            }
            header('Location: /Categoria/categorias');
            exit;
        }

        $error = 'Usuario o clave incorrectos';
        $this->render('login', compact('error'));
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}

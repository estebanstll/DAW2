<?php
namespace App\Controllers;

use Core\Controller;
use App\Apirest\Models\ApiUsuario;
use App\Apirest\Models\ApiCategoria;
use App\Apirest\Models\ApiProducto;
use App\Apirest\Models\ApiPedido;
use App\Apirest\Tools\Jwt;

class ApirestController extends Controller
{
    // Punto frontal: /apirest/api/<recurso>/[id]
    public function api(...$params)
    {
        header('Content-Type: application/json; charset=utf-8');

        $recurso = $params[0] ?? null;
        $id = $params[1] ?? null;

        try {
            switch ($recurso) {
                case 'login':
                    $this->handleLogin();
                    break;
                case 'categorias':
                    $this->requireAuth();
                    $this->handleCategorias();
                    break;
                case 'productos':
                    $this->requireAuth();
                    $this->handleProductos($id);
                    break;
                case 'pedidos':
                    $this->requireAuth();
                    $this->handlePedidos($id);
                    break;
                default:
                    http_response_code(404);
                    echo json_encode(['error' => 'Recurso no encontrado']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    protected function handleLogin()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $email = $input['email'] ?? null;
        $password = $input['password'] ?? null;

        if (!$email || !$password) {
            http_response_code(400);
            echo json_encode(['error' => 'Email y password requeridos']);
            return;
        }

        $user = ApiUsuario::validarCredenciales($email, $password);

        if (!$user) {
            // Información diagnóstica para desarrollo: comprobar si existe el usuario y su hash almacenado
            try {
                $bd = \Tools\Conexion::getConexion();
                $stmt = $bd->prepare('SELECT Correo, Clave FROM restaurantes WHERE Correo = :email');
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $row = $stmt->fetch();
            } catch (\Exception $e) {
                $row = null;
            }

            http_response_code(401);
            echo json_encode([
                'error' => 'Credenciales inválidas',
                'diagnostic' => [
                    'user_exists' => $row ? true : false,
                    'stored_hash' => $row['Clave'] ?? null
                ]
            ]);
            return;
        }

        $payload = [
            'sub' => $user['CodRes'] ?? $user['CodUsuario'] ?? null,
            'email' => $user['Correo'] ?? $user['Email'] ?? $email
        ];

        $token = Jwt::generate($payload, 3600); // 1 hora

        echo json_encode(['token' => $token]);
    }

    protected function handleCategorias()
    {
        $cats = ApiCategoria::obtenerTodas();
        echo json_encode($cats);
    }

    protected function handleProductos($pk_categoria)
    {
        if (!$pk_categoria) {
            http_response_code(400);
            echo json_encode(['error' => 'Se requiere pk_categoria']);
            return;
        }
        $prods = ApiProducto::obtenerPorCategoria((int)$pk_categoria);
        echo json_encode($prods);
    }

    protected function handlePedidos($pk_restaurante)
    {
        if (!$pk_restaurante) {
            http_response_code(400);
            echo json_encode(['error' => 'Se requiere pk_restaurante']);
            return;
        }
        $pedidos = ApiPedido::obtenerPorRestaurante((int)$pk_restaurante);
        echo json_encode($pedidos);
    }

    protected function requireAuth()
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? null;

        if (!$authHeader) {
            http_response_code(401);
            echo json_encode(['error' => 'Autorización requerida']);
            exit;
        }

        if (stripos($authHeader, 'Bearer ') === 0) {
            $token = trim(substr($authHeader, 7));
        } else {
            $token = $authHeader;
        }

        $payload = Jwt::validate($token);
        if (!$payload) {
            http_response_code(401);
            echo json_encode(['error' => 'Token inválido o expirado']);
            exit;
        }
        // Puedes exponer $payload si lo necesitas
        return $payload;
    }
}

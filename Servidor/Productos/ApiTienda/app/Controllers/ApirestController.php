<?php
namespace App\Controllers;

use Core\Controller;
use App\Apirest\Models\ApiUsuario;
use  App\Apirest\Models\Apianimales;
use  App\Apirest\Models\Apicategorias;
use  App\Apirest\Models\Apiproductos;

use App\Apirest\Tools\Jwt;

class ApirestController extends Controller
{
    /**
     * Punto frontal: /apirest/api/<recurso>
     * 
     * RUTA COMPLETA: http://localhost/Productos/ApiTienda/public/apirest/api/<recurso>
     * 
     * Ejemplos:
     * - GET  http://localhost/Productos/ApiTienda/public/apirest/api/productos       (todos los productos)
     * - GET  http://localhost/Productos/ApiTienda/public/apirest/api/productos/1     (producto con ID 1)
     * - GET  http://localhost/Productos/ApiTienda/public/apirest/api/categorias      (todas las categorías)
     * - POST http://localhost/Productos/ApiTienda/public/apirest/api/login           (login de usuario)
     * 
     * NOTA: La ruta se configura en:
     * - /public/.htaccess (RewriteBase /Productos/ApiTienda/public/)
     * - /public/index.php (BASE_URL define)
     */
    public function api(...$params)
    {
        header('Content-Type: application/json; charset=utf-8');

        // DEBUG: Log all headers received
        error_log("=== API HEADERS RECEIVED ===");
        error_log(print_r(getallheaders(), true));
        error_log("HTTP_AUTHORIZATION: " . ($_SERVER['HTTP_AUTHORIZATION'] ?? 'NULL'));
        error_log("REDIRECT_HTTP_AUTHORIZATION: " . ($_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? 'NULL'));

        $recurso = $params[0] ?? null;
        $id = $params[1] ?? null;

        try {
            switch ($recurso) {
                case 'login':
                    $this->handleLogin();
                    break;
                case 'register':
                    $this->handleRegister();
                    break;
                case 'productos':
                    $this->requireAuth();
                    $this->handleProductosPorIdCat($id);
                    break;

                case 'categorias':
                    $this->requireAuth();
                    $this->handleCategoriasAll();
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
            http_response_code(401);
            echo json_encode(['error' => 'Credenciales inválidas']);
            return;
        }

        $payload = [
            'sub' => $user['id'] ?? null,
            'email' => $user['correo'] ?? $email
        ];

        $token = Jwt::generate($payload, 86400); // 24 hora

        echo json_encode(['token' => $token]);
    }

    protected function handleRegister()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $email = $input['email'] ?? null;
        $password = $input['password'] ?? null;
        $nombre = $input['nombre'] ?? '';

        if (!$email || !$password) {
            http_response_code(400);
            echo json_encode(['error' => 'Email y password requeridos']);
            return;
        }

        $resultado = ApiUsuario::crearUsuario($email, $password, $nombre);

        if ($resultado['success']) {
            http_response_code(201);
            echo json_encode([
                'message' => $resultado['message'],
                'id' => $resultado['id']
            ]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => $resultado['message']]);
        }
    }

    protected function requireAuth()
    {
        // DEBUG: Log auth attempt
        error_log("=== REQUIRE AUTH ===");
        
        // Intentar obtener el header de diferentes fuentes
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? null;
        error_log("authHeader from SERVER: " . ($authHeader ?? 'NULL'));
        
        // Si no está en $_SERVER, intentar desde getallheaders()
        if (!$authHeader) {
            $headers = getallheaders();
            $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? null;
            error_log("authHeader from getallheaders: " . ($authHeader ?? 'NULL'));
        }

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

        error_log("Token extracted: " . substr($token, 0, 30) . "...");

        $payload = Jwt::validate($token);
        error_log("Jwt::validate result: " . ($payload ? 'VALID' : 'INVALID/NULL'));
        
        if (!$payload) {
            error_log("JWT validation FAILED - returning 401");
            http_response_code(401);
            echo json_encode(['error' => 'Token inválido o expirado']);
            exit;
        }
        // Puedes exponer $payload si lo necesitas
        return $payload;
    }









    protected function handleCategoriasAll(){

        $categorias = Apicategorias::getTodos();
        echo json_encode($categorias);


    }

    protected function handleProductosPorIdCat($id){

        $productos = Apiproductos::getPorId($id);  

        if ($productos) {
            echo json_encode($productos);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'productos no encontrados']);
        }        

    }




/*
    protected function handleUpdateAnimal($id){
        
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID del animal requerido']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $animal = $input['animal'] ?? null;
        $raza = $input['raza'] ?? null;
        $nombre = $input['nombre'] ?? null;
        $personaACargo = $input['personaACargo'] ?? null;

        if (!$animal || !$raza || !$nombre || !$personaACargo) {
            http_response_code(400);
            echo json_encode(['error' => 'Animal, raza, nombre y personaACargo requeridos']);
            return;
        }

        $resultado = Apianimales::updatePorId($id, $animal, $raza, $nombre, $personaACargo);

        if ($resultado['success']) {
            http_response_code(200);
            echo json_encode($resultado);
        } else {
            http_response_code(400);
            echo json_encode(['error' => $resultado['message']]);
        }
    }

    protected function handleDeleteAnimal($id){
        
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID del animal requerido']);
            return;
        }

        $resultado = Apianimales::deletePorId($id);

        if ($resultado['success']) {
            http_response_code(200);
            echo json_encode($resultado);
        } else {
            http_response_code(400);
            echo json_encode(['error' => $resultado['message']]);
        }
    }*/
}

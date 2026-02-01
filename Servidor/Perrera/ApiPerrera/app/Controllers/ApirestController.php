<?php
namespace App\Controllers;

use Core\Controller;
use App\Apirest\Models\ApiUsuario;
use  App\Apirest\Models\Apianimales;
use App\Apirest\Tools\Jwt;

class ApirestController extends Controller
{
    /**
     * Punto frontal: /apirest/api/<recurso>
     * 
     * RUTA COMPLETA: http://localhost/Perrera/ApiPerrera/public/apirest/api/<recurso>
     * 
     * Ejemplos:
     * - GET  http://localhost/Perrera/ApiPerrera/public/apirest/api/animal       (todos los animales)
     * - GET  http://localhost/Perrera/ApiPerrera/public/apirest/api/animal/1     (animal con ID 1)
     * - POST http://localhost/Perrera/ApiPerrera/public/apirest/api/login        (login de usuario)
     * 
     * NOTA: La ruta se configura en:
     * - /public/.htaccess (RewriteBase /Perrera/ApiPerrera/public/)
     * - /public/index.php (BASE_URL define)
     */
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
                case 'register':
                    $this->handleRegister();
                    break;
                case 'animal':
                    $this->requireAuth();
                    if($id){
                    $this->handleAnimalesPorId($id);
                        
                    }else{

                        $this->handleAnimalesAll();
                    }
                    break;
                case 'updateAnimal':
                    $this->requireAuth();
                    $id = $params[1] ?? null;
                    $this->handleUpdateAnimal($id);
                    break;
                case 'deleteAnimal':
                    $this->requireAuth();
                    $id = $params[1] ?? null;
                    $this->handleDeleteAnimal($id);
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

        $token = Jwt::generate($payload, 3600); // 1 hora

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
        // Intentar obtener el header de diferentes fuentes
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? null;
        
        // Si no está en $_SERVER, intentar desde getallheaders()
        if (!$authHeader) {
            $headers = getallheaders();
            $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? null;
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

        $payload = Jwt::validate($token);
        if (!$payload) {
            http_response_code(401);
            echo json_encode(['error' => 'Token inválido o expirado']);
            exit;
        }
        // Puedes exponer $payload si lo necesitas
        return $payload;
    }


    protected function handleAnimalesAll(){

        $animales = Apianimales::getTodos();
        echo json_encode($animales);


    }

    protected function handleAnimalesPorId($id){

        $animales = Apianimales::getPorId($id);  

        if ($animales) {
            echo json_encode($animales);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'ANIMAL no encontrado']);
        }        

    }

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
    }
}

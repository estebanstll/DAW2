<?php
namespace App\Controllers;

use Core\Controller;
use App\Apirest\Models\ApiUsuario;
use  App\Apirest\Models\ApiPacientes;
use  App\Apirest\Models\ApiTrabajadores;

use App\Apirest\Tools\Jwt;

class ApirestController extends Controller
{
    /**
     * Punto frontal: /apirest/api/<recurso>
     * 
     * RUTA COMPLETA: http://localhost/Productos/ApiTienda/public/apirest/api/<recurso>
     * 
     * Ejemplos:
     * - GET  http://localhost/Hospital/Api/public/apirest/api/productos       (todos los productos)
     * - GET  http://localhost/Hospital/Api/public/apirest/api/productos/1     (producto con ID 1)
     * - GET  http://localhost/Hospital/Api/public/apirest/api/categorias      (todas las categorías)
     * - POST http://localhost/Hospital/Api/public/apirest/api/login           (login de usuario)
     * 
     * NOTA: La ruta se configura en:
     * - /public/.htaccess (RewriteBase /Productos/ApiTienda/public/)
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
                
                case 'trabajadores':
                    if($id){
                        //$this->requireAuth();
                        $this->handleMedicosId($id);
                    }else{
                        $this->handlemedicosAll();
                    }
                    
                    break;
                case 'paciente':
                    //$this->requireAuth();
                    if($id){
                        //$this->requireAuth();
                        $this->handlePacienteById($id);

                        
                    }else{
                        $this->handlePacientesAll();
                    }
                    break;
                 case 'pacienteDelete':
                    //$this->requireAuth();
                    $this->handleDeletePaciente($id);
                    break;

                     case 'pacienteUpdate':
                    //$this->requireAuth();
                    $this->handleupdatePaciente($id);
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
            // intentar obtener de apache env (pasado por .htaccess)
            $authHeader = getenv('HTTP_AUTHORIZATION') ?: getenv('REDIRECT_HTTP_AUTHORIZATION');
        }

        // Log para depuración: qué header llega
        error_log('requireAuth: authHeader raw => ' . print_r($authHeader, true));

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

        // Log token extraído
        error_log('requireAuth: token extracted => ' . print_r($token, true));

        $payload = Jwt::validate($token);
        error_log('requireAuth: Jwt::validate result => ' . print_r($payload, true));
        if (!$payload) {
            http_response_code(401);
            echo json_encode(['error' => 'Token inválido o expirado']);
            exit;
        }
        // Puedes exponer $payload si lo necesitas
        return $payload;
    }









    protected function handlemedicosAll(){

        $medicos = ApiTrabajadores::getTodos();
        echo json_encode($medicos);


    }

    protected function handleMedicosId($id){

        $medicos = ApiTrabajadores::getId($id);  

        if ($medicos) {
            echo json_encode($medicos);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'productos no encontrados']);
        }        

    }
    // Obtener todos los pacientes
    protected function handlePacientesAll()
    {
        $pacientes = ApiPacientes::getTodos();
        echo json_encode($pacientes);
    }

    // Obtener paciente por id
    protected function handlePacienteById($id)
    {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID del paciente requerido']);
            return;
        }

        $paciente = ApiPacientes::getId($id);
        if ($paciente && count($paciente) > 0) {
            echo json_encode($paciente);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Paciente no encontrado']);
        }
    }

    // Actualizar paciente por id (PUT/PATCH)
    protected function handleupdatePaciente($id)
    {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID del paciente requerido']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $medico_id = $input['medico_id'] ?? null;
        $nombre = $input['nombre'] ?? null;
        $motivo = $input['motivo'] ?? null;

        if (!$medico_id || !$nombre || !$motivo) {
            http_response_code(400);
            echo json_encode(['error' => 'medico_id, nombre y motivo requeridos']);
            return;
        }

        $resultado = ApiPacientes::updatePorId($id, $medico_id, $nombre, $motivo);
        if (isset($resultado['success']) && $resultado['success']) {
            http_response_code(200);
            echo json_encode($resultado);
        } else {
            http_response_code(400);
            echo json_encode(['error' => $resultado['message'] ?? 'Error al actualizar paciente']);
        }
    }

    // Eliminar paciente por id
    protected function handleDeletePaciente($id)
    {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID del paciente requerido']);
            return;
        }

        $resultado = ApiPacientes::delete($id);
        if (isset($resultado['success']) && $resultado['success']) {
            http_response_code(200);
            echo json_encode($resultado);
        } else {
            http_response_code(400);
            echo json_encode(['error' => $resultado['message'] ?? 'Error al eliminar paciente']);
        }
    }

    // Debug: mostrar y logear cómo llegan los headers de autorización
    protected function handleDebugAuth()
    {
        $serverAuth = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
        $serverRedirectAuth = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? null;
        $getenvAuth = getenv('HTTP_AUTHORIZATION') ?: null;
        $getenvRedirect = getenv('REDIRECT_HTTP_AUTHORIZATION') ?: null;

        $headers = [];
        if (function_exists('getallheaders')) {
            $headers = getallheaders();
        } elseif (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
        }

        $debug = [
            'server_HTTP_AUTHORIZATION' => $serverAuth,
            'server_REDIRECT_HTTP_AUTHORIZATION' => $serverRedirectAuth,
            'getenv_HTTP_AUTHORIZATION' => $getenvAuth,
            'getenv_REDIRECT_HTTP_AUTHORIZATION' => $getenvRedirect,
            'getallheaders' => $headers,
        ];

        error_log('debug-auth: ' . print_r($debug, true));

        echo json_encode($debug);
    }
}

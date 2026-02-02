<?php
namespace App\Controllers;

use Core\Controller;
use App\Apirest\Models\ApiUsuario;
use  App\Apirest\Models\ApiProfesores;
use  App\Apirest\Models\ApiAlumnos;
use  App\Apirest\Models\ApiNotas;

use App\Apirest\Tools\Jwt;

class ApirestController extends Controller
{
    /**
     * Punto frontal: /apirest/api/<recurso>
     * 
     * RUTA COMPLETA: http://localhost/Productos/Api/public/apirest/api/<recurso>
     * 
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
                
                case 'profesores':
                    if($id){
                        //$this->requireAuth();
                        $this->handleProfesoresID($id);
                    }else{
                        $this->handleProfesoresAll();
                    }
                    break;
                case 'alumnoGet':
                    //$this->requireAuth();
                    
                        //$this->requireAuth();
                        $this->handleAlumnosID($id);
                    break;
                case 'alumnoById':
                    //$this->requireAuth();
                    $this->handleAlumnoById($id);
                    break;

                 case 'alumnoUpdate':
                    //$this->requireAuth();
                    $this->handleUpdateAlumno($id);
                    break;

                     case 'notaGet':
                    //$this->requireAuth();
                    $this->handleNotasId($id);
                    break;
                    case 'notasUpdate':
                        //$this->requireAuth();
                        $this->handleUpdateNota($id);
                        break;
                    case 'notasCreate':
                        //$this->requireAuth();
                        $this->handleCreateNota();
                        break;
                    case 'notasDelete':
                        //$this->requireAuth();
                        $this->deleteNotaId($id);
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









    protected function handleProfesoresAll(){

        $profesores = ApiProfesores::getTodos();
        echo json_encode($profesores);


    }

    protected function handleProfesoresID($id){

        $profesores = ApiProfesores::getId($id);  

        if ($profesores) {
            echo json_encode($profesores);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'productos no encontrados']);
        }        

    }



    protected function handleAlumnosID($id){

        $alumnos = ApiAlumnos::getId($id);  

        if ($alumnos) {
            echo json_encode($alumnos);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'productos no encontrados']);
        }        

    }

    protected function handleAlumnoById($id){

        $alumno = ApiAlumnos::getPorId($id);

        if ($alumno) {
            echo json_encode($alumno);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'alumno no encontrado']);
        }

    }


    

    // Actualizar paciente por id (PUT/PATCH)
    protected function handleUpdateAlumno($id)
    {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID del alumno requerido']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $profesor_id = $input['profesor_id'] ?? null;
        $nombre = $input['nombre'] ?? null;
        $apellido = $input['apellido'] ?? null;

        if (!$profesor_id || !$nombre || !$apellido) {
            http_response_code(400);
            echo json_encode(['error' => 'medico_id, nombre y apellido requeridos']);
            return;
        }

        $resultado = ApiAlumnos::updatePorId($id, $profesor_id, $nombre, $apellido);
        if (isset($resultado['success']) && $resultado['success']) {
            http_response_code(200);
            echo json_encode($resultado);
        } else {
            http_response_code(400);
            echo json_encode(['error' => $resultado['message'] ?? 'Error al actualizar alumno']);
        }
    }


    protected function handleNotasId($id){

        $notas = ApiNotas::getId($id);  

        if ($notas) {
            echo json_encode($notas);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'notas no encontrados']);
        }        

    }


    protected function deleteNotaId($id){

        $nota= ApiNotas::delete($id);

    }

    // Actualizar nota por id (PUT/PATCH)
    protected function handleUpdateNota($id)
    {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de la nota requerido']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $nota = $input['nota'] ?? null;

        if ($nota === null || $nota === '') {
            http_response_code(400);
            echo json_encode(['error' => 'nota requerida']);
            return;
        }

        if (!is_numeric($nota)) {
            http_response_code(400);
            echo json_encode(['error' => 'nota debe ser numérica']);
            return;
        }

        $resultado = ApiNotas::updatePorId($id, (int)$nota);
        if (isset($resultado['success']) && $resultado['success']) {
            http_response_code(200);
            echo json_encode($resultado);
        } else {
            http_response_code(400);
            echo json_encode(['error' => $resultado['message'] ?? 'Error al actualizar nota']);
        }
    }

    // Crear nota (POST)
    protected function handleCreateNota()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        $alumno_id = $input['alumno_id'] ?? null;
        $asignatura = $input['asignatura'] ?? null;
        $nota = $input['nota'] ?? null;

        if (!$alumno_id || !$asignatura || $nota === null || $nota === '') {
            http_response_code(400);
            echo json_encode(['error' => 'alumno_id, asignatura y nota requeridos']);
            return;
        }

        if (!is_numeric($nota)) {
            http_response_code(400);
            echo json_encode(['error' => 'nota debe ser numérica']);
            return;
        }

        $resultado = ApiNotas::crearNota($id, $alumno_id, $asignatura, (int)$nota);
        if (isset($resultado['success']) && $resultado['success']) {
            http_response_code(201);
            echo json_encode($resultado);
        } else {
            http_response_code(400);
            echo json_encode(['error' => $resultado['message'] ?? 'Error al crear nota']);
        }
    }

    
}

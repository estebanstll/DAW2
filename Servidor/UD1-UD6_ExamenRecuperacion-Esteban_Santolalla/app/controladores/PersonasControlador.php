<?php
namespace Dwes\Clinica;


    class PersonasControlador extends Controlador{

    public function index(){

        $apiUrl = 'http://localhost/UD1-UD6_ExamenRecuperacion-Esteban_Santolalla/API/personas';

        $auth = base64_encode('dwes:dwes');
        $opts = [
            'http' => [
                'method' => "GET",
                'header' => "Authorization: Basic $auth\r\n" .
                            "Accept: application/json\r\n"
            ]
        ];

        $context = stream_context_create($opts);
        $json = @file_get_contents($apiUrl, false, $context);

        $personas = [];
        if ($json !== false) {
            $decoded = json_decode($json, true);
            if (is_array($decoded) && isset($decoded[0])) {
                $personas = $decoded;
            } elseif (is_array($decoded) && isset($decoded['mensaje'])) {
                $personas = [];
            }
        }

        $datos = [
            'personas' => $personas
        ];

        $this->vista("personas/index", $datos);

    }


    public function ficha($id){

    $persona = $this->modelo("Personas");
    $datos = [
            'personas' => $persona->getByID($id)
        ];

    $this->vista("personas/ficha",$datos);
    }

    public function registrar(){

    $this->vista("personas/registrar");


    }
    public function validarDatos(){

     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_URL . '/VeterinarioControlador');
            exit;
        }

        // Obtener datos del formulario
        $email = $_POST['correo'] ?? null;
        $apellidos = $_POST['apellidos'] ?? null;
        $nombre = $_POST['nombre'] ?? null;
        $telefono = $_POST['telefono'] ?? null;

        // Validar que no estén vacíos
        if (empty($email) || empty($apellidos) || empty($nombre) || empty($telefono)) {
            $_SESSION['error'] = 'Correo, nombre, apelldios y telefono son requeridos';
            header('Location: ' . RUTA_URL . '/VeterinarioControlador');
            exit;
        }

        // Cargar modelo Veterinario
        $Persona = $this->modelo('Personas');
        
        // Intentar login
        $resultado = $Persona->post($nombre, $apellidos,$telefono,$email);

        // Verificar respuesta
        if ($resultado) {
            // Login exitoso - guardar en sesión

            header('Location: ' . RUTA_URL.'/PersonasControlador');
            exit;
        } else {
            // Login fallido
            $_SESSION['error'] = 'Correo o contraseña incorrectos';
            header('Location: ' . RUTA_URL . '/PersonasControlador/registrar');
            exit;
        }
    }



    
    }
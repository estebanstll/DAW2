<?php
namespace Dwes\Clinica;


class VeterinarioControlador extends Controlador{


    public function index(){

      $datos = [
            'titulo' => 'Login de usuario'
        ];
        $this->vista("veterinarios/index", $datos);
    }


    public function validarDatos(){

     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_URL . '/VeterinarioControlador');
            exit;
        }

        // Obtener datos del formulario
        $email = $_POST['correo'] ?? null;
        $clave = $_POST['contraseña'] ?? null;
        $nombre = $_POST['nombre'] ?? null;

        // Validar que no estén vacíos
        if (empty($email) || empty($clave) || empty($nombre)) {
            $_SESSION['error'] = 'Correo, nombre y contraseña son requeridos';
            header('Location: ' . RUTA_URL . '/VeterinarioControlador');
            exit;
        }

        // Cargar modelo Veterinario
        $Veterinario = $this->modelo('Veterinario');
        
        // Intentar login
        $resultado = $Veterinario->login($email, $clave, $nombre);

        // Verificar respuesta
        if ($resultado) {
            // Login exitoso - guardar en sesión
            $_SESSION['usuario_activo'] = $resultado;
            $_SESSION['email'] = $email;
            
            // Redirigir a dashboard o inicio
            header('Location: ' . RUTA_URL.'/CochesControlador');
            exit;
        } else {
            // Login fallido
            $_SESSION['error'] = 'Correo o contraseña incorrectos';
            header('Location: ' . RUTA_URL . '/VeterinarioControlador');
            exit;
        }
    }

}
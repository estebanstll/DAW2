<?php
namespace Dwes\Clinica;


class UsuariosControlador extends Controlador{


    public function index(){

      $datos = [
            'titulo' => 'Login de usuario'
        ];
        $this->vista("usuarios/index", $datos);
    }


    public function validarDatos(){

     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_URL . '/UsuariosControlador');
            exit;
        }

        // Obtener datos del formulario
        $email = $_POST['correo'] ?? null;
        $clave = $_POST['contraseña'] ?? null;

        // Validar que no estén vacíos
        if (empty($email) || empty($clave)) {
            $_SESSION['error'] = 'Correo y contraseña son requeridos';
            header('Location: ' . RUTA_URL . '/UsuariosControlador');
            exit;
        }

        // Cargar modelo Usuarios
        $Usuarios = $this->modelo('Usuarios');
        
        // Intentar login
        $resultado = $Usuarios->login($email, $clave);

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
            header('Location: ' . RUTA_URL . '/UsuariosControlador');
            exit;
        }
    }

}
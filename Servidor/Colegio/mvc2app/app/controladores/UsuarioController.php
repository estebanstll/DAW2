<?php

use App\Models\Usuarios;

// Cargar manualmente la clase Usuarios
require_once __DIR__.'/../modelos/Usuarios.php';

class UsuarioController extends Controlador{

    public function index():void{
        $this->vista("usuarios/index");
    }


    public function validarDatos():void{
        // Verificar que sea POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'usuario');
            exit;
        }

        // Obtener datos del formulario
        $correo = $_POST['correo'] ?? null;
        $contraseña = $_POST['contraseña'] ?? null;

        // Validar que no estén vacíos
        if (empty($correo) || empty($contraseña)) {
            $_SESSION['error'] = 'Correo y contraseña son requeridos';
            header('Location: ' . BASE_URL . 'usuario');
            exit;
        }

        // Intentar login en la API
        $respuesta = Usuarios::login($correo, $contraseña);

        // Verificar respuesta
        if ($respuesta['status'] === 200 && isset($respuesta['data']['token'])) {
            // Login exitoso - guardar token en sesión
            $_SESSION['token'] = $respuesta['data']['token'];
            $_SESSION['correo'] = $correo;
            
            // Redirigir a index o dashboard
            header('Location: ' . BASE_URL . 'ProfesoresController');
            exit;
        } else {
            // Login fallido
            $error = $respuesta['data']['error'] ?? 'Error al iniciar sesión';
            $_SESSION['error'] = $error;
            header('Location: ' . BASE_URL . 'usuario');
            exit;
        }
    }


    public function register(){


        $this->vista("usuarios/register");

    }


    public function crearUsuario(){

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'usuario/register');
            exit;
        }

        $nombre = $_POST['nombre'] ?? null;
        $correo = $_POST['correo'] ?? null;
        $contraseña = $_POST['contraseña'] ?? null;


         if (empty($nombre) || empty($correo) || empty($contraseña)) {
            $_SESSION['error'] = 'nombre, Correo y contraseña son requeridos';
            header('Location: ' . BASE_URL . 'usuario/register');
            exit;
        }

        $respuesta = Usuarios::register($nombre, $correo, $contraseña);

         if ($respuesta['status'] === 200) {
            // Login exitoso - guardar token en sesión
            
            
            // Redirigir a index o dashboard
            header('Location: ' . BASE_URL . 'usuario');
            exit;
        } else {
            // Login fallido
            $error = $respuesta['data']['error'] ?? 'Error al iniciar sesión';
            $_SESSION['error'] = $error;
            header('Location: ' . BASE_URL . 'usuario');
            exit;
        }

    }
}
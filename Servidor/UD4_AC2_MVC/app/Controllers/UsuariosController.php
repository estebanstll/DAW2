<?php

namespace App\Controllers;
use Core\Controller;

class UsuariosController extends Controller
{
    public function index()
    {
        $this->vista('usuarios/index');
    }

    public function isLogged()
    {
        $usuario  = $_POST['usuario'] ?? '';
        $password = $_POST['password'] ?? '';

        try {
            $modelo = $this->modelo("Usuario");
            $ok = $modelo->comprobarUsuario($usuario, $password);
        } catch (\Throwable $e) {
            $this->vista('usuarios/index', ['error' => 'Error del servidor. Inténtalo de nuevo más tarde.']);
            return;
        }

        if ($ok) {
            $_SESSION['usuarioAutenticado'] = $usuario;
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'] ?? '';
            $location = ($host ? ($scheme . '://' . $host) : '') . BASE_URL . 'categorias/index';
            header('Location: ' . $location, true, 303);
            exit;
        }

        $this->vista('usuarios/index', ['error' => 'Credenciales inválidas. Inténtalo de nuevo.']);
    }

    public function logout(){
        $this->vista('usuarios/logout');
    }
}


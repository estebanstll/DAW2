<?php

namespace App\Controllers;

use Core\Controller;

class UsuariosController extends Controller
{
    public function index(): void
    {
        $this->vista("usuarios/index");
    }

    public function autenticar(): void
    {
        $email = $_POST["usuario"] ?? "";
        $clave = $_POST["password"] ?? "";

        try {
            $validado = $this->modelo("Usuario")->validarCredenciales($email, $clave);
        } catch (\Throwable $e) {
            $this->vista("usuarios/index", ["error" => "Error en el servidor"]);
            return;
        }

        if ($validado) {
            $_SESSION["usuarioAutenticado"] = $email;
            header("Location: " . BASE_URL . "categorias/index", true, 303);
            exit;
        }

        $this->vista("usuarios/index", ["error" => "Credenciales no válidas"]);
    }

    public function cerrarSesion(): void
    {
        $this->vista("usuarios/logout");
    }
}

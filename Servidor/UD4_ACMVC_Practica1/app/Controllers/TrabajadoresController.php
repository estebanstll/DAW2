<?php

namespace App\Controllers;
use App\Models\Trabajadores;
use Core\Controller;

class TrabajadoresController extends Controller
{
    public function index(): void
    {
        $trabajadores = Trabajadores::getTodos();
        $this->vista("trabajadores/index", ['usuarios' => $trabajadores]);
    }

    public function editar(int $id): void
    {
        $trabajador = Trabajadores::getPorId($id);

        if (!$trabajador) {
            die('Error 404: Trabajador no encontrado con ID ' . $id);
        }

        
        $this->vista("trabajadores/editar", ['usuario' => $trabajador]);
    }

    public function actualizar($id): void
    {
        $id = (int)$id;
        $trabajador = Trabajadores::getPorId($id);

        if (!$trabajador) {
            die('Error 404: Trabajador no encontrado con ID ' . $id);
        }

        $nombre       = $_POST['nombre'] ?? '';
        $gmail        = $_POST['gmail'] ?? '';
        $contraseña   = $_POST['contraseña'] ?? '';
        $especialidad = $_POST['especialidad'] ?? null;

        $trabajador->setId($id);
        $trabajador->setNombre($nombre);
        $trabajador->setGmail($gmail);
        $trabajador->setContraseña($contraseña);
        $trabajador->setEspecialidad($especialidad);

        $trabajador->guardar();

        header('Location: ' . BASE_URL . 'trabajadores');
    }
}
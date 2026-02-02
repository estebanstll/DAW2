<?php

use App\Models\Notas;

// Cargar manualmente la clase Usuarios
require_once __DIR__.'/../modelos/Notas.php';

class NotasController extends Controlador{


    public function index($id){


    $notas=Notas::getAllNotas($id);
    $this->vista("notas/index", ["notas"=>$notas, "alumno_id" => $id]);

    }

    public function create($alumnoId = null){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $alumnoIdPost = $_POST['alumno_id'] ?? null;
            $asignatura = $_POST['asignatura'] ?? null;
            $nota = $_POST['nota'] ?? null;

            if (!$alumnoIdPost || !$asignatura || $nota === null || $nota === '') {
                http_response_code(400);
                echo 'Todos los campos son requeridos.';
                return;
            }

            $resultado = Notas::create([
                'alumno_id' => $alumnoIdPost,
                'asignatura' => $asignatura,
                'nota' => $nota
            ]);

            if (!empty($resultado['success'])) {
                header('Location: ' . BASE_URL . 'NotasController/index/' . $alumnoIdPost);
                exit;
            }

            http_response_code(400);
            echo $resultado['message'] ?? 'Error al crear nota.';
            return;
        }

        if (!$alumnoId) {
            http_response_code(400);
            echo 'ID del alumno requerido.';
            return;
        }

        $this->vista("alumnos/insertarNuevaNota", ["alumno_id" => $alumnoId]);
    }

    public function update($id = null){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idPost = $_POST['id'] ?? null;
            $alumnoId = $_POST['alumno_id'] ?? null;
            $nota = $_POST['nota'] ?? null;

            if (!$idPost || !$alumnoId || $nota === null || $nota === '') {
                http_response_code(400);
                echo 'Todos los campos son requeridos.';
                return;
            }

            $resultado = Notas::update($idPost, $nota);

            if (!empty($resultado['success'])) {
                header('Location: ' . BASE_URL . 'NotasController/index/' . $alumnoId);
                exit;
            }

            http_response_code(400);
            echo $resultado['message'] ?? 'Error al actualizar nota.';
            return;
        }

        if (!$id) {
            http_response_code(400);
            echo 'ID de la nota requerido.';
            return;
        }

        $nota = Notas::getById($id);
        $this->vista("notas/update", ["nota" => $nota]);
    }

    public function delete($id){

    Notas::delete($id);
    $this->index($id);

    }


    
    
    }
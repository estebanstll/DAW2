<?php

use App\Models\Alumnos;

// Cargar manualmente la clase Usuarios
require_once __DIR__.'/../modelos/Alumnos.php';

class AlumnosController extends Controlador{


    public function index($id){


    $alumnos=Alumnos::getAllProfe($id);
    $this->vista("alumnos/index", ["alumnos"=>$alumnos]);

    }


    public function update($id = null){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idPost = $_POST['id'] ?? null;
            $idProfe = $_POST['id_profe'] ?? null;
            $nombre = $_POST['nombre'] ?? null;
            $apellido = $_POST['apellido'] ?? ($_POST['Apellido'] ?? null);

            if (!$idPost || !$idProfe || !$nombre || !$apellido) {
                http_response_code(400);
                echo 'Todos los campos son requeridos.';
                return;
            }

            $payload = [
                'profesor_id' => $idProfe,
                'nombre' => $nombre,
                'apellido' => $apellido
            ];

            $resultado = Alumnos::update($idPost, $payload);

            if (!empty($resultado['success'])) {
                header('Location: ' . BASE_URL . 'AlumnosController/index/' . $idProfe);
                exit;
            }

            http_response_code(400);
            echo $resultado['message'] ?? 'Error al actualizar alumno.';
            return;
        }

        if (!$id) {
            http_response_code(400);
            echo 'ID del alumno requerido.';
            return;
        }

        $alumno = Alumnos::getById($id);
        $this->vista("alumnos/update",["alumno"=>$alumno]);

    }


}
<?php
namespace Dwes\Clinica;


class API extends Controlador{

 private function jsonResponse($data, int $status = 200): void
    {
        http_response_code($status);
        header("Content-Type: application/json");
        echo json_encode($data);
    }

    private function autenticar() {
        // Verificamos si las credenciales coinciden
        if (isset($_SERVER['PHP_AUTH_USER']) &&
            $_SERVER['PHP_AUTH_USER'] === 'dwes' &&
            $_SERVER['PHP_AUTH_PW'] === 'dwes') {

            // CÓDIGO SI ES CORRECTO:
            // No hace falta hacer nada, dejamos que el script continúe.
            return true;

        } else {

            // CÓDIGO SI FALLA O NO HA ENVIADO NADA AÚN:

            // 1. Enviar encabezado para que salga la ventanita del navegador
            header('WWW-Authenticate: Basic realm="Zona de Pruebas"');

            // 2. Enviar encabezado de "No autorizado"
            header('HTTP/1.0 401 Unauthorized');

            // 3. Mensaje para mostrar si el usuario pulsa "Cancelar"
            echo 'Usuario no autorizado. Debes introducir credenciales correctas.';

            // 4. IMPRESCINDIBLE: Matar el script para que no cargue el resto de la página
            exit;
        }
    }


    public function Personas($id = null){

        $this->autenticar();
        $modelo = $this->modelo("Personas");

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            if ($id) {
                $persona = $modelo->getByID((int)$id);
                if ($persona) {
                    $this->jsonResponse($persona);
                } else {
                    $this->jsonResponse(["mensaje" => "Persona no encontrada"], 404);
                }
            } else {
                $personas = $modelo->getAll();
                if (!empty($personas)) {
                    $this->jsonResponse($personas);
                } else {
                    $this->jsonResponse(["mensaje" => "No hay datos disponibles"], 404);
                }
            }
        } elseif ($method === 'POST') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true) ?? [];

            $modelo->setNombre($data['nombre'] ?? null);
            $modelo->setApellidos($data['apellidos'] ?? null);
            $modelo->setTelefono(isset($data['telefono']) ? (int)$data['telefono'] : null);
            $modelo->setEmail($data['email'] ?? null);

            $exito = $modelo->post();
            if ($exito) {
                $this->jsonResponse(["mensaje" => "Persona creada con éxito"], 201);
            } else {
                $this->jsonResponse(["mensaje" => "Error al crear la persona"], 500);
            }
        } elseif ($method === 'DELETE') {
            if (!$id) {
                $this->jsonResponse(["mensaje" => "ID necesario en la URL para eliminar"], 400);
                return;
            }
            $modelo->setId((int)$id);
            $exito = $modelo->deleteByID();
            $exito ? $this->jsonResponse(["mensaje" => "Persona $id eliminada"]) : $this->jsonResponse(["mensaje" => "Error al eliminar"], 500);
        }


    }


}
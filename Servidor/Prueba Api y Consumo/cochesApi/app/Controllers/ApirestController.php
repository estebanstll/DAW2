<?php
namespace App\Controllers;

use Core\Controller;
use App\Apirest\Tools\Jwt;
use \App\Models\ApiCoches;
class ApirestController extends Controller
{
    // Punto frontal: /apirest/api/<recurso>/[id]
    public function api(...$params)
    {
        header('Content-Type: application/json; charset=utf-8');

        $recurso = $params[0] ?? null;
        $id = $params[1] ?? null;

        try {
            switch ($recurso) {
                case 'coches':
                    if ($id) {
                        $this->handleCocheById($id);
                    } else {
                        $this->handleCochesAll();
                    }
                    break;
                default:
                    http_response_code(404);
                    echo json_encode(['error' => 'Recurso no encontrado']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    protected function handleCochesAll()
    {
        $coches = ApiCoches::obtenerTodos();
        echo json_encode($coches);
    }

    protected function handleCocheById($id)
    {
        $coche = ApiCoches::IdCoche((int)$id);
        if ($coche) {
            echo json_encode($coche);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Coche no encontrado']);
        }
    }

    
}

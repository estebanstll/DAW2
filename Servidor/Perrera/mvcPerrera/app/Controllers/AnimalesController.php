<?php


namespace App\Controllers;

use Core\Controller;
use App\Models\Animales;

class AnimalesController extends Controller{

public function index(){
    
    $respuesta = Animales::getAll();
    $this->vista("animales/index",["animales"=>$respuesta]);


}

public function verDetalles($id){

$respuesta = Animales::getPorId($id);
$this->vista("animales/detalles", ["animal"=>$respuesta]);
}


public function eliminar($id){


Animales::deletePorId($id);
$this->index();

}



public function update($id){

$respuesta = Animales::getPorId($id);
$this->vista("animales/update",["animal"=>$respuesta]);
}

public function actualizar(){

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . BASE_URL . '/Animales/index');
        exit;
    }

        $id = $_POST['id'] ?? null;
        $animal = $_POST['animal'] ?? null;
        $raza = $_POST['raza'] ?? null;
        $nombre = $_POST['nombre'] ?? null;
        $personaACargo = $_POST['personaACargo'] ?? null;


        if (empty($id) || empty($animal)  || empty($raza)  || empty($nombre)   || empty($personaACargo)) {
            $_SESSION['error'] = 'Todos los campos son requeridos';
            header('Location: ' . BASE_URL . '/Animales/update/'.$id);
            exit;
        }

        Animales::updatePorId($id,$animal,$raza,$nombre,$personaACargo);
        header('Location: '.BASE_URL.'/Animales/index ');
}


}
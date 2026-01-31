<?php


namespace App\Controllers;

use Core\Controller;

use App\Models\Coches;

class CochesController extends Controller{

    public function index():void{
        $listadoCoches = Coches::obtenerTodos();
        $this->vista("coches/index",["coches"=>$listadoCoches]);
    }

    public function VerCoche($id): void {
        $idCoche = Coches::IdCoche($id);
        $this->vista("coches/especifico", ["idCoche" => $idCoche]);
    }

    


}
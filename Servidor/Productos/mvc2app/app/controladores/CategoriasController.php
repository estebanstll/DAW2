<?php

use App\Models\Categorias;
require_once __DIR__.'/../modelos/Categorias.php';

class CategoriasController extends Controlador{


public function index(){

    $categorias = Categorias::getAll();
    $this->vista("categorias/index", ["categorias" => $categorias]);

}


}
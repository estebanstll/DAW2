<?php

use App\Models\Medicos;

// Cargar manualmente la clase medicos
require_once __DIR__.'/../modelos/Medicos.php';

class MedicosController extends Controlador{


public function index(){

$medicos= Medicos::getAll();
$this->vista("medicos/index", ["Medicos"=>$medicos]);

}

public function verdetalles($id){

$medicos= Medicos::getById($id);

$this->vista("medicos/detalles", ["Medicos"=>$medicos]);

}




}
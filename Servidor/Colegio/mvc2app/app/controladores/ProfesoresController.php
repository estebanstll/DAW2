<?php

use App\Models\Profesores;

// Cargar manualmente la clase Usuarios
require_once __DIR__.'/../modelos/Profesores.php';

class ProfesoresController extends Controlador{


    public function index(){

    $profesores=Profesores::getAll();
    $this->vista("profesores/index",["profesores"=>$profesores]);

    }


}
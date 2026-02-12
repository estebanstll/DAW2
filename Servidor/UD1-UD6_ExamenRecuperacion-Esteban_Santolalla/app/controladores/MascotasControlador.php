<?php
namespace Dwes\Clinica;

class MascotasControlador extends Controlador{

    public function index($id){

    $mascotas = $this->modelo("Mascotas");
    $datos = [
            'mascotas' => $mascotas->getByIdPersona($id)
        ];

    $this->vista("mascotas/index",$datos);
    }


    }



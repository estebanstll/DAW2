<?php

namespace App\Controllers;

use Core\Controller;
use Tools\Conexion;
use App\Models\Categoria;

class CategoriasController extends Controller
{
    public function __construct(){
    }

    public function index()
    {
        $categoria = $this->modelo("Categoria");

        $datos = $categoria->todas();

        $this->vista('categorias/index', $datos);

    }

}
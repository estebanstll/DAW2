<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Categoria;

class CategoriasController extends Controller
{
    public function index(): void
    {
        $categorias = Categoria::obtenerTodas();
        $this->vista("categorias/index", ["categoriasList" => $categorias]);
    }
}

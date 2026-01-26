<?php

namespace App\Controllers;
use App\Models\Producto;
use App\Models\Productos;
use Core\Controller;


class ProductosController extends Controller{


    public function index(): void
    {
        $productos = Productos::getAll();
        $this->vista("productos/index", ['products' => $productos]);
    }

    public function eliminar($id){
    
    Productos::delete($id);

    header("Location:" . BASE_URL."productos/index");
    exit;
    }
}
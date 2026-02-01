<?php

use App\Models\productos;

require_once __DIR__.'/../modelos/Productos.php';


class ProductosController extends Controlador{

public function index($id){

    $productos=productos::getProductoCategoria($id);

    $this->vista("productos/index",["productos"=>$productos]);


}


}
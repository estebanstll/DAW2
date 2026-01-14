<?php

class Articulo{ 
    private $bd;
    
    public function __construct()
    {
        $this->bd = new Db();

    }

    public function obtenerArticulos(){
        $this->bd->query("SELECT * FROM articulos");
        return $this->bd->registros();
    }
}

<?php

class Articulos extends Controlador
{
    private $articuloModelo;

    public function __construct()
    {
        $this->articuloModelo = $this->modelo('Articulo');
    }

    public function index()
    {
        $articulos = $this->articuloModelo->obtenerArticulos();
        $datos = [
            'titulo' => 'Artículos',
            'articulos' => $articulos
        ];
        $this->vista('paginas/ejemplo-inicio', $datos);
    }
}

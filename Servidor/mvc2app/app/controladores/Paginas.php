<?php

class Paginas extends Controlador
{
    private $datos;

    public function __construct()
    {
    }

    public function index()
    {

        $datos = [
            'titulo' => 'ED 23-24',
        ];

        $this->vista('paginas/inicio', $datos);
    }
}
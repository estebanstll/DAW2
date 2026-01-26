<?php

namespace App\Controllers;
use App\Models\Trabajadores;
use Core\Controller;

class TrabajadoresController extends Controller
{
    public function index(): void
    {
        $trabajadores = Trabajadores::getTodos();
        $this->vista("trabajadores/index", ['usuarios' => $trabajadores]);
    }
}
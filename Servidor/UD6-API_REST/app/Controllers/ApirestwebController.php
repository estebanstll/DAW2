<?php
namespace App\Controllers;

use Core\Controller;

class ApirestwebController extends Controller
{
    public function index()
    {
        $this->vista('apirest_web/index');
    }

    public function login()
    {
        $this->vista('apirest_web/login');
    }

    public function categorias()
    {
        $this->vista('apirest_web/categorias');
    }

    public function productos()
    {
        $this->vista('apirest_web/productos');
    }

    public function pedidos()
    {
        $this->vista('apirest_web/pedidos');
    }
}

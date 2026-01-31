<?php

namespace Core;

class Router
{
    // Nombre del controlador (string)
    protected string $controladorNombre = 'ApirestController';

    // Instancia del controlador (objeto)
    protected object $controladorActual;

    protected string $metodoActual = 'index';
    protected array $parametros = [];

    protected string $namespaceControladores = 'App\\Controllers\\';

    public function __construct()
    {
        $url = $this->getUrl();

        // ===== CONTROLADOR =====
        if (isset($url[0])) {
            $nombreControlador = ucfirst($url[0]) . 'Controller';
            $rutaControlador   = '../app/Controllers/' . $nombreControlador . '.php';

            if (file_exists($rutaControlador)) {
                $this->controladorNombre = $nombreControlador;
                unset($url[0]);
            }
        }

        // ===== CARGAR CONTROLADOR =====
        $rutaControlador = '../app/Controllers/' . $this->controladorNombre . '.php';

        if (!file_exists($rutaControlador)) {
            die('Error 404: Controlador no encontrado');
        }

        require_once $rutaControlador;

        $claseCompleta = $this->namespaceControladores . $this->controladorNombre;
        $this->controladorActual = new $claseCompleta;

        // ===== MÉTODO =====
        if (isset($url[1]) && method_exists($this->controladorActual, $url[1])) {
            $this->metodoActual = $url[1];
            unset($url[1]);
        } elseif (isset($url[1])) {
            die('Error 404: Método no encontrado');
        }

        // ===== PARÁMETROS =====
        $this->parametros = $url ? array_values($url) : [];

        // ===== EJECUTAR =====
        call_user_func_array(
            [$this->controladorActual, $this->metodoActual],
            $this->parametros
        );
    }

    public function getUrl(): ?array
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }

        return null;
    }
}

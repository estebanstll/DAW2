<?php

namespace Core;

// Ruta base del proyecto (un nivel arriba de /core)
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

class Router
{
    // Nombre del controlador (string)
    // Por defecto usar ApirestwebController para exponer la interfaz de pruebas
    protected string $controladorNombre = 'ApirestwebController';

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
            $rutaControlador   = APP_ROOT . '/app/Controllers/' . $nombreControlador . '.php';

            if (file_exists($rutaControlador)) {
                $this->controladorNombre = $nombreControlador;
                unset($url[0]);
            }
        }

        // ===== CARGAR CONTROLADOR =====
        $rutaControlador = APP_ROOT . '/app/Controllers/' . $this->controladorNombre . '.php';

        if (!file_exists($rutaControlador)) {
            die('Error 404: Controlador no encontrado en: ' . $rutaControlador);
        }

        require_once $rutaControlador;

        $claseCompleta = $this->namespaceControladores . $this->controladorNombre;
        $this->controladorActual = new $claseCompleta;

        // ===== MÉTODO =====
        if (isset($url[1]) && method_exists($this->controladorActual, $url[1])) {
            $this->metodoActual = $url[1];
            unset($url[1]);
        } elseif (isset($url[1])) {
            die('Error 404: Método no encontrado: ' . $url[1]);
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
        // Primero intentar obtener de $_GET['url'] (reescritura .htaccess)
        if (isset($_GET['url']) && !empty($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }

        // Si no hay $_GET['url'], parsear desde REQUEST_URI
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        // Determinar base path dinámicamente desde SCRIPT_NAME (p. ej. /ApiRest/public)
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        if ($scriptDir === '.' || $scriptDir === '\\' || $scriptDir === '') {
            $basePath = '/';
        } else {
            $basePath = $scriptDir;
            if (substr($basePath, -1) !== '/') $basePath .= '/';
        }

        // Si la URI comienza por el basePath, quitarlo
        if ($basePath !== '/' && strpos($requestUri, $basePath) === 0) {
            $url = substr($requestUri, strlen($basePath));
        } else {
            $url = $requestUri;
        }

        // Quitar query string
        if (($pos = strpos($url, '?')) !== false) {
            $url = substr($url, 0, $pos);
        }

        // Normalizar: eliminar slashes iniciales y finales
        $url = trim($url, '/');

        if ($url === '' || $url === 'index.php') {
            return null;
        }

        // Devolver segmentos limpios
        return explode('/', $url);
    }
}

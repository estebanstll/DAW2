<?php

ob_start(); // Iniciar buffer de salida para permitir redirecciones



require_once __DIR__ . "/../vendor/autoload.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define("BASE_URL", "/Servidor/UD4_AC2_MVC/public/");
define("CSS_URL", "/Servidor/UD4_AC2_MVC/public/css/");

use Core\Router;

// Mostrar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);



try {
    $router = new Router();
} catch (\Exception $e) {
    die("Error en Router: " . $e->getMessage() . "<br>" . $e->getTraceAsString());
}



ob_end_flush(); // Enviar el buffer
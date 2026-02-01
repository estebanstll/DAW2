<?php

/**
 * ========================================
 * PUNTO DE ENTRADA DE LA APLICACIÓN
 * ========================================
 * Este archivo es el único punto de entrada público de la aplicación.
 * Todas las peticiones pasan por aquí gracias al .htaccess
 */

// Buffer de salida para permitir redirecciones
ob_start();

// Cargar autoload de Composer
require_once __DIR__ . "/../vendor/autoload.php";

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ========================================
// CONFIGURACIÓN DE RUTAS
// ========================================
// IMPORTANTE: Cambia estas rutas según tu entorno
// En desarrollo local (servidor integrado PHP): usa "/"
// En XAMPP/WAMP con subcarpeta: usa "/nombre_carpeta/public/"
// En producción: usa "/" o la ruta correspondiente

define("BASE_URL", "/ApiPerrera/public/");  // CAMBIA ESTO según tu entorno
// Ejemplo desarrollo: define("BASE_URL", "/mi_proyecto/public/");

// ========================================
// CONFIGURACIÓN DE ERRORES
// ========================================
// DESARROLLO: Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// PRODUCCIÓN: Ocultar errores y guardarlos en log
// error_reporting(0);
// ini_set('display_errors', 0);
// ini_set('log_errors', 1);
// ini_set('error_log', __DIR__ . '/../logs/php-errors.log');

// ========================================
// INICIAR ROUTER
// ========================================
use Core\Router;

try {
    $router = new Router();
} catch (\Exception $e) {
    // En desarrollo, mostrar detalles del error:
    die("Error en Router: " . $e->getMessage() . "<br>" . $e->getTraceAsString());
    
    // En producción, mostrar página de error genérica
    // die("Error en la aplicación. Por favor, contacta al administrador.");
}

// Enviar el buffer de salida
ob_end_flush();

<?php
// Test directo - Simula acceso a articulos
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../app/iniciador.php';

// Simulamos la URL como si fuera /articulos
$_GET['url'] = 'articulos';

echo "<h1>Test: Cargando Articulos...</h1>";

try {
    $iniciar = new Core();
} catch (Exception $e) {
    echo "<h2 style='color:red'>Error: " . $e->getMessage() . "</h2>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
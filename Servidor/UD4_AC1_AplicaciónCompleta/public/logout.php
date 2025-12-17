<?php


if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$carrito = $_SESSION['ventas'] ?? null;

$_SESSION = [];

if ($carrito !== null) {
    $_SESSION['ventas'] = $carrito;
}

if (function_exists('session_regenerate_id')) {
    session_regenerate_id(true);
}

header('Location: index.php');
exit;

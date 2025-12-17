<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


function eliminarProducto(int $codProd): void
{
    if (isset($_SESSION['ventas'][$codProd])) {
        unset($_SESSION['ventas'][$codProd]);
        if (empty($_SESSION['ventas'])) {
            unset($_SESSION['ventas']);
        }
    }
}


function restarCantidad(int $codProd, int $cantidad): void
{
    if ($cantidad <= 0) {
        return;
    }
    if (!isset($_SESSION['ventas'][$codProd])) {
        return;
    }

    $actual = (int)$_SESSION['ventas'][$codProd];
    $nuevo = $actual - $cantidad;
    if ($nuevo > 0) {
        $_SESSION['ventas'][$codProd] = $nuevo;
    } else {
        unset($_SESSION['ventas'][$codProd]);
        if (empty($_SESSION['ventas'])) {
            unset($_SESSION['ventas']);
        }
    }
}


function vaciarCarrito(): void
{
    if (isset($_SESSION['ventas'])) {
        unset($_SESSION['ventas']);
    }
}

$accion = $_GET['accion'] ?? null;
$cod = isset($_GET['codprod']) ? (int)$_GET['codprod'] : null;
$cant = isset($_GET['cantidad']) ? (int)$_GET['cantidad'] : null;
$return = $_GET['return'] ?? 'confirmar_pedido.php';

if ($accion === 'eliminar' && $cod !== null) {
    eliminarProducto($cod);
    header('Location: ' . $return);
    exit;
}

if ($accion === 'vaciar') {
    vaciarCarrito();
    header('Location: ' . $return);
    exit;
}

if ($accion === 'restar' && $cod !== null && $cant !== null) {
    restarCantidad($cod, max(0, $cant));
    header('Location: ' . $return);
    exit;
}


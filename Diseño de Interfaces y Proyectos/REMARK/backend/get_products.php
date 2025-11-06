<?php
// Endpoint: devuelve todos los productos en JSON
header("Content-Type: application/json; charset=utf-8");
include "db.php";

// Debug: registrar en el log del servidor que entramos al script
error_log("get_products.php: iniciando consulta de productos");

$sql = "SELECT nombre, categoria, etiquetas, precio, imagen FROM productos";
$result = $conn->query($sql);

if ($result === false) {
    // registrar error de consulta en el log
    error_log("get_products.php: error en consulta SQL: " . $conn->error);
    echo json_encode([], JSON_UNESCAPED_UNICODE);
    $conn->close();
    exit;
}

$productos = [];

$brands_from_row = [];
if ($result && $result->num_rows > 0) {
    error_log("get_products.php: filas obtenidas = " . $result->num_rows);
    while ($row = $result->fetch_assoc()) {
        // intentar extraer una 'marca' a partir de la columna 'etiquetas' (primer token)
        $marca = '';
        if (!empty($row['etiquetas'])) {
            $parts = explode(',', $row['etiquetas']);
            $marca = trim($parts[0]);
        }

        $productos[] = [
            'nombre' => $row['nombre'],
            'categoria' => $row['categoria'],
            'marca' => $marca,
            'precio' => $row['precio'],
            'imagen' => $row['imagen']
        ];
    }
} else {
    error_log("get_products.php: ninguna fila devuelta");
}

echo json_encode($productos, JSON_UNESCAPED_UNICODE);
$conn->close();
?>

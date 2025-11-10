<?php
// Endpoint: búsqueda de productos
// Devuelve un JSON con los productos encontrados o un array vacío si no hay resultados

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

include "db.php";

// Comprobamos que la conexión existe
if (!isset($conn) || $conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión a la base de datos"]);
    exit;
}

$termino = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';
$productos = [];

if ($termino !== '') {
    $sql = "
        SELECT p.id, p.nombre, p.categoria, p.precio, p.imagen,
               GROUP_CONCAT(e.nombre SEPARATOR ',') AS marcas
        FROM productos p
        LEFT JOIN producto_etiqueta pe ON p.id = pe.id_producto
        LEFT JOIN etiquetas e ON pe.id_etiqueta = e.id
        WHERE p.nombre LIKE '%$termino%'
           OR p.descripcion LIKE '%$termino%'
           OR p.categoria LIKE '%$termino%'
           OR e.nombre LIKE '%$termino%'
        GROUP BY p.id
        ORDER BY p.id DESC
    ";

    $result = $conn->query($sql);

    if ($result === false) {
        error_log('buscar.php SQL error: ' . $conn->error . ' -- SQL: ' . $sql);
        http_response_code(500);
        echo json_encode(["error" => "Error al ejecutar la búsqueda."]);
        exit;
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convertimos la columna marcas en array
            $marcasArray = [];
            if (!empty($row['marcas'])) {
                $marcasArray = array_map('trim', explode(',', $row['marcas']));
            }

            $productos[] = [
                "id" => (int)$row["id"],
                "nombre" => $row["nombre"],
                "categoria" => $row["categoria"],
                "marca" => $marcasArray,  // siempre array
                "precio" => (float)$row["precio"],
                "imagen" => $row["imagen"]
            ];
        }
    }
}

// Devolvemos JSON válido
echo json_encode($productos, JSON_UNESCAPED_UNICODE);

// Cerramos conexión
$conn->close();
?>

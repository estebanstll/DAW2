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
    // Consulta limpia y sin barras invertidas
    $sql = "
        SELECT nombre, categoria, etiquetas, precio, imagen
        FROM productos
        WHERE nombre LIKE '%$termino%'
           OR descripcion LIKE '%$termino%'
           OR categoria LIKE '%$termino%'
           OR etiquetas LIKE '%$termino%'
        ORDER BY id DESC
    ";

    $result = $conn->query($sql);

    if ($result === false) {
        // Registrar el error en el log del servidor
        error_log('buscar.php SQL error: ' . $conn->error . ' -- SQL: ' . $sql);

        // Enviar respuesta controlada al cliente
        http_response_code(500);
        echo json_encode(["error" => "Error al ejecutar la búsqueda."]);
        exit;
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Derivar 'marca' desde 'etiquetas' (primer token)
            $marca = '';
            if (!empty($row['etiquetas'])) {
                $parts = explode(',', $row['etiquetas']);
                $marca = trim($parts[0]);
            }

            $productos[] = [
                "nombre" => $row["nombre"],
                "categoria" => $row["categoria"],
                "marca" => $marca,
                "precio" => $row["precio"],
                "imagen" => $row["imagen"]
            ];
        }
    }
}

// Si no hay resultados o término vacío, devolvemos array vacío (JSON válido)
echo json_encode($productos, JSON_UNESCAPED_UNICODE);

// Cerramos conexión
$conn->close();
?>

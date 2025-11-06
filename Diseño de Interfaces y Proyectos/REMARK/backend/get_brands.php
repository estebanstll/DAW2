<?php
// Devuelve marcas únicas (extraídas de 'etiquetas')
include "db.php";
error_log("get_brands.php: iniciando consulta de marcas");

// extraer marcas desde 'etiquetas'
$result = $conn->query("SELECT etiquetas FROM productos");
if ($result === false) {
    error_log("get_brands.php: error en consulta SQL: " . $conn->error);
    echo json_encode([]);
    $conn->close();
    exit;
}

$marcas = [];
while ($row = $result->fetch_assoc()) {
    if (empty($row['etiquetas'])) continue;
    $parts = explode(',', $row['etiquetas']);
    foreach ($parts as $p) {
        $m = trim($p);
        if ($m === '') continue;
        $marcas[$m] = true; // usar clave para uniquear
    }
}

$marcas = array_values(array_keys($marcas));
error_log("get_brands.php: marcas obtenidas = " . count($marcas));
echo json_encode($marcas);
?>

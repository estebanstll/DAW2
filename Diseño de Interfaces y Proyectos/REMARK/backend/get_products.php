<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';

$sql = "
    SELECT 
        p.id,
        p.nombre,
        p.categoria,
        p.descripcion,
        p.precio,
        p.imagen,
        p.estado,
        p.fecha_publicacion,
        GROUP_CONCAT(e.nombre SEPARATOR ',') AS marcas
    FROM productos p
    LEFT JOIN producto_etiqueta pe ON p.id = pe.id_producto
    LEFT JOIN etiquetas e ON pe.id_etiqueta = e.id
    GROUP BY p.id
    ORDER BY p.fecha_publicacion DESC
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode([]);
    exit;
}

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = [
        "id" => (int)$row["id"],
        "nombre" => $row["nombre"],
        "categoria" => $row["categoria"],
        "descripcion" => $row["descripcion"],
        "precio" => (float)$row["precio"],
        "imagen" => $row["imagen"],
        "estado" => $row["estado"],
        "fecha_publicacion" => $row["fecha_publicacion"],
        "marca" => $row["marcas"] ? explode(',', $row["marcas"]) : []
    ];
}

echo json_encode($productos, JSON_UNESCAPED_UNICODE);
?>

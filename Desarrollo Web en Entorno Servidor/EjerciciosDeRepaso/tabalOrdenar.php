<?php

$jugadores = [
    ['id' => 1, 'nombre' => 'Luis', 'puntos' => 50],
    ['id' => 2, 'nombre' => 'Ana', 'puntos' => 90],
    ['id' => 3, 'nombre' => 'Carlos', 'puntos' => 50],
    ['id' => 4, 'nombre' => 'Beatriz', 'puntos' => 90],
    ['id' => 5, 'nombre' => 'David', 'puntos' => 120],
];

// Filtros permitidos
$filtros_validos = ['id', 'nombre', 'puntos'];
$ordenes_validos = ['asc', 'desc'];

if (!empty($_GET['filtro']) && in_array($_GET['filtro'], $filtros_validos)) {

    $filtro = $_GET['filtro'];
    $orden = (!empty($_GET['ord']) && in_array($_GET['ord'], $ordenes_validos)) ? $_GET['ord'] : 'asc';

    // Extraer columna a ordenar
    $columna = array_column($jugadores, $filtro);

    // Ordenar según el orden indicado
    array_multisort($columna, $orden === 'asc' ? SORT_ASC : SORT_DESC, $jugadores);
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Jugadores</title>

    <style>
        table {
            border-collapse: collapse;
            width: 40%;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #eee;
        }

        a {
            margin-left: 5px;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <h2>Jugadores</h2>

    <table>
        <tr>
            <th>
                ID
                <a href="?filtro=id&ord=asc">▲</a>
                <a href="?filtro=id&ord=desc">▼</a>
            </th>
            <th>
                Nombre
                <a href="?filtro=nombre&ord=asc">▲</a>
                <a href="?filtro=nombre&ord=desc">▼</a>
            </th>
            <th>
                Puntos
                <a href="?filtro=puntos&ord=asc">▲</a>
                <a href="?filtro=puntos&ord=desc">▼</a>
            </th>
        </tr>

        <?php foreach ($jugadores as $j): ?>
            <tr>
                <td><?= $j['id'] ?></td>
                <td><?= htmlspecialchars($j['nombre']) ?></td>
                <td><?= $j['puntos'] ?></td>
            </tr>
        <?php endforeach; ?>

    </table>

</body>

</html>
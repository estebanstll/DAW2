<?php

define('N', 10);

function generarTituloAleatorio() {
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    $tituloLong = rand(1, 10);
    return substr(str_shuffle($permitted_chars), 0, $tituloLong);
}

function generarNumeroPaginas() {
    return random_int(100, 99999999);
}

function generarPrecioAleatorio() {
    $parte_entera = rand(1, 999);
    $parte_decimal = rand(1, 99999);
    return floatval($parte_entera . "." . str_pad($parte_decimal, 5, '0', STR_PAD_LEFT));
}

function generarFechaAleatoria() {
    $inicio = strtotime('2025-01-01');
    $fin = strtotime('2025-09-30');
    $timestamp_random = rand($inicio, $fin);
    return date('d/m/Y', $timestamp_random);
}


function Cantidad() {
    $coleccion = array();

    for ($i = 0; $i < N; $i++) {
        $libro = array(
            "titulo" => generarTituloAleatorio(),
            "n_paginas" => generarNumeroPaginas(),
            "precio" => generarPrecioAleatorio(),
            "fecha_publicacion" => generarFechaAleatoria()
        );

        $coleccion[] = $libro;
    }

    return $coleccion;
}

$libros = Cantidad();

echo '<table border="1" cellpadding="5" cellspacing="0">';
echo '<thead>';
echo '<tr>';
echo '<th>Título</th>';
echo '<th>Número de Páginas</th>';
echo '<th>Precio</th>';
echo '<th>Fecha de Publicación</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

foreach ($libros as $libro) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($libro['titulo']) . '</td>';
    echo '<td>' . number_format($libro['n_paginas']) . '</td>';
    echo '<td>$' . number_format($libro['precio'], 2) . '</td>';
    echo '<td>' . $libro['fecha_publicacion'] . '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

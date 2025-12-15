<?php
require_once 'Hobby.php';
require_once 'generadordehobbys.php';

define('N', 3);
$gen = new GeneradorAleatorio();

echo "--- Hobbies de Lectura ---<br>";
for ($i=0; $i<N; $i++) {
    $libro = new Lectura("Libro " . ($i+1), $gen->generarEditorial(), $gen->generarPaginas());
    echo $libro . "<br>";
    $libro->iniciar();
    $libro->detener();
}

echo "<br>--- Hobbies de Entrenamiento ---<br>";
for ($i=0; $i<N; $i++) {
    $entreno = new Entrenamiento("Ejercicio " . ($i+1), $gen->generarDuracion(), $gen->generarCalorias());
    echo $entreno . "<br>";
    $entreno->iniciar();
    $entreno->detener();
}

echo "<br>";
Hobby::mostrarTotal();

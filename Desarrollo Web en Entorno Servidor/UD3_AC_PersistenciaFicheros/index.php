<?php

$alfabeto = range('a', 'z');
$archivo = "alfabeto.txt";

$fp = fopen($archivo, "w");

$contador = 0;
foreach ($alfabeto as $letra) {
    fwrite($fp, $letra . " ");
    $contador++;

    if ($contador == 5) {
        fwrite($fp, PHP_EOL);
        $contador = 0;
    }
}

fclose($fp);



$fp = fopen($archivo, "r");

if (!is_dir("letras"))
    mkdir("letras");
if (!is_dir("copiasletras"))
    mkdir("copiasletras");

while (($linea = fgets($fp)) !== false) {

    $letras = explode(" ", trim($linea));

    foreach ($letras as $letra) {
        if ($letra === "")
            continue;

        $ruta = "letras/$letra.txt";

        if (!file_exists($ruta)) {
            file_put_contents($ruta, $letra);
        }
    }
}



rewind($fp);

while (($linea = fgets($fp)) !== false) {

    $letras = explode(" ", trim($linea));

    foreach ($letras as $letra) {
        if ($letra === "")
            continue;

        $origen = "letras/$letra.txt";
        $destino = "copiasletras/$letra.txt";

        if (file_exists($origen)) {
            copy($origen, $destino);
        }
    }
}

fclose($fp);

echo "okey";


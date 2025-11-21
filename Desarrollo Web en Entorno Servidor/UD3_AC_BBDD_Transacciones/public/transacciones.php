<?php
require_once "../src/GestorLectura.php";

$gestor = new GestorLectura();

// mete registros normales
function pruebaRegistrosValidos(GestorLectura $g)
{
    echo "<h2>prueba a: registros normales</h2>";

    $r = [
        [
            'titulo_libro' => 'a',
            'autor' => 'farfa',
            'paginas' => 150,
            'terminado' => 1,
            'fecha_lectura' => '2025-11-21',
            'comentario' => 'registro 1'
        ],
        [
            'titulo_libro' => 'b',
            'autor' => 'gero',
            'paginas' => 200,
            'terminado' => 0,
            'fecha_lectura' => null,
            'comentario' => 'registro 2'
        ]
    ];

    try {
        $g->insertarVarios($r);
        echo "<p>exito</p>";
    } catch (Exception $e) {
        echo "<p>error: {$e->getMessage()}</p>";
    }
}

// mete registros duplicados pa probar rollback
function pruebaRegistrosDuplicados(GestorLectura $g)
{
    echo "<h2>prueba b: registros duplicados</h2>";

    $r = [
        [
            'titulo_libro' => 'dup',
            'autor' => 'farfa',
            'paginas' => 150,
            'terminado' => 1,
            'fecha_lectura' => '2025-11-21',
            'comentario' => 'registro 1'
        ],
        [
            'titulo_libro' => 'dup',
            'autor' => 'gero',
            'paginas' => 200,
            'terminado' => 0,
            'fecha_lectura' => null,
            'comentario' => 'registro 2'
        ]
    ];

    try {
        $g->insertarVarios($r);
        echo "<p>probando rollback</p>";
    } catch (Exception $e) {
        echo "<p>revertido</p>";
    }
}
?>

<?php
	// Array asociativo de un videojuego
$videojuego = [
    "titulo" => "Elden Ring",
    "genero" => "RPG",
    "plataforma" => "PC",
    "valoracion" => 9.5
];



    echo("El juego {$videojuego['titulo']} es del género {$videojuego['genero']} y está disponible en {$videojuego['genero']} con una valoración de {$videojuego['valoracion']}.");



// Array asociativo de un jugador
$jugador = [
    "nombre" => "Alex",
    "nivel" => 35,
    "juegos" => ["Elden Ring", "God of War", "FIFA 22"],
    "tiempo_total" => 120  // en horas
];

$catalogo = [
    [
        "titulo" => "Elden Ring",
        "genero" => "RPG",
        "plataforma" => "PC",
        "valoracion" => 9.5
    ],
    [
        "titulo" => "FIFA 22",
        "genero" => "Deportes",
        "plataforma" => "PS5",
        "valoracion" => 8.0
    ],
    [
        "titulo" => "Minecraft",
        "genero" => "Aventura",
        "plataforma" => "PC",
        "valoracion" => 9.0
    ]
];
    echo "<br>";
    echo "<br>";
    echo "<br>";

foreach ($catalogo as $cat) {
    echo("El juego {$cat['titulo']} es del género {$cat['genero']} y está disponible en {$cat['genero']} con una valoración de {$cat['valoracion']}.");
    echo "<br>";

}

// Lista de jugadores
$jugadores = [
    [
        "nombre" => "Alex",
        "nivel" => 35,
        "juegos" => ["Elden Ring", "FIFA 22"],
        "tiempo_total" => 120
    ],
    [
        "nombre" => "Lucía",
        "nivel" => 42,
        "juegos" => ["Minecraft", "FIFA 22"],
        "tiempo_total" => 150
    ]
];

foreach ($jugadores as $jug) {
    echo "<br><br><br>";
    $lista_juegos = implode(", ", $jug['juegos']); // convierte el array en string separado por comas
    echo "El jugador {$jug['nombre']} de nivel {$jug['nivel']} con sus juegos ({$lista_juegos}) tiene un total de {$jug['tiempo_total']} horas.";
    echo "<br>";
}
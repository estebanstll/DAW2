<?php

    $videojuego = [
        "titulo" => "Elden Ring",
        "genero" => "RPG",
        "plataforma" => "PC",
        "valoracion" => 9.5
    ];



        echo("El juego {$videojuego['titulo']} es del género {$videojuego['genero']} y está disponible en {$videojuego['genero']} con una valoración de {$videojuego['valoracion']}.");

        $videojuego['valoracion']=9;

        echo("<br>El juego {$videojuego['titulo']} es del género {$videojuego['genero']} y está disponible en {$videojuego['genero']} con una valoración de {$videojuego['valoracion']}.");

        unset($videojuego['valoracion']);

        echo("<br>El juego {$videojuego['titulo']} es del género {$videojuego['genero']} y está disponible en {$videojuego['genero']} con una valoración de {$videojuego['valoracion']}.");

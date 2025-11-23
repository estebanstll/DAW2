<?php

class Videojuego {

    public $nombre;
    public $genero;
    public $plataforma;
    public $valoracion;

    public function __construct($nombre, $genero, $plataforma, $valoracion) {
        $this->nombre = $nombre;
        $this->genero = $genero;
        $this->plataforma = $plataforma;
        $this->valoracion = $valoracion;
    }

    // GETTERS
    public function getNombre(): string {
        return $this->nombre;
    }

    public function getGenero(): string {
        return $this->genero;
    }

    public function getPlataforma(): string {
        return $this->plataforma;
    }

    public function getValoracion() {
        return $this->valoracion;
    }

    // SETTERS
    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setGenero($genero): void {
        $this->genero = $genero;
    }

    public function setPlataforma($plataforma): void {
        $this->plataforma = $plataforma;
    }

    public function setValoracion($valoracion): void {
        $this->valoracion = $valoracion;
    }

    public function mostrarInfo() {
        echo "Título: " . $this->nombre . "<br>";
        echo "Género: " . $this->genero . "<br>";
        echo "Plataforma: " . $this->plataforma . "<br>";
        echo "Valoración: " . $this->valoracion . "<br><br>";
    }
}


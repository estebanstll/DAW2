<?php
    require_once "./biblioteca.php";
    class Jugador {
        private $nombre;
        private $biblio;

        public function __construct($nombre) {
            $this->nombre = $nombre;
            $this->biblio = new Biblioteca();
        }

        public function getNombre() {
            return $this->nombre;
        }

        public function getbiblio() {
            return $this->biblio;
        }

        public function añadirJuego($juego) {
            $this->biblio->agregarJuego($juego);
        }

        public function mostrarMisJuegos() {
            echo "Catálogo de " . $this->nombre . ":<br>";
            $this->biblio->mostrarCatalogo();
        }
    }
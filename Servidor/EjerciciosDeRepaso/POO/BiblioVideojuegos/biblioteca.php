<?php
class Biblioteca{

    private $array=[];

    public function __construct(){

        $this->array = [];

    }
     public function getArray() {
        return $this->array;
    }

    function agregarJuego($videojuego){
        array_push($this->array, $videojuego);
    }

    function obtenerPorGenero($genero):array{
        $output=[];
        foreach($this->array as $a){

            if($a['genero']===$genero){
                array_push($output, $a);
            }
        }
        return $output;
    }
     public function mostrarCatalogo() {
        foreach ($this->array as $juego) {
            $juego->mostrarInfo();
        }
    }
}
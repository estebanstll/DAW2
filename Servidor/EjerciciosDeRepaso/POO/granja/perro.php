<?php
    require_once "./animal.php";


    class perro extends animal{

        public $sonido;
        public function __construct($sonido){
            $this->sonido=$sonido;
        }

        public function hacerSonido(): string{


            return $this->sonido;
        }


    }



    $perro = new perro("guau");

    echo($perro->hacerSonido());
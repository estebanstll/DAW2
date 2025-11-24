<?php 
    interface Transporte{

        public function arrancar(){}
        public function detener(){}
        public function velocidadMaxima(){}

    }


    class coche implements Transporte{

        public $marca;
        public $velocidadMax;


        public function __construct($marca, $velo){

            $this->marca=$marca;
            $this->velocidadMax=$velo;

        }

        public function arrancar() {
        echo "El coche {$this->marca} está arrancando...<br>";
    }

    public function detener() {
        echo "El coche {$this->marca} se ha detenido.<br>";
    }

    public function velocidadMaxima() {
        return $this->velocidadMax;
    }

    }   
    
    $coche =new Coche("Toyota", 180);

     
    
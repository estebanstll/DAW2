<?php
namespace Core;

class Controller{

    //Cargar modelo
    public function modelo(string $modelo){
        $ruta = '../app/Models/' . $modelo . '.php';

        if (!file_exists($ruta)) {
            die("El modelo $modelo no existe");
        }

        require_once $ruta;

        $clase = "App\\Models\\$modelo";
        return new $clase();
    }

    //Cargar vista
    public function vista($vista, $datos = []){
        //Comprobar si existe el archivo de vista.
        if (file_exists('../app/Views/'.$vista.'.php')){
            extract($datos);
            require_once '../app/Views/'.$vista.'.php';
        }else{
            //si el archivo de vista no existe
            die('La vista no exite');
        }
    }
}

<?php
namespace Core;

// Ruta base del proyecto (un nivel arriba de /core)
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

class Controller{

    //Cargar modelo
    public function modelo(string $modelo){
        $ruta = APP_ROOT . '/app/Models/' . $modelo . '.php';

        if (!file_exists($ruta)) {
            die("El modelo $modelo no existe en: $ruta");
        }

        require_once $ruta;

        $clase = "App\\Models\\$modelo";
        return new $clase();
    }

    //Cargar vista
    public function vista($vista, $datos = []){
        $rutaVista = APP_ROOT . '/app/Views/' . $vista . '.php';
        
        if (file_exists($rutaVista)){
            extract($datos);
            require_once $rutaVista;
        }else{
            die("La vista no existe en: $rutaVista");
        }
    }
}

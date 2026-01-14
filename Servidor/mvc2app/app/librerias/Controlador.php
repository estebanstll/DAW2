<?php

//Clase controlador principal
//Carga los modelos y las vistas.

class Controlador
{

    //Cargar modelo
    public function modelo($modelo)
    {
        //carga
        require_once RUTA_APP . '/modelos/' . $modelo . '.php';
        //Instanciar el modelo
        return new $modelo();
    }

    //Cargar vista
    public function vista($vista, $datos = [])
    {
        //Comprobar si existe el archivo de vista.
        if (file_exists(RUTA_APP . '/vistas/' . $vista . '.php')) {
            require_once RUTA_APP . '/vistas/' . $vista . '.php';
        } else {
            //si el archivo de vista no existe
            die('La vista no existe');
        }
    }
}
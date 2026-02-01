<?php
    //Cargamos librerias
    require_once __DIR__.'/../app/config/config.php';

    //require_once __DIR__.'/../app/librerias/Db.php';
    //require_once __DIR__.'/../app/librerias/Controlador.php';
    //require_once __DIR__.'/../app/librerias/Core.php';

    
    //Autoload php
    spl_autoload_register(function($nombreClase){
        require_once __DIR__.'/../app/librerias/'.$nombreClase.'.php';
    });



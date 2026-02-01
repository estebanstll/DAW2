<?php
    //cargando el iniciador
    //require_once $_SERVER['DOCUMENT_ROOT'].'/ud5/mvc2app/app/iniciador.php';

 //   require_once $_SERVER['DOCUMENT_ROOT'].'/ud5/mvc2app/app/librerias/Dd.php';
    //require_once $_SERVER['DOCUMENT_ROOT'].'/ud5/mvc2app/app/librerias/Controlador.php';
    //require_once $_SERVER['DOCUMENT_ROOT'].'/ud5/mvc2app/app/librerias/Core.php';

 
    //require_once '/ud5/mvc2app/app/iniciador.php';
    require_once __DIR__.'/../app/iniciador.php';

    //$i = __DIR__.'/../app/iniciador.php';
    
    //$BASE = $_SERVER['DOCUMENT_ROOT'];

    // Instanciamos el controlador
    $iniciar = new Core();

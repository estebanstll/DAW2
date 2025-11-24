<?php
    $usuario = $_POST['usuario'];
    $contra = $_POST['contraseña'];


    if($usuario==="admin" && $contra ==="1234"){


    echo("login realizado con exito");

    }else{

        echo("login fallido");
    }
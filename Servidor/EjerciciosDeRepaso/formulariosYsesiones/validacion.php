<?php
    session_start();
    $user= $_POST['nombre'];
    $pwds= $_POST['pswd'];

    if ($user==="user" && $pwds==="1234") {
       $_SESSION['usuario_autenticado'] = $usuario;
        header('Location: calculos.php');
    }else{


        echo("error");
    }
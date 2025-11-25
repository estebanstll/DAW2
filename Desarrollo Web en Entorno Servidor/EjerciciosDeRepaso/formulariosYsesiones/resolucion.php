<?php
    session_start();
    $numero1 = $_POST['uno'];
    $numero2 = $_POST['dos'];
    $operador = $_POST['op'];

    $resultado = 0;

    if ($operador == '+') {
        $resultado = $numero1 + $numero2;
        echo "entre";
    } elseif ($operador == '-') {
        $resultado = $numero1 - $numero2;
    } elseif ($operador == '*') {
        $resultado = $numero1 * $numero2;
    } elseif ($operador == '/') {
        if ($numero2 != 0) {
            $resultado = $numero1 / $numero2;
        } else {
            $resultado = "Error: división entre cero";
        }
    } else {
        $resultado = "Operador no válido";
    }



    $_SESSION['resultado'] = $resultado;

    if (!isset($_SESSION['contador'])) {
        $_SESSION['contador'] = 0;
    }
    if ($resultado < 1000) {
        $_SESSION['contador']++;
    }
    if($_SESSION['contador']>5){
        header('Location: ecuaciones.php');
        exit();
    }

    header('Location: calculos.php');
    exit();


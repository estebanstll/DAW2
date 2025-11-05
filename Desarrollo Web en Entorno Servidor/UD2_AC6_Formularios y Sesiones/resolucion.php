<?php
session_start();

    $num1 = $_GET["numero1"];
    $num2 = $_GET["numero2"];
    $ref = $_GET["select"];


    switch ($ref) {
        case '+':
            $resultado = $num1 + $num2;
            break;
        case '-':
            $resultado = $num1 - $num2;
            break;
        case '*':
            $resultado = $num1 * $num2;
            echo $resultado;
            break;
        case '/':
            if ($num2 != 0) {
                $resultado = $num1 / $num2;
            } else {
                $resultado = "Error: División por cero";
            }
            break;
        default:
            $resultado = "Operación no válida";
            break;
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
?>
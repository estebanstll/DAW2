<?php
session_start();

    $num1 = $_GET["numero1"];
    $num2 = $_GET["numero2"];
    $operador = $_GET["select"];


    switch ($operador) {
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

    if (!isset($_SESSION['contador_operaciones'])) {
        $_SESSION['contador_operaciones'] = 0;
    }

    if ($resultado < 1000) {
        $_SESSION['contador_operaciones']++;
    }

    header('Location: calculos.php');
    exit();
?>
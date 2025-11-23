<?php
    $numero1=2;
    $numero2= 7;
    $operador="-";
    $resultado=0;

    switch ($operador) {
        case '+':
            $resultado= $numero1+$numero2;
            break;
        case '-':
            $resultado= $numero1-$numero2;
            break;
        default:
            $resultado=0;
            break;
    }

    echo("el resultado es ".$resultado);
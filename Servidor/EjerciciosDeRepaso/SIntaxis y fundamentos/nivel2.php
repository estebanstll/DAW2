<?php

    $nota=7;

    if ($nota>=9) {
        echo("enhorabuena, tiene un sobresaliente");
    }elseif ($nota>=7) {
        echo("enhorabuena, tiene un notable");
    }elseif($nota>=5){
        echo("tienes un suficiente");
    }else{

        echo("has suspendido");

    }
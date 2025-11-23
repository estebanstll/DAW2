<?php
    function saludar($nombre,$hora):string{

        if($hora>12){

            return "buenas tardes {$nombre}";
        }else{

            return "buenos dias {$nombre}";
        }

    }

    echo(saludar("esteban",13));
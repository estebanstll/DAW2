<?php
    $frutas=["manzana","pera","platano"];


    foreach ($frutas as $fru) {
        echo($fru." ");
    }
array_push($frutas, "fresas");
        echo("<br><br>");

 foreach ($frutas as $fru) {
        echo($fru." ");
    }

    echo("<br><br>");
    echo(count($frutas));
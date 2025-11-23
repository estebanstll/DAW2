<?php
    $catalogo = [
    ["titulo"=>"Elden Ring","genero"=>"RPG","plataforma"=>"PC","valoracion"=>9.5],
    ["titulo"=>"FIFA 22","genero"=>"Deportes","plataforma"=>"PS5","valoracion"=>8.0],
    ["titulo"=>"Minecraft","genero"=>"Aventura","plataforma"=>"PC","valoracion"=>9.0],
    ["titulo"=>"God of War","genero"=>"RPG","plataforma"=>"PS5","valoracion"=>9.2]
    ];

    $jugador = [
        "nombre"=>"Alex",
        "juegos"=>["Elden Ring","FIFA 22"]
    ];


    function obtenerJuegoPorGenero($c,$genero):array{
        $resultado=[];

        foreach ($c as $cat) {
            if($cat['genero']===$genero){

                array_push($resultado, $cat);
            }
        }
        return $resultado;
    }


    $out= obtenerJuegoPorGenero($catalogo,'RPG');

    foreach ($out as $o) {
      echo($o['titulo'].", ");

    }




    function calcularPromedio($cat):float{

        $suma=0;
        foreach($cat as $c){

            $suma = $suma + $c['valoracion'];

        }
        $promedio=$suma/count($cat);

        if($promedio<9){

            throw new Exception("la media es muy baja", 1);
            
        }
        return $promedio;
    }

    try {
        echo("<br><br>el pormedio es de: ".calcularPromedio($catalogo));

    }  catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
    
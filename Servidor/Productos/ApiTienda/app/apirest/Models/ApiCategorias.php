<?php
namespace App\Apirest\Models;

use Tools\Conexion;

class Apicategorias{

public static function getTodos():array{

        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM categorias";
        $stmt = $bd->prepare($consulta);
        $stmt->execute();
        $row = $stmt->fetchAll();

    return $row;
}

}
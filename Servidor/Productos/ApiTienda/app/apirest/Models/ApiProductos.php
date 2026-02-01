<?php
namespace App\Apirest\Models;

use Tools\Conexion;

class Apiproductos{

public static function getPorId($id):?array{

        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM productos WHERE categoria_id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetchAll();
        return $row?:null;
}

}
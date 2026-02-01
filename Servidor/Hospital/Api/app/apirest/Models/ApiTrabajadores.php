<?php
namespace App\Apirest\Models;
use Tools\Conexion;

 class ApiTrabajadores{

public static function getTodos():array{

        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM medicos";
        $stmt = $bd->prepare($consulta);
        $stmt->execute();
        $row = $stmt->fetchAll();

    return $row;
}

public static function getId($id):array{

$bd = Conexion::getConexion();
        $consulta = "SELECT * FROM medicos WHERE id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        $row = $stmt->fetchAll();

    return $row;

}


 }
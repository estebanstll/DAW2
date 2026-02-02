<?php
namespace App\Apirest\Models;
use Tools\Conexion;

 class ApiProfesores{

public static function getTodos():array{

        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM profesores";
        $stmt = $bd->prepare($consulta);
        $stmt->execute();
        $row = $stmt->fetchAll();

    return $row;
}

public static function getId($id):array{

$bd = Conexion::getConexion();
        $consulta = "SELECT * FROM profesores WHERE id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        $row = $stmt->fetchAll();

    return $row;

}


 }
<?php
namespace App\Apirest\Models;
use Tools\Conexion;
class ApiAlumnos{


public static function getId($id):array{

$bd = Conexion::getConexion();
        $consulta = "SELECT * FROM alumnos WHERE profesor_id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        $row = $stmt->fetchAll();

    return $row;

}

public static function getPorId($id):array{

$bd = Conexion::getConexion();
        $consulta = "SELECT * FROM alumnos WHERE id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        $row = $stmt->fetchAll();

    return $row;

}


public static function updatePorId($id, string $profesor_id, string $nombre, string $apellidos):array{

        $bd = Conexion::getConexion();
    $consulta = "UPDATE alumnos SET profesor_id=:profesor_id, nombre=:nombre, apellidos=:apellidos WHERE id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":profesor_id", $profesor_id);
        $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":apellidos", $apellidos);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'alumno actualizado correctamente'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar el alumno'];
        }
}

}
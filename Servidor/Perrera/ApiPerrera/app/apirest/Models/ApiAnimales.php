<?php
namespace App\Apirest\Models;

use Tools\Conexion;

class Apianimales{

public static function getTodos():array{

        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM animales";
        $stmt = $bd->prepare($consulta);
        $stmt->execute();
        $row = $stmt->fetchAll();

    return $row;
}


public static function getPorId($id):?array{

        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM animales WHERE id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetchAll();
        return $row?:null;
}

public static function updatePorId($id, string $animal, string $raza, string $nombre, string $personaACargo):array{

        $bd = Conexion::getConexion();
        $consulta = "UPDATE animales SET animal=:animal, raza=:raza, nombre=:nombre, personaACargo=:personaACargo WHERE id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":animal", $animal);
        $stmt->bindParam(":raza", $raza);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":personaACargo", $personaACargo);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Animal actualizado correctamente'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar el animal'];
        }
}

public static function deletePorId($id):array{

        $bd = Conexion::getConexion();
        $consulta = "DELETE FROM animales WHERE id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Animal eliminado correctamente'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar el animal'];
        }
}


}
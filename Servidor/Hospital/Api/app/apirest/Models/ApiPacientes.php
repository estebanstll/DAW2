<?php
namespace App\Apirest\Models;
use Tools\Conexion;

 class ApiPacientes{


public static function getTodos():array{

        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM pacientes";
        $stmt = $bd->prepare($consulta);
        $stmt->execute();
        $row = $stmt->fetchAll();

    return $row;
}

public static function getId($id):array{

$bd = Conexion::getConexion();
        $consulta = "SELECT * FROM pacientes WHERE id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        $row = $stmt->fetchAll();

    return $row;

}

public static function delete($id){

    $bd = Conexion::getConexion();
        $consulta = "DELETE FROM pacientes WHERE id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'paciente eliminado correctamente'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar el paciente'];
        }

}

public static function updatePorId($id, string $medico_id, string $nombre, string $motivo):array{

        $bd = Conexion::getConexion();
        $consulta = "UPDATE pacientes SET medico_id=:medico, nombre=:nombre, motivo=:motivo WHERE id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":medico", $medico_id);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":motivo", $motivo);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'paciente actualizado correctamente'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar el paciente'];
        }
}
 
 }
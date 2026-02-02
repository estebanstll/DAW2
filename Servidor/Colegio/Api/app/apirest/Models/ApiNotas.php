<?php
namespace App\Apirest\Models;
use Tools\Conexion;


class ApiNotas{

public static function getId($id):array{

$bd = Conexion::getConexion();
        $consulta = "SELECT * FROM notas WHERE alumno_id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        $row = $stmt->fetchAll();

    return $row;

}


public static function updatePorId($id, int $nota):array{

        $bd = Conexion::getConexion();
        $consulta = "UPDATE notas SET nota=:nota WHERE id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nota", $nota);
        ;
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Nota actualizado correctamente'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar el nota'];
        }
}

public static function delete($id){

    $bd = Conexion::getConexion();
        $consulta = "DELETE FROM notas WHERE id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'nota eliminado correctamente'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar el nota'];
        }

}

public static function crearNota($id,$alumno_id,$asignatura,$nota){

 $bd = Conexion::getConexion();
        
        
        // Insertar el nuevo usuario
        $consulta = "INSERT INTO notas (id, alumno_id, asignatura,nota) 
                 VALUES (:id, :alumno_id, :asignatura, :nota)";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':alumno_id', $alumno_id);
        $stmt->bindParam(':asignatura', $asignatura);
        $stmt->bindParam(':nota', $nota);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'nota creado correctamente', 'id' => $bd->lastInsertId()];
        } else {
            return ['success' => false, 'message' => 'Error al crear el nota'];
        }
    }

}
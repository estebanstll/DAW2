<?php
namespace App\Models;

use Tools\Conexion;


class ApiCoches{

public static function obtenerTodos():array{
        $resultado = [];
        $bd = Conexion::getConexion();
        $consulta ="SELECT * From coches";
        $stmt =$bd->prepare($consulta);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function IdCoche(int $id): ?array {
        $bd = Conexion::getConexion();
        $consulta = "SELECT * From coches WHERE id=:id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return $row ?: null;
    }
    
    
    }
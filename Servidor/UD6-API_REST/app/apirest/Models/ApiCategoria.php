<?php
namespace App\Apirest\Models;

use Tools\Conexion;

class ApiCategoria
{
    public static function obtenerTodas(): array
    {
        $bd = Conexion::getConexion();
        $sql = "SELECT CodCat as id, Nombre as nombre, Descripcion as descripcion FROM categorias";
        $stmt = $bd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

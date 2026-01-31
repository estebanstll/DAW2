<?php
namespace App\Apirest\Models;

use Tools\Conexion;

class ApiProducto
{
    public static function obtenerPorCategoria(int $categoriaId): array
    {
        $bd = Conexion::getConexion();
        $sql = "SELECT CodProd as id, Nombre as nombre, Descripcion as descripcion, Peso as peso, Stock as stock, Categoria as categoria FROM productos WHERE Categoria = :cat";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':cat', $categoriaId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

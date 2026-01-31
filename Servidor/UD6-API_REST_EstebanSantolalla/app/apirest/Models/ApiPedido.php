<?php
namespace App\Apirest\Models;

use Tools\Conexion;

class ApiPedido
{
    public static function obtenerPorRestaurante(int $restId): array
    {
        $bd = Conexion::getConexion();

        // Obtener pedidos básicos
        $sql = "SELECT p.CodPed as id, p.Enviado as enviado, p.Restaurante as restaurante, p.Fecha as fecha
                FROM pedidos p
                WHERE p.Restaurante = :restId";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':restId', $restId);
        $stmt->execute();
        $pedidos = $stmt->fetchAll();

        // Añadir detalles (líneas) para cada pedido
        foreach ($pedidos as &$pedido) {
            $sql2 = "SELECT pp.Producto as producto_id, pr.Nombre as producto_nombre, pp.Unidades as unidades
                     FROM pedidosproductos pp
                     JOIN productos pr ON pr.CodProd = pp.Producto
                     WHERE pp.Pedido = :id";
            $stmt2 = $bd->prepare($sql2);
            $stmt2->bindParam(':id', $pedido['id']);
            $stmt2->execute();
            $pedido['lineas'] = $stmt2->fetchAll();
        }

        return $pedidos;
    }
}

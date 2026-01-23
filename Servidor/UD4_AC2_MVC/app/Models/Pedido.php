<?php

namespace App\Models;
use App\Controllers\PedidosController;
use App\Models\LineaPedido;
use Tools\Conexion;
use PDO;
use PDOException;
class Pedido
{
    private $codPed;
    private $fecha;
    private $enviado;
    private $codRes;
    private $lineas = [];

    public function __construct($enviado = false, $codRes = null){
        $this->enviado = $enviado;
        $this->codRes = $codRes;
    }


    /**
     * @return mixed
     */
    public function getCodPed()
    {
        return $this->codPed;
    }

    /**
     * @param mixed $codPed
     */
    public function setCodPed($codPed): void
    {
        $this->codPed = $codPed;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getEnviado()
    {
        return $this->enviado;
    }

    /**
     * @param mixed $enviado
     */
    public function setEnviado($enviado): void
    {
        $this->enviado = $enviado;
    }

    /**
     * @return mixed
     */
    public function getCodRes()
    {
        return $this->codRes;
    }

    /**
     * @param mixed $codRes
     */
    public function setCodRes($codRes): void
    {
        $this->codRes = $codRes;
    }

    public function getLineas(){
        return $this->lineas;
    }

    public function addLinea(LineaPedido $linea){
        $this->lineas[] = $linea;
    }

    /**
     * Añade una línea de pedido a la base de datos.
     * @param LineaPedido $linea La línea de pedido a añadir.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function anadirLinea(LineaPedido $linea): bool
    {
        $conexion = Conexion::getConexion();

        // Asume que la conexión está abierta y la transacción ya iniciada si se llama desde guardar()
        $sql = "INSERT INTO pedidosproductos (Pedido, Producto, Unidades) VALUES (:codPed, :codProd, :unidades)";

        $stmt = $conexion->prepare($sql);

        $codPed = $linea->getCodPed();
        $codProd = $linea->getCodProd();
        $unidades = $linea->getUnidades();

        $stmt->bindParam(':codPed', $codPed);
        $stmt->bindParam(':codProd', $codProd);
        $stmt->bindParam(':unidades', $unidades);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error al añadir línea de pedido: " . $e->getMessage());
            // No hacemos rollback aquí, se gestiona en guardar()
            return false;
        }
    }

    /**
     * Añade un pedido a la base de datos y devuelve su ID insertado.
     * @param Pedido $pedido El objeto Pedido a añadir.
     * @return int El ID del pedido recién insertado.
     * @throws PDOException Si la inserción del pedido falla.
     */
    public function anadirPedido(Pedido $pedido): int
    {
        $conexion = Conexion::getConexion();
        // Asume que la conexión está abierta y la transacción ya iniciada si se llama desde guardar()
        $sql = "INSERT INTO pedidos (Enviado, Restaurante) VALUES (:enviado, :codRes)";
        $stmt = $conexion->prepare($sql);

        $enviado = $pedido->getEnviado();
        $codRes = $pedido->getCodRes();
        $stmt->bindParam(':enviado', $enviado);
        $stmt->bindParam(':codRes', $codRes);
        $stmt->execute();

        // Devolver el ID del último registro insertado
        return (int) $conexion->lastInsertId();
    }

    /**
     * Guarda el pedido y sus líneas usando transacciones.
     * Si falla cualquier inserción de línea, se revierte todo.
     * @param Pedido $pedido El objeto Pedido con sus líneas.
     * @return int|bool El ID del pedido insertado en caso de éxito, o false en caso de fallo.
     */
    public function guardar(Pedido $pedido)
    {
        $conexion = Conexion::getConexion();
        $conexion->beginTransaction(); // 1. Iniciar la transacción

        try {
            // 2. Insertar el pedido y obtener su ID
            $codPed = $this->anadirPedido($pedido);

            // 3. Insertar las líneas de pedido
            foreach ($pedido->getLineas() as $linea) {
                $linea->setCodPed($codPed); // Establecer el ID del pedido en la línea
                if (!$this->anadirLinea($linea)) {
                    // Si falla alguna línea, lanza una excepción para que el catch la atrape
                    throw new \Exception("Fallo al insertar la línea de pedido.");
                }
            }

            $conexion->commit();
            return $codPed; // Devolver el ID del pedido insertado

        } catch (\Exception $e) {
            // 5. Si algo falla, deshacer todos los cambios
            if ($conexion->inTransaction()) {
                $conexion->rollBack();
            }
            die("Error SQL: " . $e->getMessage());

            // error_log("Transacción de pedido fallida: " . $e->getMessage());
            // return false;
        }
    }
}
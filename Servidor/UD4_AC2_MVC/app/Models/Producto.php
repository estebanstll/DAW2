<?php
namespace App\Models;

use Tools\Conexion;
use PDO;

class Producto
{
    private ?int $codProd;
    private $nombre;
    private $descripcion;
    private $peso;
    private $stock;
    private $codCat;

    public function __construct(
        ?string $nombre = null,
        ?string $descripcion = null,
        ?float $peso = null,
        ?int $stock = null,
        ?int $codCat = null
    ) {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->peso = $peso;
        $this->stock = $stock;
        $this->codCat = $codCat;
    }


    public function getCodProd(){
        return $this->codProd;
    }
    public function setCodProd($codProd){
        $this->codProd = $codProd;
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getPeso(){
        return $this->peso;
    }
    public function setPeso($peso): void
    {
        $this->peso = $peso;
    }

    public function getStock(){
        return $this->stock;
    }
    public function setStock($stock): void
    {
        $this->stock = $stock;
    }

    public function getCodCat(){
        return $this->codCat;
    }
    public function setCodCat($codCat): void
    {
        $this->codCat = $codCat;
    }

    public function __toString(){
        return $this->nombre;
    }

    public function productosDeCategoria(int $codCat){
        $conexion = Conexion::getConexion();

        $sql1 = "SELECT * FROM productos WHERE Categoria = :codCat";
        $stmt1 = $conexion->prepare($sql1);
        $stmt1->bindParam(':codCat', $codCat);
        $stmt1->execute();
        $filas = $stmt1->fetchAll();
        $productos = [];

        foreach($filas as $fila){
            $codProd = $fila['CodProd'];
            $nombre = $fila['Nombre'];
            $descripcion = $fila['Descripcion'];
            $peso = $fila['Peso'];
            $stock = $fila['Stock'];
            $categoria = $fila['Categoria'];
            $producto = new Producto($nombre, $descripcion, $peso, $stock, $categoria);
            $producto->setCodProd($codProd);
            $productos[] = $producto;
        }

        return $productos;
    }

    public function buscarPorId(int $codProd): ?Producto {
        $sql = "SELECT * FROM productos WHERE CodProd = :codProd";
        $stmt = Conexion::getConexion()->prepare($sql);

        $stmt->bindParam(':codProd', $codProd);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        $productoNuevo = new Producto($producto['Nombre'], $producto['Descripcion'], $producto['Peso'], $producto['Stock'], $producto['Categoria']);
        $productoNuevo->setCodProd($producto['CodProd']);;
        return $productoNuevo;
    }

    public function cambiarStock(int $codProd, int $cantidad)
    {
        $conexion = Conexion::getConexion();

        $sql = "UPDATE productos SET Stock = Stock - :cantidad WHERE CodProd = :codProd";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':codProd', $codProd);

        return $stmt->execute();
    }

}
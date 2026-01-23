<?php

namespace App\Models;

use Tools\Conexion;

class Usuario
{
    private $codRes;
    private $correo;
    private $clave;
    private $pais;
    private $cp;
    private $ciudad;
    private $direccion;

    public function __construct(
        ?string $correo = null,
        ?string $clave = null,
        ?string $pais = null,
        ?string $cp = null,
        ?string $ciudad = null,
        ?string $direccion = null
    ) {
        $this->correo = $correo;
        $this->clave = $clave;
        $this->pais = $pais;
        $this->cp = $cp;
        $this->ciudad = $ciudad;
        $this->direccion = $direccion;
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

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param mixed $clave
     */
    public function setClave($clave): void
    {
        $this->clave = $clave;
    }

    /**
     * @return mixed
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param mixed $pais
     */
    public function setPais($pais): void
    {
        $this->pais = $pais;
    }

    /**
     * @return mixed
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * @param mixed $cp
     */
    public function setCp($cp): void
    {
        $this->cp = $cp;
    }

    /**
     * @return mixed
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * @param mixed $ciudad
     */
    public function setCiudad($ciudad): void
    {
        $this->ciudad = $ciudad;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    public static function comprobarUsuario(string $correo, string $clave)
    {
        $conexion = Conexion::getConexion();
        $sql = "SELECT * FROM restaurantes WHERE Correo = :correo AND Clave = :clave";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':clave', $clave);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function getIdUsuario(string $usuario)
    {
        $conexion = Conexion::getConexion();
        $sql = "SELECT CodRes FROM restaurantes WHERE Correo = :correo";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':correo', $usuario);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

}
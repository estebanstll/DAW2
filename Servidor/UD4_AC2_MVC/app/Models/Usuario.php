<?php

namespace App\Models;

use Tools\Conexion;

class Usuario
{
    private ?int $idRestaurante = null;
    private ?string $email = null;
    private ?string $contrasena = null;
    private ?string $nacion = null;
    private ?string $codigoPostal = null;
    private ?string $municipio = null;
    private ?string $domicilio = null;

    public function __construct(
        ?string $email = null,
        ?string $contrasena = null,
        ?string $nacion = null,
        ?string $codigoPostal = null,
        ?string $municipio = null,
        ?string $domicilio = null
    ) {
        $this->email = $email;
        $this->contrasena = $contrasena;
        $this->nacion = $nacion;
        $this->codigoPostal = $codigoPostal;
        $this->municipio = $municipio;
        $this->domicilio = $domicilio;
    }

    public function obtenerId(): ?int
    {
        return $this->idRestaurante;
    }

    public function asignarId(?int $id): void
    {
        $this->idRestaurante = $id;
    }

    public function obtenerEmail(): ?string
    {
        return $this->email;
    }

    public function asignarEmail($email): void
    {
        $this->email = $email;
    }

    public function obtenerContrasena(): ?string
    {
        return $this->contrasena;
    }

    public function asignarContrasena($contrasena): void
    {
        $this->contrasena = $contrasena;
    }

    public function obtenerNacion(): ?string
    {
        return $this->nacion;
    }

    public function asignarNacion($nacion): void
    {
        $this->nacion = $nacion;
    }

    public function obtenerCodigoPostal(): ?string
    {
        return $this->codigoPostal;
    }

    public function asignarCodigoPostal($cp): void
    {
        $this->codigoPostal = $cp;
    }

    public function obtenerMunicipio(): ?string
    {
        return $this->municipio;
    }

    public function asignarMunicipio($municipio): void
    {
        $this->municipio = $municipio;
    }

    public function obtenerDomicilio(): ?string
    {
        return $this->domicilio;
    }

    public function asignarDomicilio($domicilio): void
    {
        $this->domicilio = $domicilio;
    }

    public static function validarCredenciales(string $email, string $contrasena)
    {
        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM restaurantes WHERE Correo = :email AND Clave = :contrasena";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":contrasena", $contrasena);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function obtenerIdUsuario(string $email)
    {
        $bd = Conexion::getConexion();
        $consulta = "SELECT CodRes FROM restaurantes WHERE Correo = :email";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->fetchColumn();
    }
}

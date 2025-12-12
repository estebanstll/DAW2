<?php


class Usuario
{

    private string $correo;
    private string $clave;
    private string $CP;
    private string $pais;
    private string $ciudad;
    private string $direccion;




    public function __construct(string $correo, string $clave, string $CP, string $pais, string $ciudad, string $direccion)
    {

        $this->correo = $correo;
        $this->clave = $clave;
        $this->CP = $CP;
        $this->pais = $pais;
        $this->ciudad = $ciudad;
        $this->direccion = $direccion;
    }


    public function getCorreo(): string
    {
        return $this->correo;
    }

    public function setCorreo(string $value)
    {
        $this->correo = $value;
    }

    public function getClave(): string
    {
        return $this->clave;
    }

    public function setClave(string $value)
    {
        $this->clave = $value;
    }

    public function getCP(): string
    {
        return $this->CP;
    }

    public function setCP(string $value)
    {
        $this->CP = $value;
    }

    public function getPais(): string
    {
        return $this->pais;
    }

    public function setPais(string $value)
    {
        $this->pais = $value;
    }

    public function getCiudad(): string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $value)
    {
        $this->ciudad = $value;
    }

    public function getDireccion(): string
    {
        return $this->direccion;
    }

    public function setDireccion(string $value)
    {
        $this->direccion = $value;
    }
}
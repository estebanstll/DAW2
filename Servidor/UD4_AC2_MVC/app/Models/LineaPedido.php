<?php

namespace App\Models;

class LineaPedido
{
    private $codPedProd;
    private $codPed;
    private $codProd;
    private $unidades;

    public function __construct($codProd, $unidades){
        $this->codProd = $codProd;
        $this->unidades = $unidades;
    }

    /**
     * @return mixed
     */
    public function getCodPedProd()
    {
        return $this->codPedProd;
    }

    /**
     * @param mixed $codPedProd
     */
    public function setCodPedProd($codPedProd): void
    {
        $this->codPedProd = $codPedProd;
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
    public function getCodProd()
    {
        return $this->codProd;
    }

    /**
     * @param mixed $codProd
     */
    public function setCodProd($codProd): void
    {
        $this->codProd = $codProd;
    }

    /**
     * @return mixed
     */
    public function getUnidades()
    {
        return $this->unidades;
    }

    /**
     * @param mixed $unidades
     */
    public function sumarUnidades($unidades): void
    {
        $this->unidades += $unidades;
    }

    public function restarUnidades($unidades): void
    {
        $this->unidades -= $unidades;
    }



}
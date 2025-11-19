<?php

interface AccionesBD
{
    public function insertar(array $datos): bool;

    public function eliminar(int $id): bool;

    public function actualizar(int $id, array $datos): bool;

    public function listar(): array;
}

?>

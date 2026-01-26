<?php

namespace App\Models;

use Tools\Conexion;
use RuntimeException;

class Trabajadores {

    private int $id;
    private string $nombre;
    private string $gmail;
    private string $contraseña;
    private ?string $especialidad;

    public function __construct(
        int $id,
        string $nombre,
        string $gmail,
        string $contraseña,
        ?string $especialidad
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->gmail = $gmail;
        $this->contraseña = $contraseña;
        $this->especialidad = $especialidad;
    }





	public function getId() : int {
		return $this->id;
	}

	public function getNombre() : string {
		return $this->nombre;
	}

	public function getGmail() : string {
		return $this->gmail;
	}

	public function getContraseña() : string {
		return $this->contraseña;
	}

	public function getEspecialidad() : ?string {
		return $this->especialidad;
	}


	public function setId(int $value) {
		$this->id = $value;
	}

	public function setNombre(string $value) {
		$this->nombre = $value;
	}

	public function setGmail(string $value) {
		$this->gmail = $value;
	}

	public function setContraseña(string $value) {
		$this->contraseña = $value;
	}

	public function setEspecialidad(?string $value) {
		$this->especialidad = $value;
	}


    public static function obtenerIdUsuario(string $gmail)
    {
        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM usuarios WHERE gmail = :gmail";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":gmail", $gmail);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public static function getTodos():array{
        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM usuarios";
        $stmt = $bd->prepare($consulta);
        $stmt->execute();
        
        $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $trabajadores = [];
        
        foreach ($resultados as $fila) {
            $trabajadores[] = new self(
                $fila['id'],
                $fila['nombre'],
                $fila['gmail'],
                $fila['contraseña'],
                $fila['especialidad'] ?? null
            );
        }
        
        return $trabajadores;
    }
}
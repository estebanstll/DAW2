<?php

namespace App\Models;

use Tools\Conexion;

class Coches{

    private ?int $id;
    private ?string $marca;
    private ?string $modelo;
    private ?int $año;
    private ?float $precio;

    /**
     * @param string|null $marca
     * @param string|null $modelo
     * @param int|null $año
     * @param float|null $precio
     */
    public function __construct(?string $marca, ?string $modelo, ?int $año, ?float $precio)
    {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->año = $año;
        $this->precio = $precio;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Coches
    {
        $this->id = $id;
        return $this;
    }

    public function getMarca(): ?string
    {
        return $this->marca;
    }

    public function setMarca(?string $marca): Coches
    {
        $this->marca = $marca;
        return $this;
    }

    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    public function setModelo(?string $modelo): Coches
    {
        $this->modelo = $modelo;
        return $this;
    }

    public function getAño(): ?int
    {
        return $this->año;
    }

    public function setAño(?int $año): Coches
    {
        $this->año = $año;
        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(?float $precio): Coches
    {
        $this->precio = $precio;
        return $this;
    }

    public static function obtenerTodos():array{
        $resultado = [];
        
        // Consumir API REST con cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/cars/cochesApi/apirest/api/coches");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200 && $response) {
            $data = json_decode($response, true);
            
            // Instanciar objetos Coches con los datos de la API
            if (is_array($data)) {
                foreach($data as $row) {
                    $coche = new self($row["marca"], $row["modelo"], $row["año"], $row["precio"]);
                    $coche->setId($row["id"]);
                    $resultado[] = $coche;
                }
            }
        }

        return $resultado;
    }

    public static function IdCoche(int $id): ?Coches {
        // Consumir API REST con cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/cars/cochesApi/apirest/api/coches/" . $id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200 && $response) {
            $row = json_decode($response, true);
            
            if ($row) {
                $coche = new self($row["marca"], $row["modelo"], $row["año"], $row["precio"]);
                $coche->setId($row["id"]);
                return $coche;
            }
        }
        
        return null;
    }

}
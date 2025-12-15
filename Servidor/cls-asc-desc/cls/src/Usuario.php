<?php
// src/Usuario.php

require_once __DIR__ . '/../tools/Validador.php';

class Usuario
{
    use Validador;

    private string $user;
    private string $pass;
    private string $nombre;
    private string $email;
    private int $edad;

    public function __construct(
        string $user = "",
        string $pass = "",
        string $nombre = "",
        string $email = "",
        int $edad = 0
    ) {
        if ($user !== "")
            $this->setUser($user);
        if ($pass !== "")
            $this->setPass($pass);
        if ($nombre !== "")
            $this->setNombre($nombre);
        if ($email !== "")
            $this->setEmail($email);
        if ($edad !== 0)
            $this->setEdad($edad);
    }

    public function __destruct()
    {
        unset($this->user, $this->pass, $this->nombre, $this->email, $this->edad);
    }

    public function __toString(): string
    {
        return "Usuario: {$this->user}, Nombre: {$this->nombre}, Email: {$this->email}, Edad: {$this->edad}";
    }

    public function setNombre(string $nombre)
    {
        if ($this->validarTexto($nombre)) {
            $this->nombre = $nombre;
        } else {
            throw new Exception("El nombre no es válido.");
        }
    }

    public function setEmail(string $email)
    {
        if ($this->validarEmail($email)) {
            $this->email = $email;
        } else {
            throw new Exception("El email no es válido.");
        }
    }

    public function setEdad(int $edad)
    {
        if ($this->validarEntero($edad) && $edad >= 0) {
            $this->edad = $edad;
        } else {
            throw new Exception("La edad debe ser un entero positivo.");
        }
    }

    public function setUser(string $user): void
    {
        if (!$this->campoObligatorio($user)) {
            throw new Exception("El usuario es obligatorio");
        }
        $this->user = $user;
    }

    public function setPass(string $pass): void
    {
        if (!$this->longitudEntre($pass, 4, 20)) {
            throw new Exception("La contraseña debe tener entre 4 y 20 caracteres");
        }
        $this->pass = $pass;
    }

    public function mostrarDatos(): string
    {
        return "Usuario: $this->nombre - $this->email - $this->edad años";
    }

    public static function lista($pdo): array
    {
        $sql = "SELECT * FROM usuarios";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function login(PDO $pdo): bool
    {
        $sql = "SELECT user, nombre, email, edad 
                FROM usuarios 
                WHERE user = :user AND pass = :pass";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user' => $this->user,
            ':pass' => $this->pass,
        ]);

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            $this->nombre = $fila['nombre'];
            $this->email = $fila['email'];
            $this->edad = (int) $fila['edad'];
            return true;
        }

        return false;
    }
}

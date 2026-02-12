<?php

namespace Dwes\Clinica;

class Veterinario
{
    private $bd;
    private ?int $id;
    private ?string $nombre;
    private ?string $email;
    private ?int $clave;

    public function __construct($id = null, $nombre = null, $email = null, $clave = null){
        $this->bd = new Db();
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->clave = $clave;
    }

    /**
     * @return mixed
     */
    public function getBd()
    {
        return $this->bd;
    }

    /**
     * @param mixed $bd
     */
    public function setBd($bd): void
    {
        $this->bd = $bd;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getClave(): ?int
    {
        return $this->clave;
    }

    public function setClave(?int $clave): void
    {
        $this->clave = $clave;
    }

    public function login($email, $clave,$nombre){
        $this->bd->query("SELECT * FROM veterinarios 
        WHERE email = :email AND nombre = :nombre AND clave = :clave");
        $this->bd->bind("email", $email);
        $this->bd->bind("clave", $clave);
        $this->bd->bind("nombre", $nombre);

        $user = $this->bd->registro();

        if ($user) {
            return $user->email;
        } else {
            return false;
        }

    }

    public function logout(){
        unset($_SESSION["usuario_activo"]);
    }

    public function logged()
    {
        if (!isset($_SESSION["usuario_activo"])) {
            header("Location: " . RUTA_URL . "/Paginas/form_login");
            exit();
        }
    }
}
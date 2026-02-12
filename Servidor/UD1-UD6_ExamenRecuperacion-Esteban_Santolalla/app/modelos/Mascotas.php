<?php 

    namespace Dwes\Clinica;

    class Mascotas{

    private $bd;
    public ?int $id=null;
    public ?int $nombre;
    public ?int $tipo;
    public ?int $fecha_nacimiento;
    public ?int $foto_url;
    public ?int $id_persona;

        /**
         * @param int|null $id
         * @param int|null $nombre
         * @param int|null $tipo
         * @param int|null $fecha_nacimiento
         * @param int|null $foto_url
         * @param int|null $id_persona
         */
        public function __construct(?int $id = null, ?string $nombre = null, ?string $tipo = null, ?string $fechaNacimiento = null, ?string $foto = null, ?int $idPersona = null){
            $this->bd = new Db();
            $this->id = $id;
            $this->nombre = $nombre;
            $this->tipo = $tipo;
            $this->fechaNacimiento = $fechaNacimiento;
            $this->foto = $foto;
            $this->idPersona = $idPersona;
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

        public function getNombre(): ?int
        {
            return $this->nombre;
        }

        public function setNombre(?int $nombre): void
        {
            $this->nombre = $nombre;
        }

        public function getTipo(): ?int
        {
            return $this->tipo;
        }

        public function setTipo(?int $tipo): void
        {
            $this->tipo = $tipo;
        }

        public function getFechaNacimiento(): ?int
        {
            return $this->fecha_nacimiento;
        }

        public function setFechaNacimiento(?int $fecha_nacimiento): void
        {
            $this->fecha_nacimiento = $fecha_nacimiento;
        }

        public function getFotoUrl(): ?int
        {
            return $this->foto_url;
        }

        public function setFotoUrl(?int $foto_url): void
        {
            $this->foto_url = $foto_url;
        }

        public function getIdPersona(): ?int
        {
            return $this->id_persona;
        }

        public function setIdPersona(?int $id_persona): void
        {
            $this->id_persona = $id_persona;
        }


        public function getByIdPersona($id_persona){


        $this->bd->query("SELECT * FROM mascotas WHERE id_persona=:id_persona");
        $this->bd->bind("id_persona", $id_persona);
            $mascotas = $this->bd->registros();

            return $mascotas ?: [];


        }

    }
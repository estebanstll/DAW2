<?php 

    namespace Dwes\Clinica;

    class Personas{

        private $bd;

        private ?int $id=null;

        private ?string $nombre;
        private ?string $apellidos;
        private ?int $telefono;
        private ?string $email;

        /**
         * @param int|null $id
         * @param string|null $nombre
         * @param string|null $apellidos
         * @param int|null $telefono
         * @param string|null $email
         */
        public function __construct(?int $id = null, ?string $nombre = null, ?string $apellidos = null, ?int $telefono = null, ?string $email = null)
        {
            $this->bd = new Db();
            $this->id = $id;
            $this->nombre = $nombre;
            $this->apellidos = $apellidos;
            $this->telefono = $telefono;
            $this->email = $email;
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

        public function getApellidos(): ?string
        {
            return $this->apellidos;
        }

        public function setApellidos(?string $apellidos): void
        {
            $this->apellidos = $apellidos;
        }

        public function getTelefono(): ?int
        {
            return $this->telefono;
        }

        public function setTelefono(?int $telefono): void
        {
            $this->telefono = $telefono;
        }

        public function getEmail(): ?string
        {
            return $this->email;
        }

        public function setEmail(?string $email): void
        {
            $this->email = $email;
        }
        
        public function getAll(){

            $this->bd->query("SELECT * FROM personas");
            $users = $this->bd->registros();

            return $users ?: [];

        }
        
        public function getByID(int $id){

            $this->bd->query("SELECT * FROM personas WHERE id=:id");
            $this->bd->bind("id", $id);
            $user = $this->bd->registro();

            return $user ?:[];
        
        }

        public function deleteByID($id){

            

            $this->bd->query("DELETE FROM personas WHERE id=:id");
            $this->bd->bind("id", $id);
            $this->bd->execute();

            return ($this->bd->rowCount() > 0) ? true : false;

        }

        public function updateByID($id,$nombre, $apellidos,$telefono,$email){

            if (is_null($this->id)) {
                return false;
            }

            $this->bd->query("UPDATE personas SET nombre=:nombre, apellidos=:apellidos, telefono=:telefono, email=:email WHERE id=:id");
            $this->bd->bind("nombre", $nombre);
            $this->bd->bind("apellidos", $apellidos);
            $this->bd->bind("telefono", $telefono);
            $this->bd->bind("email", $email);
            $this->bd->bind("id", $id);

            $this->bd->execute();

            return ($this->bd->rowCount() > 0) ? true : false;

        }

        public function post($nombre, $apellidos,$telefono,$email){

            $this->bd->query("INSERT INTO personas (nombre, apellidos, telefono, email) VALUES (:nombre, :apellidos, :telefono, :email)");
            $this->bd->bind("nombre", $nombre);
            $this->bd->bind("apellidos", $apellidos);
            $this->bd->bind("telefono", $telefono);
            $this->bd->bind("email", $email);

            $this->bd->execute();

            return ($this->bd->rowCount() > 0) ? true : false;

        }


        
    }




<?php

    //Clase para conectarse a la base de datos y ejecutar consultas PDO

    class Db{
        private $host = DB_HOST;
        private $usuario = DB_USUARIO;
        private $password = DB_PASSWORD;
        private $nombre_db = DB_NOMBRE;

        private $dbh; // database handler (manejador de base de datos)
        private $stmt;
        private $error;

        public function __construct()
        {
            //configurar conextion
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->nombre_db;
            $opciones = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            //Crear instancia de PDO
            try{
                $this->dbh = new PDO($dsn, $this->usuario, $this->password, $opciones);
                //Para usar caracteres especiales y símbolos.
                $this->dbh->exec('set names utf8');
            }catch (PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        //Preparamos la consulta
        public function query($sql){
            $this->stmt = $this->dbh->prepare($sql);
        }

        //Vinculamos parámttros de la consulta
        public function bind($parametro, $valor, $tipo = null){
            if (is_null($tipo)){
                switch (true){
                    case is_int($valor):
                        $tipo = PDO::PARAM_INT;
                        break;
                    case is_bool($valor):
                        $tipo = PDO::PARAM_BOOL;
                        break;
                    case is_null($valor):
                        $tipo = PDO::PARAM_NULL;
                        break;
                    default:
                        $tipo = PDO::PARAM_STR;
                        break;                          
                }
            }
            $this->stmt->bindValue($parametro, $valor, $tipo);
        }

        //Ejecutamos la consulta
        public function execute(){
            return $this->stmt->execute();
        }

        //Obtenemos registros
        public function registros(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        //Obtenemos registro
        public function registro(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }
        //Obtenemos cantidad de filas con rowCount
        public function rowCount(){
            return $this->stmt->rowCount();
}

        
    }
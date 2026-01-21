<?php
namespace Acme\IntranetRestaurante\Model;

use Ol\Tools\Conexion;
use PDO;

class Restaurante { 
    private $CodRes;
    private $Correo;
    private $Clave;
    
    public function getCodRes() { return $this->CodRes; }
    public function getCorreo() { return $this->Correo; }

    public static function login($correo, $clave) {
        $pdo = Conexion::getConexion();
        $stmt = $pdo->prepare("SELECT * FROM restaurante WHERE Correo = :correo");
        $stmt->execute([':correo' => $correo]);
        $obj = $stmt->fetchObject(self::class); 

        if ($obj && $obj->Clave === $clave) { 
            return $obj;
        }
        return null;
    }
}
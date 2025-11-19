<?php
require_once '../tools/Conexion.php';
require_once '../src/AccionesDB.php';
class GestorLectura implements AccionesBD
{

    private PDO $conexion;


    public function __construct()
    {
        $conexion = new Conexion();
        $this->conexion = $conexion->getPDO();
    }

    public function insertar(array $datos): bool
    {
        try {
            $sql = "INSERT INTO lectura (titulo, autor, paginas, terminado, fechaLectura) 
                    VALUES (:titulo, :autor, :paginas, :terminado, :fechaLectura)";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([
                ':titulo' => $datos['titulo'],
                ':autor' => $datos['autor'],
                ':paginas' => $datos['paginas'],
                ':terminado' => $datos['terminado'],
                ':fechaLectura' => $datos['fechaLectura']
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al insertar: " . $e->getMessage());
        }
    }

    public function eliminar(int $id): bool
    {
        try {
            $sql = "DELETE FROM lectura WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar: " . $e->getMessage());
        }
    }

    public function actualizar(int $id, array $datos): bool
    {
        try {
            $sql = "UPDATE lectura SET 
                        titulo = :titulo, 
                        autor = :autor, 
                        paginas = :paginas, 
                        terminado = :terminado, 
                        fechaLectura = :fechaLectura
                    WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $datos['id'] = $id; // Agregamos el ID al array
            return $stmt->execute([
                ':titulo' => $datos['titulo'],
                ':autor' => $datos['autor'],
                ':paginas' => $datos['paginas'],
                ':terminado' => $datos['terminado'],
                ':fechaLectura' => $datos['fechaLectura'],
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar: " . $e->getMessage());
        }
    }

    public function listar(): array
    {
        try {
            $sql = "SELECT * FROM lectura";
            $stmt = $this->conexion->query($sql);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new Exception("Error al listar: " . $e->getMessage());
        }
    }
}
?>
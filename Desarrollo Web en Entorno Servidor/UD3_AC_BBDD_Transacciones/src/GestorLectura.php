<?php
require_once __DIR__ . '/../tools/Conexion.php';
require_once __DIR__ . '/AccionesDB.php';

class GestorLectura implements AccionesBD
{
    private PDO $c;

    public function __construct()
    {
        // conectamos a la db
        $con = new Conexion();
        $this->c = $con->obtenerConexion();
    }

    // meter
    public function insertar(array $d): bool
    {
        try {
            $sql = "INSERT INTO lectura 
                        (titulo_libro, autor, paginas, terminado, fecha_lectura, comentario) 
                    VALUES (:t, :a, :p, :term, :f, :c)";
            $s = $this->c->prepare($sql);
            return $s->execute([
                ':t' => $d['titulo_libro'],
                ':a' => $d['autor'],
                ':p' => $d['paginas'],
                ':term' => $d['terminado'],
                ':f' => $d['fecha_lectura'],
                ':c' => $d['comentario']
            ]);
        } catch (PDOException $e) {
            throw new Exception("error insertar: " . $e->getMessage());
        }
    }

    // borrar
    public function eliminar(int $id): bool
    {
        try {
            $sql = "DELETE FROM lectura WHERE id = :id";
            $s = $this->c->prepare($sql);
            return $s->execute([':id' => $id]);
        } catch (PDOException $e) {
            throw new Exception("error eliminar: " . $e->getMessage());
        }
    }

    // actualizar
    public function actualizar(int $id, array $d): bool
    {
        try {
            $sql = "UPDATE lectura SET 
                        titulo_libro = :t, 
                        autor = :a, 
                        paginas = :p, 
                        terminado = :term, 
                        fecha_lectura = :f,
                        comentario = :c
                    WHERE id = :id";
            $s = $this->c->prepare($sql);
            return $s->execute([
                ':t' => $d['titulo_libro'],
                ':a' => $d['autor'],
                ':p' => $d['paginas'],
                ':term' => $d['terminado'],
                ':f' => $d['fecha_lectura'],
                ':c' => $d['comentario'],
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            throw new Exception("error actualizar: " . $e->getMessage());
        }
    }

    // devuelve todo
    public function listar(): array
    {
        try {
            $sql = "SELECT * FROM lectura";
            $s = $this->c->query($sql);
            return $s->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new Exception("error listar: " . $e->getMessage());
        }
    }

    //llamar metodo  transaccion
    public function insertarVarios(array $r): bool
    {
        return $this->insertarBloque($r);
    }

    // insercion transaccion
    private function insertarBloque(array $r): bool
    {
        try {
            $this->c->beginTransaction();
            $sql = "INSERT INTO lectura 
                        (titulo_libro, autor, paginas, terminado, fecha_lectura, comentario)
                    VALUES (:t, :a, :p, :term, :f, :c)";
            $s = $this->c->prepare($sql);

            foreach ($r as $v) {
                $s->execute([
                    ':t' => $v['titulo_libro'],
                    ':a' => $v['autor'],
                    ':p' => $v['paginas'],
                    ':term' => $v['terminado'],
                    ':f' => $v['fecha_lectura'],
                    ':c' => $v['comentario']
                ]);
            }

            $this->c->commit();
            return true;
        } catch (PDOException $e) {
            $this->c->rollback();
            throw new Exception("error: " . $e->getMessage());
        }
    }
}
?>

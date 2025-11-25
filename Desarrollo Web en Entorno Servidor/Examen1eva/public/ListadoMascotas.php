<?php
require_once __DIR__ . '/../tools/conexion.php';

if (isset($_GET['delete'])) {
    $idEliminar = (int)$_GET['delete'];

    try {
        $stmtDel = $pdo->prepare('DELETE FROM mascotas WHERE id = :id');
        $stmtDel->execute([':id' => $idEliminar]);

        header('Location: ListadoMascotas.php');
        exit;
    } catch (PDOException $e) {
        $error = 'Error al eliminar la mascota: ' . htmlspecialchars($e->getMessage());
    }
}

try {
    $stmt = $pdo->prepare('SELECT * FROM mascotas');
    $stmt->execute();

    $animales = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $obj = new stdClass();
        $obj->foto        = $row['foto'] ?? 'img/default.jpg';
        $obj->nombre      = $row['nombre'] ?? '';
        $obj->tipo        = $row['tipo'] ?? '';
        $obj->responsable = $row['id_persona'] ?? '';
        $obj->fecha_nac   = $row['fecha_nacimiento'] ?? '';
        $obj->id          = $row['id'];

        $animales[] = $obj;
    }
} catch (PDOException $e) {
    $error = 'Error: ' . htmlspecialchars($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Listado Mascotas</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<style>
  .container{max-width:900px;margin:auto;padding:20px;}
  .card{
    border:1px solid #ccc; padding:15px; margin-bottom:15px;
    display:flex; justify-content:space-between; align-items:center;
  }
  .card img{
    max-width:120px; max-height:120px; object-fit:cover; border-radius:5px;
  }
</style>
</head>
<body>

<div class="container">
<h1 class="mb-4">Listado de Mascotas</h1>

<?php if (isset($error)): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php foreach ($animales as $animal): ?>
  <div class="card">
    
    <div style="display:flex; align-items:center;">
      <img src="<?= htmlspecialchars($animal->foto) ?>"
           alt="Foto de <?= htmlspecialchars($animal->nombre) ?>">

      <div style="margin-left:15px;">
        <strong>Responsable:</strong> <?= htmlspecialchars($animal->responsable) ?><br>
        <strong>Nombre:</strong> <?= htmlspecialchars($animal->nombre) ?><br>
        <strong>Tipo:</strong> <?= htmlspecialchars($animal->tipo) ?><br>
        <strong>Fecha de Nacimiento:</strong> <?= htmlspecialchars($animal->fecha_nac) ?>
      </div>
    </div>

    <div class="d-flex flex-column gap-2">

      <a href="EditarFotoMascota.php?id=<?= $animal->id ?>" 
         class="btn btn-primary btn-sm">
        Cambiar Foto
      </a>

      <a href="?delete=<?= $animal->id ?>" 
         class="btn btn-danger btn-sm"
         onclick="return confirm('¿Seguro que deseas eliminar esta mascota?');">
        Eliminar
      </a>

    </div>

  </div>
<?php endforeach; ?>

<div class="text-center mt-4">
  <a href="./RegistroMascota.php" class="btn btn-success">Registrar Mascota</a>
  <a href="./logout" class="btn btn-secondary">Cerrar Sesión</a>
</div>

</div>

</body>
</html>

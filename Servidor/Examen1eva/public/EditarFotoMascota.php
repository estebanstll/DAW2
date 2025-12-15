<?php
session_start();                     
    require_once "../tools/conexion.php";


if (!isset($_SESSION['id_mascota'])) {
    header('Location: ListadoMascotas.php');
    exit;
}
$idMascota = $_SESSION['id_mascota'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_FILES['nueva_foto'])
        && $_FILES['nueva_foto']['error'] === UPLOAD_ERR_OK
    ) {

        $tmpFile = $_FILES['nueva_foto']['tmp_name'];
        $originalName = basename($_FILES['nueva_foto']['name']);

        $newFileName = uniqid('foto_', true) . pathinfo($originalName, PATHINFO_EXTENSION);
        $destPath   = __DIR__ . '/img/' . $newFileName;     

        if (move_uploaded_file($tmpFile, $destPath)) {

            $sql = "UPDATE mascotas SET foto_url = :url WHERE id_mascota = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':url' => 'img/' . $newFileName,   
                ':id'  => $idMascota,
            ]);

            header('Location: ListadoMascotas.php');
            exit;
        } else {
            $errorMsg = "Error al mover.";
        }
    } else {
        $errorMsg = "no valido.";
    }
}


$sql   = "SELECT nombre, tipo, fecha_nacimiento FROM mascotas WHERE id_mascota = :id";
$stmt  = $pdo->prepare($sql);
$stmt->execute([':id' => $idMascota]);
$mascota = $stmt->fetch();

if (!$mascota) {
    header('Location: ListadoMascotas.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Cambiar Foto Mascota</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
  .form-wrapper{max-width:700px;margin:20px auto;}
</style>
</head>
<body>

<div class="container form-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
            <div class="card p-4">

                <h2 class="mb-3">Cambiar Foto</h2>

                <?php if (isset($errorMsg)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
                <?php endif; ?>

                <p><strong>Nombre:</strong> <?= htmlspecialchars($mascota['nombre']) ?></p>
                <p><strong>Tipo:</strong> <?= htmlspecialchars($mascota['tipo']) ?></p>
                <p><strong>Fecha de Nacimiento:</strong> <?= htmlspecialchars($mascota['fecha_nacimiento']) ?></p>

                <img src="img/<?= $mascota['foto_url'] ?? 'default.jpg' ?>" alt="Foto de <?= htmlspecialchars($mascota['nombre']) ?>"
                     class="img-fluid mb-3" style="max-width:200px;">

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nueva_foto" class="form-label">Seleccione nueva foto:</label>
                        <input type="file" name="nueva_foto" id="nueva_foto" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Cambiar Foto
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>

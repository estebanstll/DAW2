<?php
require_once '../src/GestorLectura.php';

try {
	// Crear el gestor
	$gestor = new GestorLectura();

	// Llamar al método listar()
	$lecturas = $gestor->listar();

} catch (Exception $e) {
	$error = $e->getMessage();
}
?>

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Visualización de datos</title>
</head>

<body>
	<h1 style="text-align:center;">Lista de Lecturas</h1>

	<?php if (isset($error)): ?>
		<p style="color:red; text-align:center;"><?php echo $error; ?></p>
	<?php else: ?>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Título</th>
					<th>Autor</th>
					<th>Páginas</th>
					<th>Terminado</th>
					<th>Fecha Lectura</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($lecturas as $lectura): ?>
					<tr>
						<td><?php echo htmlspecialchars($lectura->id); ?></td>
						<td><?php echo htmlspecialchars($lectura->titulo_libro); ?></td>
						<td><?php echo htmlspecialchars($lectura->autor); ?></td>
						<td><?php echo htmlspecialchars($lectura->paginas); ?></td>
						<td><?php echo $lectura->terminado ? 'Sí' : 'No'; ?></td>
						<td><?php echo htmlspecialchars($lectura->fecha_lectura ?? ''); ?></td>
					</tr>
				<?php endforeach; ?>

			</tbody>
		</table>
	<?php endif; ?>
</body>

</html>
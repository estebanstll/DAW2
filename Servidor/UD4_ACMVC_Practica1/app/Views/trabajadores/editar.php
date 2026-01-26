<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Editar Trabajador</title>
</head>
<body>

<h1>Editar Trabajador</h1>

<form action="<?php echo BASE_URL; ?>trabajadores/actualizar/<?php echo $usuario->getId(); ?>" method="post">
	<label for="nombre">Nombre:</label>
	<input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario->getNombre()); ?>" required><br><br>

	<label for="gmail">Gmail:</label>
	<input type="email" id="gmail" name="gmail" value="<?php echo htmlspecialchars($usuario->getGmail()); ?>" required><br><br>

	<label for="contraseña">Contraseña:</label>
	<input type="password" id="contraseña" name="contraseña" value="<?php echo htmlspecialchars($usuario->getContraseña()); ?>" required><br><br>

	<label for="especialidad">Especialidad:</label>
	<input type="text" id="especialidad" name="especialidad" value="<?php echo htmlspecialchars($usuario->getEspecialidad()); ?>"><br><br>

	<input type="submit" value="Guardar Cambios">
</form>

<p><a href="<?php echo BASE_URL; ?>trabajadores">Volver al listado</a></p>

</body>
</html>

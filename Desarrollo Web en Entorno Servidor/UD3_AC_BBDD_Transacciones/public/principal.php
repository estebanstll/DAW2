<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Página principal de aplicación</title>
</head>
<body>
	<h1> Página principal de la palicación </h1>
	<p>Debes controlar que el usuario esté autenticado en todo momento, para ello usa las sessiones</p>
	<hr>
		<table style="width: 90%; margin: 20px auto; border-collapse: collapse;">
	    <tr style="background-color: #f3f3f3;">
	        <th style="padding: 10px; border: 1px solid #ccc;">ID</th>
	        <th style="padding: 10px; border: 1px solid #ccc;">Nombre</th>
	        <th style="padding: 10px; border: 1px solid #ccc;">Tipo</th>
	        <th style="padding: 10px; border: 1px solid #ccc;">Nivel</th>
	        <th style="padding: 10px; border: 1px solid #ccc;">Fecha de Alta</th>
	        <th style="padding: 10px; border: 1px solid #ccc;">Acciones</th>
	    </tr>

	    <!-- Ejemplo de una fila. En tu práctica el alumno iterará desde PHP -->
	    <tr>
	        <td style="padding: 10px; border: 1px solid #ccc;">1</td>
	        <td style="padding: 10px; border: 1px solid #ccc;">Lectura</td>
	        <td style="padding: 10px; border: 1px solid #ccc;">Cultural</td>
	        <td style="padding: 10px; border: 1px solid #ccc;">Avanzado</td>
	        <td style="padding: 10px; border: 1px solid #ccc;">2025-02-01</td>

	        <td style="padding: 10px; border: 1px solid #ccc; text-align: center;">

	            <!-- Botón VER -->
	            <a href="ver.php?id=1"
	               style="background-color: #17a2b8; color: white; padding: 6px 12px; 
	                      border-radius: 4px; text-decoration: none; margin-right: 5px;">
	                Ver
	            </a>

	            <!-- Botón EDITAR -->
	            <a href="editar.php?id=1"
	               style="background-color: #28a745; color: white; padding: 6px 12px;
	                      border-radius: 4px; text-decoration: none; margin-right: 5px;">
	                Editar
	            </a>

	            <!-- Botón BORRAR -->
	            <a href="borrar.php?id=1"
	               style="background-color: #dc3545; color: white; padding: 6px 12px;
	                      border-radius: 4px; text-decoration: none;"
	               onclick="return confirm('¿Seguro que quieres borrar este hobby?');">
	                Borrar
	            </a>
	        </td>
	    </tr>
		</table>

	<p> En esta página puedes mostrar los datos de tus scripts de visualización</p>
	<hr>
	<p> En este página puedes llamar a tus transacciones</p>
	<button style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px;">
    Transacción A: invocar con registros válidos
	</button>
	<button style="background-color: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 5px;">
    Transacción B: invocar con registros erróneos
	</button>

</body>
</html>
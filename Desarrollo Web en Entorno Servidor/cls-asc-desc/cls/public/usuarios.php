<?php
	session_start();

	// esta parte de autenticación la podemos pasar a un archivo en tools: auth.php
	if (!isset($_SESSION['usuario'])){
		header("Location: index.php");
		exit; 
	}

	// Requerimientos que necesitamos para recuperar datos
	require_once __DIR__.'/../src/Usuario.php';
	require_once __DIR__.'/../tools/Conexion.php';
	require_once __DIR__.'/../tools/HtmlHelpers.php';


	// recuperar usuarios de la bbdd que tengamos configurada
	$pdo = Conexion::getConexion(); // es sigleton
	$usuarios = Usuario::lista($pdo); // así lo hacemos independiente de la bbdd.

	
	// Capturamos parámetros de ordenación
	$orden = $_GET['orden'] ?? '';
	$dir   = $_GET['dir']   ?? '';

	// Ordenación por NOMBRE
	if ($orden === 'nombre') {
	    $columna = array_column($usuarios, 'nombre');

	    if ($dir === 'asc') {
	        array_multisort($columna, SORT_ASC, $usuarios);
	    } else {
	        array_multisort($columna, SORT_DESC, $usuarios);
	    }
	}

	// Ordenación por EDAD
	if ($orden === 'edad') {
	    $columna = array_column($usuarios, 'edad');

	    if ($dir === 'asc') {
	        array_multisort($columna, SORT_ASC, $usuarios);
	    } else {
	        array_multisort($columna, SORT_DESC, $usuarios);
	    }
	}

?>

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

		<!-- Listo en html los usuarios de la bbdd -->
		<?= HtmlHelpers::tablaUsuarios($usuarios); ?>
	<hr>



</body>
</html>
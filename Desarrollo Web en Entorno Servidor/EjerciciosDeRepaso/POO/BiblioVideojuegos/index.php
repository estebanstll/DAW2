<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestión de Videojuegos</title>
  </head>
  <body>
    <h1>Gestión de Biblioteca de Videojuegos</h1>

    <?php
    // Incluimos las clases necesarias
    require_once 'videojuego.php';  // Suponiendo que Videojuego está en un archivo separado
    require_once 'biblioteca.php';  // Suponiendo que Biblioteca está en otro archivo
    require_once 'jugador.php';     // Suponiendo que Jugador está en otro archivo

    // Crear un jugador (puedes cambiar el nombre)
    $jugador = new Jugador("Alex");

    // Crear algunos videojuegos
    $juego1 = new Videojuego("Elden Ring", "RPG", "PC", 9.5);
    $juego2 = new Videojuego("FIFA 22", "Deportes", "PS5", 8.0);
    $juego3 = new Videojuego("Minecraft", "Aventura", "PC", 9.0);
    $juego4 = new Videojuego("God of War", "RPG", "PS5", 9.2);

    // Añadir los videojuegos a la biblioteca del jugador
    $jugador->añadirJuego($juego1); $jugador->añadirJuego($juego2);
    $jugador->añadirJuego($juego3); $jugador->añadirJuego($juego4); // Mostrar
     ?>

    <h2>Agregar un nuevo videojuego</h2>
    <form action="" method="POST">
      <label for="nombre">Título del videojuego:</label><br />
      <input type="text" id="nombre" name="nombre" required /><br /><br />

      <label for="genero">Género:</label><br />
      <input type="text" id="genero" name="genero" required /><br /><br />

      <label for="plataforma">Plataforma:</label><br />
      <input
        type="text"
        id="plataforma"
        name="plataforma"
        required
      /><br /><br />

      <label for="valoracion">Valoración (de 0 a 10):</label><br />
      <input
        type="number"
        id="valoracion"
        name="valoracion"
        step="0.1"
        min="0"
        max="10"
        required
      /><br /><br />

      <input type="submit" value="Agregar Juego" />
    </form>

    <?php
    // Si se recibe el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $genero = $_POST['genero'];
        $plataforma = $_POST['plataforma'];
        $valoracion = $_POST['valoracion'];

        // Crear un nuevo videojuego con los datos del formulario
        $nuevoJuego = new Videojuego($nombre, $genero, $plataforma, $valoracion);

        // Añadir el juego a la biblioteca del jugador
        $jugador->añadirJuego($nuevoJuego); // Mostrar el nuevo juego agregado y
     echo "<br /><strong>Juego agregado: </strong>" .
    $nombre; $jugador->mostrarMisJuegos(); } ?>
  </body>
</html>

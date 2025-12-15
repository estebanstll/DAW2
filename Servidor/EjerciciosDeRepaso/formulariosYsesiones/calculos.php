<?php
session_start();





?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
  </head>
  <body>
    <form action="resolucion.php" method="post">
      <input type="text" name="uno" />

            <select name="op">
			    <option value="+">Suma (+)</option>
                <option value="-">Resta (-)</option>
                <option value="*">Multiplicación (*)</option>
                <option value="/">División (/)</option>

			</select>
      <input type="text" name="dos" />
      <button type="submit">Enviar</button>
    </form>
        <?php 
            if(isset($_SESSION['resultado'])){

                echo "el resultado es: ". $_SESSION['resultado'];
            }
        ?>
  </body>
</html>